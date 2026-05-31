<?php
include "includes/db.php";

$post_id = $_POST['post_id'];
$content = $_POST['content'];

$stmt = $conn->prepare("INSERT INTO comments (post_id, content) VALUES (?, ?)");
$stmt->bind_param("is", $post_id, $content);
$stmt->execute();

header("Location: post.php?id=$post_id");
?>