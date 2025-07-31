<?php
session_start();
include_once "../includes/header.php";
include_once "../helpers/db.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header('Location: ../auth/login');
        exit; 
    }
    
$sql = "SELECT * FROM services ORDER BY id DESC";
$result = $conn->query($sql);
?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Services</h3>
        <a href="addservice.php" class="btn btn-success">+ Add Service</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Sample Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price (TZS)</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php $i = 1; while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td>
                                <?php if ($row['sample_image'] && file_exists(__DIR__ . '/../' . $row['sample_image'])): ?>
                                    <img src="../<?= htmlspecialchars($row['sample_image']) ?>" alt="Sample Image" width="70" class="img-thumbnail">
                                <?php else: ?>
                                    <span class="text-muted">No image</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['category']) ?></td>
                            <td><?= number_format($row['price'], 2) ?></td>
                            <td>
                                <?php if ($row['is_active']): ?>
                                    <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Inactive</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center text-muted">No services found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
