<?php
session_start();
if(!isset($_SESSION['applicant_id'])){ header("Location: login.php"); exit; }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Apply Online</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<h2>Online Application Form</h2>
<form action="submit_application.php" method="POST" enctype="multipart/form-data">
<label>Program Applying For</label>
<input type="text" name="program" required>
<label>Qualifications</label>
<textarea name="qualifications" required></textarea>
<label>Upload Certificate (PDF/JPG/PNG, max 2MB)</label>
<input type="file" name="certificate" required>
<button type="submit">Submit Application</button>
</form>
</div>
</body>
</html>
