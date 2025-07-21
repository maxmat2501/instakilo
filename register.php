<?php 

include "db.php";
include "header.php";
session_start();

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    

    $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email','$password', '$role')";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo "error: {$conn->error}";
    }
    else {
        echo "Registration done successfully";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="register.php" method="POST">
    name : <input type="text" name="name" required>
    email : <input type="email" name="email" required>
    password : <input type="password" name="password" required>
    role : 
    <select name="role">
        <option value="subscriber">subscriber</option>
        <option value="author">author</option>
    </select><br>
    <input type="submit" name="submit" value="register">
    </form>
</body>
</html>
