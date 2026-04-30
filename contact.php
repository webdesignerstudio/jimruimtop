<?php
session_start();
require_once __DIR__ . '/includes/functions.php';
check_site_vergrendeling();
$contact      = laad_json('contact.json');
$teksten      = laad_json('teksten.json');
$instellingen = laad_json('instellingen.json');
$toon_fotos   = $instellingen['toon_fotos_menu'] ?? true;
$p            = $teksten['contact'] ?? [];
$telefoon     = t($contact, 'telefoon', '06 13 94 31 86');
$tel_href     = tel_link($contact);
$wa_url       = whatsapp_url($contact);
$email        = htmlspecialchars($contact['email'] ?? 'info@jimruimt-op.nl', ENT_QUOTES, 'UTF-8');
$adres        = t($contact, 'adres', 'Tilburg');
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8"/>
    <link rel="icon" type="image/x-icon" href="/favicon.ico"/>
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png"/>
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png"/>
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png"/>
    <link rel="icon" type="image/png" sizes="192x192" href="/favicon-192x192.png"/>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png"/>
    <link rel="manifest" href="/site.webmanifest"/>
    <meta name="theme-color" content="#1A436D"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Contact | Jim Ruimt Op — Woningontruiming Tilburg</title>
    <meta name="description" content="Neem contact op met Jim voor een kennismaking. Woningontruiming in Tilburg — binnen 48 uur teruggebeld. Bel, WhatsApp of vul het formulier in."/>
    <meta name="robots" content="index, follow"/>
    <link rel="canonical" href="https://jimruimt-op.nl/contact.php"/>
    <meta property="og:title" content="Contact | Jim Ruimt Op — Woningontruiming Tilburg"/>
    <meta property="og:description" content="Kennismaking aanvragen bij Jim Ruimt Op. Woningontruiming in Tilburg — binnen 48 uur reactie."/>
    <meta property="og:url" content="https://jimruimt-op.nl/contact.php"/>
    <meta property="og:type" content="website"/>
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "Hoe snel kan Jim langskomen?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Meestal kan Jim binnen 48 uur een eerste vrijblijvende intake inplannen in de regio Tilburg."
          }
        },
        {
          "@type": "Question",
          "name": "Zijn er kosten verbonden aan de intake?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Nee, het eerste gesprek is volledig gratis en bedoeld om uw wensen en de situatie in kaart te brengen."
          }
        },
        {
          "@type": "Question",
          "name": "Werkt Jim Ruimt Op ook in het weekend?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Ja, op zaterdagochtend is Jim beschikbaar. Voor spoedgevallen is hij ook buiten kantoortijden bereikbaar."
          }
        },
        {
          "@type": "Question",
          "name": "Wat gebeurt er met waardevolle spullen bij de ontruiming?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Samen wordt besproken wat u wilt houden, verkopen, doneren of laten verwerken. Bruikbare items kunnen worden verrekend met de ontruimingskosten."
          }
        }
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
            overflow-x: hidden;
        }
        body {
            overflow-x: hidden;
        }
        
        .cloud-shadow {
            box-shadow: 0 20px 40px rgba(26, 67, 109, 0.12);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
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
        
        /* Form input focus effects */
        .form-input {
            transition: all 0.3s ease;
        }
        .form-input:focus {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(26, 67, 109, 0.15);
        }
        
        /* Contact card hover effects */
        .contact-card {
            transition: all 0.3s ease;
        }
        .contact-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(26, 67, 109, 0.15);
            border-color: #5BCEFF;
        }
        
        /* FAQ accordion effects */
        .faq-item {
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .faq-item:hover {
            transform: translateX(5px);
        }
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease, opacity 0.3s ease;
            opacity: 0;
        }
        .faq-item.active .faq-answer {
            max-height: 200px;
            opacity: 1;
        }
        .faq-item.active {
            background-color: rgba(91, 206, 255, 0.1);
        }
        
        /* Pulse animation for emergency */
        .pulse-emergency {
            animation: pulse-emergency 2s ease-in-out infinite;
        }
        
        @keyframes pulse-emergency {
            0%, 100% { box-shadow: 0 0 0 0 rgba(91, 206, 255, 0.4); }
            50% { box-shadow: 0 0 0 15px rgba(91, 206, 255, 0); }
        }
        
        /* Submit button effects */
        .submit-btn {
            transition: all 0.3s ease;
        }
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(26, 67, 109, 0.2);
        }
        .submit-btn:active {
            transform: translateY(0);
        }
        .submit-btn.loading {
            pointer-events: none;
            opacity: 0.8;
        }
        
        /* Success animation */
        .success-check {
            animation: success-pop 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        @keyframes success-pop {
            0% { transform: scale(0); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body class="bg-white font-body" style="background-color:#f0f7ff">
    <!-- Scroll Progress Bar -->
    <div id="progress-bar" style="width: 0%"></div>

    <!-- WhatsApp Floating Button -->
    <a href="<?= $wa_url ?>?text=Hallo%20Jim%2C%20ik%20heb%20een%20vraag%20over%20woningontruiming" target="_blank" rel="noopener" style="position:fixed;bottom:170px;right:30px;z-index:41;background:#25D366;color:white;width:56px;height:56px;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 20px rgba(37,211,102,0.4);transition:transform 0.2s ease;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'" aria-label="WhatsApp Jim Ruimt Op">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
    </a>

    <!-- Header -->
    <header class="w-full bg-brandNavy sticky top-0 z-50 shadow-sm">
        <nav class="flex justify-between items-center max-w-7xl mx-auto px-6 py-4">
            <a href="index.php" class="flex items-center gap-2 hover:scale-105 transition-transform">
                <img src="logo.png" alt="Jim Ruimt Op" class="w-14 h-14 object-contain"/>
            </a>
            <div class="hidden md:flex items-center space-x-8">
                <a href="index.php" class="font-headline font-bold text-white/70 hover:text-brandCyan transition-colors">Home</a>
                <a href="diensten.php" class="font-headline font-bold text-white/70 hover:text-brandCyan transition-colors">Diensten</a>
                <a href="fotos.php" class="font-headline font-bold text-white/70 hover:text-brandCyan transition-colors">Foto's</a>
                <a href="over-mij.php" class="font-headline font-bold text-white/70 hover:text-brandCyan transition-colors">Over Ons</a>
                <a href="contact.php" class="font-headline font-bold text-white border-b-2 border-brandCyan pb-1">Contact</a>
            </div>
            <div class="hidden md:flex items-center gap-4">
                <a href="<?= $tel_href ?>" class="flex items-center gap-2 text-white font-bold hover:text-brandCyan transition-colors text-sm">
                    <span class="material-symbols-outlined text-lg">call</span>
                    <span><?= $telefoon ?></span>
                </a>
                <a href="contact.php" class="bg-brandCyan text-brandNavy px-6 py-3 rounded-full font-bold hover:opacity-90 transition-all text-sm">
                    Plan een kennismaking
                </a>
            </div>
            <button id="mobile-menu-btn" class="md:hidden text-white">
                <span class="material-symbols-outlined text-3xl">menu</span>
            </button>
        </nav>
        <div id="mobile-menu" class="hidden md:hidden bg-brandNavy border-t border-white/20">
            <div class="flex flex-col px-6 py-4 space-y-4">
                <a href="index.php" class="font-headline font-bold text-white/70">Home</a>
                <a href="diensten.php" class="font-headline font-bold text-white/70">Diensten</a>
                <a href="fotos.php" class="font-headline font-bold text-white/70">Foto's</a>
                <a href="over-mij.php" class="font-headline font-bold text-white/70">Over Ons</a>
                <a href="contact.php" class="font-headline font-bold text-white">Contact</a>
                <a href="<?= $tel_href ?>" class="flex items-center gap-2 text-white font-bold text-sm">
                    <span class="material-symbols-outlined text-lg">call</span><?= $telefoon ?>
                </a>
                <a href="contact.php" class="bg-brandCyan text-brandNavy px-6 py-3 rounded-full font-bold text-center text-sm">Plan een kennismaking</a>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        <!-- Hero Section -->
        <section class="relative bg-gradient-to-br from-brandNavy to-brandNavy/80 text-white py-24 overflow-hidden">
            <div class="max-w-7xl mx-auto px-6 relative z-10">
                <div class="max-w-2xl fade-in-left">
                    <span class="font-script text-brandCyan text-3xl mb-4 block"><?= t($p, 'hero_script', 'Laten we kennismaken') ?></span>
                    <h1 class="font-headline text-5xl md:text-6xl font-bold leading-tight tracking-tight mb-6"><?= t($p, 'hero_kop', 'Een schone lei begint met een goed gesprek.') ?></h1>
                    <p class="text-white/80 text-lg md:text-xl font-medium leading-relaxed mb-8">
                        <?= t($p, 'hero_subtekst', 'Zet vandaag de eerste stap naar rust en overzicht. Mijn kennismaking is altijd vrijblijvend en op uw tempo.') ?>
                    </p>
                </div>
            </div>
            <!-- Decorative Element -->
            <div class="absolute right-0 top-0 w-1/3 h-full opacity-10 pointer-events-none">
                <div class="w-full h-full bg-brandCyan/30 rounded-l-full"></div>
            </div>
        </section>

        <!-- Main Contact Canvas -->
        <section class="max-w-7xl mx-auto px-6 py-20 -mt-16 relative z-20">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                <!-- Contact Form Card -->
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
                    <form id="contact-form" class="space-y-6" action="#" method="POST">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="name" class="block font-headline text-sm font-bold text-gray-600">Volledige Naam *</label>
                                <input type="text" id="name" name="name" placeholder="Uw naam" required class="form-input w-full bg-white border border-gray-200 rounded-xl p-4 focus:ring-2 focus:ring-brandNavy"/>
                            </div>
                            <div class="space-y-2">
                                <label for="email" class="block font-headline text-sm font-bold text-gray-600">E-mailadres *</label>
                                <input type="email" id="email" name="email" placeholder="uw@email.nl" required class="form-input w-full bg-white border border-gray-200 rounded-xl p-4 focus:ring-2 focus:ring-brandNavy"/>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label for="phone" class="block font-headline text-sm font-bold text-gray-600">Telefoonnummer</label>
                            <input type="tel" id="phone" name="phone" placeholder="06 1234 5678" class="form-input w-full bg-white border border-gray-200 rounded-xl p-4 focus:ring-2 focus:ring-brandNavy"/>
                        </div>
                        <div class="space-y-2">
                            <label for="subject" class="block font-headline text-sm font-bold text-gray-600">Onderwerp</label>
                            <select id="subject" name="subject" class="form-input w-full bg-white border border-gray-200 rounded-xl p-4 focus:ring-2 focus:ring-brandNavy">
                                <option value="" disabled selected>Kies een onderwerp...</option>
                                <option value="intake">Kennismaking inplannen</option>
                                <option value="basis">BASIS — Complete ontruiming</option>
                                <option value="begeleid">BEGELEID — Met aandacht en rust</option>
                                <option value="voorbereid">VOORBEREID & GEREGELD</option>
                                <option value="opruimen">OPRUIMEN & OVERZICHT</option>
                                <option value="spoed">Spoedontruiming</option>
                                <option value="maatwer">Maatwerk / andere situatie</option>
                                <option value="vraag">Algemene vraag</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label for="message" class="block font-headline text-sm font-bold text-gray-600">Bericht *</label>
                            <textarea id="message" name="message" placeholder="Vertel kort waarmee Jim u kan helpen..." rows="5" required class="form-input w-full bg-white border border-gray-200 rounded-xl p-4 focus:ring-2 focus:ring-brandNavy"></textarea>
                        </div>
                        <button type="submit" id="submit-btn" class="submit-btn w-full md:w-auto bg-brandNavy text-white px-12 py-4 rounded-xl font-headline font-bold uppercase tracking-widest text-sm hover:bg-brandCyan hover:text-brandNavy transition-all shadow-lg flex items-center justify-center gap-2">
                            <span>Bericht Verzenden</span>
                            <span class="material-symbols-outlined">send</span>
                        </button>
                    </form>
                </div>

                <!-- Contact Details Column -->
                <div class="lg:col-span-5 space-y-8 fade-in-right delay-200">
                    <!-- Jim's Personal Note -->
                    <div class="bg-white p-8 rounded-2xl relative overflow-hidden cloud-shadow">
                        <span class="material-symbols-outlined text-4xl text-brandNavy mb-4">forum</span>
                        <h3 class="font-headline text-2xl font-bold text-brandNavy mb-4">Direct contact met Jim</h3>
                        <p class="text-gray-600 leading-relaxed mb-6">
                            "<?= t($p, 'jim_quote', 'Geen ingewikkelde procedures of lange wachtlijsten. Ik sta u graag persoonlijk te woord om te kijken hoe ik weer ruimte kan maken in uw leven.') ?>"
                        </p>
                        <div class="font-script text-2xl text-brandNavy">- Jim</div>
                    </div>

                    <!-- Details Bento -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <a href="<?= $tel_href ?>" class="contact-card bg-white p-6 rounded-xl border-b-2 border-transparent hover:border-brandCyan transition-all block cloud-shadow">
                            <div class="icon-container w-12 h-12 bg-brandNavy/10 rounded-full flex items-center justify-center mb-3 transition-colors">
                                <span class="material-symbols-outlined text-2xl text-brandNavy transition-colors">call</span>
                            </div>
                            <div class="font-headline text-xs font-bold text-gray-400 uppercase tracking-tighter">Telefoon</div>
                            <div class="text-brandNavy font-bold"><?= $telefoon ?></div>
                        </a>
                        <a href="<?= $wa_url ?>" target="_blank" rel="noopener" class="contact-card bg-white p-6 rounded-xl border-b-2 border-transparent hover:border-brandCyan transition-all block cloud-shadow">
                            <div class="icon-container w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-3 transition-colors">
                                <span class="material-symbols-outlined text-2xl transition-colors" style="color:#25D366">chat</span>
                            </div>
                            <div class="font-headline text-xs font-bold text-gray-400 uppercase tracking-tighter">WhatsApp</div>
                            <div class="text-brandNavy font-bold">Direct sturen</div>
                        </a>
                        <a href="mailto:<?= $email ?>" class="contact-card bg-white p-6 rounded-xl border-b-2 border-transparent hover:border-brandCyan transition-all block cloud-shadow">
                            <div class="icon-container w-12 h-12 bg-brandNavy/10 rounded-full flex items-center justify-center mb-3 transition-colors">
                                <span class="material-symbols-outlined text-2xl text-brandNavy transition-colors">mail</span>
                            </div>
                            <div class="font-headline text-xs font-bold text-gray-400 uppercase tracking-tighter">E-mail</div>
                            <div class="text-brandNavy font-bold"><?= $email ?></div>
                        </a>
                        <div class="contact-card bg-white p-6 rounded-xl border-b-2 border-transparent cloud-shadow">
                            <div class="icon-container w-12 h-12 bg-brandNavy/10 rounded-full flex items-center justify-center mb-3 transition-colors">
                                <span class="material-symbols-outlined text-2xl text-brandNavy transition-colors">location_on</span>
                            </div>
                            <div class="font-headline text-xs font-bold text-gray-400 uppercase tracking-tighter">Werkgebied</div>
                            <div class="text-brandNavy font-bold"><?= t($contact, 'werkgebied', 'Tilburg &amp; omstreken') ?></div>
                        </div>
                    </div>

                    <!-- Opening Hours -->
                    <div class="bg-brandNavy text-white p-6 rounded-2xl">
                        <h4 class="font-headline font-bold mb-4 text-brandCyan">Openingstijden</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-white/70">Maandag - Vrijdag</span>
                                <span><?= htmlspecialchars($contact['openingstijden']['maandag_vrijdag'] ?? '08:00 - 18:00', ENT_QUOTES, 'UTF-8') ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-white/70">Zaterdag</span>
                                <span><?= htmlspecialchars($contact['openingstijden']['zaterdag'] ?? '09:00 - 14:00', ENT_QUOTES, 'UTF-8') ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-white/70">Zondag</span>
                                <span><?= htmlspecialchars($contact['openingstijden']['zondag'] ?? 'Gesloten', ENT_QUOTES, 'UTF-8') ?></span>
                            </div>
                        </div>
                        <p class="text-xs text-white/50 mt-4">* Ook buiten kantoortijden bereikbaar voor spoed</p>
                    </div>

                    <!-- Google Maps Embed -->
                    <div class="rounded-2xl overflow-hidden cloud-shadow h-64 scale-in delay-400">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d39558.94!2d5.0913!3d51.5555!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c6bfdeab0e6c4b%3A0x7bf46a4756dc9f67!2sTilburg!5e0!3m2!1snl!2snl!4v1"
                            width="100%" height="256" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Werkgebied Jim Ruimt Op — Tilburg en omstreken"
                            aria-label="Google Maps kaart van Tilburg, werkgebied Jim Ruimt Op"></iframe>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ / Call to Action -->
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
                            <p class="text-gray-600 text-sm mt-3">Meestal kan ik binnen 48 uur een eerste vrijblijvende kennismaking inplannen in de regio Tilburg.</p>
                        </div>
                    </div>
                    <div class="faq-item bg-white p-6 rounded-xl cloud-shadow fade-in-up delay-200" onclick="toggleFaq(this)">
                        <div class="flex justify-between items-center">
                            <h4 class="font-headline font-bold text-brandNavy">Zijn er kosten verbonden aan de kennismaking?</h4>
                            <span class="material-symbols-outlined text-brandNavy transition-transform">expand_more</span>
                        </div>
                        <div class="faq-answer">
                            <p class="text-gray-600 text-sm mt-3">Nee, het eerste gesprek is volledig vrijblijvend en bedoeld om uw wensen en de situatie in kaart te brengen.</p>
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

        <!-- Emergency CTA -->
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
                    <p class="text-white/70 text-sm">Specialist in ontruiming & ontzorging in regio Tilburg.</p>
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
                        <li><a href="/woningontruiming-berkel-enschot" class="hover:text-white transition-colors">Berkel-Enschot</a></li>
                        <li><a href="/woningontruiming-oisterwijk" class="hover:text-white transition-colors">Oisterwijk</a></li>
                        <li><a href="/woningontruiming-goirle" class="hover:text-white transition-colors">Goirle</a></li>
                        <li><a href="/woningontruiming-hilvarenbeek" class="hover:text-white transition-colors">Hilvarenbeek</a></li>
                        <li><a href="/woningontruiming-udenhout" class="hover:text-white transition-colors">Udenhout</a></li>
                    </ul>
                </div>
                <!-- Kolom 4: Contact -->
                <div>
                    <h4 class="font-bold mb-3 text-brandCyan uppercase text-sm tracking-wider">Contact</h4>
                    <p class="text-white/70 text-sm"><?= $adres ?><br/><?= $email ?><br/>Bel: <?= $telefoon ?></p>
                </div>
                <!-- Kolom 5: Direct contact -->
                <div class="col-span-2 md:col-span-1 flex flex-col items-start md:items-end">
                    <h4 class="font-bold mb-3 text-brandCyan uppercase text-sm tracking-wider">Direct contact</h4>
                    <a href="contact.php" class="bg-brandCyan text-brandNavy px-6 py-3 rounded-full font-bold hover:bg-opacity-90 transition-all text-sm md:text-base text-center w-full md:w-auto">
                        Contact Aanvragen
                    </a>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto mt-12 pt-8 border-t border-white/20 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-white/50 text-sm">© 2026 Jim Ruimt Op. Alle rechten voorbehouden.</p>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });

        // Scroll Progress Bar
        function updateProgressBar() {
            const scrollTop = window.scrollY;
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;
            const progress = (scrollTop / docHeight) * 100;
            document.getElementById('progress-bar').style.width = progress + '%';
        }
        window.addEventListener('scroll', updateProgressBar);

        // Intersection Observer for fade-in animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fade-in-up, .fade-in-left, .fade-in-right, .scale-in').forEach(el => {
            observer.observe(el);
        });

        // Voorinvullen dropdown via URL-parameter ?onderwerp=
        (function() {
            const params = new URLSearchParams(window.location.search);
            const onderwerp = params.get('onderwerp');
            if (onderwerp) {
                const select = document.getElementById('subject');
                if (select) {
                    const opt = select.querySelector('option[value="' + onderwerp + '"]');
                    if (opt) { opt.selected = true; }
                }
            }
        })();

        // FAQ Toggle
        function toggleFaq(item) {
            const isActive = item.classList.contains('active');
            
            // Close all FAQ items
            document.querySelectorAll('.faq-item').forEach(faq => {
                faq.classList.remove('active');
                faq.querySelector('.material-symbols-outlined').style.transform = 'rotate(0deg)';
            });
            
            // Open clicked item if it wasn't active
            if (!isActive) {
                item.classList.add('active');
                item.querySelector('.material-symbols-outlined').style.transform = 'rotate(180deg)';
            }
        }

        // Form handling with validation
        document.getElementById('contact-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = document.getElementById('submit-btn');
            const originalText = btn.innerHTML;
            
            // Validation
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const message = document.getElementById('message').value.trim();
            
            if (!name || !email || !message) {
                btn.innerHTML = '<span class="material-symbols-outlined">error</span> Vul alle verplichte velden in';
                btn.classList.remove('bg-brandNavy');
                btn.classList.add('bg-red-500');
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.classList.remove('bg-red-500');
                    btn.classList.add('bg-brandNavy');
                }, 2000);
                return;
            }
            
            btn.classList.add('loading');
            btn.innerHTML = '<span class="material-symbols-outlined animate-spin">refresh</span> Verzenden...';
            
            // Simulate form submission
            setTimeout(() => {
                btn.innerHTML = '<span class="material-symbols-outlined success-check">check_circle</span> Verzonden!';
                btn.classList.remove('bg-brandNavy', 'loading');
                btn.classList.add('bg-brandGreen');
                
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.classList.remove('bg-brandGreen');
                    btn.classList.add('bg-brandNavy');
                    this.reset();
                }, 3000);
            }, 1500);
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });

        // Initialize on load
        document.addEventListener('DOMContentLoaded', () => {
            updateProgressBar();
        });
    </script>
</body>
</html>
