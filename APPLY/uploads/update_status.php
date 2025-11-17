<?php
session_start();
require 'db.php';

if(!isset($_SESSION['admin_logged_in'])){
    header("Location: admin.php");
    exit;
}

if($_POST){
    $id = $conn->real_escape_string($_POST['id']);
    $status = $conn->real_escape_string($_POST['status']);
    $conn->query("UPDATE applications SET status='$status' WHERE id='$id'");
}

header("Location: admin.php");
exit;
?>
