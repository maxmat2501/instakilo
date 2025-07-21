<?php
session_start();
include "db.php";
include "header.php";

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo "error: {$conn->error}";
    }
    else {
        if ($result->num_rows>0 ) {
            $row = mysqli_fetch_assoc($result);

                if (password_verify($password, $row['password'])) {
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['user_name'] = $row['name'];
                    $_SESSION['user_role'] = $row['role'];
                    $_SESSION['user_email'] = $row['email'];
                    echo "loged in successfully <a href='displaypost.php'>FEED</a> ";
                }
            
        }
    }
}

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Login</h1> <br>
        <form action="login.php" method="post">
            <label>Username:</label>
            <input type="email" name="email" required>
            <br>
            <label>Password:</label>
            <input type="password" name="password" required>
            <br>
            <input type="submit" name="submit" value="submit"> <br><br>
             <p>Don't have an account ?</p><a href='register.php'>Register</a>
        </form><br><br>
        
    </div>
</body>
</html>
