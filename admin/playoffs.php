<?php 
require_once __DIR__ . '/../includes/config.php';
require_login();

$rows = $mysqli->query("
    SELECT p.*, 
           th.name AS home_name, 
           ta.name AS away_name, 
           tw.name AS winner_name 
    FROM playoffs p 
    LEFT JOIN teams th ON th.id=p.home_team_id 
    LEFT JOIN teams ta ON ta.id=p.away_team_id 
    LEFT JOIN teams tw ON tw.id=p.winner_team_id 
    ORDER BY FIELD(p.stage,'Quarterfinal','Semifinal','Final','3rd Place'), p.start_date ASC, p.id ASC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Playoffs - FERWABA</title>
<link rel="stylesheet" href="<?php echo asset_url('../css/style.css'); ?>">
<style>
    body { background:#f9fafb; font-family:Arial,sans-serif; }
    .container { max-width:1200px; margin:24px auto; }
    .section-title { display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; flex-wrap:wrap; }
    .section-title h2 { margin:0; font-size:1.8rem; }
    .section-title .btn { padding:6px 14px; border-radius:6px; text-decoration:none; color:#fff; background:#2563eb; font-size:0.9rem; margin-top:4px; }
    .section-title .btn:hover { opacity:0.85; }
    .card { background:#fff; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.05); padding:16px; overflow-x:auto; }
    table { width:100%; border-collapse:collapse; }
    th, td { padding:10px 12px; text-align:left; border-bottom:1px solid #e5e7eb; }
    th { background:#f3f4f6; font-weight:600; }
    tr:hover { background:#f9fafb; }
    td a { color:#2563eb; text-decoration:none; margin-right:8px; font-size:0.9rem; }
    td a:hover { text-decoration:underline; }
</style>
</head>
<body>
<div class="container">
    <div class="section-title">
        <h2>Playoffs</h2>
        <div>
            <a class="btn" href="playoff-form.php">Add Matchup</a>
            <a class="btn" href="javascript:history.back()" style="background:#6b7280;">⬅️ Back</a>
        </div>
    </div>

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Stage</th>
                    <th>Dates</th>
                    <th>Matchup</th>
                    <th>Status</th>
                    <th>Score</th>
                    <th>Winner</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($p=$rows->fetch_assoc()): ?>
                <tr>
                    <td><?php echo sanitize($p['stage']); ?></td>
                    <td><?php echo sanitize($p['start_date'].' to '.$p['end_date']); ?></td>
                    <td><?php echo sanitize(($p['home_name']??'TBD').' vs '.($p['away_name']??'TBD')); ?></td>
                    <td><?php echo sanitize($p['status']); ?></td>
                    <td><?php echo (int)$p['home_score'].' - '.(int)$p['away_score']; ?></td>
                    <td><?php echo sanitize($p['winner_name'] ?? ''); ?></td>
                    <td>
                        <a href="playoff-form.php?id=<?php echo (int)$p['id']; ?>">Edit</a>
                        <a href="delete-playoff.php?id=<?php echo (int)$p['id']; ?>" onclick="return confirm('Delete matchup?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
