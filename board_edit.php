<?php
session_start();
include("./lib/db.php");

if(!isset($_SESSION["username"])){
  echo "<script>alert('로그인 필요'); location.href='login.php';</script>";
  exit;
}

$id = intval($_GET["id"] ?? 0);
$rst = mysqli_query($conn, "SELECT * FROM board WHERE id=$id");
$post = mysqli_fetch_assoc($rst);
if(!$post){
  echo "<script>alert('글이 없습니다'); history.back();</script>";
  exit;
}

$can = ($_SESSION["username"] === $post["username"]) || (isset($_SESSION["role"]) && $_SESSION["role"]==="admin");
if(!$can){
  echo "<script>alert('권한 없음'); history.back();</script>";
  exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>글 수정</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="navbar">
  <a href="index.php">홈</a>
  <a href="board.php">게시판</a>
  <a href="logout.php">로그아웃(<?= htmlspecialchars($_SESSION['username']) ?>)</a>
</div>

<div class="container">
  <h2>글 수정</h2>

  <form action="board_update.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $post['id'] ?>">

    <label>제목</label>
    <input type="text" name="title" required value="<?= htmlspecialchars($post['title']) ?>">

    <label>내용</label>
    <textarea name="content" rows="8" required><?= htmlspecialchars($post['content']) ?></textarea>

    <?php if($post['file_path']){ ?>
      <p class="meta">현재 첨부: <a href="<?= htmlspecialchars($post['file_path']) ?>" target="_blank">보기</a></p>
      <label><input type="checkbox" name="remove_file" value="1"> 첨부파일 삭제</label>
    <?php } ?>

    <label>새 첨부파일 (선택)</label>
    <input type="file" name="upfile">

    <button type="submit">수정 저장</button>
  </form>
</div>
</body>
</html>
