<?php 
session_start();
session_destroy();

if(!isset($_SESSION['user_id'])){
    header("location: login.php");
}
else{
    echo "welcome to dashboard, your name is : {$_SESSION['user_name']} and your role is: {$_SESSION['user_role']} <a href='logout.php'>log out</a> <a href='displaypost.php'>FEED</a>";
}

?>
