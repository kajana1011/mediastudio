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
    $client_location = trim($_POST['client_location']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $booking_date = $_POST['booking_date'];
    $notes = trim($_POST['notes']);
    $status = $_POST['status'] ?? 'pending';

    if (!$client_name || !$service_id || !$booking_date) {
        $error = "Please fill in required fields: Client Name, Service, and Booking Date.";
    } else {
        $stmt = $conn->prepare("INSERT INTO bookings (user_id, service_id, client_name, client_location, phone, email, booking_date, notes, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iisssssss", $user_id, $service_id, $client_name, $client_location, $phone, $email, $booking_date, $notes, $status);

        if ($stmt->execute()) {
            $success = "Booking added successfully!";
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
    <h3 class="mb-4">Add New Booking</h3>

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
            <label for="service_id" class="form-label">Service *</label>
            <select name="service_id" id="service_id" class="form-select" required>
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
            <label for="client_location" class="form-label">Client Location</label>
            <input type="text" name="client_location" id="client_location" class="form-control">
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="tel" name="phone" id="phone" class="form-control">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control">
        </div>

        <div class="mb-3">
            <label for="booking_date" class="form-label">Booking Date *</label>
            <input type="date" name="booking_date" id="booking_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status *</label>
            <select name="status" id="status" class="form-select" required>
                <option value="pending" selected>Pending</option>
                <option value="confirmed">Confirmed</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Add Booking</button>
    </form>
</div>

</body>
</html>

