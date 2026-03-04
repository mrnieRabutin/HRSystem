<?php
include 'config.php';

// Get all POST data
$id                   = intval($_POST['id']); // always sanitize IDs
$fullname             = $_POST['fullname'];
$position             = $_POST['position'];
$office               = $_POST['office'];
$effective_date       = $_POST['effective_date'];
$appointment_name     = $_POST['appointment_name'];
$appointment_position = $_POST['appointment_position'];
$day_signed           = $_POST['day_signed'];
$month_signed         = $_POST['month_signed'];
$year_signed          = $_POST['year_signed'];
$sig_name             = $_POST['sig_name'];
$sig_rank             = $_POST['sig_rank'];
$sig_place            = $_POST['sig_place'];
$hrmo_name            = $_POST['hrmo_name'];
$hrmo_rank            = $_POST['hrmo_rank'];

// Prepare SQL to prevent SQL injection
$stmt = $conn->prepare("UPDATE assumption_records SET 
    fullname=?, position=?, office=?, effective_date=?,
    appointment_name=?, appointment_position=?,
    day_signed=?, month_signed=?, year_signed=?,
    sig_name=?, sig_rank=?, sig_place=?,
    hrmo_name=?, hrmo_rank=?
    WHERE id=?");

$stmt->bind_param(
    "ssssssssssssssi",
    $fullname, $position, $office, $effective_date,
    $appointment_name, $appointment_position,
    $day_signed, $month_signed, $year_signed,
    $sig_name, $sig_rank, $sig_place,
    $hrmo_name, $hrmo_rank,
    $id
);

// Execute and redirect
if($stmt->execute()){
    header('Location: index.php?msg=Record+Updated');
    exit();
}else{
    echo "Error updating record: ".$stmt->error;
}

$stmt->close();
$conn->close();
?>