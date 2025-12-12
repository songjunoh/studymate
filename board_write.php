<?php
session_start();
include("./lib/db.php");
if(!isset($_SESSION["username"])){
  echo "<script>alert('로그인이 필요합니다.'); location.href='login.php';</script>";
  exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>글쓰기</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="navbar">
  <a href="index.php">홈</a>
  <a href="board.php">게시판</a>
  <a href="logout.php">로그아웃(<?= htmlspecialchars($_SESSION['username']) ?>)</a>
</div>

<div class="container">
  <h2>글쓰기</h2>

  <form action="board_insert.php" method="post" enctype="multipart/form-data">
    <label>제목</label>
    <input type="text" name="title" required>

    <label>내용</label>
    <textarea name="content" rows="8" required></textarea>

    <label>첨부파일 (이미지/문서 가능)</label>
    <input type="file" name="upfile">

    <button type="submit">등록</button>
  </form>
</div>
</body>
</html>
