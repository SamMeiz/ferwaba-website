<?php 
require_once __DIR__ . '/includes/header.php';

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    redirect('players.php');
}

$player_id = (int)$_GET['id'];

// Fetch player info
$stmt = $mysqli->prepare("
  SELECT p.id, p.name, p.position, p.jersey_number, p.height, p.nationality, p.photo,
         t.name AS team_name, t.id AS team_id
  FROM players p
  LEFT JOIN teams t ON t.id = p.team_id
  WHERE p.id = ?
  LIMIT 1
");
$stmt->bind_param('i', $player_id);
$stmt->execute();
$player = $stmt->get_result()->fetch_assoc();

if (!$player) {
    redirect('players.php');
}

// Fetch player stats
$stmt = $mysqli->prepare("
  SELECT *
  FROM player_stats
  WHERE player_id = ?
  LIMIT 1
");
$stmt->bind_param('i', $player_id);
$stmt->execute();
$stats = $stmt->get_result()->fetch_assoc();

// Helper function to calculate percentages safely
function calc_percent($made, $attempted) {
    return $attempted > 0 ? round(($made/$attempted)*100,1) : 0;
}

// Per-game averages
$gp = max(1, (int)($stats['games_played'] ?? 0));
$ppg = round(($stats['total_points'] ?? 0)/$gp,1);
$rpg = round(($stats['total_rebounds'] ?? 0)/$gp,1);
$apg = round(($stats['total_assists'] ?? 0)/$gp,1);
$spg = round(($stats['total_steals'] ?? 0)/$gp,1);
$bpg = round(($stats['total_blocks'] ?? 0)/$gp,1);
$fg_pct = calc_percent($stats['fg_made'] ?? 0, $stats['fg_attempted'] ?? 0);
$three_pct = calc_percent($stats['three_made'] ?? 0, $stats['three_attempted'] ?? 0);
$ft_pct = calc_percent($stats['ft_made'] ?? 0, $stats['ft_attempted'] ?? 0);

?>

<section class="section-title">
  <h2><?php echo sanitize($player['name']); ?> - Player Card</h2>
</section>

<div class="card" style="max-width:700px;margin:auto;overflow:hidden">
  <img 
    src="<?php echo $player['photo'] ? 'admin/uploads/'.sanitize($player['photo']) : 'https://via.placeholder.com/600x400?text=Player'; ?>" 
    alt="<?php echo sanitize($player['name']); ?>" 
    style="width:100%;height:350px;object-fit:cover"
  >
  <div class="card-body">
    <h3>#<?php echo (int)$player['jersey_number']; ?> - <?php echo sanitize($player['name']); ?></h3>
    <p><strong>Position:</strong> <?php echo sanitize($player['position']); ?></p>
    <p><strong>Height:</strong> <?php echo sanitize($player['height']); ?></p>
    <p><strong>Nationality:</strong> <?php echo sanitize($player['nationality']); ?></p>
    <p><strong>Team:</strong> 
      <a href="team.php?id=<?php echo (int)$player['team_id']; ?>">
        <?php echo sanitize($player['team_name']); ?>
      </a>
    </p>

    <h3 style="margin-top:20px;">Statistics (Per Game)</h3>
    <table style="width:100%;border-collapse:collapse;margin-top:8px">
      <tr>
        <th style="text-align:left;padding:6px;border-bottom:1px solid #ccc">GP</th>
        <td style="padding:6px;border-bottom:1px solid #ccc"><?php echo $gp; ?></td>
      </tr>
      <tr>
        <th style="text-align:left;padding:6px;border-bottom:1px solid #ccc">PPG</th>
        <td style="padding:6px;border-bottom:1px solid #ccc"><?php echo $ppg; ?></td>
      </tr>
      <tr>
        <th style="text-align:left;padding:6px;border-bottom:1px solid #ccc">RPG</th>
        <td style="padding:6px;border-bottom:1px solid #ccc"><?php echo $rpg; ?></td>
      </tr>
      <tr>
        <th style="text-align:left;padding:6px;border-bottom:1px solid #ccc">APG</th>
        <td style="padding:6px;border-bottom:1px solid #ccc"><?php echo $apg; ?></td>
      </tr>
      <tr>
        <th style="text-align:left;padding:6px;border-bottom:1px solid #ccc">SPG</th>
        <td style="padding:6px;border-bottom:1px solid #ccc"><?php echo $spg; ?></td>
      </tr>
      <tr>
        <th style="text-align:left;padding:6px;border-bottom:1px solid #ccc">BPG</th>
        <td style="padding:6px;border-bottom:1px solid #ccc"><?php echo $bpg; ?></td>
      </tr>
      <tr>
        <th style="text-align:left;padding:6px;border-bottom:1px solid #ccc">FG%</th>
        <td style="padding:6px;border-bottom:1px solid #ccc"><?php echo $fg_pct; ?>%</td>
      </tr>
      <tr>
        <th style="text-align:left;padding:6px;border-bottom:1px solid #ccc">3P%</th>
        <td style="padding:6px;border-bottom:1px solid #ccc"><?php echo $three_pct; ?>%</td>
      </tr>
      <tr>
        <th style="text-align:left;padding:6px;border-bottom:1px solid #ccc">FT%</th>
        <td style="padding:6px;border-bottom:1px solid #ccc"><?php echo $ft_pct; ?>%</td>
      </tr>
    </table>

  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
