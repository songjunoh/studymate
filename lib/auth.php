<?php
// lib/auth.php
function is_login(){
    return isset($_SESSION['username']);
}
function is_admin(){
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}
function require_login(){
    if(!is_login()){
        echo "<script>alert('로그인이 필요합니다.'); location.href='login.php';</script>";
        exit;
    }
}
function require_admin(){
    if(!is_admin()){
        echo "<script>alert('관리자만 접근 가능합니다.'); location.href='../index.php';</script>";
        exit;
    }
}
?>
