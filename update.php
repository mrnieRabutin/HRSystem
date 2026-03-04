<?php
include "config/db.php";

$id = $_POST['id'];
unset($_POST['id']);

$updates = [];
foreach($_POST as $key=>$value){
    $updates[] = "$key='$value'";
}

$sql = "UPDATE appointments SET ".implode(",", $updates)." WHERE id=$id";
$conn->query($sql);

header("Location: dashboard.php");
?>