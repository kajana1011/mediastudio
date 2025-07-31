<?php
session_start();
include_once "../includes/header.php";
include_once "../helpers/db.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login');
    exit; 
}
// Fetch all portfolio items
$sql = "SELECT * FROM portfolio ORDER BY uploaded_at DESC";
$result = $conn->query($sql);
?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">All Portfolio Items</h3>
        <a href="addportfolio.php" class="btn btn-success">+ Add New</a>
    </div>

    <div class="row">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <?php if ($row['media_type'] == 'image'): ?>
                            <img src="../<?= $row['file_path'] ?>" class="card-img-top" alt="Portfolio Image">
                        <?php else: ?>
                            <video class="card-img-top" controls>
                                <source src="../<?= $row['file_path'] ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
                            <p class="card-text text-muted small mb-1">
                                <?= htmlspecialchars($row['description']) ?>
                            </p>
                            <span class="badge bg-<?= $row['media_type'] === 'image' ? 'info' : 'dark' ?>">
                                <?= ucfirst($row['media_type']) ?>
                            </span>
                            <p class="text-muted mt-2 mb-0">
                                <small>Uploaded: <?= date('Y-m-d H:i', strtotime($row['uploaded_at'])) ?></small>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-warning text-center">No portfolio items found.</div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include "../includes/footer.php"; ?>
