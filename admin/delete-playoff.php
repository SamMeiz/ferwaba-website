<?php require_once __DIR__ . '/../includes/bootstrap.php';
require_login();

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    die('Invalid request');
}
$id = (int) $_GET['id'];

try {
    $stmt = $db->prepare("SELECT stage FROM playoffs WHERE id=? LIMIT 1");
    $stmt->execute([$id]);
    $bracket = $stmt->fetch();

    if ($bracket) {
        $stage = $bracket['stage'];
        $del = $db->prepare("DELETE FROM playoffs WHERE id=? LIMIT 1");
        $del->execute([$id]);
        audit_log($db, 'Delete Playoff', "Deleted playoff bracket ID: $id ($stage)");
    }
} catch (PDOException $e) {
    error_log("Delete Playoff Error: " . $e->getMessage());
}

redirect('playoffs.php');
