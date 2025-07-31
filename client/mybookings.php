<?php
session_start();
include "../includes/header.php"; 
include "../helpers/db.php"; 

$user_id = $_SESSION['id'];
?>

<div class="container my-5">
    <h2 class="text-center mb-4">My Bookings</h2>

    <?php
    $stmt = $conn->prepare("SELECT id, booking_date, service_type, status, location, created_at 
                            FROM bookings WHERE user_id = ? ORDER BY booking_date DESC");
    $stmt->execute([$user_id]);
    $result = $stmt->get_result();
    ?>

    <?php if ($result->num_rows > 0): ?>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Service</th>
                    <th>Booking Date</th>
                    <th>Status</th>
                    <th>Location</th>
                    <th>Booked On</th>
                </tr>
            </thead>
            <tbody>
                <?php $sn = 1; while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $sn++ ?></td>
                    <td><?= htmlspecialchars($row['service_type']) ?></td>
                    <td><?= date('F j, Y', strtotime($row['booking_date'])) ?></td>
                    <td>
                        <?php
                        $status = htmlspecialchars($row['status']);
                        $badge = match ($status) {
                            'pending' => 'warning',
                            'confirmed' => 'success',
                            'cancelled' => 'danger',
                            default => 'secondary'
                        };
                        ?>
                        <span class="badge bg-<?= $badge ?>"><?= ucfirst($status) ?></span>
                    </td>
                    <td><?= htmlspecialchars($row['location']) ?></td>
                    <td><?= date('F j, Y', strtotime($row['created_at'])) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center text-muted">You have no bookings yet.</p>
    <?php endif; ?>
</div>

<?php include "includes/footer.php"; ?>
