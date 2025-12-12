<?php
session_start();
include("./lib/db.php");

if(!isset($_SESSION["username"])){
  echo "<script>alert('로그인이 필요합니다.'); location.href='login.php';</script>";
  exit;
}
$username = mysqli_real_escape_string($conn, $_SESSION["username"]);
$qry = "SELECT * FROM users WHERE username='$username' LIMIT 1";
$rst = mysqli_query($conn, $qry);
$user = mysqli_fetch_assoc($rst);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>마이페이지</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="navbar">
  <a href="index.php">홈</a>
  <a href="guestbook.php">방명록</a>
  <a href="board.php">게시판</a>
  <a href="mypage.php">마이페이지</a>
  <?php if(isset($_SESSION['role']) && $_SESSION['role']==='admin'){ ?>
    <a class="admin-link" href="admin/admin_dashboard.php">관리자</a>
  <?php } ?>
  <a href="logout.php">로그아웃(<?= htmlspecialchars($_SESSION['username']) ?>)</a>
</div>

<div class="container">
  <h2>마이페이지</h2>

  <form action="update_profile.php" method="post">
    <label>아이디(변경 불가)</label>
    <input type="text" value="<?= htmlspecialchars($user['username']) ?>" disabled>

    <label>이메일 변경</label>
    <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>">

    <label>새 비밀번호 (변경 시 입력)</label>
    <input type="password" name="password" placeholder="비우면 변경 안 함">

    <button type="submit">정보 수정</button>
  </form>
</div>
</body>
</html>
