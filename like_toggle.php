<?php
session_start();
include("./lib/db.php");

if(!isset($_SESSION["username"])){
  echo "<script>alert('로그인 필요'); history.back();</script>";
  exit;
}

$board_id = intval($_GET["board_id"] ?? 0);
if($board_id <= 0){
  echo "<script>alert('잘못된 접근'); history.back();</script>";
  exit;
}

$username = mysqli_real_escape_string($conn, $_SESSION["username"]);

// 이미 눌렀는지 확인
$chk = "SELECT id FROM likes WHERE board_id=$board_id AND username='$username' LIMIT 1";
$chkRst = mysqli_query($conn, $chk);

if(mysqli_num_rows($chkRst) > 0){
  // 취소
  mysqli_query($conn, "DELETE FROM likes WHERE board_id=$board_id AND username='$username'");
} else {
  // 추가
  mysqli_query($conn, "INSERT INTO likes(board_id, username, regdate) VALUES($board_id, '$username', NOW())");
}

echo "<script>location.href='board_view.php?id=$board_id';</script>";
