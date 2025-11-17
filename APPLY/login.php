<?php
require 'db.php';
session_start();

if($_POST){
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM applicants WHERE email='$email'");
    if($result->num_rows){
        $user = $result->fetch_assoc();
        if(password_verify($password, $user['password'])){
            $_SESSION['applicant_id'] = $user['id'];
            $_SESSION['full_name'] = $user['full_name'];
            header("Location: dashboard.php");
            exit;
        } else { $error = "Incorrect password."; }
    } else { $error = "Email not registered."; }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<h2>Applicant Login</h2>
<form method="POST">
    <label>Email</label>
    <input type="email" name="email" required>
    <label>Password</label>
    <input type="password" name="password" required>
    <button type="submit">Login</button>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
</form>
</div>
</body>
</html>
