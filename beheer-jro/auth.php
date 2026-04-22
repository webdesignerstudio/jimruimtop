<?php
/**
 * Auth-check — elke admin-pagina includeert dit bestand.
 * Redirect naar login als sessie ontbreekt of verlopen is.
 */
require_once __DIR__ . '/config.php';

session_name(SESSION_NAAM);
session_start();

// Controleer of ingelogd
if (empty($_SESSION['ingelogd'])) {
    header('Location: index.php');
    exit;
}

// Controleer session timeout
if (!empty($_SESSION['laatste_activiteit']) && (time() - $_SESSION['laatste_activiteit']) > SESSION_TIMEOUT) {
    session_unset();
    session_destroy();
    header('Location: index.php?timeout=1');
    exit;
}

// Update laatste activiteit
$_SESSION['laatste_activiteit'] = time();

/**
 * Genereer of haal CSRF-token op
 */
function csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Valideer CSRF-token uit POST
 */
function csrf_valideer(): bool {
    return isset($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token']);
}

/**
 * Laad JSON veilig vanuit content-map
 */
function laad_json_admin(string $bestand): array {
    $pad = CONTENT_PAD . $bestand;
    if (!file_exists($pad)) return [];
    $data = json_decode(file_get_contents($pad), true);
    return is_array($data) ? $data : [];
}

/**
 * Sla JSON atomisch op met backup
 */
function sla_json_op_admin(string $bestand, mixed $data): bool {
    $pad = CONTENT_PAD . $bestand;
    $tmp = $pad . '.tmp';
    $bak = $pad . '.bak';

    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json === false) return false;
    if (file_put_contents($tmp, $json, LOCK_EX) === false) return false;
    if (file_exists($pad)) copy($pad, $bak);
    return rename($tmp, $pad);
}
