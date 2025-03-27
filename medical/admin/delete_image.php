<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: admin_login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "church_cms");
$id = $_POST['id'];

// Get image path before deleting
$result = $conn->query("SELECT image FROM images WHERE id = $id");
$image = $result->fetch_assoc()['image'];

// Delete from database
$conn->query("DELETE FROM images WHERE id = $id");

// Delete file
if (file_exists($image)) {
    unlink($image);
}

header("Location: admin.php");