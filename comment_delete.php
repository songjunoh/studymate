<?php
session_start();
include("./lib/db.php");

if(!isset($_SESSION["username"])){
  echo "<script>alert('로그인 필요'); history.back();</script>";
  exit;
}

$id = intval($_GET["id"] ?? 0);
$board_id = intval($_GET["board_id"] ?? 0);

$rst = mysqli_query($conn, "SELECT * FROM comments WHERE id=$id");
$c = mysqli_fetch_assoc($rst);
if(!$c){
  echo "<script>alert('댓글 없음'); history.back();</script>";
  exit;
}

$can = ($_SESSION["username"] === $c["username"]) || (isset($_SESSION["role"]) && $_SESSION["role"]==="admin");
if(!$can){
  echo "<script>alert('권한 없음'); history.back();</script>";
  exit;
}

if(mysqli_query($conn, "DELETE FROM comments WHERE id=$id")){
  echo "<script>alert('삭제 완료'); location.href='board_view.php?id=$board_id';</script>";
} else {
  echo "오류: " . mysqli_error($conn);
}
