<?php
session_start();
if(!isset($_SESSION['applicant_id'])){
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Application Submitted</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<h2>Application Submitted Successfully!</h2>
<p>Thank you for your application. We will review it and contact you shortly.</p>
<a href="dashboard.php" class="btn">Go to Dashboard</a>
<a href="logout.php" class="btn">Logout</a>
</div>
</body>
</html>
