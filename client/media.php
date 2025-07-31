<?php
session_start();
include "../includes/header.php"; 
include "../helpers/db.php";  

$user_id = $_SESSION['id'];
?>

<div class="container my-4">
    <h2 class="text-center">My Media Gallery</h2>

    <div class="row">
        <?php
        $stmt = $conn->prepare("SELECT file_path, media_type, description, uploaded_at 
                                FROM customer_media 
                                WHERE user_id = ? AND is_active = 1 
                                ORDER BY uploaded_at DESC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0):
            while ($media = $result->fetch_assoc()):
        ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <?php if ($media['media_type'] === 'image'): ?>
                        <img src="<?= htmlspecialchars($media['file_path']) ?>" class="card-img-top" alt="Media Image">
                    <?php else: ?>
                        <video controls class="card-img-top">
                            <source src="<?= htmlspecialchars($media['file_path']) ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    <?php endif; ?>
                    <div class="card-body">
                        <p class="card-text"><?= nl2br(htmlspecialchars($media['description'])) ?></p>
                        <small class="text-muted">Uploaded on <?= date("F j, Y", strtotime($media['uploaded_at'])) ?></small>
                    </div>
                </div>
            </div>
        <?php endwhile; else: ?>
            <div class="col-12">
                <p class="text-center text-danger">You have no media uploaded yet.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include "../includes/footer.php"; ?>
