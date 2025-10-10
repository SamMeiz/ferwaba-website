<?php require_once __DIR__ . '/../includes/config.php';
require_login();

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) { die('Invalid request'); }
$id = (int)$_GET['id'];

// Get division/gender context
$ctx = $mysqli->query("SELECT division,gender FROM games WHERE id=$id LIMIT 1");
if ($ctx && $row = $ctx->fetch_assoc()) {
  $stmt = $mysqli->prepare("DELETE FROM games WHERE id=? LIMIT 1");
  $stmt->bind_param('i',$id);
  $stmt->execute();
  // Recalc standings for this division/gender (pick any remaining game id in same div/gender)
  $any = $mysqli->query("SELECT id FROM games WHERE division='".$mysqli->real_escape_string($row['division'])."' AND gender='".$mysqli->real_escape_string($row['gender'])."' ORDER BY id DESC LIMIT 1");
  if ($any && $any->num_rows) {
    $gm = $any->fetch_assoc();
    recalc_standings_for_game_change($mysqli, (int)$gm['id']);
  } else {
    // If no games left, reset standings to zero for teams in that context
    $division = $mysqli->real_escape_string($row['division']);
    $gender = $mysqli->real_escape_string($row['gender']);
    $mysqli->query("UPDATE standings SET games_played=0,wins=0,losses=0,points=0 WHERE division='$division' AND gender='$gender'");
  }
}
redirect('/admin/games.php');


