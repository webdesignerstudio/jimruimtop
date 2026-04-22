<?php
/**
 * Jim Ruimt Op — Gedeelde helper functies
 */

define('CONTENT_DIR', __DIR__ . '/../content/');
define('UPLOADS_DIR', __DIR__ . '/../uploads/gallerij/');
define('UPLOADS_URL', 'uploads/gallerij/');

/**
 * Laad een JSON content-bestand veilig.
 * Geeft altijd een array terug, ook als het bestand ontbreekt of corrupt is.
 */
function laad_json(string $bestand): array {
    $pad = CONTENT_DIR . $bestand;
    if (!file_exists($pad)) {
        return [];
    }
    $inhoud = file_get_contents($pad);
    if ($inhoud === false) {
        return [];
    }
    $data = json_decode($inhoud, true);
    return is_array($data) ? $data : [];
}

/**
 * Sla JSON atomisch op: schrijf naar tijdelijk bestand, maak backup, hernoem.
 */
function sla_json_op(string $bestand, mixed $data): bool {
    $pad = CONTENT_DIR . $bestand;
    $tijdelijk = $pad . '.tmp';
    $backup = $pad . '.bak';

    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json === false) {
        return false;
    }

    if (file_put_contents($tijdelijk, $json, LOCK_EX) === false) {
        return false;
    }

    // Maak backup van huidige versie
    if (file_exists($pad)) {
        copy($pad, $backup);
    }

    // Atomische vervanging
    return rename($tijdelijk, $pad);
}

/**
 * Haal een waarde op uit een geneste array met een fallback.
 */
function t(array $arr, string $sleutel, string $fallback = ''): string {
    return isset($arr[$sleutel]) ? htmlspecialchars((string)$arr[$sleutel], ENT_QUOTES, 'UTF-8') : htmlspecialchars($fallback, ENT_QUOTES, 'UTF-8');
}

/**
 * Haal een waarde op zonder HTML-escaping (voor velden die HTML bevatten).
 */
function t_html(array $arr, string $sleutel, string $fallback = ''): string {
    return isset($arr[$sleutel]) ? (string)$arr[$sleutel] : $fallback;
}

/**
 * Geeft de juiste URL terug voor een afbeelding (uploads of root).
 */
function afbeelding_url(string $bestandsnaam): string {
    // Check of het een uploaded afbeelding is
    if (file_exists(UPLOADS_DIR . $bestandsnaam)) {
        return UPLOADS_URL . htmlspecialchars($bestandsnaam, ENT_QUOTES, 'UTF-8');
    }
    // Anders root-map (originele afbeeldingen)
    return htmlspecialchars($bestandsnaam, ENT_QUOTES, 'UTF-8');
}

/**
 * Genereer WhatsApp URL
 */
function whatsapp_url(array $contact): string {
    $nummer = $contact['whatsapp_nummer'] ?? '31612345678';
    $bericht = $contact['whatsapp_bericht'] ?? 'Hallo%20Jim%2C%20ik%20heb%20een%20vraag%20over%20woningontruiming';
    return 'https://wa.me/' . htmlspecialchars($nummer, ENT_QUOTES, 'UTF-8') . '?text=' . $bericht;
}

/**
 * Genereer tel: link
 */
function tel_link(array $contact): string {
    return 'tel:' . htmlspecialchars($contact['telefoon_link'] ?? '+31612345678', ENT_QUOTES, 'UTF-8');
}
