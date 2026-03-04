<?php
session_start();
include "../config/db.php";

$username = $_POST['username'];
$password = md5($_POST['password']);

$res = $conn->query("SELECT * FROM users 
                     WHERE username='$username' 
                     AND password='$password'");

if($res->num_rows > 0){
    $_SESSION['user'] = $username;

    // redirect BACK to login with success flag
    header("Location: login.php?success=1");
    exit();
}else{
    header("Location: login.php?error=1");
    exit();
}
?>