<?php
require_once __DIR__ . '/auth.php';

$gallerij = laad_json_admin('gallerij.json');
$sliders  = laad_json_admin('sliders.json');
$melding  = '';
$melding_type = 'groen';
$csrf = csrf_token();

// --- Verwerk POST acties ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_valideer()) {
        $melding = 'Beveiligingsfout. Probeer opnieuw.';
        $melding_type = 'rood';
    } else {
        $actie = $_POST['actie'] ?? '';

        // Upload galerij foto
        if ($actie === 'upload_gallerij') {
            if (!empty($_FILES['foto']['tmp_name'])) {
                $resultaat = upload_foto($_FILES['foto'], 'gallerij');
                if ($resultaat['ok']) {
                    $gallerij[] = [
                        'bestand' => $resultaat['bestand'],
                        'label'   => trim($_POST['label'] ?? ''),
                        'alt'     => trim($_POST['alt'] ?? ''),
                    ];
                    sla_json_op_admin('gallerij.json', $gallerij);
                    $melding = "Foto '{$resultaat['bestand']}' geüpload en toegevoegd aan de galerij.";
                } else {
                    $melding = $resultaat['fout'];
                    $melding_type = 'rood';
                }
            }
        }

        // Verwijder galerij foto
        elseif ($actie === 'verwijder_gallerij') {
            $index = (int)($_POST['index'] ?? -1);
            if (isset($gallerij[$index])) {
                $bestand = $gallerij[$index]['bestand'];
                $pad = UPLOADS_PAD . $bestand;
                if (file_exists($pad)) unlink($pad);
                array_splice($gallerij, $index, 1);
                sla_json_op_admin('gallerij.json', $gallerij);
                $melding = "Foto verwijderd.";
            }
        }

        // Labels galerij opslaan
        elseif ($actie === 'sla_gallerij_labels_op') {
            foreach ($gallerij as $i => &$foto) {
                $foto['label'] = trim($_POST["label_{$i}"] ?? $foto['label']);
                $foto['alt']   = trim($_POST["alt_{$i}"] ?? $foto['alt']);
            }
            unset($foto);
            sla_json_op_admin('gallerij.json', $gallerij);
            $melding = 'Labels opgeslagen.';
        }

        // Upload slider afbeelding
        elseif ($actie === 'upload_slider') {
            $slider_index = (int)($_POST['slider_index'] ?? -1);
            $kant = $_POST['kant'] ?? ''; // 'voor' of 'na'
            if (isset($sliders[$slider_index]) && in_array($kant, ['voor', 'na'], true) && !empty($_FILES['slider_foto']['tmp_name'])) {
                $resultaat = upload_foto($_FILES['slider_foto'], 'gallerij');
                if ($resultaat['ok']) {
                    $sliders[$slider_index]["{$kant}_bestand"] = $resultaat['bestand'];
                    sla_json_op_admin('sliders.json', $sliders);
                    $melding = "Slider afbeelding geüpload.";
                } else {
                    $melding = $resultaat['fout'];
                    $melding_type = 'rood';
                }
            }
        }

        // Sla slider teksten op
        elseif ($actie === 'sla_sliders_op') {
            foreach ($sliders as $i => &$slider) {
                $slider['titel']   = trim($_POST["titel_{$i}"] ?? $slider['titel'] ?? '');
                $slider['locatie'] = trim($_POST["locatie_{$i}"] ?? $slider['locatie'] ?? '');
                $slider['voor_alt']= trim($_POST["voor_alt_{$i}"] ?? $slider['voor_alt'] ?? '');
                $slider['na_alt']  = trim($_POST["na_alt_{$i}"] ?? $slider['na_alt'] ?? '');
            }
            unset($slider);
            sla_json_op_admin('sliders.json', $sliders);
            $melding = 'Slider informatie opgeslagen.';
        }

        // Voeg nieuwe slider toe
        elseif ($actie === 'voeg_slider_toe') {
            $sliders[] = [
                'titel'       => trim($_POST['nieuwe_titel'] ?? 'Nieuwe slider'),
                'locatie'     => '',
                'voor_bestand'=> '',
                'voor_alt'    => 'Voor ontruiming',
                'na_bestand'  => '',
                'na_alt'      => 'Na ontruiming',
            ];
            sla_json_op_admin('sliders.json', $sliders);
            $melding = 'Nieuwe Voor/Na slider toegevoegd.';
        }

        // Verwijder slider
        elseif ($actie === 'verwijder_slider') {
            $index = (int)($_POST['index'] ?? -1);
            if (isset($sliders[$index])) {
                array_splice($sliders, $index, 1);
                sla_json_op_admin('sliders.json', $sliders);
                $melding = 'Slider verwijderd.';
            }
        }

        // Herlaad data na actie
        $gallerij = laad_json_admin('gallerij.json');
        $sliders  = laad_json_admin('sliders.json');
    }
}

/**
 * Upload een foto veilig naar /uploads/gallerij/
 */
function upload_foto(array $bestand, string $submap): array {
    if ($bestand['error'] !== UPLOAD_ERR_OK) {
        return ['ok' => false, 'fout' => 'Upload fout code: ' . $bestand['error']];
    }
    if ($bestand['size'] > MAX_UPLOAD_GROOTTE) {
        return ['ok' => false, 'fout' => 'Bestand is te groot (max 8 MB).'];
    }

    $mimetype = mime_content_type($bestand['tmp_name']);
    if (!in_array($mimetype, TOEGESTANE_TYPES, true)) {
        return ['ok' => false, 'fout' => 'Ongeldig bestandstype. Gebruik JPG, PNG of WebP.'];
    }

    $ext = strtolower(pathinfo($bestand['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, TOEGESTANE_EXTENSIES, true)) {
        return ['ok' => false, 'fout' => 'Ongeldige extensie.'];
    }

    $nieuw_bestand = uniqid('jro_', true) . '.' . $ext;
    $doel = UPLOADS_PAD . $nieuw_bestand;

    if (!is_dir(UPLOADS_PAD)) {
        mkdir(UPLOADS_PAD, 0755, true);
    }

    if (!move_uploaded_file($bestand['tmp_name'], $doel)) {
        return ['ok' => false, 'fout' => 'Kan bestand niet opslaan. Controleer schrijfrechten op /uploads/gallerij/.'];
    }

    return ['ok' => true, 'bestand' => $nieuw_bestand];
}

function afbeelding_preview(string $bestand): string {
    if (empty($bestand)) return '';
    if (file_exists(UPLOADS_PAD . $bestand)) {
        return UPLOADS_URL_PAD . htmlspecialchars($bestand, ENT_QUOTES);
    }
    return '../' . htmlspecialchars($bestand, ENT_QUOTES);
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Foto's beheer — Jim Ruimt Op</title>
    <meta name="robots" content="noindex, nofollow"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { theme: { extend: { colors: { navy:'#1A436D', cyan:'#5BCEFF', green:'#7CC19D' } } } }</script>
    <style>
        .foto-thumb { width:100px;height:80px;object-fit:cover;border-radius:6px;border:2px solid #e5e7eb; }
        .sectie-kop { font-size:1.1rem;font-weight:700;color:#1A436D;margin-bottom:1rem;padding-bottom:0.5rem;border-bottom:2px solid #5BCEFF; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

    <header class="bg-navy text-white px-6 py-4 flex justify-between items-center shadow-md sticky top-0 z-40">
        <div class="flex items-center gap-3">
            <span class="font-bold text-lg">Jim Ruimt Op</span>
            <span class="text-white/50 text-sm">| Foto's Beheer</span>
        </div>
        <nav class="flex items-center gap-4">
            <a href="dashboard.php" class="text-white/80 hover:text-white text-sm font-medium">Teksten & Contact</a>
            <a href="fotos.php" class="text-white text-sm font-bold">Foto's</a>
            <a href="../fotos.php" target="_blank" class="text-white/60 hover:text-white text-sm">↗ Website</a>
            <a href="uitloggen.php" class="bg-white/10 hover:bg-white/20 px-4 py-2 rounded-lg text-sm font-medium transition-colors">Uitloggen</a>
        </nav>
    </header>

    <main class="max-w-5xl mx-auto px-6 py-8">

        <?php if ($melding): ?>
        <div class="mb-6 px-4 py-3 rounded-lg text-sm font-medium <?= $melding_type === 'rood' ? 'bg-red-50 border border-red-200 text-red-700' : 'bg-green-50 border border-green-200 text-green-700' ?>">
            <?= htmlspecialchars($melding) ?>
        </div>
        <?php endif; ?>

        <!-- ====== GALERIJ ====== -->
        <section class="mb-12">
            <h2 class="sectie-kop">Fotogalerij</h2>

            <!-- Upload nieuwe foto -->
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-6">
                <h3 class="font-semibold text-gray-700 mb-4">Nieuwe foto uploaden</h3>
                <form method="POST" enctype="multipart/form-data" class="space-y-4">
                    <input type="hidden" name="csrf_token" value="<?= $csrf ?>"/>
                    <input type="hidden" name="actie" value="upload_gallerij"/>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-1">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Foto kiezen *</label>
                            <input type="file" name="foto" accept=".jpg,.jpeg,.png,.webp" required
                                class="w-full text-sm text-gray-600 border border-gray-300 rounded-lg px-3 py-2 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-navy file:text-white file:text-sm file:cursor-pointer"/>
                            <p class="text-xs text-gray-400 mt-1">Max 8 MB. JPG, PNG of WebP.</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Label (bijv. "Woonkamer Tilburg")</label>
                            <input type="text" name="label" placeholder="Label van de foto"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy"/>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Alt-tekst (voor SEO)</label>
                            <input type="text" name="alt" placeholder="Beschrijving voor zoekmachines"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy"/>
                        </div>
                    </div>
                    <button type="submit" class="bg-navy text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-opacity-90 transition-all">
                        Foto uploaden
                    </button>
                </form>
            </div>

            <!-- Bestaande foto's -->
            <?php if (!empty($gallerij)): ?>
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-semibold text-gray-700 mb-4">Huidige foto's (<?= count($gallerij) ?>)</h3>
                <form method="POST">
                    <input type="hidden" name="csrf_token" value="<?= $csrf ?>"/>
                    <input type="hidden" name="actie" value="sla_gallerij_labels_op"/>
                    <div class="space-y-3">
                        <?php foreach ($gallerij as $i => $foto):
                            $preview = afbeelding_preview($foto['bestand'] ?? '');
                        ?>
                        <div class="flex items-center gap-4 p-3 rounded-lg border border-gray-100 hover:bg-gray-50 transition-colors">
                            <?php if ($preview): ?>
                            <img src="<?= $preview ?>" alt="preview" class="foto-thumb flex-shrink-0"/>
                            <?php else: ?>
                            <div class="foto-thumb flex-shrink-0 bg-gray-100 flex items-center justify-center text-gray-400 text-xs">Geen foto</div>
                            <?php endif; ?>
                            <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-2">
                                <input type="text" name="label_<?= $i ?>" value="<?= htmlspecialchars($foto['label'] ?? '') ?>"
                                    placeholder="Label" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy"/>
                                <input type="text" name="alt_<?= $i ?>" value="<?= htmlspecialchars($foto['alt'] ?? '') ?>"
                                    placeholder="Alt-tekst" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy"/>
                            </div>
                            <form method="POST" onsubmit="return confirm('Foto verwijderen?')" class="flex-shrink-0">
                                <input type="hidden" name="csrf_token" value="<?= $csrf ?>"/>
                                <input type="hidden" name="actie" value="verwijder_gallerij"/>
                                <input type="hidden" name="index" value="<?= $i ?>"/>
                                <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                                    Verwijder
                                </button>
                            </form>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="submit" class="mt-4 bg-navy text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-opacity-90 transition-all">
                        Labels opslaan
                    </button>
                </form>
            </div>
            <?php else: ?>
            <p class="text-gray-500 text-sm py-4">Nog geen foto's in de galerij.</p>
            <?php endif; ?>
        </section>

        <!-- ====== VOOR / NA SLIDERS ====== -->
        <section>
            <h2 class="sectie-kop">Voor & Na Sliders</h2>

            <!-- Voeg slider toe -->
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 mb-6">
                <form method="POST" class="flex items-end gap-4">
                    <input type="hidden" name="csrf_token" value="<?= $csrf ?>"/>
                    <input type="hidden" name="actie" value="voeg_slider_toe"/>
                    <div class="flex-1">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Titel nieuwe slider</label>
                        <input type="text" name="nieuwe_titel" placeholder="bijv. Woonkamer — Tilburg"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy"/>
                    </div>
                    <button type="submit" class="bg-green text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-opacity-90 transition-all flex-shrink-0">
                        + Slider toevoegen
                    </button>
                </form>
            </div>

            <!-- Slider teksten opslaan -->
            <?php if (!empty($sliders)): ?>
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-6">
                <h3 class="font-semibold text-gray-700 mb-4">Slider titels & locaties</h3>
                <form method="POST">
                    <input type="hidden" name="csrf_token" value="<?= $csrf ?>"/>
                    <input type="hidden" name="actie" value="sla_sliders_op"/>
                    <div class="space-y-4">
                        <?php foreach ($sliders as $i => $slider): ?>
                        <div class="p-4 rounded-lg border border-gray-100 bg-gray-50">
                            <div class="flex justify-between items-start mb-3">
                                <span class="text-sm font-bold text-navy">Slider <?= $i + 1 ?></span>
                                <form method="POST" onsubmit="return confirm('Slider verwijderen?')" class="inline">
                                    <input type="hidden" name="csrf_token" value="<?= $csrf ?>"/>
                                    <input type="hidden" name="actie" value="verwijder_slider"/>
                                    <input type="hidden" name="index" value="<?= $i ?>"/>
                                    <button type="submit" class="text-xs text-red-500 hover:text-red-700 font-medium">Verwijder slider</button>
                                </form>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Titel</label>
                                    <input type="text" name="titel_<?= $i ?>" value="<?= htmlspecialchars($slider['titel'] ?? '') ?>"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy"/>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Locatie</label>
                                    <input type="text" name="locatie_<?= $i ?>" value="<?= htmlspecialchars($slider['locatie'] ?? '') ?>"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy"/>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Voor — alt tekst</label>
                                    <input type="text" name="voor_alt_<?= $i ?>" value="<?= htmlspecialchars($slider['voor_alt'] ?? '') ?>"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy"/>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Na — alt tekst</label>
                                    <input type="text" name="na_alt_<?= $i ?>" value="<?= htmlspecialchars($slider['na_alt'] ?? '') ?>"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy"/>
                                </div>
                            </div>

                            <!-- Upload voor/na afbeeldingen -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                <?php foreach (['voor' => 'Voor', 'na' => 'Na'] as $kant => $kant_label):
                                    $huidig = afbeelding_preview($slider["{$kant}_bestand"] ?? '');
                                ?>
                                <div class="p-3 rounded-lg border border-dashed border-gray-300 bg-white">
                                    <p class="text-xs font-bold text-gray-600 mb-2"><?= $kant_label ?>-afbeelding</p>
                                    <?php if ($huidig): ?>
                                    <img src="<?= $huidig ?>" alt="<?= $kant ?>" class="foto-thumb mb-2"/>
                                    <?php else: ?>
                                    <div class="w-24 h-16 bg-gray-100 rounded flex items-center justify-center text-xs text-gray-400 mb-2">Geen foto</div>
                                    <?php endif; ?>
                                    <form method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="csrf_token" value="<?= $csrf ?>"/>
                                        <input type="hidden" name="actie" value="upload_slider"/>
                                        <input type="hidden" name="slider_index" value="<?= $i ?>"/>
                                        <input type="hidden" name="kant" value="<?= $kant ?>"/>
                                        <input type="file" name="slider_foto" accept=".jpg,.jpeg,.png,.webp"
                                            class="text-xs text-gray-600 mb-2 block w-full"/>
                                        <button type="submit" class="bg-navy text-white px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-opacity-90 transition-all">
                                            Uploaden
                                        </button>
                                    </form>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="submit" class="mt-4 bg-navy text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-opacity-90 transition-all">
                        Slider info opslaan
                    </button>
                </form>
            </div>
            <?php else: ?>
            <p class="text-gray-500 text-sm py-4">Nog geen sliders aangemaakt. Gebruik het formulier hierboven om er een toe te voegen.</p>
            <?php endif; ?>
        </section>

    </main>

    <footer class="text-center py-6 text-xs text-gray-400 mt-8">
        Jim Ruimt Op — Foto's Beheer | <a href="uitloggen.php" class="hover:text-gray-600">Uitloggen</a>
    </footer>
</body>
</html>
