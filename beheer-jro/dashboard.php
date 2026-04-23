<?php
require_once __DIR__ . '/auth.php';

$contact      = laad_json_admin('contact.json');
$teksten      = laad_json_admin('teksten.json');
$locaties     = laad_json_admin('locaties.json');
$instellingen = laad_json_admin('instellingen.json');

$melding = '';
$melding_type = 'groen';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_valideer()) {
        $melding = 'Beveiligingsfout. Probeer opnieuw.';
        $melding_type = 'rood';
    } else {
        $actie = $_POST['actie'] ?? '';

        if ($actie === 'sla_contact_op') {
            $contact['telefoon']       = trim($_POST['telefoon'] ?? '');
            $contact['telefoon_link']  = trim($_POST['telefoon_link'] ?? '');
            $contact['email']          = trim($_POST['email'] ?? '');
            $contact['whatsapp_nummer']  = trim($_POST['whatsapp_nummer'] ?? '');
            $contact['whatsapp_bericht'] = trim($_POST['whatsapp_bericht'] ?? '');
            $contact['adres']          = trim($_POST['adres'] ?? '');
            $contact['werkgebied']     = trim($_POST['werkgebied'] ?? '');
            $contact['openingstijden']['maandag_vrijdag'] = trim($_POST['ot_ma_vr'] ?? '');
            $contact['openingstijden']['zaterdag']        = trim($_POST['ot_zat'] ?? '');
            $contact['openingstijden']['zondag']          = trim($_POST['ot_zon'] ?? '');

            if (sla_json_op_admin('contact.json', $contact)) {
                $melding = 'Contactgegevens opgeslagen.';
            } else {
                $melding = 'Fout bij opslaan. Controleer de schrijfrechten op /content/.';
                $melding_type = 'rood';
            }
        }

        elseif ($actie === 'sla_instellingen_op') {
            $instellingen['toon_fotos_menu'] = isset($_POST['toon_fotos_menu']);
            if (sla_json_op_admin('instellingen.json', $instellingen)) {
                $melding = 'Instellingen opgeslagen.';
            } else {
                $melding = 'Fout bij opslaan. Controleer schrijfrechten op /content/.';
                $melding_type = 'rood';
            }
        }

        elseif ($actie === 'sla_locatie_op') {
            $slug_loc = preg_replace('/[^a-z0-9\-]/', '', strtolower(trim($_POST['slug'] ?? '')));
            $toegestane_slugs = ['berkel-enschot','oisterwijk','goirle','hilvarenbeek','udenhout'];
            if (in_array($slug_loc, $toegestane_slugs, true)) {
                $locaties[$slug_loc]['intro'] = trim($_POST['intro'] ?? '');
                if (sla_json_op_admin('locaties.json', $locaties)) {
                    $melding = 'Intro-tekst voor ' . htmlspecialchars($locaties[$slug_loc]['naam']) . ' opgeslagen.';
                } else {
                    $melding = 'Fout bij opslaan. Controleer schrijfrechten op /content/.';
                    $melding_type = 'rood';
                }
            }
        }

        elseif ($actie === 'sla_teksten_op') {
            $pagina = $_POST['pagina'] ?? '';
            $toegestane_paginas = ['index', 'diensten', 'over_mij', 'contact', 'fotos'];
            if (in_array($pagina, $toegestane_paginas, true)) {
                if (!isset($teksten[$pagina])) $teksten[$pagina] = [];
                $html_velden = ['hero_subtekst', 'verhaal_tekst_1', 'verhaal_tekst_2', 'intro_tekst'];
                foreach ($_POST as $sleutel => $waarde) {
                    if ($sleutel === 'actie' || $sleutel === 'pagina' || $sleutel === 'csrf_token') continue;
                    $waarde = trim($waarde);
                    if (in_array($sleutel, $html_velden, true)) {
                        $waarde = strip_tags($waarde, '<strong><em><br><a>');
                    } else {
                        $waarde = strip_tags($waarde);
                    }
                    $teksten[$pagina][$sleutel] = $waarde;
                }
                if (sla_json_op_admin('teksten.json', $teksten)) {
                    $melding = 'Teksten voor pagina "' . htmlspecialchars($pagina) . '" opgeslagen.';
                } else {
                    $melding = 'Fout bij opslaan. Controleer de schrijfrechten op /content/.';
                    $melding_type = 'rood';
                }
            }
        }
    }
}

$tab = $_GET['tab'] ?? 'contact';
$csrf = csrf_token();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Dashboard — Jim Ruimt Op Beheer</title>
    <meta name="robots" content="noindex, nofollow"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { colors: { navy:'#1A436D', cyan:'#5BCEFF', green:'#7CC19D', cream:'#F4F0E6' } } }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700;800&family=Inter:wght@400;500;600&family=Dancing+Script:wght@500&display=swap" rel="stylesheet"/>
    <style>
        .tab-btn.actief { background-color: #1A436D; color: white; }
        .tab-inhoud { display: none; }
        .tab-inhoud.actief { display: block; }
        .veld-label { @apply block text-sm font-semibold text-gray-700 mb-1; }
        .veld-input { @apply w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy; }
        .veld-textarea { @apply w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy resize-y; }
        /* Live preview */
        .preview-panel { font-family: 'Inter', sans-serif; }
        .preview-panel .pv-headline { font-family: 'Manrope', sans-serif; }
        .preview-panel .pv-script { font-family: 'Dancing Script', cursive; }
        .preview-panel { background: #1A436D; border-radius: 0.75rem; padding: 1.5rem; color: white; }
        .pv-kop { font-size: 1.5rem; font-weight: 800; line-height: 1.2; color: white; word-break: break-word; margin-bottom: 0.5rem; }
        .pv-sub { font-size: 0.9rem; color: rgba(255,255,255,0.75); line-height: 1.5; margin-bottom: 0.75rem; }
        .pv-script-text { font-size: 1.25rem; color: #5BCEFF; margin-bottom: 0.5rem; display: block; }
        .pv-stap-titel { font-family: 'Manrope', sans-serif; font-weight: 700; font-size: 0.9rem; color: #1A436D; }
        .pv-stap-tekst { font-size: 0.8rem; color: #555; }
        .pv-stap-nr { width: 2rem; height: 2rem; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.875rem; }
        .preview-sticky { position: sticky; top: 5rem; }
        .pv-changed { outline: 2px solid #5BCEFF; border-radius: 0.375rem; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

    <!-- Topbar -->
    <header class="bg-navy text-white px-6 py-4 flex justify-between items-center shadow-md sticky top-0 z-40">
        <div class="flex items-center gap-3">
            <span class="font-bold text-lg">Jim Ruimt Op</span>
            <span class="text-white/50 text-sm">| Beheer</span>
        </div>
        <nav class="flex items-center gap-4">
            <a href="dashboard.php" class="text-white/80 hover:text-white text-sm font-medium <?= $tab !== 'fotos' ? 'text-cyan' : '' ?>">Teksten & Contact</a>
            <a href="fotos.php" class="text-white/80 hover:text-white text-sm font-medium">Foto's</a>
            <a href="../index.php" target="_blank" class="text-white/60 hover:text-white text-sm">↗ Website</a>
            <a href="uitloggen.php" class="bg-white/10 hover:bg-white/20 px-4 py-2 rounded-lg text-sm font-medium transition-colors">Uitloggen</a>
        </nav>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-8">

        <?php if ($melding): ?>
        <div class="mb-6 px-4 py-3 rounded-lg text-sm font-medium <?= $melding_type === 'rood' ? 'bg-red-50 border border-red-200 text-red-700' : 'bg-green-50 border border-green-200 text-green-700' ?>">
            <?= htmlspecialchars($melding) ?>
        </div>
        <?php endif; ?>

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-navy mb-1">Teksten & Contactgegevens</h1>
            <p class="text-gray-500 text-sm">Wijzigingen zijn direct zichtbaar op de website.</p>
        </div>

        <!-- Tabs -->
        <div class="flex flex-wrap gap-2 mb-6 border-b border-gray-200 pb-0">
            <?php
            $tabs = [
                'contact'  => 'Contactgegevens',
                'index'    => 'Home',
                'diensten' => 'Diensten',
                'over_mij' => 'Over Mij',
                'contact_teksten' => 'Contact pagina',
                'fotos_teksten'   => "Foto's pagina",
                'locaties'        => 'Locatiepagina\'s',
                'instellingen'    => 'Instellingen',
            ];
            foreach ($tabs as $sleutel => $naam):
            ?>
            <a href="?tab=<?= $sleutel ?>"
               class="tab-btn px-4 py-2 rounded-t-lg text-sm font-medium text-gray-600 hover:bg-gray-100 transition-colors <?= $tab === $sleutel ? 'actief' : '' ?>">
                <?= $naam ?>
            </a>
            <?php endforeach; ?>
        </div>

        <!-- TAB: Contactgegevens -->
        <?php if ($tab === 'contact'): ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-navy mb-4">Contactgegevens</h2>
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= $csrf ?>"/>
                <input type="hidden" name="actie" value="sla_contact_op"/>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Telefoonnummer (weergave)</label>
                        <input type="text" name="telefoon" value="<?= htmlspecialchars($contact['telefoon'] ?? '') ?>"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy"
                            placeholder="06 13 94 31 86"/>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Telefoonnummer (link, bijv. +31613943186)</label>
                        <input type="text" name="telefoon_link" value="<?= htmlspecialchars($contact['telefoon_link'] ?? '') ?>"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy"
                            placeholder="+31613943186"/>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">E-mailadres</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($contact['email'] ?? '') ?>"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy"
                            placeholder="info@jimruimt-op.nl"/>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">WhatsApp nummer (bijv. 31613943186)</label>
                        <input type="text" name="whatsapp_nummer" value="<?= htmlspecialchars($contact['whatsapp_nummer'] ?? '') ?>"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy"
                            placeholder="31613943186"/>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Adres / Stad</label>
                        <input type="text" name="adres" value="<?= htmlspecialchars($contact['adres'] ?? '') ?>"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy"
                            placeholder="Tilburg"/>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Werkgebied</label>
                        <input type="text" name="werkgebied" value="<?= htmlspecialchars($contact['werkgebied'] ?? '') ?>"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy"
                            placeholder="Tilburg & omstreken"/>
                    </div>
                </div>

                <h3 class="text-sm font-bold text-gray-600 uppercase tracking-wide mb-3">Openingstijden</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Maandag – Vrijdag</label>
                        <input type="text" name="ot_ma_vr" value="<?= htmlspecialchars($contact['openingstijden']['maandag_vrijdag'] ?? '') ?>"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy"
                            placeholder="08:00 - 18:00"/>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Zaterdag</label>
                        <input type="text" name="ot_zat" value="<?= htmlspecialchars($contact['openingstijden']['zaterdag'] ?? '') ?>"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy"
                            placeholder="09:00 - 14:00"/>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Zondag</label>
                        <input type="text" name="ot_zon" value="<?= htmlspecialchars($contact['openingstijden']['zondag'] ?? '') ?>"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy"
                            placeholder="Gesloten"/>
                    </div>
                </div>

                <button type="submit" class="bg-navy text-white px-6 py-2.5 rounded-lg font-semibold text-sm hover:bg-opacity-90 transition-all">
                    Contactgegevens opslaan
                </button>
            </form>
        </div>

        <!-- TAB: Home teksten -->
        <?php elseif ($tab === 'index'): ?>
        <?php $v = $teksten['index'] ?? []; ?>
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 items-start">
            <!-- Editor kolom -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-navy mb-4">Home pagina — teksten</h2>
                <form method="POST" id="form-index">
                    <input type="hidden" name="csrf_token" value="<?= $csrf ?>"/>
                    <input type="hidden" name="actie" value="sla_teksten_op"/>
                    <input type="hidden" name="pagina" value="index"/>
                    <div class="space-y-4">
                        <?php
                        $velden = [
                            'hero_kop'          => ['Hero — bedrijfsnaam / kop', 'text'],
                            'hero_tagline'      => ['Hero — tagline (cursief onder kop)', 'text'],
                            'hero_quote'        => ['Hero — citaat onderaan foto', 'text'],
                            'diensten_kop'      => ['Diensten sectie — kop', 'text'],
                            'diensten_subtekst' => ['Diensten sectie — subtekst', 'textarea'],
                            'hoe_werkt_kop'     => ['Hoe werkt het — kop', 'text'],
                            'hoe_werkt_subtekst'=> ['Hoe werkt het — subtekst', 'text'],
                            'stap1_kop'         => ['Stap 1 — kop', 'text'],
                            'stap1_tekst'       => ['Stap 1 — tekst', 'textarea'],
                            'stap2_kop'         => ['Stap 2 — kop', 'text'],
                            'stap2_tekst'       => ['Stap 2 — tekst', 'textarea'],
                            'stap3_kop'         => ['Stap 3 — kop', 'text'],
                            'stap3_tekst'       => ['Stap 3 — tekst', 'textarea'],
                        ];
                        foreach ($velden as $sleutel => [$label, $type]):
                        ?>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1"><?= htmlspecialchars($label) ?></label>
                            <?php if ($type === 'textarea'): ?>
                            <textarea name="<?= $sleutel ?>" data-preview="<?= $sleutel ?>" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy resize-y"><?= htmlspecialchars($v[$sleutel] ?? '') ?></textarea>
                            <?php else: ?>
                            <input type="text" name="<?= $sleutel ?>" data-preview="<?= $sleutel ?>" value="<?= htmlspecialchars($v[$sleutel] ?? '') ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy"/>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="submit" class="mt-6 bg-navy text-white px-6 py-2.5 rounded-lg font-semibold text-sm hover:bg-opacity-90 transition-all">
                        Home teksten opslaan
                    </button>
                </form>
            </div>
            <!-- Preview kolom -->
            <div class="preview-sticky space-y-4">
                <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-1">Live preview</p>
                <!-- Hero preview -->
                <div class="preview-panel">
                    <div class="pv-kop pv-headline" id="pv-hero_kop"><?= htmlspecialchars($v['hero_kop'] ?? '') ?></div>
                    <div class="mt-1 mb-2" style="font-family:'Dancing Script',cursive;font-size:1.1rem;color:#5BCEFF" id="pv-hero_tagline"><?= htmlspecialchars($v['hero_tagline'] ?? '') ?></div>
                    <div class="mt-3 text-xs italic text-white/50" id="pv-hero_quote">"<?= htmlspecialchars($v['hero_quote'] ?? '') ?>"</div>
                </div>
                <!-- Diensten preview -->
                <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
                    <div class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-2">Diensten sectie</div>
                    <div class="font-bold text-navy text-base pv-headline" id="pv-diensten_kop"><?= htmlspecialchars($v['diensten_kop'] ?? '') ?></div>
                    <div class="text-sm text-gray-500 mt-1" id="pv-diensten_subtekst"><?= htmlspecialchars($v['diensten_subtekst'] ?? '') ?></div>
                </div>
                <!-- Stappen preview -->
                <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
                    <div class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-3">Stappenplan</div>
                    <div class="space-y-3">
                        <?php foreach ([1,2,3] as $i): $kleur = $i===2 ? '#5BCEFF' : '#1A436D'; $tc = $i===2 ? '#1A436D' : 'white'; ?>
                        <div class="flex items-start gap-3">
                            <span class="pv-stap-nr flex-shrink-0" style="background:<?= $kleur ?>;color:<?= $tc ?>"><?= $i ?></span>
                            <div>
                                <div class="pv-stap-titel" id="pv-stap<?= $i ?>_kop"><?= htmlspecialchars($v["stap{$i}_kop"] ?? '') ?></div>
                                <div class="pv-stap-tekst" id="pv-stap<?= $i ?>_tekst"><?= htmlspecialchars($v["stap{$i}_tekst"] ?? '') ?></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB: Over Mij teksten -->
        <?php elseif ($tab === 'over_mij'): ?>
        <?php $v = $teksten['over_mij'] ?? []; ?>
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 items-start">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-navy mb-4">Over Mij pagina — teksten</h2>
                <form method="POST">
                    <input type="hidden" name="csrf_token" value="<?= $csrf ?>"/>
                    <input type="hidden" name="actie" value="sla_teksten_op"/>
                    <input type="hidden" name="pagina" value="over_mij"/>
                    <div class="space-y-4">
                        <?php
                        $velden = [
                            'hero_script'        => ['Hero — script tekst', 'text'],
                            'hero_kop'           => ['Hero — kop', 'text'],
                            'hero_subtekst'      => ['Hero — subtekst', 'textarea'],
                            'verhaal_kop'        => ['Verhaal — kop', 'text'],
                            'verhaal_tekst_1'    => ['Verhaal — eerste alinea', 'textarea'],
                            'verhaal_tekst_2'    => ['Verhaal — tweede alinea', 'textarea'],
                            'belofte_kop'        => ['Beloften — kop', 'text'],
                            'belofte_1'          => ['Belofte 1', 'text'],
                            'belofte_2'          => ['Belofte 2', 'text'],
                            'belofte_3'          => ['Belofte 3', 'text'],
                            'werkwijze_kop'      => ['Werkwijze — kop', 'text'],
                            'werkwijze_subtekst' => ['Werkwijze — subtekst', 'textarea'],
                            'waarde1_kop'        => ['Waarde 1 — kop', 'text'],
                            'waarde1_tekst'      => ['Waarde 1 — tekst', 'textarea'],
                            'waarde2_kop'        => ['Waarde 2 — kop', 'text'],
                            'waarde2_tekst'      => ['Waarde 2 — tekst', 'textarea'],
                            'waarde3_kop'        => ['Waarde 3 — kop', 'text'],
                            'waarde3_tekst'      => ['Waarde 3 — tekst', 'textarea'],
                            'quote_jim'          => ['Citaat van Jim', 'text'],
                            'kvk_nummer'         => ['KvK nummer', 'text'],
                        ];
                        foreach ($velden as $sleutel => [$label, $type]):
                        ?>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1"><?= htmlspecialchars($label) ?></label>
                            <?php if ($type === 'textarea'): ?>
                            <textarea name="<?= $sleutel ?>" data-preview="<?= $sleutel ?>" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy resize-y"><?= htmlspecialchars($v[$sleutel] ?? '') ?></textarea>
                            <?php else: ?>
                            <input type="text" name="<?= $sleutel ?>" data-preview="<?= $sleutel ?>" value="<?= htmlspecialchars($v[$sleutel] ?? '') ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy"/>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="submit" class="mt-6 bg-navy text-white px-6 py-2.5 rounded-lg font-semibold text-sm hover:bg-opacity-90 transition-all">
                        Over Mij teksten opslaan
                    </button>
                </form>
            </div>
            <div class="preview-sticky space-y-4">
                <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-1">Live preview</p>
                <div class="preview-panel">
                    <span class="pv-script-text pv-script" id="pv-hero_script"><?= htmlspecialchars($v['hero_script'] ?? '') ?></span>
                    <div class="pv-kop pv-headline" id="pv-hero_kop"><?= htmlspecialchars($v['hero_kop'] ?? '') ?></div>
                    <div class="pv-sub mt-2" id="pv-hero_subtekst"><?= htmlspecialchars($v['hero_subtekst'] ?? '') ?></div>
                </div>
                <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
                    <div class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-2">Verhaal</div>
                    <div class="font-bold text-navy text-sm pv-headline mb-2" id="pv-verhaal_kop"><?= htmlspecialchars($v['verhaal_kop'] ?? '') ?></div>
                    <div class="text-sm text-gray-600 mb-2" id="pv-verhaal_tekst_1"><?= htmlspecialchars($v['verhaal_tekst_1'] ?? '') ?></div>
                    <div class="text-sm text-gray-600" id="pv-verhaal_tekst_2"><?= htmlspecialchars($v['verhaal_tekst_2'] ?? '') ?></div>
                </div>
                <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
                    <div class="font-bold text-navy text-sm pv-headline mb-2" id="pv-belofte_kop"><?= htmlspecialchars($v['belofte_kop'] ?? '') ?></div>
                    <ul class="space-y-1 text-sm text-gray-600">
                        <li class="flex items-start gap-2"><span class="text-cyan font-bold mt-0.5">&#10003;</span><span id="pv-belofte_1"><?= htmlspecialchars($v['belofte_1'] ?? '') ?></span></li>
                        <li class="flex items-start gap-2"><span class="text-cyan font-bold mt-0.5">&#10003;</span><span id="pv-belofte_2"><?= htmlspecialchars($v['belofte_2'] ?? '') ?></span></li>
                        <li class="flex items-start gap-2"><span class="text-cyan font-bold mt-0.5">&#10003;</span><span id="pv-belofte_3"><?= htmlspecialchars($v['belofte_3'] ?? '') ?></span></li>
                    </ul>
                </div>
                <div class="bg-navy rounded-xl p-4 text-white text-sm italic text-center" id="pv-quote_jim">"<?= htmlspecialchars($v['quote_jim'] ?? '') ?>"</div>
            </div>
        </div>

        <!-- TAB: Contact pagina teksten -->
        <?php elseif ($tab === 'contact_teksten'): ?>
        <?php $v = $teksten['contact'] ?? []; ?>
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 items-start">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-navy mb-4">Contact pagina — teksten</h2>
                <form method="POST">
                    <input type="hidden" name="csrf_token" value="<?= $csrf ?>"/>
                    <input type="hidden" name="actie" value="sla_teksten_op"/>
                    <input type="hidden" name="pagina" value="contact"/>
                    <div class="space-y-4">
                        <?php
                        $velden = [
                            'hero_script'  => ['Hero — script tekst', 'text'],
                            'hero_kop'     => ['Hero — kop', 'text'],
                            'hero_subtekst'=> ['Hero — subtekst', 'textarea'],
                            'jim_quote'    => ['Jim zijn citaat op de contactpagina', 'textarea'],
                        ];
                        foreach ($velden as $sleutel => [$label, $type]):
                        ?>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1"><?= htmlspecialchars($label) ?></label>
                            <?php if ($type === 'textarea'): ?>
                            <textarea name="<?= $sleutel ?>" data-preview="<?= $sleutel ?>" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy resize-y"><?= htmlspecialchars($v[$sleutel] ?? '') ?></textarea>
                            <?php else: ?>
                            <input type="text" name="<?= $sleutel ?>" data-preview="<?= $sleutel ?>" value="<?= htmlspecialchars($v[$sleutel] ?? '') ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy"/>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="submit" class="mt-6 bg-navy text-white px-6 py-2.5 rounded-lg font-semibold text-sm hover:bg-opacity-90 transition-all">
                        Contact teksten opslaan
                    </button>
                </form>
            </div>
            <div class="preview-sticky space-y-4">
                <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-1">Live preview</p>
                <div class="preview-panel">
                    <span class="pv-script-text pv-script" id="pv-hero_script"><?= htmlspecialchars($v['hero_script'] ?? '') ?></span>
                    <div class="pv-kop pv-headline" id="pv-hero_kop"><?= htmlspecialchars($v['hero_kop'] ?? '') ?></div>
                    <div class="pv-sub mt-2" id="pv-hero_subtekst"><?= htmlspecialchars($v['hero_subtekst'] ?? '') ?></div>
                </div>
                <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
                    <div class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-2">Jim zijn citaat</div>
                    <p class="text-sm text-gray-600 italic" id="pv-jim_quote">"<?= htmlspecialchars($v['jim_quote'] ?? '') ?>"</p>
                </div>
            </div>
        </div>

        <!-- TAB: Foto's pagina teksten -->
        <?php elseif ($tab === 'fotos_teksten'): ?>
        <?php $v = $teksten['fotos'] ?? []; ?>
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 items-start">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-navy mb-4">Foto's pagina — teksten</h2>
                <form method="POST">
                    <input type="hidden" name="csrf_token" value="<?= $csrf ?>"/>
                    <input type="hidden" name="actie" value="sla_teksten_op"/>
                    <input type="hidden" name="pagina" value="fotos"/>
                    <div class="space-y-4">
                        <?php
                        $velden = [
                            'hero_script'      => ['Hero — script tekst', 'text'],
                            'hero_kop'         => ['Hero — kop', 'text'],
                            'hero_subtekst'    => ['Hero — subtekst', 'textarea'],
                            'gallerij_kop'     => ['Galerij — kop', 'text'],
                            'gallerij_subtekst'=> ['Galerij — subtekst', 'text'],
                            'cta_script'       => ['CTA — script tekst', 'text'],
                            'cta_kop'          => ['CTA — kop', 'text'],
                            'cta_tekst'        => ['CTA — tekst', 'textarea'],
                        ];
                        foreach ($velden as $sleutel => [$label, $type]):
                        ?>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1"><?= htmlspecialchars($label) ?></label>
                            <?php if ($type === 'textarea'): ?>
                            <textarea name="<?= $sleutel ?>" data-preview="<?= $sleutel ?>" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy resize-y"><?= htmlspecialchars($v[$sleutel] ?? '') ?></textarea>
                            <?php else: ?>
                            <input type="text" name="<?= $sleutel ?>" data-preview="<?= $sleutel ?>" value="<?= htmlspecialchars($v[$sleutel] ?? '') ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy"/>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="submit" class="mt-6 bg-navy text-white px-6 py-2.5 rounded-lg font-semibold text-sm hover:bg-opacity-90 transition-all">
                        Foto's pagina teksten opslaan
                    </button>
                </form>
            </div>
            <div class="preview-sticky space-y-4">
                <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-1">Live preview</p>
                <div class="preview-panel">
                    <span class="pv-script-text pv-script" id="pv-hero_script"><?= htmlspecialchars($v['hero_script'] ?? '') ?></span>
                    <div class="pv-kop pv-headline" id="pv-hero_kop"><?= htmlspecialchars($v['hero_kop'] ?? '') ?></div>
                    <div class="pv-sub mt-2" id="pv-hero_subtekst"><?= htmlspecialchars($v['hero_subtekst'] ?? '') ?></div>
                </div>
                <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
                    <div class="font-bold text-navy text-sm pv-headline" id="pv-gallerij_kop"><?= htmlspecialchars($v['gallerij_kop'] ?? '') ?></div>
                    <div class="text-xs text-gray-500 mt-1" id="pv-gallerij_subtekst"><?= htmlspecialchars($v['gallerij_subtekst'] ?? '') ?></div>
                </div>
                <div class="bg-navy rounded-xl p-4 text-white">
                    <span class="pv-script-text pv-script text-sm" id="pv-cta_script"><?= htmlspecialchars($v['cta_script'] ?? '') ?></span>
                    <div class="font-bold text-base pv-headline" id="pv-cta_kop"><?= htmlspecialchars($v['cta_kop'] ?? '') ?></div>
                    <div class="text-sm text-white/75 mt-1" id="pv-cta_tekst"><?= htmlspecialchars($v['cta_tekst'] ?? '') ?></div>
                </div>
            </div>
        </div>

        <!-- TAB: Diensten teksten -->
        <?php elseif ($tab === 'diensten'): ?>
        <?php $v = $teksten['diensten'] ?? []; ?>
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 items-start">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-navy mb-4">Diensten pagina — teksten</h2>
                <form method="POST">
                    <input type="hidden" name="csrf_token" value="<?= $csrf ?>"/>
                    <input type="hidden" name="actie" value="sla_teksten_op"/>
                    <input type="hidden" name="pagina" value="diensten"/>
                    <div class="space-y-4">
                        <?php
                        $velden = [
                            'hero_kop'     => ['Hero — kop', 'text'],
                            'hero_subtekst'=> ['Hero — subtekst', 'textarea'],
                            'intro_kop'    => ['Intro — kop', 'text'],
                            'intro_tekst'  => ['Intro — tekst', 'textarea'],
                        ];
                        foreach ($velden as $sleutel => [$label, $type]):
                        ?>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1"><?= htmlspecialchars($label) ?></label>
                            <?php if ($type === 'textarea'): ?>
                            <textarea name="<?= $sleutel ?>" data-preview="<?= $sleutel ?>" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy resize-y"><?= htmlspecialchars($v[$sleutel] ?? '') ?></textarea>
                            <?php else: ?>
                            <input type="text" name="<?= $sleutel ?>" data-preview="<?= $sleutel ?>" value="<?= htmlspecialchars($v[$sleutel] ?? '') ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy"/>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="submit" class="mt-6 bg-navy text-white px-6 py-2.5 rounded-lg font-semibold text-sm hover:bg-opacity-90 transition-all">
                        Diensten teksten opslaan
                    </button>
                </form>
            </div>
            <div class="preview-sticky space-y-4">
                <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-1">Live preview</p>
                <div class="preview-panel">
                    <div class="pv-kop pv-headline" id="pv-hero_kop"><?= htmlspecialchars($v['hero_kop'] ?? '') ?></div>
                    <div class="pv-sub mt-2" id="pv-hero_subtekst"><?= htmlspecialchars($v['hero_subtekst'] ?? '') ?></div>
                </div>
                <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
                    <div class="font-bold text-navy text-sm pv-headline mb-1" id="pv-intro_kop"><?= htmlspecialchars($v['intro_kop'] ?? '') ?></div>
                    <div class="text-sm text-gray-600" id="pv-intro_tekst"><?= htmlspecialchars($v['intro_tekst'] ?? '') ?></div>
                </div>
            </div>
        </div>
        <!-- TAB: Locatiepagina's -->
        <!-- TAB: Instellingen -->
        <?php elseif ($tab === 'instellingen'): ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-navy mb-2">Instellingen</h2>
            <p class="text-sm text-gray-500 mb-6">Beheer de zichtbaarheid van menu-items en andere website-opties.</p>
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= $csrf ?>"/>
                <input type="hidden" name="actie" value="sla_instellingen_op"/>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-xl">
                        <div>
                            <p class="font-semibold text-gray-800 text-sm">Foto's pagina tonen in menu</p>
                            <p class="text-xs text-gray-500 mt-0.5">Als uitgeschakeld verdwijnt "Foto's" uit de navigatie op alle pagina's.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer ml-4">
                            <input type="checkbox" name="toon_fotos_menu" value="1" <?= !empty($instellingen['toon_fotos_menu']) ? 'checked' : '' ?> class="sr-only peer"/>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:bg-navy after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-full"></div>
                        </label>
                    </div>
                </div>
                <button type="submit" class="mt-6 bg-navy text-white px-6 py-2.5 rounded-lg font-semibold text-sm hover:bg-opacity-90 transition-all">
                    Instellingen opslaan
                </button>
            </form>
        </div>

        <?php elseif ($tab === 'locaties'): ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-navy mb-2">Locatiepagina's — intro-teksten</h2>
            <p class="text-sm text-gray-500 mb-6">Pas de unieke intro-tekst per locatiepagina aan. Deze tekst verschijnt bovenaan de pagina en is belangrijk voor SEO.</p>
            <?php
            $loc_namen = [
                'berkel-enschot' => 'Berkel-Enschot',
                'oisterwijk'     => 'Oisterwijk',
                'goirle'         => 'Goirle',
                'hilvarenbeek'   => 'Hilvarenbeek',
                'udenhout'       => 'Udenhout',
            ];
            foreach ($loc_namen as $slug_l => $naam_l):
                $intro_huidig = $locaties[$slug_l]['intro'] ?? '';
            ?>
            <div class="mb-6 border border-gray-100 rounded-xl p-5">
                <h3 class="font-bold text-navy mb-3"><?= htmlspecialchars($naam_l) ?></h3>
                <form method="POST">
                    <input type="hidden" name="csrf_token" value="<?= $csrf ?>"/>
                    <input type="hidden" name="actie" value="sla_locatie_op"/>
                    <input type="hidden" name="slug" value="<?= $slug_l ?>"/>
                    <div class="mb-3">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Intro-tekst (zichtbaar op de pagina)</label>
                        <textarea name="intro" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy resize-y"><?= htmlspecialchars($intro_huidig) ?></textarea>
                    </div>
                    <button type="submit" class="bg-navy text-white px-5 py-2 rounded-lg font-semibold text-sm hover:bg-opacity-90 transition-all">
                        <?= htmlspecialchars($naam_l) ?> opslaan
                    </button>
                </form>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    </main>

    <footer class="text-center py-6 text-xs text-gray-400 mt-8">
        Jim Ruimt Op — Beheer | <a href="uitloggen.php" class="hover:text-gray-600">Uitloggen</a>
    </footer>

    <script>
    (function () {
        const HTML_VELDEN = ['hero_subtekst', 'verhaal_tekst_1', 'verhaal_tekst_2', 'intro_tekst'];

        function stripDangerous(html) {
            const tmp = document.createElement('div');
            tmp.innerHTML = html;
            tmp.querySelectorAll('script,style,iframe,object,embed,form').forEach(el => el.remove());
            return tmp.innerHTML;
        }

        function updatePreview(el) {
            const key = el.dataset.preview;
            if (!key) return;
            const target = document.getElementById('pv-' + key);
            if (!target) return;

            let val = el.value;

            if (HTML_VELDEN.includes(key)) {
                target.innerHTML = stripDangerous(val);
            } else {
                if (key === 'hero_quote' || key === 'jim_quote' || key === 'quote_jim') {
                    target.textContent = '"' + val + '"';
                } else {
                    target.textContent = val;
                }
            }

            target.classList.add('pv-changed');
            clearTimeout(target._pvTimer);
            target._pvTimer = setTimeout(() => target.classList.remove('pv-changed'), 1200);
        }

        document.querySelectorAll('[data-preview]').forEach(el => {
            el.addEventListener('input', () => updatePreview(el));
        });
    })();
    </script>
</body>
</html>
