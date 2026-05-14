<?php
// File: index.php (Main Landing Page)
// This file serves as the main entry point and marketing page for the application.

// Start session to check for logged-in users.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Include the database connection if the file exists.
if (file_exists('includes/db.php')) {
    require_once 'includes/db.php'; 
}

// If a user is already logged in, redirect them to their respective dashboard
if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
    header("Location: " . $_SESSION['role'] . "/");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Vaccination System - Professional Health Management</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #3498db; /* Professional Blue */
            --secondary-color: #1abc9c; /* Soft Teal */
            --accent-color: #f39c12; /* Warm Gold/Orange */
            --dark-color: #2c3e50;
            --light-color: #f5f7fa;
            --font-family: 'Poppins', sans-serif;
        }
        html { scroll-behavior: smooth; }
        body { font-family: var(--font-family); background-color: #ffffff; }

        .navbar { transition: all 0.4s ease; }
        .navbar-scrolled {
            background-color: rgba(255, 255, 255, 0.85) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        .navbar-brand { font-weight: 700; }
        .nav-link { font-weight: 500; position: relative; padding: 0.5rem 1rem; }
        .nav-link::after {
            content: ''; position: absolute; bottom: -5px; left: 0;
            width: 0; height: 2px;
            background-color: var(--secondary-color);
            transition: width 0.3s ease;
        }
        .nav-link:hover::after, .navbar-nav .nav-link.active::after { width: 100%; }

        #hero {
            position: relative; background: var(--dark-color);
            height: 100vh; color: white; display: flex; align-items: center; overflow: hidden;
        }
        #particles-js { position: absolute; width: 100%; height: 100%; top: 0; left: 0; z-index: 1; }
        #hero .container { position: relative; z-index: 2; }
        
        .section { padding: 100px 0; }
        .section-title { font-weight: 800; color: var(--dark-color); }
        .section-subtitle { font-weight: 400; color: #6c757d; max-width: 600px; margin: 0 auto 4rem auto; }

        .feature-card, .why-card {
            background-color: white; border-radius: 1rem; border: 1px solid #eee;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: all 0.3s ease; transform-style: preserve-3d;
        }
        .feature-card:hover, .why-card:hover { transform: translateY(-10px) scale(1.02); box-shadow: 0 15px 40px rgba(0,0,0,0.1); }
        .feature-card-content, .why-card-content { transform: translateZ(20px); }
        .feature-icon, .why-icon {
            font-size: 3rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        #stats { background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1583324113626-77e0fce6441f?q=80&w=1974&auto=format&fit=crop') center center/cover fixed; }
        .stat-item .display-4 { font-weight: 700; }
        
        .team-card {
            border-radius: 1rem; overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.07);
            transition: all 0.3s ease;
        }
        .team-card:hover { transform: translateY(-5px) scale(1.03); }
        .team-card-img { height: 250px; object-fit: cover; }
        
        .testimonial-card {
            background-color: var(--light-color);
            border-left: 5px solid var(--secondary-color);
        }
        .testimonial-card img { width: 80px; height: 80px; object-fit: cover; }

        footer { background-color: var(--dark-color); color: #ccc; }
        footer a { color: #ccc; text-decoration: none; transition: color 0.2s; }
        footer a:hover { color: var(--secondary-color); }
        footer .social-icons a { font-size: 1.5rem; }
        
        .btn-gradient {
             background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
             border: none;
             transition: all 0.3s ease;
             padding: 12px 30px;
        }
        .btn-gradient:hover {
            box-shadow: 0 10px 20px rgba(74, 144, 226, 0.3);
            transform: translateY(-2px);
        }
        .btn-outline-light:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            color: white !important;
        }

        .accordion-button:not(.collapsed) { color: #fff; background-color: var(--primary-color); }
        .accordion-button:focus { box-shadow: none; }
        
        .carousel-item img {
            height: 600px;
            object-fit: cover;
            object-position: center;
        }
        .vaccine-card .card-img-top {
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body data-bs-spy="scroll" data-bs-target="#main-nav">

    <!-- Header & Navbar -->
    <nav id="main-nav" class="navbar navbar-expand-lg fixed-top navbar-dark">
        <div class="container">
            <a class="navbar-brand fs-4" href="#hero"><i class="bi bi-shield-check me-2"></i>E-Vaccination</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#hero">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="#vaccines">Vaccines</a></li>
                    <li class="nav-item"><a class="nav-link" href="#team">Team</a></li>
                    <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                </ul>
                <a href="login.php" class="btn btn-outline-light ms-lg-3">Login</a>
                <a href="register.php" class="btn btn-primary btn-gradient ms-lg-2">Register</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="hero">
        <div id="particles-js"></div>
        <div class="container text-center">
            <h1 class="display-3 fw-bold" data-aos="fade-up">A Digital Guardian for Your Child's Health</h1>
            <p class="lead my-4" data-aos="fade-up" data-aos-delay="200">Stay ahead of immunization schedules with our intelligent tracking and appointment booking system.</p>
            <div data-aos="fade-up" data-aos-delay="400">
                <a href="register.php" class="btn btn-primary btn-gradient btn-lg mt-3">Get Started for Free</a>
                <a href="#about" class="btn btn-outline-light btn-lg mt-3">Learn More</a>
            </div>
        </div>
    </section>

    <!-- Image Slider Section -->
    <section id="slider" class="py-5 bg-light">
        <div class="container" data-aos="fade-up">
            <div id="featureCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner rounded-4 shadow-lg">
                    <div class="carousel-item active"><img src="https://images.pexels.com/photos/2631746/pexels-photo-2631746.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" class="d-block w-100" alt="Hospital Building"><div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded"><h5>State-of-the-Art Facilities</h5><p>Our network includes modern, well-equipped hospitals.</p></div></div>
                    <div class="carousel-item"><img src="https://images.pexels.com/photos/3279197/pexels-photo-3279197.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" class="d-block w-100" alt="Hospital Reception"><div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded"><h5>Professional and Welcoming Environments</h5><p>Experience care in clean, professional settings.</p></div></div>
                    <div class="carousel-item"><img src="https://images.pexels.com/photos/3786157/pexels-photo-3786157.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" class="d-block w-100" alt="Doctors Talking"><div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded"><h5>Expert Medical Staff</h5><p>Connect with experienced doctors and nurses.</p></div></div>
                    <div class="carousel-item"><img src="https://images.pexels.com/photos/1170979/pexels-photo-1170979.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" class="d-block w-100" alt="Hospital Room"><div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded"><h5>Comfort and Care</h5><p>Our partner facilities prioritize patient comfort and well-being.</p></div></div>
                    <div class="carousel-item"><img src="https://images.pexels.com/photos/3957987/pexels-photo-3957987.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="d-block w-100" alt="Vaccine vial"><div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded"><h5>Safe and Secure Vaccinations</h5><p>Ensuring the highest standards of safety and care.</p></div></div>
                    <div class="carousel-item"><img src="https://images.pexels.com/photos/2280547/pexels-photo-2280547.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="d-block w-100" alt="Science Lab"><div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-3 rounded"><h5>Powered by Modern Science</h5><p>Leveraging technology to improve public health.</p></div></div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#featureCarousel" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span></button>
                <button class="carousel-control-next" type="button" data-bs-target="#featureCarousel" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span></button>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="section">
        <div class="container">
            <div class="text-center" data-aos="fade-up"><h2 class="section-title">About The E-Vaccination System</h2><p class="section-subtitle">Our mission is to safeguard public health by replacing outdated, manual vaccination tracking with a seamless, modern digital platform.</p></div>
            <div class="row g-5 align-items-center">
                <div class="col-lg-6" data-aos="fade-right"><img src="https://images.pexels.com/photos/7089019/pexels-photo-7089019.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="img-fluid rounded-4 shadow-lg" alt="Doctor with tablet"></div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="100">
                    <h3 class="fw-bold">The Problem We Solve</h3>
                    <p class="text-muted">In many regions, vaccination records are still managed using paper-based systems. This method is inefficient, prone to human error, and can lead to lost records. As a result, children can miss critical immunization doses, leaving them vulnerable to preventable diseases and creating a significant public health challenge.</p>
                    <h3 class="fw-bold mt-4">Our Vision for the Future</h3>
                    <p class="text-muted">We envision a future where every child's vaccination history is securely and digitally stored, accessible to parents and authorized healthcare providers anytime, anywhere. By leveraging technology, we aim to create a reliable and efficient ecosystem that ensures no child is left behind, ultimately contributing to a healthier society for all.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="section bg-light">
        <div class="container">
            <div class="text-center"><h2 class="section-title" data-aos="fade-up">A Platform for Everyone</h2><p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">We provide dedicated tools for every user in the vaccination ecosystem.</p></div>
            <div class="row g-4">
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200"><div class="card service-card p-4 text-center h-100"><div class="card-body d-flex flex-column h-100"><i class="bi bi-person-heart service-icon mb-3"></i><h4 class="fw-bold">For Parents</h4><p>Register children, get automated schedules, book hospital appointments, and maintain a complete digital health record.</p><a href="register.php" class="btn btn-outline-primary mt-auto">Parent Portal</a></div></div></div>
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300"><div class="card service-card p-4 text-center h-100"><div class="card-body d-flex flex-column h-100"><i class="bi bi-hospital service-icon mb-3"></i><h4 class="fw-bold">For Hospitals</h4><p>Manage approved appointments, update vaccination statuses in real-time, and become part of our trusted network of providers.</p><a href="register.php" class="btn btn-outline-primary mt-auto">Hospital Portal</a></div></div></div>
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="400"><div class="card service-card p-4 text-center h-100"><div class="card-body d-flex flex-column h-100"><i class="bi bi-person-workspace service-icon mb-3"></i><h4 class="fw-bold">For Admins</h4><p>Oversee the entire system from a powerful dashboard. Manage hospitals, vaccines, user accounts, and generate insightful reports.</p><a href="login.php" class="btn btn-outline-primary mt-auto">Admin Login</a></div></div></div>
            </div>
        </div>
    </section>

    <!-- Vaccines Section -->
    <section id="vaccines" class="section">
        <div class="container">
            <div class="text-center" data-aos="fade-up"><h2 class="section-title">Essential Childhood Vaccinations</h2><p class="section-subtitle">A look at some of the core vaccines that protect children from serious illnesses.</p></div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up">
                    <div class="card vaccine-card h-100">
                        <img src="https://atamed.sg/images/polio-vaccine-vial-and-syringe-placed-next-to-a-stethoscope-representing-immunisation-efforts-to-protect-against-polio-in-singapore.webp" class="card-img-top" alt="Polio Vaccine">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">Polio (OPV)</h5>
                            <p class="card-text text-muted">This oral vaccine prevents poliomyelitis, a viral disease that can cause permanent paralysis. The OPV is a live attenuated vaccine given at birth, followed by scheduled booster doses. It’s a key part of global eradication efforts and national immunization programs.</p>
                            <a href="#" class="btn btn-outline-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="card vaccine-card h-100">
                        <img src="https://www.news-medical.net/image-handler/ts/20201120070002/ri/1000/picture/2020/11/shutterstock_1449408860.jpg" class="card-img-top" alt="MMR Vaccine">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">MMR Vaccine</h5>
                            <p class="card-text text-muted">The Measles, Mumps, and Rubella (MMR) vaccine is a combination shot that protects against three common and serious childhood diseases. It is a cornerstone of immunization schedules worldwide.</p>
                            <a href="#" class="btn btn-outline-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="card vaccine-card h-100">
                        <img src="https://alohakidsclinic.com/wp-content/uploads/2024/08/Aloha01-3.jpg" class="card-img-top" alt="DTaP Vaccine">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">DTaP/DTwP Vaccine</h5>
                            <p class="card-text text-muted">This combination vaccine protects against Diphtheria, Tetanus (lockjaw), and Pertussis (whooping cough), all of which can be very serious, especially for infants and young children.</p>
                            <a href="#" class="btn btn-outline-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up">
                    <div class="card vaccine-card h-100">
                        <img src="https://res.cloudinary.com/liaison-inc/image/upload/f_auto/q_auto,w_1200/v1738772335/content/bettercare/bettercare-vial-of-hepatitis-b-vaccine-and-syringe_r3tqz2.jpg" class="card-img-top" alt="Hepatitis B Vaccine">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">Hepatitis B Vaccine</h5>
                            <p class="card-text text-muted">Administered as a series of shots starting from birth, this vaccine protects against the Hepatitis B virus, a major cause of serious liver disease, including cirrhosis and liver cancer.</p>
                            <a href="#" class="btn btn-outline-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="card vaccine-card h-100">
                        <img src="https://www.bu.edu/sph/files/2022/08/bcg-1920x1280.jpg" class="card-img-top" alt="BCG Vaccine">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">BCG Vaccine</h5>
                            <p class="card-text text-muted">Protects infants against tuberculosis (TB), particularly severe childhood forms like TB meningitis and miliary TB. Given at birth as a single dose, it is a live attenuated vaccine administered intradermally, typically on the upper arm. It often leaves a small scar.</p>
                            <a href="#" class="btn btn-outline-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="card vaccine-card h-100">
                        <img src="https://images.pexels.com/photos/6075017/pexels-photo-6075017.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="card-img-top" alt="Child playing">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">Hib Vaccine</h5>
                            <p class="card-text text-muted">The Haemophilus influenzae type b (Hib) vaccine protects against a type of bacteria that can cause severe illnesses, particularly in children under 5, including meningitis, pneumonia, and epiglottitis.</p>
                            <a href="#" class="btn btn-outline-primary mt-auto">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section id="stats" class="py-5 text-white">
        <div class="container text-center py-5">
             <h2 class="section-title text-white" data-aos="fade-up">Our Impact in Numbers</h2>
             <div class="row mt-5">
                <div class="col-md-4" data-aos="fade-up"><div class="stat-item"><i class="bi bi-people-fill display-2"></i><h3 class="display-4" data-target="12500">0</h3><p class="lead">Parents Trust Us</p></div></div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200"><div class="stat-item"><i class="bi bi-hospital-fill display-2"></i><h3 class="display-4" data-target="350">0</h3><p class="lead">Hospitals Onboard</p></div></div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="400"><div class="stat-item"><i class="bi bi-shield-check display-2"></i><h3 class="display-4" data-target="50000">0</h3><p class="lead">Vaccinations Managed</p></div></div>
             </div>
        </div>
    </section>

    <!-- Team Section -->
    <section id="team" class="section bg-light">
        <div class="container">
            <div class="text-center"><h2 class="section-title" data-aos="fade-up">Meet Our Team</h2><p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">The dedicated students from Aptech behind the E-Vaccination System project.</p></div>
            <div class="row g-4 justify-content-center">
                <div class="col-lg-2 col-md-4 col-6" data-aos="zoom-in"><div class="card team-card text-center"><img src="https://media.licdn.com/dms/image/v2/D5603AQGNKdQP1zatpg/profile-displayphoto-shrink_800_800/B56ZST3Q7UHQAc-/0/1737647526405?e=1755734400&v=beta&t=vQ6do1f5_G9QcFdkP5pJ241OddjyAjfs59vg63FcVxM" class="card-img-top team-card-img" alt="ABDUL SATTAR"><div class="card-body p-2"><h6 class="card-title fw-bold mb-0">ABDUL SATTAR</h6><p class="card-text small text-muted">1619071</p></div></div></div>
                <div class="col-lg-2 col-md-4 col-6" data-aos="zoom-in" data-aos-delay="100"><div class="card team-card text-center"><img src="https://randomuser.me/api/portraits/men/69.jpg" class="card-img-top team-card-img" alt="MUHAMMAD ANUS"><div class="card-body p-2"><h6 class="card-title fw-bold mb-0">MUHAMMAD ANUS</h6><p class="card-text small text-muted">1598956</p></div></div></div>
                <div class="col-lg-2 col-md-4 col-6" data-aos="zoom-in" data-aos-delay="200"><div class="card team-card text-center"><img src="https://randomuser.me/api/portraits/men/70.jpg" class="card-img-top team-card-img" alt="MUHAMMAD AHMED"><div class="card-body p-2"><h6 class="card-title fw-bold mb-0">MUHAMMAD AHMED</h6><p class="card-text small text-muted">1604808</p></div></div></div>
                <div class="col-lg-2 col-md-4 col-6" data-aos="zoom-in" data-aos-delay="300"><div class="card team-card text-center"><img src="https://randomuser.me/api/portraits/men/71.jpg" class="card-img-top team-card-img" alt="M. ABBAS ZAIDI"><div class="card-body p-2"><h6 class="card-title fw-bold mb-0">M. ABBAS ZAIDI</h6><p class="card-text small text-muted">1604806</p></div></div></div>
                <div class="col-lg-2 col-md-4 col-6" data-aos="zoom-in" data-aos-delay="400"><div class="card team-card text-center"><img src="https://randomuser.me/api/portraits/men/72.jpg" class="card-img-top team-card-img" alt="SARANG LATEEF"><div class="card-body p-2"><h6 class="card-title fw-bold mb-0">SARANG LATEEF</h6><p class="card-text small text-muted">1598519</p></div></div></div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="section">
        <div class="container">
            <div class="text-center" data-aos="fade-up"><h2 class="section-title">Frequently Asked Questions</h2></div>
            <div class="row justify-content-center">
                <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item mb-3 border-0 shadow-sm rounded-3"><h2 class="accordion-header"><button class="accordion-button collapsed rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#faq-1">What happens if we miss a vaccine dose?</button></h2><div id="faq-1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion"><div class="accordion-body">Our system helps you track missed doses. You can consult with a registered doctor through our platform to reschedule the appointment and create a catch-up vaccination plan for your child.</div></div></div>
                        <div class="accordion-item mb-3 border-0 shadow-sm rounded-3"><h2 class="accordion-header"><button class="accordion-button collapsed rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#faq-2">Is the E-Vaccination system free for parents?</button></h2><div id="faq-2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion"><div class="accordion-body">Yes, the core services for parents, including registration, scheduling, and record-keeping, are completely free. Our goal is to make healthcare accessible to everyone.</div></div></div>
                        <div class="accordion-item mb-3 border-0 shadow-sm rounded-3"><h2 class="accordion-header"><button class="accordion-button collapsed rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#faq-3">How is my child's data kept private?</button></h2><div id="faq-3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion"><div class="accordion-body">We use industry-standard encryption and security protocols to protect all personal and medical data. Your privacy is our top priority, and we comply with all healthcare data protection regulations.</div></div></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0"><h4 class="fw-bold mb-3">E-Vaccination</h4><p>A project by Aptech students to modernize public health services and ensure a healthier future for the next generation.</p></div>
                <div class="col-md-2 offset-md-1 mb-4 mb-md-0"><h5 class="fw-bold mb-3">Links</h5><ul class="list-unstyled"><li><a href="#hero">Home</a></li><li><a href="#about">About</a></li><li><a href="#services">Services</a></li><li><a href="#team">Team</a></li></ul></div>
                <div class="col-md-4 offset-md-1"><h5 class="fw-bold mb-3">Contact Us</h5><p class="mb-2 d-flex"><i class="bi bi-geo-alt-fill me-2"></i> Gulshan-e-Hadeed, Karachi, Pakistan</p><p class="mb-2 d-flex"><i class="bi bi-envelope-fill me-2"></i> <a href="mailto:contact@e-vaccination.com">contact@e-vaccination.com</a></p><div class="social-icons mt-3"><a href="https://twitter.com" target="_blank" class="me-3"><i class="bi bi-twitter"></i></a><a href="https://facebook.com" target="_blank" class="me-3"><i class="bi bi-facebook"></i></a><a href="https://instagram.com" target="_blank" class="me-3"><i class="bi bi-instagram"></i></a><a href="https://linkedin.com" target="_blank" class="me-3"><i class="bi bi-linkedin"></i></a></div></div>
            </div>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.1);"><div class="text-center"><p class="mb-0">&copy; 2025 E-Vaccination System. All Rights Reserved.</p></div>
        </div>
    </footer>


    <!-- JS Files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        $(document).ready(function() {
            AOS.init({ duration: 800, once: true });
            
            $(window).scroll(function() {
                if ($(this).scrollTop() > 50) {
                    $('#main-nav').addClass('navbar-scrolled navbar-light').removeClass('navbar-dark');
                } else {
                    $('#main-nav').removeClass('navbar-scrolled navbar-light').addClass('navbar-dark');
                }
            });

            const counterObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if(entry.isIntersecting){
                        const counters = entry.target.querySelectorAll('.display-4[data-target]');
                        counters.forEach(counter => {
                            const updateCount = () => {
                                const target = +counter.getAttribute('data-target');
                                const count = +counter.innerText.replace(/,/g, '');
                                const increment = target / 100;
                                if (count < target) {
                                    counter.innerText = Math.ceil(count + increment).toLocaleString();
                                    setTimeout(updateCount, 20);
                                } else {
                                    counter.innerText = target.toLocaleString();
                                }
                            };
                            updateCount();
                        });
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.5 });
            
            const statsSection = document.getElementById('stats');
            if(statsSection) { counterObserver.observe(statsSection); }
            
            $('.feature-card').on('mousemove', function(e) {
                let rect = this.getBoundingClientRect();
                let x = e.clientX - rect.left; let y = e.clientY - rect.top;
                let width = rect.width; let height = rect.height;
                let rotateX = -1 * (y - height / 2) / (height / 2) * 8;
                let rotateY = (x - width / 2) / (width / 2) * 8;
                $(this).css('transform', `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`);
            }).on('mouseleave', function() {
                $(this).css('transform', 'perspective(1000px) rotateX(0) rotateY(0)');
            });

            if (document.getElementById('particles-js')) {
                particlesJS('particles-js', { "particles": { "number": { "value": 60, "density": { "enable": true, "value_area": 800 } }, "color": { "value": "#ffffff" }, "shape": { "type": "circle" }, "opacity": { "value": 0.5, "random": true }, "size": { "value": 3, "random": true }, "line_linked": { "enable": false }, "move": { "enable": true, "speed": 1, "direction": "none", "random": true, "straight": false, "out_mode": "out" } }, "interactivity": { "detect_on": "canvas", "events": { "onhover": { "enable": false }, "onclick": { "enable": false } } }, "retina_detect": true });
            }
        });
    </script>
</body>
</html>
