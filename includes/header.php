<?php require_once __DIR__ . '/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FERWABA Basketball League Management System v1.5</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Roboto+Condensed:wght@300;400;700&display=swap" rel="stylesheet">

    <!-- CSS & JS -->
    <link rel="stylesheet" href="<?php echo asset_url('css/style.css'); ?>">
    <script defer src="<?php echo asset_url('js/main.js'); ?>"></script>
    

</head>

<body>
<header class="site-header" id="header">
    <div class="header-inner">
        <a class="logo" href="<?php echo asset_url('index.php'); ?>">
            <img src="<?php echo asset_url('img/logo.png'); ?>" alt="FERWABA Logo">
            <span>RBL</span>
        </a>

        <button class="nav-toggle" id="navToggle">☰</button>

        <nav class="main-nav" id="mainNav">
            <ul>
                <?php
                $current_page = basename($_SERVER['PHP_SELF']);
                $current_path = $_SERVER['REQUEST_URI'];
                
                function is_active($url, $current_page, $current_path) {
                    $page_name = basename(parse_url($url, PHP_URL_PATH));
                    if ($page_name === $current_page) return true;
                    if (strpos($current_path, $page_name) !== false) return true;
                    return false;
                }
                ?>
                <li><a href="<?php echo asset_url('index.php'); ?>" class="<?php echo is_active(asset_url('index.php'), $current_page, $current_path) ? 'active' : ''; ?>">Home</a></li>
                <li><a href="<?php echo asset_url('standings.php'); ?>" class="<?php echo is_active(asset_url('standings.php'), $current_page, $current_path) ? 'active' : ''; ?>">Standings</a></li>
                <li class="has-sub">
                    <a href="<?php echo asset_url('teams.php'); ?>" class="<?php echo is_active(asset_url('teams.php'), $current_page, $current_path) ? 'active' : ''; ?>">Teams</a>
                </li>
                <li class="has-sub">
                    <a href="<?php echo asset_url('players.php'); ?>" class="<?php echo is_active(asset_url('players.php'), $current_page, $current_path) ? 'active' : ''; ?>">Players</a>
                    <ul class="sub">
                        <li><a href="<?php echo asset_url('players.php'); ?>">All Players</a></li>
                        <li><a href="<?php echo asset_url('players.php#leaderboards'); ?>">Leaderboards</a></li>
                    </ul>
                </li>
                <li class="has-sub">
                    <a href="<?php echo asset_url('national-team.php'); ?>" class="<?php echo is_active(asset_url('national-team.php'), $current_page, $current_path) ? 'active' : ''; ?>">National Teams</a>
                </li>
                <li class="has-sub">
                    <a href="<?php echo asset_url('games.php'); ?>" class="<?php echo is_active(asset_url('games.php'), $current_page, $current_path) ? 'active' : ''; ?>">Games</a>
                </li>
                <li class="has-sub">
                    <a href="<?php echo asset_url('playoffs.php'); ?>" class="<?php echo is_active(asset_url('playoffs.php'), $current_page, $current_path) ? 'active' : ''; ?>">BetPawa Playoffs</a>
                    <ul class="sub">
                        <li><a href="<?php echo asset_url('playoffs.php'); ?>">Bracket</a></li>
                        <li><a href="<?php echo asset_url('playoffs.php#history'); ?>">Champion History</a></li>
                    </ul>
                </li>
                <li class="has-sub">
                    <a href="<?php echo asset_url('news.php'); ?>" class="<?php echo is_active(asset_url('news.php'), $current_page, $current_path) ? 'active' : ''; ?>">News</a>
                </li>
                <li class="has-sub">
                    <a href="<?php echo asset_url('shop.php'); ?>" class="<?php echo is_active(asset_url('shop.php'), $current_page, $current_path) ? 'active' : ''; ?>">Shop</a>
                </li>
            </ul>
        </nav>
    </div>
</header>

<script>
    // Sticky header when scrolling
    window.addEventListener('scroll', () => {
        const header = document.getElementById('header');
        if (window.scrollY > 50) header.classList.add('scrolled');
        else header.classList.remove('scrolled');
    });

    // Mobile menu toggle
    const navToggle = document.getElementById('navToggle');
    const mainNav = document.getElementById('mainNav');
    navToggle.addEventListener('click', () => {
        mainNav.classList.toggle('active');
        navToggle.textContent = mainNav.classList.contains('active') ? '✕' : '☰';
    });

    // Close menu when clicking outside
    document.addEventListener('click', (e) => {
        if (!mainNav.contains(e.target) && !navToggle.contains(e.target)) {
            mainNav.classList.remove('active');
            navToggle.textContent = '☰';
        }
    });
</script>

<!-- ✅ Ensures page content starts below navbar -->
<main class="site-main container">
