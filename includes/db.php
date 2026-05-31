<?php
$conn = new mysqli("***", "***", "***", "***");

if ($conn->connect_error) {
    die("Chyba připojení: " . $conn->connect_error);
}
?>