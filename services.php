<?php
include "includes/guest.php";
include "helpers/db.php"; // Make sure this file sets up your DB connection
?>

<div class="container text-center">
    <h1>Our Services</h1>

    <ul class="list-group my-4">
        <?php
        $stmt = $conn->prepare("SELECT name, description, price FROM services WHERE is_active = 1");
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
        ?>
            <li class="list-group-item">
                <h3><?= htmlspecialchars($row['name']) ?></h3>
                <p><?= nl2br(htmlspecialchars($row['description'])) ?></p>
                <p>Estimated price: $<?= number_format($row['price'], 2) ?></p>
            </li>
        <?php
            endwhile;
        else:
        ?>
            <li class="list-group-item text-danger">No services found at the moment. <a href="database/seeder.php">seed sample data</a></li>
        <?php endif; ?>
    </ul>
</div>

<?php
include "includes/footer.php";
?>
