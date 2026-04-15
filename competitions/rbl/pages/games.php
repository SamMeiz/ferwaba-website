<?php require_once __DIR__ . '/../includes/header.php'; ?>

<style>
/* Professional Games Schedule */
.page-header {
  background: linear-gradient(135deg, #1a365d 0%, #2c5282 100%);
  padding: 60px 40px;
  margin: -20px -16px 40px -16px;
  border-radius: 0 0 24px 24px;
}
.page-header h1 {
  font-size: 42px;
  font-weight: 800;
  color: #fff;
  margin: 0 0 8px 0;
}
.page-header p {
  color: rgba(255,255,255,0.8);
  font-size: 16px;
  margin: 0;
}

.filters-container {
  background: #fff;
  padding: 24px;
  border-radius: 16px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.08);
  margin-bottom: 32px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 16px;
}

.games-filter {
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
  align-items: center;
}

.games-filter select,
.games-filter input[type="date"] {
  padding: 12px 16px;
  border: 2px solid #e5e7eb;
  border-radius: 10px;
  background: #fff;
  font-size: 14px;
  font-weight: 500;
  color: #1a365d;
  transition: all 0.2s ease;
  cursor: pointer;
}

.games-filter select:hover,
.games-filter input[type="date"]:hover {
  border-color: #1a365d;
}

.games-filter select:focus,
.games-filter input[type="date"]:focus {
  outline: none;
  border-color: #fbbf24;
  box-shadow: 0 0 0 3px rgba(251,191,36,0.2);
}

.filter-btn {
  background: linear-gradient(135deg, #1a365d 0%, #2c5282 100%);
  color: #fff;
  border: none;
  padding: 12px 24px;
  border-radius: 10px;
  font-weight: 600;
  font-size: 14px;
  cursor: pointer;
  transition: all 0.3s ease;
}

.filter-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(26,54,93,0.3);
}

.toggle-label {
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 14px;
  font-weight: 500;
  color: #4b5563;
  cursor: pointer;
}

.toggle-switch {
  position: relative;
  width: 48px;
  height: 26px;
  background: #e5e7eb;
  border-radius: 13px;
  cursor: pointer;
  transition: background 0.3s ease;
}

.toggle-switch:has(input:checked) {
  background: #1a365d;
}

.toggle-switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.toggle-switch::after {
  content: '';
  position: absolute;
  top: 3px;
  left: 3px;
  width: 20px;
  height: 20px;
  background: #fff;
  border-radius: 50%;
  transition: transform 0.3s ease;
  box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.toggle-switch:has(input:checked)::after {
  transform: translateX(22px);
}

.games-schedule {
  max-width: 100%;
}

.date-section {
  margin-bottom: 24px;
  background: #fff;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 4px 16px rgba(0,0,0,0.06);
}

.date-header {
  background: linear-gradient(90deg, #f8fafc 0%, #f1f5f9 100%);
  padding: 16px 24px;
  border-bottom: 2px solid #e5e7eb;
  font-weight: 700;
  font-size: 14px;
  color: #1a365d;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.date-header i {
  color: #fbbf24;
  margin-right: 10px;
}

.game-count {
  background: #1a365d;
  color: #fff;
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 600;
}

.game-row {
  display: grid;
  grid-template-columns: 100px 1fr 150px 120px auto;
  align-items: center;
  gap: 20px;
  padding: 20px 24px;
  border-bottom: 1px solid #f1f5f9;
  transition: background 0.2s ease;
}

.game-row:last-child {
  border-bottom: none;
}

.game-row:hover {
  background: #f8fafc;
}

.game-time {
  display: flex;
  flex-direction: column;
}

.time-main {
  font-weight: 700;
  font-size: 15px;
  color: #1a365d;
}

.division-badge {
  font-size: 11px;
  color: #64748b;
  margin-top: 4px;
}

.game-matchup {
  display: flex;
  align-items: center;
  gap: 16px;
}

.teams-wrapper {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.team-row {
  display: flex;
  align-items: center;
  gap: 10px;
}

.team-name {
  font-weight: 600;
  font-size: 15px;
  color: #1a1a1a;
}

.team-badge {
  padding: 3px 8px;
  background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
  border-radius: 4px;
  font-size: 10px;
  font-weight: 700;
  color: #1a365d;
  text-transform: uppercase;
}

.score-wrapper {
  display: flex;
  flex-direction: column;
  gap: 8px;
  text-align: center;
}

.team-score {
  font-size: 22px;
  font-weight: 800;
  color: #1a365d;
}

.game-location {
  display: flex;
  align-items: center;
  gap: 8px;
  color: #64748b;
  font-size: 13px;
}

.game-location i {
  color: #1a365d;
}

.status-badge {
  padding: 8px 16px;
  border-radius: 8px;
  font-size: 12px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.status-scheduled {
  background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
  color: #1e40af;
}

.status-live {
  background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
  color: #dc2626;
  animation: pulse 2s infinite;
}

@keyframes pulse {
  0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.7); }
  70% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(220, 38, 38, 0); }
  100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 38, 38, 0); }
}

.status-final {
  background: #f1f5f9;
  color: #64748b;
}

.game-actions {
  display: flex;
  gap: 8px;
}

.btn-tickets {
  background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
  color: #1a365d;
  padding: 10px 20px;
  border-radius: 8px;
  font-weight: 700;
  font-size: 12px;
  text-decoration: none;
  transition: all 0.3s ease;
  text-transform: uppercase;
  display: inline-flex;
  align-items: center;
  gap: 6px;
}

.btn-tickets:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(251,191,36,0.4);
}

.btn-live {
  background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
  color: #fff;
  padding: 10px 20px;
  border-radius: 8px;
  font-weight: 700;
  font-size: 12px;
  text-decoration: none;
  transition: all 0.3s ease;
  text-transform: uppercase;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  animation: pulse 2s infinite;
  box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
  border: 2px solid #fff;
}

.btn-live:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(239,68,68,0.6);
  color: #fff;
}

.btn-highlights {
  background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
  color: #fff;
  padding: 10px 20px;
  border-radius: 8px;
  font-weight: 700;
  font-size: 12px;
  text-decoration: none;
  transition: all 0.3s ease;
  text-transform: uppercase;
  display: inline-flex;
  align-items: center;
  gap: 6px;
}

.btn-highlights:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(59,130,246,0.4);
}

.empty-state {
  text-align: center;
  padding: 80px 40px;
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 4px 16px rgba(0,0,0,0.06);
}

.empty-state i {
  font-size: 64px;
  color: #e5e7eb;
  margin-bottom: 20px;
}

.empty-state h3 {
  font-size: 24px;
  color: #1a365d;
  margin-bottom: 8px;
}

.empty-state p {
  color: #64748b;
  font-size: 16px;
}

@media (max-width: 1024px) {
  .game-row {
    grid-template-columns: 1fr;
    gap: 16px;
    text-align: center;
    padding: 16px;
  }
  .game-matchup {
    justify-content: center;
  }
  .game-location {
    justify-content: center;
  }
  .game-actions {
    justify-content: center;
  }
  .score-wrapper {
    text-align: center;
  }
}

@media (max-width: 768px) {
  .page-header {
    padding: 40px 20px;
    margin: -20px -16px 30px -16px;
  }
  .page-header h1 {
    font-size: 28px;
  }
  .filters-container {
    padding: 16px;
  }
  .games-filter {
    width: 100%;
  }
  .games-filter select,
  .games-filter input[type="date"] {
    flex: 1;
    min-width: 120px;
  }
  
  /* Better mobile visibility - centered */
  .date-section {
    margin-left: 0;
    margin-right: 0;
    border-radius: 12px;
  }
  
  .game-row {
    padding: 16px 12px;
  }
  
  .team-name {
    font-size: 14px;
  }
  
  .team-score {
    font-size: 18px;
  }
  
  .game-time {
    border-bottom: 1px solid #f1f5f9;
    padding-bottom: 8px;
    margin-bottom: 8px;
  }
  
  .teams-wrapper {
    align-items: center;
  }
  
  .team-row {
    justify-content: center;
  }
}
</style>

<div class="page-header">
  <h1><i class="fas fa-calendar-alt"></i> Games Schedule</h1>
  <p>Follow all Rwanda Basketball League matches and results</p>
</div>

<div class="filters-container">
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
    <button class="filter-btn" type="submit"><i class="fas fa-filter"></i> Apply Filters</button>
  </form>
  
  <label class="toggle-label">
    <span>Hide Completed</span>
    <div class="toggle-switch">
      <input type="checkbox" id="hideCompletedToggle" <?php echo ($_GET['hide_completed'] ?? '1') === '1' ? 'checked' : ''; ?> 
             onchange="toggleCompleted(this)">
    </div>
  </label>
</div>

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
    $formatted_date = $date_obj->format('F j, Y');
  ?>
  <div class="date-section">
    <div class="date-header">
      <span><i class="fas fa-calendar-day"></i> <?php echo $day_name . ', ' . $formatted_date; ?></span>
      <span class="game-count"><?php echo count($games); ?> Games</span>
    </div>
    
    <?php foreach($games as $g): ?>
    <div class="game-row">
      <div class="game-time">
        <span class="time-main">
          <?php 
          if(!empty($g['game_time'])) {
            echo date('g:i A', strtotime($g['game_time']));
          } else {
            echo 'TBD';
          }
          ?>
        </span>
        <span class="division-badge"><?php echo sanitize($g['division']); ?></span>
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
          <i class="fas fa-map-marker-alt"></i>
          <span><?php echo sanitize($g['location']); ?></span>
        <?php endif; ?>
      </div>

      <?php
      $current_time = time();
      $is_game_time = false;
      if(!empty($g['game_date']) && !empty($g['game_time'])) {
          $game_ts = strtotime($g['game_date'] . ' ' . $g['game_time']);
          if($game_ts && $current_time >= $game_ts) $is_game_time = true;
      }

      $status_raw = trim((string)($g['status'] ?? ''));
      $status_lower = strtolower($status_raw);
      $live_link_value = trim((string)($g['live_link'] ?? ''));
      $highlight_link_value = trim((string)($g['highlight_url'] ?? ''));
      $has_live_link = $live_link_value !== '' && strtolower($live_link_value) !== 'n/a';
      $has_highlight_link = $highlight_link_value !== '' && strtolower($highlight_link_value) !== 'n/a';

      $is_completed_status = in_array($status_lower, ['completed', 'final', 'finished'], true);
      $is_live_status = in_array($status_lower, ['live', 'ongoing', 'in progress', 'in_progress'], true);
      if(!$is_completed_status && !$is_live_status && $has_live_link && $is_game_time) {
          $is_live_status = true;
      }

      $status_class = 'status-scheduled';
      $status_label = $status_raw !== '' ? strtoupper($status_raw) : 'SCHEDULED';
      if($is_live_status) {
          $status_class = 'status-live';
          $status_label = 'LIVE';
      } elseif($is_completed_status) {
          $status_class = 'status-final';
          $status_label = 'COMPLETED';
      }

      $show_live = $has_live_link && ($is_live_status || (!$is_completed_status && $is_game_time));
      $show_highlights = $is_completed_status && $has_highlight_link;
      $show_tickets = !$is_completed_status && !$show_live;
      ?>
        
      <div class="game-status">
        <span class="status-badge <?php echo $status_class; ?>">
          <?php echo sanitize($status_label); ?>
        </span>
      </div>

      <div class="game-actions">
        <?php if($show_live): ?>
          <a href="<?php echo sanitize($live_link_value); ?>" target="_blank" class="btn-live"><i class="fas fa-play-circle"></i> Watch Now</a>
        <?php endif; ?>
        <?php if($show_highlights): ?>
          <a href="<?php echo sanitize($highlight_link_value); ?>" target="_blank" class="btn-highlights"><i class="fas fa-video"></i> Highlights</a>
        <?php endif; ?>
        <?php if($show_tickets): ?>
          <a href="https://ticqet.rw" target="_blank" class="btn-tickets"><i class="fas fa-ticket-alt"></i> Get Tickets</a>
        <?php endif; ?>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endforeach; ?>

  <?php if(empty($games_by_date)): ?>
    <div class="empty-state">
      <i class="fas fa-basketball-ball"></i>
      <h3>No Games Found</h3>
      <p>There are no games matching your current filters. Try adjusting your selection.</p>
    </div>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
