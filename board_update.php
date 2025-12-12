<?php
session_start();
include("./lib/db.php");

if(!isset($_SESSION["username"])){
  echo "<script>alert('로그인 필요'); location.href='login.php';</script>";
  exit;
}

$id = intval($_POST["id"] ?? 0);
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

$title = mysqli_real_escape_string($conn, trim($_POST["title"] ?? ""));
$content = mysqli_real_escape_string($conn, trim($_POST["content"] ?? ""));

$filePath = $post['file_path'];

/* 첨부 삭제 체크 */
if(isset($_POST["remove_file"]) && $_POST["remove_file"] == "1"){
  if($filePath && file_exists(__DIR__ . "/" . $filePath)){
    @unlink(__DIR__ . "/" . $filePath);
  }
  $filePath = null;
}

/* 새 파일 업로드 */
if(isset($_FILES["upfile"]) && $_FILES["upfile"]["error"] === UPLOAD_ERR_OK){
  // 기존 파일 삭제
  if($filePath && file_exists(__DIR__ . "/" . $filePath)){
    @unlink(__DIR__ . "/" . $filePath);
  }

  $tmp = $_FILES["upfile"]["tmp_name"];
  $orig = basename($_FILES["upfile"]["name"]);
  $ext = pathinfo($orig, PATHINFO_EXTENSION);

  $newName = date("Ymd_His") . "_" . bin2hex(random_bytes(4));
  if($ext) $newName .= "." . $ext;

  $saveDir = __DIR__ . "/uploads";
  if(!is_dir($saveDir)) mkdir($saveDir, 0777, true);

  $savePath = $saveDir . "/" . $newName;
  if(move_uploaded_file($tmp, $savePath)){
    $filePath = "uploads/" . $newName;
  }
}

$f = $filePath ? mysqli_real_escape_string($conn, $filePath) : "";
$qry = "UPDATE board SET title='$title', content='$content', file_path=".($filePath ? "'$f'" : "NULL")." WHERE id=$id";

if(mysqli_query($conn, $qry)){
  echo "<script>alert('수정 완료'); location.href='board_view.php?id=$id';</script>";
} else {
  echo "오류: " . mysqli_error($conn);
}
