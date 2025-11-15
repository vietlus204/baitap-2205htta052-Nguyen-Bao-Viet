<?php
require 'config.php';
require 'auth_check.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = :id AND user_id = :uid");
    $stmt->execute([
        ':id'  => $id,
        ':uid' => $_SESSION['user_id']
    ]);
}

header('Location: index.php');
exit;
