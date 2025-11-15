<?php
if (!isset($pageTitle)) $pageTitle = "To-Do App";
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($pageTitle) ?></title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background: #15191e;
      color: #e5e5e5;
      font-family: 'Segoe UI', sans-serif;
    }

  
    .task-card {
      background: #1e2329;
      padding: 18px;
      border-radius: 12px;
      border: 1px solid #2c3137;
      box-shadow: 0 2px 10px #00000033;
      transition: 0.25s;
    }
    .task-card:hover {
      transform: translateY(-3px);
      background: #252b32;
    }

    .task-date {
      color: #b7b7b7;
      font-size: 0.9rem;
    }

    .floating-form {
      position: fixed;
      right: 25px;
      top: 120px;
      width: 320px;
      background: #1e2329;
      padding: 20px;
      border-radius: 14px;
      box-shadow: 0 4px 20px #00000055;
      border: 1px solid #2c2f33;
      z-index: 999;
    }
  </style>
</head>

<body>

<nav class="navbar navbar-dark px-4 py-3">
  <span class="navbar-brand fw-semibold">📝 To-Do Cards</span>

  <div>
    <a href="index.php" class="btn btn-outline-light btn-sm me-2">Trang chủ</a>
    <a href="logout.php" class="btn btn-danger btn-sm">Đăng xuất</a>
  </div>
</nav>

<div class="container py-4">
