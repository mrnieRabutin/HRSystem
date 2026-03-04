<?php
include 'config.php';
$id = $_POST['id'];
$conn->query("DELETE FROM assumption_records WHERE id=$id");
header('Location: index.php');
?>