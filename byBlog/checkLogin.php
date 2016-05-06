<?php
/**
 * 验证是否已登录
 */
session_start();
if( !isset($_SESSION['userName'])){
    //Echo "已登录";
    header("Location: login.php");
    }
?>