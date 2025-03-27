<?php
$conn = new mysqli("localhost", "root", "", "church_cms");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = 'admin'; // Change if needed
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $conn->query("DELETE FROM users WHERE username = 'admin'");
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    
    echo "Admin user created! Password: ".$_POST['password'];
}
?>

<form method="POST">
    <input type="password" name="password" placeholder="Enter new password" required>
    <button type="submit">Create Admin</button>
</form>