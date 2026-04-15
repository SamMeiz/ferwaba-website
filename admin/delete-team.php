<?php
require_once __DIR__ . '/../includes/bootstrap.php';
require_login();

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
  die('Invalid request');
}
$id = (int) $_GET['id'];

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

redirect('teams.php');
?>
