<?php require_once __DIR__ . '/includes/header.php'; ?>

<section class="section-title">
  <h2>Standings</h2>
  <form method="get" class="grid col-2" style="gap:8px;max-width:520px">
    <select name="division">
      <option value="Division 1" <?php echo (($_GET['division'] ?? '')!=='Division 2')?'selected':''; ?>>Division 1</option>
      <option value="Division 2" <?php echo (($_GET['division'] ?? '')==='Division 2')?'selected':''; ?>>Division 2</option>
    </select>
    <select name="gender">
      <option value="Men" <?php echo (($_GET['gender'] ?? '')!=='Women')?'selected':''; ?>>Men</option>
      <option value="Women" <?php echo (($_GET['gender'] ?? '')==='Women')?'selected':''; ?>>Women</option>
    </select>
    <button class="btn" type="submit">Apply</button>
  </form>
</section>

<?php
$division = ($_GET['division'] ?? 'Division 1') === 'Division 2' ? 'Division 2' : 'Division 1';
$gender = ($_GET['gender'] ?? 'Men') === 'Women' ? 'Women' : 'Men';

// Fetch standings for selected division & gender
$stmt = $mysqli->prepare("
  SELECT s.*, t.name, t.logo, t.id AS team_id
  FROM standings s 
  JOIN teams t ON t.id = s.team_id 
  WHERE s.division=? AND s.gender=? 
  ORDER BY s.points DESC, s.wins DESC, t.name ASC
");
$stmt->bind_param('ss', $division, $gender);
$stmt->execute();
$res = $stmt->get_result();

// Get leader stats for GB calculation
$leader = $res->fetch_assoc();
$leader_wins = $leader['wins'] ?? 0;
$leader_losses = $leader['losses'] ?? 0;
$res->data_seek(0);
?>

<div class="card">
  <table>
    <thead>
      <tr>
        <th>Team</th>
        <th>GP</th>
        <th>W</th>
        <th>L</th>
        <th>Pts</th>
        <th>Win%</th>
        <th>GB</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $res->fetch_assoc()):
        $gp = max(1, $row['games_played']);
        $win_pct = round(($row['wins'] / $gp) * 100, 1);
        $gb = round((($leader_wins - $row['wins']) + ($row['losses'] - $leader_losses)) / 2, 1);
      ?>
      <tr>
        <td>
  <a href="team.php?id=<?php echo $row['team_id']; ?>" 
     style="color:#0077cc;text-decoration:none;display:inline-flex;align-items:center;gap:8px;">
    <?php if (!empty($row['logo'])): ?>
      <img src="admin/uploads/<?php echo sanitize($row['logo']); ?>" 
           alt="<?php echo sanitize($row['name']); ?> Logo" 
           style="width:28px;height:28px;object-fit:cover;border-radius:6px;">
    <?php endif; ?>
    <span style="font-weight:600;"><?php echo sanitize($row['name']); ?></span>
  </a>
</td>



        </td>
        <td><?php echo (int)$row['games_played']; ?></td>
        <td><?php echo (int)$row['wins']; ?></td>
        <td><?php echo (int)$row['losses']; ?></td>
        <td><?php echo (int)$row['points']; ?></td>
        <td><?php echo $win_pct; ?>%</td>
        <td><?php echo $gb; ?></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
