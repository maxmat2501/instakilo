<?php 
session_start();
$user_id = $_SESSION['user_id'];
include "db.php";
include "header.php";
if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
}


if (!isset($_SESSION['user_id'])) {
    header ("Location: login.php");
}
else {
    if ($_SESSION['user_role'] == "author") {
        $sql = "SELECT * FROM categories";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            echo "error : {$conn->error}";
        }
        else {
            if (isset($_POST['submit'])) {
                $title = $_POST['title'];
                $content = $_POST['content'];
                $category_name = $_POST['category_name'];
                $name = $_FILES['image']['name'];
                $temp_location = $_FILES['image']['tmp_name'];
                $our_location = "image/";
                if (!empty($name)) {
                    move_uploaded_file($temp_location, $our_location.$name);
                }
                $sql1 = "SELECT id FROM categories WHERE name = '$category_name'";
                $result1 = mysqli_query($conn, $sql1);
                if ($result1->num_rows>0) {
                    $row = mysqli_fetch_assoc($result1);
                    $idcategory = $row['id'];
                }
                $sql2 = "Update posts set title='$title', content = '$content',author_id = '$user_id', category_id= '$idcategory' where id='$post_id'";
                $result2 = mysqli_query($conn, $sql2);
                if ($result2) {
                    echo "post updated successfully";
                }
            }
        }
       
    } 
    else {
            header("Location: dashboard.php");
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
    <form action="updatepost.php?post_id=<?php echo $post_id ?>" method="post" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Give your post a title!" required>
        <textarea name="content" placeholder="Add an extra description here!" required></textarea>

        <select name="category_name">
            <?php while ($row = mysqli_fetch_assoc($result) ) { ?>
            <option value="<?php echo "{$row['name']}"; ?>"><?php echo "{$row['name']}"; ?></option>
            <?php } ?>
        </select>

        <input type="file" name="image" required>
        <input type="submit" name="submit" value="update post">
    </form>
</body>
</html>