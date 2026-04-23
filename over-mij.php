<?php
require_once __DIR__ . '/includes/functions.php';
$contact      = laad_json('contact.json');
$teksten      = laad_json('teksten.json');
$instellingen = laad_json('instellingen.json');
$toon_fotos   = $instellingen['toon_fotos_menu'] ?? true;
$p            = $teksten['over_mij'] ?? [];

$telefoon     = t($contact, 'telefoon', '06 13 94 31 86');
$tel_href     = tel_link($contact);
$wa_url       = whatsapp_url($contact);
$hero_script  = t($p, 'hero_script', 'Gedreven door zorg');
$hero_kop     = t($p, 'hero_kop', 'Het Gezicht Achter De Rust.');
$hero_sub     = t($p, 'hero_subtekst', 'In Tilburg en omstreken help ik mensen bij de meest kwetsbare transities in hun leven.');
$verhaal_kop  = t($p, 'verhaal_kop', 'Waarom dit bedrijf bestaat');
$verhaal1     = t($p, 'verhaal_tekst_1', 'Dit bedrijf is ontstaan vanuit een persoonlijke ervaring.');
$verhaal2     = t($p, 'verhaal_tekst_2', 'Families verdienen ondersteuning die verder gaat dan alleen spullen weggooiën.');
$belofte_kop  = t($p, 'belofte_kop', 'Mijn Belofte aan U');
$belofte1     = t($p, 'belofte_1', 'Altijd een luisterend oor voor uw verhaal.');
$belofte2     = t($p, 'belofte_2', 'Zorgvuldige afhandeling van persoonlijke eigendommen.');
$belofte3     = t($p, 'belofte_3', 'Een resultaat dat direct rust en overzicht geeft.');
$ww_kop       = t($p, 'werkwijze_kop', 'Mijn Werkwijze in Tilburg');
$ww_sub       = t($p, 'werkwijze_subtekst', 'De waarden die de basis vormen van elke woningontruiming.');
$w1_kop       = t($p, 'waarde1_kop', 'Empathie');
$w1_tekst     = t($p, 'waarde1_tekst', 'Ik begrijp de emotionele lading van een afscheid of verhuizing. Ik werk met mijn hart.');
$w2_kop       = t($p, 'waarde2_kop', 'Discretie');
$w2_tekst     = t($p, 'waarde2_tekst', 'Uw privacy is heilig. Wat er in huis gebeurt en wat we tegenkomen, blijft tussen ons.');
$w3_kop       = t($p, 'waarde3_kop', 'Structuur');
$w3_tekst     = t($p, 'waarde3_tekst', 'Waar anderen chaos zien, zie ik een logisch proces om orde en rust te herstellen.');
$quote_jim    = t($p, 'quote_jim', 'Ik kijk ernaar uit om u te ontmoeten en samen een plan te maken dat bij u past.');
$kvk          = t($p, 'kvk_nummer', '87654321');
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Over Jim | Woningontruiming Tilburg met hart & zorg</title>
    <meta name="description" content="Maak kennis met Jim — oprichter van Jim Ruimt Op. Zijn persoonlijke verhaal, werkwijze en belofte aan senioren en nabestaanden in Tilburg en omstreken."/>
    <meta name="robots" content="index, follow"/>
    <link rel="canonical" href="https://www.jimruimtop.nl/over-mij.php"/>
    <meta property="og:title" content="Over Jim | Woningontruiming Tilburg met hart & zorg"/>
    <meta property="og:description" content="Jim helpt senioren en nabestaanden bij woningontruiming in Tilburg. Empathisch, discreet en persoonlijk. Lees zijn verhaal."/>
    <meta property="og:url" content="https://www.jimruimtop.nl/over-mij.php"/>
    <meta property="og:type" content="website"/>
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
        #progress-bar { position: fixed; top: 0; left: 0; height: 3px; background: linear-gradient(90deg, #5BCEFF, #1A436D); z-index: 9999; transition: width 0.1s ease; }
        html { scroll-behavior: smooth; }
        .cloud-shadow { box-shadow: 0 20px 40px rgba(26, 67, 109, 0.12); }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .fade-in-up { opacity: 0; transform: translateY(30px); transition: opacity 0.6s ease, transform 0.6s ease; }
        .fade-in-up.visible { opacity: 1; transform: translateY(0); }
        .fade-in-left { opacity: 0; transform: translateX(-30px); transition: opacity 0.6s ease, transform 0.6s ease; }
        .fade-in-left.visible { opacity: 1; transform: translateX(0); }
        .fade-in-right { opacity: 0; transform: translateX(30px); transition: opacity 0.6s ease, transform 0.6s ease; }
        .fade-in-right.visible { opacity: 1; transform: translateX(0); }
        .scale-in { opacity: 0; transform: scale(0.9); transition: opacity 0.5s ease, transform 0.5s ease; }
        .scale-in.visible { opacity: 1; transform: scale(1); }
        .delay-100 { transition-delay: 0.1s; }
        .delay-200 { transition-delay: 0.2s; }
        .delay-300 { transition-delay: 0.3s; }
        .delay-400 { transition-delay: 0.4s; }
        .floating-cta { position: fixed; bottom: 24px; right: 16px; z-index: 40; animation: float 3s ease-in-out infinite; }
        @media (min-width: 640px) { .floating-cta { bottom: 30px; right: 30px; } }
        .wa-float-btn { position:fixed;bottom:90px;right:16px;z-index:41;background:#25D366;color:white;width:52px;height:52px;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 20px rgba(37,211,102,0.4);transition:transform 0.2s ease; }
        .wa-float-btn:hover { transform:scale(1.1); }
        @media (min-width: 640px) { .wa-float-btn { bottom:110px;right:30px;width:56px;height:56px; } }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        .pulse-glow { animation: pulse-glow 2s ease-in-out infinite; }
        @keyframes pulse-glow { 0%, 100% { box-shadow: 0 0 0 0 rgba(91,206,255,0.4); } 50% { box-shadow: 0 0 20px 10px rgba(91,206,255,0.2); } }
        .img-hover-zoom { overflow: hidden; transition: transform 0.5s ease; }
        .img-hover-zoom:hover { transform: scale(1.02); }
        .img-hover-zoom img { transition: transform 0.5s ease; }
        .img-hover-zoom:hover img { transform: scale(1.05); }
        .value-card { transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        .value-card:hover { transform: translateY(-10px); box-shadow: 0 25px 50px rgba(26, 67, 109, 0.2); }
        .quote-float { animation: quote-float 4s ease-in-out infinite; }
        @keyframes quote-float { 0%, 100% { transform: translateY(0) rotate(-2deg); } 50% { transform: translateY(-8px) rotate(2deg); } }
    </style>
</head>
<body class="bg-white font-body" style="background-color:#f0f7ff">
    <div id="progress-bar" style="width: 0%"></div>
    
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
                <a href="index.php" class="font-headline font-bold text-white/70 hover:text-brandCyan transition-colors">Home</a>
                <a href="diensten.php" class="font-headline font-bold text-white/70 hover:text-brandCyan transition-colors">Diensten</a>
                <?php if ($toon_fotos): ?><a href="fotos.php" class="font-headline font-bold text-white/70 hover:text-brandCyan transition-colors">Foto's</a><?php endif; ?>
                <a href="over-mij.php" class="font-headline font-bold text-white border-b-2 border-brandCyan pb-1">Over Mij</a>
                <a href="contact.php" class="font-headline font-bold text-white/70 hover:text-brandCyan transition-colors">Contact</a>
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
                <a href="over-mij.php" class="font-headline font-bold text-white">Over Mij</a>
                <a href="contact.php" class="font-headline font-bold text-white/70">Contact</a>
                <a href="<?= $tel_href ?>" class="flex items-center gap-2 text-white font-bold text-sm">
                    <span class="material-symbols-outlined text-lg">call</span><?= $telefoon ?>
                </a>
                <a href="contact.php" class="bg-brandCyan text-brandNavy px-6 py-3 rounded-full font-bold text-center text-sm">Gratis Intake</a>
            </div>
        </div>
    </header>

    <main>
        <section class="relative overflow-hidden pt-20 pb-32 px-6">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center gap-16">
                <div class="w-full md:w-1/2 z-10 fade-in-left">
                    <span class="font-script text-brandCyan text-3xl mb-4 block"><?= $hero_script ?></span>
                    <h1 class="font-headline text-5xl md:text-6xl font-bold text-brandNavy leading-tight mb-6 break-words">
                        <?= $hero_kop ?>
                    </h1>
                    <p class="text-lg text-gray-600 max-w-xl leading-relaxed mb-8"><?= $hero_sub ?></p>
                    <div class="flex items-center gap-4">
                        <img src="herofoto.jpg" alt="Jim, oprichter Jim Ruimt Op Tilburg" class="w-16 h-16 rounded-full object-cover border-4 border-white"/>
                        <div>
                            <p class="font-bold text-brandNavy">Jim</p>
                            <p class="text-sm text-gray-500">Oprichter & Specialist</p>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-1/2 relative fade-in-right delay-200">
                    <div class="absolute -top-10 -left-10 w-64 h-64 bg-brandCyan/20 rounded-full blur-3xl"></div>
                    <div class="relative rounded-2xl overflow-hidden cloud-shadow border-8 border-white rotate-2 img-hover-zoom">
                        <img src="file_26---05787c6d-5a2f-4a29-a396-a37570acc71c.jpg" alt="Jim tijdens een woningontruiming in Tilburg" class="w-full h-auto object-cover"/>
                    </div>
                    <div class="absolute -bottom-6 -right-6 bg-white p-6 rounded-xl cloud-shadow max-w-xs hidden md:block quote-float">
                        <p class="text-sm font-semibold text-brandNavy italic">"Ruimte creëren in huis is ruimte creëren in het hoofd."</p>
                        <p class="text-xs text-gray-500 mt-1">— Jim</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-brandNavy py-24 px-6">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-16 fade-in-up">
                    <div class="bg-white rounded-xl p-5 text-center cloud-shadow">
                        <span class="material-symbols-outlined text-brandNavy text-2xl mb-2">store</span>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">KvK</p>
                        <p class="text-brandNavy font-bold text-sm"><?= $kvk ?></p>
                    </div>
                    <div class="bg-white rounded-xl p-5 text-center cloud-shadow">
                        <span class="material-symbols-outlined text-brandNavy text-2xl mb-2">location_on</span>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Gevestigd</p>
                        <p class="text-brandNavy font-bold text-sm"><?= t($contact, 'adres', 'Tilburg') ?></p>
                    </div>
                    <div class="bg-white rounded-xl p-5 text-center cloud-shadow">
                        <span class="material-symbols-outlined text-brandNavy text-2xl mb-2">verified</span>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Specialisme</p>
                        <p class="text-brandNavy font-bold text-sm">Senioren & nabestaanden</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-12 items-start">
                    <div class="md:col-span-5 order-2 md:order-1 fade-in-left">
                        <div class="space-y-12">
                            <div>
                                <h2 class="font-headline text-3xl font-bold text-white mb-6"><?= $verhaal_kop ?></h2>
                                <p class="text-white/90 leading-relaxed mb-4"><?= $verhaal1 ?></p>
                                <p class="text-white/90 leading-relaxed"><?= $verhaal2 ?></p>
                            </div>
                            <div class="bg-white p-8 rounded-xl cloud-shadow border-l-4 border-brandCyan">
                                <h3 class="font-headline text-xl font-bold text-brandNavy mb-4"><?= $belofte_kop ?></h3>
                                <ul class="space-y-4">
                                    <li class="flex items-start gap-3">
                                        <span class="material-symbols-outlined text-brandCyan">check_circle</span>
                                        <span class="text-sm text-gray-600"><?= $belofte1 ?></span>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <span class="material-symbols-outlined text-brandCyan">check_circle</span>
                                        <span class="text-sm text-gray-600"><?= $belofte2 ?></span>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <span class="material-symbols-outlined text-brandCyan">check_circle</span>
                                        <span class="text-sm text-gray-600"><?= $belofte3 ?></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="md:col-span-7 order-1 md:order-2 relative h-[400px] md:h-[500px] fade-in-right delay-200">
                        <img src="herofoto.jpg" alt="Jim helpt bij het zorgvuldig sorteren van inboedel na overlijden" class="w-full h-full object-cover rounded-xl grayscale-[20%] img-hover-zoom"/>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-24 px-6">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16 fade-in-up">
                    <h2 class="font-headline text-4xl font-bold text-brandNavy mb-4"><?= $ww_kop ?></h2>
                    <p class="text-gray-600 max-w-2xl mx-auto"><?= $ww_sub ?></p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="value-card bg-white p-10 rounded-xl hover:bg-brandCyan/10 transition-colors duration-500 group fade-in-up delay-100">
                        <div class="w-12 h-12 bg-brandNavy rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-white">favorite</span>
                        </div>
                        <h3 class="font-headline text-2xl font-bold text-brandNavy mb-4"><?= $w1_kop ?></h3>
                        <p class="text-gray-600 group-hover:text-brandNavy transition-colors"><?= $w1_tekst ?></p>
                    </div>
                    <div class="value-card bg-brandNavy p-10 rounded-xl text-white transition-transform hover:-translate-y-2 fade-in-up delay-200">
                        <div class="w-12 h-12 bg-brandCyan rounded-full flex items-center justify-center mb-6">
                            <span class="material-symbols-outlined text-brandNavy">shield_with_heart</span>
                        </div>
                        <h3 class="font-headline text-2xl font-bold mb-4"><?= $w2_kop ?></h3>
                        <p class="text-white/80"><?= $w2_tekst ?></p>
                    </div>
                    <div class="value-card bg-white p-10 rounded-xl hover:bg-brandCyan/10 transition-colors duration-500 group fade-in-up delay-300">
                        <div class="w-12 h-12 bg-brandNavy rounded-full flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-white">psychology</span>
                        </div>
                        <h3 class="font-headline text-2xl font-bold text-brandNavy mb-4"><?= $w3_kop ?></h3>
                        <p class="text-gray-600 group-hover:text-brandNavy transition-colors"><?= $w3_tekst ?></p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-24 px-6">
            <div class="max-w-4xl mx-auto text-center fade-in-up">
                <span class="font-script text-brandCyan text-4xl mb-6 block">Klaar voor een schone start?</span>
                <h2 class="font-headline text-4xl font-bold text-brandNavy mb-8">Laten we samen die eerste stap zetten.</h2>
                <div class="flex flex-col md:flex-row items-center justify-center gap-6">
                    <a href="contact.php" class="bg-brandGreen text-white px-10 py-5 rounded-full font-bold text-lg hover:bg-brandNavy transition-all shadow-lg pulse-glow">
                        Maak een afspraak
                    </a>
                    <a href="diensten.php" class="text-brandNavy font-bold border-b-2 border-brandNavy pb-1 hover:text-brandCyan hover:border-brandCyan transition-colors">
                        Bekijk mijn diensten
                    </a>
                </div>
                <div class="mt-16 border-t border-gray-200 pt-8 fade-in-up delay-200">
                    <p class="text-sm italic text-gray-500">"<?= $quote_jim ?>"</p>
                    <p class="font-script text-2xl text-brandNavy mt-2">Jim</p>
                </div>
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
                    <p class="text-white/70 text-sm"><?= t($contact, 'adres', 'Tilburg') ?><br/><?= htmlspecialchars($contact['email'] ?? 'info@jimruimt-op.nl') ?><br/>Bel: <?= $telefoon ?></p>
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
        document.addEventListener('DOMContentLoaded', () => { updateProgressBar(); });
    </script>
</body>
</html>
