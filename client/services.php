<?php
session_start();
include "../includes/header.php";
include "../helpers/db.php";

// Fetch all services
$query = "SELECT * FROM services";
$result = mysqli_query($conn, $query);
?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Our Services</h2>
    <div class="row">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($row['name']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($row['description']) ?></p>
                        <p class="card-text"><strong>Price:</strong> <?= htmlspecialchars($row['price']) ?> TZS</p>
                        <a href="book.php?service_id=<?= $row['id'] ?>" class="btn btn-primary">Book Now</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>
