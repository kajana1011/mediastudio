<?php
session_start();
include_once "../includes/header.php";
include_once "../helpers/db.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header('Location: ../auth/login');
        exit; 
    }
    
$sql = "SELECT t.*, u.name AS user_name, s.name AS service_name 
        FROM testimonials t
        LEFT JOIN users u ON t.user_id = u.id
        LEFT JOIN services s ON t.service_id = s.id
        ORDER BY t.created_at DESC";

$result = $conn->query($sql);
?>

<div class="container py-4">
    <h3 class="mb-4">Testimonials</h3>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Client Name</th>
                    <th>User</th>
                    <th>Service</th>
                    <th>Feedback</th>
                    <th>Approved</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php $i = 1; while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= htmlspecialchars($row['client_name']) ?></td>
                            <td><?= htmlspecialchars($row['user_name'] ?: 'N/A') ?></td>
                            <td><?= htmlspecialchars($row['service_name'] ?: 'N/A') ?></td>
                            <td><?= nl2br(htmlspecialchars($row['feedback'])) ?></td>
                            <td>
                                <?php if ($row['is_approved']): ?>
                                    <span class="badge bg-success">Yes</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">No</span>
                                <?php endif; ?>
                            </td>
                            <td><?= date('Y-m-d H:i', strtotime($row['created_at'])) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="7" class="text-center text-muted">No testimonials found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
