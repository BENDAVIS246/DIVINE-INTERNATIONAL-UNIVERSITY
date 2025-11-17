<?php
session_start();
require 'db.php';
if(!isset($_SESSION['applicant_id'])){ header("Location: login.php"); exit; }

$applicant_id = $_SESSION['applicant_id'];
$applications = $conn->query("SELECT * FROM applications WHERE applicant_id='$applicant_id' ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<h2>Welcome, <?= htmlspecialchars($_SESSION['full_name']) ?></h2>
<a href="apply.php" class="btn">Submit New Application</a>
<a href="logout.php" class="btn">Logout</a>

<h3>Your Applications</h3>
<table border="1" cellpadding="10" cellspacing="0">
<tr>
<th>ID</th>
<th>Program</th>
<th>Status</th>
<th>Certificate</th>
<th>Submitted At</th>
</tr>
<?php while($row = $applications->fetch_assoc()){ ?>
<tr>
<td><?= $row['id'] ?></td>
<td><?= htmlspecialchars($row['program']) ?></td>
<td><?= $row['status'] ?></td>
<td><a href="<?= $row['certificate'] ?>" target="_blank">View</a></td>
<td><?= $row['created_at'] ?></td>
</tr>
<?php } ?>
</table>
</div>
</body>
</html>
