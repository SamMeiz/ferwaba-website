<?php
require_once __DIR__ . '/../includes/bootstrap.php';
require_login();

$id = isset($_GET['id']) && ctype_digit($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id > 0) {
    try {
        $stmt = $db->prepare("SELECT team_id FROM standings WHERE id=? LIMIT 1");
        $stmt->execute([$id]);
        $standing = $stmt->fetch();

        if ($standing) {
            $teamId = $standing['team_id'];
            $del = $db->prepare("DELETE FROM standings WHERE id=? LIMIT 1");
            $del->execute([$id]);
            audit_log($db, 'Delete Standing', "Deleted standing entry ID: $id for team ID: $teamId");
        }
    } catch (PDOException $e) {
        error_log("Delete Standing Error: " . $e->getMessage());
    }
}

redirect('standings-list.php');
?>