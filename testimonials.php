<?php
    include "includes/guest.php";
    include "helpers/db.php"; // make sure $conn is set

    // Fetch only approved testimonials
    $query = "SELECT client_name, feedback FROM testimonials WHERE is_approved = 1 ORDER BY created_at DESC";
    $result = mysqli_query($conn, $query);
?>

<h1>Testimonials</h1>

<div class="list-group my-4">
    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="list-group-item">
                <p>"<?php echo htmlspecialchars($row['feedback']); ?>"</p>
                <small>- <?php echo htmlspecialchars($row['client_name']); ?></small>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="list-group-item">
            <p>No testimonials available yet.</p>
        </div>
    <?php endif; ?>
</div>

<?php
    include "includes/footer.php";
?>
