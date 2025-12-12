<?php
session_start();
include("./lib/db.php");

if(!isset($_SESSION["username"])){
  echo "<script>alert('로그인 필요'); history.back();</script>";
  exit;
}

$board_id = intval($_POST["board_id"] ?? 0);
$content = mysqli_real_escape_string($conn, trim($_POST["content"] ?? ""));
$username = mysqli_real_escape_string($conn, $_SESSION["username"]);

if($board_id <= 0 || $content === ""){
  echo "<script>alert('내용을 입력하세요'); history.back();</script>";
  exit;
}

$qry = "INSERT INTO comments(board_id,username,content,regdate) VALUES($board_id,'$username','$content',NOW())";
if(mysqli_query($conn, $qry)){
  echo "<script>alert('댓글 등록'); location.href='board_view.php?id=$board_id';</script>";
} else {
  echo "오류: " . mysqli_error($conn);
}
