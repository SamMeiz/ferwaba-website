<?php require_once __DIR__ . '/../includes/config.php';
require_login();

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
  die('Invalid request');
}
$id = (int)$_GET['id'];

// Set players/coaches team_id to NULL before delete to satisfy FK
$stmt = $mysqli->prepare("UPDATE players SET team_id=NULL WHERE team_id=?");
$stmt->bind_param('i',$id);
$stmt->execute();
$stmt = $mysqli->prepare("UPDATE coaches SET team_id=NULL WHERE team_id=?");
$stmt->bind_param('i',$id);
$stmt->execute();

$stmt = $mysqli->prepare("DELETE FROM teams WHERE id=? LIMIT 1");
$stmt->bind_param('i',$id);
$stmt->execute();
redirect('teams.php');


