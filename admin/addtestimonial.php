<?php
session_start();
include_once "../includes/header.php";
include_once "../helpers/db.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header('Location: ../auth/login');
        exit; 
    }
$success = $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'] ?: null;
    $service_id = $_POST['service_id'] ?: null;
    $client_name = trim($_POST['client_name']);
    $feedback = trim($_POST['feedback']);
    $is_approved = isset($_POST['is_approved']) ? 1 : 0;

    if (!$client_name || !$feedback) {
        $error = "Please fill in Client Name and Feedback.";
    } else {
        $stmt = $conn->prepare("INSERT INTO testimonials (user_id, service_id, client_name, feedback, is_approved) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iissi", $user_id, $service_id, $client_name, $feedback, $is_approved);

        if ($stmt->execute()) {
            $success = "Testimonial added successfully!";
        } else {
            $error = "Database error: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Fetch users and services for dropdowns
$users = $conn->query("SELECT id, name FROM users ORDER BY name");
$services = $conn->query("SELECT id, name FROM services WHERE is_active = 1 ORDER BY name");
?>

<div class="container py-4">
    <h3 class="mb-4">Add New Testimonial</h3>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" class="mb-5">
        <div class="mb-3">
            <label for="user_id" class="form-label">User (optional)</label>
            <select name="user_id" id="user_id" class="form-select">
                <option value="">-- Select User --</option>
                <?php while ($u = $users->fetch_assoc()): ?>
                    <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['name']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="service_id" class="form-label">Service (optional)</label>
            <select name="service_id" id="service_id" class="form-select">
                <option value="">-- Select Service --</option>
                <?php while ($s = $services->fetch_assoc()): ?>
                    <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['name']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="client_name" class="form-label">Client Name *</label>
            <input type="text" name="client_name" id="client_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="feedback" class="form-label">Feedback *</label>
            <textarea name="feedback" id="feedback" class="form-control" rows="4" required></textarea>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="is_approved" id="is_approved" class="form-check-input" checked>
            <label for="is_approved" class="form-check-label">Approve Testimonial</label>
        </div>

        <button type="submit" class="btn btn-primary">Add Testimonial</button>
    </form>
</div>

</body>
</html>
