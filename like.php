<?php
session_start();
header('Content-Type: application/json');
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not connected']);
    exit;
}

$postId = intval($_GET['post_id']);
$userId = $_SESSION['user_id'];

// Vérifie si l'utilisateur a déjà liké le post
$check = $conn->prepare("SELECT id FROM likes WHERE post_id = ? AND user_id = ?");
$check->bind_param("ii", $postId, $userId);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    // Déjà liké -> on enlève
    $delete = $conn->prepare("DELETE FROM likes WHERE post_id = ? AND user_id = ?");
    $delete->bind_param("ii", $postId, $userId);
    $delete->execute();
    $liked = false;
} else {
    // Pas encore liké -> on ajoute
    $insert = $conn->prepare("INSERT INTO likes (post_id, user_id) VALUES (?, ?)");
    $insert->bind_param("ii", $postId, $userId);
    $insert->execute();
    $liked = true;
}

// Compter les likes actuels
$count = $conn->prepare("SELECT COUNT(*) FROM likes WHERE post_id = ?");
$count->bind_param("i", $postId);
$count->execute();
$count->bind_result($totalLikes);
$count->fetch();

echo json_encode([
    'success' => true,
    'liked' => $liked,
    'likes' => $totalLikes
]);
?>
