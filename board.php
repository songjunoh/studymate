<?php
session_start();
include("./lib/db.php");

$perPage = 7;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if($page < 1) $page = 1;
$start = ($page - 1) * $perPage;

$keyword = trim($_GET['keyword'] ?? "");
$field = $_GET['field'] ?? "title";
$allowed = ['title','content','username'];
if(!in_array($field, $allowed)) $field = 'title';

$where = "";
$qs = "";
if($keyword !== ""){
  $esc = mysqli_real_escape_string($conn, $keyword);
  $where = "WHERE $field LIKE '%$esc%'";
  $qs = "&field=".urlencode($field)."&keyword=".urlencode($keyword);
}

$totalQry = "SELECT COUNT(*) AS cnt FROM board $where";
$totalRst = mysqli_query($conn, $totalQry);
$totalPosts = (int)mysqli_fetch_assoc($totalRst)['cnt'];
$totalPages = max(1, (int)ceil($totalPosts / $perPage));

$qry = "
  SELECT b.*,
    (SELECT COUNT(*) FROM likes l WHERE l.board_id=b.id) AS like_cnt,
    (SELECT COUNT(*) FROM comments c WHERE c.board_id=b.id) AS cmt_cnt
  FROM board b
  $where
  ORDER BY b.id DESC
  LIMIT $start, $perPage
";
$rst = mysqli_query($conn, $qry);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>게시판</title>
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
  <h2>게시판</h2>

  <?php if(isset($_SESSION['username'])) { ?>
    <a href="board_write.php"><button>글쓰기</button></a>
  <?php } ?>

  <form method="get" class="panel" style="padding:14px; margin-top:14px;">
    <div style="display:flex; gap:10px; align-items:center;">
      <select name="field" style="max-width:140px;">
        <option value="title" <?= $field==='title'?'selected':'' ?>>제목</option>
        <option value="content" <?= $field==='content'?'selected':'' ?>>내용</option>
        <option value="username" <?= $field==='username'?'selected':'' ?>>작성자</option>
      </select>
      <input type="text" name="keyword" placeholder="검색어" value="<?= htmlspecialchars($keyword) ?>">
      <button type="submit" style="max-width:120px;">검색</button>
    </div>
  </form>

  <div style="margin-top:14px;">
    <table class="board-table">
      <tr>
        <th style="width:70px;">번호</th>
        <th>제목</th>
        <th style="width:120px;">작성자</th>
        <th style="width:160px;">작성일</th>
        <th style="width:80px;">조회</th>
        <th style="width:80px;">좋아요</th>
      </tr>

      <?php if(mysqli_num_rows($rst) === 0){ ?>
        <tr><td colspan="6" style="text-align:center;">게시글이 없습니다.</td></tr>
      <?php } else {
        $no = $totalPosts - $start;
        while($row = mysqli_fetch_assoc($rst)){ ?>
          <tr>
            <td><?= $no-- ?></td>
            <td>
              <a href="board_view.php?id=<?= $row['id'] ?>">
                <?= htmlspecialchars($row['title']) ?>
              </a>
              <span class="meta"> (댓글 <?= (int)$row['cmt_cnt'] ?>)</span>
            </td>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td class="meta"><?= htmlspecialchars($row['regdate']) ?></td>
            <td><?= (int)$row['views'] ?></td>
            <td><?= (int)$row['like_cnt'] ?></td>
          </tr>
      <?php }} ?>
    </table>

    <div class="pagination">
      <?php if($page > 1){ ?>
        <a href="board.php?page=<?= $page-1 ?><?= $qs ?>">◀</a>
      <?php } ?>

      <?php
      for($i=1; $i<=$totalPages; $i++){
        if($i == $page) echo "<span class='active'>$i</span>";
        else echo "<a href='board.php?page=$i$qs'>$i</a>";
      }
      ?>

      <?php if($page < $totalPages){ ?>
        <a href="board.php?page=<?= $page+1 ?><?= $qs ?>">▶</a>
      <?php } ?>
    </div>
  </div>
</div>
</body>
</html>
