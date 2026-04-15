<?php
require_once __DIR__ . '/../includes/bootstrap.php';
require_login();

// 1. ADD MISSING FUNCTION-LEVEL ACCESS CONTROL
// Only superadmins should be allowed to delete a whole team and its associated playoffs, games, standings,, and players.
require_superadmin();

// 2. REQUIRE POST INSTEAD OF GET (to fix CSRF vulnerability)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  die('Invalid request. Data deletion must be performed securely via POST.');
}

// 3. REQUIRE CSRF TOKEN
require_csrf_token();

if (!isset($_POST['id']) || !ctype_digit($_POST['id'])) {
  die('Invalid request: Missing or malformed team ID');
}
$id = (int) $_POST['id'];

try {
  $stmt = $db->prepare("SELECT name FROM teams WHERE id = ?");
  $stmt->execute([$id]);
  $team = $stmt->fetch();
  if ($team) {
    $name = $team['name'];

    $db->beginTransaction();

    $db->prepare("UPDATE players SET team_id=NULL WHERE team_id=?")->execute([$id]);
    $db->prepare("UPDATE coaches SET team_id=NULL WHERE team_id=?")->execute([$id]);
    $db->prepare("UPDATE shop_items SET team_id=NULL WHERE team_id=?")->execute([$id]);

    $db->prepare("DELETE FROM gallery WHERE team_id=?")->execute([$id]);
    $db->prepare("DELETE FROM standings WHERE team_id=?")->execute([$id]);
    $db->prepare("DELETE FROM games WHERE home_team_id=? OR away_team_id=?")->execute([$id, $id]);
    $db->prepare("DELETE FROM playoffs WHERE home_team_id=? OR away_team_id=? OR winner_team_id=?")->execute([$id, $id, $id]);

    $db->prepare("DELETE FROM teams WHERE id=? LIMIT 1")->execute([$id]);

    audit_log($db, 'Delete Team', "Deleted team: $name (ID: $id)");
    $db->commit();
  }
} catch (PDOException $e) {
  if ($db->inTransaction()) {
    $db->rollBack();
  }
  error_log("Delete Team Error: " . $e->getMessage());
  die("An error occurred during deletion.");
}

redirect('teams.php?msg=Team+deleted+successfully&type=success');
?>
