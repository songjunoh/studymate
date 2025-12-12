<?php
session_start();
include("./lib/db.php");

if(!isset($_SESSION["username"])){
  echo "<script>alert('로그인이 필요합니다.'); location.href='login.php';</script>";
  exit;
}

$title = mysqli_real_escape_string($conn, trim($_POST["title"] ?? ""));
$content = mysqli_real_escape_string($conn, trim($_POST["content"] ?? ""));
$username = mysqli_real_escape_string($conn, $_SESSION["username"]);

if($title === "" || $content === ""){
  echo "<script>alert('제목/내용은 필수입니다.'); history.back();</script>";
  exit;
}

$filePath = null;

// 파일 업로드 처리
if(isset($_FILES["upfile"]) && $_FILES["upfile"]["error"] === UPLOAD_ERR_OK){
  $tmp = $_FILES["upfile"]["tmp_name"];
  $orig = basename($_FILES["upfile"]["name"]);
  $ext = pathinfo($orig, PATHINFO_EXTENSION);

  $newName = date("Ymd_His") . "_" . bin2hex(random_bytes(4));
  if($ext) $newName .= "." . $ext;

  $saveDir = __DIR__ . "/uploads";
  if(!is_dir($saveDir)) mkdir($saveDir, 0777, true);

  $savePath = $saveDir . "/" . $newName;
  if(move_uploaded_file($tmp, $savePath)){
    $filePath = "uploads/" . $newName; // DB 저장용(상대경로)
  }
}

$f = $filePath ? mysqli_real_escape_string($conn, $filePath) : "";
$qry = "INSERT INTO board(username,title,content,file_path,regdate,views)
        VALUES('$username','$title','$content',".($filePath ? "'$f'" : "NULL").",NOW(),0)";

if(mysqli_query($conn, $qry)){
  echo "<script>alert('등록 완료'); location.href='board.php';</script>";
} else {
  echo "오류: " . mysqli_error($conn);
}
