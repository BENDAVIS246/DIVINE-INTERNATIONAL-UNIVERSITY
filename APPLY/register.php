<?php
require 'db.php';
session_start();

if($_POST){
    $name = $conn->real_escape_string($_POST['full_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO applicants (full_name, email, password) VALUES ('$name','$email','$password')";
    if($conn->query($sql)){
        $_SESSION['applicant_id'] = $conn->insert_id;
        $_SESSION['full_name'] = $name;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Email already registered.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<h2>Applicant Registration</h2>
<form method="POST">
    <label>Full Name</label>
    <input type="text" name="full_name" required>
    <label>Email</label>
    <input type="email" name="email" required>
    <label>Password</label>
    <input type="password" name="password" required>
    <button type="submit">Register</button>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
</form>
</div>
</body>
</html>
