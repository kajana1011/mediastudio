<?php
session_start();
include_once "../helpers/db.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login');
    exit; 
}

// Fetch all users
$sql = "SELECT id, name, email, phone, role, is_active, last_login FROM users ORDER BY created_at DESC";
$result = $conn->query($sql);

include_once "../includes/header.php";
?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">All Users</h3>
        <a href="adduser.php" class="btn btn-success">+ Add User</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Last Login</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php $i = 1; while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['phone']) ?></td>
                            <td>
                                <span class="badge bg-<?= $row['role'] == 'admin' ? 'danger' : ($row['role'] == 'staff' ? 'primary' : 'secondary') ?>">
                                    <?= ucfirst($row['role']) ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($row['is_active']): ?>
                                    <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td><?= $row['last_login'] ? date('Y-m-d H:i', strtotime($row['last_login'])) : 'Never' ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="7" class="text-center text-muted">No users found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
<?php
include_once "../includes/footer.php";