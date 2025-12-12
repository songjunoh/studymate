<?php
session_start();
include("./lib/db.php");

$err = "";
if($_POST){
  $username = trim($_POST["username"] ?? "");
  $password = $_POST["password"] ?? "";

  $u = mysqli_real_escape_string($conn, $username);
  $qry = "SELECT * FROM users WHERE username='$u' LIMIT 1";
  $rst = mysqli_query($conn, $qry);
  $user = mysqli_fetch_assoc($rst);

  if($user && password_verify($password, $user["password"])){
    $_SESSION["username"] = $user["username"];
    $_SESSION["role"] = $user["role"];
    echo "<script>alert('로그인 성공!'); location.href='index.php';</script>";
    exit;
  } else {
    $err = "아이디 또는 비밀번호가 틀렸습니다.";
  }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>로그인</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="navbar">
  <a href="index.php">홈</a>
  <a href="guestbook.php">방명록</a>
  <a href="board.php">게시판</a>
  <a href="login.php">로그인</a>
  <a href="signup.php">회원가입</a>
</div>

<div class="container">
  <h2>로그인</h2>
  <?php if($err) echo "<p style='color:#d9534f; font-weight:800;'>".htmlspecialchars($err)."</p>"; ?>

  <form method="post">
    <label>아이디</label>
    <input type="text" name="username" required>

    <label>비밀번호</label>
    <input type="password" name="password" required>

    <button type="submit">로그인</button>
  </form>
</div>
</body>
</html>
