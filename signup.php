<?php
session_start();
include("./lib/db.php");

$err = "";
if($_POST){
  $username = trim($_POST["username"] ?? "");
  $password = $_POST["password"] ?? "";
  $email    = trim($_POST["email"] ?? "");

  if($username === "" || $password === ""){
    $err = "아이디/비밀번호는 필수입니다.";
  } else {
    $u = mysqli_real_escape_string($conn, $username);
    $e = mysqli_real_escape_string($conn, $email);
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $qry = "INSERT INTO users(username,password,email) VALUES('$u','$hash','$e')";
    if(!mysqli_query($conn, $qry)){
      if(strpos(mysqli_error($conn), "Duplicate") !== false){
        $err = "이미 사용 중인 아이디입니다.";
      } else {
        $err = "가입 실패: " . mysqli_error($conn);
      }
    } else {
      echo "<script>alert('가입 완료! 로그인해주세요.'); location.href='login.php';</script>";
      exit;
    }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>회원가입</title>
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
  <h2>회원가입</h2>

  <?php if($err) echo "<p style='color:#d9534f; font-weight:800;'>".htmlspecialchars($err)."</p>"; ?>

  <form method="post">
    <label>아이디</label>
    <input type="text" name="username" required>

    <label>비밀번호</label>
    <input type="password" name="password" required>

    <label>이메일</label>
    <input type="email" name="email" placeholder="선택">

    <button type="submit">가입하기</button>
  </form>
</div>
</body>
</html>
