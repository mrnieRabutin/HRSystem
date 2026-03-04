<?php
include 'config.php';

$id = intval($_GET['id']); // sanitize input

$result = $conn->query("SELECT * FROM assumption_records WHERE id = $id");

if($result->num_rows > 0){
    $row = $result->fetch_assoc();
    echo json_encode($row); // returns all fields as JSON
} else {
    echo json_encode([]);
}
?>