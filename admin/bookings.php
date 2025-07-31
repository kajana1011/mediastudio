<?php
session_start();
include_once "../includes/header.php";
include_once "../helpers/db.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header('Location: ../auth/login');
        exit; 
    }
    
// Query bookings with service and user info
$sql = "SELECT b.id, b.client_name, b.client_location, b.phone, b.email, b.booking_date, b.status,
        s.name AS service_name, u.name AS user_name
        FROM bookings b
        LEFT JOIN services s ON b.service_id = s.id
        LEFT JOIN users u ON b.user_id = u.id
        ORDER BY b.booking_date DESC";

$result = $conn->query($sql);
?>

<div class="container py-4">
    <h3 class="mb-4">Bookings</h3>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Client Name</th>
                    <th>Service</th>
                    <th>Booking Date</th>
                    <th>Status</th>
                    <th>Contact</th>
                    <th>Location</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php $i = 1; while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td>
                                <?= htmlspecialchars($row['client_name']) ?><br>
                                <small class="text-muted">User: <?= htmlspecialchars($row['user_name'] ?: 'N/A') ?></small>
                            </td>
                            <td><?= htmlspecialchars($row['service_name'] ?: 'Unknown') ?></td>
                            <td><?= date('Y-m-d', strtotime($row['booking_date'])) ?></td>
                            <td>
                                <?php
                                $status = $row['status'];
                                $badgeClass = match ($status) {
                                    'pending' => 'warning',
                                    'confirmed' => 'primary',
                                    'completed' => 'success',
                                    'cancelled' => 'danger',
                                    default => 'secondary',
                                };
                                ?>
                                <span class="badge bg-<?= $badgeClass ?>"><?= ucfirst($status) ?></span>
                            </td>
                            <td>
                                <div>Phone: <?= htmlspecialchars($row['phone']) ?></div>
                                <div>Email: <?= htmlspecialchars($row['email']) ?></div>
                            </td>
                            <td><?= htmlspecialchars($row['client_location']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="7" class="text-center text-muted">No bookings found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
