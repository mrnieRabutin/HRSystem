<?php
include "config/db.php";

/* Auto Control No */
$year = date("Y");
$res = $conn->query("SELECT COUNT(*) as total FROM appointments");
$row = $res->fetch_assoc();
$next = $row['total'] + 1;
$control_no = "DEPED-$year-".str_pad($next,4,"0",STR_PAD_LEFT);

/* Upload Signature */
$signature = "";
if(!empty($_FILES['signature']['name'])){
    $signature = time()."_".$_FILES['signature']['name'];
    move_uploaded_file($_FILES['signature']['tmp_name'],
        "uploads/signatures/".$signature);
}

/* Collect fields */
$data = $_POST;
$data['control_no'] = $control_no;
$data['signature'] = $signature;

/* Build query */
$columns = implode(",", array_keys($data));
$values = "'" . implode("','", array_values($data)) . "'";

$conn->query("INSERT INTO appointments ($columns) VALUES ($values)");

$id = $conn->insert_id;
header("Location: generate_pdf.php?id=".$id);
?>