<?php
session_start();
include("./lib/db.php");

if(!isset($_SESSION["username"])){
  echo "<script>alert('로그인이 필요합니다'); history.back();</script>";
  exit;
}

$id = intval($_GET["id"] ?? 0);
$rst = mysqli_query($conn, "SELECT * FROM board WHERE id=$id");
$row = mysqli_fetch_assoc($rst);

if(!$row){
  echo "<script>alert('글이 없습니다'); history.back();</script>";
  exit;
}

$can = ($_SESSION["username"] === $row["username"]) || (isset($_SESSION["role"]) && $_SESSION["role"]==="admin");
if(!$can){
  echo "<script>alert('본인 글 또는 관리자만 삭제 가능합니다'); history.back();</script>";
  exit;
}

if($row['file_path'] && file_exists(__DIR__ . "/" . $row['file_path'])){
  @unlink(__DIR__ . "/" . $row['file_path']);
}

$ok = mysqli_query($conn, "DELETE FROM board WHERE id=$id");
if($ok){
  echo "<script>alert('삭제 완료'); location.href='board.php';</script>";
} else {
  echo "오류: ".mysqli_error($conn);
}
