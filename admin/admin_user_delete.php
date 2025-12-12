<?php
session_start();
include("../lib/db.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
  echo "<script>alert('관리자만'); location.href='../index.php';</script>";
  exit;
}
$id = intval($_GET["id"] ?? 0);
if($id <= 0){
  echo "<script>alert('잘못된 요청'); history.back();</script>";
  exit;
}
mysqli_query($conn, "DELETE FROM users WHERE id=$id");
echo "<script>alert('삭제 완료'); location.href='admin_users.php';</script>";
