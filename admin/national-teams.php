<?php
require_once __DIR__ . '/../includes/config.php';
require_login();

// Fetch national teams ordered by category and creation date
$result = $mysqli->query("SELECT * FROM national_teams ORDER BY category, created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>National Teams - FERWABA</title>
  <link rel="stylesheet" href="<?php echo asset_url('../css/admin.css'); ?>">
</head>
<body>
<div class="container">
  <div class="section-title">
    <h2>National Teams</h2>
    <div>
      <a href="dashboard.php" class="btn btn-secondary">Back</a>
      <a class="btn" href="national-team-form.php">Add New Team</a>
    </div>
  </div>

  <div class="card">
    <div class="table-wrapper">
      <table>
        <thead>
          <tr>
            <th>Banner</th>
            <th>Team Name</th>
            <th>Category</th>
            <th>Created</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result->num_rows > 0): ?>
            <?php while($t = $result->fetch_assoc()): ?>
              <tr>
                <td>
                  <?php if (!empty($t['banner_image'])): ?>
                    <img src="/ferwaba1/admin/uploads/<?php echo sanitize($t['banner_image']); ?>" style="width:50px;height:50px;object-fit:cover;border-radius:6px;">
                  <?php else: ?>
                    <span class="muted">—</span>
                  <?php endif; ?>
                </td>
                <td><?php echo sanitize($t['team_name']); ?></td>
                <td><?php echo sanitize($t['category']); ?></td>
                <td><?php echo date('Y-m-d', strtotime($t['created_at'])); ?></td>
                <td class="table-actions">
                  <a href="national-team-form.php?id=<?php echo (int)$t['id']; ?>">Edit</a>
                  <a href="national-players.php?team_id=<?php echo (int)$t['id']; ?>">Manage Players</a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="5" style="text-align:center;padding:40px;color:#6b7280;">
                No national teams found. <a href="national-team-form.php">Add a team</a> to get started.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
