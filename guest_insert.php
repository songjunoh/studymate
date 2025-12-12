<?php
session_start();
include("./lib/db.php");

if(!isset($_SESSION["username"])){
  echo "<script>alert('로그인이 필요합니다.'); history.back();</script>";
  exit;
}

$username = mysqli_real_escape_string($conn, $_SESSION["username"]);
$msg = mysqli_real_escape_string($conn, trim($_POST["msg"] ?? ""));

if($msg === ""){
  echo "<script>alert('내용을 입력하세요.'); history.back();</script>";
  exit;
}

$qry = "INSERT INTO guestbook(username,message,regdate) VALUES('$username','$msg',NOW())";
if(mysqli_query($conn, $qry)){
  echo "<script>alert('등록되었습니다.'); location.href='guestbook.php';</script>";
} else {
  echo "오류: " . mysqli_error($conn);
}
