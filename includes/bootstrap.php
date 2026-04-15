<?php
/**
 * FERWABA Security & Core Bootstrap
 * This file handles session management, configuration loading, 
 * database connection, and base security measures.
 */

// 1. Session Management
// Use secure session configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    ini_set('session.cookie_secure', 1);
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Load Configuration (Outside public_html)
$configFile = dirname(dirname(__DIR__)) . '/config.php';
if (!file_exists($configFile)) {
    // Fallback or relative to project root if structure differs
    $configFile = __DIR__ . '/config.php';
}

if (file_exists($configFile)) {
    require_once $configFile;
} else {
    // Default fallback if config is missing
    define('ENVIRONMENT', 'development');
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'ferwaba_db');
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

// 6. Security - DDoS / Rate Limiting (Simple File-Based Implementation)
function check_rate_limit($key, $limit = 60, $period = 60)
{
    if (!isset($_SESSION['rate_limits'])) {
        $_SESSION['rate_limits'] = [];
    }

    $now = time();
    if (!isset($_SESSION['rate_limits'][$key])) {
        $_SESSION['rate_limits'][$key] = ['count' => 1, 'start' => $now];
        return true;
    }

    $data = &$_SESSION['rate_limits'][$key];
    if ($now - $data['start'] > $period) {
        $data = ['count' => 1, 'start' => $now];
        return true;
    }

    if ($data['count'] >= $limit) {
        return false;
    }

    $data['count']++;
    return true;
}

// 7. Security Headers
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: strict-origin-when-cross-origin");

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