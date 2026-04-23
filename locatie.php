<?php
require_once __DIR__ . '/includes/functions.php';

$contact      = laad_json('contact.json');
$teksten      = laad_json('teksten.json');
$locaties     = laad_json('locaties.json');
$instellingen = laad_json('instellingen.json');
$toon_fotos   = $instellingen['toon_fotos_menu'] ?? true;

$slug = trim($_GET['locatie'] ?? '');
$slug = preg_replace('/[^a-z0-9\-]/', '', strtolower($slug));

if (empty($slug) || !isset($locaties[$slug])) {
    header('HTTP/1.1 404 Not Found');
    include '404.html';
    exit;
}

$loc        = $locaties[$slug];
$naam       = htmlspecialchars($loc['naam']             ?? '', ENT_QUOTES, 'UTF-8');
$titel      = htmlspecialchars($loc['titel']            ?? 'Woningontruiming | Jim Ruimt Op', ENT_QUOTES, 'UTF-8');
$meta_desc  = htmlspecialchars($loc['meta_description'] ?? '', ENT_QUOTES, 'UTF-8');
$h1         = htmlspecialchars($loc['h1']               ?? 'Woningontruiming ' . $naam, ENT_QUOTES, 'UTF-8');
$intro      = htmlspecialchars($loc['intro']            ?? '', ENT_QUOTES, 'UTF-8');
$canonical  = 'https://www.jimruimtop.nl/woningontruiming-' . $slug . '.php';

$telefoon   = t($contact, 'telefoon', '06 13 94 31 86');
$tel_href   = tel_link($contact);
$wa_url     = whatsapp_url($contact);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= $titel ?></title>
    <meta name="description" content="<?= $meta_desc ?>"/>
    <meta name="robots" content="index, follow"/>
    <link rel="canonical" href="<?= $canonical ?>"/>
    <meta property="og:title" content="<?= $titel ?>"/>
    <meta property="og:description" content="<?= $meta_desc ?>"/>
    <meta property="og:image" content="https://www.jimruimtop.nl/jim-ruimt-op-logo.jpg"/>
    <meta property="og:url" content="<?= $canonical ?>"/>
    <meta property="og:type" content="website"/>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "name": "Jim Ruimt Op",
      "description": "Woningontruiming in <?= $naam ?> — empathisch, discreet en professioneel.",
      "url": "<?= $canonical ?>",
      "telephone": "<?= htmlspecialchars($contact['telefoon'] ?? '06 13 94 31 86') ?>",
      "email": "info@jimruimt-op.nl",
      "address": {
        "@type": "PostalAddress",
        "addressLocality": "Tilburg",
        "addressRegion": "Noord-Brabant",
        "addressCountry": "NL"
      },
      "areaServed": ["Tilburg", "<?= $naam ?>"],
      "priceRange": "€€"
    }
    </script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700;800&family=Inter:wght@400;500;600&family=Dancing+Script:wght@500&family=Playfair+Display:ital,wght@1,400;1,600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brandNavy: '#1A436D',
                        brandCyan: '#5BCEFF',
                        brandCream: '#F4F0E6',
                        brandGreen: '#7CC19D',
                    },
                    fontFamily: {
                        headline: ['Manrope', 'sans-serif'],
                        body: ['Inter', 'sans-serif'],
                        script: ['Dancing Script', 'cursive'],
                    }
                }
            }
        }
    </script>
    <style>
        #progress-bar { position:fixed;top:0;left:0;height:3px;background:linear-gradient(90deg,#5BCEFF,#1A436D);z-index:9999;transition:width 0.1s ease; }
        html { scroll-behavior:smooth; }
        .card-tilted-left { transform:rotate(-5deg) translateY(20px);transition:all 0.4s cubic-bezier(0.175,0.885,0.32,1.275); }
        .card-center { transform:translateY(-20px);z-index:20;transition:all 0.4s cubic-bezier(0.175,0.885,0.32,1.275); }
        .card-tilted-right { transform:rotate(5deg) translateY(20px);transition:all 0.4s cubic-bezier(0.175,0.885,0.32,1.275); }
        .pricing-card:hover { transform:translateY(-10px) scale(1.02) !important;box-shadow:0 25px 50px rgba(26,67,109,0.2); }
        .card-center:hover { transform:translateY(-30px) scale(1.05) !important;box-shadow:0 30px 60px rgba(26,67,109,0.25); }
        @media (max-width:768px) { .card-tilted-left,.card-center,.card-tilted-right { transform:none !important; } .pricing-card:hover { transform:translateY(-5px) !important; } }
        .cloud-shadow { box-shadow:0 20px 40px rgba(26,67,109,0.12); }
        .fade-in-up { opacity:0;transform:translateY(30px);transition:opacity 0.6s ease,transform 0.6s ease; }
        .fade-in-up.visible { opacity:1;transform:translateY(0); }
        .fade-in-left { opacity:0;transform:translateX(-30px);transition:opacity 0.6s ease,transform 0.6s ease; }
        .fade-in-left.visible { opacity:1;transform:translateX(0); }
        .fade-in-right { opacity:0;transform:translateX(30px);transition:opacity 0.6s ease,transform 0.6s ease; }
        .fade-in-right.visible { opacity:1;transform:translateX(0); }
        .scale-in { opacity:0;transform:scale(0.9);transition:opacity 0.5s ease,transform 0.5s ease; }
        .scale-in.visible { opacity:1;transform:scale(1); }
        .delay-100{transition-delay:0.1s;} .delay-200{transition-delay:0.2s;} .delay-300{transition-delay:0.3s;} .delay-400{transition-delay:0.4s;}
        .floating-cta { position:fixed;bottom:24px;right:16px;z-index:40;animation:float 3s ease-in-out infinite; }
        @media (min-width:640px) { .floating-cta { bottom:30px;right:30px; } }
        .wa-float-btn { position:fixed;bottom:90px;right:16px;z-index:41;background:#25D366;color:white;width:52px;height:52px;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 20px rgba(37,211,102,0.4);transition:transform 0.2s ease; }
        .wa-float-btn:hover { transform:scale(1.1); }
        @media (min-width:640px) { .wa-float-btn { bottom:110px;right:30px;width:56px;height:56px; } }
        @keyframes float { 0%,100%{transform:translateY(0);}50%{transform:translateY(-10px);} }
        .pulse-glow { animation:pulse-glow 2s ease-in-out infinite; }
        @keyframes pulse-glow { 0%,100%{box-shadow:0 0 0 0 rgba(91,206,255,0.4);}50%{box-shadow:0 0 20px 10px rgba(91,206,255,0.2);} }
        .img-zoom-container { overflow:hidden;border-radius:1rem; }
        .img-zoom-container img { transition:transform 0.5s ease; }
        .img-zoom-container:hover img { transform:scale(1.05); }
        .service-card { transition:all 0.3s ease; }
        .service-card:hover { transform:translateY(-5px);background-color:#5BCEFF; }
        .service-card:hover span,.service-card:hover .service-text { color:white; }
        .material-symbols-outlined { font-variation-settings:'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 24; }
    </style>
</head>
<body class="bg-white font-body" style="background-color:#f0f7ff">
    <div id="progress-bar" style="width:0%"></div>

    <a href="contact.php" class="floating-cta bg-brandNavy text-white px-6 py-4 rounded-full font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2 pulse-glow">
        <span class="material-symbols-outlined">calendar_today</span>
        <span class="hidden sm:inline">Gratis Intake</span>
    </a>

    <a href="<?= $wa_url ?>" target="_blank" rel="noopener" class="wa-float-btn" aria-label="WhatsApp Jim Ruimt Op">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
    </a>

    <header class="w-full bg-brandNavy sticky top-0 z-50 shadow-sm">
        <nav class="flex justify-between items-center max-w-7xl mx-auto px-6 py-4">
            <a href="index.php" class="flex items-center gap-2 hover:scale-105 transition-transform">
                <img src="logo.png" alt="Jim Ruimt Op" class="w-14 h-14 object-contain"/>
            </a>
            <div class="hidden md:flex items-center space-x-8">
                <a href="index.php" class="font-headline font-bold text-white/70 hover:text-brandCyan pb-1 transition-all">Home</a>
                <a href="diensten.php" class="font-headline font-bold text-white/70 hover:text-brandCyan pb-1 transition-all">Diensten</a>
                <?php if ($toon_fotos): ?><a href="fotos.php" class="font-headline font-bold text-white/70 hover:text-brandCyan pb-1 transition-all">Foto's</a><?php endif; ?>
                <a href="over-mij.php" class="font-headline font-bold text-white/70 hover:text-brandCyan pb-1 transition-all">Over Mij</a>
                <a href="contact.php" class="font-headline font-bold text-white/70 hover:text-brandCyan pb-1 transition-all">Contact</a>
            </div>
            <div class="hidden md:flex items-center gap-4">
                <a href="<?= $tel_href ?>" class="flex items-center gap-2 text-white font-bold hover:text-brandCyan transition-colors text-sm">
                    <span class="material-symbols-outlined text-lg">call</span>
                    <span><?= $telefoon ?></span>
                </a>
                <a href="contact.php" class="bg-brandCyan text-brandNavy px-6 py-3 rounded-full font-bold hover:opacity-90 transition-all text-sm shadow-md">Gratis Intake</a>
            </div>
            <button id="mobile-menu-btn" class="md:hidden text-white hover:text-brandCyan transition-colors">
                <span class="material-symbols-outlined text-3xl">menu</span>
            </button>
        </nav>
        <div id="mobile-menu" class="hidden md:hidden bg-brandNavy border-t border-white/20">
            <div class="flex flex-col px-6 py-4 space-y-4">
                <a href="index.php" class="font-headline font-bold text-white/70 hover:text-brandCyan">Home</a>
                <a href="diensten.php" class="font-headline font-bold text-white/70 hover:text-brandCyan">Diensten</a>
                <?php if ($toon_fotos): ?><a href="fotos.php" class="font-headline font-bold text-white/70 hover:text-brandCyan">Foto's</a><?php endif; ?>
                <a href="over-mij.php" class="font-headline font-bold text-white/70 hover:text-brandCyan">Over Mij</a>
                <a href="contact.php" class="font-headline font-bold text-white/70 hover:text-brandCyan">Contact</a>
                <a href="<?= $tel_href ?>" class="flex items-center gap-2 text-white font-bold text-sm"><span class="material-symbols-outlined text-lg">call</span><?= $telefoon ?></a>
                <a href="contact.php" class="bg-brandCyan text-brandNavy px-6 py-3 rounded-full font-bold text-center text-sm hover:opacity-90 transition-all">Gratis Intake</a>
            </div>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="relative overflow-visible pt-16 pb-32 px-6 max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 items-center gap-16">
                <div class="z-10 fade-in-right">
                    <p class="text-xs font-bold tracking-widest text-brandCyan uppercase mb-3">Werkgebied</p>
                    <h1 class="font-headline text-5xl md:text-6xl font-extrabold leading-tight mb-4 text-brandNavy break-words" style="letter-spacing:-0.02em"><?= $h1 ?></h1>
                    <p class="text-brandCyan text-3xl md:text-4xl mb-6" style="font-family:'Playfair Display',serif;font-style:italic;font-weight:600;letter-spacing:-0.01em">Zorgeloos geregeld!</p>
                    <p class="text-gray-600 leading-relaxed mb-8 text-base max-w-lg"><?= $intro ?></p>
                    <div class="flex flex-wrap gap-4">
                        <a href="contact.php" class="inline-block bg-brandCyan text-brandNavy px-8 py-4 rounded-full font-bold text-lg hover:bg-white transition-all shadow-lg pulse-glow">
                            Kennismakingsgesprek
                        </a>
                        <a href="diensten.php" class="inline-block border-2 border-brandNavy text-brandNavy px-8 py-4 rounded-full font-bold text-lg hover:bg-brandNavy hover:text-white transition-all">
                            Bekijk Diensten
                        </a>
                    </div>
                    <div class="grid grid-cols-3 gap-6 mt-12 pt-8 border-t border-gray-200">
                        <div class="text-center">
                            <span class="material-symbols-outlined text-brandCyan text-4xl mb-1 block">handshake</span>
                            <p class="text-sm font-bold text-brandNavy">Gratis intake</p>
                            <p class="text-xs text-gray-500">Altijd vrijblijvend</p>
                        </div>
                        <div class="text-center">
                            <span class="material-symbols-outlined text-brandCyan text-4xl mb-1 block">request_quote</span>
                            <p class="text-sm font-bold text-brandNavy">Vaste prijs</p>
                            <p class="text-xs text-gray-500">Geen verrassingen</p>
                        </div>
                        <div class="text-center">
                            <span class="material-symbols-outlined text-brandCyan text-4xl mb-1 block">verified</span>
                            <p class="text-sm font-bold text-brandNavy">Bezemschoon</p>
                            <p class="text-xs text-gray-500">Gegarandeerd</p>
                        </div>
                    </div>
                </div>
                <div class="relative fade-in-left delay-200">
                    <div class="img-zoom-container cloud-shadow rounded-2xl overflow-hidden">
                        <img src="herofoto.jpg" alt="Woningontruiming <?= $naam ?> — Jim Ruimt Op" class="w-full object-cover" style="max-height:520px;"/>
                    </div>
                    <div class="absolute -bottom-4 -left-4 bg-white p-4 rounded-xl cloud-shadow max-w-xs hidden md:block scale-in delay-400">
                        <p class="text-sm font-semibold text-brandNavy italic">"Ruimte creëren in huis is ruimte creëren in het hoofd."</p>
                        <p class="text-xs text-gray-500 mt-1">— Jim</p>
                    </div>
                </div>
            </div>

            <!-- Pakketten Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto relative px-4 mt-16">
                <div class="pricing-card card-tilted-left bg-white border-2 border-brandCyan/30 p-8 rounded-2xl cloud-shadow flex flex-col items-center text-center">
                    <div class="mb-4 text-brandNavy"><span class="material-symbols-outlined text-5xl">home</span></div>
                    <h3 class="text-2xl font-bold mb-1 text-brandNavy font-headline">CORE</h3>
                    <p class="text-sm text-gray-500 mb-4">All-in ontruiming</p>
                    <div class="text-2xl font-bold text-brandNavy mb-1">Op aanvraag</div>
                    <p class="text-xs text-gray-400 mb-4">Gratis intake — vaste prijs achteraf</p>
                    <ul class="text-left space-y-2 mb-6 text-sm w-full">
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-brandCyan text-base mt-0.5">check_circle</span> Complete woningontruiming</li>
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-brandCyan text-base mt-0.5">check_circle</span> Sorteren: bewaren / verkopen / doneren / afvoeren</li>
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-brandCyan text-base mt-0.5">check_circle</span> Schoonmaak & bezemschoon oplevering</li>
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-brandCyan text-base mt-0.5">check_circle</span> Coördinatie met woningcorporaties</li>
                    </ul>
                    <a href="diensten.php#pakket-core" class="mt-auto text-brandNavy font-bold hover:text-brandCyan transition-colors flex items-center gap-1 text-sm">Bekijk pakket <span class="material-symbols-outlined text-sm">arrow_forward</span></a>
                </div>
                <div class="pricing-card card-center bg-brandCyan/20 border-2 border-brandCyan p-8 rounded-2xl cloud-shadow flex flex-col items-center text-center relative">
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-brandNavy text-white px-4 py-1 rounded-full text-xs font-bold">MEEST GEVRAAGD</div>
                    <div class="mb-4 text-brandNavy"><span class="material-symbols-outlined text-5xl">favorite</span></div>
                    <h3 class="text-2xl font-bold mb-1 text-brandNavy font-headline">PREMIUM</h3>
                    <p class="text-sm text-gray-600 mb-4">Zorgeloos Afscheid Begeleiding</p>
                    <div class="text-2xl font-bold text-brandNavy mb-1">Op aanvraag</div>
                    <p class="text-xs text-gray-500 mb-4">Inclusief begeleiding & familiegesprekken</p>
                    <ul class="text-left space-y-2 mb-6 text-sm w-full">
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-brandCyan text-base mt-0.5">check_circle</span> Alles van Core aanbod</li>
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-brandCyan text-base mt-0.5">check_circle</span> Rustige begeleiding bij keuzes</li>
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-brandCyan text-base mt-0.5">check_circle</span> Tijd nemen voor herinneringen</li>
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-brandCyan text-base mt-0.5">check_circle</span> Familiegesprekken faciliteren</li>
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-brandCyan text-base mt-0.5">check_circle</span> Waardevolle items verkopen / doneren</li>
                    </ul>
                    <a href="diensten.php#pakket-premium" class="mt-auto bg-brandNavy text-white px-6 py-2 rounded-full font-bold hover:bg-brandCyan hover:text-brandNavy transition-colors text-sm">Bekijk pakket</a>
                </div>
                <div class="pricing-card card-tilted-right bg-white border-2 border-brandCyan/30 p-8 rounded-2xl cloud-shadow flex flex-col items-center text-center">
                    <div class="mb-4 text-brandNavy"><span class="material-symbols-outlined text-5xl">elderly</span></div>
                    <h3 class="text-2xl font-bold mb-1 text-brandNavy font-headline">SENIOR</h3>
                    <p class="text-sm text-gray-500 mb-4">Rust Vooraf Pakket</p>
                    <div class="text-2xl font-bold text-brandNavy mb-1">Op aanvraag</div>
                    <p class="text-xs text-gray-400 mb-4">Vooruit plannen zonder stress</p>
                    <ul class="text-left space-y-2 mb-6 text-sm w-full">
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-brandCyan text-base mt-0.5">check_circle</span> Inventarisatie van de woning</li>
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-brandCyan text-base mt-0.5">check_circle</span> Persoonlijk plan op maat</li>
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-brandCyan text-base mt-0.5">check_circle</span> Keuzes vooraf vastleggen</li>
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-brandCyan text-base mt-0.5">check_circle</span> Kinderen worden niet belast</li>
                    </ul>
                    <a href="diensten.php#pakket-senior" class="mt-auto bg-brandNavy text-white px-6 py-2 rounded-full font-bold text-sm hover:bg-brandCyan hover:text-brandNavy transition-all">Bekijk pakket</a>
                </div>
            </div>
        </section>

        <!-- Maatwerk pill -->
        <div class="px-6 pb-2" style="background-color:#f0f7ff">
            <div class="max-w-5xl mx-auto flex justify-center">
                <a href="contact.php" class="inline-flex items-center gap-2 bg-white border border-gray-200 text-gray-500 text-xs font-medium px-5 py-2 rounded-full cloud-shadow hover:border-brandNavy hover:text-brandNavy transition-all">
                    <span class="material-symbols-outlined text-gray-400" style="font-size:14px">handshake</span>
                    Andere situatie? Jim maakt een offerte op maat.
                    <span class="material-symbols-outlined text-gray-400" style="font-size:14px">arrow_forward</span>
                </a>
            </div>
        </div>

        <!-- Hoe werkt het -->
        <section class="py-20 px-6">
            <div class="max-w-5xl mx-auto">
                <div class="text-center mb-14 fade-in-up">
                    <h2 class="font-headline text-4xl font-bold mb-4 text-brandNavy">Hoe werkt het?</h2>
                    <p class="text-gray-600 max-w-xl mx-auto">In drie eenvoudige stappen regelen we alles voor u.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center fade-in-up delay-100">
                        <div class="w-16 h-16 bg-brandNavy text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-6 cloud-shadow">1</div>
                        <h3 class="font-headline text-xl font-bold text-brandNavy mb-3">Gratis Intake</h3>
                        <p class="text-gray-600">Jim komt langs voor een vrijblijvende inspectie op locatie. Geen kosten, geen verplichtingen.</p>
                    </div>
                    <div class="text-center fade-in-up delay-200">
                        <div class="w-16 h-16 bg-brandCyan text-brandNavy rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-6 cloud-shadow">2</div>
                        <h3 class="font-headline text-xl font-bold text-brandNavy mb-3">Duidelijke Offerte</h3>
                        <p class="text-gray-600">Binnen 48 uur ontvangt u een vaste prijs. Transparant, eerlijk, zonder verborgen kosten.</p>
                    </div>
                    <div class="text-center fade-in-up delay-300">
                        <div class="w-16 h-16 bg-brandNavy text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-6 cloud-shadow border-2 border-brandCyan">3</div>
                        <h3 class="font-headline text-xl font-bold text-brandNavy mb-3">Ik Regel Alles</h3>
                        <p class="text-gray-600">Van inboedel sorteren tot bezemschoon opleveren. U hoeft er niet bij te zijn als u dat niet wilt.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Trust badges -->
        <section class="bg-brandNavy py-8 px-6">
            <div class="max-w-5xl mx-auto">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center text-white">
                    <div class="fade-in-up"><span class="material-symbols-outlined text-brandCyan text-3xl mb-1 block">store</span><p class="text-xs font-bold uppercase tracking-wide text-white/80">KvK geregistreerd</p></div>
                    <div class="fade-in-up delay-100"><span class="material-symbols-outlined text-brandCyan text-3xl mb-1 block">recycling</span><p class="text-xs font-bold uppercase tracking-wide text-white/80">Milieubewuste afvoer</p></div>
                    <div class="fade-in-up delay-300"><span class="material-symbols-outlined text-brandCyan text-3xl mb-1 block">verified</span><p class="text-xs font-bold uppercase tracking-wide text-white/80">Bezemschoon garantie</p></div>
                    <div class="fade-in-up delay-400"><span class="material-symbols-outlined text-brandCyan text-3xl mb-1 block">schedule</span><p class="text-xs font-bold uppercase tracking-wide text-white/80">Binnen 48u teruggebeld</p></div>
                </div>
            </div>
        </section>

        <!-- Review & Contact -->
        <section class="bg-brandCyan/10 py-16 px-6">
            <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-12 items-start">
                <div class="fade-in-left">
                    <h2 class="font-headline text-3xl font-bold mb-6 text-brandNavy">Wat klanten zeggen</h2>
                    <div class="bg-white p-6 rounded-xl cloud-shadow hover:shadow-lg transition-shadow mb-6">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="flex text-brandCyan">
                                <span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span><span class="material-symbols-outlined">star</span>
                            </div>
                            <span class="text-sm text-gray-500">Tilburg & omgeving</span>
                        </div>
                        <p class="text-gray-700 italic">"Jim heeft ons enorm geholpen bij het ontruimen van het huis van onze overleden vader. Met respect en empathie. Een aanrader!"</p>
                        <p class="text-sm text-brandNavy font-semibold mt-3">— Familie de Vries</p>
                    </div>
                    <div class="bg-brandNavy/5 p-5 rounded-xl border border-brandNavy/10">
                        <p class="text-sm text-brandNavy font-medium leading-relaxed">Jim is ook actief in <strong>Tilburg</strong>, <strong>Berkel-Enschot</strong>, <strong>Oisterwijk</strong>, <strong>Goirle</strong>, <strong>Hilvarenbeek</strong> en <strong>Udenhout</strong>. Twijfelt u of wij bij u in de buurt komen? Bel of app gerust.</p>
                    </div>
                </div>
                <div class="fade-in-right delay-200">
                    <h2 class="font-headline text-3xl font-bold mb-2 text-brandNavy">Contact of bel terug</h2>
                    <p class="text-gray-500 mb-6 text-sm flex items-center gap-1"><span class="material-symbols-outlined text-brandCyan text-base">verified</span> Ik reageer binnen 48 uur</p>
                    <form action="contact.php" method="GET" class="space-y-4 bg-white p-6 rounded-xl cloud-shadow">
                        <p class="text-gray-600 text-sm">Vul het volledige contactformulier in voor een snelle reactie van Jim.</p>
                        <a href="contact.php" class="block w-full text-center bg-brandNavy text-white py-4 rounded-xl font-bold text-lg hover:bg-brandCyan hover:text-brandNavy transition-all shadow-md">
                            Naar contactformulier →
                        </a>
                        <div class="flex gap-3 pt-2">
                            <a href="<?= $tel_href ?>" class="flex-1 flex items-center justify-center gap-2 border-2 border-brandNavy text-brandNavy py-3 rounded-xl font-bold hover:bg-brandNavy hover:text-white transition-all text-sm">
                                <span class="material-symbols-outlined text-lg">call</span> Bel direct
                            </a>
                            <a href="<?= $wa_url ?>" target="_blank" rel="noopener" class="flex-1 flex items-center justify-center gap-2 border-2 border-green-500 text-green-600 py-3 rounded-xl font-bold hover:bg-green-500 hover:text-white transition-all text-sm">
                                <span class="material-symbols-outlined text-lg">chat</span> WhatsApp
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
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
                    <p class="text-white/70 text-sm">Tilburg<br/>info@jimruimt-op.nl<br/>Bel: <?= $telefoon ?></p>
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
    </script>
</body>
</html>
