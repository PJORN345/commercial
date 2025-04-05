
<?php
include 'db_connect.php';

// Fetch logo from database
$logoQuery = "SELECT image FROM images WHERE category = 'logo' LIMIT 1";
$logoResult = $conn->query($logoQuery);
$logoPath = null;

if ($logoResult && $logoResult->num_rows > 0) {
    $logoData = $logoResult->fetch_assoc();
    $logoPath = "../medical/uploads/" . basename($logoData['image']);
}




// Fetch images from database
$query = "SELECT * FROM image_slider";
$result = $conn->query($query);
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Church Army Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background-color: white;
            color: #000;
        }

        /* Top Bar */
        .top-bar {
            background: linear-gradient(45deg, maroon, red);
            color: white;
            padding: 10px 0;
            font-size: 14px;
        }
        .top-bar .contact-info {
            display: flex;
            gap: 15px;
        }
        .top-bar .btn-donate {
            background-color: gold;
            color: black;
            padding: 7px 15px;
            border-radius: 5px;
            font-weight: bold;
            transition: 0.3s;
        }
        .top-bar .btn-donate:hover {
            background-color: darkgoldenrod;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(90deg, maroon, darkred);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .navbar a {
            color: white !important;
            font-weight: bold;
            transition: 0.3s;
        }
        .navbar a:hover {
            color: gold !important;
            transform: scale(1.05);
        }
       .dropdown-menu {
    background: linear-gradient(45deg, maroon, darkred);
    border: none;
    padding: 10px;
}
.dropdown-menu a {
    color: white !important;
    padding: 10px 15px;
    transition: 0.3s;
    display: flex;
    align-items: center;
}
.dropdown-menu a i {
    margin-right: 8px;
}
.dropdown-menu a:hover {
    background: darkred;
    color: gold !important;
    transform: scale(1.05);
}



        /* Hero Section */
        .hero {
            background: url('https://source.unsplash.com/1600x900/?church') center/cover;
            color: white;
            text-align: center;
            padding: 100px 20px;
            position: relative;
        }
        .hero::before {
            content: "";
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }
        .hero h1, .hero p, .hero button {
            position: relative;
            z-index: 1;
        }
        .hero h1 {
            font-size: 48px;
            font-weight: bold;
            animation: fadeInDown 1s ease-in-out;
        }
        .hero p {
            font-size: 18px;
            animation: fadeInUp 1.2s ease-in-out;
        }
        .btn-primary, .btn-danger {
            transition: 0.3s;
        }
        .btn-primary:hover, .btn-danger:hover {
            transform: scale(1.1);
        }

        /* Services Section */
        .services {
            padding: 50px 20px;
        }
        .services h2 {
            text-align: center;
            color: maroon;
            margin-bottom: 30px;
        }
        .card {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s;
        }
        .card:hover {
            transform: scale(1.05);
        }


        .service-card {
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    border-radius: 15px;
}
.service-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}


        /* Footer */
        .footer {
            background: linear-gradient(90deg, maroon, darkred);
            color: white;
            padding: 20px;
            text-align: center;
            font-weight: bold;
        }

        /* Animations */
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        #imageSlider {
    margin-top: 20px;
}
.carousel-item img {
    height: 500px; /* Adjust for consistency */
    object-fit: cover;
}
.carousel-caption {
    background: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
    padding: 15px;
    border-radius: 10px;
}



/* Contact Section */
.text-maroon {
    color: maroon;
}

.btn-maroon {
    background: maroon;
    color: white;
    padding: 10px 25px;
}

.btn-maroon:hover {
    background: darkred;
    color: white;
}

/* Footer Styles */
.footer {
    background: linear-gradient(90deg, maroon, darkred);
    color: white;
}

.footer h5 {
    color: gold;
    margin-bottom: 20px;
}

.social-icons a {
    transition: transform 0.3s;
}

.social-icons a:hover {
    transform: translateY(-5px);
    color: gold !important;
}

.list-unstyled li {
    margin-bottom: 8px;
}


/* Events Section */
.events-section {
    background-color: #f8f9fa;
}

.event-card {
    transition: transform 0.3s ease;
    min-width: 300px;
    margin-right: 15px;
}

.event-card:hover {
    transform: translateY(-5px);
}

.event-description {
    cursor: pointer;
    color: maroon;
    transition: color 0.3s ease;
}

.event-description:hover {
    color: darkred;
}

/* Scrollable row */
.row-flex-nowrap {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: thin;
}

/* Custom scrollbar */
.row-flex-nowrap::-webkit-scrollbar {
    height: 8px;
}

.row-flex-nowrap::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.row-flex-nowrap::-webkit-scrollbar-thumb {
    background: maroon;
    border-radius: 4px;
}


    </style>
</head>



<body>



    <!-- Top Bar -->
    <div class="top-bar d-flex justify-content-between align-items-center px-4">
        <div class="contact-info">
            <span><i class="fas fa-envelope"></i> info@churcharmy.org</span>
            <span><i class="fas fa-phone"></i> +254 721-326-677 or +254 733 228 144</span>
        </div>
        <button class="btn-donate">Donate to Us</button>
    </div>

   <!-- Updated Navbar -->
<nav class="navbar navbar-expand-lg">
      <div class="container">
        <a class="navbar-brand" href="#">
            <?php if($logoPath): ?>
                <img src="<?= htmlspecialchars($logoPath) ?>" alt="Church Logo" style="height: 40px; margin-right: 10px;">
            <?php endif; ?>
            <i class="fas fa-church"></i> Church Army Africa
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-home"></i> Home</a></li>

                <!-- Dropdown Menu for Our Story -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="ourStoryDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-book"></i> Our Story
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-bullseye"></i> Mission, Vision & Core Values</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user-tie"></i> General Secretary</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user-shield"></i> CAA Board Chairman</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-users"></i> CAA Secretariat</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-clipboard-list"></i> CAA Board</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-map-marked-alt"></i> CAA Regions</a></li>
                    </ul>
                </li>

                <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-newspaper"></i> News & Events</a></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-hands-helping"></i> Get Involved</a></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-envelope"></i> Contact Us</a></li>
            </ul>
        </div>
    </div>
</nav>

<section id="imageSlider" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <?php
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            echo '<button type="button" data-bs-target="#imageSlider" data-bs-slide-to="' . $i . '" ' . ($i == 0 ? 'class="active"' : '') . '></button>';
            $i++;
        }
        ?>
    </div>

    <div class="carousel-inner">
        <?php
        $result->data_seek(0); // Reset pointer
        $first = true;
        while ($row = $result->fetch_assoc()) {
            $imagePath = "admin/uploads/" . $row['image_url']; // Ensure correct path
            echo '<div class="carousel-item ' . ($first ? 'active' : '') . '" data-bs-interval="5000">
                    <img src="' . htmlspecialchars($imagePath) . '" 
                         class="d-block w-100" 
                         alt="' . htmlspecialchars($row['alt_text'] ?? 'Image') . '">
                    <div class="carousel-caption">
                        <h5>' . htmlspecialchars($row['title']) . '</h5>
                        <p>' . htmlspecialchars($row['description']) . '</p>
                    </div>
                  </div>';
            $first = false;
        }
        ?>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#imageSlider" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#imageSlider" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</section>



<?php $conn->close(); ?>





<section class="services py-5">
    <div class="container">
        <h2 class="text-center mb-4 text-uppercase fw-bold" style="color: maroon;">Our Services</h2>
        <div class="row g-4">
            <!-- Medical Centre -->
            <div class="col-md-4">
                <div class="card service-card shadow-lg border-0">
                    <div class="card-body text-center">
                        <i class="fas fa-hospital fa-3x text-danger mb-3"></i>
                        <h5 class="card-title">Medical Centre</h5>
                        <p class="card-text">Providing quality healthcare services with compassion.</p>
                       <a href="/comercial/medical/index.php" class="btn btn-danger">Learn More</a>
                    </div>
                </div>
            </div>

            <!-- Carlile College -->
            <div class="col-md-4">
                <div class="card service-card shadow-lg border-0">
                    <div class="card-body text-center">
                        <i class="fas fa-graduation-cap fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Carlile College</h5>
                        <p class="card-text">Empowering students through theological and leadership training.</p>
                        <button class="btn btn-primary">Learn More</button>
                    </div>
                </div>
            </div>

            <!-- Academy -->
            <div class="col-md-4">
                <div class="card service-card shadow-lg border-0">
                    <div class="card-body text-center">
                        <i class="fas fa-school fa-3x text-warning mb-3"></i>
                        <h5 class="card-title">Academy</h5>
                        <p class="card-text">Delivering quality education for young minds.</p>
                        <button class="btn btn-warning">Learn More</button>
                    </div>
                </div>
            </div>

            <!-- Centre for Urban Mission (C.U.M) -->
            <div class="col-md-4">
                <div class="card service-card shadow-lg border-0">
                    <div class="card-body text-center">
                        <i class="fas fa-city fa-3x text-success mb-3"></i>
                        <h5 class="card-title">Centre for Urban Mission (C.U.M)</h5>
                        <p class="card-text">Engaging communities to transform urban life.</p>
                        <button class="btn btn-success">Learn More</button>
                    </div>
                </div>
            </div>

            <!-- Missions -->
            <div class="col-md-4">
                <div class="card service-card shadow-lg border-0">
                    <div class="card-body text-center">
                        <i class="fas fa-hands-helping fa-3x text-info mb-3"></i>
                        <h5 class="card-title">Missions</h5>
                        <p class="card-text">Spreading the message of hope and faith.</p>
                        <button class="btn btn-info">Learn More</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Latest News & Events Section -->
<section class="events-section py-5">
    <div class="container">
        <h2 class="text-center mb-5 text-uppercase fw-bold" style="color: maroon;">Latest News & Events</h2>
        
        <div class="row flex-nowrap overflow-auto pb-3" style="scroll-snap-type: x mandatory;">
            <?php
            include 'db_connect.php';
            $eventsQuery = "SELECT * FROM images WHERE category='event' ORDER BY event_date DESC";
            $eventsResult = $conn->query($eventsQuery);
            
            while($event = $eventsResult->fetch_assoc()):
                $imagePath = "admin/uploads/" . htmlspecialchars(basename($event['image']));
            ?>
            <div class="col-12 col-md-4 col-lg-3" style="scroll-snap-align: start;">
                <div class="card event-card h-100 border-0 shadow-lg mb-4">
                    <img src="<?= $imagePath ?>" class="card-img-top" alt="<?= htmlspecialchars($event['title']) ?>" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <small class="text-muted"><?= date('M d, Y', strtotime($event['event_date'])) ?></small>
                        <h5 class="card-title mt-2"><?= htmlspecialchars($event['title']) ?></h5>
                        <p class="card-text event-description" 
                           data-bs-toggle="modal" 
                           data-bs-target="#eventModal"
                           data-title="<?= htmlspecialchars($event['title']) ?>"
                           data-date="<?= date('F j, Y', strtotime($event['event_date'])) ?>"
                           data-description="<?= htmlspecialchars($event['description']) ?>"
                           data-image="<?= $imagePath ?>">
                            <?= substr(htmlspecialchars($event['description']), 0, 100) ?>...
                        </p>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<!-- Event Modal -->
<div class="modal fade" id="eventModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <img id="eventModalImage" src="" class="img-fluid rounded" alt="Event Image">
                        <p class="text-muted mt-2" id="eventModalDate"></p>
                    </div>
                    <div class="col-md-6">
                        <p id="eventModalDescription"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>






<!-- Add after Services section -->
<section class="contact-section py-5 bg-light">
    <div class="container">
        <div class="row g-5">
            <!-- Contact Info -->
            <div class="col-md-5">
                <h3 class="text-maroon mb-4">Contact Information</h3>
                <div class="contact-info">
                    <div class="mb-4">
                        <h5><i class="fas fa-map-marker-alt me-2"></i>Location</h5>
                        <p>Along Jogoo Rd, Nairobi, Kenya</p>
                    </div>
                    <div class="mb-4">
                        <h5><i class="fas fa-envelope me-2"></i>Email</h5>
                        <p>info@churcharmyafrica.net</p>
                    </div>
                    <div class="mb-4">
                        <h5><i class="fas fa-phone me-2"></i>Call</h5>
                        <p>+254 721-326-677<br>+254 733 228 144</p>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-md-7">
                <h3 class="text-maroon mb-4">Send Us a Message</h3>
                <form action="send-message.php" method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                        </div>
                        <div class="col-md-6">
                            <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                        </div>
                        <div class="col-12">
                            <input type="text" name="subject" class="form-control" placeholder="Subject" required>
                        </div>
                        <div class="col-12">
                            <textarea name="message" class="form-control" rows="5" placeholder="Your Message" required></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-maroon">Send Message</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>








    <!-- Footer -->
    <!-- Updated Footer -->
<!-- Updated Footer -->
<footer class="footer py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Combined Links Column -->
            <div class="col-md-4">
                <div class="row">
                    <!-- Useful Links -->
                    <div class="col-6">
                        <h5>Useful Links</h5>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-light"><i class="fas fa-chevron-right me-2"></i>Home</a></li>
                            <li><a href="#" class="text-light"><i class="fas fa-chevron-right me-2"></i>About us</a></li>
                            <li><a href="#" class="text-light"><i class="fas fa-chevron-right me-2"></i>Our History</a></li>
                            <li><a href="#" class="text-light"><i class="fas fa-chevron-right me-2"></i>Latest News & Events</a></li>
                        </ul>
                    </div>
                    
                    <!-- Services Links -->
                    <div class="col-6">
                        <h5>Our Services</h5>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-light"><i class="fas fa-chevron-right me-2"></i>Carlile College</a></li>
                            <li><a href="#" class="text-light"><i class="fas fa-chevron-right me-2"></i>Academy</a></li>
                            <li><a href="#" class="text-light"><i class="fas fa-chevron-right me-2"></i>Health Center</a></li>
                            <li><a href="#" class="text-light"><i class="fas fa-chevron-right me-2"></i>Mission</a></li>
                            <li><a href="#" class="text-light"><i class="fas fa-chevron-right me-2"></i>CUM</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Contact Details -->
            <div class="col-md-4">
                <h5>Contact Details</h5>
                <div class="text-light">
                    <p>Along Jogoo Rd, Nairobi, Kenya</p>
                    <p>Phone: +254 721-326-677<br>+254 733 228 144</p>
                    <p>Email: info@churcharmyafrica.net</p>
                </div>
            </div>

            <!-- About Us -->
            <div class="col-md-4">
                <h5>About Us</h5>
                <p class="text-light">Church Army being missionary and Evangelistic in its nature, Community worship defines our identity as a Christian institution.</p>
            </div>
        </div>

        <!-- Social Media & Copyright -->
        <div class="row mt-4">
            <div class="col-12 text-center">
                <div class="social-icons">
                    <a href="#" class="text-light mx-3"><i class="fab fa-facebook fa-2x"></i></a>
                    <a href="#" class="text-light mx-3"><i class="fab fa-twitter fa-2x"></i></a>
                    <a href="#" class="text-light mx-3"><i class="fab fa-instagram fa-2x"></i></a>
                    <a href="#" class="text-light mx-3"><i class="fab fa-linkedin fa-2x"></i></a>
                    <a href="#" class="text-light mx-3"><i class="fab fa-youtube fa-2x"></i></a>
                </div>
                <p class="mb-0 mt-3">&copy; 2025 Church Army. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    const eventModal = document.getElementById('eventModal');
    eventModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const title = button.getAttribute('data-title');
        const date = button.getAttribute('data-date');
        const description = button.getAttribute('data-description');
        const image = button.getAttribute('data-image');

        const modalTitle = eventModal.querySelector('.modal-title');
        const modalDate = eventModal.querySelector('#eventModalDate');
        const modalDescription = eventModal.querySelector('#eventModalDescription');
        const modalImage = eventModal.querySelector('#eventModalImage');

        modalTitle.textContent = title;
        modalDate.textContent = date;
        modalDescription.textContent = description;
        modalImage.src = image;
    });
});
</script>
</body>
</html>
