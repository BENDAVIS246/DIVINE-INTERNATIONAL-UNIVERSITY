<?php
session_start();
require 'db.php';

if(!isset($_SESSION['applicant_id'])){
    header("Location: login.php");
    exit;
}

$applicant_id = $_SESSION['applicant_id'];

// Sanitize inputs
$program = $conn->real_escape_string($_POST['program']);
$qualifications = $conn->real_escape_string($_POST['qualifications']);

// Handle file upload
$certificate = $_FILES['certificate'];
$target_dir = "uploads/";
$target_file = $target_dir . time() . "_" . basename($certificate["name"]);
$fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

if($certificate["size"] > 2*1024*1024){
    die("File too large. Max 2MB.");
}
if(!in_array($fileType, ['pdf','jpg','jpeg','png'])){
    die("Invalid file type.");
}
if(!move_uploaded_file($certificate["tmp_name"], $target_file)){
    die("Error uploading file.");
}

// Insert into applications table
$sql = "INSERT INTO applications (applicant_id, program, qualifications, certificate)
        VALUES ('$applicant_id', '$program', '$qualifications', '$target_file')";

if($conn->query($sql)){
    // Send email to applicant
    $applicant_result = $conn->query("SELECT email, full_name FROM applicants WHERE id='$applicant_id'");
    $applicant = $applicant_result->fetch_assoc();
    $to = $applicant['email'];
    $subject = "Application Received - Divine International University";
    $message = "Dear {$applicant['full_name']},\n\nYour application for $program has been received.\n\nRegards,\nDivine International University";
    @mail($to, $subject, $message, "From: no-reply@divineuniversity.com");

    // Send email to admin
    $adminEmail = "admin@divineuniversity.com";
    $subjectAdmin = "New Application Submitted";
    $messageAdmin = "New application submitted by {$applicant['full_name']}.";
    @mail($adminEmail, $subjectAdmin, $messageAdmin, "From: no-reply@divineuniversity.com");

    header("Location: success.php");
    exit;
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
