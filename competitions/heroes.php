<?php require_once __DIR__ . '/../includes/bootstrap.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Heroes Cup - Knockout Tournament | Ferwaba</title>
  <meta name="description"
    content="Heroes Cup - Elite basketball tournament featuring Rwanda's top teams in a knockout format.">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap"
    rel="stylesheet">
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Roboto+Condensed:wght@300;400;700&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    :root {
      --primary: #DC143C;
      /* Crimson red */
      --secondary: #FFD700;
      /* Gold */
      --accent: #8B0000;
      /* Dark red */
      --light: #f8f9fa;
      --dark: #212529;
      --gray: #6c757d;
      --light-gray: #e9ecef;
    }

    body {
      background-color: #f5f7fa;
      color: #333;
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding-top: 70px;
      line-height: 1.6;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }

    /* Navigation */
    .navbar {
      background-color: #ffffff;
      color: #000000;
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 1000;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .nav-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      height: 70px;
    }

    .nav-brand {
      display: flex;
      align-items: center;
      gap: 12px;
      text-decoration: none;
      color: var(--primary);
      font-weight: 700;
    }

    .heroes-logo {
      font-size: 1.8rem;
      font-weight: bold;
      color: white;
      background: var(--primary);
      padding: 5px 12px;
      border-radius: 4px;
    }

    .site-title {
      font-size: 1.3rem;
      color: var(--primary);
    }

    .nav-menu {
      display: flex;
      gap: 1.5rem;
      align-items: center;
    }

    .nav-link {
      text-decoration: none;
      color: var(--dark);
      font-weight: 500;
      padding: 8px 16px;
      border-radius: 4px;
      transition: all 0.3s ease;
      position: relative;
    }

    .nav-link:hover {
      color: var(--primary);
      background-color: rgba(220, 20, 60, 0.1);
    }

    .nav-link.active {
      color: var(--primary);
      font-weight: 600;
    }

    .ferwaba-link {
      background-color: var(--primary);
      color: white !important;
      border-radius: 4px;
      padding: 8px 16px;
    }

    .ferwaba-link:hover {
      background-color: var(--accent);
      transform: translateY(-2px);
    }

    /* Tournament Header */
    .tournament-header {
      background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
      padding: 80px 0;
      text-align: center;
      color: white;
      position: relative;
      overflow: hidden;
    }

    .tournament-header::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('https://images.unsplash.com/photo-1546519638-68e109498ffc?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80') center/cover no-repeat;
      opacity: 0.2;
    }

    .tournament-title {
      font-family: 'Roboto Condensed', sans-serif;
      font-size: 3.5rem;
      font-weight: 700;
      margin: 0;
      color: white;
      text-transform: uppercase;
      letter-spacing: 2px;
      position: relative;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .tournament-subtitle {
      font-size: 1.3rem;
      margin: 15px 0 25px;
      color: rgba(255, 255, 255, 0.9);
      max-width: 800px;
      margin-left: auto;
      margin-right: auto;
      position: relative;
    }

    .tournament-info {
      display: flex;
      justify-content: center;
      gap: 30px;
      flex-wrap: wrap;
      margin-top: 30px;
      position: relative;
    }

    .info-card {
      background: rgba(255, 255, 255, 0.9);
      border-radius: 8px;
      padding: 20px;
      min-width: 180px;
      text-align: center;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .info-card h3 {
      color: var(--primary);
      margin: 0 0 10px;
      font-size: 1.1rem;
      font-weight: 600;
    }

    .info-card p {
      margin: 0;
      font-size: 1.6rem;
      font-weight: 700;
      color: var(--accent);
    }

    /* Section Styling */
    .section {
      padding: 70px 20px;
      max-width: 1200px;
      margin: 0 auto;
    }

    .section-title {
      text-align: center;
      margin-bottom: 50px;
    }

    .section-title h2 {
      font-size: 2.2rem;
      margin: 0;
      color: var(--primary);
      display: inline-block;
      padding-bottom: 12px;
      position: relative;
    }

    .section-title h2::after {
      content: "";
      position: absolute;
      width: 70px;
      height: 3px;
      background: var(--secondary);
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
    }

    /* Knockout Bracket Section */
    .knockout-container {
      background: white;
      border-radius: 12px;
      padding: 30px;
      margin-bottom: 40px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      border: 1px solid var(--light-gray);
    }

    .knockout-title {
      text-align: center;
      margin-bottom: 30px;
      color: var(--primary);
      font-size: 1.6rem;
      font-weight: 600;
    }

    .knockout-bracket {
      display: flex;
      justify-content: space-between;
      gap: 20px;
      flex-wrap: wrap;
      position: relative;
    }

    .knockout-round {
      flex: 1;
      min-width: 200px;
      position: relative;
    }

    .round-title {
      text-align: center;
      color: var(--primary);
      margin-bottom: 20px;
      font-size: 1.3rem;
      font-weight: 600;
    }

    .match {
      background: white;
      border: 1px solid var(--light-gray);
      border-radius: 8px;
      margin-bottom: 25px;
      padding: 15px;
      text-align: center;
      transition: all 0.3s ease;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
      position: relative;
    }

    .match::before {
      content: "";
      position: absolute;
      top: -25px;
      left: 50%;
      transform: translateX(-50%);
      width: 2px;
      height: 25px;
      background: var(--light-gray);
    }

    .match:first-child::before {
      display: none;
    }

    .match:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      border-color: var(--secondary);
    }

    .team {
      padding: 12px;
      margin: 6px 0;
      border-radius: 6px;
      background: #f8f9fa;
      font-weight: 500;
      transition: all 0.2s ease;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .team-name {
      flex: 1;
      text-align: left;
    }

    .team-score {
      font-weight: 700;
      color: var(--primary);
      min-width: 30px;
    }

    .team:hover {
      background: #e9ecef;
      cursor: pointer;
    }

    .team.winner {
      background: rgba(220, 20, 60, 0.1);
      border-left: 3px solid var(--primary);
      font-weight: 600;
    }

    .match-info {
      font-size: 0.9rem;
      color: var(--gray);
      margin-top: 12px;
      padding-top: 10px;
      border-top: 1px dashed var(--light-gray);
    }

    /* Teams Grid */
    .teams-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 30px;
    }

    .team-card {
      background: white;
      border-radius: 12px;
      overflow: hidden;
      transition: all 0.3s ease;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      border: 1px solid var(--light-gray);
    }

    .team-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .team-logo {
      height: 160px;
      background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 3.5rem;
      color: white;
    }

    .team-info {
      padding: 20px;
      text-align: center;
    }

    .team-info h3 {
      margin: 0 0 8px;
      color: var(--dark);
      font-size: 1.3rem;
    }

    .team-info p {
      color: var(--gray);
      margin: 0 0 15px;
      font-size: 0.9rem;
    }

    .team-stats {
      display: flex;
      justify-content: space-around;
      margin-top: 15px;
      padding-top: 15px;
      border-top: 1px solid var(--light-gray);
    }

    .stat {
      text-align: center;
    }

    .stat-value {
      font-size: 1.4rem;
      font-weight: 700;
      color: var(--primary);
    }

    .stat-label {
      font-size: 0.8rem;
      color: var(--gray);
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    /* Standings Table */
    .standings-table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .standings-table th {
      background: var(--primary);
      color: white;
      padding: 15px;
      text-align: left;
      font-weight: 500;
    }

    .standings-table td {
      padding: 12px 15px;
      border-bottom: 1px solid var(--light-gray);
    }

    .standings-table tr:nth-child(even) {
      background: #f8f9fa;
    }

    .standings-table tr:hover {
      background: rgba(220, 20, 60, 0.05);
    }

    .team-position {
      font-weight: 700;
      color: var(--primary);
      width: 50px;
      text-align: center;
    }

    /* Buttons */
    .btn {
      display: inline-block;
      background: var(--primary);
      color: white;
      padding: 12px 25px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: 500;
      margin: 10px;
      transition: all 0.3s ease;
      border: none;
      cursor: pointer;
      font-size: 1rem;
      text-align: center;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .btn:hover {
      background: var(--accent);
      transform: translateY(-3px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .btn-secondary {
      background: var(--secondary);
      color: var(--dark);
    }

    .btn-secondary:hover {
      background: #e6c200;
    }

    .btn-outline {
      background: transparent;
      color: var(--primary);
      border: 2px solid var(--primary);
    }

    .btn-outline:hover {
      background: var(--primary);
      color: white;
    }

    /* Highlights Section */
    .highlights-section {
      background-color: #ffffff;
      padding: 70px 20px;
    }

    .highlights-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 30px;
    }

    .highlight-card {
      background: white;
      border-radius: 12px;
      overflow: hidden;
      transition: all 0.3s ease;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      border: 1px solid var(--light-gray);
    }

    .highlight-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .highlight-img {
      height: 200px;
      background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 3.5rem;
      color: white;
    }

    .highlight-content {
      padding: 25px;
      text-align: center;
    }

    .highlight-content h3 {
      margin: 0 0 15px;
      color: var(--dark);
      font-size: 1.4rem;
    }

    .highlight-content p {
      color: var(--gray);
      margin: 0;
      line-height: 1.6;
    }

    /* CTA Section */
    .cta-section {
      background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
      padding: 80px 20px;
      text-align: center;
      color: white;
      margin: 60px 0;
    }

    .cta-title {
      font-size: 2.5rem;
      margin-bottom: 20px;
      color: white;
    }

    .cta-subtitle {
      font-size: 1.2rem;
      max-width: 700px;
      margin: 0 auto 30px;
      color: rgba(255, 255, 255, 0.9);
    }

    /* Footer */
    .site-footer {
      background: var(--dark);
      color: white;
      padding: 60px 0 30px;
    }

    .footer-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }

    .footer-top {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      flex-wrap: wrap;
      gap: 40px;
      margin-bottom: 40px;
    }

    .footer-brand {
      flex: 1;
      min-width: 250px;
    }

    .footer-brand .heroes-logo {
      color: white;
      background: var(--secondary);
    }

    .footer-links {
      display: flex;
      gap: 60px;
      flex-wrap: wrap;
    }

    .footer-links h4 {
      color: var(--secondary);
      margin: 0 0 15px;
      font-size: 1.1rem;
    }

    .footer-links div {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .footer-links a {
      color: rgba(255, 255, 255, 0.8);
      text-decoration: none;
      font-size: 15px;
      transition: all 0.3s ease;
    }

    .footer-links a:hover {
      color: var(--secondary);
      text-decoration: underline;
    }

    .footer-line {
      border: none;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      margin: 20px 0;
    }

    .footer-bottom {
      text-align: center;
      font-size: 14px;
      color: rgba(255, 255, 255, 0.6);
    }

    .footer-bottom-links a {
      color: rgba(255, 255, 255, 0.8);
      text-decoration: none;
      margin: 0 8px;
    }

    .footer-bottom-links a:hover {
      color: var(--secondary);
      text-decoration: underline;
    }

    /* Additional Internal CSS Styles */

    /* Background Pattern */
    body {
      background-image:
        radial-gradient(circle at 10% 20%, rgba(220, 20, 60, 0.05) 0%, transparent 20%),
        radial-gradient(circle at 80% 80%, rgba(220, 20, 60, 0.05) 0%, transparent 20%);
    }

    /* Enhanced Hover Effects */
    .team-card:hover {
      transform: translateY(-10px) scale(1.02);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .highlight-card:hover {
      transform: translateY(-10px) scale(1.02);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    /* Button Pulse Animation */
    @keyframes pulse {
      0% {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      }

      50% {
        box-shadow: 0 8px 15px rgba(220, 20, 60, 0.3);
      }

      100% {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      }
    }

    .btn {
      animation: pulse 2s infinite;
    }

    /* Match Winner Highlight */
    .team.winner {
      position: relative;
      overflow: hidden;
    }

    .team.winner::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 215, 0, 0.2), transparent);
      transform: translateX(-100%);
      animation: shimmer 2s infinite;
    }

    @keyframes shimmer {
      100% {
        transform: translateX(100%);
      }
    }

    /* Bracket Connector Lines */
    .knockout-round {
      position: relative;
    }

    .knockout-round:not(:last-child)::after {
      content: "";
      position: absolute;
      top: 50%;
      right: -30px;
      width: 30px;
      height: 2px;
      background: var(--light-gray);
      transform: translateY(-50%);
    }

    /* Team Logo Animation */
    .team-logo {
      transition: all 0.3s ease;
    }

    .team-card:hover .team-logo {
      transform: scale(1.1);
    }

    /* Footer Wave Effect */
    .site-footer {
      position: relative;
    }

    .site-footer::after {
      content: "";
      position: absolute;
      top: -20px;
      left: 0;
      width: 100%;
      height: 20px;
      background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320'%3E%3Cpath fill='%23f5f7fa' fill-opacity='1' d='M0,128L48,138.7C96,149,192,171,288,165.3C384,160,480,128,576,128C672,128,768,160,864,176C960,192,1056,192,1152,197.3C1248,203,1344,213,1392,218.7L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z'%3E%3C/path%3E%3C/svg%3E");
      background-size: cover;
      background-repeat: no-repeat;
    }

    /* Responsive Design */
    @media (max-width: 992px) {
      .tournament-title {
        font-size: 2.8rem;
      }

      .teams-grid {
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      }
    }

    @media (max-width: 768px) {
      .tournament-title {
        font-size: 2.2rem;
      }

      .knockout-bracket {
        flex-direction: column;
      }

      .knockout-round:not(:first-child)::before {
        display: none;
      }

      .footer-top {
        flex-direction: column;
      }

      .footer-links {
        gap: 40px;
      }

      .nav-menu {
        flex-direction: column;
        background-color: white;
        position: fixed;
        top: 70px;
        right: -100%;
        width: 100%;
        height: calc(100vh - 70px);
        transition: 0.3s;
        padding: 20px;
        align-items: flex-start;
        box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1);
      }

      .nav-menu.active {
        right: 0;
      }

      /* Mobile-specific enhancements */
      .match {
        margin-bottom: 40px;
      }

      .match::before {
        top: -35px;
        height: 35px;
      }
    }
  </style>
</head>

<body>
  <!-- Navigation -->
  <nav class="navbar">
    <div class="nav-container">
      <a href="../index.php" class="nav-brand" aria-label="Heroes Cup - Knockout Tournament">
        <div class="heroes-logo">HC</div>
        <span class="site-title">Heroes Cup</span>
      </a>

      <ul class="nav-menu">
        <li><a href="#bracket" class="nav-link">Bracket</a></li>
        <li><a href="#teams" class="nav-link">Teams</a></li>
        <li><a href="#standings" class="nav-link">Standings</a></li>
        <li><a href="#highlights" class="nav-link">Highlights</a></li>
        <li><a href="../games.php" class="nav-link">Schedule</a></li>
        <li><a href="../index.php" class="nav-link ferwaba-link">Back to Ferwaba</a></li>
      </ul>
    </div>
  </nav>

  <!-- Tournament Header -->
  <section class="tournament-header">
    <div class="container">
      <h1 class="tournament-title">Heroes Cup</h1>
      <p class="tournament-subtitle">Elite basketball tournament featuring Rwanda's top teams in a knockout format</p>

      <div class="tournament-info">
        <div class="info-card">
          <h3>Season</h3>
          <p>2025</p>
        </div>
        <div class="info-card">
          <h3>Teams</h3>
          <p>8</p>
        </div>
        <div class="info-card">
          <h3>Games</h3>
          <p>15</p>
        </div>
        <div class="info-card">
          <h3>Champion</h3>
          <p>TBD</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Knockout Bracket Section -->
  <section id="bracket" class="section">
    <div class="section-title">
      <h2>Knockout Bracket</h2>
    </div>

    <div class="knockout-container">
      <h3 class="knockout-title">Championship Knockout Stage</h3>
      <div class="knockout-bracket">
        <!-- Quarterfinals -->
        <div class="knockout-round">
          <h4 class="round-title">Quarterfinals</h4>
          <div class="match">
            <div class="team winner">
              <span class="team-name">Kigali Warriors</span>
              <span class="team-score">85</span>
            </div>
            <div class="team">
              <span class="team-name">Northern Eagles</span>
              <span class="team-score">78</span>
            </div>
            <div class="match-info">May 10, 2025 | 7:00 PM</div>
          </div>
          <div class="match">
            <div class="team">
              <span class="team-name">Southern Stars</span>
              <span class="team-score">72</span>
            </div>
            <div class="team winner">
              <span class="team-name">Western Dragons</span>
              <span class="team-score">81</span>
            </div>
            <div class="match-info">May 10, 2025 | 9:00 PM</div>
          </div>
          <div class="match">
            <div class="team winner">
              <span class="team-name">Eastern Phoenix</span>
              <span class="team-score">92</span>
            </div>
            <div class="team">
              <span class="team-name">Central Titans</span>
              <span class="team-score">84</span>
            </div>
            <div class="match-info">May 11, 2025 | 7:00 PM</div>
          </div>
          <div class="match">
            <div class="team">
              <span class="team-name">Lake Victoria</span>
              <span class="team-score">76</span>
            </div>
            <div class="team winner">
              <span class="team-name">Mountain Kings</span>
              <span class="team-score">83</span>
            </div>
            <div class="match-info">May 11, 2025 | 9:00 PM</div>
          </div>
        </div>

        <!-- Semifinals -->
        <div class="knockout-round">
          <h4 class="round-title">Semifinals</h4>
          <div class="match">
            <div class="team winner">
              <span class="team-name">Kigali Warriors</span>
              <span class="team-score">88</span>
            </div>
            <div class="team">
              <span class="team-name">Western Dragons</span>
              <span class="team-score">82</span>
            </div>
            <div class="match-info">May 15, 2025 | 7:00 PM</div>
          </div>
          <div class="match">
            <div class="team">
              <span class="team-name">Eastern Phoenix</span>
              <span class="team-score">79</span>
            </div>
            <div class="team winner">
              <span class="team-name">Mountain Kings</span>
              <span class="team-score">85</span>
            </div>
            <div class="match-info">May 15, 2025 | 9:00 PM</div>
          </div>
        </div>

        <!-- Finals -->
        <div class="knockout-round">
          <h4 class="round-title">Finals</h4>
          <div class="match">
            <div class="team">
              <span class="team-name">Kigali Warriors</span>
              <span class="team-score">TBD</span>
            </div>
            <div class="team">
              <span class="team-name">Mountain Kings</span>
              <span class="team-score">TBD</span>
            </div>
            <div class="match-info">May 20, 2025 | 8:00 PM</div>
          </div>
        </div>

        <!-- Champion -->
        <div class="knockout-round">
          <h4 class="round-title">Champion</h4>
          <div class="match">
            <div class="team">
              <span class="team-name">TBD</span>
            </div>
            <div class="match-info">May 22, 2025</div>
          </div>
        </div>
      </div>
    </div>

    <div class="text-center">
      <a href="#" class="btn">View Full Bracket</a>
      <a href="../games.php" class="btn btn-secondary">Full Schedule</a>
    </div>
  </section>

  <!-- Teams Section -->
  <section id="teams" class="section">
    <div class="section-title">
      <h2>Participating Teams</h2>
    </div>

    <div class="teams-grid">
      <!-- Team 1 -->
      <div class="team-card">
        <div class="team-logo">
          <i class="fas fa-basketball-ball"></i>
        </div>
        <div class="team-info">
          <h3>Kigali Warriors</h3>
          <p>Top Seed</p>
          <div class="team-stats">
            <div class="stat">
              <div class="stat-value">19</div>
              <div class="stat-label">Wins</div>
            </div>
            <div class="stat">
              <div class="stat-value">3</div>
              <div class="stat-label">Losses</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Team 2 -->
      <div class="team-card">
        <div class="team-logo">
          <i class="fas fa-basketball-ball"></i>
        </div>
        <div class="team-info">
          <h3>Mountain Kings</h3>
          <p>Second Seed</p>
          <div class="team-stats">
            <div class="stat">
              <div class="stat-value">17</div>
              <div class="stat-label">Wins</div>
            </div>
            <div class="stat">
              <div class="stat-value">5</div>
              <div class="stat-label">Losses</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Team 3 -->
      <div class="team-card">
        <div class="team-logo">
          <i class="fas fa-basketball-ball"></i>
        </div>
        <div class="team-info">
          <h3>Western Dragons</h3>
          <p>Semifinalists</p>
          <div class="team-stats">
            <div class="stat">
              <div class="stat-value">15</div>
              <div class="stat-label">Wins</div>
            </div>
            <div class="stat">
              <div class="stat-value">7</div>
              <div class="stat-label">Losses</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Team 4 -->
      <div class="team-card">
        <div class="team-logo">
          <i class="fas fa-basketball-ball"></i>
        </div>
        <div class="team-info">
          <h3>Eastern Phoenix</h3>
          <p>Semifinalists</p>
          <div class="team-stats">
            <div class="stat">
              <div class="stat-value">14</div>
              <div class="stat-label">Wins</div>
            </div>
            <div class="stat">
              <div class="stat-value">8</div>
              <div class="stat-label">Losses</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Standings Section -->
  <section id="standings" class="section">
    <div class="section-title">
      <h2>Group Stage Standings</h2>
    </div>

    <div class="table-responsive">
      <table class="standings-table">
        <thead>
          <tr>
            <th>Pos</th>
            <th>Team</th>
            <th>GP</th>
            <th>W</th>
            <th>L</th>
            <th>PTS</th>
            <th>PF</th>
            <th>PA</th>
            <th>+/-</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="team-position">1</td>
            <td>Kigali Warriors</td>
            <td>22</td>
            <td>19</td>
            <td>3</td>
            <td>38</td>
            <td>102.5</td>
            <td>85.3</td>
            <td>+17.2</td>
          </tr>
          <tr>
            <td class="team-position">2</td>
            <td>Mountain Kings</td>
            <td>22</td>
            <td>17</td>
            <td>5</td>
            <td>34</td>
            <td>98.2</td>
            <td>87.1</td>
            <td>+11.1</td>
          </tr>
          <tr>
            <td class="team-position">3</td>
            <td>Western Dragons</td>
            <td>22</td>
            <td>15</td>
            <td>7</td>
            <td>30</td>
            <td>95.8</td>
            <td>89.5</td>
            <td>+6.3</td>
          </tr>
          <tr>
            <td class="team-position">4</td>
            <td>Eastern Phoenix</td>
            <td>22</td>
            <td>14</td>
            <td>8</td>
            <td>28</td>
            <td>93.4</td>
            <td>91.2</td>
            <td>+2.2</td>
          </tr>
          <tr>
            <td class="team-position">5</td>
            <td>Northern Eagles</td>
            <td>22</td>
            <td>12</td>
            <td>10</td>
            <td>24</td>
            <td>91.1</td>
            <td>93.7</td>
            <td>-2.6</td>
          </tr>
          <tr>
            <td class="team-position">6</td>
            <td>Southern Stars</td>
            <td>22</td>
            <td>10</td>
            <td>12</td>
            <td>20</td>
            <td>88.3</td>
            <td>95.8</td>
            <td>-7.5</td>
          </tr>
          <tr>
            <td class="team-position">7</td>
            <td>Central Titans</td>
            <td>22</td>
            <td>8</td>
            <td>14</td>
            <td>16</td>
            <td>85.7</td>
            <td>98.2</td>
            <td>-12.5</td>
          </tr>
          <tr>
            <td class="team-position">8</td>
            <td>Lake Victoria</td>
            <td>22</td>
            <td>6</td>
            <td>16</td>
            <td>12</td>
            <td>82.9</td>
            <td>101.4</td>
            <td>-18.5</td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>

  <!-- Highlights Section -->
  <section id="highlights" class="section">
    <div class="section-title">
      <h2>Tournament Highlights</h2>
    </div>

    <div class="highlights-grid">
      <div class="highlight-card">
        <div class="highlight-img">
          <i class="fas fa-trophy"></i>
        </div>
        <div class="highlight-content">
          <h3>Opening Ceremony</h3>
          <p>Experience the grand opening of the 2025 Heroes Cup with spectacular performances and tributes.</p>
        </div>
      </div>

      <div class="highlight-card">
        <div class="highlight-img">
          <i class="fas fa-users"></i>
        </div>
        <div class="highlight-content">
          <h3>All-Star Game</h3>
          <p>Watch the best players from across Rwanda compete in this exciting showcase of talent and skill.</p>
        </div>
      </div>

      <div class="highlight-card">
        <div class="highlight-img">
          <i class="fas fa-award"></i>
        </div>
        <div class="highlight-content">
          <h3>Awards Ceremony</h3>
          <p>Celebrate the achievements of players and teams at our annual awards ceremony.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="cta-section">
    <div class="container">
      <h2 class="cta-title">Experience the Heroes Cup Live</h2>
      <p class="cta-subtitle">Get your tickets now for the remaining games and be part of Rwanda's most exciting
        basketball tournament.</p>
      <div>
        <a href="#" class="btn">Buy Tickets</a>
        <a href="#" class="btn btn-secondary">Team Merchandise</a>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="site-footer">
    <div class="footer-container">
      <div class="footer-top">
        <div class="footer-brand">
          <div class="heroes-logo" style="font-size: 2rem; font-weight: bold;">HC</div>
          <p style="max-width: 300px;">Heroes Cup - Celebrating excellence in Rwandan basketball.</p>
        </div>

        <div class="footer-links">
          <div>
            <h4>Quick Links</h4>
            <a href="#bracket">Bracket</a>
            <a href="#teams">Teams</a>
            <a href="#standings">Standings</a>
            <a href="../games.php">Schedule</a>
          </div>

          <div>
            <h4>Resources</h4>
            <a href="../news.php">News</a>
            <a href="../players.php">Players</a>
            <a href="../shop.php">Shop</a>
            <a href="#">Tickets</a>
          </div>
        </div>
      </div>

      <hr class="footer-line">

      <div class="footer-bottom">
        <div class="footer-bottom-links">
          <a href="#">Privacy Policy</a>
          <a href="#">Terms of Service</a>
          <a href="#">Contact Us</a>
        </div>
        <p>&copy; 2025 Heroes Cup. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <script>
    // Smooth scrolling for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
          behavior: 'smooth'
        });
      });
    });
  </script>

</body>

</html>