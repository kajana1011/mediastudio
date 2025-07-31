<?php
session_start();
include_once "../includes/header.php";
include_once "../helpers/db.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header('Location: ../auth/login');
        exit; 
    }
    
$success = $error = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $media_type = $_POST["media_type"];

    $file_path = "";
    $thumbnail_path = "";

    // Handle main file upload
    if (isset($_FILES["media_file"]) && $_FILES["media_file"]["error"] === UPLOAD_ERR_OK) {
        $targetDir = "../uploads/";
        $fileName = time() . "_" . basename($_FILES["media_file"]["name"]);
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES["media_file"]["tmp_name"], $targetFile)) {
            $file_path = "uploads/" . $fileName;
        } else {
            $error = "Failed to upload media file.";
        }
    }

    // Handle thumbnail upload
    if (isset($_FILES["thumbnail"]) && $_FILES["thumbnail"]["error"] === UPLOAD_ERR_OK) {
        $thumbName = time() . "_thumb_" . basename($_FILES["thumbnail"]["name"]);
        $thumbTarget = $targetDir . $thumbName;

        if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $thumbTarget)) {
            $thumbnail_path = "uploads/" . $thumbName;
        } else {
            $error = "Failed to upload thumbnail.";
        }
    }

    if (empty($error)) {
        $stmt = $conn->prepare("INSERT INTO portfolio (title, description, media_type, file_path, thumbnail_path) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $title, $description, $media_type, $file_path, $thumbnail_path);

        if ($stmt->execute()) {
            $success = "Portfolio item uploaded successfully!";
        } else {
            $error = "Database error: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Add to Portfolio</h4>
                </div>
                <div class="card-body">
                    <?php if ($success): ?>
                        <div class="alert alert-success"><?= $success ?></div>
                    <?php elseif ($error): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>

                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Title *</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Media Type *</label>
                            <select name="media_type" class="form-select" required>
                                <option value="image">Image</option>
                                <option value="video">Video</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Media File *</label>
                            <input type="file" name="media_file" class="form-control" accept="image/*,video/*" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Thumbnail (optional)</label>
                            <input type="file" name="thumbnail" class="form-control" accept="image/*">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center mt-3">
                <a href="portfolios.php" class="text-decoration-none">&larr; Back to Portfolio List</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
<?php
include_once "../includes/footer.php"; 
?>