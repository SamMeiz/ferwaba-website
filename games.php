<?php require_once __DIR__ . '/includes/header.php'; ?>
<br><br><br><br><br><br>
<head>
  <style>
.games-filter { margin-bottom: 20px; display: flex; gap: 10px; flex-wrap: wrap; } 
.games-filter select, .games-filter input[type="date"] { padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; background: white; font-size: 14px; } 
.games-filter .btn { background: var(--blue); color: white; border: none; border-radius: 4px; padding: 8px 16px; font-weight: 500; cursor: pointer; transition: 0.25s; } 
.games-filter .btn:hover { background: var(--gold); color: #000; } 
.games-schedule { max-width: 100%; margin: 0 auto; } 
.date-section { margin-bottom: 30px; } 
.date-header { background: #f5f5f5; padding: 12px 20px; border-bottom: 1px solid #e0e0e0; font-weight: 600; font-size: 13px; color: #666; text-transform: uppercase; display: flex; justify-content: space-between; align-items: center; } 
.game-count { color: #999; font-size: 12px; } 
.game-row { display: flex; align-items: center; justify-content: space-between; padding: 12px 20px; border-bottom: 1px solid #f0f0f0; background: white; transition: background 0.2s; flex-wrap: nowrap; } 
.game-row:hover { background: #fafafa; } 
.game-time { font-size: 13px; color: #666; min-width: 80px; display: flex; flex-direction: column; } 
.time-main { font-weight: 600; color: #000; display: block; margin-bottom: 2px; } 
.network { font-size: 11px; color: #999; } 
.game-matchup { display: flex; align-items: center; gap: 12px; min-width: 200px; } 
.teams-wrapper { display: flex; flex-direction: column; gap: 6px; } 
.team-row { display: flex; align-items: center; gap: 6px; } 
.team-name { font-weight: 500; color: #000; font-size: 14px; } 
.team-badge { display: inline-block; padding: 2px 5px; background: #f0f0f0; border-radius: 3px; font-size: 10px; color: #666; font-weight: 600; } 
.score-wrapper { display: flex; flex-direction: column; justify-content: space-between; min-width: 50px; text-align: center; } 
.team-score { font-size: 18px; font-weight: 700; color: #000; line-height: 1.4; } 
.game-location { font-size: 13px; color: #666; min-width: 120px; text-align: center; } 
.location-name { font-weight: 500; } 
.game-status-actions { display: flex; align-items: center; gap: 8px; margin-left: 20px; } 
.status-badge { display: inline-block; padding: 6px 12px; border-radius: 4px; font-size: 12px; font-weight: 600; white-space: nowrap; } 
.status-scheduled { background: #e8f4fd; color: #0066cc; } 
.status-live { background: #fee; color: #c00; } 
.status-final { background: #f0f0f0; color: #666; } 
.btn-action { padding: 6px 12px; border-radius: 4px; font-size: 12px; font-weight: 500; text-decoration: none; transition: 0.2s; border: 1px solid #ddd; background: white; color: #333; cursor: pointer; white-space: nowrap; } 
.btn-action:hover { background: var(--blue); color: white; border-color: var(--blue); } 
.btn-tickets { background: var(--gold); color: #000; border-color: var(--gold); margin-left: auto; } 
.btn-tickets:hover { background: #d4a017; border-color: #d4a017; } 
.btn-highlight { background: var(--blue); color: white; border-color: var(--blue); } 
.btn-highlight:hover { background: #0056b3; border-color: #0056b3; } 
@media (max-width: 768px) { .game-row { flex-direction: column; align-items: center; gap: 12px; padding: 15px; } .score-wrapper { flex-direction: row; gap: 15px; justify-content: center; width: 100%; } .game-location, .game-status-actions { text-align: center; margin-left: 0; } .teams-wrapper { flex-direction: column; gap: 6px; } .btn-tickets { margin-left: 0; } }


  </style>
</head>

<section class="section-title">
  <h2>Games Schedule</h2>
  <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
    <form method="get" class="games-filter">
      <select name="division">
        <option value="">All Divisions</option>
        <option value="Division 1" <?php echo (($_GET['division'] ?? '')==='Division 1')?'selected':''; ?>>Division 1</option>
        <option value="Division 2" <?php echo (($_GET['division'] ?? '')==='Division 2')?'selected':''; ?>>Division 2</option>
      </select>

      <select name="gender">
        <option value="">All Genders</option>
        <option value="Men" <?php echo (($_GET['gender'] ?? '')==='Men')?'selected':''; ?>>Men</option>
        <option value="Women" <?php echo (($_GET['gender'] ?? '')==='Women')?'selected':''; ?>>Women</option>
      </select>

      <input type="date" name="date" value="<?php echo sanitize($_GET['date'] ?? ''); ?>">
      <input type="hidden" name="hide_completed" value="<?php echo $_GET['hide_completed'] ?? '1'; ?>">
      <button class="btn" type="submit">Apply Filters</button>
    </form>
    
    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 14px;">
      <span>Hide Completed Games</span>
      <input type="checkbox" id="hideCompletedToggle" <?php echo ($_GET['hide_completed'] ?? '1') === '1' ? 'checked' : ''; ?> 
             onchange="toggleCompleted(this)" style="width: 40px; height: 20px; cursor: pointer;">
    </label>
  </div>
</section>

<script>
function toggleCompleted(checkbox) {
  const url = new URL(window.location.href);
  url.searchParams.set('hide_completed', checkbox.checked ? '1' : '0');
  window.location.href = url.toString();
}
</script>

<div class="games-schedule">
  <?php
  $where = [];
  $types = '';
  $params = [];

  if (!empty($_GET['division'])) { $where[]='g.division=?'; $types.='s'; $params[]=$_GET['division']; }
  if (!empty($_GET['gender'])) { $where[]='g.gender=?'; $types.='s'; $params[]=$_GET['gender']; }
  if (!empty($_GET['date'])) { $where[]='g.game_date=?'; $types.='s'; $params[]=$_GET['date']; }
  
  // Default to hiding completed games unless explicitly set to show
  $hide_completed = ($_GET['hide_completed'] ?? '1') === '1';
  if ($hide_completed) { $where[]="g.status != 'Completed'"; }

  $sql = "SELECT g.*, th.name AS home_name, ta.name AS away_name 
          FROM games g 
          JOIN teams th ON th.id=g.home_team_id 
          JOIN teams ta ON ta.id=g.away_team_id";
  if ($where) $sql .= ' WHERE ' . implode(' AND ', $where);
  $sql .= ' ORDER BY g.game_date DESC, g.id DESC';

  $stmt = $mysqli->prepare($sql);
  if ($types) $stmt->bind_param($types, ...$params);
  $stmt->execute();
  $res = $stmt->get_result();

  $games_by_date = [];
  while($g = $res->fetch_assoc()) {
    $games_by_date[$g['game_date']][] = $g;
  }

  foreach($games_by_date as $date => $games):
    $date_obj = new DateTime($date);
    $day_name = $date_obj->format('l');
    $formatted_date = $date_obj->format('F j');
  ?>
  <div class="date-section">
    <div class="date-header">
      <span><?php echo strtoupper($day_name . ', ' . $formatted_date); ?></span>
      <span class="game-count"><?php echo count($games); ?> Games</span>
    </div>
    
    <?php foreach($games as $g): ?>
    <div class="game-row">
      <div class="game-time">
        <span class="time-main">
          <?php 
          if(!empty($g['game_time'])) {
            echo date('g:i A', strtotime($g['game_time'])) . ' ET';
          }
          ?>
        </span>
        <span class="network"><?php echo sanitize($g['division']); ?></span>
      </div>

      <div class="game-matchup">
        <div class="teams-wrapper">
          <div class="team-row">
            <span class="team-name"><?php echo sanitize($g['away_name']); ?></span>
            <span class="team-badge"><?php echo sanitize($g['gender']); ?></span>
          </div>
          <div class="team-row">
            <span class="team-name"><?php echo sanitize($g['home_name']); ?></span>
          </div>
        </div>
        
        <?php if($g['status'] === 'Completed'): ?>
        <div class="score-wrapper">
          <span class="team-score"><?php echo (int)$g['away_score']; ?></span>
          <span class="team-score"><?php echo (int)$g['home_score']; ?></span>
        </div>
        <?php endif; ?>
      </div>

      <div class="game-location">
        <?php if(!empty($g['location'])): ?>
          <span class="location-name"><?php echo sanitize($g['location']); ?></span>
        <?php endif; ?>
      </div>
        
        <div class="game-status">
          <?php 
          $status_class = 'status-scheduled';
          if(strtolower($g['status']) === 'live') $status_class = 'status-live';
          if(strtolower($g['status']) === 'completed') $status_class = 'status-final';
          ?>
          <span class="status-badge <?php echo $status_class; ?>">
            <?php echo strtoupper(sanitize($g['status'])); ?>
          </span>
        </div>

        <div class="game-actions">
          <?php if($g['status'] === 'Completed' && !empty($g['highlight_url'])): ?>
            <a href="<?php echo sanitize($g['highlight_url']); ?>" target="_blank" class="btn-action">HIGHLIGHT</a>
          <?php endif; ?>
          <a href="https://ticqet.rw" target="_blank" class="btn-action btn-tickets">TICKETS</a>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endforeach; ?>

  <?php if(empty($games_by_date)): ?>
    <div class="card">
      <p style="text-align: center; padding: 40px; color: #999;">No games found matching your filters.</p>
    </div>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>