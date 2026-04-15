<?php
/**
 * FERWABA Security & Core Bootstrap
 * This file handles session management, configuration loading, 
 * database connection, and base security measures.
 */
// Marker so config.php knows bootstrap already ran (VULN-005 guard)
define('_FERWABA_BOOTSTRAP_LOADED', true);

// 1. Session Management
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_samesite', 'Lax');
$isHttps = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
if ($isHttps) {
    ini_set('session.cookie_secure', 1);
}
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => $isHttps,
    'httponly' => true,
    'samesite' => 'Lax',
]);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
    session_unset();
    session_destroy();
    session_start();
}
$_SESSION['last_activity'] = time();

// 2. Load Configuration (Outside public_html)
$configFile = dirname(dirname(__DIR__)) . '/config.php';
if (!file_exists($configFile)) {
    // Fallback: try relative to project root
    $configFile = __DIR__ . '/config.php';
}

if (file_exists($configFile)) {
    require_once $configFile;
} else {
    // FIXED VULN-010: was silently falling back to root/empty credentials.
    // Now fails loudly so misconfiguration is never silent.
    error_log('FERWABA FATAL: config.php not found. Application cannot start.');
    die('Application configuration error. Please contact the system administrator.');
}

// 3. Centralized Error Handling
if (defined('ENVIRONMENT') && ENVIRONMENT === 'production') {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

ini_set('log_errors', 1);
$logPath = dirname(__DIR__) . '/logs/error.log';
if (!is_dir(dirname($logPath))) {
    mkdir(dirname($logPath), 0755, true);
}
ini_set('error_log', $logPath);

// 4. Load Helper Functions
require_once __DIR__ . '/helpers.php';

// 5. Database Connection (PDO with prepared statements support)
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    error_log("Database Connection Error: " . $e->getMessage());
    if (ENVIRONMENT === 'production') {
        die("A temporary error occurred. Please try again later.");
    } else {
        die("Connection failed: " . $e->getMessage());
    }
}

// 6. Security — NOTE: VULN-006 FIX: Session-based rate limiter removed.
// It was bypassable by sending requests without a session cookie (new session = fresh counter).
// Login rate limiting is now handled exclusively by the database-backed
// is_ip_rate_limited() in helpers.php (20 failed attempts per IP per 5 min).

// 7. Security Headers
header("X-Frame-Options: SAMEORIGIN");
// NOTE: X-XSS-Protection removed (VULN-012 FIX) — deprecated, not supported in modern browsers,
// and can cause XSS vulnerabilities in old IE/Edge. CSP header below provides superior protection.
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: strict-origin-when-cross-origin");
$csp = "default-src 'self' https: data: blob:; img-src 'self' https: data: blob:; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com; font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com data:; script-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://www.google.com https://maps.googleapis.com https://www.youtube.com https://www.youtube-nocookie.com; frame-src https://www.google.com https://maps.google.com https://www.youtube.com https://www.youtube-nocookie.com; connect-src 'self' https:; base-uri 'self'; form-action 'self'; frame-ancestors 'self'";
header("Content-Security-Policy: " . $csp);
header("Permissions-Policy: geolocation=(), camera=(), microphone=(), payment=(), usb=(), interest-cohort=()");
header("Cross-Origin-Opener-Policy: same-origin");
header("Cross-Origin-Resource-Policy: same-origin");
header("X-Permitted-Cross-Domain-Policies: none");
header("X-Download-Options: noopen");
if ($isHttps) {
    header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
}

// Global available variables
$db = $pdo;

// Backward compatibility for mysqli
$mysqli = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($mysqli->connect_errno) {
    error_log('Mysqli connection failed: ' . $mysqli->connect_error);
} else {
    $mysqli->set_charset('utf8mb4');
}
?>
