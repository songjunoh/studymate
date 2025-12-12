<?php
session_start();
include("./lib/db.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>방명록</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="navbar">
  <a href="index.php">홈</a>
  <a href="guestbook.php">방명록</a>
  <a href="board.php">게시판</a>

  <?php if(isset($_SESSION['username'])) { ?>
    <a href="mypage.php">마이페이지</a>
    <?php if(isset($_SESSION['role']) && $_SESSION['role']==='admin'){ ?>
      <a class="admin-link" href="admin/admin_dashboard.php">관리자</a>
    <?php } ?>
    <a href="logout.php">로그아웃(<?= htmlspecialchars($_SESSION['username']) ?>)</a>
  <?php } else { ?>
    <a href="login.php">로그인</a>
    <a href="signup.php">회원가입</a>
  <?php } ?>
</div>

<div class="container">
  <h2>방명록</h2>

  <?php if(isset($_SESSION["username"])) { ?>
    <form action="guest_insert.php" method="post">
      <label>응원 메시지</label>
      <textarea name="msg" rows="4" required placeholder="응원 한마디 남겨줘!"></textarea>
      <button type="submit">등록</button>
    </form>
  <?php } else { ?>
    <p>방명록을 작성하려면 <a class="btn btn-outline" href="login.php">로그인</a>하세요.</p>
  <?php } ?>

  <?php
  $qry = "SELECT * FROM guestbook ORDER BY id DESC";
  $rst = mysqli_query($conn, $qry);

  while($row = mysqli_fetch_assoc($rst)){
    echo "<div class='guest-item'>";
    echo "<b>".htmlspecialchars($row['username'])."</b> ";
    echo "<span class='meta'>(".htmlspecialchars($row['regdate']).")</span>";
    echo "<p>".nl2br(htmlspecialchars($row['message']))."</p>";

    if(isset($_SESSION["role"]) && $_SESSION["role"] === "admin"){
      echo "<a class='delete-btn' href='guest_delete.php?id={$row['id']}' onclick=\"return confirm('삭제할까요?');\">삭제</a>";
    }
    echo "</div>";
  }
  ?>
</div>
</body>
</html>
