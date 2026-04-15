<?php require_once __DIR__ . '/../includes/bootstrap.php';
require_login();

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    die('Invalid request');
}
$id = (int) $_GET['id'];

try {
    $stmt = $db->prepare("SELECT name FROM players WHERE id=? LIMIT 1");
    $stmt->execute([$id]);
    $player = $stmt->fetch();

    if ($player) {
        $name = $player['name'];
        $del = $db->prepare("DELETE FROM players WHERE id=? LIMIT 1");
        $del->execute([$id]);
        audit_log($db, 'Delete Player', "Deleted player: $name (ID: $id)");
    }
} catch (PDOException $e) {
    error_log("Delete Player Error: " . $e->getMessage());
}

redirect('players.php');
?>