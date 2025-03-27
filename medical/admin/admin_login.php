<?php
session_start();
$conn = new mysqli("localhost", "root", "", "church_cms");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['loggedin'] = true;
            header("Location: admin.php");
            exit;
        }
    }
    $error = "Invalid credentials";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Church Army Medical Centre - Admin Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>

 /* Add this at the top of your CSS */
    * {
        box-sizing: border-box;
    }


    body {
        margin: 0;
        padding: 0;
        background: linear-gradient(135deg, #800000, #600000);
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Arial', sans-serif;
    }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.2);
            width: 400px;
            text-align: center;
            /* Add these lines */
        margin: 0 20px; /* Prevents touching screen edges on mobile */
        overflow: hidden; /* Contains child elements */

        }

        .logo {
            width: 80px;
            margin-bottom: 20px;
        }

        h1 {
            color: #800000;
            margin-bottom: 30px;
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .input-group {
            position: relative;
            margin-bottom: 25px;
             width: 100%;
        }

        input {
            width: 100%;
            padding: 12px 20px 12px 40px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
               /* Fix the overflow */
        box-sizing: border-box; /* Include padding and border in width */
        margin: 0; /* Remove any default margins */
        }

        input:focus {
            border-color: #800000;
            outline: none;
            box-shadow: 0 0 8px rgba(128, 0, 0, 0.2);
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #800000;
        }

        button {
            background: #800000;
            color: white;
            border: none;
            padding: 14px 30px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        button:hover {
            background: #600000;
            transform: translateY(-2px);
        }

        .error-message {
            color: #dc3545;
            background: #f8d7da;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            display: none;
        }

        .error-message.active {
            display: block;
        }

        @media (max-width: 480px) {
            .login-container {
                width: 90%;
                padding: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>
            <i class="fas fa-hospital" style="margin-right: 10px;"></i>
            Church Army Medical Centre<br>
            <span style="font-size: 18px;">Admin Portal</span>
        </h1>

        <?php if(isset($error)): ?>
        <div class="error-message active">
            <?= $error ?>
        </div>
        <?php endif; ?>

        <form method="POST">
            <div class="input-group">
                <i class="fas fa-user input-icon"></i>
                <input type="text" name="username" placeholder="Username" required>
            </div>

            <div class="input-group">
                <i class="fas fa-lock input-icon"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button type="submit">
                <i class="fas fa-sign-in-alt" style="margin-right: 8px;"></i>
                Login
            </button>
        </form>
    </div>
</body>
</html>