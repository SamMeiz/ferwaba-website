<?php require_once __DIR__ . '/../includes/header.php'; ?>

<style>
  /* Professional Homepage Styles */
  .hero {
    position: relative;
    width: 100vw;
    height: 85vh;
    min-height: 600px;
    margin: -140px -16px 0 -16px;
    left: 50%;
    right: 50%;
    margin-left: -50vw;
    margin-right: -50vw;
    overflow: hidden;
  }

  .hero-backgrounds {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
  }

  .hero-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    opacity: 0;
    transform: scale(1.1);
    transition: opacity 1.5s ease-in-out, transform 8s ease;
  }

  .hero-bg.active {
    opacity: 1;
    transform: scale(1);
  }

  .hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(26, 54, 93, 0.85) 0%, rgba(26, 54, 93, 0.6) 50%, rgba(26, 54, 93, 0.4) 100%);
  }

  .hero-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    z-index: 10;
    max-width: 900px;
    padding: 0 20px;
  }

  .hero-badge {
    display: inline-block;
    background: rgba(251, 191, 36, 0.2);
    border: 2px solid #fbbf24;
    color: #fbbf24;
    padding: 8px 20px;
    border-radius: 30px;
    font-size: 13px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 24px;
  }

  .hero h1 {
    font-size: 64px;
    font-weight: 900;
    color: #fff;
    margin: 0 0 16px 0;
    line-height: 1.1;
    text-shadow: 2px 4px 8px rgba(0, 0, 0, 0.3);
  }

  .hero p {
    font-size: 20px;
    color: rgba(255, 255, 255, 0.9);
    margin: 0 0 32px 0;
    line-height: 1.6;
  }

  .hero-buttons {
    display: flex;
    gap: 16px;
    justify-content: center;
    flex-wrap: wrap;
  }

  .hero-btn {
    padding: 16px 36px;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.3s ease;
  }

  .hero-btn-primary {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    color: #1a365d;
    box-shadow: 0 8px 24px rgba(251, 191, 36, 0.4);
  }

  .hero-btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 32px rgba(251, 191, 36, 0.5);
  }

  .hero-btn-secondary {
    background: rgba(255, 255, 255, 0.15);
    color: #fff;
    border: 2px solid rgba(255, 255, 255, 0.4);
    backdrop-filter: blur(10px);
  }

  .hero-btn-secondary:hover {
    background: rgba(255, 255, 255, 0.25);
    border-color: #fff;
  }

  /* Section Styling */
  .home-section {
    padding: 60px 0;
  }

  .section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 32px;
    flex-wrap: wrap;
    gap: 16px;
  }

  .section-header h2 {
    font-size: 32px;
    font-weight: 800;
    color: #fff;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .section-header h2 i {
    color: #fbbf24;
  }

  .view-all-btn {
    background: linear-gradient(135deg, #1a365d 0%, #2c5282 100%);
    color: #fff;
    padding: 12px 24px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
  }

  .view-all-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(26, 54, 93, 0.3);
  }

  /* Games Table */
  .games-card {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
  }

  .games-table {
    width: 100%;
    border-collapse: collapse;
  }

  .games-table th {
    background: linear-gradient(90deg, #f8fafc 0%, #f1f5f9 100%);
    padding: 16px 20px;
    text-align: left;
    font-size: 12px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .games-table td {
    padding: 18px 20px;
    border-bottom: 1px solid #f1f5f9;
    font-size: 14px;
    color: #1a1a1a;
  }

  .games-table tr:last-child td {
    border-bottom: none;
  }

  .games-table tr:hover td {
    background: #f8fafc;
  }

  .match-cell {
    font-weight: 700;
    color: #1a365d;
  }

  .btn-ticket {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    color: #1a365d;
    padding: 8px 16px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 700;
    font-size: 12px;
    transition: all 0.3s ease;
  }

  .btn-ticket:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(251, 191, 36, 0.4);
  }

  .upcoming-highlight td {
    background: rgba(34, 197, 94, 0.08) !important;
  }

  /* Standings Grid */
  .standings-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 24px;
  }

  .standings-mini-card {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
  }

  .standings-mini-header {
    background: linear-gradient(135deg, #1a365d 0%, #2c5282 100%);
    padding: 20px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .standings-mini-header h4 {
    color: #fff;
    font-size: 18px;
    font-weight: 700;
    margin: 0;
  }

  .standings-mini-header .btn-small {
    background: rgba(255, 255, 255, 0.2);
    color: #fff;
    padding: 8px 16px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    font-size: 12px;
    border: none;
    transition: all 0.2s ease;
  }

  .standings-mini-header .btn-small:hover {
    background: #fbbf24;
    color: #1a365d;
  }

  .gender-tabs {
    display: flex;
    gap: 8px;
    padding: 16px 24px;
    background: #f8fafc;
  }

  .gender-tab {
    padding: 8px 20px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    color: #64748b;
    background: #fff;
    border: 2px solid #e5e7eb;
    transition: all 0.2s ease;
  }

  .gender-tab.active {
    background: #1a365d;
    color: #fff;
    border-color: #1a365d;
  }

  .gender-tab:hover:not(.active) {
    border-color: #1a365d;
  }

  .standings-mini-table {
    width: 100%;
    border-collapse: collapse;
  }

  .standings-mini-table th {
    padding: 12px 16px;
    text-align: left;
    font-size: 11px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    background: #f8fafc;
  }

  .standings-mini-table td {
    padding: 14px 16px;
    font-size: 14px;
    border-bottom: 1px solid #f1f5f9;
  }

  .standings-mini-table tr:last-child td {
    border-bottom: none;
  }

  @media (max-width: 1024px) {
    .standings-grid {
      grid-template-columns: 1fr;
    }
  }

  @media (max-width: 768px) {
    .hero h1 {
      font-size: 36px;
    }

    .hero p {
      font-size: 16px;
    }

    .section-header h2 {
      font-size: 24px;
    }
  }
</style>

<section class="hero">
  <div class="hero-backgrounds">
    <div class="hero-bg active" style="background-image:url('../img/banner1.png');"
      data-title="Rwanda Basketball League" data-sub="The premier professional basketball competition in Rwanda"></div>
    <div class="hero-bg" style="background-image:url('../img/banner2.png');" data-title="Redefining African Basketball"
      data-sub="Experience the passion, dedication, and excellence of Rwandan basketball"></div>
    <div class="hero-bg" style="background-image:url('../img/banner3.png');" data-title="Exciting Matchups"
      data-sub="Stay updated with live scores, schedules, and results"></div>
    <div class="hero-bg" style="background-image:url('../img/banner4.png');" data-title="Future of Basketball"
      data-sub="Developing the next generation of elite players"></div>
    <div class="hero-bg" style="background-image:url('../img/banner5.png');" data-title="Women's League Rising"
      data-sub="Empowering women athletes to reach new heights"></div>
  </div>

  <div class="hero-overlay"></div>

  <div class="hero-content">
    <div class="hero-badge"><i class="fas fa-basketball-ball"></i> Official League</div>
    <h1>Rwanda Basketball League</h1>
    <p>The premier professional basketball competition organized by FERWABA. Follow your favorite teams and players
      throughout the season.</p>
    <div class="hero-buttons">
      <a class="hero-btn hero-btn-primary" href="games.php"><i class="fas fa-calendar-alt"></i> View Schedule</a>
      <a class="hero-btn hero-btn-secondary" href="standings.php"><i class="fas fa-trophy"></i> Standings</a>
    </div>
  </div>
</section>


<!-- Upcoming Games Section -->
<section class="home-section">
  <div class="section-header">
    <h2><i class="fas fa-calendar-alt"></i> Upcoming Games</h2>
    <a class="view-all-btn" href="games.php"><i class="fas fa-arrow-right"></i> View All Games</a>
  </div>

  <div class="games-card">
    <table class="games-table">
      <thead>
        <tr>
          <th>Date</th>
          <th>Match</th>
          <th>Division</th>
          <th>Gender</th>
          <th>Venue</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $today = date('Y-m-d');
        $three_days = date('Y-m-d', strtotime('+3 days'));

        $q = "SELECT g.*, th.name AS home_name, ta.name AS away_name 
        FROM games g
        JOIN teams th ON th.id = g.home_team_id
        JOIN teams ta ON ta.id = g.away_team_id
        WHERE g.status='Scheduled' 
        ORDER BY g.game_date ASC, g.id ASC 
        LIMIT 5";

        if ($r = $mysqli->query($q)) {
          while ($g = $r->fetch_assoc()):
            $row_class = '';
            if ($g['game_date'] >= $today && $g['game_date'] <= $three_days) {
              $row_class = 'upcoming-highlight';
            }
            ?>
            <tr class="<?php echo $row_class; ?>">
              <td><?php echo date('M d, Y', strtotime($g['game_date'])); ?></td>
              <td class="match-cell"><?php echo sanitize($g['home_name'] . ' vs ' . $g['away_name']); ?></td>
              <td><?php echo sanitize($g['division']); ?></td>
              <td><?php echo sanitize($g['gender']); ?></td>
              <td><?php echo sanitize($g['location']); ?></td>
              <td>
                <a href="https://ticqet.rw" target="_blank" class="btn-ticket"><i class="fas fa-ticket-alt"></i> Tickets</a>
              </td>
            </tr>
          <?php endwhile;
        } ?>
      </tbody>
    </table>
  </div>
</section>

<!-- Standings Section -->
<section class="home-section">
  <div class="section-header">
    <h2><i class="fas fa-trophy"></i> League Standings</h2>
    <a class="view-all-btn" href="standings.php"><i class="fas fa-arrow-right"></i> Full Tables</a>
  </div>

  <div class="standings-grid">
    <?php
    $divisions = ["Division 1", "Division 2"];
    foreach ($divisions as $div):
      $paramName = 'gender_' . str_replace(' ', '_', $div);
      $selectedGender = $_GET[$paramName] ?? 'Men';
      $genders = ["Men", "Women"];

      $stmt = $mysqli->prepare("
        SELECT s.*, t.name 
        FROM standings s 
        JOIN teams t ON t.id = s.team_id 
        WHERE s.division=? AND s.gender=? 
        ORDER BY s.points DESC, s.wins DESC 
        LIMIT 5
      ");
      $stmt->bind_param('ss', $div, $selectedGender);
      $stmt->execute();
      $res = $stmt->get_result();
      ?>

      <div class="standings-mini-card">
        <div class="standings-mini-header">
          <h4><?php echo sanitize($div); ?></h4>
          <a href="standings.php?division=<?php echo urlencode($div); ?>&gender=<?php echo urlencode($selectedGender); ?>"
            class="btn-small">Full Table</a>
        </div>

        <div class="gender-tabs">
          <?php foreach ($genders as $gender):
            $isActive = ($selectedGender === $gender);
            $activeClass = $isActive ? 'gender-tab active' : 'gender-tab';
            $url = "?{$paramName}=" . urlencode($gender);
            ?>
            <a href="<?php echo $url; ?>" class="<?php echo $activeClass; ?>">
              <?php echo sanitize($gender); ?>
            </a>
          <?php endforeach; ?>
        </div>

        <table class="standings-mini-table">
          <thead>
            <tr>
              <th>Team</th>
              <th>GP</th>
              <th>W</th>
              <th>L</th>
              <th>Pts</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($res->num_rows > 0):
              while ($row = $res->fetch_assoc()): ?>
                <tr>
                  <td style="font-weight:600;color:#1a365d;"><?php echo sanitize($row['name']); ?></td>
                  <td><?php echo (int) $row['games_played']; ?></td>
                  <td style="color:#16a34a;font-weight:600;"><?php echo (int) $row['wins']; ?></td>
                  <td style="color:#dc2626;font-weight:600;"><?php echo (int) $row['losses']; ?></td>
                  <td style="font-weight:800;color:#1a365d;"><?php echo (int) $row['points']; ?></td>
                </tr>
              <?php endwhile; else: ?>
              <tr>
                <td colspan="5" style="text-align:center;color:#999;padding:30px;">No data available</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

    <?php endforeach; ?>
  </div>
</section>


<script>
  // Hero Slideshow
  const heroBGs = document.querySelectorAll('.hero-bg');
  let current = 0;

  function showSlide(index) {
    heroBGs.forEach((bg, i) => bg.classList.remove('active'));
    const bg = heroBGs[index];
    const title = bg.getAttribute('data-title');
    const sub = bg.getAttribute('data-sub');
    const heroContent = document.querySelector('.hero-content');
    heroContent.querySelector('h1').textContent = title;
    heroContent.querySelector('p').textContent = sub;
    heroBGs[index].classList.add('active');
    heroContent.classList.add('active');
  }

  setInterval(() => {
    current = (current + 1) % heroBGs.length;
    showSlide(current);
  }, 5000);
</script>


<?php require_once __DIR__ . '/../includes/footer.php'; ?>