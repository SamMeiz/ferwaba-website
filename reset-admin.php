<?php
require_once __DIR__ . '/includes/bootstrap.php';

$email = 'admin@ferwaba.rw';
$password = 'Admin@Ferwaba2025!';
$hash = password_hash($password, PASSWORD_BCRYPT);

try {
    $stmt = $db->prepare("SELECT * FROM admins WHERE email = ?");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();

    if ($admin) {
        $update = $db->prepare("UPDATE admins SET password = ?, is_active = 1 WHERE email = ?");
        $update->execute([$hash, $email]);
        echo "Password for $email has been reset to: $password\n";
    } else {
        $insert = $db->prepare("INSERT INTO admins (full_name, email, password, role, is_active) VALUES ('Super Admin', ?, ?, 'SuperAdmin', 1)");
        $insert->execute([$email, $hash]);
        echo "Admin $email has been created with password: $password\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
