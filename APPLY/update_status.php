<?php
session_start();
require 'db.php';

// Ensure admin is logged in
if(!isset($_SESSION['admin_logged_in'])){
    die("Access denied. Please login as admin.");
}

// Only allow POST requests
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    die("Invalid request method.");
}

// Validate input
if(!isset($_POST['id'], $_POST['status'])){
    die("Missing required parameters.");
}

$id = $conn->real_escape_string($_POST['id']);
$status = $conn->real_escape_string($_POST['status']);

// Ensure status is valid
$allowed_status = ['Pending','Reviewed','Accepted','Rejected'];
if(!in_array($status, $allowed_status)){
    die("Invalid status value.");
}

// Update application status
$sql = "UPDATE applications SET status='$status' WHERE id='$id'";
if($conn->query($sql)){
    // Optionally, notify applicant via email
    $applicant_result = $conn->query("SELECT email, full_name, program FROM applicants 
                                      JOIN applications ON applicants.id = applications.applicant_id 
                                      WHERE applications.id='$id'");
    if($applicant_result->num_rows){
        $applicant = $applicant_result->fetch_assoc();
        $to = $applicant['email'];
        $subject = "Application Status Update - Divine International University";
        $message = "Dear {$applicant['full_name']},\n\nYour application for {$applicant['program']} has been updated to '{$status}'.\n\nRegards,\nDivine International University";
        @mail($to, $subject, $message, "From: no-reply@divineuniversity.com");
    }

    header("Location: admin.php");
    exit;
} else {
    die("Database error: " . $conn->error);
}

$conn->close();
?>
