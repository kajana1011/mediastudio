<?php
session_start();
include "../includes/header.php";
include "../helpers/db.php";

// Check if user is logged in and is a client
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'client') {
    header("Location: ../auth/login.php");
    exit;
}

// Get service ID from query string
if (!isset($_GET['service_id'])) {
    echo "<p>Invalid request.</p>";
    exit;
}

$service_id = $_GET['service_id'];

// Fetch service details
$stmt = $conn->prepare("SELECT * FROM services WHERE id = ?");
$stmt->bind_param("i", $service_id);
$stmt->execute();
$service = $stmt->get_result()->fetch_assoc();

if (!$service) {
    echo "<p>Service not found.</p>";
    exit;
}

// Handle booking form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_name = $_POST['client_name'];
    $client_location = $_POST['client_location'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $booking_date = $_POST['booking_date'];
    $notes = $_POST['notes'];
    $user_id = $_SESSION['id'] ?? ""; // Make sure session is started and user is logged in

    $stmt = $conn->prepare("INSERT INTO bookings (user_id, service_id, client_name, client_location, phone, email, booking_date, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissssss", $user_id, $service_id, $client_name, $client_location, $phone, $email, $booking_date, $notes);
    
    if ($stmt->execute()) {
        $success = "<div class='alert alert-success'>Booking request submitted successfully!</div>";
    } else {
        $error = "<div class='alert alert-danger'>Failed to book service. Please try again.</div>";
    }
}
?>

<div class="container mt-4">
    <h2>Book: <?= htmlspecialchars($service['name']) ?></h2>
    <p><strong>Description:</strong> <?= htmlspecialchars($service['description']) ?></p>
    <?php if (isset($success)) echo $success; ?>
    <?php if (isset($error)) echo $error; ?>
    <form method="POST" class="mt-3">
        <div class="mb-3">
            <label for="client_name" class="form-label">Your Full Name</label>
            <input type="text" name="client_name" id="client_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="client_location" class="form-label">Your Location</label>
            <input type="text" name="client_location" id="client_location" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="text" name="phone" id="phone" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" id="email" class="form-control">
        </div>

        <div class="mb-3">
            <label for="booking_date" class="form-label">Preferred Booking Date</label>
            <input type="date" name="booking_date" id="booking_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="notes" class="form-label">Additional Notes (Optional)</label>
            <textarea name="notes" id="notes" class="form-control" rows="4"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit Booking</button>
    </form>
</div>

