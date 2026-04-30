<?php
require_once __DIR__ . '/includes/functions.php';
$contact      = laad_json('contact.json');
$teksten      = laad_json('teksten.json');
$instellingen = laad_json('instellingen.json');
$toon_fotos   = $instellingen['toon_fotos_menu'] ?? true;
$p            = $teksten['fotos'] ?? [];
$gallerij     = laad_json('gallerij.json');
$fotos        = $gallerij['fotos'] ?? [];
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
    <title>Foto's & Resultaten | Jim Ruimt Op — Woningontruiming Tilburg</title>
    <meta name="description" content="Bekijk foto's van woningontruimingen in Tilburg door Jim Ruimt Op. Voor- en nafoto's tonen het verschil — van vol naar leeg en bezemschoon."/>
    <meta name="robots" content="index, follow"/>
    <link rel="canonical" href="https://jimruimt-op.nl/fotos.php"/>
    <meta property="og:title" content="Foto's & Resultaten | Jim Ruimt Op"/>
    <meta property="og:description" content="Voor- en nafoto's van woningontruimingen in Tilburg. Zie het verschil dat Jim maakt."/>
    <meta property="og:url" content="https://jimruimt-op.nl/fotos.php"/>
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
        html { scroll-behavior: smooth; }
        #progress-bar {
            position: fixed; top: 0; left: 0; height: 3px;
            background: linear-gradient(90deg, #5BCEFF, #1A436D);
            z-index: 9999; transition: width 0.1s ease;
        }
        .floating-cta {
            position: fixed; bottom: 30px; right: 30px; z-index: 40;
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .pulse-glow { animation: pulse-glow 2s ease-in-out infinite; }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(91,206,255,0.4); }
            50% { box-shadow: 0 0 20px 10px rgba(91,206,255,0.2); }
        }
        .whatsapp-btn {
            position: fixed; bottom: 170px; right: 30px; z-index: 41;
            background: #25D366; color: white; width: 56px; height: 56px;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 20px rgba(37,211,102,0.4); transition: transform 0.2s ease;
        }
        .whatsapp-btn:hover { transform: scale(1.1); }
        .cloud-shadow { box-shadow: 0 8px 32px rgba(26,67,109,0.10); }

        /* Voor/Na Slider */
        .before-after-container {
            position: relative; overflow: hidden; border-radius: 1rem;
            cursor: col-resize; user-select: none; touch-action: none;
        }
        .before-after-container img {
            display: block; width: 100%; height: 100%; object-fit: cover;
        }
        .ba-after {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        }
        .ba-after img {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            object-fit: cover;
        }
        .ba-clip {
            position: absolute; top: 0; left: 0; width: 50%; height: 100%;
            overflow: hidden;
        }
        .ba-clip img {
            position: absolute; top: 0; left: 0;
            width: var(--container-width, 100%);
            height: 100%; object-fit: cover;
        }
        .ba-handle {
            position: absolute; top: 0; left: 50%;
            transform: translateX(-50%);
            width: 4px; height: 100%; background: white;
            z-index: 10; cursor: col-resize;
        }
        .ba-handle::before {
            content: '';
            position: absolute; top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            width: 44px; height: 44px; border-radius: 50%;
            background: white; box-shadow: 0 2px 12px rgba(0,0,0,0.25);
        }
        .ba-handle::after {
            content: '◀ ▶';
            position: absolute; top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            font-size: 10px; color: #1A436D; font-weight: bold;
            letter-spacing: -1px; white-space: nowrap; z-index: 1;
        }
        .ba-label {
            position: absolute; top: 12px;
            background: rgba(26,67,109,0.85); color: white;
            font-size: 11px; font-weight: 700; padding: 4px 10px;
            border-radius: 20px; letter-spacing: 0.05em; text-transform: uppercase;
        }
        .ba-label-voor { left: 12px; }
        .ba-label-na { right: 12px; }

        /* Gallerij grid */
        .gallery-grid {
            columns: 1;
            column-gap: 1rem;
        }
        @media (min-width: 640px) { .gallery-grid { columns: 2; } }
        @media (min-width: 1024px) { .gallery-grid { columns: 3; } }
        .gallery-item {
            break-inside: avoid;
            margin-bottom: 1rem;
            border-radius: 0.75rem;
            overflow: hidden;
            position: relative;
            cursor: pointer;
        }
        .gallery-item img {
            width: 100%; display: block;
            transition: transform 0.4s ease;
        }
        .gallery-item:hover img { transform: scale(1.04); }
        .gallery-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(26,67,109,0.6) 0%, transparent 50%);
            opacity: 0; transition: opacity 0.3s ease;
            display: flex; align-items: flex-end; padding: 1rem;
        }
        .gallery-item:hover .gallery-overlay { opacity: 1; }

        /* Lightbox */
        .lightbox {
            display: none; position: fixed; inset: 0; z-index: 100;
            background: rgba(0,0,0,0.92); align-items: center; justify-content: center;
        }
        .lightbox.open { display: flex; }
        .lightbox img { max-width: 90vw; max-height: 85vh; border-radius: 0.5rem; object-fit: contain; }

        .fade-in-up { opacity: 0; transform: translateY(24px); transition: opacity 0.6s ease, transform 0.6s ease; }
        .fade-in-up.visible { opacity: 1; transform: translateY(0); }
        .delay-100 { transition-delay: 0.1s; }
        .delay-200 { transition-delay: 0.2s; }
        .delay-300 { transition-delay: 0.3s; }
    </style>
</head>
<body class="bg-white font-body" style="background-color:#f0f7ff">
    <div id="progress-bar" style="width:0%"></div>

    <!-- Floating CTA -->
    <a href="contact.php#formulier" class="floating-cta bg-brandNavy text-white px-6 py-4 rounded-full font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2 pulse-glow">
        <span class="material-symbols-outlined">calendar_today</span>
        <span class="hidden sm:inline">Plan een kennismaking</span>
    </a>

    <!-- WhatsApp -->
    <a href="https://wa.me/31613943186?text=Hallo%20Jim%2C%20ik%20heb%20een%20vraag%20over%20woningontruiming" target="_blank" rel="noopener" class="whatsapp-btn" aria-label="WhatsApp Jim Ruimt Op">
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
                <a href="fotos.php" class="font-headline font-bold text-white border-b-2 border-brandCyan pb-1">Foto's</a>
                <a href="over-mij.php" class="font-headline font-bold text-white/70 hover:text-brandCyan transition-colors">Over Ons</a>
                <a href="contact.php" class="font-headline font-bold text-white/70 hover:text-brandCyan transition-colors">Contact</a>
            </div>
            <div class="hidden md:flex items-center gap-4">
                <a href="<?= $tel_href ?>" class="flex items-center gap-2 text-white font-bold hover:text-brandCyan transition-colors text-sm">
                    <span class="material-symbols-outlined text-lg">call</span>
                    <span><?= $telefoon ?></span>
                </a>
                <a href="contact.php#formulier" class="bg-brandCyan text-brandNavy px-6 py-3 rounded-full font-bold hover:opacity-90 transition-all text-sm">Plan een kennismaking</a>
            </div>
            <button id="mobile-menu-btn" class="md:hidden text-white">
                <span class="material-symbols-outlined text-3xl">menu</span>
            </button>
        </nav>
        <div id="mobile-menu" class="hidden md:hidden bg-brandNavy border-t border-white/20">
            <div class="flex flex-col px-6 py-4 space-y-4">
                <a href="index.php" class="font-headline font-bold text-white/70">Home</a>
                <a href="diensten.php" class="font-headline font-bold text-white/70">Diensten</a>
                <a href="fotos.php" class="font-headline font-bold text-white">Foto's</a>
                <a href="over-mij.php" class="font-headline font-bold text-white/70">Over Ons</a>
                <a href="contact.php" class="font-headline font-bold text-white/70">Contact</a>
                <a href="<?= $tel_href ?>" class="flex items-center gap-2 text-white font-bold text-sm">
                    <span class="material-symbols-outlined text-lg">call</span>06 13 94 31 86
                </a>
                <a href="contact.php#formulier" class="bg-brandCyan text-brandNavy px-6 py-3 rounded-full font-bold text-center text-sm">Plan een kennismaking</a>
            </div>
        </div>
    </header>

    <main>
        <!-- Hero -->
        <section class="bg-brandNavy text-white py-20 px-6">
            <div class="max-w-4xl mx-auto text-center fade-in-up">
                <span class="font-script text-brandCyan text-3xl mb-4 block"><?= t($p, 'hero_script', 'Het resultaat spreekt voor zich') ?></span>
                <h1 class="font-headline text-5xl md:text-6xl font-bold mb-4"><?= t($p, 'hero_kop', "Foto's &amp; Resultaten") ?></h1>
                <p class="text-xl text-white/80 max-w-2xl mx-auto"><?= t($p, 'hero_subtekst', 'Van vol en overweldigend naar leeg en bezemschoon. Bekijk het verschil dat Jim maakt — in woningen door heel Tilburg en omstreken.') ?></p>
            </div>
        </section>

        <!-- Voor / Na Sliders -->
        <section class="py-20 px-6">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-12 fade-in-up">
                    <h2 class="font-headline text-4xl font-bold text-brandNavy mb-3">Voor & Na</h2>
                    <p class="text-gray-600 max-w-xl mx-auto">Sleep de schuifregelaar om het verschil te zien. Elke ontruiming begint met chaos — en eindigt met rust.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <!-- Slider 1 -->
                    <div class="fade-in-up delay-100">
                        <p class="font-headline font-bold text-brandNavy mb-3 text-lg">Woonkamer — Eengezinswoning</p>
                        <div class="before-after-container cloud-shadow" style="height:300px;" data-ba="1">
                            <!-- NA (achtergrond) -->
                            <img src="file_24---f1a3f6be-ff29-4eb4-9169-64c58267bf1c.jpg" alt="Na ontruiming woonkamer Tilburg"/>
                            <!-- VOOR (clip) -->
                            <div class="ba-clip" id="ba-clip-1">
                                <img src="file_26---05787c6d-5a2f-4a29-a396-a37570acc71c.jpg" alt="Voor ontruiming woonkamer Tilburg"/>
                            </div>
                            <span class="ba-label ba-label-voor">Voor</span>
                            <span class="ba-label ba-label-na">Na</span>
                            <div class="ba-handle" id="ba-handle-1"></div>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">Tilburg — Complete woningontruiming</p>
                    </div>

                    <!-- Slider 2 -->
                    <div class="fade-in-up delay-200">
                        <p class="font-headline font-bold text-brandNavy mb-3 text-lg">Garage — Opruiming & Sortering</p>
                        <div class="before-after-container cloud-shadow" style="height:300px;" data-ba="2">
                            <img src="file_24---f1a3f6be-ff29-4eb4-9169-64c58267bf1c.jpg" alt="Na ontruiming garage Tilburg"/>
                            <div class="ba-clip" id="ba-clip-2">
                                <img src="file_26---05787c6d-5a2f-4a29-a396-a37570acc71c.jpg" alt="Voor ontruiming garage Tilburg"/>
                            </div>
                            <span class="ba-label ba-label-voor">Voor</span>
                            <span class="ba-label ba-label-na">Na</span>
                            <div class="ba-handle" id="ba-handle-2"></div>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">Tilburg Noord — Garageontruiming</p>
                    </div>

                    <!-- Slider 3 -->
                    <div class="fade-in-up delay-100">
                        <p class="font-headline font-bold text-brandNavy mb-3 text-lg">Slaapkamer — Zorgeloos Afscheid</p>
                        <div class="before-after-container cloud-shadow" style="height:300px;" data-ba="3">
                            <img src="file_24---f1a3f6be-ff29-4eb4-9169-64c58267bf1c.jpg" alt="Na ontruiming slaapkamer Tilburg"/>
                            <div class="ba-clip" id="ba-clip-3">
                                <img src="file_26---05787c6d-5a2f-4a29-a396-a37570acc71c.jpg" alt="Voor ontruiming slaapkamer Tilburg"/>
                            </div>
                            <span class="ba-label ba-label-voor">Voor</span>
                            <span class="ba-label ba-label-na">Na</span>
                            <div class="ba-handle" id="ba-handle-3"></div>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">Tilburg Zuid — Nabestaanden begeleiding</p>
                    </div>

                    <!-- Slider 4 -->
                    <div class="fade-in-up delay-200">
                        <p class="font-headline font-bold text-brandNavy mb-3 text-lg">Zolder — Volledig leeggemaakt</p>
                        <div class="before-after-container cloud-shadow" style="height:300px;" data-ba="4">
                            <img src="file_24---f1a3f6be-ff29-4eb4-9169-64c58267bf1c.jpg" alt="Na zolderontruiming Tilburg"/>
                            <div class="ba-clip" id="ba-clip-4">
                                <img src="file_26---05787c6d-5a2f-4a29-a396-a37570acc71c.jpg" alt="Voor zolderontruiming Tilburg"/>
                            </div>
                            <span class="ba-label ba-label-voor">Voor</span>
                            <span class="ba-label ba-label-na">Na</span>
                            <div class="ba-handle" id="ba-handle-4"></div>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">Oisterwijk — Zolderontruiming</p>
                    </div>

                </div>
            </div>
        </section>

        <!-- Fotogalerij -->
        <section class="bg-brandCream py-20 px-6">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-12 fade-in-up">
                    <h2 class="font-headline text-4xl font-bold text-brandNavy mb-3"><?= t($p, 'gallerij_kop', 'Galerij') ?></h2>
                    <p class="text-gray-600 max-w-xl mx-auto"><?= t($p, 'gallerij_subtekst', 'Een selectie van uitgevoerde ontruimingen. Klik op een foto om te vergroten.') ?></p>
                </div>

                <div class="gallery-grid">
                    <?php foreach ($fotos as $foto):
                        $src = htmlspecialchars(afbeelding_url($foto['bestand'] ?? ''), ENT_QUOTES, 'UTF-8');
                        $alt = htmlspecialchars($foto['alt'] ?? '', ENT_QUOTES, 'UTF-8');
                        $label = htmlspecialchars($foto['label'] ?? '', ENT_QUOTES, 'UTF-8');
                    ?>
                    <div class="gallery-item cloud-shadow" onclick="openLightbox(this)">
                        <img src="<?= $src ?>" alt="<?= $alt ?>"/>
                        <div class="gallery-overlay">
                            <p class="text-white text-sm font-bold"><?= $label ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </section>

        <!-- CTA -->
        <section class="py-20 px-6">
            <div class="max-w-4xl mx-auto text-center fade-in-up">
                <span class="font-script text-brandCyan text-3xl mb-4 block"><?= t($p, 'cta_script', 'Zo kan uw woning er ook uitzien') ?></span>
                <h2 class="font-headline text-4xl font-bold text-brandNavy mb-6"><?= t($p, 'cta_kop', 'Klaar voor een frisse start?') ?></h2>
                <p class="text-gray-600 mb-8 max-w-xl mx-auto"><?= t($p, 'cta_tekst', 'Plan een kennismaking in en ontdek wat Jim voor uw situatie kan betekenen.') ?></p>
                <a href="contact.php#formulier" class="inline-block bg-brandGreen text-white px-10 py-4 rounded-full font-bold text-lg hover:bg-brandNavy transition-all shadow-lg">
                    Kennismaking aanvragen
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

    <!-- Lightbox -->
    <div id="lightbox" class="lightbox" onclick="closeLightbox()">
        <button onclick="closeLightbox()" class="absolute top-6 right-6 w-12 h-12 bg-white/10 rounded-full flex items-center justify-center text-white hover:bg-white/20 transition-colors">
            <span class="material-symbols-outlined">close</span>
        </button>
        <img id="lightbox-img" src="" alt=""/>
    </div>

    <script>
        // Progress bar
        window.addEventListener('scroll', () => {
            const p = (window.scrollY / (document.body.scrollHeight - window.innerHeight)) * 100;
            document.getElementById('progress-bar').style.width = p + '%';
        });

        // Mobile menu
        document.getElementById('mobile-menu-btn').addEventListener('click', () => {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });

        // Scroll animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
        }, { threshold: 0.1 });
        document.querySelectorAll('.fade-in-up').forEach(el => observer.observe(el));

        // Lightbox
        function openLightbox(item) {
            const src = item.querySelector('img').src;
            document.getElementById('lightbox-img').src = src;
            document.getElementById('lightbox').classList.add('open');
        }
        function closeLightbox() {
            document.getElementById('lightbox').classList.remove('open');
        }
        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLightbox(); });

        // Voor/Na sliders
        function initSlider(id) {
            const container = document.querySelector(`[data-ba="${id}"]`);
            const clip = document.getElementById(`ba-clip-${id}`);
            const handle = document.getElementById(`ba-handle-${id}`);
            if (!container || !clip || !handle) return;

            // Set initial clip image width to container width
            const updateClipImgWidth = () => {
                clip.querySelector('img').style.width = container.offsetWidth + 'px';
            };
            updateClipImgWidth();
            window.addEventListener('resize', updateClipImgWidth);

            let dragging = false;

            function setPosition(x) {
                const rect = container.getBoundingClientRect();
                let pct = ((x - rect.left) / rect.width) * 100;
                pct = Math.max(2, Math.min(98, pct));
                clip.style.width = pct + '%';
                handle.style.left = pct + '%';
            }

            handle.addEventListener('mousedown', e => { dragging = true; e.preventDefault(); });
            container.addEventListener('mousedown', e => { dragging = true; setPosition(e.clientX); e.preventDefault(); });
            window.addEventListener('mousemove', e => { if (dragging) setPosition(e.clientX); });
            window.addEventListener('mouseup', () => { dragging = false; });

            handle.addEventListener('touchstart', e => { dragging = true; e.preventDefault(); }, { passive: false });
            container.addEventListener('touchstart', e => { dragging = true; setPosition(e.touches[0].clientX); }, { passive: true });
            window.addEventListener('touchmove', e => { if (dragging) setPosition(e.touches[0].clientX); }, { passive: true });
            window.addEventListener('touchend', () => { dragging = false; });
        }

        [1, 2, 3, 4].forEach(initSlider);
    </script>
</body>
</html>
