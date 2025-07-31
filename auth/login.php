<?php
session_start();
include '../helpers/db.php';

$email = $password = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email && $password) {
        $stmt = $conn->prepare("SELECT id, name, password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 1) {
            $stmt->bind_result($id, $name, $hashed_password, $role);
            $stmt->fetch();
            if (password_verify($password, $hashed_password)) {
                
                $_SESSION['id'] = $id;
                $_SESSION['name'] = $name;
                $_SESSION['role'] = $role;
                // Redirect based on role
                if ($role === 'admin') {
                    header("Location: ../admin/dashboard");
                } else {
                    header("Location: ../client/dashboard");
                }
                exit;
            } else {
                $message = '<div class="alert alert-danger text-center">Invalid password.</div>';
            }
        } else {
            $message = '<div class="alert alert-danger text-center">No account found with that email.</div>';
        }
        $stmt->close();
    } else {
        $message = '<div class="alert alert-danger text-center">Please fill in all fields.</div>';
    }
}
?>

<?php include '../includes/guest.php'; ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h3 class="mb-4 text-center fw-bold">Login</h3>
                    <?php echo $message; ?>
                    <form method="post" action="">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required value="<?php echo htmlspecialchars($email); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                    <div class="text-center mt-3">
                        <small>Don't have an account? <a href="register.php">Register</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
