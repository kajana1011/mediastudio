<?php
session_start();
include_once "../includes/header.php";
include_once "../helpers/db.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header('Location: ../auth/login');
        exit; 
    }
    
$userId = $_GET['user_id'] ?? null;
$mediaList = [];
$userName = '';

if ($userId) {
    // Get user name
    $stmt = $conn->prepare("SELECT name FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($userName);
    $stmt->fetch();
    $stmt->close();

    // Get customer media for this user
    $stmt = $conn->prepare("SELECT * FROM customer_media WHERE user_id = ? AND is_active = 1 ORDER BY uploaded_at DESC");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $mediaList = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}

// Fetch users for selection
$usersResult = $conn->query("SELECT id, name FROM users ORDER BY name");
?>

<div class="container py-4">

    <h3 class="mb-4">Customer Media</h3>

    <form method="GET" class="mb-4">
        <div class="row g-2 align-items-center">
            <div class="col-auto">
                <label for="user_id" class="col-form-label">Select Customer:</label>
            </div>
            <div class="col-auto">
                <select name="user_id" id="user_id" class="form-select" required>
                    <option value="">-- Select Customer --</option>
                    <?php while ($user = $usersResult->fetch_assoc()): ?>
                        <option value="<?= $user['id'] ?>" <?= ($user['id'] == $userId) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($user['name']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">View Media</button>
            </div>
        </div>
    </form>

    <?php if ($userId): ?>
        <h5>Media for: <strong><?= htmlspecialchars($userName) ?></strong></h5>

        <?php if (count($mediaList) === 0): ?>
            <div class="alert alert-warning">No media found for this customer.</div>
        <?php else: ?>
            <div class="row g-3">
                <?php foreach ($mediaList as $media): ?>
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm">
                            <?php if ($media['media_type'] === 'image'): ?>
                                <img src="../<?= htmlspecialchars($media['file_path']) ?>" class="card-img-top" alt="Customer Media">
                            <?php else: ?>
                                <video class="card-img-top" controls>
                                    <source src="../<?= htmlspecialchars($media['file_path']) ?>" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            <?php endif; ?>
                            <div class="card-body">
                                <p class="card-text"><?= htmlspecialchars($media['description']) ?: '<em>No description</em>' ?></p>
                                <small class="text-muted">Uploaded: <?= date('Y-m-d H:i', strtotime($media['uploaded_at'])) ?></small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>

</div>

</body>
</html>
