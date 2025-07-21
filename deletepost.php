<?php 
session_start();
include "db.php";
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}
else {
    if ($_SESSION['user_role'] == "subscriber") {
        header("Location: dashboard.php");
    }
    else {
        $post_id = $_GET['post_id'];
        $sql = "delete from posts where id = '$post_id' AND author_id = '{$_SESSION['user_id']}'";
        $result = mysqli_query($conn, $sql);
        $sql2 = "delete from likes where post_id = '$post_id'";
        $result2 = mysqli_query($conn, $sql2);

        if (!$result) {
            echo "error: {$conn->error}";
        }
        else {
            echo "Deleted successfully";
            header("Location: displaypost.php");
        }
    }
}


?> 