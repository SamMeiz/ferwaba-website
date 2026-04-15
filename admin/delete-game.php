<?php require_once __DIR__ . '/../includes/bootstrap.php';
require_login();

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
  die('Invalid request');
}
$id = (int) $_GET['id'];

try {
  // Get division/gender context
  $stmt = $db->prepare("SELECT division, gender FROM games WHERE id=? LIMIT 1");
  $stmt->execute([$id]);
  $row = $stmt->fetch();

  if ($row) {
    $division = $row['division'];
    $gender = $row['gender'];

    $del = $db->prepare("DELETE FROM games WHERE id=? LIMIT 1");
    $del->execute([$id]);

    audit_log($db, 'Delete Game', "Deleted game ID: $id ($division $gender)");

    // Recalc standings for this division/gender
    $anyStmt = $db->prepare("SELECT id FROM games WHERE division=? AND gender=? ORDER BY id DESC LIMIT 1");
    $anyStmt->execute([$division, $gender]);
    $any = $anyStmt->fetch();

    if ($any) {
      recalc_standings_for_game_change($db, (int) $any['id']);
    } else {
      // If no games left, reset standings to zero for teams in that context
      $upd = $db->prepare("UPDATE standings SET games_played=0, wins=0, losses=0, points=0 WHERE division=? AND gender=?");
      $upd->execute([$division, $gender]);
    }
  }
} catch (PDOException $e) {
  error_log("Delete Game Error: " . $e->getMessage());
  die("An error occurred during deletion.");
}

redirect('games.php');
