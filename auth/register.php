<?php
include '../includes/guest.php';
include '../helpers/db.php';
include '../helpers/functions.php';

// Initialize variables
$name = $email = $phone = $password = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($name && $email && $password) {
        // Register user as 'client' by default
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'client')");
        $stmt->bind_param("sss", $name, $email, $hashed_password);
        if ($stmt->execute()) {
            $message = '<div class="alert alert-success text-center">Registration successful! <a href="login.php">Login now</a>.</div>';
        } else {
            $message = '<div class="alert alert-danger text-center">Email already exists or error occurred.</div>';
        }
        $stmt->close();
    } else {
        $message = '<div class="alert alert-danger text-center">Please fill in all required fields.</div>';
    }
}
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h3 class="mb-4 text-center fw-bold">Sign Up</h3>
                    <?php echo $message; ?>
                    <form method="post" action="">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" required value="<?php echo htmlspecialchars($name); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required value="<?php echo htmlspecialchars($email); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Create Account</button>
                    </form>
                    <div class="text-center mt-3">
                        <small>Already have an account? <a href="login.php">Login</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
