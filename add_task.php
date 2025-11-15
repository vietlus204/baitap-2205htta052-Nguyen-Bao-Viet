<?php
require 'config.php';
require 'auth_check.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title       = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $due_date    = $_POST['datetime-local'] ?? null;

    if ($title !== '') {
        $stmt = $pdo->prepare(
            "INSERT INTO tasks (user_id, title, description, due_date) 
             VALUES (:uid, :t, :d, :due)"
        );
        $stmt->execute([
            ':uid' => $_SESSION['user_id'],
            ':t'   => $title,
            ':d'   => $description ?: null,
            ':due' => $due_date ?: null
        ]);
    }
}

header('Location: index.php');
exit;
