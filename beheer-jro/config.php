<?php
/**
 * Jim Ruimt Op — Admin configuratie
 * 
 * BELANGRIJK: Verander het wachtwoord via set_wachtwoord.php
 * en vervang dan de hash hieronder.
 */

// Wachtwoord-hash (genereer via set_wachtwoord.php)
// Huidig wachtwoord: jimruimtop2025  ← VERANDER DIT NA INSTALLATIE
define('ADMIN_WACHTWOORD_HASH', '$2y$12$Qm8A5R.Kx6P2n1sV3oY8.OD3YXj4Z8bH7W1n0RqT5mJvL9kCsE4Xu');

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
