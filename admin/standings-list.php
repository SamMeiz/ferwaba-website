<?php 
  require_once __DIR__ . '/../includes/config.php';
?>
<head>
<link rel="stylesheet" href="../css/style.css">
</head>
<a href="standings-form.php" class="btn">➕ Add Team Standing</a>
<div class="card">
  <table>
    <thead>
      <tr>
        <th>Team</th>
        <th>Division</th>
        <th>Gender</th>
        <th>GP</th>
        <th>W</th>
        <th>L</th>
        <th>Pts</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $res = $mysqli->query("SELECT s.*, t.name FROM standings s JOIN teams t ON t.id = s.team_id ORDER BY s.division, s.gender, s.points DESC");
      while($row = $res->fetch_assoc()):
      ?>
      <tr>
        <td><?php echo sanitize($row['name']); ?></td>
        <td><?php echo sanitize($row['division']); ?></td>
        <td><?php echo sanitize($row['gender']); ?></td>
        <td><?php echo (int)$row['games_played']; ?></td>
        <td><?php echo (int)$row['wins']; ?></td>
        <td><?php echo (int)$row['losses']; ?></td>
        <td><?php echo (int)$row['points']; ?></td>
        <td>
          <a href="standings-form.php?id=<?php echo $row['id']; ?>" class="btn-small">✏️ Edit</a>
          <a href="delete.php?type=standings&id=<?php echo $row['id']; ?>" class="btn-small danger" onclick="return confirm('Delete this record?')">🗑️ Delete</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>


