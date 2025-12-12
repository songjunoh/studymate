<?php
session_start();
include("../lib/db.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
  echo "<script>alert('관리자만 접근 가능합니다'); location.href='../index.php';</script>";
  exit;
}

$rst = mysqli_query($conn, "
  SELECT c.*, b.title
  FROM comments c
  LEFT JOIN board b ON b.id=c.board_id
  ORDER BY c.id DESC
");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>댓글 관리</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include("admin_nav.php"); ?>

<div class="container">
  <h2>댓글 관리</h2>

  <?php while($c = mysqli_fetch_assoc($rst)){ ?>
    <div class="guest-item">
      <b><?= htmlspecialchars($c['username']) ?></b>
      <span class="meta">(<?= htmlspecialchars($c['regdate']) ?>)</span>
      <div class="meta">글: <?= htmlspecialchars($c['title'] ?? '(삭제된 글)') ?> / board_id=<?= (int)$c['board_id'] ?></div>
      <p><?= nl2br(htmlspecialchars($c['content'])) ?></p>
      <a class="delete-btn" href="admin_comment_delete.php?id=<?= $c['id'] ?>" onclick="return confirm('삭제?');">삭제</a>
    </div>
  <?php } ?>
</div>
</body>
</html>
