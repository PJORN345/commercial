<?php
session_start();
$conn = new mysqli("localhost", "root", "", "church_cms");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Authentication check
if (!isset($_SESSION['loggedin'])) {
    header("Location: admin_login.php");
    exit;
}


if (isset($_POST['update_status'])) {
    $messageId = (int)$_POST['message_id'];
    $newStatus = $conn->real_escape_string($_POST['new_status']);
    
    $conn->query("UPDATE contact_messages SET status = '$newStatus' WHERE id = $messageId");
}

// Get contact messages
$messages = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC");

// Add to the existing POST handling
if (isset($_POST['delete_message'])) {
    $messageId = (int)$_POST['message_id'];
    $conn->query("DELETE FROM contact_messages WHERE id = $messageId");
    header("Location: admin.php");
    exit;
}




// Handle file uploads
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle image upload
    if (isset($_FILES['image'])) {
        $category = $_POST['category'];
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO images (category, image) VALUES (?, ?)");
            $stmt->bind_param("ss", $category, $target_file);
            $stmt->execute();
        }
    }
    
    // Handle team member addition
    if (isset($_POST['add_team'])) {
        $name = $_POST['name'];
        $position = $_POST['position'];
        $facebook = $_POST['facebook'];
        $linkedin = $_POST['linkedin'];
        $email = $_POST['email'];
        $photo = "../uploads/" . basename($_FILES["photo"]["name"]);
        
        move_uploaded_file($_FILES["photo"]["tmp_name"], $photo);
        
        $stmt = $conn->prepare("INSERT INTO team_members (name, position, photo, facebook, linkedin, email) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $position, $photo, $facebook, $linkedin, $email);
        $stmt->execute();
    }
}

// Get existing images
$images = $conn->query("SELECT * FROM images");
$team_members = $conn->query("SELECT * FROM team_members");



// Add to existing PHP handling
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle lab tests
    if(isset($_POST['add_test'])) {
        $stmt = $conn->prepare("INSERT INTO lab_tests (test_name, amount, duration) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $_POST['test_name'], $_POST['amount'], $_POST['duration']);
        $stmt->execute();
    }
    
    if(isset($_POST['delete_test'])) {
        $conn->query("DELETE FROM lab_tests WHERE id = " . (int)$_POST['delete_test']);
    }
    
    // Handle logo upload
    if(isset($_FILES['logo'])) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["logo"]["name"]);
        
        if(move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
            // Delete existing logo
            $conn->query("DELETE FROM images WHERE category='logo'");
            
            $stmt = $conn->prepare("INSERT INTO images (category, image) VALUES ('logo', ?)");
            $stmt->bind_param("s", $target_file);
            $stmt->execute();
        }
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
        .admin-container { max-width: 1200px; margin: 0 auto; }
        .section { margin-bottom: 40px; padding: 20px; border: 1px solid #ddd; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; }
        .image-card img { max-width: 100%; height: auto; }
        .team-card { padding: 10px; border: 1px solid #eee; }

        :root {
            --primary-color: #800000;
            --secondary-color: #FFD700;
            --accent-color: #004D40;
            --background: #f8f9fa;
            --text-dark: #2D2D2D;
            --text-light: #F5F5F5;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background);
            color: var(--text-dark);
            line-height: 1.6;
            padding: 2rem;
        }

        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        h1 {
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2.5rem;
        }

        .section {
            margin-bottom: 3rem;
            padding: 2rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        h2 {
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            font-size: 1.8rem;
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 0.5rem;
        }

        form {
            margin-bottom: 2rem;
            background: #fff;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text-dark);
            font-weight: 500;
        }

        input[type="text"],
        input[type="email"],
        select,
        textarea {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #e2e8f0;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        input[type="file"] {
            padding: 0.5rem;
            border: 2px dashed #e2e8f0;
            background: #f8fafc;
        }

        input:focus,
        select:focus {
            border-color: var(--primary-color);
            outline: none;
        }

        button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            text-transform: uppercase;
        }

        button:hover {
            background-color: #600000;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .image-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .image-card:hover {
            transform: translateY(-5px);
        }

        .image-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 2px solid #e2e8f0;
        }

        .image-card p {
            padding: 1rem;
            color: var(--text-dark);
            font-size: 0.9rem;
        }

        .team-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            text-align: center;
        }

        .team-card:hover {
            transform: translateY(-5px);
        }

        .team-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-bottom: 2px solid #e2e8f0;
        }

        .team-card h4 {
            margin: 1rem 0 0.5rem;
            color: var(--primary-color);
        }

        .team-card p {
            color: #666;
            margin-bottom: 1rem;
        }

        .delete-btn {
            background-color: #dc3545;
            margin-top: 1rem;
            width: 100%;
            border-radius: 0 0 6px 6px;
        }

        .delete-btn:hover {
            background-color: #bb2d3b;
        }

        /* Form Layout */
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }

        @media (max-width: 768px) {
            .admin-container {
                padding: 1rem;
            }

            .section {
                padding: 1rem;
            }

            h1 {
                font-size: 2rem;
            }

            .grid {
                grid-template-columns: 1fr;
            }
        }



        .services-table {
            margin: 50px auto;
            width: 90%;
            border-collapse: collapse;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        .services-table th,
        .services-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .services-table th {
            background-color: var(--primary-color);
            color: white;
        }

        .services-table tr:hover {
            background-color: #f5f5f5;
        }

        .table-container {
            padding: 50px 5%;
            background: white;
            margin: -50px 5% 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }




.messages-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2rem;
        }
        
        .messages-table th, 
        .messages-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        .messages-table th {
            background-color: var(--primary-color);
            color: white;
        }
        
        .status-unread { background-color: #fff3cd; }
        .status-read { background-color: #d4edda; }
        .status-replied { background-color: #d1ecf1; }
        
        .email-link {
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .email-link:hover {
            text-decoration: underline;
        }
        
        .status-form {
            display: inline-block;
            margin-left: 10px;
        }


    </style>
</head>
<body>
    <div class="admin-container">
        <h1>Church CMS Admin Panel</h1>


 <!-- Add this new section right after the main heading -->
        <div class="section">
            <h2>Contact Messages</h2>
            <table class="messages-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($message = $messages->fetch_assoc()): ?>
                    <tr class="status-<?= $message['status'] ?>">
                        <td><?= htmlspecialchars($message['name']) ?></td>
                        <td>
                            <a href="mailto:<?= $message['email'] ?>?subject=RE: <?= urlencode($message['subject'] ?? 'Your Message') ?>" 
                               class="email-link"
                               onclick="document.getElementById('status-form-<?= $message['id'] ?>').submit()">
                                <?= htmlspecialchars($message['email']) ?>
                            </a>
                        </td>
                        <td><?= nl2br(htmlspecialchars($message['message'])) ?></td>
                        <td><?= date('M j, Y H:i', strtotime($message['created_at'])) ?></td>
                        <td>
                            <form id="status-form-<?= $message['id'] ?>" method="POST" class="status-form">
                                <input type="hidden" name="message_id" value="<?= $message['id'] ?>">
                                <select name="new_status" onchange="this.form.submit()">
                                    <option value="unread" <?= $message['status'] == 'unread' ? 'selected' : '' ?>>Unread</option>
                                    <option value="read" <?= $message['status'] == 'read' ? 'selected' : '' ?>>Read</option>
                                    <option value="replied" <?= $message['status'] == 'replied' ? 'selected' : '' ?>>Replied</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="message_id" value="<?= $message['id'] ?>">
                                <button type="submit" name="delete_message" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>







        
        <!-- Image Upload Section -->
        <div class="section">
            <h2>Manage Images</h2>
            <form method="POST" enctype="multipart/form-data">
                <select name="category" required>
                    <option value="slider">Slider Image</option>
                    <option value="about-gallery">About Gallery</option>
                    <option value="left-gallery">Left Gallery</option>
                </select>
                <input type="file" name="image" required>
                <button type="submit">Upload Image</button>
            </form>

            <h3>Existing Images</h3>
            <div class="grid">
                <?php while($row = $images->fetch_assoc()): ?>
                <div class="image-card">
                    <img src="<?= $row['image'] ?>" alt="Uploaded Image">
                    <p>Category: <?= $row['category'] ?></p>
                    <form action="delete_image.php" method="POST">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button type="submit">Delete</button>
                    </form>
                </div>
                <?php endwhile; ?>
            </div>
        </div>

        <!-- Team Management Section -->
        <div class="section">
            <h2>Manage Team Members</h2>
            <form method="POST" enctype="multipart/form-data">
                <input type="text" name="name" placeholder="Full Name" required>
                <input type="text" name="position" placeholder="Position" required>
                <input type="text" name="facebook" placeholder="Facebook URL">
                <input type="text" name="linkedin" placeholder="LinkedIn URL">
                <input type="email" name="email" placeholder="Email" required>
                <input type="file" name="photo" accept="image/*" required>
                <button type="submit" name="add_team">Add Team Member</button>
            </form>

            <h3>Existing Team Members</h3>
            <div class="grid">
                <?php while($member = $team_members->fetch_assoc()): ?>
                <div class="team-card">
                    <img src="<?= $member['photo'] ?>" alt="<?= $member['name'] ?>" style="width:100%">
                    <h4><?= $member['name'] ?></h4>
                    <p><?= $member['position'] ?></p>
                    <form action="delete_team.php" method="POST">
                        <input type="hidden" name="id" value="<?= $member['id'] ?>">
                        <button type="submit">Delete</button>
                    </form>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

<!-- Add to admin.php -->
<div class="section">
    <h2>Manage Lab Tests</h2>
    <form method="POST">
        <input type="text" name="test_name" placeholder="Test Name" required>
        <input type="number" name="amount" placeholder="Amount" required>
        <input type="text" name="duration" placeholder="Duration" required>
        <button type="submit" name="add_test">Add Test</button>
    </form>

    <h3>Existing Tests</h3>
    <table class="services-table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>LAB TEST</th>
                    <th>AMOUNT (KES)</th>
                    <th>TIME</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM lab_tests ORDER BY id";
                $result = $conn->query($query);
                
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['test_name']}</td>
                            <td>{$row['amount']}</td>
                            <td>{$row['duration']}</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>




        <?php while($test = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $test['id'] ?></td>
            <td><?= $test['test_name'] ?></td>
            <td><?= $test['amount'] ?></td>
            <td><?= $test['duration'] ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="delete_test" value="<?= $test['id'] ?>">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<!-- Add logo upload section -->
<div class="section">
    <h2>Upload Logo</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="logo" accept="image/*" required>
        <button type="submit">Upload Logo</button>
    </form>
</div>



</body>
</html>