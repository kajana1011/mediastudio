<?php
session_start();
include_once "../includes/header.php";
include_once "../helpers/db.php";


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header('Location: ../auth/login');
        exit; 
    }
$success = $error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $category = $_POST["category"];
    $is_active = isset($_POST["is_active"]) ? 1 : 0;

    // Handle sample image upload
    $sample_image_path = "";
    if (isset($_FILES["sample_image"]) && $_FILES["sample_image"]["error"] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . "/../uploads/";
        $fileName = time() . "_" . basename($_FILES["sample_image"]["name"]);
        $targetFile = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES["sample_image"]["tmp_name"], $targetFile)) {
            $sample_image_path = "uploads/" . $fileName;
        } else {
            $error = "Failed to upload sample image.";
        }
    }

    if (empty($error)) {
        $stmt = $conn->prepare("INSERT INTO services (name, description, price, sample_image, category, is_active) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdssi", $name, $description, $price, $sample_image_path, $category, $is_active);

        if ($stmt->execute()) {
            $success = "Service added successfully!";
        } else {
            $error = "Database error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Add New Service</h4>
                </div>
                <div class="card-body">
                    <?php if ($success): ?>
                        <div class="alert alert-success"><?= $success ?></div>
                    <?php elseif ($error): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>

                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Service Name *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Price (TZS) *</label>
                            <input type="number" name="price" step="0.01" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <input type="text" name="category" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sample Image</label>
                            <input type="file" name="sample_image" class="form-control" accept="image/*">
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" checked>
                            <label for="is_active" class="form-check-label">Active</label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Add Service</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center mt-3">
                <a href="services.php" class="text-decoration-none">&larr; Back to Services List</a>
            </div>
        </div>
    </div>
</div>

<?php include_once "../includes/footer.php"; ?>

