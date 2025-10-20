<?php
require_once __DIR__ . '/../includes/config.php';
require_login();

$stats = $mysqli->query("
  SELECT ps.*, p.name AS player_name 
  FROM player_stats ps
  JOIN players p ON ps.player_id = p.id
  ORDER BY p.name ASC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="../css/style.css">
</head>
<a href="dashboard.php" class="btn">⬅️ Back</a>
<section class="section-title">
  <h2>Player Statistics</h2>
  <a href="stats-form.php" class="btn">➕ Add Stats</a>
</section>

<div class="card">
  <table>
    <thead>
      <tr>
        <th>Player</th>
        <th>GP</th>
        <th>PPG</th>
        <th>RPG</th>
        <th>APG</th>
        <th>SPG</th>
        <th>BPG</th>
        <th>FG%</th>
        <th>3P%</th>
        <th>FT%</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while($s = $stats->fetch_assoc()): 
        $gp = max(1, $s['games_played']);
        $ppg = round($s['total_points'] / $gp, 1);
        $rpg = round($s['total_rebounds'] / $gp, 1);
        $apg = round($s['total_assists'] / $gp, 1);
        $spg = round($s['total_steals'] / $gp, 1);
        $bpg = round($s['total_blocks'] / $gp, 1);
        $fgp = $s['fg_attempted'] > 0 ? round(($s['fg_made'] / $s['fg_attempted']) * 100, 1) : 0;
        $tp  = $s['three_attempted'] > 0 ? round(($s['three_made'] / $s['three_attempted']) * 100, 1) : 0;
        $ftp = $s['ft_attempted'] > 0 ? round(($s['ft_made'] / $s['ft_attempted']) * 100, 1) : 0;
      ?>
      <tr>
        <td><?php echo sanitize($s['player_name']); ?></td>
        <td><?php echo $s['games_played']; ?></td>
        <td><?php echo $ppg; ?></td>
        <td><?php echo $rpg; ?></td>
        <td><?php echo $apg; ?></td>
        <td><?php echo $spg; ?></td>
        <td><?php echo $bpg; ?></td>
        <td><?php echo $fgp; ?>%</td>
        <td><?php echo $tp; ?>%</td>
        <td><?php echo $ftp; ?>%</td>
        <td>
          <a href="stats-form.php?id=<?php echo $s['id']; ?>" class="btn-small">✏️ Edit</a>
          <a href="delete.php?type=stats&id=<?php echo $s['id']; ?>" class="btn-small danger" onclick="return confirm('Delete this record?')">🗑️ Delete</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>


