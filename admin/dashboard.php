<?php
    // Start session and check admin role (add your own authentication logic)
    session_start();
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header('Location: ../auth/login');
        exit; 
    }

    include_once '../includes/header.php';
?>

<div class="container my-5">
    <h1 class="mb-4 text-center">Admin Dashboard</h1>
    <div class="row g-4">
        <div class="col-md-4 col-sm-6">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Manage Services</h5>
                    <p class="card-text">Add, edit, or remove services offered by the studio.</p>
                    <a href="services.php" class="btn btn-primary">Go</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">View Bookings</h5>
                    <p class="card-text">See all client bookings and manage their status.</p>
                    <a href="bookings.php" class="btn btn-primary">Go</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Portfolio Uploads</h5>
                    <p class="card-text">Upload new photos or videos to the portfolio.</p>
                    <a href="portfolio.php" class="btn btn-primary">Go</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Testimonials</h5>
                    <p class="card-text">View and manage client feedback.</p>
                    <a href="testimonials.php" class="btn btn-primary">Go</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Users</h5>
                    <p class="card-text">Manage admin, staff, and client accounts.</p>
                    <a href="users.php" class="btn btn-primary">Go</a>
                </div>
            </div>
        </div>
    </div>
</div>