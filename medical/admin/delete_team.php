<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: admin_login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "church_cms");
$id = $_POST['id'];

// Get photo path before deleting
$result = $conn->query("SELECT photo FROM team_members WHERE id = $id");
$photo = $result->fetch_assoc()['photo'];

// Delete from database
$conn->query("DELETE FROM team_members WHERE id = $id");

// Delete file
if (file_exists($photo)) {
    unlink($photo);
}

header("Location: admin.php");