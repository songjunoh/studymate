<?php
session_start();
include("../lib/db.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
  echo "<script>alert('관리자만'); location.href='../index.php';</script>";
  exit;
}

$id = intval($_GET["id"] ?? 0);
$role = $_GET["role"] ?? "user";
if(!in_array($role, ["user","admin"])) $role = "user";

mysqli_query($conn, "UPDATE users SET role='$role' WHERE id=$id");
echo "<script>alert('권한 변경 완료'); location.href='admin_users.php';</script>";
