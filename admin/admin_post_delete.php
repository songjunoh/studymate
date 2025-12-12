<?php
session_start();
include("../lib/db.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
  echo "<script>alert('관리자만'); location.href='../index.php';</script>";
  exit;
}
$id = intval($_GET["id"] ?? 0);

$rst = mysqli_query($conn, "SELECT file_path FROM board WHERE id=$id");
$row = mysqli_fetch_assoc($rst);
if($row && $row['file_path']){
  $path = dirname(__DIR__) . "/" . $row['file_path'];
  if(file_exists($path)) @unlink($path);
}

mysqli_query($conn, "DELETE FROM board WHERE id=$id");
echo "<script>alert('삭제 완료'); location.href='admin_board.php';</script>";
