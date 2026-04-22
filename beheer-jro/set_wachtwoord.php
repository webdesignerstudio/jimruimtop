<?php
/**
 * Wachtwoord-hash generator voor Jim Ruimt Op beheer
 * 
 * GEBRUIK:
 * 1. Open deze pagina in de browser (na inloggen op server)
 * 2. Voer het nieuwe wachtwoord in
 * 3. Kopieer de gegenereerde hash
 * 4. Plak de hash in config.php bij ADMIN_WACHTWOORD_HASH
 * 5. Verwijder of bescherm daarna dit bestand
 * 
 * VEILIGHEID: Verwijder dit bestand van de server na gebruik!
 */

// Eenvoudige IP-check of wachtwoordbeveiliging kan hier worden toegevoegd
// Voor nu: alleen lokaal of met .htaccess beschermd draaien

$hash = '';
$fout = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $wachtwoord = $_POST['wachtwoord'] ?? '';
    $herhaal    = $_POST['herhaal'] ?? '';

    if (strlen($wachtwoord) < 8) {
        $fout = 'Wachtwoord moet minimaal 8 tekens zijn.';
    } elseif ($wachtwoord !== $herhaal) {
        $fout = 'Wachtwoorden komen niet overeen.';
    } else {
        $hash = password_hash($wachtwoord, PASSWORD_BCRYPT, ['cost' => 12]);
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Wachtwoord instellen — Jim Ruimt Op</title>
    <meta name="robots" content="noindex, nofollow"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { theme: { extend: { colors: { navy:'#1A436D', cyan:'#5BCEFF' } } } }</script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="bg-white rounded-2xl shadow-lg p-8 w-full max-w-lg mx-4">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-navy">Wachtwoord instellen</h1>
            <p class="text-gray-500 text-sm mt-1">Jim Ruimt Op — Beheer</p>
        </div>

        <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-6 text-sm text-amber-800">
            <strong>⚠ Let op:</strong> Verwijder dit bestand van de server nadat u het wachtwoord heeft ingesteld!
        </div>

        <?php if ($fout): ?>
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
            <?= htmlspecialchars($fout) ?>
        </div>
        <?php endif; ?>

        <?php if ($hash): ?>
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
            <p class="text-sm font-semibold text-green-800 mb-2">✓ Hash gegenereerd:</p>
            <p class="text-xs font-mono bg-white p-3 rounded border border-green-200 break-all select-all text-gray-700"><?= htmlspecialchars($hash) ?></p>
            <p class="text-xs text-green-700 mt-2">Kopieer deze hash en plak hem in <code>config.php</code> bij <code>ADMIN_WACHTWOORD_HASH</code>.</p>
        </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nieuw wachtwoord (min. 8 tekens)</label>
                <input type="password" name="wachtwoord" required minlength="8" autofocus
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-navy"
                    placeholder="Nieuw wachtwoord"/>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Herhaal wachtwoord</label>
                <input type="password" name="herhaal" required minlength="8"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-navy"
                    placeholder="Wachtwoord herhalen"/>
            </div>
            <button type="submit"
                class="w-full bg-navy text-white py-3 rounded-xl font-bold hover:bg-opacity-90 transition-all">
                Hash genereren
            </button>
        </form>

        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
            <p class="text-xs font-semibold text-gray-600 mb-2">Stappenplan:</p>
            <ol class="text-xs text-gray-500 space-y-1 list-decimal list-inside">
                <li>Vul het gewenste wachtwoord in en klik op "Hash genereren"</li>
                <li>Kopieer de hash (de lange string die verschijnt)</li>
                <li>Open <code>config.php</code> in de map <code>beheer-jro/</code></li>
                <li>Vervang de waarde van <code>ADMIN_WACHTWOORD_HASH</code> door de gekopieerde hash</li>
                <li>Sla config.php op</li>
                <li><strong>Verwijder dit bestand (set_wachtwoord.php) van de server!</strong></li>
            </ol>
        </div>
    </div>
</body>
</html>
