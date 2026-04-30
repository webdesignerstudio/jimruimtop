<?php
/**
 * Jim Ruimt Op — Admin configuratie
 * 
 * BELANGRIJK: Verander het wachtwoord via set_wachtwoord.php
 * en vervang dan de hash hieronder.
 */

// Wachtwoord-hash
define('ADMIN_WACHTWOORD_HASH', '$2y$12$SBzQ988j4NBws09CeBb1oeOrXwA51NmR8B61foQStseekR.C2/2T6');

// Session naam (voorkomt conflicten)
define('SESSION_NAAM', 'jro_beheer_sessie');

// Session timeout in seconden (30 minuten)
define('SESSION_TIMEOUT', 1800);

// Maximale uploadgrootte in bytes (8 MB)
define('MAX_UPLOAD_GROOTTE', 8 * 1024 * 1024);

// Toegestane afbeeldingstypen
define('TOEGESTANE_TYPES', ['image/jpeg', 'image/png', 'image/webp']);
define('TOEGESTANE_EXTENSIES', ['jpg', 'jpeg', 'png', 'webp']);

// Paden
define('ADMIN_DIR', __DIR__);
define('ROOT_DIR', dirname(__DIR__));
define('CONTENT_PAD', ROOT_DIR . '/content/');
define('UPLOADS_PAD', ROOT_DIR . '/uploads/gallerij/');
define('UPLOADS_URL_PAD', '../uploads/gallerij/');
