<?php
/**
 * Admin login pagina
 */
require_once __DIR__ . '/config.php';

session_name(SESSION_NAAM);
session_start();

// Al ingelogd? Stuur door
if (!empty($_SESSION['ingelogd'])) {
    header('Location: dashboard.php');
    exit;
}

$fout = '';
$timeout = isset($_GET['timeout']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Geen CSRF nodig op login zelf, maar valideer wel POST
    $wachtwoord = $_POST['wachtwoord'] ?? '';

    if (password_verify($wachtwoord, ADMIN_WACHTWOORD_HASH)) {
        session_regenerate_id(true);
        $_SESSION['ingelogd'] = true;
        $_SESSION['laatste_activiteit'] = time();
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        header('Location: dashboard.php');
        exit;
    } else {
        // Kort vertraag om brute-force te remmen
        sleep(1);
        $fout = 'Onjuist wachtwoord. Probeer opnieuw.';
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8"/>
    <link rel="icon" type="image/x-icon" href="/favicon.ico"/>
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Beheer — Jim Ruimt Op</title>
    <meta name="robots" content="noindex, nofollow"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { colors: { navy:'#1A436D', cyan:'#5BCEFF', green:'#7CC19D' } } }
        }
    </script>
</head>
<body class="min-h-screen flex items-center justify-center" style="background: linear-gradient(135deg, #1A436D 0%, #0f2942 100%)">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-sm mx-4">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-navy rounded-full flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
            <h1 class="text-2xl font-bold text-navy">Jim Ruimt Op</h1>
            <p class="text-gray-500 text-sm mt-1">Websitebeheer</p>
        </div>

        <?php if ($timeout): ?>
        <div class="bg-amber-50 border border-amber-200 text-amber-700 px-4 py-3 rounded-lg mb-4 text-sm">
            Uw sessie is verlopen. Log opnieuw in.
        </div>
        <?php endif; ?>

        <?php if ($fout): ?>
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
            <?= htmlspecialchars($fout) ?>
        </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-4">
                <label for="wachtwoord" class="block text-sm font-semibold text-gray-700 mb-2">Wachtwoord</label>
                <input type="password" id="wachtwoord" name="wachtwoord" required autofocus
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent"
                    placeholder="Uw wachtwoord"/>
            </div>
            <button type="submit"
                class="w-full bg-navy text-white py-3 rounded-xl font-bold hover:bg-opacity-90 transition-all">
                Inloggen
            </button>
        </form>

        <p class="text-center text-xs text-gray-400 mt-6">Jim Ruimt Op — Websitebeheer</p>
    </div>
</body>
</html>
