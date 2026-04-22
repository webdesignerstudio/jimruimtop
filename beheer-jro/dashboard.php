<?php
require_once __DIR__ . '/auth.php';

$contact = laad_json_admin('contact.json');
$teksten = laad_json_admin('teksten.json');

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

        elseif ($actie === 'sla_teksten_op') {
            $pagina = $_POST['pagina'] ?? '';
            $toegestane_paginas = ['index', 'diensten', 'over_mij', 'contact', 'fotos'];
            if (in_array($pagina, $toegestane_paginas, true)) {
                if (!isset($teksten[$pagina])) $teksten[$pagina] = [];
                foreach ($_POST as $sleutel => $waarde) {
                    if ($sleutel === 'actie' || $sleutel === 'pagina' || $sleutel === 'csrf_token') continue;
                    $teksten[$pagina][$sleutel] = trim($waarde);
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
    <style>
        .tab-btn.actief { background-color: #1A436D; color: white; }
        .tab-inhoud { display: none; }
        .tab-inhoud.actief { display: block; }
        .veld-label { @apply block text-sm font-semibold text-gray-700 mb-1; }
        .veld-input { @apply w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy; }
        .veld-textarea { @apply w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy resize-y; }
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

    <main class="max-w-5xl mx-auto px-6 py-8">

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
                            placeholder="06 12 34 56 78"/>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Telefoonnummer (link, bijv. +31612345678)</label>
                        <input type="text" name="telefoon_link" value="<?= htmlspecialchars($contact['telefoon_link'] ?? '') ?>"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy"
                            placeholder="+31612345678"/>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">E-mailadres</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($contact['email'] ?? '') ?>"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy"
                            placeholder="info@jimruimtop.nl"/>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">WhatsApp nummer (bijv. 31612345678)</label>
                        <input type="text" name="whatsapp_nummer" value="<?= htmlspecialchars($contact['whatsapp_nummer'] ?? '') ?>"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy"
                            placeholder="31612345678"/>
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
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-navy mb-4">Home pagina — teksten</h2>
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= $csrf ?>"/>
                <input type="hidden" name="actie" value="sla_teksten_op"/>
                <input type="hidden" name="pagina" value="index"/>
                <?php $v = $teksten['index'] ?? []; ?>
                <div class="space-y-4">
                    <?php
                    $velden = [
                        'hero_script'       => ['Hero — script tekst (klein cursief)', 'text'],
                        'hero_kop_regel1'   => ['Hero — kop regel 1', 'text'],
                        'hero_kop_regel2'   => ['Hero — kop regel 2 (blauw)', 'text'],
                        'hero_kop_regel3'   => ['Hero — kop regel 3', 'text'],
                        'hero_subtekst'     => ['Hero — subtekst (mag HTML)', 'textarea'],
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
                        <textarea name="<?= $sleutel ?>" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy resize-y"><?= htmlspecialchars($v[$sleutel] ?? '') ?></textarea>
                        <?php else: ?>
                        <input type="text" name="<?= $sleutel ?>" value="<?= htmlspecialchars($v[$sleutel] ?? '') ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy"/>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="submit" class="mt-6 bg-navy text-white px-6 py-2.5 rounded-lg font-semibold text-sm hover:bg-opacity-90 transition-all">
                    Home teksten opslaan
                </button>
            </form>
        </div>

        <!-- TAB: Over Mij teksten -->
        <?php elseif ($tab === 'over_mij'): ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-navy mb-4">Over Mij pagina — teksten</h2>
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= $csrf ?>"/>
                <input type="hidden" name="actie" value="sla_teksten_op"/>
                <input type="hidden" name="pagina" value="over_mij"/>
                <?php $v = $teksten['over_mij'] ?? []; ?>
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
                        <textarea name="<?= $sleutel ?>" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy resize-y"><?= htmlspecialchars($v[$sleutel] ?? '') ?></textarea>
                        <?php else: ?>
                        <input type="text" name="<?= $sleutel ?>" value="<?= htmlspecialchars($v[$sleutel] ?? '') ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy"/>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="submit" class="mt-6 bg-navy text-white px-6 py-2.5 rounded-lg font-semibold text-sm hover:bg-opacity-90 transition-all">
                    Over Mij teksten opslaan
                </button>
            </form>
        </div>

        <!-- TAB: Contact pagina teksten -->
        <?php elseif ($tab === 'contact_teksten'): ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-navy mb-4">Contact pagina — teksten</h2>
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= $csrf ?>"/>
                <input type="hidden" name="actie" value="sla_teksten_op"/>
                <input type="hidden" name="pagina" value="contact"/>
                <?php $v = $teksten['contact'] ?? []; ?>
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
                        <textarea name="<?= $sleutel ?>" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy resize-y"><?= htmlspecialchars($v[$sleutel] ?? '') ?></textarea>
                        <?php else: ?>
                        <input type="text" name="<?= $sleutel ?>" value="<?= htmlspecialchars($v[$sleutel] ?? '') ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy"/>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="submit" class="mt-6 bg-navy text-white px-6 py-2.5 rounded-lg font-semibold text-sm hover:bg-opacity-90 transition-all">
                    Contact teksten opslaan
                </button>
            </form>
        </div>

        <!-- TAB: Foto's pagina teksten -->
        <?php elseif ($tab === 'fotos_teksten'): ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-navy mb-4">Foto's pagina — teksten</h2>
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= $csrf ?>"/>
                <input type="hidden" name="actie" value="sla_teksten_op"/>
                <input type="hidden" name="pagina" value="fotos"/>
                <?php $v = $teksten['fotos'] ?? []; ?>
                <div class="space-y-4">
                    <?php
                    $velden = [
                        'hero_script'     => ['Hero — script tekst', 'text'],
                        'hero_kop'        => ['Hero — kop', 'text'],
                        'hero_subtekst'   => ['Hero — subtekst', 'textarea'],
                        'gallerij_kop'    => ['Galerij — kop', 'text'],
                        'gallerij_subtekst'=> ['Galerij — subtekst', 'text'],
                        'cta_script'      => ['CTA — script tekst', 'text'],
                        'cta_kop'         => ['CTA — kop', 'text'],
                        'cta_tekst'       => ['CTA — tekst', 'textarea'],
                    ];
                    foreach ($velden as $sleutel => [$label, $type]):
                    ?>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1"><?= htmlspecialchars($label) ?></label>
                        <?php if ($type === 'textarea'): ?>
                        <textarea name="<?= $sleutel ?>" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy resize-y"><?= htmlspecialchars($v[$sleutel] ?? '') ?></textarea>
                        <?php else: ?>
                        <input type="text" name="<?= $sleutel ?>" value="<?= htmlspecialchars($v[$sleutel] ?? '') ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy"/>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="submit" class="mt-6 bg-navy text-white px-6 py-2.5 rounded-lg font-semibold text-sm hover:bg-opacity-90 transition-all">
                    Foto's pagina teksten opslaan
                </button>
            </form>
        </div>

        <!-- TAB: Diensten teksten -->
        <?php elseif ($tab === 'diensten'): ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-navy mb-4">Diensten pagina — teksten</h2>
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= $csrf ?>"/>
                <input type="hidden" name="actie" value="sla_teksten_op"/>
                <input type="hidden" name="pagina" value="diensten"/>
                <?php $v = $teksten['diensten'] ?? []; ?>
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
                        <textarea name="<?= $sleutel ?>" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy resize-y"><?= htmlspecialchars($v[$sleutel] ?? '') ?></textarea>
                        <?php else: ?>
                        <input type="text" name="<?= $sleutel ?>" value="<?= htmlspecialchars($v[$sleutel] ?? '') ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-navy"/>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button type="submit" class="mt-6 bg-navy text-white px-6 py-2.5 rounded-lg font-semibold text-sm hover:bg-opacity-90 transition-all">
                    Diensten teksten opslaan
                </button>
            </form>
        </div>
        <?php endif; ?>

    </main>

    <footer class="text-center py-6 text-xs text-gray-400 mt-8">
        Jim Ruimt Op — Beheer | <a href="uitloggen.php" class="hover:text-gray-600">Uitloggen</a>
    </footer>
</body>
</html>
