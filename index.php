<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agro-Web-App | Farmer Government Schemes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
        }

        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
                        url('https://images.unsplash.com/photo-1500937386664-56d1dfef3854');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 270px 0;
            text-align: center;
        }

        .feature-icon {
            font-size: 50px;
            color: #198754;
        }

        .footer {
            background-color: #212529;
            color: white;
            padding: 20px 0;
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 30px;
        }
    </style>
</head>

<body>

<!-- ================= NAVBAR ================= -->
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">

        <!-- Brand -->
        <a class="navbar-brand" href="index.php">🌾Agro-Web-App</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Right Side Login Buttons -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="user_login.php">User Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin_login.php">Admin Login</a>
                </li>
            </ul>
        </div>

    </div>
</nav>


<!-- ================= HERO SECTION ================= -->
<section class="hero-section">
    <div class="container">
        <h1 class="display-4 fw-bold">Farmer Government Aided Schemes Portal</h1>
        <p class="lead mt-3">
            Apply for Government Schemes, Get Crop Information, and Track Your Application Status Easily.
        </p>
    </div>
</section>


<!-- ================= ABOUT SECTION ================= -->
<section class="py-5">
    <div class="container text-center">
        <h2 class="mb-4 text-success">About Agro-Web-App</h2>
        <p class="lead">
            Agro-Web-App is a digital platform designed to help farmers access government
            schemes, crop information, pesticide details, and financial support.
            Our mission is to make agriculture smarter and more accessible.
        </p>
    </div>
</section>


<!-- ================= FEATURES SECTION ================= -->
<section class="bg-light py-5">
    <div class="container">
        <h2 class="text-center text-success mb-5">Our Features</h2>

        <div class="row text-center">

            <div class="col-md-4 mb-4">
                <div class="card shadow-sm p-4">
                    <div class="feature-icon mb-3">🌱</div>
                    <h5>Crop Information</h5>
                    <p>Get detailed information about crops, seasons, soil types, and fertilizers.</p>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card shadow-sm p-4">
                    <div class="feature-icon mb-3">🏛</div>
                    <h5>Government Schemes</h5>
                    <p>View and apply for various agricultural government aided schemes.</p>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card shadow-sm p-4">
                    <div class="feature-icon mb-3">📊</div>
                    <h5>Track Application</h5>
                    <p>Check real-time status of your scheme applications anytime.</p>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- ================= FOOTER ================= -->
<footer class="footer text-center">
    <div class="container">
        <p class="mb-0">
            © <?php echo date("Y"); ?> Agro-Web-App | Developed for Farmer Government Aided Schemes Project
        </p>
    </div>
</footer>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
