<?php
include "includes/db.php";

$post_id = (int)$_GET['id'];
$type = $_GET['type'];
$ip = $_SERVER['REMOTE_ADDR'];

$value = ($type === "up") ? 1 : -1;

// zjisti jestli už hlasoval
$stmt = $conn->prepare("SELECT value FROM votes WHERE post_id = ? AND ip = ?");
$stmt->bind_param("is", $post_id, $ip);
$stmt->execute();
$res = $stmt->get_result();
$existing = $res->fetch_assoc();

if ($existing) {
    if ($existing['value'] == $value) {
        // klikne znovu → zruší hlas
        $stmt = $conn->prepare("DELETE FROM votes WHERE post_id = ? AND ip = ?");
        $stmt->bind_param("is", $post_id, $ip);
        $stmt->execute();

        $conn->query("UPDATE posts SET votes = votes - $value WHERE id = $post_id");
    } else {
        // změna hlasu
        $diff = $value - $existing['value'];

        $stmt = $conn->prepare("UPDATE votes SET value = ? WHERE post_id = ? AND ip = ?");
        $stmt->bind_param("iis", $value, $post_id, $ip);
        $stmt->execute();

        $conn->query("UPDATE posts SET votes = votes + $diff WHERE id = $post_id");
    }
} else {
    // nový hlas
    $stmt = $conn->prepare("INSERT INTO votes (post_id, ip, value) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $post_id, $ip, $value);
    $stmt->execute();

    $conn->query("UPDATE posts SET votes = votes + $value WHERE id = $post_id");
}

header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
?>