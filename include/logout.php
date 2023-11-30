<?php
session_start();
include_once '../controllers/storybook.php';
$user = new Dashboard();
unset($_SESSION['uid']);
$user->user_logout();
header("location:../index.php");
?>