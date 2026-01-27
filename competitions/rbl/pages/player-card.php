<?php require_once __DIR__ . '/../includes/header.php'; ?><br><br>
<?php

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
  redirect('players.php');
}

$player_id = (int) $_GET['id'];

// Fetch player info
$stmt = $mysqli->prepare("
  SELECT p.id, p.name, p.position, p.jersey_number, p.height, p.nationality, p.photo,
         t.name AS team_name, t.id AS team_id
  FROM players p
  LEFT JOIN teams t ON t.id = p.team_id
  WHERE p.id = ?
  LIMIT 1
");
$stmt->bind_param('i', $player_id);
$stmt->execute();
$player = $stmt->get_result()->fetch_assoc();

if (!$player) {
  redirect('players.php');
}

// Fetch player stats
$stmt = $mysqli->prepare("
  SELECT *
  FROM player_stats
  WHERE player_id = ?
  LIMIT 1
");
$stmt->bind_param('i', $player_id);
$stmt->execute();
$stats = $stmt->get_result()->fetch_assoc();

// Helper function to calculate percentages safely
function calc_percent($made, $attempted)
{
  return $attempted > 0 ? round(($made / $attempted) * 100, 1) : 0;
}

// Per-game averages
$gp = max(1, (int) ($stats['games_played'] ?? 0));
$ppg = round(($stats['total_points'] ?? 0) / $gp, 1);
$rpg = round(($stats['total_rebounds'] ?? 0) / $gp, 1);
$apg = round(($stats['total_assists'] ?? 0) / $gp, 1);
$spg = round(($stats['total_steals'] ?? 0) / $gp, 1);
$bpg = round(($stats['total_blocks'] ?? 0) / $gp, 1);
$fg_pct = calc_percent($stats['fg_made'] ?? 0, $stats['fg_attempted'] ?? 0);
$three_pct = calc_percent($stats['three_made'] ?? 0, $stats['three_attempted'] ?? 0);
$ft_pct = calc_percent($stats['ft_made'] ?? 0, $stats['ft_attempted'] ?? 0);

?>

<style>
  /* 🏀 PROFESSIONAL PLAYER CARD - MOBILE FIRST RESPONSIVE */
  .player-page-wrapper {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    font-family: 'Inter', sans-serif;
  }

  /* Back Link */
  .back-link-pro {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #1a365d;
    font-weight: 700;
    text-decoration: none;
    margin-bottom: 24px;
    transition: 0.3s;
    font-size: 14px;
  }

  .back-link-pro:hover {
    color: #fbbf24;
    transform: translateX(-5px);
  }

  /* Hero Section */
  .p-hero {
    background: #fff;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    display: flex;
    flex-direction: row;
    /* Desktop default */
    border: 1px solid #f1f5f9;
    margin-bottom: 40px;
  }

  .p-hero-img {
    width: 350px;
    height: 450px;
    background: linear-gradient(135deg, #1a365d 0%, #2c5282 100%);
    position: relative;
    flex-shrink: 0;
  }

  .p-hero-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .p-jersey-badge {
    position: absolute;
    top: 20px;
    right: 20px;
    background: #fbbf24;
    color: #1a365d;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 900;
    font-size: 24px;
    box-shadow: 0 4px 12px rgba(251, 191, 36, 0.4);
  }

  .p-hero-body {
    padding: 40px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .p-name {
    font-size: 42px;
    font-weight: 900;
    color: #1a365d;
    margin: 0 0 10px 0;
    letter-spacing: -1.5px;
    line-height: 1;
  }

  .p-pos-tag {
    font-size: 16px;
    font-weight: 700;
    color: #fbbf24;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 30px;
  }

  /* Info Grid */
  .p-info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
  }

  .p-info-item {
    background: #f8fafc;
    padding: 15px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    gap: 15px;
  }

  .p-info-item i {
    color: #1a365d;
    font-size: 18px;
    width: 24px;
  }

  .p-info-label {
    font-size: 11px;
    text-transform: uppercase;
    font-weight: 700;
    color: #64748b;
    margin-bottom: 2px;
  }

  .p-info-value {
    font-size: 15px;
    font-weight: 800;
    color: #1e293b;
  }

  /* Stats Section */
  .p-stats-title {
    font-size: 24px;
    font-weight: 900;
    color: #1a365d;
    margin-bottom: 24px;
    padding-left: 12px;
    border-left: 5px solid #fbbf24;
  }

  .p-stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
  }

  .stat-box-pro {
    background: #fff;
    border: 1px solid #f1f5f9;
    padding: 24px;
    border-radius: 20px;
    text-align: center;
    transition: 0.3s;
  }

  .stat-box-pro:hover {
    border-color: #fbbf24;
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
  }

  .st-label-pro {
    font-size: 11px;
    text-transform: uppercase;
    font-weight: 700;
    color: #64748b;
    margin-bottom: 8px;
    letter-spacing: 1px;
  }

  .st-value-pro {
    font-size: 32px;
    font-weight: 900;
    color: #1a365d;
    line-height: 1;
  }

  /* 📱 RESPONSIVE BREAKPOINTS */
  @media (max-width: 900px) {
    .p-hero {
      flex-direction: column;
    }

    .p-hero-img {
      width: 100%;
      height: 350px;
    }

    .p-stats-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (max-width: 600px) {
    .player-page-wrapper {
      padding: 15px;
    }

    .p-name {
      font-size: 28px;
      letter-spacing: -1px;
    }

    .p-pos-tag {
      font-size: 14px;
      margin-bottom: 20px;
    }

    .p-hero-body {
      padding: 20px;
    }

    .p-info-grid {
      grid-template-columns: 1fr;
      gap: 12px;
    }

    .p-info-item {
      padding: 12px;
    }

    .p-stats-grid {
      grid-template-columns: repeat(2, 1fr);
      gap: 10px;
    }

    .st-value-pro {
      font-size: 24px;
    }

    .stat-box-pro {
      padding: 12px;
    }
  }
</style>

<div class="player-page-wrapper">

  <a href="players.php" class="back-link-pro">
    <i class="fas fa-arrow-left"></i> Back to Roster
  </a>

  <section class="p-hero">
    <div class="p-hero-img">
      <?php if (!empty($player['photo'])): ?>
        <img src="../../../admin/uploads/<?php echo sanitize($player['photo']); ?>" alt="">
      <?php else: ?>
        <img src="https://via.placeholder.com/400x500?text=RBL+Player" alt="">
      <?php endif; ?>
      <div class="p-jersey-badge">#<?php echo (int) $player['jersey_number']; ?></div>
    </div>

    <div class="p-hero-body">
      <div class="p-pos-tag"><?php echo sanitize($player['position']); ?></div>
      <h1 class="p-name"><?php echo sanitize($player['name']); ?></h1>

      <div class="p-info-grid">
        <div class="p-info-item">
          <i class="fas fa-shield-alt"></i>
          <div>
            <div class="p-info-label">Current Club</div>
            <div class="p-info-value"><?php echo sanitize($player['team_name']); ?></div>
          </div>
        </div>
        <div class="p-info-item">
          <i class="fas fa-ruler-vertical"></i>
          <div>
            <div class="p-info-label">Height</div>
            <div class="p-info-value"><?php echo sanitize($player['height']); ?></div>
          </div>
        </div>
        <div class="p-info-item">
          <i class="fas fa-flag"></i>
          <div>
            <div class="p-info-label">Nationality</div>
            <div class="p-info-value"><?php echo sanitize($player['nationality']); ?></div>
          </div>
        </div>
        <div class="p-info-item">
          <i class="fas fa-basketball-ball"></i>
          <div>
            <div class="p-info-label">Experience</div>
            <div class="p-info-value"><?php echo $gp; ?> Games</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <h3 class="p-stats-title">Season averages</h3>

  <div class="p-stats-grid">
    <div class="stat-box-pro">
      <div class="st-label-pro">PTS / GM</div>
      <div class="st-value-pro"><?php echo $ppg; ?></div>
    </div>
    <div class="stat-box-pro">
      <div class="st-label-pro">REB / GM</div>
      <div class="st-value-pro"><?php echo $rpg; ?></div>
    </div>
    <div class="stat-box-pro">
      <div class="st-label-pro">AST / GM</div>
      <div class="st-value-pro"><?php echo $apg; ?></div>
    </div>
    <div class="stat-box-pro">
      <div class="st-label-pro">STL / GM</div>
      <div class="st-value-pro"><?php echo $spg; ?></div>
    </div>
    <div class="stat-box-pro">
      <div class="st-label-pro">FG %</div>
      <div class="st-value-pro"><?php echo $fg_pct; ?>%</div>
    </div>
    <div class="stat-box-pro">
      <div class="st-label-pro">3P %</div>
      <div class="st-value-pro"><?php echo $three_pct; ?>%</div>
    </div>
    <div class="stat-box-pro">
      <div class="st-label-pro">FT %</div>
      <div class="st-value-pro"><?php echo $ft_pct; ?>%</div>
    </div>
    <div class="stat-box-pro">
      <div class="st-label-pro">BLK / GM</div>
      <div class="st-value-pro"><?php echo $bpg; ?></div>
    </div>
  </div>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>