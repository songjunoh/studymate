<?php
session_start();
include("./lib/db.php");

if(!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin"){
  echo "<script>alert('관리자만 삭제 가능합니다.'); history.back();</script>";
  exit;
}
$id = intval($_GET["id"] ?? 0);
if($id <= 0){
  echo "<script>alert('잘못된 요청'); history.back();</script>";
  exit;
}

$qry = "DELETE FROM guestbook WHERE id=$id";
if(mysqli_query($conn, $qry)){
  echo "<script>alert('삭제 완료'); location.href='guestbook.php';</script>";
} else {
  echo "오류: " . mysqli_error($conn);
}
