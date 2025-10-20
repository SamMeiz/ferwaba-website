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
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
