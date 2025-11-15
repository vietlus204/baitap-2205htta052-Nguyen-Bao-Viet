<?php
require 'auth_check.php';
require 'config.php';

$userId = $_SESSION['user_id'];

$statusFilter = $_GET['status'] ?? '';
$order        = $_GET['order'] ?? 'asc';

$query = "SELECT * FROM tasks WHERE user_id = :uid";
$params = [':uid' => $userId];

if ($statusFilter !== '') {
    $query .= " AND status = :status";
    $params[':status'] = $statusFilter;
}

$query .= " ORDER BY due_date " . ($order === 'desc' ? 'DESC' : 'ASC');

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = "Danh sách công việc";
require 'partials/header.php';
?>


<div class="floating-form">
  <h5 class="mb-3"> Thêm công việc</h5>

  <form method="post" action="add_task.php">

    <div class="mb-2">
      <label class="form-label">Tiêu đề</label>
      <input name="title" class="form-control" required>
    </div>

    <div class="mb-2">
      <label class="form-label">Mô tả</label>
      <textarea name="description" class="form-control" rows="2"></textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Ngày hết hạn</label>
      <input type="date" name="due_date" class="form-control">
    </div>

    <button class="btn btn-success w-100">Thêm</button>
  </form>
</div>


<h4 class="mb-3">📌 Công việc của bạn</h4>

<div class="row g-4">

<?php foreach ($tasks as $t): ?>
  <div class="col-md-4">
    <div class="task-card">

      <h5><?= htmlspecialchars($t['title']) ?></h5>

      <div class="task-date">
        📅 <?= $t['due_date'] ? date("d/m/Y", strtotime($t['due_date'])) : "-" ?>
      </div>

      <div class="mt-2">
        <?php
          $vt = [
            "pending"     => "⏳ Chờ xử lý",
            "in_progress" => "💼 Đang làm",
            "completed"   => "✔ Hoàn thành"
          ];
          echo "<strong>" . ($vt[$t['STATUS']] ?? $t['STATUS']) . "</strong>";
        ?>
      </div>

      <div class="mt-3 d-flex gap-2">
        <a class="btn btn-sm btn-outline-primary" href="edit_task.php?id=<?= $t['id'] ?>">Sửa</a>

    

        <a class="btn btn-sm btn-outline-danger"
          href="delete_task.php?id=<?= $t['id'] ?>"
          onclick="return confirm('Xóa task này?');">Xóa</a>
      </div>

    </div>
  </div>
<?php endforeach; ?>

</div>

<?php require 'partials/footer.php'; ?>
