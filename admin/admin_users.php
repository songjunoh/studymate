<?php
session_start();
include("../lib/db.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
  echo "<script>alert('관리자만 접근 가능합니다'); location.href='../index.php';</script>";
  exit;
}

$rst = mysqli_query($conn, "SELECT id, username, email, role, regdate FROM users ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>회원 관리</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php include("admin_nav.php"); ?>

<div class="container">
  <h2>회원 관리</h2>

  <table class="board-table">
    <tr>
      <th style="width:70px;">ID</th>
      <th>아이디</th>
      <th>이메일</th>
      <th style="width:90px;">권한</th>
      <th style="width:170px;">가입일</th>
      <th style="width:180px;">관리</th>
    </tr>

    <?php while($row = mysqli_fetch_assoc($rst)){ ?>
      <tr>
        <td><?= (int)$row['id'] ?></td>
        <td><b><?= htmlspecialchars($row['username']) ?></b></td>
        <td><?= htmlspecialchars($row['email'] ?? '') ?></td>
        <td><?= htmlspecialchars($row['role']) ?></td>
        <td class="meta"><?= htmlspecialchars($row['regdate']) ?></td>
        <td>
          <?php if($row['username'] !== 'admin'){ ?>
            <a class="btn btn-outline" href="admin_user_role.php?id=<?= $row['id'] ?>&role=admin">관리자로</a>
            <a class="btn btn-outline" href="admin_user_role.php?id=<?= $row['id'] ?>&role=user">유저로</a>
          <?php } ?>
          <a class="btn" style="background:#d9534f;"
             href="admin_user_delete.php?id=<?= $row['id'] ?>"
             onclick="return confirm('정말 삭제할까요?');">삭제</a>
        </td>
      </tr>
    <?php } ?>
  </table>
</div>
</body>
</html>
