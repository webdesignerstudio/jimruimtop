<?php
require_once __DIR__ . '/includes/functions.php';
$contact      = laad_json('contact.json');
$teksten      = laad_json('teksten.json');
$instellingen = laad_json('instellingen.json');
$toon_fotos   = $instellingen['toon_fotos_menu'] ?? true;
$gallerij     = laad_json('gallerij.json');
$sliders      = laad_json('sliders.json');
$p        = $teksten['fotos'] ?? [];

$telefoon    = t($contact, 'telefoon', '06 12 34 56 78');
$tel_href    = tel_link($contact);
$wa_url      = whatsapp_url($contact);
$hero_script = t($p, 'hero_script', 'Het resultaat spreekt voor zich');
$hero_kop    = t($p, 'hero_kop', "Foto's & Resultaten");
$hero_sub    = t($p, 'hero_subtekst', 'Van vol en overweldigend naar leeg en bezemschoon. Bekijk het verschil dat Jim maakt — in woningen door heel Tilburg en omstreken.');
$gal_kop     = t($p, 'gallerij_kop', 'Galerij');
$gal_sub     = t($p, 'gallerij_subtekst', 'Een selectie van uitgevoerde ontruimingen. Klik op een foto om te vergroten.');
$cta_script  = t($p, 'cta_script', 'Zo kan uw woning er ook uitzien');
$cta_kop     = t($p, 'cta_kop', 'Klaar voor een frisse start?');
$cta_tekst   = t($p, 'cta_tekst', 'Plan een gratis intake in en ontdek wat Jim voor uw situatie kan betekenen.');

// Fallback sliders als JSON leeg is
if (empty($sliders)) {
    $sliders = [
        ['titel'=>'Woonkamer — Eengezinswoning','locatie'=>'Tilburg — Complete woningontruiming','voor_bestand'=>'file_26---05787c6d-5a2f-4a29-a396-a37570acc71c.jpg','voor_alt'=>'Voor ontruiming woonkamer','na_bestand'=>'file_24---f1a3f6be-ff29-4eb4-9169-64c58267bf1c.jpg','na_alt'=>'Na ontruiming woonkamer'],
        ['titel'=>'Garage — Opruiming & Sortering','locatie'=>'Tilburg Noord — Garageontruiming','voor_bestand'=>'file_26---05787c6d-5a2f-4a29-a396-a37570acc71c.jpg','voor_alt'=>'Voor ontruiming garage','na_bestand'=>'file_24---f1a3f6be-ff29-4eb4-9169-64c58267bf1c.jpg','na_alt'=>'Na ontruiming garage'],
        ['titel'=>'Slaapkamer — Zorgeloos Afscheid','locatie'=>'Tilburg Zuid — Nabestaanden begeleiding','voor_bestand'=>'file_26---05787c6d-5a2f-4a29-a396-a37570acc71c.jpg','voor_alt'=>'Voor ontruiming slaapkamer','na_bestand'=>'file_24---f1a3f6be-ff29-4eb4-9169-64c58267bf1c.jpg','na_alt'=>'Na ontruiming slaapkamer'],
        ['titel'=>'Zolder — Volledig leeggemaakt','locatie'=>'Oisterwijk — Zolderontruiming','voor_bestand'=>'file_26---05787c6d-5a2f-4a29-a396-a37570acc71c.jpg','voor_alt'=>'Voor zolderontruiming','na_bestand'=>'file_24---f1a3f6be-ff29-4eb4-9169-64c58267bf1c.jpg','na_alt'=>'Na zolderontruiming'],
    ];
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Foto's & Resultaten | Jim Ruimt Op — Woningontruiming Tilburg</title>
    <meta name="description" content="Bekijk foto's van woningontruimingen in Tilburg door Jim Ruimt Op. Voor- en nafoto's tonen het verschil — van vol naar leeg en bezemschoon."/>
    <meta name="robots" content="index, follow"/>
    <link rel="canonical" href="https://www.jimruimtop.nl/fotos.html"/>
    <meta property="og:title" content="Foto's & Resultaten | Jim Ruimt Op"/>
    <meta property="og:description" content="Voor- en nafoto's van woningontruimingen in Tilburg. Zie het verschil dat Jim maakt."/>
    <meta property="og:url" content="https://www.jimruimtop.nl/fotos.html"/>
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
    <a href="contact.php" class="floating-cta bg-brandNavy text-white px-6 py-4 rounded-full font-bold shadow-lg hover:shadow-xl transition-all flex items-center gap-2 pulse-glow">
        <span class="material-symbols-outlined">calendar_today</span>
        <span class="hidden sm:inline">Gratis Intake</span>
    </a>

    <!-- WhatsApp -->
    <a href="<?= $wa_url ?>" target="_blank" rel="noopener" class="whatsapp-btn" aria-label="WhatsApp Jim Ruimt Op">
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
                <?php if ($toon_fotos): ?><a href="fotos.php" class="font-headline font-bold text-white border-b-2 border-brandCyan pb-1">Foto's</a><?php endif; ?>
                <a href="over-mij.php" class="font-headline font-bold text-white/70 hover:text-brandCyan transition-colors">Over Mij</a>
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
                <?php if ($toon_fotos): ?><a href="fotos.php" class="font-headline font-bold text-white">Foto's</a><?php endif; ?>
                <a href="over-mij.php" class="font-headline font-bold text-white/70">Over Mij</a>
                <a href="contact.php" class="font-headline font-bold text-white/70">Contact</a>
                <a href="<?= $tel_href ?>" class="flex items-center gap-2 text-white font-bold text-sm">
                    <span class="material-symbols-outlined text-lg">call</span><?= $telefoon ?>
                </a>
                <a href="contact.php" class="bg-brandCyan text-brandNavy px-6 py-3 rounded-full font-bold text-center text-sm">Gratis Intake</a>
            </div>
        </div>
    </header>

    <main>
        <!-- Hero -->
        <section class="bg-brandNavy text-white py-20 px-6">
            <div class="max-w-4xl mx-auto text-center fade-in-up">
                <span class="font-script text-brandCyan text-3xl mb-4 block"><?= $hero_script ?></span>
                <h1 class="font-headline text-5xl md:text-6xl font-bold mb-4"><?= $hero_kop ?></h1>
                <p class="text-xl text-white/80 max-w-2xl mx-auto"><?= $hero_sub ?></p>
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
                    <?php foreach ($sliders as $i => $slider):
                        $idx = $i + 1;
                        $delay = ($i % 2 === 0) ? 'delay-100' : 'delay-200';
                        $titel = htmlspecialchars($slider['titel'] ?? "Slider $idx", ENT_QUOTES, 'UTF-8');
                        $locatie = htmlspecialchars($slider['locatie'] ?? '', ENT_QUOTES, 'UTF-8');
                        $voor_src = afbeelding_url($slider['voor_bestand'] ?? '');
                        $voor_alt = htmlspecialchars($slider['voor_alt'] ?? 'Voor ontruiming', ENT_QUOTES, 'UTF-8');
                        $na_src = afbeelding_url($slider['na_bestand'] ?? '');
                        $na_alt = htmlspecialchars($slider['na_alt'] ?? 'Na ontruiming', ENT_QUOTES, 'UTF-8');
                    ?>
                    <div class="fade-in-up <?= $delay ?>">
                        <p class="font-headline font-bold text-brandNavy mb-3 text-lg"><?= $titel ?></p>
                        <div class="before-after-container cloud-shadow" style="height:300px;" data-ba="<?= $idx ?>">
                            <img src="<?= $na_src ?>" alt="<?= $na_alt ?>"/>
                            <div class="ba-clip" id="ba-clip-<?= $idx ?>">
                                <img src="<?= $voor_src ?>" alt="<?= $voor_alt ?>"/>
                            </div>
                            <span class="ba-label ba-label-voor">Voor</span>
                            <span class="ba-label ba-label-na">Na</span>
                            <div class="ba-handle" id="ba-handle-<?= $idx ?>"></div>
                        </div>
                        <?php if ($locatie): ?>
                        <p class="text-sm text-gray-500 mt-2"><?= $locatie ?></p>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Fotogalerij -->
        <section class="py-20 px-6">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-12 fade-in-up">
                    <h2 class="font-headline text-4xl font-bold text-brandNavy mb-3"><?= $gal_kop ?></h2>
                    <p class="text-gray-600 max-w-xl mx-auto"><?= $gal_sub ?></p>
                </div>

                <?php if (!empty($gallerij)): ?>
                <div class="gallery-grid">
                    <?php foreach ($gallerij as $foto):
                        $src   = afbeelding_url($foto['bestand'] ?? '');
                        $label = htmlspecialchars($foto['label'] ?? '', ENT_QUOTES, 'UTF-8');
                        $alt   = htmlspecialchars($foto['alt'] ?? $label, ENT_QUOTES, 'UTF-8');
                    ?>
                    <div class="gallery-item cloud-shadow" onclick="openLightbox(this)">
                        <img src="<?= $src ?>" alt="<?= $alt ?>"/>
                        <div class="gallery-overlay">
                            <?php if ($label): ?>
                            <p class="text-white text-sm font-bold"><?= $label ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <p class="text-center text-gray-500 py-12">Er zijn nog geen foto's toegevoegd.</p>
                <?php endif; ?>
            </div>
        </section>

        <!-- CTA -->
        <section class="py-20 px-6">
            <div class="max-w-4xl mx-auto text-center fade-in-up">
                <span class="font-script text-brandCyan text-3xl mb-4 block"><?= $cta_script ?></span>
                <h2 class="font-headline text-4xl font-bold text-brandNavy mb-6"><?= $cta_kop ?></h2>
                <p class="text-gray-600 mb-8 max-w-xl mx-auto"><?= $cta_tekst ?></p>
                <a href="contact.php" class="inline-block bg-brandGreen text-white px-10 py-4 rounded-full font-bold text-lg hover:bg-brandNavy transition-all shadow-lg">
                    Gratis Intake Aanvragen
                </a>
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
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-12 w-full md:w-auto">
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
                    <h4 class="font-bold mb-3 text-brandCyan uppercase text-sm tracking-wider">Contact</h4>
                    <p class="text-white/70 text-sm"><?= t($contact, 'adres', 'Tilburg') ?><br/><?= htmlspecialchars($contact['email'] ?? 'info@jimruimtop.nl') ?><br/>Bel: <?= $telefoon ?></p>
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

    <!-- Lightbox -->
    <div id="lightbox" class="lightbox" onclick="closeLightbox()">
        <button onclick="closeLightbox()" class="absolute top-6 right-6 w-12 h-12 bg-white/10 rounded-full flex items-center justify-center text-white hover:bg-white/20 transition-colors">
            <span class="material-symbols-outlined">close</span>
        </button>
        <img id="lightbox-img" src="" alt=""/>
    </div>

    <script>
        window.addEventListener('scroll', () => {
            const p = (window.scrollY / (document.body.scrollHeight - window.innerHeight)) * 100;
            document.getElementById('progress-bar').style.width = p + '%';
        });

        document.getElementById('mobile-menu-btn').addEventListener('click', () => {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
        }, { threshold: 0.1 });
        document.querySelectorAll('.fade-in-up').forEach(el => observer.observe(el));

        function openLightbox(item) {
            const src = item.querySelector('img').src;
            document.getElementById('lightbox-img').src = src;
            document.getElementById('lightbox').classList.add('open');
        }
        function closeLightbox() {
            document.getElementById('lightbox').classList.remove('open');
        }
        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLightbox(); });

        function initSlider(id) {
            const container = document.querySelector(`[data-ba="${id}"]`);
            const clip = document.getElementById(`ba-clip-${id}`);
            const handle = document.getElementById(`ba-handle-${id}`);
            if (!container || !clip || !handle) return;

            const updateClipImgWidth = () => {
                const img = clip.querySelector('img');
                if (img) img.style.width = container.offsetWidth + 'px';
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

        <?php for ($i = 1; $i <= count($sliders); $i++): ?>
        initSlider(<?= $i ?>);
        <?php endfor; ?>
    </script>
</body>
</html>
