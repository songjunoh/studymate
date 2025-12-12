<?php
session_start();
include("./lib/db.php");

$id = intval($_GET["id"] ?? 0);
if($id <= 0){
  echo "<script>alert('잘못된 접근입니다.'); history.back();</script>";
  exit;
}

/* 조회수 증가 */
mysqli_query($conn, "UPDATE board SET views = views + 1 WHERE id=$id");

/* 글 가져오기 */
$rst = mysqli_query($conn, "SELECT * FROM board WHERE id=$id");
$post = mysqli_fetch_assoc($rst);
if(!$post){
  echo "<script>alert('존재하지 않는 글입니다.'); history.back();</script>";
  exit;
}

/* 좋아요 개수 */
$likeCntRst = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM likes WHERE board_id=$id");
$likeCnt = (int)mysqli_fetch_assoc($likeCntRst)['cnt'];

/* 내가 눌렀는지 */
$liked = false;
if(isset($_SESSION["username"])){
  $u = mysqli_real_escape_string($conn, $_SESSION["username"]);
  $chkRst = mysqli_query($conn, "SELECT id FROM likes WHERE board_id=$id AND username='$u' LIMIT 1");
  $liked = (mysqli_num_rows($chkRst) > 0);
}

/* 댓글 페이징 */
$commentPerPage = 5;
$cpage = isset($_GET['cpage']) ? intval($_GET['cpage']) : 1;
if($cpage < 1) $cpage = 1;
$cstart = ($cpage - 1) * $commentPerPage;

$ctotalRst = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM comments WHERE board_id=$id");
$ctotal = (int)mysqli_fetch_assoc($ctotalRst)['cnt'];
$ctotalPages = max(1, (int)ceil($ctotal / $commentPerPage));

$crst = mysqli_query($conn, "SELECT * FROM comments WHERE board_id=$id ORDER BY id ASC LIMIT $cstart, $commentPerPage");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($post['title']) ?></title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="navbar">
  <a href="index.php">홈</a>
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
  <h2>게시글 보기</h2>

  <div class="guest-item">
    <h3 style="margin-top:0;"><?= htmlspecialchars($post['title']) ?></h3>
    <p class="meta">
      작성자: <?= htmlspecialchars($post['username']) ?> |
      작성일: <?= htmlspecialchars($post['regdate']) ?> |
      조회수: <?= (int)$post['views'] ?> |
      좋아요: <?= $likeCnt ?>
    </p>
    <hr>
    <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>

    <?php if($post['file_path']){ ?>
      <hr>
      <p class="meta">첨부파일:
        <a class="btn btn-outline" href="<?= htmlspecialchars($post['file_path']) ?>" target="_blank">다운로드/보기</a>
      </p>
    <?php } ?>
  </div>

  <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:10px;">
    <a href="board.php"><button class="btn-outline btn">목록</button></a>

    <?php
    $canEdit = false;
    if(isset($_SESSION["username"])){
      if($_SESSION["username"] === $post["username"]) $canEdit = true;
      if(isset($_SESSION["role"]) && $_SESSION["role"] === "admin") $canEdit = true;
    }
    if($canEdit){ ?>
      <a href="board_edit.php?id=<?= $post['id'] ?>"><button>수정</button></a>
      <a href="board_delete.php?id=<?= $post['id'] ?>" onclick="return confirm('정말 삭제할까요?');">
        <button style="background:#d9534f;">삭제</button>
      </a>
    <?php } ?>

    <?php if(isset($_SESSION["username"])){ ?>
      <a href="like_toggle.php?board_id=<?= $post['id'] ?>" class="btn <?= $liked ? 'btn-outline' : '' ?>">
        <?= $liked ? '좋아요 취소' : '좋아요' ?>
      </a>
    <?php } else { ?>
      <span class="meta">좋아요/댓글은 로그인 후 가능합니다.</span>
    <?php } ?>
  </div>

  <h2 style="margin-top:22px;">댓글</h2>

  <?php if(isset($_SESSION["username"])){ ?>
    <form action="comment_insert.php" method="post">
      <input type="hidden" name="board_id" value="<?= $post['id'] ?>">
      <label>댓글 내용</label>
      <textarea name="content" rows="3" required></textarea>
      <button type="submit">댓글 등록</button>
    </form>
  <?php } else { ?>
    <p>댓글을 작성하려면 <a class="btn btn-outline" href="login.php">로그인</a>하세요.</p>
  <?php } ?>

  <?php while($c = mysqli_fetch_assoc($crst)){ ?>
    <div class="guest-item">
      <b><?= htmlspecialchars($c['username']) ?></b>
      <span class="meta">(<?= htmlspecialchars($c['regdate']) ?>)</span>
      <p><?= nl2br(htmlspecialchars($c['content'])) ?></p>

      <?php
      $canDel = false;
      if(isset($_SESSION["username"])){
        if($_SESSION["username"] === $c["username"]) $canDel = true;
        if(isset($_SESSION["role"]) && $_SESSION["role"] === "admin") $canDel = true;
      }
      if($canDel){ ?>
        <a class="delete-btn"
           href="comment_delete.php?id=<?= $c['id'] ?>&board_id=<?= $id ?>"
           onclick="return confirm('댓글 삭제?');">삭제</a>
      <?php } ?>
    </div>
  <?php } ?>

  <div class="pagination">
    <?php if($cpage > 1){ ?>
      <a href="board_view.php?id=<?= $id ?>&cpage=<?= $cpage-1 ?>">◀</a>
    <?php } ?>
    <?php for($i=1; $i<=$ctotalPages; $i++){
      if($i == $cpage) echo "<span class='active'>$i</span>";
      else echo "<a href='board_view.php?id=$id&cpage=$i'>$i</a>";
    } ?>
    <?php if($cpage < $ctotalPages){ ?>
      <a href="board_view.php?id=<?= $id ?>&cpage=<?= $cpage+1 ?>">▶</a>
    <?php } ?>
  </div>

</div>
</body>
</html>
