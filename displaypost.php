<?php 
session_start();
include "db.php";
include "header.php";

if (!isset($_SESSION['user_id'])) {
    header ("Location: login.php");
}

// Requête pour récupérer les posts avec les noms d'auteurs
$sql = "SELECT posts.*, users.name AS author_name
        FROM posts
        JOIN users ON posts.author_id = users.id
        ORDER BY posts.id DESC";

$results = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fil d'actualité</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<body>

<?php if (mysqli_num_rows($results) > 0): ?>
    <?php while ($row = mysqli_fetch_assoc($results)): ?>
        <?php
            $title = htmlspecialchars($row['title']);
            $content = htmlspecialchars($row['content']);
            $image = htmlspecialchars($row['image']);
            $post_id = $row['id'];
            $author_name = htmlspecialchars($row['author_name']);
        ?>
        <div class="post-card">
            <div class="post-header">
                <img src="image/avatar.jpg" alt="avatar" class="avatar"> 
                <span class="username"><?php echo $author_name; ?></span>
            </div>
            <img src="image/<?php echo $image; ?>" alt="Image du post" class="post-image">
            <div class="post-content">
                <h2 class="post-title"><?php echo $title; ?></h2>
                <p class="post-description"><?php echo $content; ?></p>

                <a href="updatepost.php?post_id=<?php echo $post_id; ?>">Modifier</a> |
                <a href="deletepost.php?post_id=<?php echo $post_id; ?>">Supprimer</a>
            </div><br>

            <div class="comments">
                <form action="insertcomment.php?post_id=<?php echo $post_id; ?>" method="POST">
                    <textarea name="comment" placeholder="Écrire un commentaire..."></textarea>
                    <input type="submit" name="submit" value="Commenter">
                </form>

                <?php
                $sql2 = "SELECT * FROM comments WHERE post_id='$post_id'";
                $results2 = mysqli_query($conn, $sql2);
                while ($row2 = mysqli_fetch_assoc($results2)):
                    $user_name = htmlspecialchars($row2['user_name']);
                    $comment = htmlspecialchars($row2['comment']);
                ?><br>
                    <p><strong><?php echo $user_name; ?> :</strong> <?php echo $comment; ?></p>

                    


                <?php endwhile; ?>
            </div>
            <?php
                    // Vérifie si l'utilisateur a liké ce post
                    $user_id = $_SESSION['user_id'];
                    $like_check = mysqli_query($conn, "SELECT * FROM likes WHERE post_id = $post_id AND user_id = $user_id");
                    $liked = mysqli_num_rows($like_check) > 0;

                    // Compte le nombre total de likes
                    $like_count_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM likes WHERE post_id = $post_id");
                    $like_count = mysqli_fetch_assoc($like_count_query)['total'];
                    ?>

                    <div class="like-container">
                        <span class="heart <?php echo $liked ? 'liked' : ''; ?>" id="heart-<?php echo $post_id; ?>" onclick="toggleLike(<?php echo $post_id; ?>)">
                            &#10084;
                        </span>
                        <span id="count-<?php echo $post_id; ?>"><?php echo $like_count; ?></span>
                    </div>
        </div>

        
        
    <?php endwhile; ?>
<?php else: ?>
    <p>Aucun post pour le moment.</p>
<?php endif; ?>

<div class="bottom-bar">
    <a href="insertpost.php" class="create-post-btn" title="Créer un post">+</a>
</div>
<script>
function toggleLike(postId) {
    fetch('like.php?post_id=' + postId)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const heart = document.getElementById('heart-' + postId);
                const count = document.getElementById('count-' + postId);
                heart.classList.toggle('liked', data.liked);
                count.textContent = data.likes;
            } else {
                alert(data.message || "Erreur");
            }
        });
}
</script>
</body>
</html>
