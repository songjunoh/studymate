<?php
session_start();
include("../lib/db.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
  echo "<script>alert('관리자만 접근 가능합니다'); location.href='../index.php';</script>";
  exit;
}

$userCnt = (int)mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM users"))['cnt'];
$postCnt = (int)mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM board"))['cnt'];
$commentCnt = (int)mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM comments"))['cnt'];
$likeCnt = (int)mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM likes"))['cnt'];

$todayPostCnt = (int)mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM board WHERE DATE(regdate)=CURDATE()"))['cnt'];
$todayUserCnt = (int)mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM users WHERE DATE(regdate)=CURDATE()"))['cnt'];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>관리자 대시보드</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php include("admin_nav.php"); ?>

<div class="container">
  <h2>📊 관리자 통계 대시보드</h2>

  <div class="admin-stats">
    <div class="stat-box"><h3>👤 전체 회원</h3><p><?= $userCnt ?> 명</p></div>
    <div class="stat-box"><h3>📝 전체 게시글</h3><p><?= $postCnt ?> 개</p></div>
    <div class="stat-box"><h3>💬 전체 댓글</h3><p><?= $commentCnt ?> 개</p></div>
    <div class="stat-box"><h3>👍 전체 좋아요</h3><p><?= $likeCnt ?> 개</p></div>
    <div class="stat-box"><h3>📅 오늘 게시글</h3><p><?= $todayPostCnt ?> 개</p></div>
    <div class="stat-box"><h3>🆕 오늘 가입</h3><p><?= $todayUserCnt ?> 명</p></div>
  </div>
</div>
</body>
</html>
