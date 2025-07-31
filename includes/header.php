<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>b25studio</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/bootstrap-5.0.2-dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .active-nav-link {
            font-weight: bold;
            text-decoration: underline;
        }

        .service-img {
            height: 250px;
            object-fit: cover;
            width: 100%;
        }

        #hero {
            background: #454141ff;
        }

        #spiderCanvas {
            z-index: 1;
            opacity: 0.8;
        }
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .brand-logo {
            height: 40px;
            width: 40px;
            object-fit: contain;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background-color: #000 !important;">
        <div class="container-fluid px-4">
            <div class="d-flex flex-column w-100">
                <!-- Brand row -->
                <div class="d-flex align-items-center" style="min-height:56px; margin-bottom:0;">
                    <a class="navbar-brand" href="/" style="margin-left:0;">
                        <img src="../assets/images/logo2.jpg" alt="b25studio logo" class="brand-logo">
                        <span class="fw-bold text-white">b25studio</span>
                    </a>
                    <!-- Offcanvas toggler for mobile -->
                    <button class="navbar-toggler ms-auto d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileNav" aria-controls="mobileNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
                <!-- Desktop nav tabs (hidden on mobile) -->
                <div class="d-none d-lg-flex justify-content-end">
                    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <?php
                                $role = $_SESSION['role'] ?? null;
                                // Desktop navigation (visible on large screens)
                                if ($role === 'admin') {
                                    // Admin links
                            ?>
                                <li class="nav-item">
                                    <a class="nav-link text-white py-2" href="dashboard">Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white py-2" href="users">Users</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white py-2" href="addportfolio">Add Portfolio</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white py-2" href="bookings">Bookings</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white py-2" href="services">Services</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white py-2" href="testimonials">Testimonials</a>
                                </li>
                                <li class="nav-item">
                                    <a href="../auth/logout.php" class="btn btn-outline-danger ms-2">Logout</a>
                                </li>
                            <?php
                                } elseif ($role === 'client') {
                                    // Client links
                            ?>
                                <li class="nav-item">
                                    <a class="nav-link text-white py-2" href="dashboard">Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white py-2" href="services">Services</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white py-2" href="mybookings">My Bookings</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white py-2" href="media">My Gallery</a>
                                </li>
                                <li class="nav-item">
                                    <a href="../auth/logout.php" class="btn btn-outline-danger ms-2">Logout</a>
                                </li>
                            <?php
                                } elseif ($role === 'staff') {
                                    // Staff links
                            ?>
                                <li class="nav-item">
                                    <a class="nav-link text-white py-2" href="dashboard">Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white py-2" href="bookings">Bookings</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white py-2" href="clients">Clients</a>
                                </li>
                                <li class="nav-item">
                                    <a href="../auth/logout.php" class="btn btn-outline-danger ms-2">Logout</a>
                                </li>
                            <?php
                                } else {
                                    // Guest links (public)
                            ?>
                                
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Offcanvas sidebar for mobile (hidden on desktop) -->
        <div class="offcanvas offcanvas-start bg-dark text-white d-lg-none" tabindex="-1" id="mobileNav" aria-labelledby="mobileNavLabel" style="width: 260px;">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="mobileNavLabel">Menu</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav">
                    <?php
                        // Repeat the same logic as above for mobile sidebar
                        // (copy the PHP block above here)
                    ?>
                </ul>
            </div>
        </div>
    </nav>

