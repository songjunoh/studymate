<?php
session_start();
include("../lib/db.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
  echo "<script>alert('관리자만'); location.href='../index.php';</script>";
  exit;
}
$id = intval($_GET["id"] ?? 0);
mysqli_query($conn, "DELETE FROM comments WHERE id=$id");
echo "<script>alert('삭제 완료'); location.href='admin_comments.php';</script>";
