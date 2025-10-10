<?php require_once __DIR__ . '/includes/header.php'; ?>

<section class="section-title">
  <h2>Games</h2>
  <form method="get" class="grid col-3" style="gap:8px">
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
    <input type="date" name="from" value="<?php echo sanitize($_GET['from'] ?? ''); ?>">
    <input type="date" name="to" value="<?php echo sanitize($_GET['to'] ?? ''); ?>">
    <button class="btn" type="submit">Apply</button>
  </form>
</section>

<a id="schedule"></a>
<div class="card">
  <table>
    <thead><tr><th>Date</th><th>Match</th><th>Division</th><th>Gender</th><th>Status</th><th>Score</th><th>Highlight</th></tr></thead>
    <tbody>
      <?php
      $where=[];$types='';$params=[];
      if (!empty($_GET['division'])) { $where[]='g.division=?'; $types.='s'; $params[]=$_GET['division']; }
      if (!empty($_GET['gender'])) { $where[]='g.gender=?'; $types.='s'; $params[]=$_GET['gender']; }
      if (!empty($_GET['from'])) { $where[]='g.game_date>=?'; $types.='s'; $params[]=$_GET['from']; }
      if (!empty($_GET['to'])) { $where[]='g.game_date<=?'; $types.='s'; $params[]=$_GET['to']; }
      $sql = "SELECT g.*, th.name AS home_name, ta.name AS away_name FROM games g JOIN teams th ON th.id=g.home_team_id JOIN teams ta ON ta.id=g.away_team_id";
      if ($where) { $sql .= ' WHERE '.implode(' AND ',$where); }
      $sql .= ' ORDER BY g.game_date DESC, g.id DESC';
      $stmt = $mysqli->prepare($sql);
      if ($where) { $stmt->bind_param($types, ...$params); }
      $stmt->execute();
      $res = $stmt->get_result();
      while($g=$res->fetch_assoc()): ?>
      <tr>
        <td><?php echo sanitize($g['game_date']); ?></td>
        <td><?php echo sanitize($g['home_name'].' vs '.$g['away_name']); ?></td>
        <td><?php echo sanitize($g['division']); ?></td>
        <td><?php echo sanitize($g['gender']); ?></td>
        <td><?php echo sanitize($g['status']); ?></td>
        <td><?php echo (int)$g['home_score'].' - '.(int)$g['away_score']; ?></td>
        <td>
          <?php if($g['highlight_url']): ?>
            <a href="<?php echo sanitize($g['highlight_url']); ?>" target="_blank">Watch</a>
          <?php endif; ?>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  </div>

<a id="results"></a>

<?php require_once __DIR__ . '/includes/footer.php'; ?>


