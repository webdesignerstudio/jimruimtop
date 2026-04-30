<?php
/**
 * Jim Ruimt Op — Gedeelde helper functies
 */

define('CONTENT_DIR', __DIR__ . '/../content/');
define('UPLOADS_DIR', __DIR__ . '/../uploads/gallerij/');
define('UPLOADS_URL', 'uploads/gallerij/');

/**
 * Laad een JSON content-bestand veilig.
 * Geeft altijd een array terug, ook als het bestand ontbreekt of corrupt is.
 */
function laad_json(string $bestand): array {
    $pad = CONTENT_DIR . $bestand;
    if (!file_exists($pad)) {
        return [];
    }
    $inhoud = file_get_contents($pad);
    if ($inhoud === false) {
        return [];
    }
    $data = json_decode($inhoud, true);
    return is_array($data) ? $data : [];
}

/**
 * Sla JSON atomisch op: schrijf naar tijdelijk bestand, maak backup, hernoem.
 */
function sla_json_op(string $bestand, mixed $data): bool {
    $pad = CONTENT_DIR . $bestand;
    $tijdelijk = $pad . '.tmp';
    $backup = $pad . '.bak';

    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json === false) {
        return false;
    }

    if (file_put_contents($tijdelijk, $json, LOCK_EX) === false) {
        return false;
    }

    // Maak backup van huidige versie
    if (file_exists($pad)) {
        copy($pad, $backup);
    }

    // Atomische vervanging
    return rename($tijdelijk, $pad);
}

/**
 * Haal een waarde op uit een geneste array met een fallback.
 */
function t(array $arr, string $sleutel, string $fallback = ''): string {
    return isset($arr[$sleutel]) ? htmlspecialchars((string)$arr[$sleutel], ENT_QUOTES, 'UTF-8') : htmlspecialchars($fallback, ENT_QUOTES, 'UTF-8');
}

/**
 * Haal een waarde op zonder HTML-escaping (voor velden die HTML bevatten).
 */
function t_html(array $arr, string $sleutel, string $fallback = ''): string {
    return isset($arr[$sleutel]) ? (string)$arr[$sleutel] : $fallback;
}

/**
 * Geeft de juiste URL terug voor een afbeelding (uploads of root).
 */
function afbeelding_url(string $bestandsnaam): string {
    // Check of het een uploaded afbeelding is
    if (file_exists(UPLOADS_DIR . $bestandsnaam)) {
        return UPLOADS_URL . htmlspecialchars($bestandsnaam, ENT_QUOTES, 'UTF-8');
    }
    // Anders root-map (originele afbeeldingen)
    return htmlspecialchars($bestandsnaam, ENT_QUOTES, 'UTF-8');
}

/**
 * Genereer WhatsApp URL
 */
function whatsapp_url(array $contact): string {
    $nummer = $contact['whatsapp_nummer'] ?? '31613943186';
    $bericht = $contact['whatsapp_bericht'] ?? 'Hallo%20Jim%2C%20ik%20heb%20een%20vraag%20over%20woningontruiming';
    return 'https://wa.me/' . htmlspecialchars($nummer, ENT_QUOTES, 'UTF-8') . '?text=' . $bericht;
}

/**
 * Genereer tel: link
 */
function tel_link(array $contact): string {
    return 'tel:' . htmlspecialchars($contact['telefoon_link'] ?? '+31613943186', ENT_QUOTES, 'UTF-8');
}

/**
 * Rate limiting: max $max_per_uur submissions per IP per uur.
 * Slaat data op in /content/rate_limit.json (geblokkeerd via .htaccess).
 * Geeft true terug als het mag, false als het geblokkeerd is.
 */
function rate_limit_ok(string $actie = 'form', int $max_per_uur = 5): bool
{
    $pad    = CONTENT_DIR . 'rate_limit.json';
    $nu     = time();
    $ip     = $_SERVER['REMOTE_ADDR'] ?? 'onbekend';
    $sleutel = $actie . '_' . md5($ip);

    $data = [];
    if (file_exists($pad)) {
        $inhoud = file_get_contents($pad);
        $data   = json_decode($inhoud ?: '{}', true) ?: [];
    }

    // Verwijder oude entries (ouder dan 1 uur)
    $data = array_filter($data, fn($r) => ($r['ts'] ?? 0) > $nu - 3600);

    // Tel hits voor deze IP+actie
    $hits = array_filter($data, fn($r) => ($r['k'] ?? '') === $sleutel);
    if (count($hits) >= $max_per_uur) {
        return false;
    }

    // Registreer nieuwe hit
    $data[] = ['k' => $sleutel, 'ts' => $nu];
    @file_put_contents($pad, json_encode(array_values($data)), LOCK_EX);
    return true;
}

/**
 * Genereer of haal een publiek CSRF-token op (voor contactformulieren).
 */
function csrf_token_publiek(): string
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (empty($_SESSION['csrf_publiek'])) {
        $_SESSION['csrf_publiek'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['csrf_publiek'];
}

/**
 * Valideer het publieke CSRF-token.
 */
function csrf_publiek_ok(): bool
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $token_post    = $_POST['csrf_token'] ?? '';
    $token_sessie  = $_SESSION['csrf_publiek'] ?? '';
    return $token_sessie !== '' && hash_equals($token_sessie, $token_post);
}

/**
 * Controleer pincode-vergrendeling. Toon pincode-scherm als site vergrendeld is.
 * Aanroepen bovenaan elke publieke pagina, vóór enige output.
 */
function check_site_vergrendeling(): void {
    $instellingen = laad_json('instellingen.json');
    if (empty($instellingen['site_vergrendeld'])) {
        return;
    }

    if (!isset($_SESSION)) {
        session_start();
    }

    if (!empty($_SESSION['pincode_ok'])) {
        return;
    }

    $fout = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pincode'])) {
        $ingevoerd = trim($_POST['pincode'] ?? '');
        $correct   = (string)($instellingen['pincode'] ?? '1234');
        if ($ingevoerd === $correct) {
            $_SESSION['pincode_ok'] = true;
            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit;
        }
        $fout = 'Ongeldige pincode. Probeer opnieuw.';
    }

    // Toon pincode-scherm en stop verdere uitvoer
    http_response_code(403);
    ?><!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Jim Ruimt Op — Niet openbaar</title>
    <meta name="robots" content="noindex, nofollow"/>
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { theme: { extend: { colors: { brandNavy: '#1A436D', brandCyan: '#5BBFEC' } } } }</script>
</head>
<body class="min-h-screen bg-brandNavy flex items-center justify-center px-4">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-sm text-center">
        <img src="/favicon-96x96.png" alt="Jim Ruimt Op" class="w-16 h-16 mx-auto mb-4"/>
        <h1 class="text-2xl font-bold text-brandNavy mb-1">Jim Ruimt Op</h1>
        <p class="text-gray-500 text-sm mb-6">Deze website is nog niet openbaar.<br/>Voer de pincode in om verder te gaan.</p>
        <?php if ($fout): ?>
            <p class="text-red-500 text-sm mb-4 font-medium"><?= htmlspecialchars($fout) ?></p>
        <?php endif; ?>
        <form method="POST">
            <input
                type="password"
                name="pincode"
                placeholder="Pincode"
                maxlength="20"
                autofocus
                class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-center text-2xl tracking-widest font-bold text-brandNavy focus:outline-none focus:border-brandCyan mb-4"
            />
            <button type="submit" class="w-full bg-brandNavy text-white py-3 rounded-xl font-bold hover:bg-brandCyan hover:text-brandNavy transition-all">
                Toegang
            </button>
        </form>
    </div>
</body>
</html><?php
    exit;
}
