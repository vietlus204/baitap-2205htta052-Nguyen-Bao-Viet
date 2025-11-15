<?php
// DEBUG
// var_dump($_SERVER['REQUEST_METHOD'], $_POST);
// die;

require 'config.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $errors[] = "Nhập username và mật khẩu.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :u");
        $stmt->execute([':u' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['PASSWORD'])) {
            $_SESSION['user_id']  = $user['id'];
            $_SESSION['username'] = $user['username'];

            header('Location: index.php');
            exit;
        } else {
            $errors[] = "Sai username hoặc mật khẩu.";
        }
    }
}

$pageTitle = "Đăng nhập";
require 'partials/header.php';
?>



<div class="row justify-content-center">
  <div class="col-md-5">
    <h2 class="mb-3">Đăng nhập</h2>

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
        <label class="form-label">Mật khẩu</label>
        <input name="password" type="password" class="form-control" required>
      </div>
      <button class="btn btn-primary">Đăng nhập</button>
      <a href="register.php" class="btn btn-link">Chưa có tài khoản? Đăng ký</a>
    </form>
  </div>
</div>

<?php require 'partials/footer.php'; ?>
