<?php require_once __DIR__ . '/../../../includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rwanda Basketball League (RBL) | FERWABA Official</title>
  <meta name="description"
    content="Official website of Rwanda Basketball League - The premier professional basketball competition in Rwanda, organized by FERWABA.">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Roboto+Condensed:wght@300;400;700&display=swap"
    rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <!-- CSS & JS -->
  <link rel="stylesheet" href="../../../assets/css/style.css">
  <script defer src="../../../assets/js/main.js"></script>

  <style>
    /* RBL Pages Background - Rwanda Arena */
    body {
      background: linear-gradient(rgba(15, 23, 42, 0.9), rgba(15, 23, 42, 0.98)),
        url('../img/rwanda-arena.png') center/cover fixed no-repeat;
      min-height: 100vh;
      position: relative;
      font-family: 'Inter', system-ui, -apple-system, sans-serif;
      color: #fff;
    }

    body::before {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-image:
        radial-gradient(circle at 20% 30%, rgba(0, 71, 171, 0.2) 0%, transparent 50%),
        radial-gradient(circle at 80% 70%, rgba(255, 184, 28, 0.15) 0%, transparent 50%);
      pointer-events: none;
      z-index: 0;
    }

    .site-main {
      position: relative;
      z-index: 1;
    }

    /* Professional Government Header Styles */
    .top-bar {
      background: linear-gradient(90deg, #1a365d 0%, #2c5282 100%);
      padding: 8px 0;
      font-size: 12px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .top-bar-inner {
      max-width: 1400px;
      margin: 0 auto;
      padding: 0 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      color: rgba(255, 255, 255, 0.9);
    }

    .top-bar a {
      color: rgba(255, 255, 255, 0.9);
      text-decoration: none;
      transition: color 0.2s;
    }

    .top-bar a:hover {
      color: #fbbf24;
    }

    .top-bar-left {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .top-bar-left span {
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .top-bar-right {
      display: flex;
      align-items: center;
      gap: 16px;
    }

    .top-bar-right a {
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .site-header {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      z-index: 1000;
      background: linear-gradient(180deg, rgba(26, 54, 93, 0.98) 0%, rgba(26, 54, 93, 0.95) 100%);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      padding: 0;
      transition: all 0.3s ease;
      box-shadow: 0 2px 20px rgba(0, 0, 0, 0.15);
    }

    .site-header.scrolled {
      background: rgba(26, 54, 93, 0.98);
      box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
    }

    .header-inner {
      max-width: 1400px;
      margin: 0 auto;
      padding: 16px 40px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .logo {
      display: flex;
      align-items: center;
      gap: 14px;
      text-decoration: none;
    }

    .logo img {
      height: 52px;
      width: auto;
      object-fit: contain;
      transition: transform 0.3s ease;
    }

    .logo:hover img {
      transform: scale(1.05);
    }

    .logo-text {
      display: flex;
      flex-direction: column;
      line-height: 1.1;
    }

    .logo-title {
      font-size: 22px;
      font-weight: 800;
      color: #fff;
      letter-spacing: -0.5px;
    }

    .logo-subtitle {
      font-size: 11px;
      color: #fbbf24;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1.5px;
    }

    .main-nav ul {
      display: flex;
      gap: 4px;
      align-items: center;
      list-style: none;
      margin: 0;
      padding: 0;
    }

    .main-nav a {
      color: rgba(255, 255, 255, 0.9);
      text-decoration: none;
      font-weight: 600;
      font-size: 14px;
      padding: 10px 16px;
      border-radius: 8px;
      transition: all 0.3s ease;
      position: relative;
    }

    .main-nav a:hover {
      background: rgba(255, 255, 255, 0.1);
      color: #fff;
    }

    .main-nav a.active {
      background: #fbbf24;
      color: #1a365d;
      box-shadow: 0 4px 15px rgba(251, 191, 36, 0.3);
    }

    /* 🍔 Animated Hamburger Toggle */
    .nav-toggle {
      display: none;
      background: none;
      border: none;
      width: 44px;
      height: 44px;
      cursor: pointer;
      position: relative;
      z-index: 120;
      transition: all 0.3s ease;
      padding: 0;
    }

    .hamburger-box {
      width: 24px;
      height: 18px;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }

    .hamburger-inner,
    .hamburger-inner::before,
    .hamburger-inner::after {
      content: '';
      display: block;
      width: 24px;
      height: 2px;
      background-color: #fff;
      position: absolute;
      transition: transform 0.3s cubic-bezier(0.68, -0.6, 0.32, 1.6), background-color 0.3s ease;
      border-radius: 4px;
    }

    .hamburger-inner {
      top: 50%;
      transform: translateY(-50%);
    }

    .hamburger-inner::before {
      top: -8px;
    }

    .hamburger-inner::after {
      bottom: -8px;
    }

    .nav-toggle.active .hamburger-inner {
      background-color: transparent !important;
    }

    .nav-toggle.active .hamburger-inner::before {
      transform: translateY(8px) rotate(45deg);
      background-color: #fbbf24;
    }

    .nav-toggle.active .hamburger-inner::after {
      transform: translateY(-8px) rotate(-45deg);
      background-color: #fbbf24;
    }

    .has-sub {
      position: relative;
    }

    .has-sub .sub {
      position: absolute;
      top: 100%;
      left: 0;
      background: rgba(26, 54, 93, 0.98);
      backdrop-filter: blur(20px);
      min-width: 200px;
      display: none;
      flex-direction: column;
      padding: 12px 0;
      border-radius: 12px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
      margin-top: 8px;
    }

    .has-sub:hover .sub {
      display: flex;
    }

    .sub a {
      padding: 12px 20px;
      font-size: 13px;
      border-radius: 0;
    }

    .sub a:hover {
      background: rgba(251, 191, 36, 0.2);
    }

    @media (max-width: 1200px) {
      .header-inner {
        padding: 16px 20px;
      }

      .top-bar-inner {
        padding: 0 20px;
      }

      .logo-title {
        font-size: 18px;
      }
    }

    @media (max-width: 992px) {
      .top-bar {
        display: none;
      }

      .nav-toggle {
        display: block;
      }

      .main-nav {
        position: fixed;
        top: 0;
        right: -100%;
        width: 260px;
        /* Catchy, compact width */
        height: 100vh;
        background: linear-gradient(165deg, #0f172a 0%, #1e3a8a 100%);
        flex-direction: column;
        justify-content: flex-start;
        padding: 80px 15px 30px;
        transition: right 0.6s cubic-bezier(0.85, 0, 0.15, 1);
        box-shadow: -10px 0 40px rgba(0, 0, 0, 0.4);
        z-index: 100;
        overflow-y: auto;
      }

      .main-nav.active {
        right: 0;
      }

      .main-nav ul {
        flex-direction: column;
        gap: 8px;
        /* Tighter spacing */
        width: 100%;
      }

      .main-nav a {
        width: 100%;
        padding: 12px 20px;
        font-size: 14px;
        font-weight: 700;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.05);
        color: rgba(255, 255, 255, 0.9);
        display: flex;
        align-items: center;
        justify-content: space-between;
        text-decoration: none !important;
        box-shadow: none !important;
      }

      .main-nav a:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: translateX(-3px);
        color: #fff;
      }

      .main-nav a.active {
        background: #fbbf24 !important;
        color: #1a365d !important;
        border-color: #fbbf24 !important;
        transform: none !important;
      }

      /* Entrance Animation for Items */
      .main-nav.active li {
        animation: slideInNav 0.5s ease forwards;
        opacity: 0;
      }

      .main-nav.active li:nth-child(1) {
        animation-delay: 0.1s;
      }

      .main-nav.active li:nth-child(2) {
        animation-delay: 0.15s;
      }

      .main-nav.active li:nth-child(3) {
        animation-delay: 0.2s;
      }

      .main-nav.active li:nth-child(4) {
        animation-delay: 0.25s;
      }

      .main-nav.active li:nth-child(5) {
        animation-delay: 0.3s;
      }

      .main-nav.active li:nth-child(6) {
        animation-delay: 0.35s;
      }

      .main-nav.active li:nth-child(7) {
        animation-delay: 0.4s;
      }

      .main-nav.active li:nth-child(8) {
        animation-delay: 0.45s;
      }

      @keyframes slideInNav {
        from {
          opacity: 0;
          transform: translateX(30px);
        }

        to {
          opacity: 1;
          transform: translateX(0);
        }
      }

      .has-sub .sub {
        position: static;
        background: rgba(0, 0, 0, 0.2);
        box-shadow: none;
        margin-top: 10px;
        padding: 8px 0;
        border-radius: 12px;
        display: none;
      }

      .has-sub.open .sub {
        display: flex;
      }
    }

    @media (max-width: 640px) {
      .logo-title {
        font-size: 16px;
      }

      .logo-subtitle {
        font-size: 9px;
      }
    }

    /* Global Reset for Underlines */
    a {
      text-decoration: none !important;
    }
  </style>
</head>

<body>
  <!-- Top Bar -->
  <div class="top-bar">
    <div class="top-bar-inner">
      <div class="top-bar-left">
        <span><i class="fas fa-map-marker-alt"></i> Kigali, Rwanda</span>
        <span><i class="fas fa-envelope"></i> info@ferwaba.rw</span>
      </div>
      <div class="top-bar-right">
        <a href="../../../ferwaba-main/index"><i class="fas fa-globe"></i> FERWABA Main</a>
        <a href="https://ticqet.rw" target="_blank"><i class="fas fa-ticket-alt"></i> Buy Tickets</a>
      </div>
    </div>
  </div>

  <header class="site-header" id="header">
    <div class="header-inner">
      <a class="logo" href="index">
        <img src="../img/logo.png" alt="FERWABA Logo">
        <div class="logo-text">
          <span class="logo-title">Rwanda Basketball League</span>
          <span class="logo-subtitle">Official Competition</span>
        </div>
      </a>

      <button class="nav-toggle" id="navToggle" aria-label="Toggle Navigation">
        <div class="hamburger-box">
          <span class="hamburger-inner"></span>
        </div>
      </button>

      <nav class="main-nav" id="mainNav">
        <ul>
          <?php
          $current_page = basename($_SERVER['PHP_SELF']);
          function is_active($page, $current)
          {
            return ($page === $current) ? 'active' : '';
          }
          ?>
          <li><a href="index" class="<?php echo is_active('index.php', $current_page); ?>">Home</a></li>
          <li><a href="standings" class="<?php echo is_active('standings.php', $current_page); ?>">Standings</a>
          </li>
          <li><a href="teams" class="<?php echo is_active('teams.php', $current_page); ?>">Teams</a></li>
          <li><a href="players" class="<?php echo is_active('players.php', $current_page); ?>">Leaderboard</a></li>
          <li><a href="games" class="<?php echo is_active('games.php', $current_page); ?>">Schedule</a></li>
          <li class="has-sub">
            <a href="playoffs" class="<?php echo is_active('playoffs.php', $current_page); ?>">Playoffs</a>
            <ul class="sub">
              <li><a href="playoffs">Bracket</a></li>
              <li><a href="playoffs#history">Champions</a></li>
            </ul>
          </li>
          <li><a href="news" class="<?php echo is_active('news.php', $current_page); ?>">News</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const topBar = document.querySelector('.top-bar');
      const header = document.getElementById('header');

      window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
          header.classList.add('scrolled');
          if (topBar) topBar.style.transform = 'translateY(-100%)';
          header.style.top = '0';
        } else {
          header.classList.remove('scrolled');
          if (topBar) topBar.style.transform = 'translateY(0)';
        }
      });

      const navToggle = document.getElementById('navToggle');
      const mainNav = document.getElementById('mainNav');

      if (navToggle && mainNav) {
        navToggle.addEventListener('click', (e) => {
          e.stopPropagation();
          mainNav.classList.toggle('active');
          navToggle.classList.toggle('active'); // Toggle the animated hamburger state
        });

        document.addEventListener('click', (e) => {
          if (!mainNav.contains(e.target) && !navToggle.contains(e.target)) {
            mainNav.classList.remove('active');
            navToggle.classList.remove('active');
          }
        });
      }
    });
  </script>

  <main class="site-main container" style="padding-top: 140px;">