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
$stmt = $mysqli->prepare("SELECT s.*, t.name, t.logo FROM standings s JOIN teams t ON t.id=s.team_id WHERE s.division=? AND s.gender=? ORDER BY s.points DESC, s.wins DESC, t.name ASC");
$stmt->bind_param('ss',$division,$gender);
$stmt->execute();
$res = $stmt->get_result();
?>

<div class="card">
  <table>
    <thead><tr><th>Team</th><th>GP</th><th>W</th><th>L</th><th>Pts</th></tr></thead>
    <tbody>
      <?php while($row=$res->fetch_assoc()): ?>
      <tr>
        <td>
          <?php if($row['logo']): ?><img src="/admin/uploads/<?php echo sanitize($row['logo']); ?>" alt="logo" style="width:24px;height:24px;object-fit:cover;border-radius:6px;vertical-align:middle;margin-right:8px"><?php endif; ?>
          <?php echo sanitize($row['name']); ?>
        </td>
        <td><?php echo (int)$row['games_played']; ?></td>
        <td><?php echo (int)$row['wins']; ?></td>
        <td><?php echo (int)$row['losses']; ?></td>
        <td><?php echo (int)$row['points']; ?></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>


