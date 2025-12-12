<?php
session_start();
include("../lib/db.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
  echo "<script>alert('관리자만'); location.href='../index.php';</script>";
  exit;
}

$rst = mysqli_query($conn, "
  SELECT b.*,
    (SELECT COUNT(*) FROM comments c WHERE c.board_id=b.id) AS cmt_cnt,
    (SELECT COUNT(*) FROM likes l WHERE l.board_id=b.id) AS like_cnt
  FROM board b
  ORDER BY b.id DESC
");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>게시글 관리</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include("admin_nav.php"); ?>

<div class="container">
  <h2>게시글 관리</h2>

  <table class="board-table">
    <tr>
      <th style="width:70px;">ID</th>
      <th>제목</th>
      <th style="width:120px;">작성자</th>
      <th style="width:170px;">작성일</th>
      <th style="width:70px;">조회</th>
      <th style="width:70px;">좋아요</th>
      <th style="width:70px;">댓글</th>
      <th style="width:90px;">관리</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($rst)){ ?>
      <tr>
        <td><?= (int)$row['id'] ?></td>
        <td><a href="../board_view.php?id=<?= $row['id'] ?>" target="_blank"><b><?= htmlspecialchars($row['title']) ?></b></a></td>
        <td><?= htmlspecialchars($row['username']) ?></td>
        <td class="meta"><?= htmlspecialchars($row['regdate']) ?></td>
        <td><?= (int)$row['views'] ?></td>
        <td><?= (int)$row['like_cnt'] ?></td>
        <td><?= (int)$row['cmt_cnt'] ?></td>
        <td>
          <a class="btn" style="background:#d9534f;"
             href="admin_post_delete.php?id=<?= $row['id'] ?>"
             onclick="return confirm('삭제할까요?');">삭제</a>
        </td>
      </tr>
    <?php } ?>
  </table>
</div>
</body>
</html>
