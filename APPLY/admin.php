<?php
session_start();
require 'db.php';

// Admin login
if(!isset($_SESSION['admin_logged_in'])){
    if($_POST){
        $username = $_POST['username'];
        $password = hash('sha256', $_POST['password']);
        $result = $conn->query("SELECT * FROM admin WHERE username='$username' AND password='$password'");
        if($result->num_rows){
            $_SESSION['admin_logged_in'] = true;
        } else {
            $error = "Invalid credentials.";
        }
    } else {
        echo '<div class="container"><h2>Admin Login</h2>
              <form method="POST">
              <input type="text" name="username" placeholder="Username" required><br><br>
              <input type="password" name="password" placeholder="Password" required><br><br>
              <button type="submit">Login</button>
              </form>';
        if(isset($error)) echo "<p style='color:red;'>$error</p>";
        echo '</div>';
        exit;
    }
}

// Fetch applications
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : "";
$sql = "SELECT a.id, ap.full_name, ap.email, a.program, a.qualifications, a.certificate, a.status, a.created_at
        FROM applications a
        JOIN applicants ap ON a.applicant_id = ap.id";

if($search != ""){
    $sql .= " WHERE ap.full_name LIKE '%$search%' OR a.program LIKE '%$search%' OR a.status LIKE '%$search%'";
}

$sql .= " ORDER BY a.created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Panel</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<h2>Admin Panel</h2>

<form method="GET" style="margin-bottom:20px;">
<input type="text" name="search" placeholder="Search Name, Program, Status" value="<?= htmlspecialchars($search) ?>">
<button type="submit">Search</button>
<a href="admin.php" class="btn">Reset</a>
</form>

<table border="1" cellpadding="10" cellspacing="0">
<tr>
<th>ID</th>
<th>Applicant Name</th>
<th>Email</th>
<th>Program</th>
<th>Qualifications</th>
<th>Certificate</th>
<th>Status</th>
<th>Submitted At</th>
<th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()){ ?>
<tr>
<td><?= $row['id'] ?></td>
<td><?= htmlspecialchars($row['full_name']) ?></td>
<td><?= htmlspecialchars($row['email']) ?></td>
<td><?= htmlspecialchars($row['program']) ?></td>
<td><?= htmlspecialchars($row['qualifications']) ?></td>
<td><a href="<?= $row['certificate'] ?>" target="_blank">View</a></td>
<td><?= $row['status'] ?></td>
<td><?= $row['created_at'] ?></td>
<td>
<form method="POST" action="update_status.php">
<input type="hidden" name="id" value="<?= $row['id'] ?>">
<select name="status">
<option value="Pending" <?= $row['status']=='Pending'?'selected':'' ?>>Pending</option>
<option value="Reviewed" <?= $row['status']=='Reviewed'?'selected':'' ?>>Reviewed</option>
<option value="Accepted" <?= $row['status']=='Accepted'?'selected':'' ?>>Accepted</option>
<option value="Rejected" <?= $row['status']=='Rejected'?'selected':'' ?>>Rejected</option>
</select>
<button type="submit">Update</button>
</form>
</td>
</tr>
<?php } ?>
</table>

<form method="POST" action="logout_admin.php" style="margin-top:20px;">
<button type="submit">Logout</button>
</form>

</div>
</body>
</html>
