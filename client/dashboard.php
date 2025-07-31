<?php
session_start();

// Check if user is logged in and is a client
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'client') {
    header("Location: ../auth/login.php");
    exit;
}

include '../includes/header.php';
?>

<div class="container py-5">
    <h2 class="text-center mb-4">Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?> 👋</h2>

    <div class="row g-4">
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">My Orders</h5>
                    <p class="card-text">View and manage your placed orders.</p>
                    <a href="orders.php" class="btn btn-primary">View Orders</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Request Service</h5>
                    <p class="card-text">Place a new photography or editing service request.</p>
                    <a href="request-service.php" class="btn btn-success">Request Now</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">My Profile</h5>
                    <p class="card-text">Update your profile information.</p>
                    <a href="profile.php" class="btn btn-warning">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
