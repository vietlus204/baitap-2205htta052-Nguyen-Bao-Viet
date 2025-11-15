<?php
require 'config.php';

require 'auth_check.php';

$id     = $_GET['id'] ?? null;
$userId = $_SESSION['user_id'];

if (!$id) {
    header('Location: index.php');
    exit;
}


$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = :id AND user_id = :uid");
$stmt->execute([':id' => $id, ':uid' => $userId]);
$task = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$task) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title       = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $due_date    = $_POST['due_date'] ?? null;
    $status      = $_POST['status'] ?? 'pending';

    if ($title !== '') {
        $stmt = $pdo->prepare(
            "UPDATE tasks 
             SET title = :t, description = :d, due_date = :due, status = :st 
             WHERE id = :id AND user_id = :uid"
        );
        $stmt->execute([
            ':t'   => $title,
            ':d'   => $description ?: null,
            ':due' => $due_date ?: null,
            ':st'  => $status,
            ':id'  => $id,
            ':uid' => $userId
        ]);
    }
    header('Location: index.php');
    exit;
}

$pageTitle = "Sửa công việc";
require 'partials/header.php';
?>

<h3>Sửa công việc</h3>

<form method="post" class="col-md-6">
  <div class="mb-3">
    <label class="form-label">Tiêu đề</label>
    <input name="title" class="form-control" value="<?= htmlspecialchars($task['title']) ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Mô tả</label>
    <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($task['description']) ?></textarea>
  </div>
  <div class="mb-3">
    <label class="form-label">Ngày hết hạn</label>
    <input type="date" name="due_date" class="form-control" value="<?= htmlspecialchars($task['due_date']) ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Trạng thái</label>
    <select name="status" class="form-select">
      <option value="pending"     <?= $task['STATUS']==='pending'?'selected':'' ?>>Pending</option>
      <option value="in_progress" <?= $task['STATUS']==='in_progress'?'selected':'' ?>>In progress</option>
      <option value="completed"   <?= $task['STATUS']==='completed'?'selected':'' ?>>Completed</option>
    </select>
  </div>
  <button class="btn btn-primary">Lưu</button>
  <a href="index.php" class="btn btn-secondary">Hủy</a>
</form>

<?php require 'partials/footer.php'; ?>
