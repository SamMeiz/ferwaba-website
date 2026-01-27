<?php require_once __DIR__ . '/../includes/header.php'; ?><br><br><br><br>
<?php

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
  redirect('teams.php');
}

$team_id = (int) $_GET['id'];

// Fetch team details
$stmt = $mysqli->prepare("SELECT * FROM teams WHERE id=? LIMIT 1");
$stmt->bind_param('i', $team_id);
$stmt->execute();
$team = $stmt->get_result()->fetch_assoc();

if (!$team) {
  redirect('teams.php');
}

// Roster
$players = $mysqli->query("
  SELECT id AS player_id, name, position, jersey_number, height, nationality, photo 
  FROM players 
  WHERE team_id = $team_id 
  ORDER BY jersey_number ASC
");

// Coaches
$coaches = $mysqli->query("
  SELECT id, name, role, nationality, photo 
  FROM coaches 
  WHERE team_id = $team_id 
  ORDER BY FIELD(role, 'Head Coach', 'Assistant Coach', 'Team Staff'), name ASC
");

// Gallery
$gallery = $mysqli->query("
  SELECT image, caption 
  FROM gallery 
  WHERE team_id = $team_id 
  ORDER BY uploaded_at DESC LIMIT 12
");

// Player stats
$stats_res = $mysqli->query("
  SELECT ps.*, p.name, p.id AS player_id
  FROM player_stats ps
  JOIN players p ON ps.player_id = p.id
  WHERE p.team_id = $team_id
  ORDER BY (ps.total_points / GREATEST(ps.games_played, 1)) DESC
");

// Fixtures & Results
$fixtures_results = $mysqli->query("
  (SELECT g.*, th.name AS home_name, ta.name AS away_name
   FROM games g
   JOIN teams th ON th.id = g.home_team_id
   JOIN teams ta ON ta.id = g.away_team_id
   WHERE (g.home_team_id = $team_id OR g.away_team_id = $team_id)
     AND g.status IN ('Finished', 'Completed')
   ORDER BY g.game_date DESC
   LIMIT 3)
  UNION ALL
  (SELECT g.*, th.name AS home_name, ta.name AS away_name
   FROM games g
   JOIN teams th ON th.id = g.home_team_id
   JOIN teams ta ON ta.id = g.away_team_id
   WHERE (g.home_team_id = $team_id OR g.away_team_id = $team_id)
     AND g.status IN ('Scheduled', 'Pending', 'Live')
   ORDER BY g.game_date ASC
   LIMIT 3)
  ORDER BY game_date DESC
");

?>

<style>
/* Professional & Compact Team Detail Page */
.team-page {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
  font-family: 'Inter', sans-serif;
  color: #334155;
}

/* Compact Header */
.team-header {
  background: white;
  border-radius: 12px;
  padding: 30px;
  display: flex;
  align-items: center;
  gap: 30px;
  border: 1px solid #e2e8f0;
  margin-bottom: 30px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

.t-logo {
  width: 100px;
  height: 100px;
  flex-shrink: 0;
}

.t-logo img {
  width: 100%;
  height: 100%;
  object-fit: contain;
}

.t-main-info h1 {
  font-size: 32px;
  font-weight: 800;
  color: #1e293b;
  margin: 0 0 8px 0;
}

.t-badges {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
}

.t-badge {
  font-size: 13px;
  font-weight: 600;
  background: #f1f5f9;
  padding: 4px 12px;
  border-radius: 6px;
  color: #64748b;
  display: flex;
  align-items: center;
  gap: 6px;
}

.t-badge i { color: #fbbf24; }

/* Grid Layout */
.team-layout {
  display: grid;
  grid-template-columns: 1fr 340px;
  gap: 30px;
}

.section-box {
  background: white;
  border-radius: 12px;
  border: 1px solid #e2e8f0;
  padding: 24px;
  margin-bottom: 30px;
}

.section-box h2 {
  font-size: 18px;
  font-weight: 700;
  color: #1e293b;
  margin: 0 0 20px 0;
  display: flex;
  align-items: center;
  gap: 10px;
}

/* Compact Roster Table */
.compact-table {
  width: 100%;
  border-collapse: collapse;
}

.compact-table th {
  text-align: left;
  font-size: 11px;
  text-transform: uppercase;
  color: #94a3b8;
  padding: 8px 12px;
  border-bottom: 1px solid #f1f5f9;
}

.compact-table td {
  padding: 10px 12px;
  border-bottom: 1px solid #f8fafc;
  font-size: 14px;
}

.p-flex {
  display: flex;
  align-items: center;
  gap: 12px;
}

.p-img {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  object-fit: cover;
  background: #f1f5f9;
}

.j-num {
  font-weight: 700;
  color: #fbbf24;
  min-width: 20px;
}

/* Compact Scoreboard Items */
.game-card {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 12px;
  border-radius: 8px;
  background: #f8fafc;
  margin-bottom: 10px;
  font-size: 13px;
}

.game-card:last-child { margin-bottom: 0; }

.g-teams {
  font-weight: 600;
  color: #1e293b;
  flex-grow: 1;
}

.g-score {
  background: #1e293b;
  color: white;
  padding: 2px 8px;
  border-radius: 4px;
  font-weight: 700;
  font-family: monospace;
  margin: 0 10px;
}

/* Small Gallery */
.small-gallery {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 10px;
}

.gallery-thumb {
  aspect-ratio: 1;
  border-radius: 6px;
  overflow: hidden;
  cursor: pointer;
  position: relative;
}

.gallery-thumb img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.gallery-thumb:hover img { transform: scale(1.1); }

/* Sidebar Staff */
.staff-item {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 12px;
}

.staff-img {
  width: 40px;
  height: 40px;
  border-radius: 8px;
  object-fit: cover;
}

.staff-info h4 {
  font-size: 14px;
  font-weight: 600;
  margin: 0;
  color: #1e293b;
}

.staff-info p {
  font-size: 12px;
  margin: 0;
  color: #64748b;
}

/* Lightbox Wrapper */
#lightbox {
  display:none; position:fixed; inset:0; background:rgba(15,23,42,0.9);
  z-index:9999; justify-content:center; align-items:center; padding:20px;
}
#lightbox img { max-width:100%; max-height:100%; border-radius:8px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.5); }

@media (max-width: 900px) {
  .team-layout { grid-template-columns: 1fr; }
  .small-gallery { grid-template-columns: repeat(3, 1fr); }
}
</style>

<div class="team-page">

  <!-- Compact Custom Header -->
  <header class="team-header">
    <div class="t-logo">
      <?php if (!empty($team['logo'])): ?>
          <img src="../../../admin/uploads/<?php echo sanitize($team['logo']); ?>" alt="Logo">
      <?php else: ?>
          <img src="https://via.placeholder.com/100?text=Logo" alt="Placeholder">
      <?php endif; ?>
    </div>
    <div class="t-main-info">
      <h1><?php echo sanitize($team['name']); ?></h1>
      <div class="t-badges">
        <span class="t-badge"><i class="fas fa-layer-group"></i> <?php echo sanitize($team['division']); ?></span>
        <span class="t-badge"><i class="fas fa-venus-mars"></i> <?php echo sanitize($team['gender']); ?></span>
        <span class="t-badge"><i class="fas fa-map-marker-alt"></i> <?php echo sanitize($team['location']); ?></span>
      </div>
    </div>
  </header>

  <div class="team-layout">
    
    <!-- Left Column -->
    <main>
      <!-- Roster List -->
      <section class="section-box">
        <h2><i class="fas fa-users-viewfinder"></i> Team Roster</h2>
        <div style="overflow-x:auto;">
          <table class="compact-table">
            <thead>
              <tr>
                <th>Player</th>
                <th>POS</th>
                <th>HT</th>
                <th>NAT</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($p = $players->fetch_assoc()):
                $photo = !empty($p['photo']) ? '../../../admin/uploads/' . sanitize($p['photo']) : 'https://via.placeholder.com/100?text=P';
                ?>
                  <tr>
                    <td>
                      <div class="p-flex">
                        <span class="j-num"><?php echo (int) $p['jersey_number']; ?></span>
                        <img src="<?php echo $photo; ?>" class="p-img" alt="">
                        <a href="player-card.php?id=<?php echo (int) $p['player_id']; ?>" style="text-decoration:none; color:#1e293b; font-weight:600;">
                          <?php echo sanitize($p['name']); ?>
                        </a>
                      </div>
                    </td>
                    <td><?php echo sanitize($p['position']); ?></td>
                    <td><?php echo sanitize($p['height']); ?></td>
                    <td><?php echo sanitize($p['nationality']); ?></td>
                  </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </section>

      <!-- Player Stats (Compact Leaderboard) -->
      <section class="section-box">
        <h2><i class="fas fa-chart-simple"></i> Statistical Leaders</h2>
        <div style="overflow-x:auto;">
          <table class="compact-table">
            <thead>
              <tr>
                <th>Player</th>
                <th>GP</th>
                <th>PPG</th>
                <th>RPG</th>
                <th>APG</th>
                <th>FG%</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($s = $stats_res->fetch_assoc()):
                $gp = max(1, $s['games_played']);
                $ppg = round($s['total_points'] / $gp, 1);
                $rpg = round($s['total_rebounds'] / $gp, 1);
                ?>
                  <tr>
                    <td><span style="font-weight:600;"><?php echo sanitize($s['name']); ?></span></td>
                    <td><?php echo $gp; ?></td>
                    <td style="font-weight:700; color:#1e293b;"><?php echo $ppg; ?></td>
                    <td><?php echo $rpg; ?></td>
                    <td><?php echo round($s['total_assists'] / $gp, 1); ?></td>
                    <td><?php echo $s['fg_attempted'] > 0 ? round(($s['fg_made'] / $s['fg_attempted']) * 100, 1) : 0; ?>%</td>
                  </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </section>

      <!-- Smaller Gallery -->
      <section class="section-box">
        <h2><i class="fas fa-images"></i> Team Gallery</h2>
        <div class="small-gallery">
          <?php while ($g = $gallery->fetch_assoc()):
            $img_path = '../../../admin/uploads/' . sanitize($g['image']);
            ?>
              <div class="gallery-thumb" onclick="openLightbox('<?php echo $img_path; ?>')">
                <img src="<?php echo $img_path; ?>" alt="">
              </div>
          <?php endwhile; ?>
        </div>
      </section>
    </main>

    <!-- Right Sidebar -->
    <aside>
      <!-- Results & Fixtures -->
      <section class="section-box">
        <h2><i class="fas fa-calendar-days"></i> Results & Schedule</h2>
        <?php if ($fixtures_results && $fixtures_results->num_rows > 0): ?>
            <?php while ($gm = $fixtures_results->fetch_assoc()):
              $is_finished = in_array($gm['status'], ['Finished', 'Completed']);
              ?>
                <div class="game-card">
                  <div style="flex-shrink:0; text-align:center; margin-right:12px;">
                    <div style="font-size:14px; font-weight:700;"><?php echo date('d', strtotime($gm['game_date'])); ?></div>
                    <div style="font-size:10px; text-transform:uppercase; color:#94a3b8;"><?php echo date('M', strtotime($gm['game_date'])); ?></div>
                  </div>
                  <div class="g-teams">
                    <?php echo sanitize($gm['home_name']); ?>
                    <?php if ($is_finished): ?>
                        <span class="g-score"><?php echo (int) $gm['home_score']; ?>-<?php echo (int) $gm['away_score']; ?></span>
                    <?php else: ?>
                        <span style="color:#94a3b8; font-size:11px; margin:0 8px;">VS</span>
                    <?php endif; ?>
                    <?php echo sanitize($gm['away_name']); ?>
                  </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="font-size:13px; color:#94a3b8;">No data available.</p>
        <?php endif; ?>
      </section>

      <!-- Coaching Staff -->
      <section class="section-box">
        <h2><i class="fas fa-user-tie"></i> Coaching Staff</h2>
        <?php while ($c = $coaches->fetch_assoc()):
          $cphoto = !empty($c['photo']) ? '../../../admin/uploads/' . sanitize($c['photo']) : 'https://via.placeholder.com/80?text=C';
          ?>
            <div class="staff-item">
              <img src="<?php echo $cphoto; ?>" class="staff-img" alt="">
              <div class="staff-info">
                <h4><?php echo sanitize($c['name']); ?></h4>
                <p><?php echo sanitize($c['role']); ?></p>
              </div>
            </div>
        <?php endwhile; ?>
      </section>
    </aside>

  </div>
</div>

<div id="lightbox" onclick="this.style.display='none'"><img id="lb-img" src=""></div>

<script>
function openLightbox(src){
  document.getElementById('lb-img').src = src;
  document.getElementById('lightbox').style.display = 'flex';
}
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>