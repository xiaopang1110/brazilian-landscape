<?php
session_start();
include 'controllers/quizapp.php';
include 'function.php';
$admin = new Dashboard();


$key= "admin@123";
echo $admin->encrypt_decrypt('encrypt', $key);

?>