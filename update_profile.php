<?php
session_start();
include("./lib/db.php");

if(!isset($_SESSION["username"])){
  echo "<script>alert('로그인이 필요합니다.'); location.href='login.php';</script>";
  exit;
}

$username = mysqli_real_escape_string($conn, $_SESSION["username"]);
$email = mysqli_real_escape_string($conn, trim($_POST["email"] ?? ""));
$newpw = $_POST["password"] ?? "";

if($newpw !== ""){
  $hash = password_hash($newpw, PASSWORD_DEFAULT);
  $qry = "UPDATE users SET email='$email', password='$hash' WHERE username='$username'";
} else {
  $qry = "UPDATE users SET email='$email' WHERE username='$username'";
}

if(mysqli_query($conn, $qry)){
  echo "<script>alert('수정 완료!'); location.href='mypage.php';</script>";
} else {
  echo "오류: " . mysqli_error($conn);
}
