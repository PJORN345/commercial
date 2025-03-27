<?php
session_start();
$conn = new mysqli("localhost", "root", "", "church_cms");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $subject = $conn->real_escape_string($_POST['subject'] ?? 'No Subject');
    $message = $conn->real_escape_string($_POST['message']);

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);
    
    if ($stmt->execute()) {
        header("Location: contactus.php?status=success");
    } else {
        header("Location: contactus.php?status=error");
    }
    
    $stmt->close();
}

$conn->close();
?>