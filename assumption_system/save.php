<?php
include 'config.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get all form inputs
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
    $created_at           = date("Y-m-d H:i:s"); // timestamp

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO assumption_records 
        (fullname, position, office, effective_date, appointment_name, appointment_position, day_signed, month_signed, year_signed, sig_name, sig_rank, sig_place, hrmo_name, hrmo_rank, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param(
        "sssssssssssssss", 
        $fullname, $position, $office, $effective_date, $appointment_name, $appointment_position,
        $day_signed, $month_signed, $year_signed, $sig_name, $sig_rank, $sig_place,
        $hrmo_name, $hrmo_rank, $created_at
    );

    if ($stmt->execute()) {
        // Success: redirect back to main page
        header("Location: index.php?msg=Record+Saved");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>