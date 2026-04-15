<?php require_once __DIR__ . '/../includes/bootstrap.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GMC - Genocide Memorial Cup | Ferwaba</title>
  <meta name="description"
    content="Genocide Memorial Cup - Rwanda's premier basketball tournament honoring memory and celebrating excellence.">
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
      --primary: #0047AB;
      /* Deep blue */
      --secondary: #FFB81C;
      /* Gold */
      --accent: #1A2A44;
      /* Dark blue */
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

    /* Navigation with Ferwaba links */
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

    .gmc-logo {
      font-size: 1.8rem;
      font-weight: bold;
      color: var(--primary);
      background: var(--secondary);
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
      background-color: rgba(0, 71, 171, 0.1);
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

    /* Bracket Section */
    .bracket-container {
      background: white;
      border-radius: 12px;
      padding: 30px;
      margin-bottom: 40px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      border: 1px solid var(--light-gray);
    }

    .bracket-title {
      text-align: center;
      margin-bottom: 30px;
      color: var(--primary);
      font-size: 1.6rem;
      font-weight: 600;
    }

    .bracket {
      display: flex;
      justify-content: space-between;
      gap: 20px;
      flex-wrap: wrap;
    }

    .round {
      flex: 1;
      min-width: 200px;
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
    }

    .team:hover {
      background: #e9ecef;
      cursor: pointer;
    }

    .team.winner {
      background: rgba(0, 71, 171, 0.1);
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
      background: rgba(0, 71, 171, 0.05);
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
      background: #e6a51d;
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

    .footer-brand .gmc-logo {
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

      .bracket {
        flex-direction: column;
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
    }
  </style>
</head>

<body>
  <!-- Navigation -->
  <nav class="navbar">
    <div class="nav-container">
      <a href="../index.php" class="nav-brand" aria-label="GMC - Genocide Memorial Cup">
        <div class="gmc-logo">GMC</div>
        <span class="site-title">Genocide Memorial Cup</span>
      </a>

      <ul class="nav-menu">
        <li><a href="#bracket" class="nav-link">Bracket</a></li>
        <li><a href="#teams" class="nav-link">Teams</a></li>
        <li><a href="#standings" class="nav-link">Standings</a></li>
        <li><a href="#highlights" class="nav-link">Highlights</a></li>
        <li><a href="../games.php" class="nav-link">Schedule</a></li>
      </ul>
    </div>
  </nav>

  <!-- Tournament Header -->
  <section class="tournament-header">
    <div class="container">
      <h1 class="tournament-title">Genocide Memorial Cup</h1>
      <p class="tournament-subtitle">Rwanda's Premier Basketball Tournament Honoring Memory and Celebrating Excellence
      </p>

      <div class="tournament-info">
        <div class="info-card">
          <h3>Season</h3>
          <p>2025</p>
        </div>
        <div class="info-card">
          <h3>Teams</h3>
          <p>16</p>
        </div>
        <div class="info-card">
          <h3>Games</h3>
          <p>48</p>
        </div>
        <div class="info-card">
          <h3>Champion</h3>
          <p>TBD</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Bracket Section -->
  <section id="bracket" class="section">
    <div class="section-title">
      <h2>Tournament Bracket</h2>
    </div>

    <div class="bracket-container">
      <h3 class="bracket-title">Championship Finals</h3>
      <div class="bracket">
        <div class="round">
          <h4 class="round-title">Semifinals</h4>
          <div class="match">
            <div class="team winner">Rwanda Patriots</div>
            <div class="team">Kigali Kings</div>
            <div class="match-info">May 15, 2025 | 7:00 PM</div>
          </div>
          <div class="match">
            <div class="team">Pirates BC</div>
            <div class="team winner">Eagles Rwanda</div>
            <div class="match-info">May 16, 2025 | 7:00 PM</div>
          </div>
        </div>

        <div class="round">
          <h4 class="round-title">Finals</h4>
          <div class="match">
            <div class="team">Rwanda Patriots</div>
            <div class="team">Eagles Rwanda</div>
            <div class="match-info">May 20, 2025 | 8:00 PM</div>
          </div>
        </div>

        <div class="round">
          <h4 class="round-title">Champion</h4>
          <div class="match">
            <div class="team">TBD</div>
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
          <h3>Rwanda Patriots</h3>
          <p>Defending Champions</p>
          <div class="team-stats">
            <div class="stat">
              <div class="stat-value">18</div>
              <div class="stat-label">Wins</div>
            </div>
            <div class="stat">
              <div class="stat-value">4</div>
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
          <h3>Kigali Kings</h3>
          <p>Runners Up</p>
          <div class="team-stats">
            <div class="stat">
              <div class="stat-value">16</div>
              <div class="stat-label">Wins</div>
            </div>
            <div class="stat">
              <div class="stat-value">6</div>
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
          <h3>Eagles Rwanda</h3>
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

      <!-- Team 4 -->
      <div class="team-card">
        <div class="team-logo">
          <i class="fas fa-basketball-ball"></i>
        </div>
        <div class="team-info">
          <h3>Pirates BC</h3>
          <p>Semifinalists</p>
          <div class="team-stats">
            <div class="stat">
              <div class="stat-value">13</div>
              <div class="stat-label">Wins</div>
            </div>
            <div class="stat">
              <div class="stat-value">9</div>
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
      <h2>Current Standings</h2>
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
            <td>Rwanda Patriots</td>
            <td>22</td>
            <td>18</td>
            <td>4</td>
            <td>36</td>
            <td>98.5</td>
            <td>82.3</td>
            <td>+16.2</td>
          </tr>
          <tr>
            <td class="team-position">2</td>
            <td>Kigali Kings</td>
            <td>22</td>
            <td>16</td>
            <td>6</td>
            <td>32</td>
            <td>95.2</td>
            <td>84.1</td>
            <td>+11.1</td>
          </tr>
          <tr>
            <td class="team-position">3</td>
            <td>Eagles Rwanda</td>
            <td>22</td>
            <td>14</td>
            <td>8</td>
            <td>28</td>
            <td>92.8</td>
            <td>86.5</td>
            <td>+6.3</td>
          </tr>
          <tr>
            <td class="team-position">4</td>
            <td>Pirates BC</td>
            <td>22</td>
            <td>13</td>
            <td>9</td>
            <td>26</td>
            <td>90.4</td>
            <td>88.2</td>
            <td>+2.2</td>
          </tr>
          <tr>
            <td class="team-position">5</td>
            <td>Northern Warriors</td>
            <td>22</td>
            <td>11</td>
            <td>11</td>
            <td>22</td>
            <td>88.1</td>
            <td>89.7</td>
            <td>-1.6</td>
          </tr>
          <tr>
            <td class="team-position">6</td>
            <td>Southern Stars</td>
            <td>22</td>
            <td>9</td>
            <td>13</td>
            <td>18</td>
            <td>85.3</td>
            <td>91.8</td>
            <td>-6.5</td>
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
          <p>Experience the grand opening of the 2025 Genocide Memorial Cup with spectacular performances and tributes.
          </p>
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
      <h2 class="cta-title">Experience the Excitement Live</h2>
      <p class="cta-subtitle">Get your tickets now for the remaining games and be part of Rwanda's biggest basketball
        event of the year.</p>
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
          <div class="gmc-logo" style="font-size: 2rem; font-weight: bold; color: var(--secondary-color);">GMC</div>
          <p style="max-width: 300px;">Genocide Memorial Cup - Honoring memory through the spirit of basketball
            excellence.</p>
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
        <p>&copy; 2025 Genocide Memorial Cup. All rights reserved.</p>
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

    // Simple animation for elements when they come into view
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
        }
      });
    }, { threshold: 0.1 });

    document.querySelectorAll('.team-card, .match, .highlight-card').forEach(el => {
      observer.observe(el);
    });
  </script>

</body>

</html>