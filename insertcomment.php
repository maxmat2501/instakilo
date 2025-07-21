<?php 
session_start();
include "db.php";
if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
}
if (!isset($_SESSION['user_id'])) {
    header ("Location: login.php");
}
else {
    

    if (isset($_POST['submit'])) {
        $user_name = $_SESSION['user_name'];
        $user_email = $_SESSION['user_email'];
        $user_comment = $_POST['comment'];
        $sql = "INSERT INTO comments(post_id, user_name, email, comment) values ('$post_id', '$user_name', '$user_email','$user_comment')";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo "error {$conn->error}";
        }
        else {
            echo "comment added";
            header ("Location: displaypost.php");
        }
    }
   
}


?> 