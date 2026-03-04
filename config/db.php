<?php
$conn = new mysqli("localhost","root","","deped_db");

if ($conn->connect_error) {
    die("DB Connection failed");
}
?>