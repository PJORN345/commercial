<?php 
$conn = new mysqli("localhost", "root", "", "church_cms");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Church Army Medical Centre - Quality Healthcare Services">
    <title>Church Army Medical Centre</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --primary-color: #800000;
            --secondary-color: #FFD700;
            --accent-color: #004D40;
            --text-dark: #2D2D2D;
            --text-light: #F5F5F5;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: var(--text-dark);
        }

        header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #600000 100%);
            color: white;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }

        .top-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 5%;
            background: rgba(0, 0, 0, 0.1);
        }

        .contact-info span {
            margin-right: 25px;
            font-size: 0.9em;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .social-icons a {
            color: var(--text-light);
            margin-left: 15px;
            transition: transform 0.3s;
        }

        .social-icons a:hover {
            transform: translateY(-2px);
        }

        .logo {
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 1px;
            background: linear-gradient(to right, #FFD700, #FFFFFF);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 5%;
}

.nav-links {
    margin-left: auto; /* Pushes links to the right */
    display: flex;
    gap: 15px;
    margin: 0;
}

        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            padding: 8px 15px;
            border-radius: 5px;
            transition: all 0.3s;
            position: relative;
             white-space: nowrap;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--secondary-color);
            transition: width 0.3s;
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .slider {
            height: 70vh;
            position: relative;
            overflow: hidden;
            border-radius: 0 0 30px 30px;
        }

        .slider-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.3));
        }

        .slider img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            animation: slide 15s infinite;
        }

        @keyframes slide {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .hero {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            padding: 80px 5%;
            background: white;
            margin: -50px 5% 0;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1;
        }

        .hero-text h1 {
            font-size: 2.8rem;
            line-height: 1.2;
            color: var(--primary-color);
            margin-bottom: 25px;
        }

        .hero-text p {
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 30px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 15px 35px;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: transform 0.3s;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .left-images {
            display: grid;
            gap: 20px;
        }

        .left-images img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 15px;
            transition: transform 0.3s;
        }

        .left-images img:hover {
            transform: translateY(-5px);
        }

        #mission-vision {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            padding: 80px 5%;
            background: linear-gradient(45deg, #FFF8E1, #FFFFFF);
        }

        .mission, .vision, .motto {
            padding: 40px;
            background: white;
            border-radius: 20px;
            text-align: center;
            transition: transform 0.3s;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .mission:hover, .vision:hover, .motto:hover {
            transform: translateY(-10px);
        }

        .mission h2, .vision h2, .motto h2 {
            color: var(--primary-color);
            margin: 20px 0;
        }



 .welcome-section {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 40px;
            padding: 50px 5%;
            background: white;
            border-radius: 20px;
            margin: -50px 5% 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .welcome-images {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            height: fit-content;
        }

        .welcome-images img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 15px;
            transition: transform 0.3s;
        }

        .welcome-content {
            position: relative;
        }

        .nhif-badge {
            position: absolute;
            top: -25px;
            right: 0;
            background: var(--primary-color);
            color: white;
            padding: 10px 20px;
            border-radius: 30px;
            font-size: 0.9em;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            padding: 50px 5%;
            background: linear-gradient(45deg, #f8f9fa, #ffffff);
        }

        .service-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            transition: transform 0.3s;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .service-card:hover {
            transform: translateY(-10px);
        }

        .service-card i {
            font-size: 2.5em;
            color: var(--primary-color);
            margin-bottom: 20px;
        }





 /* Add to existing CSS */
    footer {
        padding: 60px 5% 30px;
        background: var(--primary-color);
        margin-top: 80px;
    }

    .footer-columns {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 40px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .footer-col h3 {
        color: var(--secondary-color);
        margin-bottom: 25px;
        font-size: 1.3rem;
    }

    .footer-col p {
        font-size: 0.95rem;
        line-height: 1.7;
        color: rgba(255,255,255,0.9);
    }

    .contact-list li {
        color: rgba(255,255,255,0.9);
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .footer-nav li {
        margin-bottom: 12px;
    }

    .footer-nav a {
        color: rgba(255,255,255,0.9);
        text-decoration: none;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .footer-nav a:hover {
        color: var(--secondary-color);
        transform: translateX(5px);
    }

    .footer-bottom {
        text-align: center;
        margin-top: 50px;
        padding-top: 30px;
        border-top: 1px solid rgba(255,255,255,0.1);
    }

    @media (max-width: 768px) {
        .footer-columns {
            grid-template-columns: 1fr;
            gap: 40px;
        }
    }


        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }
            
            .hero {
                grid-template-columns: 1fr;
                margin-top: -30px;
            }
            
            .slider {
                height: 50vh;
            }
        }


/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1001;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.4);
}

.modal-content {
    background-color: #fff;
    margin: 5% auto;
    padding: 30px;
    border-radius: 15px;
    width: 90%;
    max-width: 500px;
    position: relative;
}

.close {
    position: absolute;
    right: 25px;
    top: 15px;
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover {
    color: var(--primary-color);
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: var(--text-dark);
}

.form-group input[type="text"],
.form-group input[type="tel"],
.form-group input[type="email"],
.form-group input[type="date"],
.form-group input[type="time"],
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 16px;
    transition: border-color 0.3s;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    border-color: var(--primary-color);
    outline: none;
}

.radio-group {
    display: flex;
    gap: 20px;
    margin-top: 8px;
}

.radio-group label {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
}

button[type="submit"] {
    width: 100%;
    padding: 15px;
    background: var(--primary-color);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button[type="submit"]:hover {
    background-color: #600000;
}


/* Updated Welcome Section Styles */
.welcome-section {
    display: grid;
    grid-template-columns: 1fr 1.2fr;
    gap: 40px;
    padding: 50px 5%;
    background: white;
    margin: 30px 5%;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.welcome-images {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    align-content: start;
}

.welcome-images img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    border-radius: 15px;
    transition: transform 0.3s;
}

.certifications ul {
    list-style-type: none;
    padding-left: 20px;
}

.certifications li::before {
    content: "✓";
    color: var(--primary-color);
    margin-right: 10px;
}

.objectives ol {
    padding-left: 30px;
}

/* Team Gallery Styles */
.team-gallery {
    padding: 50px 5%;
    background: linear-gradient(45deg, #f8f9fa, #ffffff);
}

.team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
    margin-top: 30px;
}

.team-member {
    background: white;
    padding: 20px;
    border-radius: 15px;
    text-align: center;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
}

.team-member img {
    width: 200px;
    height: 200px;
    object-fit: cover;
    border-radius: 50%;
    margin: 0 auto 20px;
}

.social-links {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 15px;
}

.social-links a {
    color: var(--primary-color);
    transition: transform 0.3s;
}

.social-links a:hover {
    transform: translateY(-3px);
}


.footer-social {
    text-align: center;
    margin: 30px 0;
    display: flex;
    justify-content: center;
    gap: 25px;
}

.footer-social a {
    color: white;
    font-size: 1.5rem;
    transition: transform 0.3s;
}

.footer-social a:hover {
    transform: translateY(-5px);
}


</style>

</head>
<body>
    <header>
        <div class="top-nav">
            <div class="contact-info">
                <span><i class="fas fa-map-marker-alt"></i> Jogoo Rd, Nairobi, Kenya</span>
                <span><i class="fas fa-phone"></i> (+254) 731716398</span>
            </div>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
        <nav>
            <?php
    $logo = $conn->query("SELECT image FROM images WHERE category='logo' LIMIT 1");
    if($logo->num_rows > 0): 
        $logo = $logo->fetch_assoc();
    ?>
<img src="uploads/<?= $logo['image'] ?>" alt="Logo" style="height: 50px; margin-right: 20px;">
    <?php endif; ?>
    
    <div class="logo">Church Army Medical Centre</div>
            <ul class="nav-links">
                <li><a href="#home"><i class="fas fa-home"></i> Home</a></li>
                <li><a href="about.php"><i class="fas fa-info-circle"></i> About</a></li>
                 <li><a href="labtest.php"><i class="fas fa-flask"></i> Lab Tests</a></li>
                <li><a href="services.php"><i class="fas fa-hand-holding-medical"></i> Services</a></li>
                <li><a href="#appointment"><i class="fas fa-calendar-check"></i> Appointments</a></li>
                <li><a href="contactus.php"><i class="fas fa-phone-alt"></i> Contact</a></li>
            </ul>
        </nav>
    </header>

    <div class="slider">
        <div class="slider-overlay"></div>
        <?php
        $query = "SELECT image FROM images WHERE category='slider'";
        $result = $conn->query($query);
        while ($row = $result->fetch_assoc()) {
            echo '<img src="uploads/' . $row['image'] . '" alt="Slider Image">';
        }
        ?>
    </div>
<main class="content-container">

<section class="welcome-section">
        <div class="welcome-images">
            <?php
            $query = "SELECT image FROM images WHERE category='left-gallery'";
            $result = $conn->query($query);
            while ($row = $result->fetch_assoc()) {
                echo '<img src="uploads/' . $row['image'] . '" alt="Gallery Image">';
            }
            ?>
        </div>

        <div class="welcome-content">
            <div class="nhif-badge">
                <i class="fas fa-check-circle"></i> NHIF Accredited
            </div>
            <h2>Welcome to Church Army Medical Centre</h2>
            <p>Where health is our priority. We have highly qualified and committed staff ready to serve with dignity and respect.</p>
            
            <p><strong>Operating Hours:</strong><br>
            Weekdays (Mon-Sat): 8:00 AM - 5:00 PM<br>
            Public Holidays: 9:00 AM - 5:00 PM</p>

            <p>We offer high-quality, affordable services including:</p>
        </div>


<div id="appointmentModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Make an Appointment</h2>
        <form id="appointmentForm">
            <div class="form-group">
                <label>Patient Name:</label>
                <input type="text" name="name" required>
            </div>
            
            <div class="form-group">
                <label>Phone Number:</label>
                <input type="tel" name="phone" required>
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email">
            </div>

            <div class="form-group">
                <label>Symptoms:</label>
                <textarea name="symptoms" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label>Select Date:</label>
                <input type="date" name="date" required>
            </div>

            <div class="form-group">
                <label>Department:</label>
                <select name="department" required>
                    <option value="">Select Department</option>
                    <!-- Database options will be added here later -->
                </select>
            </div>

            <div class="form-group">
                <label>Gender:</label>
                <div class="radio-group">
                    <label><input type="radio" name="gender" value="Male" required> Male</label>
                    <label><input type="radio" name="gender" value="Female"> Female</label>
                    <label><input type="radio" name="gender" value="Other"> Other</label>
                </div>
            </div>

            <div class="form-group">
                <label>Preferred Time:</label>
                <input type="time" name="time" required>
            </div>

            <button type="submit" class="btn">Book Appointment</button>
        </form>
    </div>


</div>


    </section>



 

<section class="services-grid">
        <div class="service-card">
            <i class="fas fa-stethoscope"></i>
            <h3>Consultation</h3>
            <p>Professional medical consultations with experienced practitioners</p>
        </div>

        <div class="service-card">
            <i class="fas fa-prescription-bottle"></i>
            <h3>Fully Stocked Pharmacy</h3>
            <p>Comprehensive range of medications available on-site</p>
        </div>

        <div class="service-card">
            <i class="fas fa-microscope"></i>
            <h3>Modern Laboratory</h3>
            <p>Full haemogram and advanced diagnostic services</p>
        </div>

        <div class="service-card">
            <i class="fas fa-baby-carriage"></i>
            <h3>MCH/Family Planning</h3>
            <p>Maternal and child health services with expert care</p>
        </div>

        <div class="service-card">
            <i class="fas fa-syringe"></i>
            <h3>Minor Surgeries</h3>
            <p>Professional wound care and minor surgical procedures</p>
        </div>

        <div class="service-card">
            <i class="fas fa-heartbeat"></i>
            <h3>Specialty Clinics</h3>
            <p>Chronic disease management for hypertension, diabetes, and more</p>
        </div>
    </section>







        <section class="hero">
            <div class="hero-text">
                <h1>Compassionate Care for Healthier Tomorrow</h1>
                <p>Providing comprehensive healthcare services with state-of-the-art facilities and experienced medical professionals.</p>
                <div class="hero-cta">
    <a href="#appointment" class="btn appointment-trigger">
        <i class="fas fa-calendar-check"></i>
        Book Appointment
    </a>
    <a href="#contact" class="btn" style="margin-left: 15px; background: var(--accent-color)">
        <i class="fas fa-phone-alt"></i>
        Emergency Call
    </a>
</div>
            </div>
            <div class="left-images">
                <?php
                $query = "SELECT image FROM images WHERE category='left-gallery'";
                $result = $conn->query($query);
                while ($row = $result->fetch_assoc()) {
                    echo '<img src="uploads/' . $row['image'] . '" alt="Gallery Image">';
                }
                ?>
            </div>


        </section>



        <section id="mission-vision">
            <div class="mission">
                <i class="fas fa-bullseye fa-3x" style="color: var(--primary-color)"></i>
                <h2>Our Mission</h2>
                <p>To deliver exceptional healthcare through innovation, compassion, and excellence in service.</p>
            </div>
            <div class="vision">
                <i class="fas fa-eye fa-3x" style="color: var(--primary-color)"></i>
                <h2>Our Vision</h2>
                <p>To be East Africa's leading provider of accessible, quality healthcare solutions.</p>
            </div>
            <div class="motto">
                <i class="fas fa-heartbeat fa-3x" style="color: var(--primary-color)"></i>
                <h2>Our Promise</h2>
                <p>Your wellness journey is our highest priority.</p>
            </div>
        </section>
    </main>

<script>
// Modal Handling
const modal = document.getElementById("appointmentModal");
const appointmentTriggers = document.querySelectorAll(".appointment-trigger, a[href='#appointment']");
const span = document.getElementsByClassName("close")[0];

// Add click handler to all appointment triggers
appointmentTriggers.forEach(trigger => {
    trigger.onclick = function(e) {
        e.preventDefault();
        modal.style.display = "block";
    }
});

span.onclick = function() {
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

// Form Handling
document.getElementById('appointmentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    console.log('Form submitted');
    modal.style.display = "none";
    // You can add AJAX submission here later
});
</script>



<!-- Updated Welcome Section -->
<section class="welcome-section">
    <div class="welcome-images">
        <?php
        $query = "SELECT image FROM images WHERE category='welcome-gallery'";
        $result = $conn->query($query);
        while ($row = $result->fetch_assoc()) {
            echo '<img src="uploads/' . $row['image'] . '" alt="About Image">';
        }
        ?>
    </div>

    
</section>



<footer>
    <div class="footer-columns">
        <div class="footer-col">
            <h3>About Us</h3>
            <p>We offer health services rooted in philosophy of Christian pastoral care to patients.</p>
            <p>We provide exposure to Evangelists training at Church Army School of Missions, integrating healthcare skills with Evangelistic ministry.</p>
        </div>

        <div class="footer-col">
            <h3>Contact Info</h3>
            <ul class="contact-list">
                <li><i class="fas fa-map-marker-alt"></i> Church Army Stage, Jogoo Rd,<br>Nairobi, Kenya.</li>
                <li><i class="fas fa-envelope"></i> clinic@churcharmyafrica.net</li>
                <li><i class="fas fa-phone"></i> (+254) 748101351</li>
                <li><i class="fas fa-phone"></i> 0754065026</li>
            </ul>
        </div>

        <div class="footer-col">
            <h3>Navigation</h3>
            <ul class="footer-nav">
                <li><a href="#lab-tests"><i class="fas fa-chevron-right"></i> Lab Tests</a></li>
                <li><a href="#services"><i class="fas fa-chevron-right"></i> Services</a></li>
                <li><a href="#appointment"><i class="fas fa-chevron-right"></i> Appointment</a></li>
                <li><a href="about.php"><i class="fas fa-chevron-right"></i> About</a></li>
                <li><a href="contactus.php"><i class="fas fa-chevron-right"></i> Contact Us</a></li>
                <li><a href="/comercial/pages/HomePage.php"><i class="fas fa-chevron-right"></i>Go To Church Army Africa</a></li>
            </ul>
        </div>
    </div>

<div class="footer-social">
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-linkedin-in"></i></a>
    </div>

    
    <div class="footer-bottom">
        <p>&copy; 2025 Church Army Medical Centre. All Rights Reserved.</p>
    </div>

</footer>



</body>
</html>