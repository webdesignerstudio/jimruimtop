<?php
require_once __DIR__ . '/includes/functions.php';
$contact      = laad_json('contact.json');
$teksten      = laad_json('teksten.json');
$instellingen = laad_json('instellingen.json');
$toon_fotos   = $instellingen['toon_fotos_menu'] ?? true;
$p            = $teksten['index'] ?? [];

// Fallbacks
$telefoon        = t($contact, 'telefoon', '06 13 94 31 86');
$tel_href        = tel_link($contact);
$wa_url          = whatsapp_url($contact);
$hero_kop        = t($p, 'hero_kop', 'Jim Ruimt Op');
$hero_tagline    = t($p, 'hero_tagline', 'Zorgeloos geregeld!');
$hero_quote      = t($p, 'hero_quote', 'Ruimte creëren in huis is ruimte creëren in het hoofd.');
$diensten_kop    = t($p, 'diensten_kop', 'Woningontruiming in Tilburg');
$diensten_sub    = t($p, 'diensten_subtekst', 'Professionele ondersteuning voor alle ontruimingswerkzaamheden in regio Tilburg — van garage tot complete woning.');
$hoe_kop         = t($p, 'hoe_werkt_kop', 'Hoe werkt het?');
$hoe_sub         = t($p, 'hoe_werkt_subtekst', 'In drie eenvoudige stappen regelen we alles voor u.');
$stap1_kop       = t($p, 'stap1_kop', 'Gratis Kennismaking');
$stap1_tekst     = t($p, 'stap1_tekst', 'Jim komt langs voor een vrijblijvende inspectie op locatie. Geen kosten, geen verplichtingen.');
$stap2_kop       = t($p, 'stap2_kop', 'Duidelijke Offerte');
$stap2_tekst     = t($p, 'stap2_tekst', 'Binnen 48 uur ontvangt u een vaste prijs. Transparant, eerlijk, zonder verborgen kosten.');
$stap3_kop       = t($p, 'stap3_kop', 'Ik Regel Alles');
$stap3_tekst     = t($p, 'stap3_tekst', 'Van inboedel sorteren tot bezemschoon opleveren. U hoeft er niet bij te zijn als u dat niet wilt.');
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8"/>
    <link rel="icon" type="image/x-icon" href="/favicon.ico"/>
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png"/>
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png"/>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png"/>
    <link rel="manifest" href="/site.webmanifest"/>
    <meta name="theme-color" content="#1A436D"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Ontruimingsbedrijf Tilburg | Jim Ruimt Op — Woningontruiming & Ontzorging</title>
    <meta name="description" content="Professionele woningontruiming in Tilburg door Jim. Persoonlijk, empathisch en bezemschoon. Plan een kennismaking binnen 48 uur. Specialist voor senioren & nabestaanden."/>
    <meta name="robots" content="index, follow"/>
    <link rel="canonical" href="https://www.jimruimtop.nl/"/>
    <meta property="og:title" content="Jim Ruimt Op — Woningontruiming Tilburg"/>
    <meta property="og:description" content="Persoonlijk ontruimingsbedrijf in Tilburg. Empathisch, discreet, bezemschoon. Specialist voor senioren en nabestaanden."/>
    <meta property="og:image" content="https://www.jimruimtop.nl/jim-ruimt-op-logo.jpg"/>
    <meta property="og:url" content="https://www.jimruimtop.nl/"/>
    <meta property="og:type" content="website"/>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "name": "Jim Ruimt Op",
      "description": "Ontruimingsbedrijf in Tilburg gespecialiseerd in woningontruiming, seniorenverhuizing en zorgeloos afscheid. Empathisch, discreet en professioneel.",
      "url": "https://www.jimruimtop.nl",
      "telephone": "<?= htmlspecialchars($contact['telefoon'] ?? '06 13 94 31 86') ?>",
      "email": "<?= htmlspecialchars($contact['email'] ?? 'info@jimruimt-op.nl') ?>",
      "address": {
        "@type": "PostalAddress",
        "addressLocality": "Tilburg",
        "addressRegion": "Noord-Brabant",
        "addressCountry": "NL"
      },
      "openingHoursSpecification": [
        {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
          "opens": "08:00",
          "closes": "18:00"
        },
        {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": "Saturday",
          "opens": "09:00",
          "closes": "14:00"
        }
      ],
      "areaServed": ["Tilburg","Breda","Waalwijk","Oisterwijk","Den Bosch","Eindhoven"],
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
        /* Scroll Progress Bar */
        #progress-bar {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(90deg, #5BCEFF, #1A436D);
            z-index: 9999;
            transition: width 0.1s ease;
        }
        
        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }
        
        /* Card tilt effects */
        .card-tilted-left {
            transform: rotate(-5deg) translateY(20px);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .card-center {
            transform: translateY(-20px);
            z-index: 20;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .card-tilted-right {
            transform: rotate(5deg) translateY(20px);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        /* Card hover effects */
        .pricing-card:hover {
            transform: translateY(-10px) scale(1.02) !important;
            box-shadow: 0 25px 50px rgba(26, 67, 109, 0.2);
        }
        
        .card-center:hover {
            transform: translateY(-30px) scale(1.05) !important;
            box-shadow: 0 30px 60px rgba(26, 67, 109, 0.25);
        }
        
        @media (max-width: 768px) {
            .card-tilted-left,
            .card-center,
            .card-tilted-right {
                transform: none !important;
            }
            .pricing-card:hover {
                transform: translateY(-5px) !important;
            }
        }
        
        /* Shadow utilities */
        .cloud-shadow {
            box-shadow: 0 20px 40px rgba(26, 67, 109, 0.12);
        }
        .cloud-shadow-hover:hover {
            box-shadow: 0 30px 60px rgba(26, 67, 109, 0.18);
        }
        
        /* Animation classes */
        .fade-in-up {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .fade-in-up.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        .fade-in-left {
            opacity: 0;
            transform: translateX(-30px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .fade-in-left.visible {
            opacity: 1;
            transform: translateX(0);
        }
        
        .fade-in-right {
            opacity: 0;
            transform: translateX(30px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .fade-in-right.visible {
            opacity: 1;
            transform: translateX(0);
        }
        
        .scale-in {
            opacity: 0;
            transform: scale(0.9);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }
        .scale-in.visible {
            opacity: 1;
            transform: scale(1);
        }
        
        /* Stagger delays */
        .delay-100 { transition-delay: 0.1s; }
        .delay-200 { transition-delay: 0.2s; }
        .delay-300 { transition-delay: 0.3s; }
        .delay-400 { transition-delay: 0.4s; }
        .delay-500 { transition-delay: 0.5s; }
        
        /* Floating CTA button */
        .floating-cta {
            position: fixed;
            bottom: 24px;
            right: 16px;
            z-index: 40;
            animation: float 3s ease-in-out infinite;
        }
        @media (min-width: 640px) {
            .floating-cta { bottom: 30px; right: 30px; }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        /* Pulse animation for CTA */
        .pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }
        
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(91, 206, 255, 0.4); }
            50% { box-shadow: 0 0 20px 10px rgba(91, 206, 255, 0.2); }
        }
        
        /* Image hover zoom */
        .img-zoom-container {
            overflow: hidden;
            border-radius: 1rem;
        }
        .img-zoom-container img {
            transition: transform 0.5s ease;
        }
        .img-zoom-container:hover img {
            transform: scale(1.05);
        }
        
        /* Service card hover */
        .service-card {
            transition: all 0.3s ease;
        }
        .service-card:hover {
            transform: translateY(-5px);
            background-color: #5BCEFF;
        }
        .service-card:hover span,
        .service-card:hover .service-text {
            color: white;
        }
        
        /* Material icons */
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.8);
            z-index: 100;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .modal.active {
            display: flex;
        }
        .modal-content {
            background: white;
            border-radius: 1rem;
            max-width: 600px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            animation: modal-in 0.3s ease;
        }
        @keyframes modal-in {
            from { opacity: 0; transform: scale(0.9) translateY(20px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
        
        /* WhatsApp floating button */
        .wa-float-btn {
            position: fixed;
            bottom: 90px;
            right: 16px;
            z-index: 41;
            background: #25D366;
            color: white;
            width: 52px;
            height: 52px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 20px rgba(37,211,102,0.4);
            transition: transform 0.2s ease;
        }
        .wa-float-btn:hover { transform: scale(1.1); }
        @media (min-width: 640px) {
            .wa-float-btn { bottom: 110px; right: 30px; width: 56px; height: 56px; }
        }

        /* Play button pulse */
        .play-btn {
            animation: play-pulse 2s ease-in-out infinite;
        }
        @keyframes play-pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        
        /* Counter animation */
        .counter {
            font-variant-numeric: tabular-nums;
        }
    </style>
</head>
<body class="bg-white font-body" style="background-color:#f0f7ff">
    <!-- Scroll Progress Bar -->
    <div id="progress-bar" style="width: 0%"></div>

    <!-- Floating CTA Button -->
    <a href="contact.php" class="floating-cta bg-brandNavy text-white px-6 py-4 rounded-full font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2 pulse-glow">
        <span class="material-symbols-outlined">calendar_today</span>
        <span class="hidden sm:inline">Plan een kennismaking</span>
    </a>

    <!-- WhatsApp Floating Button -->
    <a href="<?= $wa_url ?>" target="_blank" rel="noopener" class="wa-float-btn" aria-label="WhatsApp Jim Ruimt Op">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
    </a>

    <!-- Header -->
    <header class="w-full bg-brandNavy sticky top-0 z-50 shadow-sm">
        <nav class="flex justify-between items-center max-w-7xl mx-auto px-6 py-4">
            <a href="index.php" class="flex items-center gap-2 hover:scale-105 transition-transform">
                <img src="logo.png" alt="Jim Ruimt Op" class="w-14 h-14 object-contain"/>
            </a>
            <div class="hidden md:flex items-center space-x-8">
                <a href="index.php" class="font-headline font-bold text-white border-b-2 border-brandCyan pb-1 hover:text-brandCyan transition-colors">Home</a>
                <a href="diensten.php" class="font-headline font-bold text-white/70 hover:text-brandCyan pb-1 transition-all">Diensten</a>
                <?php if ($toon_fotos): ?><a href="fotos.php" class="font-headline font-bold text-white/70 hover:text-brandCyan pb-1 transition-all">Foto's</a><?php endif; ?>
                <a href="over-mij.php" class="font-headline font-bold text-white/70 hover:text-brandCyan pb-1 transition-all">Over Ons</a>
                <a href="contact.php" class="font-headline font-bold text-white/70 hover:text-brandCyan pb-1 transition-all">Contact</a>
            </div>
            <div class="hidden md:flex items-center gap-4">
                <a href="<?= $tel_href ?>" class="flex items-center gap-2 text-white font-bold hover:text-brandCyan transition-colors text-sm">
                    <span class="material-symbols-outlined text-lg">call</span>
                    <span><?= $telefoon ?></span>
                </a>
                <a href="contact.php" class="bg-brandCyan text-brandNavy px-6 py-3 rounded-full font-bold hover:opacity-90 transition-all text-sm shadow-md">
                    Plan een kennismaking
                </a>
            </div>
            <button id="mobile-menu-btn" class="md:hidden text-white hover:text-brandCyan transition-colors">
                <span class="material-symbols-outlined text-3xl">menu</span>
            </button>
        </nav>
        <div id="mobile-menu" class="hidden md:hidden bg-brandNavy border-t border-white/20">
            <div class="flex flex-col px-6 py-4 space-y-4">
                <a href="index.php" class="font-headline font-bold text-white">Home</a>
                <a href="diensten.php" class="font-headline font-bold text-white/70 hover:text-brandCyan">Diensten</a>
                <?php if ($toon_fotos): ?><a href="fotos.php" class="font-headline font-bold text-white/70 hover:text-brandCyan">Foto's</a><?php endif; ?>
                <a href="over-mij.php" class="font-headline font-bold text-white/70 hover:text-brandCyan">Over Ons</a>
                <a href="contact.php" class="font-headline font-bold text-white/70 hover:text-brandCyan">Contact</a>
                <a href="<?= $tel_href ?>" class="flex items-center gap-2 text-white font-bold text-sm">
                    <span class="material-symbols-outlined text-lg">call</span><?= $telefoon ?>
                </a>
                <a href="contact.php" class="bg-brandCyan text-brandNavy px-6 py-3 rounded-full font-bold text-center text-sm hover:opacity-90 transition-all">Plan een kennismaking</a>
            </div>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="relative overflow-visible pt-10 pb-16 md:pt-16 md:pb-32 px-6 max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 items-center gap-16">
                <div class="z-10 fade-in-right">
                    <h2 class="font-headline text-4xl sm:text-5xl md:text-6xl font-extrabold leading-tight mb-4 text-brandNavy break-words" style="letter-spacing:-0.02em"><?= $hero_kop ?></h2>
                    <p class="text-brandCyan text-2xl sm:text-3xl md:text-5xl mb-8 md:mb-10" style="font-family:'Playfair Display',serif;font-style:italic;font-weight:600;letter-spacing:-0.01em"><?= $hero_tagline ?></p>
                    <div class="flex flex-wrap gap-4">
                        <a href="contact.php#formulier" class="inline-block bg-brandCyan text-brandNavy px-8 py-4 rounded-full font-bold text-lg hover:bg-white transition-all shadow-lg pulse-glow">
                            Kennismakingsgesprek
                        </a>
                        <a href="diensten.php" class="inline-block border-2 border-brandNavy text-brandNavy px-8 py-4 rounded-full font-bold text-lg hover:bg-brandNavy hover:text-white transition-all">
                            Bekijk Diensten
                        </a>
                    </div>
                    <!-- Beloften balk -->
                    <div class="grid grid-cols-3 gap-6 mt-12 pt-8 border-t border-gray-200">
                        <div class="text-center">
                            <span class="material-symbols-outlined text-brandCyan text-4xl mb-1 block">handshake</span>
                            <p class="text-sm font-bold text-brandNavy">Gratis kennismaking</p>
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
                        <img src="herofoto.jpg" alt="Jim, woningontruiming specialist Tilburg" class="w-full object-cover" style="max-height:520px;"/>
                    </div>
                    <div class="absolute -bottom-4 -left-4 bg-white p-4 rounded-xl cloud-shadow max-w-xs hidden md:block scale-in delay-400">
                        <p class="text-sm font-semibold text-brandNavy italic">"<?= $hero_quote ?>"</p>
                        <p class="text-xs text-gray-500 mt-1">— Jim</p>
                    </div>
                </div>
            </div>

                <div class="text-center mb-10 fade-in-up">
                    <h2 class="font-headline text-3xl md:text-4xl font-bold mb-3 text-brandNavy">Welke vorm van hulp past bij u?</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">Elke situatie is anders. Daarom werken wij met duidelijke pakketten van een complete ontruiming tot persoonlijke begeleiding.</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 items-stretch">

                    <!-- OPRUIMEN & OVERZICHT -->
                    <div class="pricing-card bg-white border-2 border-brandCyan/30 p-7 rounded-2xl cloud-shadow flex flex-col">
                        <div class="mb-4 text-brandNavy">
                            <span class="material-symbols-outlined text-5xl">home_work</span>
                        </div>
                        <h3 class="font-headline text-2xl font-bold mb-4 text-brandNavy">OPRUIMEN &amp; OVERZICHT</h3>
                        <p class="text-gray-600 mb-6" style="min-height:120px">Voor wie meer rust en ruimte in huis wil, zonder te verhuizen. Stap voor stap opruimen en organiseren in uw eigen tempo.</p>
                        <ul class="text-left space-y-2 mb-6 text-sm w-full">
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-brandCyan text-base">check_circle</span> Opruimen van één of meerdere ruimtes</li>
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-brandCyan text-base">check_circle</span> Samen keuzes maken over spullen</li>
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-brandCyan text-base">check_circle</span> Structuur en overzicht creëren</li>
                        </ul>
                        <a href="contact.php#formulier" class="mt-auto w-full text-center bg-brandNavy text-white px-6 py-2 rounded-full font-bold text-sm hover:bg-brandCyan hover:text-brandNavy transition-all">
                            Kennismaking aanvragen
                        </a>
                    </div>

                    <!-- BASIS -->
                    <div class="pricing-card bg-white border-2 border-brandCyan/30 p-7 rounded-2xl cloud-shadow flex flex-col">
                        <div class="mb-4 text-brandNavy">
                            <span class="material-symbols-outlined text-5xl">home</span>
                        </div>
                        <h3 class="font-headline text-2xl font-bold mb-4 text-brandNavy">BASIS</h3>
                        <p class="text-gray-600 mb-6" style="min-height:120px">Complete ontruiming voor een snelle en duidelijke afhandeling.</p>
                        <ul class="text-left space-y-2 mb-6 text-sm w-full">
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-brandCyan text-base">check_circle</span> Woningontruiming</li>
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-brandCyan text-base">check_circle</span> Afvoer van inboedel</li>
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-brandCyan text-base">check_circle</span> Bezemschoon oplevering</li>
                        </ul>
                        <a href="contact.php?onderwerp=core#formulier" class="mt-auto w-full text-center bg-brandNavy text-white px-6 py-2 rounded-full font-bold text-sm hover:bg-brandCyan hover:text-brandNavy transition-all">
                            Kennismaking aanvragen
                        </a>
                    </div>

                    <!-- BEGELEID (featured) -->
                    <div class="pricing-card bg-brandCyan/20 border-2 border-brandCyan p-7 rounded-2xl cloud-shadow flex flex-col relative">
                        <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-brandNavy text-white px-4 py-1 rounded-full text-xs font-bold whitespace-nowrap">
                            MEEST GEVRAAGD
                        </div>
                        <div class="mb-4 text-brandNavy">
                            <span class="material-symbols-outlined text-5xl">favorite</span>
                        </div>
                        <h3 class="font-headline text-2xl font-bold mb-4 text-brandNavy">BEGELEID</h3>
                        <p class="text-gray-600 mb-6" style="min-height:120px">Met aandacht en rust. Voor wie behoefte heeft aan ondersteuning en overzicht.</p>
                        <ul class="text-left space-y-2 mb-6 text-sm w-full">
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-brandCyan text-base">check_circle</span> Alles uit basis</li>
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-brandCyan text-base">check_circle</span> Hulp bij sorteren &amp; keuzes maken</li>
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-brandCyan text-base">check_circle</span> Rustige begeleiding tijdens het proces</li>
                        </ul>
                        <a href="contact.php?onderwerp=premium#formulier" class="mt-auto w-full text-center bg-brandNavy text-white px-6 py-2 rounded-full font-bold hover:bg-brandCyan hover:text-brandNavy transition-all text-sm">
                            Begeleiding bespreken
                        </a>
                    </div>

                    <!-- VOORBEREID & GEREGELD -->
                    <div class="pricing-card bg-white border-2 border-brandCyan/30 p-7 rounded-2xl cloud-shadow flex flex-col">
                        <div class="mb-4 text-brandNavy">
                            <span class="material-symbols-outlined text-5xl">elderly</span>
                        </div>
                        <h3 class="font-headline text-2xl font-bold mb-4 text-brandNavy">VOORBEREID &amp; GEREGELD</h3>
                        <p class="text-gray-600 mb-6" style="min-height:120px">Voor wie op tijd overzicht en duidelijkheid wil creëren.</p>
                        <ul class="text-left space-y-2 mb-6 text-sm w-full">
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-brandCyan text-base">check_circle</span> Inventarisatie van de woning</li>
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-brandCyan text-base">check_circle</span> Persoonlijk plan</li>
                            <li class="flex items-center gap-2"><span class="material-symbols-outlined text-brandCyan text-base">check_circle</span> Familie ontlasten</li>
                        </ul>
                        <a href="contact.php?onderwerp=senior#formulier" class="mt-auto w-full text-center bg-brandNavy text-white px-6 py-2 rounded-full font-bold text-sm hover:bg-brandCyan hover:text-brandNavy transition-all">
                            Plan vooruit maken
                        </a>
                    </div>

                </div>
            </div>
        </section>

        <!-- Hoe werkt het sectie -->
        <section class="py-20 px-6">
            <div class="max-w-5xl mx-auto">
                <div class="text-center mb-14 fade-in-up">
                    <h2 class="font-headline text-4xl font-bold mb-4 text-brandNavy"><?= $hoe_kop ?></h2>
                    <p class="text-gray-600 max-w-xl mx-auto"><?= $hoe_sub ?></p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center fade-in-up delay-100">
                        <div class="w-16 h-16 bg-brandNavy text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-6 cloud-shadow">1</div>
                        <h3 class="font-headline text-xl font-bold text-brandNavy mb-3"><?= $stap1_kop ?></h3>
                        <p class="text-gray-600"><?= $stap1_tekst ?></p>
                    </div>
                    <div class="text-center fade-in-up delay-200">
                        <div class="w-16 h-16 bg-brandCyan text-brandNavy rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-6 cloud-shadow">2</div>
                        <h3 class="font-headline text-xl font-bold text-brandNavy mb-3"><?= $stap2_kop ?></h3>
                        <p class="text-gray-600"><?= $stap2_tekst ?></p>
                    </div>
                    <div class="text-center fade-in-up delay-300">
                        <div class="w-16 h-16 bg-brandNavy text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-6 cloud-shadow border-2 border-brandCyan">3</div>
                        <h3 class="font-headline text-xl font-bold text-brandNavy mb-3"><?= $stap3_kop ?></h3>
                        <p class="text-gray-600"><?= $stap3_tekst ?></p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Trust badges balk -->
        <section class="bg-brandNavy py-8 px-6">
            <div class="max-w-5xl mx-auto">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center text-white">
                    <div class="fade-in-up">
                        <span class="material-symbols-outlined text-brandCyan text-3xl mb-1 block">store</span>
                        <p class="text-xs font-bold uppercase tracking-wide text-white/80">KvK geregistreerd</p>
                    </div>
                    <div class="fade-in-up delay-100">
                        <span class="material-symbols-outlined text-brandCyan text-3xl mb-1 block">recycling</span>
                        <p class="text-xs font-bold uppercase tracking-wide text-white/80">Milieubewuste afvoer</p>
                    </div>
                    <div class="fade-in-up delay-300">
                        <span class="material-symbols-outlined text-brandCyan text-3xl mb-1 block">verified</span>
                        <p class="text-xs font-bold uppercase tracking-wide text-white/80">Bezemschoon garantie</p>
                    </div>
                    <div class="fade-in-up delay-400">
                        <span class="material-symbols-outlined text-brandCyan text-3xl mb-1 block">schedule</span>
                        <p class="text-xs font-bold uppercase tracking-wide text-white/80">Binnen 48u teruggebeld</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Review & Contact Section -->
        <section class="bg-brandCyan/10 py-16 px-6">
            <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-12 items-start">
                <!-- Review Column -->
                <div class="fade-in-left">
                    <h2 class="font-headline text-3xl font-bold mb-6 text-brandNavy">Bekijk wie Jim is</h2>
                    <div class="relative aspect-video rounded-2xl overflow-hidden cloud-shadow bg-gray-200 group cursor-pointer" onclick="openVideoModal()">
                        <img src="file_26---05787c6d-5a2f-4a29-a396-a37570acc71c.jpg" alt="Bedrijfsvideo Jim Ruimt Op - woningontruiming Tilburg" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"/>
                        <div class="absolute inset-0 flex items-center justify-center bg-black/30 group-hover:bg-black/40 transition-all">
                            <div class="w-20 h-20 bg-white/90 rounded-full flex items-center justify-center shadow-xl play-btn group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-4xl text-brandNavy ml-1">play_arrow</span>
                            </div>
                        </div>
                        <div class="absolute bottom-4 left-4 bg-white/90 px-4 py-2 rounded-lg">
                            <p class="text-sm font-semibold text-brandNavy">Bekijk de bedrijfsvideo</p>
                        </div>
                    </div>
                </div>

                <!-- Contact Form Column -->
                <div class="fade-in-right delay-200">
                    <h2 class="font-headline text-3xl font-bold mb-2 text-brandNavy">Contact of bel terug</h2>
                    <p class="text-gray-500 mb-6 text-sm flex items-center gap-1"><span class="material-symbols-outlined text-brandCyan text-base">verified</span> Ik reageer binnen 48 uur</p>
                    <div class="mt-4 bg-white p-6 rounded-xl cloud-shadow">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="flex text-brandCyan">
                                <span class="material-symbols-outlined">star</span>
                                <span class="material-symbols-outlined">star</span>
                                <span class="material-symbols-outlined">star</span>
                                <span class="material-symbols-outlined">star</span>
                                <span class="material-symbols-outlined">star</span>
                            </div>
                            <span class="text-sm text-gray-500">2 dagen geleden</span>
                        </div>
                        <p class="text-gray-700 italic">"Jim heeft ons enorm geholpen bij het ontruimen van het huis van onze overleden vader. Met respect en empathie. Een aanrader!"</p>
                        <p class="text-sm text-brandNavy font-semibold mt-3">— Familie de Vries</p>
                    </div>
                    <div class="mt-6">
                        <a href="contact.php" class="w-full bg-brandNavy text-white px-8 py-4 rounded-full font-bold text-center hover:bg-brandCyan hover:text-brandNavy transition-all block">
                            Kennismaking Aanvragen
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-brandNavy text-white py-12 px-6">
        <div class="max-w-7xl mx-auto">
            <!-- Grid: 5 kolommen op desktop, 2 op mobiel -->
            <div class="grid grid-cols-2 md:grid-cols-5 gap-8">
                <!-- Kolom 1: Logo -->
                <div class="col-span-2 md:col-span-1">
                    <a href="index.php" class="flex items-center gap-3 mb-3 hover:opacity-90 transition-opacity">
                        <img src="logo.png" alt="Jim Ruimt Op" class="w-14 h-14 object-contain"/>
                        <span class="font-headline text-2xl font-bold text-white">Jim Ruimt Op</span>
                    </a>
                    <p class="text-white/70 text-sm">Specialist in ontruiming &amp; ontzorging in regio Tilburg.</p>
                </div>
                <!-- Kolom 2: Navigatie -->
                <div>
                    <h4 class="font-bold mb-3 text-brandCyan uppercase text-sm tracking-wider">Navigatie</h4>
                    <ul class="space-y-2 text-white/70 text-sm">
                        <li><a href="index.php" class="hover:text-white transition-colors">Home</a></li>
                        <li><a href="diensten.php" class="hover:text-white transition-colors">Diensten</a></li>
                        <?php if ($toon_fotos): ?><li><a href="fotos.php" class="hover:text-white transition-colors">Foto's</a></li><?php endif; ?>
                        <li><a href="over-mij.php" class="hover:text-white transition-colors">Over Ons</a></li>
                        <li><a href="contact.php" class="hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>
                <!-- Kolom 3: Werkgebied -->
                <div>
                    <h4 class="font-bold mb-3 text-brandCyan uppercase text-sm tracking-wider">Werkgebied</h4>
                    <ul class="space-y-2 text-white/70 text-sm">
                        <li><span class="text-white/50">Tilburg</span></li>
                        <li><a href="locatie.php?loc=berkel-enschot" class="hover:text-white transition-colors">Berkel-Enschot</a></li>
                        <li><a href="locatie.php?loc=oisterwijk" class="hover:text-white transition-colors">Oisterwijk</a></li>
                        <li><a href="locatie.php?loc=goirle" class="hover:text-white transition-colors">Goirle</a></li>
                        <li><a href="locatie.php?loc=hilvarenbeek" class="hover:text-white transition-colors">Hilvarenbeek</a></li>
                        <li><a href="locatie.php?loc=udenhout" class="hover:text-white transition-colors">Udenhout</a></li>
                    </ul>
                </div>
                <!-- Kolom 4: Contact -->
                <div>
                    <h4 class="font-bold mb-3 text-brandCyan uppercase text-sm tracking-wider">Contact</h4>
                    <p class="text-white/70 text-sm"><?= t($contact, 'adres', 'Tilburg') ?><br/><?= htmlspecialchars($contact['email'] ?? 'info@jimruimt-op.nl') ?><br/>Bel: <?= $telefoon ?></p>
                </div>
                <!-- Kolom 5: Direct contact -->
                <div class="flex flex-col items-start md:items-end">
                    <h4 class="font-bold mb-3 text-brandCyan uppercase text-sm tracking-wider">Direct contact</h4>
                    <a href="contact.php" class="bg-brandCyan text-brandNavy px-6 py-3 rounded-full font-bold hover:bg-opacity-90 transition-all text-sm md:text-base whitespace-nowrap">
                        Contact Aanvragen
                    </a>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto mt-12 pt-8 border-t border-white/20 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-white/50 text-sm">© 2026 Jim Ruimt Op. Alle rechten voorbehouden.</p>
        </div>
    </footer>

    <!-- Video Modal -->
    <div id="video-modal" class="modal">
        <div class="modal-content relative">
            <button onclick="closeVideoModal()" class="absolute top-4 right-4 w-10 h-10 bg-brandNavy text-white rounded-full flex items-center justify-center hover:bg-brandCyan hover:text-brandNavy transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
            <div class="aspect-video bg-brandNavy/10 rounded-t-xl flex items-center justify-center">
                <div class="text-center p-8">
                    <span class="material-symbols-outlined text-6xl text-brandNavy/40 mb-4">smart_display</span>
                    <p class="text-brandNavy/60 font-medium">Bedrijfsvideo — binnenkort beschikbaar</p>
                </div>
            </div>
            <div class="p-6">
                <h3 class="font-headline text-xl font-bold text-brandNavy mb-2">Jim Ruimt Op — Bedrijfsvideo</h3>
                <p class="text-gray-600">Maak kennis met Jim en zijn aanpak.</p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });

        function updateProgressBar() {
            const scrollTop = window.scrollY;
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;
            const progress = (scrollTop / docHeight) * 100;
            document.getElementById('progress-bar').style.width = progress + '%';
        }
        window.addEventListener('scroll', updateProgressBar);

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

        document.querySelectorAll('.fade-in-up, .fade-in-left, .fade-in-right, .scale-in').forEach(el => {
            observer.observe(el);
        });

        function openVideoModal() {
            document.getElementById('video-modal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeVideoModal() {
            document.getElementById('video-modal').classList.remove('active');
            document.body.style.overflow = '';
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeVideoModal();
        });

        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        });

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) target.scrollIntoView({ behavior: 'smooth' });
            });
        });

        document.addEventListener('DOMContentLoaded', () => { updateProgressBar(); });
    </script>
</body>
</html>
