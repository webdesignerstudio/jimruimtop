<?php
/**
 * Jim Ruimt Op — Mailer helper
 * Verstuurt e-mails via SMTP (PHPMailer) met instellingen uit instellingen.json
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/PHPMailer/Exception.php';
require_once __DIR__ . '/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/SMTP.php';

/**
 * Stuur een formuliermelding naar Jim + optionele bevestiging naar klant.
 *
 * @param array  $instellingen  Instellingen-array uit instellingen.json
 * @param array  $velden        Associatieve array met formuliervelden
 * @param string $klant_email   E-mailadres van de klant (leeg = geen bevestiging)
 * @param string $klant_naam    Naam van de klant
 * @return array ['ok' => bool, 'fout' => string]
 */
function verstuur_formulier(array $instellingen, array $velden, string $klant_email = '', string $klant_naam = ''): array
{
    $smtp_host     = trim($instellingen['smtp_host']     ?? 'smtp.transip.email');
    $smtp_port     = (int)($instellingen['smtp_port']    ?? 465);
    $smtp_user     = trim($instellingen['smtp_gebruiker'] ?? '');
    $smtp_pass     = trim($instellingen['smtp_wachtwoord'] ?? '');
    $ontvanger     = trim($instellingen['mail_ontvanger'] ?? 'info@jimruimt-op.nl');
    $onderwerp_jim = trim($instellingen['mail_notificatie_onderwerp'] ?? 'Nieuw contactformulier — Jim Ruimt Op');

    if ($smtp_user === '' || $smtp_pass === '') {
        return ['ok' => false, 'fout' => 'SMTP-instellingen zijn nog niet geconfigureerd in het beheer.'];
    }

    // Bouw de HTML-body voor Jim
    $body_jim = '<html><body style="font-family:Arial,sans-serif;font-size:15px;color:#222;">';
    $body_jim .= '<h2 style="color:#1A436D;">Nieuw bericht via het contactformulier</h2>';
    $body_jim .= '<table style="border-collapse:collapse;width:100%;">';
    foreach ($velden as $label => $waarde) {
        $body_jim .= '<tr><td style="padding:8px 12px;background:#f4f0e6;font-weight:bold;width:160px;">' . htmlspecialchars($label) . '</td>';
        $body_jim .= '<td style="padding:8px 12px;border-bottom:1px solid #eee;">' . nl2br(htmlspecialchars((string)$waarde)) . '</td></tr>';
    }
    $body_jim .= '</table>';
    $body_jim .= '<p style="color:#888;font-size:12px;margin-top:24px;">Verzonden via jimruimt-op.nl</p>';
    $body_jim .= '</body></html>';

    try {
        $mail = nieuwe_mailer($smtp_host, $smtp_port, $smtp_user, $smtp_pass);
        $mail->setFrom($smtp_user, 'Jim Ruimt Op Website');
        $mail->addAddress($ontvanger, 'Jim Ruimt Op');
        if ($klant_email !== '') {
            $mail->addReplyTo($klant_email, $klant_naam ?: $klant_email);
        }
        $mail->Subject = $onderwerp_jim;
        $mail->Body    = $body_jim;
        $mail->AltBody = strip_tags(str_replace(['<td', '</tr>'], ["\n", ''], $body_jim));
        $mail->send();
    } catch (Exception $e) {
        return ['ok' => false, 'fout' => 'Verzenden mislukt: ' . $e->getMessage()];
    }

    // Bevestigingsmail naar klant
    if ($klant_email !== '' && filter_var($klant_email, FILTER_VALIDATE_EMAIL)) {
        $bevestiging_onderwerp = trim($instellingen['mail_bevestiging_onderwerp'] ?? 'Bedankt voor uw bericht — Jim Ruimt Op');
        $bevestiging_tekst     = trim($instellingen['mail_bevestiging_tekst']     ?? "Beste {naam},\n\nBedankt voor uw bericht! Jim neemt zo snel mogelijk contact met u op, uiterlijk binnen 48 uur.\n\nMet vriendelijke groet,\nJim Ruimt Op\nTilburg | info@jimruimt-op.nl");

        $bevestiging_tekst = str_replace('{naam}', htmlspecialchars($klant_naam ?: 'bezoeker'), $bevestiging_tekst);

        $body_klant  = '<html><body style="font-family:Arial,sans-serif;font-size:15px;color:#222;">';
        $body_klant .= '<div style="max-width:520px;margin:0 auto;">';
        $body_klant .= '<div style="background:#1A436D;padding:24px 32px;border-radius:8px 8px 0 0;">';
        $body_klant .= '<h1 style="color:#fff;font-size:22px;margin:0;">Jim Ruimt Op</h1>';
        $body_klant .= '</div>';
        $body_klant .= '<div style="background:#fff;padding:32px;border:1px solid #eee;border-radius:0 0 8px 8px;">';
        $body_klant .= '<p>' . nl2br(htmlspecialchars($bevestiging_tekst)) . '</p>';
        $body_klant .= '</div></div></body></html>';

        try {
            $mail2 = nieuwe_mailer($smtp_host, $smtp_port, $smtp_user, $smtp_pass);
            $mail2->setFrom($smtp_user, 'Jim Ruimt Op');
            $mail2->addAddress($klant_email, $klant_naam ?: $klant_email);
            $mail2->Subject = $bevestiging_onderwerp;
            $mail2->Body    = $body_klant;
            $mail2->AltBody = $bevestiging_tekst;
            $mail2->send();
        } catch (Exception $e) {
            // Bevestiging mislukt is niet fataal — hoofdmail is al verzonden
        }
    }

    return ['ok' => true, 'fout' => ''];
}

/**
 * Stuur een testmail (vanuit het beheer).
 */
function verstuur_testmail(array $instellingen): array
{
    $smtp_host = trim($instellingen['smtp_host']      ?? 'smtp.transip.email');
    $smtp_port = (int)($instellingen['smtp_port']     ?? 465);
    $smtp_user = trim($instellingen['smtp_gebruiker'] ?? '');
    $smtp_pass = trim($instellingen['smtp_wachtwoord'] ?? '');
    $ontvanger = trim($instellingen['mail_ontvanger'] ?? $smtp_user);

    if ($smtp_user === '' || $smtp_pass === '') {
        return ['ok' => false, 'fout' => 'Vul eerst de SMTP-gegevens in en sla op.'];
    }

    try {
        $mail = nieuwe_mailer($smtp_host, $smtp_port, $smtp_user, $smtp_pass);
        $mail->setFrom($smtp_user, 'Jim Ruimt Op');
        $mail->addAddress($ontvanger);
        $mail->Subject = 'Testmail — Jim Ruimt Op website';
        $mail->Body    = '<html><body><p>✅ De SMTP-verbinding werkt correct! Formulieren worden verstuurd naar <strong>' . htmlspecialchars($ontvanger) . '</strong>.</p></body></html>';
        $mail->AltBody = 'De SMTP-verbinding werkt correct!';
        $mail->send();
        return ['ok' => true, 'fout' => ''];
    } catch (Exception $e) {
        return ['ok' => false, 'fout' => $e->getMessage()];
    }
}

/**
 * Maak een geconfigureerde PHPMailer instantie.
 */
function nieuwe_mailer(string $host, int $port, string $user, string $pass): PHPMailer
{
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = $host;
    $mail->SMTPAuth   = true;
    $mail->Username   = $user;
    $mail->Password   = $pass;
    $mail->SMTPSecure = ($port === 465) ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = $port;
    $mail->CharSet    = 'UTF-8';
    $mail->isHTML(true);
    $mail->Timeout    = 10;
    return $mail;
}
