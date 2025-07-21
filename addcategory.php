<?php 
session_start();
include "db.php";
if(!isset($_SESSION['user_id'])){
    echo "you are not an admin";
    header("location: login.php");
}
else{
    if ($_SESSION['user_role'] == "admin") {
        if(isset($_POST['submit'])){
            $name = $_POST['name'];
           $sql = "INSERT INTO categories (name) VALUES ('$name')"; 
           $result = mysqli_query($conn, $sql);
           if(!$result){
            echo "error: {$conn->error}";
           }
           else{
            echo "category added successfully ";
           }
        }
    }
    else{
        header("location: dashboard.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="addcategory.php" method="POST">
    <input type="text" name="name">
    <input type="submit" name="submit" value="add category">
    <a href='dashboard.php'>dashboard</a>
    </form>
</body>
</html>