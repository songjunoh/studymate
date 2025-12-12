<?php
session_start();
include("./lib/db.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>StudyMate 홈</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="navbar">
  <a href="index.php">홈</a>
  <a href="guestbook.php">방명록</a>
  <a href="board.php">게시판</a>

  <?php if(isset($_SESSION['username'])) { ?>
    <a href="mypage.php">마이페이지</a>

    <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin') { ?>
      <a class="admin-link" href="admin/admin_dashboard.php">관리자</a>
    <?php } ?>

    <a href="logout.php">로그아웃(<?= htmlspecialchars($_SESSION['username']) ?>)</a>
  <?php } else { ?>
    <a href="login.php">로그인</a>
    <a href="signup.php">회원가입</a>
  <?php } ?>
</div>

<div class="container">
  <div class="hero">
    <div class="hero-title">StudyMate에 오신 걸 환영합니다 👋</div>
    <div class="hero-sub">
      스터디 친구들과 함께 공부 계획을 나누고, 방명록으로 응원 메시지를 남겨보세요.<br>
      회원가입 후 로그인하면 게시판/댓글/좋아요/방명록 기능을 사용할 수 있습니다.
    </div>

    <?php if(isset($_SESSION['username'])) { ?>
      <p><b><?= htmlspecialchars($_SESSION['username']) ?></b>님, 오늘도 파이팅! 💪</p>
    <?php } else { ?>
      <p class="hero-sub">아직 회원이 아니라면 지금 가입해보세요 🙂</p>
    <?php } ?>
  </div>

  <div class="card-grid">
    <div class="card">
      <h3>방명록</h3>
      <p>서로에게 응원 메시지를 남겨보세요. 관리자는 필요 시 글을 삭제할 수 있어요.</p>
      <a href="guestbook.php" class="card-btn">방명록 바로가기</a>
    </div>

    <div class="card">
      <h3>게시판</h3>
      <p>공부 팁, 자료 공유, 질문을 올릴 수 있어요. 댓글/좋아요/조회수까지!</p>
      <a href="board.php" class="card-btn">게시판 바로가기</a>
    </div>

    <div class="card">
      <h3>최근 방명록</h3>
      <p>최근 글 3개를 미리 봅니다.</p>
      <?php
        $qry = "SELECT * FROM guestbook ORDER BY id DESC LIMIT 3";
        $rst = mysqli_query($conn, $qry);
        while($row = mysqli_fetch_assoc($rst)){
          $msg = mb_strimwidth($row['message'], 0, 40, "...", "UTF-8");
          echo "<p class='meta'><b>".htmlspecialchars($row['username'])."</b> : ".htmlspecialchars($msg)."</p>";
        }
      ?>
      <a href="guestbook.php" class="card-btn">전체 보기</a>
    </div>
  </div>

  <div class="footer">© 2025 StudyMate. Web Application Assignment.</div>
</div>
</body>
</html>
