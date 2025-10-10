<?php require_once __DIR__ . '/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FERWABA Basketball League Management System v1.5</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Roboto+Condensed:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo asset_url('css/style.css'); ?>">
    <script defer src="<?php echo asset_url('js/main.js'); ?>"></script>
</head>
<body>
    <header class="site-header">
        <div class="container header-inner">
            <a class="logo" href="<?php echo asset_url('index.php'); ?>" style="display:flex;align-items:center;gap:10px;text-decoration:none;font-weight:700;font-size:20px;color:#111;">
  <img src="<?php echo asset_url('img/logo.png'); ?>" 
       alt="FERWABA Logo" style="height:50px;width:100px;object-fit:contain;display:block;"><span style="letter-spacing:1px;">RBL</span></a>

            <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation">☰</button>
            <nav class="main-nav" id="mainNav">
                <ul>
                    <li><a href="<?php echo asset_url('index.php'); ?>">Home</a></li>
                    <li class="has-sub">
                        <a href="<?php echo asset_url('standings.php'); ?>">Standings</a>
                        <ul class="sub">
                            <li><a href="<?php echo asset_url('standings.php?division=Division+1'); ?>">Division 1</a></li>
                            <li><a href="<?php echo asset_url('standings.php?division=Division+2'); ?>">Division 2</a></li>
                        </ul>
                    </li>
                    <li class="has-sub">
                        <a href="<?php echo asset_url('teams.php'); ?>">Teams</a>
                        <ul class="sub">
                            <li><a href="<?php echo asset_url('teams.php'); ?>">All Teams</a></li>
                        </ul>
                    </li>
                    <li class="has-sub">
                        <a href="<?php echo asset_url('players.php'); ?>">Players</a>
                        <ul class="sub">
                            <li><a href="<?php echo asset_url('players.php'); ?>">All Players</a></li>
                            <li><a href="<?php echo asset_url('players.php#leaderboards'); ?>">Leaderboards</a></li>
                        </ul>
                    </li>
                    <li class="has-sub">
                        <a href="<?php echo asset_url('national-team.php'); ?>">National Teams</a>
                        <ul class="sub">
                            <li><a href="<?php echo asset_url('national-team.php?team=Senior+Men'); ?>">Senior Men</a></li>
                            <li><a href="<?php echo asset_url('national-team.php?team=Senior+Women'); ?>">Senior Women</a></li>
                            <li><a href="<?php echo asset_url('national-team.php?team=U18+Men'); ?>">U18 Men</a></li>
                            <li><a href="<?php echo asset_url('national-team.php?team=U18+Women'); ?>">U18 Women</a></li>
                            <li><a href="<?php echo asset_url('national-team.php?team=U16+Men'); ?>">U16 Men</a></li>
                            <li><a href="<?php echo asset_url('national-team.php?team=U16+Women'); ?>">U16 Women</a></li>
                        </ul>
                    </li>
                    <li class="has-sub">
                        <a href="<?php echo asset_url('games.php'); ?>">Games</a>
                        <ul class="sub">
                            <li><a href="<?php echo asset_url('games.php#schedule'); ?>">Schedule</a></li>
                            <li><a href="<?php echo asset_url('games.php#results'); ?>">Results</a></li>
                        </ul>
                    </li>
                    <li class="has-sub">
                        <a href="<?php echo asset_url('playoffs.php'); ?>">BetPawa Playoffs</a>
                        <ul class="sub">
                            <li><a href="<?php echo asset_url('playoffs.php'); ?>">Bracket</a></li>
                            <li><a href="<?php echo asset_url('playoffs.php#history'); ?>">Champion History</a></li>
                        </ul>
                    </li>
                    <li class="has-sub">
                        <a href="<?php echo asset_url('news.php'); ?>">News</a>
                        <ul class="sub">
                            <li><a href="<?php echo asset_url('news.php?category=Latest'); ?>">Latest</a></li>
                            <li><a href="<?php echo asset_url('news.php?category=Transfers'); ?>">Transfers</a></li>
                            <li><a href="<?php echo asset_url('news.php?category=Injuries'); ?>">Injuries</a></li>
                            <li><a href="<?php echo asset_url('news.php?category=Squad+Updates'); ?>">Squad Updates</a></li>
                        </ul>
                    </li>
                    <li class="has-sub">
                        <a href="<?php echo asset_url('shop.php'); ?>">Shop </a>
                        <ul class="sub">
                            <li><a href="<?php echo asset_url('shop.php?category=Jerseys'); ?>">Jerseys</a></li>
                            <li><a href="<?php echo asset_url('shop.php?category=Kits'); ?>">Kits</a></li>
                            <li><a href="<?php echo asset_url('shop.php?category=Gear'); ?>">Gear</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    <main class="site-main container">


