<?php
require 'config.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    if ($username === '' || $password === '' || $confirm === '') {
        $errors[] = "Vui lòng nhập đủ username và mật khẩu.";
    }
    if ($password !== $confirm) {
        $errors[] = "Mật khẩu nhập lại không khớp.";
    }

    if (empty($errors)) {  
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :u OR email = :e");
        $stmt->execute([':u' => $username, ':e' => $email]);
        if ($stmt->fetch()) {
            $errors[] = "Username hoặc email đã tồn tại.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password, email) 
                                   VALUES (:u, :p, :e)");
            $stmt->execute([
                ':u' => $username,
                ':p' => $hash,
                ':e' => $email ?: null
            ]);
            header('Location: login.php');
            exit;
        }
    }
}

$pageTitle = "Đăng ký";
require 'partials/header.php';
?>

<div class="row justify-content-center">
  <div class="col-md-5">
    <h2 class="mb-3">Đăng ký</h2>

    <?php if ($errors): ?>
      <div class="alert alert-danger">
        <?php foreach ($errors as $err): ?>
          <div><?= htmlspecialchars($err) ?></div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <form method="post">
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input name="username" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Email (tùy chọn)</label>
        <input name="email" type="email" class="form-control">
      </div>
      <div class="mb-3">
        <label class="form-label">Mật khẩu</label>
        <input name="password" type="password" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Nhập lại mật khẩu</label>
        <input name="confirm_password" type="password" class="form-control" required>
      </div>
      <button class="btn btn-primary">Đăng ký</button>
      <a href="login.php" class="btn btn-link">Đã có tài khoản? Đăng nhập</a>
    </form>
  </div>
</div>

<?php require 'partials/footer.php'; ?>
