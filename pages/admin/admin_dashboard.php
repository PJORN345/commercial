<?php
include 'db_connect.php';


// Handle Event Image Upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['upload_event'])) {
    $target_dir = "uploads/";
    $title = $_POST['title'];
    $description = $_POST['description'];
    $event_date = $_POST['event_date'];
    
    // Create uploads directory if not exists
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $filename = basename($_FILES["image"]["name"]);

    // Validate image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO images (image, category, title, description, event_date) 
                    VALUES (?, 'event', ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $filename, $title, $description, $event_date);

            if ($stmt->execute()) {
                echo "<div class='alert alert-success'>Event uploaded successfully!</div>";
            } else {
                echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Failed to upload image.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>File is not an image.</div>";
    }
}

// Handle Event Deletion
if (isset($_GET['delete_event'])) {
    $id = intval($_GET['delete_event']);
    
    // Get image details
    $stmt = $conn->prepare("SELECT image FROM images WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($image);
    $stmt->fetch();
    $stmt->close();

    // Delete file and database record
    if ($image && file_exists("uploads/" . $image)) {
        unlink("uploads/" . $image);
    }
    
    $stmt = $conn->prepare("DELETE FROM images WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    
    echo "<script>alert('Event deleted successfully!'); window.location.href='admin_dashboard.php';</script>";
}

// Fetch events
$events = $conn->query("SELECT * FROM images WHERE category='event' ORDER BY event_date DESC");





if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $target_dir = "uploads/";
    $title = $_POST['title'];
    $description = $_POST['description'];
    
    // Ensure the uploads directory exists
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $filename = basename($_FILES["image"]["name"]); // Only store filename

   
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Store only the filename in database
            $sql = "INSERT INTO image_slider (image_url, title, description) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $filename, $title, $description);

            if ($stmt->execute()) {
                echo "Image uploaded successfully!";
            } else {
                echo "Error: " . $stmt->error;
            }
        } 
    
    }




// Handle Image Deletion
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    
    // Retrieve image path
    $stmt = $conn->prepare("SELECT image_url FROM image_slider WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($image_url);
    $stmt->fetch();
    $stmt->close();

    // Delete the image file
    if ($image_url && file_exists(realpath($image_url))) {
        unlink(realpath($image_url));
    }

    // Delete from database
    $stmt = $conn->prepare("DELETE FROM image_slider WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<script>alert('Image deleted successfully!'); window.location='admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error deleting image.');</script>";
    }
    $stmt->close();
}

// Fetch all images
$images = $conn->query("SELECT * FROM image_slider ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById('uploadSection').style.display = 'block';
            document.getElementById('manageSection').style.display = 'none';
        });

        function showSection(section) {
            const sections = ['upload', 'manage', 'events', 'manage_events'];
            sections.forEach(sec => {
                document.getElementById(sec + 'Section').style.display = 
                    section === sec ? 'block' : 'none';
            });
        }
    </script>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
       <!-- Modified Sidebar -->
<nav class="col-md-3 col-lg-2 d-md-block bg-dark text-white sidebar">
    <div class="position-sticky">
        <h3 class="text-center py-3">Admin Panel</h3>
        <ul class="nav flex-column">
            <!-- Existing links -->
            <li class="nav-item">
                <a class="nav-link text-white" href="#" onclick="showSection('upload')">📤 Upload Slider</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="#" onclick="showSection('manage')">📂 Manage Slider</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="#" onclick="showSection('events')">📅 Upload Event</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="#" onclick="showSection('manage_events')">🗓️ Manage Events</a>
            </li>
            
            <!-- New Medical Admin Link -->
            <li class="nav-item">
                <a class="nav-link text-white" href="/comercial/medical/admin/admin_login.php">
                    ⚕️ Medical Admin
                </a>
            </li>
        </ul>
    </div>
</nav>
        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            

<!-- New Event Upload Section -->
            <div id="eventsSection" class="mt-4" style="display: none;">
                <h2>Upload New Event</h2>
                <form action="admin_dashboard.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Event Title:</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Event Date:</label>
                        <input type="date" name="event_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Event Description:</label>
                        <textarea name="description" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Event Image:</label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                    </div>
                    <button type="submit" name="upload_event" class="btn btn-primary">Upload Event</button>
                </form>
            </div>

            <!-- New Events Management Section -->
            <div id="manage_eventsSection" class="mt-4" style="display: none;">
                <h2>Manage Events</h2>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($event = $events->fetch_assoc()): ?>
                            <tr>
                                <td><img src="uploads/<?= htmlspecialchars($event['image']) ?>" width="100"></td>
                                <td><?= htmlspecialchars($event['title']) ?></td>
                                <td><?= date('M d, Y', strtotime($event['event_date'])) ?></td>
                                <td><?= htmlspecialchars(substr($event['description'], 0, 50)) ?>...</td>
                                <td>
                                    <a href="admin_dashboard.php?delete_event=<?= $event['id'] ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Delete this event?')">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>






            <!-- Upload Section -->
            <div id="uploadSection" class="mt-4">
                <h2>Upload Slider Image</h2>
                <form action="admin_dashboard.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Title:</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description:</label>
                        <textarea name="description" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Choose Image:</label>
                        <input type="file" name="image" class="form-control" required>
                    </div>
                    <button type="submit" name="upload" class="btn btn-primary">Upload Image</button>
                </form>
            </div>

            <!-- Manage Images Section -->
            <div id="manageSection" class="mt-4" style="display: none;">
                <h2>Manage Slider Images</h2>
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $images->fetch_assoc()): ?>
                        <tr>
                            <td><img src="<?= htmlspecialchars($row['image_url']); ?>" width="100"></td>
                            <td><?= htmlspecialchars($row['title']); ?></td>
                            <td><?= htmlspecialchars($row['description']); ?></td>
                            <td>
                                <a href="admin_dashboard.php?delete=<?= intval($row['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

        </main>
    </div>
</div>

</body>
</html>

<?php $conn->close(); ?>
