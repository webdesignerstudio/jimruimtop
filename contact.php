<?php
require_once __DIR__ . '/includes/functions.php';
$contact      = laad_json('contact.json');
$teksten      = laad_json('teksten.json');
$instellingen = laad_json('instellingen.json');
$toon_fotos   = $instellingen['toon_fotos_menu'] ?? true;
$p            = $teksten['contact'] ?? [];

$form_success = false;
$form_error   = '';
$form_data    = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $naam      = trim(strip_tags($_POST['name']    ?? ''));
    $van_email = trim(strip_tags($_POST['email']   ?? ''));
    $telefoon_i= trim(strip_tags($_POST['phone']   ?? ''));
    $onderwerp = trim(strip_tags($_POST['subject'] ?? ''));
    $bericht   = trim(strip_tags($_POST['message'] ?? ''));
    $honeypot  = $_POST['website'] ?? '';

    $form_data = ['name'=>$naam,'email'=>$van_email,'phone'=>$telefoon_i,'subject'=>$onderwerp,'message'=>$bericht];

    if (!empty($honeypot)) {
        $form_success = true;
    } elseif (empty($naam) || empty($van_email) || empty($bericht)) {
        $form_error = 'Vul alle verplichte velden in.';
    } elseif (!filter_var($van_email, FILTER_VALIDATE_EMAIL)) {
        $form_error = 'Vul een geldig e-mailadres in.';
    } else {
        $naar        = 'info@jimruimt-op.nl';
        $onderwerp_labels = [
            'intake'   => 'Gratis intake inplannen',
            'core'     => 'Pakket CORE — Complete woningontruiming',
            'premium'  => 'Pakket PREMIUM — Zorgeloos Afscheid Begeleiding',
            'senior'   => 'Pakket SENIOR — Rust Vooraf Pakket',
            'garage'   => 'Garage- of zolderontruiming',
            'spoed'    => 'Spoedontruiming',
            'maatwerk' => 'Maatwerk / andere situatie',
            'vraag'    => 'Algemene vraag',
        ];
        $onderwerp_label = $onderwerp_labels[$onderwerp] ?? $onderwerp;
        $mail_onderwerp  = '=?UTF-8?B?' . base64_encode('Nieuw bericht via website — ' . $onderwerp_label) . '?=';

        $mail_body  = "Nieuw contactverzoek via jimruimtop.nl\n";
        $mail_body .= str_repeat('=', 50) . "\n\n";
        $mail_body .= "Naam:          {$naam}\n";
        $mail_body .= "E-mail:        {$van_email}\n";
        $mail_body .= "Telefoon:      " . ($telefoon_i ?: '—') . "\n";
        $mail_body .= "Onderwerp:     {$onderwerp_label}\n\n";
        $mail_body .= "Bericht:\n{$bericht}\n\n";
        $mail_body .= str_repeat('=', 50) . "\n";
        $mail_body .= "Verzonden via: jimruimtop.nl/contact.php\n";

        $headers  = "From: no-reply@jimruimtop.nl\r\n";
        $headers .= "Reply-To: {$van_email}\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

        if (mail($naar, $mail_onderwerp, $mail_body, $headers)) {
            $form_success = true;
            $form_data    = [];
        } else {
            $form_error = 'Er is iets misgegaan bij het verzenden. Bel ons gerust direct.';
        }
    }
}

$url_onderwerp = in_array($_GET['onderwerp'] ?? '', ['intake','core','premium','senior','garage','spoed','maatwerk','vraag'], true)
    ? $_GET['onderwerp']
    : '';

$telefoon      = t($contact, 'telefoon', '06 13 94 31 86');
$tel_href      = tel_link($contact);
$wa_url        = whatsapp_url($contact);
$email         = htmlspecialchars($contact['email'] ?? 'info@jimruimt-op.nl', ENT_QUOTES, 'UTF-8');
$adres         = t($contact, 'adres', 'Tilburg');
$werkgebied    = t($contact, 'werkgebied', 'Tilburg & omstreken');
$ma_vr         = t($contact['openingstijden'] ?? [], 'maandag_vrijdag', '08:00 - 18:00');
$zat           = t($contact['openingstijden'] ?? [], 'zaterdag', '09:00 - 14:00');
$zon           = t($contact['openingstijden'] ?? [], 'zondag', 'Gesloten');
$hero_script   = t($p, 'hero_script', 'Laten we kennismaken');
$hero_kop      = t($p, 'hero_kop', 'Een schone lei begint met een goed gesprek.');
$hero_sub      = t($p, 'hero_subtekst', 'Zet vandaag de eerste stap naar rust en overzicht. Mijn kennismaking is altijd vrijblijvend en op uw tempo.');
$jim_quote     = t($p, 'jim_quote', 'Geen ingewikkelde procedures of lange wachtlijsten. Ik sta u graag persoonlijk te woord om te kijken hoe ik weer ruimte kan maken in uw leven.');
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Contact | Jim Ruimt Op — Woningontruiming Tilburg</title>
    <meta name="description" content="Neem contact op met Jim voor een gratis intake. Woningontruiming in Tilburg — binnen 48 uur teruggebeld. Bel, WhatsApp of vul het formulier in."/>
    <meta name="robots" content="index, follow"/>
    <link rel="canonical" href="https://www.jimruimtop.nl/contact.html"/>
    <meta property="og:title" content="Contact | Jim Ruimt Op — Woningontruiming Tilburg"/>
    <meta property="og:description" content="Gratis intake aanvragen bij Jim Ruimt Op. Woningontruiming in Tilburg — binnen 48 uur reactie."/>
    <meta property="og:url" content="https://www.jimruimtop.nl/contact.html"/>
    <meta property="og:type" content="website"/>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [
        {"@type":"Question","name":"Hoe snel kan Jim langskomen?","acceptedAnswer":{"@type":"Answer","text":"Meestal kan Jim binnen 48 uur een eerste vrijblijvende intake inplannen in de regio Tilburg."}},
        {"@type":"Question","name":"Zijn er kosten verbonden aan de intake?","acceptedAnswer":{"@type":"Answer","text":"Nee, het eerste gesprek is volledig gratis en bedoeld om uw wensen en de situatie in kaart te brengen."}},
        {"@type":"Question","name":"Werkt Jim Ruimt Op ook in het weekend?","acceptedAnswer":{"@type":"Answer","text":"Ja, op zaterdagochtend is Jim beschikbaar. Voor spoedgevallen is hij ook buiten kantoortijden bereikbaar."}},
        {"@type":"Question","name":"Wat gebeurt er met waardevolle spullen bij de ontruiming?","acceptedAnswer":{"@type":"Answer","text":"Samen wordt besproken wat u wilt houden, verkopen, doneren of laten verwerken. Bruikbare items kunnen worden verrekend met de ontruimingskosten."}}
      ]
    }
    </script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700;800&family=Inter:wght@400;500;600&family=Dancing+Script:wght@500&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { brandNavy:'#1A436D', brandCyan:'#5BCEFF', brandCream:'#F4F0E6', brandGreen:'#7CC19D' },
                    fontFamily: { headline:['Manrope','sans-serif'], body:['Inter','sans-serif'], script:['Dancing Script','cursive'] }
                }
            }
        }
    </script>
    <style>
        #progress-bar { position:fixed;top:0;left:0;height:3px;background:linear-gradient(90deg,#5BCEFF,#1A436D);z-index:9999;transition:width 0.1s ease; }
        html { scroll-behavior:smooth; }
        .cloud-shadow { box-shadow:0 20px 40px rgba(26,67,109,0.12); }
        .glass-card { background:rgba(255,255,255,0.9);backdrop-filter:blur(20px); }
        .material-symbols-outlined { font-variation-settings:'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 24; }
        .fade-in-up { opacity:0;transform:translateY(30px);transition:opacity 0.6s ease,transform 0.6s ease; }
        .fade-in-up.visible { opacity:1;transform:translateY(0); }
        .fade-in-left { opacity:0;transform:translateX(-30px);transition:opacity 0.6s ease,transform 0.6s ease; }
        .fade-in-left.visible { opacity:1;transform:translateX(0); }
        .fade-in-right { opacity:0;transform:translateX(30px);transition:opacity 0.6s ease,transform 0.6s ease; }
        .fade-in-right.visible { opacity:1;transform:translateX(0); }
        .scale-in { opacity:0;transform:scale(0.9);transition:opacity 0.5s ease,transform 0.5s ease; }
        .scale-in.visible { opacity:1;transform:scale(1); }
        .delay-100{transition-delay:0.1s;} .delay-200{transition-delay:0.2s;} .delay-300{transition-delay:0.3s;} .delay-400{transition-delay:0.4s;}
        .form-input { transition:all 0.3s ease; }
        .form-input:focus { transform:translateY(-2px);box-shadow:0 4px 12px rgba(26,67,109,0.15); }
        .contact-card { transition:all 0.3s ease; }
        .contact-card:hover { transform:translateY(-5px);box-shadow:0 15px 30px rgba(26,67,109,0.15);border-color:#5BCEFF; }
        .faq-item { transition:all 0.3s ease;cursor:pointer; }
        .faq-item:hover { transform:translateX(5px); }
        .faq-answer { max-height:0;overflow:hidden;transition:max-height 0.3s ease,opacity 0.3s ease;opacity:0; }
        .faq-item.active .faq-answer { max-height:200px;opacity:1; }
        .faq-item.active { background-color:rgba(91,206,255,0.1); }
        .pulse-emergency { animation:pulse-emergency 2s ease-in-out infinite; }
        @keyframes pulse-emergency { 0%,100%{box-shadow:0 0 0 0 rgba(91,206,255,0.4);}50%{box-shadow:0 0 0 15px rgba(91,206,255,0);} }
        .submit-btn { transition:all 0.3s ease; }
        .submit-btn:hover { transform:translateY(-2px);box-shadow:0 10px 20px rgba(26,67,109,0.2); }
        .pulse-glow { animation:pulse-glow 2s ease-in-out infinite; }
        @keyframes pulse-glow { 0%,100%{box-shadow:0 0 0 0 rgba(91,206,255,0.4);}50%{box-shadow:0 0 20px 10px rgba(91,206,255,0.2);} }
    </style>
</head>
<body class="bg-white font-body" style="background-color:#f0f7ff">
    <div id="progress-bar" style="width: 0%"></div>

    <a href="<?= $wa_url ?>" target="_blank" rel="noopener" style="position:fixed;bottom:170px;right:30px;z-index:41;background:#25D366;color:white;width:56px;height:56px;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 20px rgba(37,211,102,0.4);transition:transform 0.2s ease;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'" aria-label="WhatsApp Jim Ruimt Op">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
    </a>

    <header class="w-full bg-brandNavy sticky top-0 z-50 shadow-sm">
        <nav class="flex justify-between items-center max-w-7xl mx-auto px-6 py-4">
            <a href="index.php" class="flex items-center gap-2 hover:scale-105 transition-transform">
                <img src="logo.png" alt="Jim Ruimt Op" class="w-14 h-14 object-contain"/>
            </a>
            <div class="hidden md:flex items-center space-x-8">
                <a href="index.php" class="font-headline font-bold text-white/70 hover:text-brandCyan transition-colors">Home</a>
                <a href="diensten.php" class="font-headline font-bold text-white/70 hover:text-brandCyan transition-colors">Diensten</a>
                <?php if ($toon_fotos): ?><a href="fotos.php" class="font-headline font-bold text-white/70 hover:text-brandCyan transition-colors">Foto's</a><?php endif; ?>
                <a href="over-mij.php" class="font-headline font-bold text-white/70 hover:text-brandCyan transition-colors">Over Mij</a>
                <a href="contact.php" class="font-headline font-bold text-white border-b-2 border-brandCyan pb-1">Contact</a>
            </div>
            <div class="hidden md:flex items-center gap-4">
                <a href="<?= $tel_href ?>" class="flex items-center gap-2 text-white font-bold hover:text-brandCyan transition-colors text-sm">
                    <span class="material-symbols-outlined text-lg">call</span>
                    <span><?= $telefoon ?></span>
                </a>
                <a href="contact.php" class="bg-brandCyan text-brandNavy px-6 py-3 rounded-full font-bold hover:opacity-90 transition-all text-sm">Gratis Intake</a>
            </div>
            <button id="mobile-menu-btn" class="md:hidden text-white">
                <span class="material-symbols-outlined text-3xl">menu</span>
            </button>
        </nav>
        <div id="mobile-menu" class="hidden md:hidden bg-brandNavy border-t border-white/20">
            <div class="flex flex-col px-6 py-4 space-y-4">
                <a href="index.php" class="font-headline font-bold text-white/70">Home</a>
                <a href="diensten.php" class="font-headline font-bold text-white/70">Diensten</a>
                <?php if ($toon_fotos): ?><a href="fotos.php" class="font-headline font-bold text-white/70">Foto's</a><?php endif; ?>
                <a href="over-mij.php" class="font-headline font-bold text-white/70">Over Mij</a>
                <a href="contact.php" class="font-headline font-bold text-white">Contact</a>
                <a href="<?= $tel_href ?>" class="flex items-center gap-2 text-white font-bold text-sm">
                    <span class="material-symbols-outlined text-lg">call</span><?= $telefoon ?>
                </a>
                <a href="contact.php" class="bg-brandCyan text-brandNavy px-6 py-3 rounded-full font-bold text-center text-sm">Gratis Intake</a>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        <section class="relative bg-gradient-to-br from-brandNavy to-brandNavy/80 text-white py-24 overflow-hidden">
            <div class="max-w-7xl mx-auto px-6 relative z-10">
                <div class="max-w-2xl fade-in-left">
                    <span class="font-script text-brandCyan text-3xl mb-4 block"><?= $hero_script ?></span>
                    <h1 class="font-headline text-5xl md:text-6xl font-bold leading-tight tracking-tight mb-6"><?= $hero_kop ?></h1>
                    <p class="text-white/80 text-lg md:text-xl font-medium leading-relaxed mb-8"><?= $hero_sub ?></p>
                </div>
            </div>
            <div class="absolute right-0 top-0 w-1/3 h-full opacity-10 pointer-events-none">
                <div class="w-full h-full bg-brandCyan/30 rounded-l-full"></div>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-6 py-20 -mt-16 relative z-20">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                <div class="lg:col-span-7 bg-white p-8 md:p-12 rounded-2xl cloud-shadow relative overflow-hidden fade-in-up">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-brandCyan/10 rounded-bl-full"></div>
                    <h2 class="font-headline text-3xl font-bold text-brandNavy mb-2">Stuur een bericht</h2>
                    <div class="flex items-center gap-2 mb-8">
                        <span class="inline-flex items-center gap-1 bg-brandGreen/10 text-brandGreen text-sm font-bold px-3 py-1 rounded-full">
                            <span class="material-symbols-outlined text-sm">schedule</span>
                            Ik reageer binnen 48 uur
                        </span>
                        <span class="inline-flex items-center gap-1 bg-brandCyan/10 text-brandNavy text-sm font-bold px-3 py-1 rounded-full">
                            <span class="material-symbols-outlined text-sm">lock</span>
                            Gratis &amp; vrijblijvend
                        </span>
                    </div>
                    <?php if ($form_success): ?>
                    <div class="bg-brandGreen/10 border border-brandGreen rounded-2xl p-8 text-center">
                        <span class="material-symbols-outlined text-5xl text-brandGreen mb-4 block">check_circle</span>
                        <h3 class="font-headline text-2xl font-bold text-brandNavy mb-2">Bericht verzonden!</h3>
                        <p class="text-gray-600">Jim neemt zo snel mogelijk contact met u op, uiterlijk binnen 24 uur.</p>
                    </div>
                    <?php else: ?>
                    <?php if ($form_error): ?>
                    <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-4 flex items-center gap-3">
                        <span class="material-symbols-outlined text-red-400">error</span>
                        <p class="text-red-600 text-sm font-medium"><?= htmlspecialchars($form_error) ?></p>
                    </div>
                    <?php endif; ?>
                    <form id="contact-form" class="space-y-6" action="contact.php" method="POST">
                        <div style="display:none">
                            <input type="text" name="website" value="" autocomplete="off" tabindex="-1"/>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="name" class="block font-headline text-sm font-bold text-gray-600">Volledige Naam *</label>
                                <input type="text" id="name" name="name" placeholder="Uw naam" required value="<?= htmlspecialchars($form_data['name'] ?? '', ENT_QUOTES) ?>" class="form-input w-full bg-white border border-gray-200 rounded-xl p-4 focus:ring-2 focus:ring-brandNavy"/>
                            </div>
                            <div class="space-y-2">
                                <label for="email_field" class="block font-headline text-sm font-bold text-gray-600">E-mailadres *</label>
                                <input type="email" id="email_field" name="email" placeholder="uw@email.nl" required value="<?= htmlspecialchars($form_data['email'] ?? '', ENT_QUOTES) ?>" class="form-input w-full bg-white border border-gray-200 rounded-xl p-4 focus:ring-2 focus:ring-brandNavy"/>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label for="phone" class="block font-headline text-sm font-bold text-gray-600">Telefoonnummer</label>
                            <input type="tel" id="phone" name="phone" placeholder="06 1234 5678" value="<?= htmlspecialchars($form_data['phone'] ?? '', ENT_QUOTES) ?>" class="form-input w-full bg-white border border-gray-200 rounded-xl p-4 focus:ring-2 focus:ring-brandNavy"/>
                        </div>
                        <div class="space-y-2">
                            <label for="subject" class="block font-headline text-sm font-bold text-gray-600">Onderwerp</label>
                            <?php $sel = $form_data['subject'] ?? $url_onderwerp; ?>
                            <select id="subject" name="subject" class="form-input w-full bg-white border border-gray-200 rounded-xl p-4 focus:ring-2 focus:ring-brandNavy">
                                <option value="" disabled <?= $sel===''?'selected':'' ?>>Kies een onderwerp...</option>
                                <option value="intake"   <?= $sel==='intake'  ?'selected':'' ?>>Gratis intake inplannen</option>
                                <option value="core"     <?= $sel==='core'    ?'selected':'' ?>>Pakket CORE — Complete woningontruiming</option>
                                <option value="premium"  <?= $sel==='premium' ?'selected':'' ?>>Pakket PREMIUM — Zorgeloos Afscheid Begeleiding</option>
                                <option value="senior"   <?= $sel==='senior'  ?'selected':'' ?>>Pakket SENIOR — Rust Vooraf Pakket</option>
                                <option value="garage"   <?= $sel==='garage'  ?'selected':'' ?>>Garage- of zolderontruiming</option>
                                <option value="spoed"    <?= $sel==='spoed'   ?'selected':'' ?>>Spoedontruiming</option>
                                <option value="maatwerk" <?= $sel==='maatwerk'?'selected':'' ?>>Maatwerk / andere situatie</option>
                                <option value="vraag"    <?= $sel==='vraag'   ?'selected':'' ?>>Algemene vraag</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label for="message" class="block font-headline text-sm font-bold text-gray-600">Bericht *</label>
                            <textarea id="message" name="message" placeholder="Vertel kort waarmee Jim u kan helpen..." rows="5" required class="form-input w-full bg-white border border-gray-200 rounded-xl p-4 focus:ring-2 focus:ring-brandNavy"><?= htmlspecialchars($form_data['message'] ?? '', ENT_QUOTES) ?></textarea>
                        </div>
                        <button type="submit" id="submit-btn" class="submit-btn w-full md:w-auto bg-brandNavy text-white px-12 py-4 rounded-xl font-headline font-bold uppercase tracking-widest text-sm hover:bg-brandCyan hover:text-brandNavy transition-all shadow-lg flex items-center justify-center gap-2">
                            <span>Bericht Verzenden</span>
                            <span class="material-symbols-outlined">send</span>
                        </button>
                    </form>
                    <?php endif; ?>
                </div>

                <div class="lg:col-span-5 space-y-8 fade-in-right delay-200">
                    <div class="bg-white p-8 rounded-2xl relative overflow-hidden cloud-shadow">
                        <span class="material-symbols-outlined text-4xl text-brandNavy mb-4">forum</span>
                        <h3 class="font-headline text-2xl font-bold text-brandNavy mb-4">Direct contact met Jim</h3>
                        <p class="text-gray-600 leading-relaxed mb-6">"<?= $jim_quote ?>"</p>
                        <div class="font-script text-2xl text-brandNavy">- Jim</div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <a href="<?= $tel_href ?>" class="contact-card bg-white p-6 rounded-xl border-b-2 border-transparent hover:border-brandCyan transition-all block cloud-shadow">
                            <span class="material-symbols-outlined text-brandNavy mb-3">call</span>
                            <div class="font-headline text-xs font-bold text-gray-400 uppercase tracking-tighter">Telefoon</div>
                            <div class="text-brandNavy font-bold"><?= $telefoon ?></div>
                        </a>
                        <a href="<?= $wa_url ?>" target="_blank" rel="noopener" class="contact-card bg-white p-6 rounded-xl border-b-2 border-transparent hover:border-brandCyan transition-all block cloud-shadow">
                            <span class="material-symbols-outlined text-brandNavy mb-3" style="color:#25D366">chat</span>
                            <div class="font-headline text-xs font-bold text-gray-400 uppercase tracking-tighter">WhatsApp</div>
                            <div class="text-brandNavy font-bold">Direct sturen</div>
                        </a>
                        <a href="mailto:<?= $email ?>" class="contact-card bg-white p-6 rounded-xl border-b-2 border-transparent hover:border-brandCyan transition-all block cloud-shadow">
                            <span class="material-symbols-outlined text-brandNavy mb-3">mail</span>
                            <div class="font-headline text-xs font-bold text-gray-400 uppercase tracking-tighter">E-mail</div>
                            <div class="text-brandNavy font-bold"><?= $email ?></div>
                        </a>
                        <div class="contact-card bg-white p-6 rounded-xl border-b-2 border-transparent cloud-shadow">
                            <span class="material-symbols-outlined text-brandNavy mb-3">location_on</span>
                            <div class="font-headline text-xs font-bold text-gray-400 uppercase tracking-tighter">Werkgebied</div>
                            <div class="text-brandNavy font-bold"><?= $werkgebied ?></div>
                        </div>
                    </div>

                    <div class="bg-brandNavy text-white p-6 rounded-2xl">
                        <h4 class="font-headline font-bold mb-4 text-brandCyan">Openingstijden</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-white/70">Maandag - Vrijdag</span>
                                <span><?= $ma_vr ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-white/70">Zaterdag</span>
                                <span><?= $zat ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-white/70">Zondag</span>
                                <span><?= $zon ?></span>
                            </div>
                        </div>
                        <p class="text-xs text-white/50 mt-4">* Ook buiten kantoortijden bereikbaar voor spoed</p>
                    </div>

                    <div class="rounded-2xl overflow-hidden cloud-shadow h-64 scale-in delay-400">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d39558.94!2d5.0913!3d51.5555!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c6bfdeab0e6c4b%3A0x7bf46a4756dc9f67!2sTilburg!5e0!3m2!1snl!2snl!4v1" width="100%" height="256" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Werkgebied Jim Ruimt Op — Tilburg en omstreken" aria-label="Google Maps kaart van Tilburg, werkgebied Jim Ruimt Op"></iframe>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-brandNavy/5 py-20 px-6">
            <div class="max-w-3xl mx-auto">
                <h2 class="font-headline text-3xl font-bold text-brandNavy mb-8 text-center fade-in-up">Veelgestelde vragen</h2>
                <div class="space-y-4">
                    <div class="faq-item bg-white p-6 rounded-xl cloud-shadow fade-in-up delay-100" onclick="toggleFaq(this)">
                        <div class="flex justify-between items-center">
                            <h4 class="font-headline font-bold text-brandNavy">Hoe snel kan Jim langskomen?</h4>
                            <span class="material-symbols-outlined text-brandNavy transition-transform">expand_more</span>
                        </div>
                        <div class="faq-answer">
                            <p class="text-gray-600 text-sm mt-3">Meestal kan ik binnen 48 uur een eerste vrijblijvende intake inplannen in de regio Tilburg.</p>
                        </div>
                    </div>
                    <div class="faq-item bg-white p-6 rounded-xl cloud-shadow fade-in-up delay-200" onclick="toggleFaq(this)">
                        <div class="flex justify-between items-center">
                            <h4 class="font-headline font-bold text-brandNavy">Zijn er kosten verbonden aan de intake?</h4>
                            <span class="material-symbols-outlined text-brandNavy transition-transform">expand_more</span>
                        </div>
                        <div class="faq-answer">
                            <p class="text-gray-600 text-sm mt-3">Nee, het eerste gesprek is volledig gratis en bedoeld om uw wensen en de situatie in kaart te brengen.</p>
                        </div>
                    </div>
                    <div class="faq-item bg-white p-6 rounded-xl cloud-shadow fade-in-up delay-300" onclick="toggleFaq(this)">
                        <div class="flex justify-between items-center">
                            <h4 class="font-headline font-bold text-brandNavy">Werkt u ook in het weekend?</h4>
                            <span class="material-symbols-outlined text-brandNavy transition-transform">expand_more</span>
                        </div>
                        <div class="faq-answer">
                            <p class="text-gray-600 text-sm mt-3">Ja, op zaterdagochtend ben ik beschikbaar. Voor spoedgevallen kan ik ook buiten kantoortijden langskomen.</p>
                        </div>
                    </div>
                    <div class="faq-item bg-white p-6 rounded-xl cloud-shadow fade-in-up delay-400" onclick="toggleFaq(this)">
                        <div class="flex justify-between items-center">
                            <h4 class="font-headline font-bold text-brandNavy">Wat gebeurt er met mijn waardevolle spullen?</h4>
                            <span class="material-symbols-outlined text-brandNavy transition-transform">expand_more</span>
                        </div>
                        <div class="faq-answer">
                            <p class="text-gray-600 text-sm mt-3">We bespreken samen wat u wilt houden, verkopen, doneren of laten verwerken. Alles met uw toestemming.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 px-6">
            <div class="max-w-4xl mx-auto text-center bg-brandNavy text-white p-12 rounded-2xl fade-in-up">
                <span class="material-symbols-outlined text-5xl text-brandCyan mb-4 pulse-emergency inline-block">emergency</span>
                <h2 class="font-headline text-3xl font-bold mb-4">Spoed? Bel direct!</h2>
                <p class="text-white/80 mb-6">Voor urgente situaties ben ik ook buiten kantoortijden bereikbaar.</p>
                <a href="<?= $tel_href ?>" class="inline-block bg-brandCyan text-brandNavy px-10 py-4 rounded-full font-bold text-lg hover:bg-white transition-all pulse-glow">
                    <?= $telefoon ?>
                </a>
            </div>
        </section>
    </main>

    <footer class="bg-brandNavy text-white py-12 px-6">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-start md:items-center gap-8">
            <div>
                <h2 class="text-3xl font-bold mb-1 font-headline">Jim</h2>
                <h3 class="text-xl font-bold mb-4 font-headline">Ruimt Op</h3>
                <p class="text-white/70 text-sm max-w-xs">Specialist in ontruiming & ontzorging in regio Tilburg.</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-10 w-full md:w-auto">
                <div>
                    <h4 class="font-bold mb-3 text-brandCyan uppercase text-sm tracking-wider">Navigatie</h4>
                    <ul class="space-y-2 text-white/70 text-sm">
                        <li><a href="index.php" class="hover:text-white transition-colors">Home</a></li>
                        <li><a href="diensten.php" class="hover:text-white transition-colors">Diensten</a></li>
                        <?php if ($toon_fotos): ?><li><a href="fotos.php" class="hover:text-white transition-colors">Foto's</a></li><?php endif; ?>
                        <li><a href="over-mij.php" class="hover:text-white transition-colors">Over Mij</a></li>
                        <li><a href="contact.php" class="hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-3 text-brandCyan uppercase text-sm tracking-wider">Werkgebied</h4>
                    <ul class="space-y-2 text-white/70 text-sm">
                        <li><span class="text-white/50">Tilburg</span></li>
                        <li><a href="woningontruiming-berkel-enschot.html" class="hover:text-white transition-colors">Berkel-Enschot</a></li>
                        <li><a href="woningontruiming-oisterwijk.html" class="hover:text-white transition-colors">Oisterwijk</a></li>
                        <li><a href="woningontruiming-goirle.html" class="hover:text-white transition-colors">Goirle</a></li>
                        <li><a href="woningontruiming-hilvarenbeek.html" class="hover:text-white transition-colors">Hilvarenbeek</a></li>
                        <li><a href="woningontruiming-udenhout.html" class="hover:text-white transition-colors">Udenhout</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-3 text-brandCyan uppercase text-sm tracking-wider">Contact</h4>
                    <p class="text-white/70 text-sm"><?= $adres ?><br/><?= $email ?><br/>Bel: <?= $telefoon ?></p>
                </div>
                <div class="flex flex-col items-start sm:items-end">
                    <h4 class="font-bold mb-3 text-brandCyan uppercase text-sm tracking-wider">Direct contact</h4>
                    <a href="contact.php" class="bg-brandCyan text-brandNavy px-6 py-3 rounded-full font-bold hover:bg-opacity-90 transition-all">Contact Aanvragen</a>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto mt-12 pt-8 border-t border-white/20 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-white/50 text-sm">© 2026 Jim Ruimt Op. Alle rechten voorbehouden.</p>
        </div>
    </footer>

    <script>
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
        function updateProgressBar() {
            const scrollTop = window.scrollY;
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;
            document.getElementById('progress-bar').style.width = ((scrollTop / docHeight) * 100) + '%';
        }
        window.addEventListener('scroll', updateProgressBar);
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => { if (entry.isIntersecting) entry.target.classList.add('visible'); });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
        document.querySelectorAll('.fade-in-up, .fade-in-left, .fade-in-right, .scale-in').forEach(el => observer.observe(el));

        function toggleFaq(item) {
            const isActive = item.classList.contains('active');
            document.querySelectorAll('.faq-item').forEach(faq => {
                faq.classList.remove('active');
                faq.querySelector('.material-symbols-outlined').style.transform = 'rotate(0deg)';
            });
            if (!isActive) {
                item.classList.add('active');
                item.querySelector('.material-symbols-outlined').style.transform = 'rotate(180deg)';
            }
        }

        document.getElementById('contact-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = document.getElementById('submit-btn');
            const originalText = btn.innerHTML;
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const message = document.getElementById('message').value.trim();
            if (!name || !email || !message) {
                btn.innerHTML = '<span class="material-symbols-outlined">error</span> Vul alle verplichte velden in';
                btn.classList.remove('bg-brandNavy'); btn.classList.add('bg-red-500');
                setTimeout(() => { btn.innerHTML = originalText; btn.classList.remove('bg-red-500'); btn.classList.add('bg-brandNavy'); }, 2000);
                return;
            }
            btn.innerHTML = '<span class="material-symbols-outlined">refresh</span> Verzenden...';
            btn.disabled = true;
            setTimeout(() => {
                btn.innerHTML = '<span class="material-symbols-outlined">check_circle</span> Verzonden!';
                btn.classList.remove('bg-brandNavy'); btn.classList.add('bg-brandGreen');
                setTimeout(() => { btn.innerHTML = originalText; btn.classList.remove('bg-brandGreen'); btn.classList.add('bg-brandNavy'); btn.disabled = false; this.reset(); }, 3000);
            }, 1500);
        });

        document.addEventListener('DOMContentLoaded', () => { updateProgressBar(); });
    </script>
</body>
</html>
