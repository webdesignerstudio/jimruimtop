<?php
require_once __DIR__ . '/includes/functions.php';
$contact  = laad_json('contact.json');
$teksten  = laad_json('teksten.json');
$p        = $teksten['index'] ?? [];

// Fallbacks
$telefoon        = t($contact, 'telefoon', '06 12 34 56 78');
$tel_href        = tel_link($contact);
$wa_url          = whatsapp_url($contact);
$hero_script     = t($p, 'hero_script', 'Woningontruiming Tilburg');
$hero_regel1     = t($p, 'hero_kop_regel1', 'Van Chaos naar Rust,');
$hero_regel2     = t($p, 'hero_kop_regel2', 'Uw Zorgeloze Afronding');
$hero_regel3     = t($p, 'hero_kop_regel3', 'Begint Hier.');
$hero_sub        = t_html($p, 'hero_subtekst', 'Geen gewoon ontruimingsbedrijf — maar een <strong>afscheids- en ontzorgservice</strong> voor senioren en nabestaanden in Tilburg en omstreken. Praktisch geregeld, emotioneel begeleid.');
$hero_quote      = t($p, 'hero_quote', 'Ruimte creëren in huis is ruimte creëren in het hoofd.');
$diensten_kop    = t($p, 'diensten_kop', 'Woningontruiming in Tilburg');
$diensten_sub    = t($p, 'diensten_subtekst', 'Professionele ondersteuning voor alle ontruimingswerkzaamheden in regio Tilburg — van garage tot complete woning.');
$hoe_kop         = t($p, 'hoe_werkt_kop', 'Hoe werkt het?');
$hoe_sub         = t($p, 'hoe_werkt_subtekst', 'In drie eenvoudige stappen regelen we alles voor u.');
$stap1_kop       = t($p, 'stap1_kop', 'Gratis Intake');
$stap1_tekst     = t($p, 'stap1_tekst', 'Jim komt langs voor een vrijblijvende inspectie op locatie. Geen kosten, geen verplichtingen.');
$stap2_kop       = t($p, 'stap2_kop', 'Duidelijke Offerte');
$stap2_tekst     = t($p, 'stap2_tekst', 'Binnen 48 uur ontvangt u een vaste prijs. Transparant, eerlijk, zonder verborgen kosten.');
$stap3_kop       = t($p, 'stap3_kop', 'Wij Regelen Alles');
$stap3_tekst     = t($p, 'stap3_tekst', 'Van inboedel sorteren tot bezemschoon opleveren. U hoeft er niet bij te zijn als u dat niet wilt.');
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Ontruimingsbedrijf Tilburg | Jim Ruimt Op — Woningontruiming & Ontzorging</title>
    <meta name="description" content="Professionele woningontruiming in Tilburg door Jim. Persoonlijk, empathisch en bezemschoon. Gratis intake binnen 48 uur. Specialist voor senioren & nabestaanden."/>
    <meta name="robots" content="index, follow"/>
    <link rel="canonical" href="https://www.jimruimtop.nl/index.html"/>
    <meta property="og:title" content="Jim Ruimt Op — Woningontruiming Tilburg"/>
    <meta property="og:description" content="Persoonlijk ontruimingsbedrijf in Tilburg. Empathisch, discreet, bezemschoon. Specialist voor senioren en nabestaanden."/>
    <meta property="og:image" content="https://www.jimruimtop.nl/jim-ruimt-op-logo.jpg"/>
    <meta property="og:url" content="https://www.jimruimtop.nl"/>
    <meta property="og:type" content="website"/>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "name": "Jim Ruimt Op",
      "description": "Ontruimingsbedrijf in Tilburg gespecialiseerd in woningontruiming, seniorenverhuizing en zorgeloos afscheid. Empathisch, discreet en professioneel.",
      "url": "https://www.jimruimtop.nl",
      "telephone": "<?= htmlspecialchars($contact['telefoon'] ?? '06 12 34 56 78') ?>",
      "email": "<?= htmlspecialchars($contact['email'] ?? 'info@jimruimtop.nl') ?>",
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
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700;800&family=Inter:wght@400;500;600&family=Dancing+Script:wght@500&display=swap" rel="stylesheet"/>
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
            bottom: 30px;
            right: 30px;
            z-index: 40;
            animation: float 3s ease-in-out infinite;
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
        <span class="hidden sm:inline">Gratis Intake</span>
    </a>

    <!-- WhatsApp Floating Button -->
    <a href="<?= $wa_url ?>" target="_blank" rel="noopener" style="position:fixed;bottom:170px;right:30px;z-index:41;background:#25D366;color:white;width:56px;height:56px;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 20px rgba(37,211,102,0.4);transition:transform 0.2s ease;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'" aria-label="WhatsApp Jim Ruimt Op">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
    </a>

    <!-- Header -->
    <header class="w-full bg-brandNavy sticky top-0 z-50 shadow-sm">
        <nav class="flex justify-between items-center max-w-7xl mx-auto px-6 py-4">
            <a href="index.php" class="flex items-center gap-2 hover:scale-105 transition-transform">
                <img src="logo.png" alt="Jim Ruimt Op" class="w-14 h-14 object-contain"/>
                <div>
                    <h1 class="text-xl font-bold leading-tight text-white font-headline">Jim Ruimt Op</h1>
                    <p class="text-brandCyan italic text-sm">Zorgeloos geregeld!</p>
                </div>
            </a>
            <div class="hidden md:flex items-center space-x-8">
                <a href="index.php" class="font-headline font-bold text-white border-b-2 border-brandCyan pb-1 hover:text-brandCyan transition-colors">Home</a>
                <a href="diensten.php" class="font-headline font-bold text-white/70 hover:text-brandCyan pb-1 transition-all">Diensten</a>
                <a href="fotos.php" class="font-headline font-bold text-white/70 hover:text-brandCyan pb-1 transition-all">Foto's</a>
                <a href="over-mij.php" class="font-headline font-bold text-white/70 hover:text-brandCyan pb-1 transition-all">Over Mij</a>
                <a href="contact.php" class="font-headline font-bold text-white/70 hover:text-brandCyan pb-1 transition-all">Contact</a>
            </div>
            <div class="hidden md:flex items-center gap-4">
                <a href="<?= $tel_href ?>" class="flex items-center gap-2 text-white font-bold hover:text-brandCyan transition-colors text-sm">
                    <span class="material-symbols-outlined text-lg">call</span>
                    <span><?= $telefoon ?></span>
                </a>
                <a href="contact.php" class="bg-brandCyan text-brandNavy px-6 py-3 rounded-full font-bold hover:opacity-90 transition-all text-sm shadow-md">
                    Gratis Intake
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
                <a href="fotos.php" class="font-headline font-bold text-white/70 hover:text-brandCyan">Foto's</a>
                <a href="over-mij.php" class="font-headline font-bold text-white/70 hover:text-brandCyan">Over Mij</a>
                <a href="contact.php" class="font-headline font-bold text-white/70 hover:text-brandCyan">Contact</a>
                <a href="<?= $tel_href ?>" class="flex items-center gap-2 text-white font-bold text-sm">
                    <span class="material-symbols-outlined text-lg">call</span><?= $telefoon ?>
                </a>
                <a href="contact.php" class="bg-brandCyan text-brandNavy px-6 py-3 rounded-full font-bold text-center text-sm hover:opacity-90 transition-all">Gratis Intake</a>
            </div>
        </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="relative overflow-visible pt-16 pb-32 px-6 max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 items-center gap-16">
                <div class="z-10 fade-in-right">
                    <h2 class="font-headline text-4xl md:text-5xl font-bold leading-tight mb-4 text-brandNavy whitespace-nowrap">Jim Ruimt Op</h2>
                    <p class="font-script text-brandCyan text-5xl md:text-7xl mb-10">Zorgeloos geregeld!</p>
                    <div class="flex flex-wrap gap-4">
                        <a href="contact.php" class="inline-block bg-brandCyan text-brandNavy px-8 py-4 rounded-full font-bold text-lg hover:bg-white transition-all shadow-lg pulse-glow">
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
                        <img src="herofoto.jpg" alt="Jim, woningontruiming specialist Tilburg" class="w-full object-cover" style="max-height:520px;"/>
                    </div>
                    <div class="absolute -bottom-4 -left-4 bg-white p-4 rounded-xl cloud-shadow max-w-xs hidden md:block scale-in delay-400">
                        <p class="text-sm font-semibold text-brandNavy italic">"Ruimte creëren in huis is ruimte creëren in het hoofd."</p>
                        <p class="text-xs text-gray-500 mt-1">— Jim</p>
                    </div>
                </div>
            </div>

            <!-- Overlapping Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto relative px-4 mt-16">

                <!-- Core Aanbod Card -->
                <div class="pricing-card card-tilted-left bg-white border-2 border-gray-100 p-8 rounded-2xl cloud-shadow flex flex-col items-center text-center">
                    <div class="mb-4 text-brandNavy">
                        <span class="material-symbols-outlined text-5xl">home</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-1 text-brandNavy font-headline">CORE</h3>
                    <p class="text-sm text-gray-500 mb-4">All-in ontruiming</p>
                    <div class="text-2xl font-bold text-brandNavy mb-1">Op aanvraag</div>
                    <p class="text-xs text-gray-400 mb-4">Gratis intake — vaste prijs achteraf</p>
                    <ul class="text-left space-y-2 mb-6 text-sm w-full">
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-brandGreen text-base mt-0.5">check_circle</span> Complete woningontruiming</li>
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-brandGreen text-base mt-0.5">check_circle</span> Sorteren: bewaren / verkopen / doneren / afvoeren</li>
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-brandGreen text-base mt-0.5">check_circle</span> Schoonmaak & bezemschoon oplevering</li>
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-brandGreen text-base mt-0.5">check_circle</span> Coördinatie met woningcorporaties</li>
                    </ul>
                    <a href="diensten.php#pakket-core" class="mt-auto text-brandNavy font-bold hover:text-brandCyan transition-colors flex items-center gap-1 text-sm">
                        Bekijk pakket <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>

                <!-- Zorgeloos Afscheid Card (Featured) -->
                <div class="pricing-card card-center bg-brandCyan/20 border-2 border-brandCyan p-8 rounded-2xl cloud-shadow flex flex-col items-center text-center relative">
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-brandNavy text-white px-4 py-1 rounded-full text-xs font-bold">
                        MEEST GEVRAAGD
                    </div>
                    <div class="mb-4 text-brandNavy">
                        <span class="material-symbols-outlined text-5xl">favorite</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-1 text-brandNavy font-headline">PREMIUM</h3>
                    <p class="text-sm text-gray-600 mb-4">Zorgeloos Afscheid Begeleiding</p>
                    <div class="text-2xl font-bold text-brandNavy mb-1">Op aanvraag</div>
                    <p class="text-xs text-gray-500 mb-4">Inclusief begeleiding & familiegesprekken</p>
                    <ul class="text-left space-y-2 mb-6 text-sm w-full">
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-brandGreen text-base mt-0.5">check_circle</span> Alles van Core aanbod</li>
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-brandGreen text-base mt-0.5">check_circle</span> Rustige begeleiding bij keuzes</li>
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-brandGreen text-base mt-0.5">check_circle</span> Tijd nemen voor herinneringen</li>
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-brandGreen text-base mt-0.5">check_circle</span> Familiegesprekken faciliteren</li>
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-brandGreen text-base mt-0.5">check_circle</span> Waardevolle items verkopen / doneren</li>
                    </ul>
                    <a href="diensten.php#pakket-premium" class="mt-auto bg-brandGreen text-white px-6 py-2 rounded-full font-bold hover:bg-brandNavy transition-colors text-sm">
                        Bekijk pakket
                    </a>
                </div>

                <!-- Senior Vooruit-planning Card -->
                <div class="pricing-card card-tilted-right bg-white border-2 border-gray-100 p-8 rounded-2xl cloud-shadow flex flex-col items-center text-center">
                    <div class="mb-4 text-brandNavy">
                        <span class="material-symbols-outlined text-5xl">elderly</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-1 text-brandNavy font-headline">SENIOR</h3>
                    <p class="text-sm text-gray-500 mb-4">Rust Vooraf Pakket</p>
                    <div class="text-2xl font-bold text-brandNavy mb-1">Op aanvraag</div>
                    <p class="text-xs text-gray-400 mb-4">Vooruit plannen zonder stress</p>
                    <ul class="text-left space-y-2 mb-6 text-sm w-full">
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-brandGreen text-base mt-0.5">check_circle</span> Inventarisatie van de woning</li>
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-brandGreen text-base mt-0.5">check_circle</span> Persoonlijk plan op maat</li>
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-brandGreen text-base mt-0.5">check_circle</span> Keuzes vooraf vastleggen</li>
                        <li class="flex items-start gap-2"><span class="material-symbols-outlined text-brandGreen text-base mt-0.5">check_circle</span> Kinderen worden niet belast</li>
                    </ul>
                    <a href="diensten.php#pakket-senior" class="mt-auto bg-brandNavy text-white px-6 py-2 rounded-full font-bold text-sm hover:bg-brandCyan hover:text-brandNavy transition-all">
                        Bekijk pakket
                    </a>
                </div>
            </div>
        </section>

        <!-- Voor wie is Jim er? Sectie -->
        <section class="py-20 px-6" style="background-color:#f0f7ff">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-14 fade-in-up">
                    <span class="font-script text-brandCyan text-3xl mb-3 block">Geen vaste doelgroep — gewoon mensen die hulp nodig hebben</span>
                    <h2 class="font-headline text-4xl md:text-5xl font-bold text-brandNavy mb-4">Voor wie is Jim er?</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto text-lg">Of u nu plotseling moet handelen of rustig vooruit plant — Jim helpt in elke situatie waarbij een woning of ruimte leeg moet. Zonder oordeel, zonder haast.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                    <!-- Tegel 1: Overlijden -->
                    <div class="bg-white rounded-2xl p-7 cloud-shadow flex gap-5 items-start fade-in-up delay-100 hover:shadow-xl transition-shadow">
                        <div class="w-14 h-14 rounded-full bg-brandNavy/10 flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-brandNavy text-3xl">favorite</span>
                        </div>
                        <div>
                            <h3 class="font-headline text-lg font-bold text-brandNavy mb-1">Na het verlies van een dierbare</h3>
                            <p class="text-sm text-gray-500">Woning leegmaken na overlijden — met alle tijd en aandacht die uw familie verdient.</p>
                        </div>
                    </div>

                    <!-- Tegel 2: Gezin / spoed -->
                    <div class="bg-white rounded-2xl p-7 cloud-shadow flex gap-5 items-start fade-in-up delay-200 hover:shadow-xl transition-shadow">
                        <div class="w-14 h-14 rounded-full bg-brandCyan/20 flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-brandNavy text-3xl">family_restroom</span>
                        </div>
                        <div>
                            <h3 class="font-headline text-lg font-bold text-brandNavy mb-1">Gezin dat snel moet verhuizen</h3>
                            <p class="text-sm text-gray-500">Vier kinderen, weinig tijd? Jim regelt de rommel zodat u zich kunt focussen op de verhuizing zelf.</p>
                        </div>
                    </div>

                    <!-- Tegel 3: Scheiding -->
                    <div class="bg-white rounded-2xl p-7 cloud-shadow flex gap-5 items-start fade-in-up delay-300 hover:shadow-xl transition-shadow">
                        <div class="w-14 h-14 rounded-full bg-brandNavy/10 flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-brandNavy text-3xl">splitscreen</span>
                        </div>
                        <div>
                            <h3 class="font-headline text-lg font-bold text-brandNavy mb-1">Scheiding — woning leegmaken</h3>
                            <p class="text-sm text-gray-500">Een emotionele periode. Jim maakt de woning netjes leeg zodat u beiden verder kunt.</p>
                        </div>
                    </div>

                    <!-- Tegel 4: Senioren -->
                    <div class="bg-white rounded-2xl p-7 cloud-shadow flex gap-5 items-start fade-in-up delay-200 hover:shadow-xl transition-shadow">
                        <div class="w-14 h-14 rounded-full bg-brandCyan/20 flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-brandNavy text-3xl">elderly</span>
                        </div>
                        <div>
                            <h3 class="font-headline text-lg font-bold text-brandNavy mb-1">Senioren die kleiner gaan wonen</h3>
                            <p class="text-sm text-gray-500">Van een grote woning naar een appartement — op uw eigen tempo, met respect voor uw spullen.</p>
                        </div>
                    </div>

                    <!-- Tegel 5: Verkoop / verhuur -->
                    <div class="bg-white rounded-2xl p-7 cloud-shadow flex gap-5 items-start fade-in-up delay-300 hover:shadow-xl transition-shadow">
                        <div class="w-14 h-14 rounded-full bg-brandNavy/10 flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-brandNavy text-3xl">sell</span>
                        </div>
                        <div>
                            <h3 class="font-headline text-lg font-bold text-brandNavy mb-1">Woning verkopen of verhuren</h3>
                            <p class="text-sm text-gray-500">Bezemschoon, leeg en klaar voor de makelaar of nieuwe huurder. Snel en professioneel.</p>
                        </div>
                    </div>

                    <!-- Tegel 6: Bedrijfsruimte -->
                    <div class="bg-white rounded-2xl p-7 cloud-shadow flex gap-5 items-start fade-in-up delay-400 hover:shadow-xl transition-shadow">
                        <div class="w-14 h-14 rounded-full bg-brandCyan/20 flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-brandNavy text-3xl">store</span>
                        </div>
                        <div>
                            <h3 class="font-headline text-lg font-bold text-brandNavy mb-1">Bedrijfsruimte of kantoor</h3>
                            <p class="text-sm text-gray-500">Kantoor sluit, winkel verhuist of magazijn moet leeg? Jim pakt het aan, zonder gedoe.</p>
                        </div>
                    </div>

                </div>

                <!-- Onderste CTA -->
                <div class="mt-12 text-center fade-in-up">
                    <p class="text-gray-500 mb-4">Staat uw situatie er niet bij? Neem gewoon contact op — Jim denkt graag mee.</p>
                    <a href="contact.php" class="inline-flex items-center gap-2 bg-brandNavy text-white px-8 py-3 rounded-full font-bold hover:bg-brandCyan hover:text-brandNavy transition-all shadow-md">
                        <span class="material-symbols-outlined text-xl">chat</span>
                        Vrijblijvend contact
                    </a>
                </div>
            </div>
        </section>

        <!-- Diensten Sectie -->
        <section class="bg-brandCream py-20 px-6">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16 fade-in-up">
                    <h2 class="font-headline text-4xl font-bold mb-4 text-brandNavy"><?= $diensten_kop ?></h2>
                    <p class="text-gray-600 max-w-2xl mx-auto"><?= $diensten_sub ?></p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="service-card flex items-center gap-4 py-4 px-6 bg-white rounded-xl cloud-shadow cursor-pointer fade-in-up delay-100">
                        <span class="material-symbols-outlined text-brandNavy text-3xl transition-colors">home_work</span>
                        <span class="service-text text-lg font-medium text-brandNavy transition-colors">Volledige ontruiming</span>
                    </div>
                    <div class="service-card flex items-center gap-4 py-4 px-6 bg-white rounded-xl cloud-shadow cursor-pointer fade-in-up delay-200">
                        <span class="material-symbols-outlined text-brandNavy text-3xl transition-colors">garage</span>
                        <span class="service-text text-lg font-medium text-brandNavy transition-colors">Garageontruiming</span>
                    </div>
                    <div class="service-card flex items-center gap-4 py-4 px-6 bg-white rounded-xl cloud-shadow cursor-pointer fade-in-up delay-300">
                        <span class="material-symbols-outlined text-brandNavy text-3xl transition-colors">home</span>
                        <span class="service-text text-lg font-medium text-brandNavy transition-colors">Woningontruiming</span>
                    </div>
                    <div class="service-card flex items-center gap-4 py-4 px-6 bg-white rounded-xl cloud-shadow cursor-pointer fade-in-up delay-400">
                        <span class="material-symbols-outlined text-brandNavy text-3xl transition-colors">sentiment_calm</span>
                        <span class="service-text text-lg font-medium text-brandNavy transition-colors">Emotionele Begeleiding</span>
                    </div>
                    <div class="service-card flex items-center gap-4 py-4 px-6 bg-white rounded-xl cloud-shadow cursor-pointer fade-in-up delay-100">
                        <span class="material-symbols-outlined text-brandNavy text-3xl transition-colors">swap_horiz</span>
                        <span class="service-text text-lg font-medium text-brandNavy transition-colors">Sorteren & Herbestemmen</span>
                    </div>
                    <div class="service-card flex items-center gap-4 py-4 px-6 bg-white rounded-xl cloud-shadow cursor-pointer fade-in-up delay-200">
                        <span class="material-symbols-outlined text-brandNavy text-3xl transition-colors">roofing</span>
                        <span class="service-text text-lg font-medium text-brandNavy transition-colors">Zolderontruiming</span>
                    </div>
                    <div class="service-card flex items-center gap-4 py-4 px-6 bg-white rounded-xl cloud-shadow cursor-pointer fade-in-up delay-300">
                        <span class="material-symbols-outlined text-brandNavy text-3xl transition-colors">favorite</span>
                        <span class="service-text text-lg font-medium text-brandNavy transition-colors">Zorgeloos Afscheid</span>
                    </div>
                    <div class="service-card flex items-center gap-4 py-4 px-6 bg-white rounded-xl cloud-shadow cursor-pointer fade-in-up delay-400">
                        <span class="material-symbols-outlined text-brandNavy text-3xl transition-colors">mop</span>
                        <span class="service-text text-lg font-medium text-brandNavy transition-colors">Schoonmaak & Oplevering</span>
                    </div>
                </div>
                <div class="text-center mt-12 fade-in-up">
                    <a href="diensten.php" class="inline-block border-2 border-brandNavy text-brandNavy px-8 py-3 rounded-full font-bold hover:bg-brandNavy hover:text-white transition-all hover:scale-105">
                        Bekijk alle diensten
                    </a>
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
                        <div class="w-16 h-16 bg-brandGreen text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-6 cloud-shadow">3</div>
                        <h3 class="font-headline text-xl font-bold text-brandNavy mb-3"><?= $stap3_kop ?></h3>
                        <p class="text-gray-600"><?= $stap3_tekst ?></p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Trust badges balk -->
        <section class="bg-brandNavy py-8 px-6">
            <div class="max-w-5xl mx-auto">
                <div class="grid grid-cols-2 md:grid-cols-5 gap-6 text-center text-white">
                    <div class="fade-in-up">
                        <span class="material-symbols-outlined text-brandCyan text-3xl mb-1 block">store</span>
                        <p class="text-xs font-bold uppercase tracking-wide text-white/80">KvK geregistreerd</p>
                    </div>
                    <div class="fade-in-up delay-100">
                        <span class="material-symbols-outlined text-brandCyan text-3xl mb-1 block">shield</span>
                        <p class="text-xs font-bold uppercase tracking-wide text-white/80">Verzekerd</p>
                    </div>
                    <div class="fade-in-up delay-200">
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

                <!-- Contact Column -->
                <div class="fade-in-right delay-200">
                    <h2 class="font-headline text-3xl font-bold mb-6 text-brandNavy">Direct contact</h2>
                    <div class="bg-white p-8 rounded-2xl cloud-shadow">
                        <div class="space-y-4">
                            <a href="<?= $tel_href ?>" class="flex items-center gap-4 p-4 rounded-xl hover:bg-brandCyan/10 transition-colors group">
                                <div class="w-12 h-12 bg-brandNavy rounded-full flex items-center justify-center group-hover:bg-brandCyan transition-colors">
                                    <span class="material-symbols-outlined text-white text-xl">call</span>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Bel direct</p>
                                    <p class="font-bold text-brandNavy"><?= $telefoon ?></p>
                                </div>
                            </a>
                            <a href="<?= $wa_url ?>" target="_blank" rel="noopener" class="flex items-center gap-4 p-4 rounded-xl hover:bg-green-50 transition-colors group">
                                <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">WhatsApp</p>
                                    <p class="font-bold text-brandNavy">Stuur een bericht</p>
                                </div>
                            </a>
                            <a href="mailto:<?= htmlspecialchars($contact['email'] ?? 'info@jimruimtop.nl') ?>" class="flex items-center gap-4 p-4 rounded-xl hover:bg-brandCyan/10 transition-colors group">
                                <div class="w-12 h-12 bg-brandNavy rounded-full flex items-center justify-center group-hover:bg-brandCyan transition-colors">
                                    <span class="material-symbols-outlined text-white text-xl">mail</span>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">E-mail</p>
                                    <p class="font-bold text-brandNavy"><?= htmlspecialchars($contact['email'] ?? 'info@jimruimtop.nl') ?></p>
                                </div>
                            </a>
                        </div>
                        <div class="mt-6 pt-6 border-t border-gray-100">
                            <a href="contact.php" class="w-full bg-brandNavy text-white px-8 py-4 rounded-full font-bold text-center hover:bg-brandCyan hover:text-brandNavy transition-all block">
                                Gratis Intake Aanvragen
                            </a>
                        </div>
                    </div>
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
                        <li><a href="fotos.php" class="hover:text-white transition-colors">Foto's</a></li>
                        <li><a href="over-mij.php" class="hover:text-white transition-colors">Over Mij</a></li>
                        <li><a href="contact.php" class="hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-3 text-brandCyan uppercase text-sm tracking-wider">Locatie</h4>
                    <p class="text-white/70 text-sm"><?= t($contact, 'adres', 'Tilburg') ?></p>
                </div>
                <div>
                    <h4 class="font-bold mb-3 text-brandCyan uppercase text-sm tracking-wider">Contact</h4>
                    <p class="text-white/70 text-sm"><?= t($contact, 'adres', 'Tilburg') ?><br/><?= htmlspecialchars($contact['email'] ?? 'info@jimruimtop.nl') ?><br/>Bel: <?= $telefoon ?></p>
                </div>
                <div class="flex flex-col items-start sm:items-end">
                    <h4 class="font-bold mb-3 text-brandCyan uppercase text-sm tracking-wider">Direct contact</h4>
                    <a href="contact.php" class="bg-brandCyan text-brandNavy px-6 py-3 rounded-full font-bold hover:bg-opacity-90 transition-all">
                        Contact Aanvragen
                    </a>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto mt-12 pt-8 border-t border-white/20 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-white/50 text-sm">© 2025 Jim Ruimt Op. Alle rechten voorbehouden.</p>
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
