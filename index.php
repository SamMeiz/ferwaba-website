<?php
/**
 * FERWABA Main Entry Point (Front Controller)
 */

// Load the bootstrap
require_once __DIR__ . '/includes/bootstrap.php';
define('APP_INIT', true);

function render_public(string $file): void
{
    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/'));
    $scriptDir = rtrim($scriptDir, '/');
    $baseHref = ($scriptDir !== '' ? $scriptDir : '') . '/ferwaba-main/';
    $safeBaseHref = htmlspecialchars($baseHref, ENT_QUOTES, 'UTF-8');
    ob_start();
    require $file;
    $output = ob_get_clean();
    if (stripos($output, '<head') !== false) {
        $output = preg_replace('~<head\b[^>]*>~i', '$0' . "\n    " . '<base href="' . $safeBaseHref . '">', $output, 1);
    }
    echo $output;
}

// Simple Router
$request = $_SERVER['REQUEST_URI'] ?? '/';
$path = parse_url($request, PHP_URL_PATH);

// Determine the base path (if installed in subdirectory)
$scriptName = dirname($_SERVER['SCRIPT_NAME']);
$route = '/' . ltrim(substr($path, strlen($scriptName)), '/');

// Routing Logic
switch ($route) {
    case '/':
    case '/index.php':
    case '/home':
        render_public(__DIR__ . '/ferwaba-main/index.php');
        break;

    case '/news':
        render_public(__DIR__ . '/ferwaba-main/news.php');
        break;

  case '/competitions':

    // Get full URL path
    $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    $parts = explode('/', $uri);

    // /competitions
    if (!isset($parts[1])) {
        require __DIR__ . '/competitions/index.php';
        break;
    }

    // /competitions/{slug}
    $slug = $parts[1];

    // Check RBL folder pages
    $rblPage = __DIR__ . "/competitions/$slug/pages/index.php";

    // Check cup files
    $cupFile = __DIR__ . "/competitions/$slug.php";

    if (file_exists($rblPage)) {
        require $rblPage;
    }

    elseif (file_exists($cupFile)) {
        require $cupFile;
    }

    else {
        require __DIR__ . '/404.php';
    }

    break;


    // Example for admin dashboard - usually keeps its own structure but can be routed here
    case '/admin':
    case '/admin/dashboard':
        require __DIR__ . '/admin/dashboard.php';
        break;

    default:
        // Attempt to find file in ferwaba-main or competitions
        $file = __DIR__ . '/ferwaba-main' . $route;
        if (file_exists($file) && is_file($file)) {
            render_public($file);
        } else {
            http_response_code(404);
            echo "<h1>404 Not Found</h1>";
            echo "<p>The page you are looking for does not exist.</p>";
        }
        break;
}
?>
