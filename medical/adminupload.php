<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Upload Images</title>
    <link rel="stylesheet" href="admin-style.css">
</head>
<body>
    <div class="admin-container">
        <h2>Upload Images for Church Army Medical Centre</h2>
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <label for="image">Select Image:</label>
            <input type="file" name="image" id="image" accept="image/*" required>
            
            <label for="category">Select Category:</label>
            <select name="category" id="category" required>
                <option value="slider">Slider</option>
                <option value="services">Services</option>
                <option value="gallery">Gallery</option>
            </select>
            
            <button type="submit" name="upload">Upload Image</button>
        </form>
    </div>

</body>
</html>
