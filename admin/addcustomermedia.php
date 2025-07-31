<?php
session_start();
include_once "../includes/header.php";
include_once "../helpers/db.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header('Location: ../auth/login');
        exit; 
    }
$success = $error = '';

$userId = '';
$bookingId = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'] ?: null;
    $bookingId = $_POST['booking_id'] ?: null;
    $description = $_POST['description'] ?? '';

    if (isset($_FILES['media_file']) && $_FILES['media_file']['error'] === UPLOAD_ERR_OK) {
        $fileTmp = $_FILES['media_file']['tmp_name'];
        $fileName = time() . '_' . basename($_FILES['media_file']['name']);
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Determine media type
        $imageTypes = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
        $videoTypes = ['mp4', 'avi', 'mov', 'wmv', 'flv', 'mkv', 'webm'];

        if (in_array($fileType, $imageTypes)) {
            $mediaType = 'image';
        } elseif (in_array($fileType, $videoTypes)) {
            $mediaType = 'video';
        } else {
            $error = "Unsupported file type.";
        }

        if (!$error) {
            $uploadDir = __DIR__ . "/../uploads/";
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $targetFile = $uploadDir . $fileName;

            if (move_uploaded_file($fileTmp, $targetFile)) {
                $filePath = "uploads/" . $fileName;

                // Insert into DB
                $stmt = $conn->prepare("INSERT INTO customer_media (user_id, booking_id, file_path, media_type, description, is_active) VALUES (?, ?, ?, ?, ?, 1)");
                $stmt->bind_param("iisss", $userId, $bookingId, $filePath, $mediaType, $description);
                if ($stmt->execute()) {
                    $success = "Customer media uploaded successfully.";
                    // Reset form variables
                    $userId = $bookingId = $description = '';
                } else {
                    $error = "Database error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                $error = "Failed to move uploaded file.";
            }
        }
    } else {
        $error = "Please select a media file to upload.";
    }
}

// Fetch users for dropdown
$usersResult = $conn->query("SELECT id, name FROM users ORDER BY name");

// Fetch bookings for dropdown (optional)
$bookingsResult = $conn->query("SELECT id, client_name, booking_date FROM bookings ORDER BY booking_date DESC");

?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Add Customer Media</h4>
                </div>
                <div class="card-body">

                    <?php if ($success): ?>
                        <div class="alert alert-success"><?= $success ?></div>
                    <?php elseif ($error): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>

                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Customer (User) *</label>
                            <select name="user_id" id="user_id" class="form-select" required>
                                <option value="">-- Select Customer --</option>
                                <?php while ($user = $usersResult->fetch_assoc()): ?>
                                    <option value="<?= $user['id'] ?>" <?= ($user['id'] == $userId) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($user['name']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="booking_id" class="form-label">Booking (optional)</label>
                            <select name="booking_id" id="booking_id" class="form-select">
                                <option value="">-- Select Booking --</option>
                                <?php while ($booking = $bookingsResult->fetch_assoc()): ?>
                                    <option value="<?= $booking['id'] ?>" <?= ($booking['id'] == $bookingId) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($booking['client_name']) ?> (<?= $booking['booking_date'] ?>)
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="media_file" class="form-label">Media File *</label>
                            <input type="file" name="media_file" id="media_file" class="form-control" required accept="image/*,video/*">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description (optional)</label>
                            <textarea name="description" id="description" class="form-control" rows="2"><?= htmlspecialchars($description) ?></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Upload Media</button>
                        </div>
                    </form>

                    <div class="mt-3">
                        <a href="customermedia.php" class="text-decoration-none">&larr; View Customer Medi
