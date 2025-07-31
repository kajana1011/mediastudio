<?php

include '../helpers/db.php';

// USERS
$conn->query("DELETE FROM users");
$conn->query("INSERT INTO users (name, email, password, phone, role, is_active) VALUES
    ('Admin User', 'admin@studio.com', '" . password_hash('admin123', PASSWORD_DEFAULT) . "', '0712345678', 'admin', 1),
    ('Staff One', 'staff1@studio.com', '" . password_hash('staff123', PASSWORD_DEFAULT) . "', '0723456789', 'staff', 1),
    ('Client One', 'client1@studio.com', '" . password_hash('client123', PASSWORD_DEFAULT) . "', '0734567890', 'client', 1),
    ('Client Two', 'client2@studio.com', '" . password_hash('client123', PASSWORD_DEFAULT) . "', '0745678901', 'client', 1)
    ");
    
    // SERVICES
try{
$conn->query("DELETE FROM services");
$conn->query("INSERT INTO services (name, description, price, sample_image, category, is_active) VALUES
    ('Wedding Photography', 'Professional wedding photography service.', 500.00, 'assets/images/sample1.jpg', 'Photography', 1),
    ('Event Video', 'High-quality event video coverage.', 800.00, 'assets/images/sample2.jpg', 'Videography', 1),
    ('Portrait Session', 'Studio portrait session.', 200.00, 'assets/images/sample3.jpg', 'Photography', 1),
    ('Photo Printing', 'High-resolution photo printing.', 50.00, 'assets/images/sample4.jpg', 'Printing', 1)
");

// PORTFOLIO
$conn->query("DELETE FROM portfolio");
$conn->query("INSERT INTO portfolio (title, description, media_type, file_path, thumbnail_path, is_active) VALUES
    ('Bride & Groom', 'A beautiful wedding moment.', 'image', 'uploads/portfolio1.jpg', 'uploads/thumb1.jpg', 1),
    ('Birthday Party', 'Fun birthday party video.', 'video', 'uploads/portfolio2.mp4', 'uploads/thumb2.jpg', 1),
    ('Family Portrait', 'Family studio portrait.', 'image', 'uploads/portfolio3.jpg', 'uploads/thumb3.jpg', 1),
    ('Graduation Day', 'Graduation celebration video.', 'video', 'uploads/portfolio4.mp4', 'uploads/thumb4.jpg', 1)
");

// BOOKINGS
$conn->query("DELETE FROM bookings");
$conn->query("INSERT INTO bookings (user_id, service_id, client_name, client_location, phone, email, booking_date, notes, status) VALUES
    (3, 1, 'Client One', 'Dar es Salaam', '0734567890', 'client1@studio.com', '2025-08-01', 'Wedding booking', 'confirmed'),
    (4, 2, 'Client Two', 'Arusha', '0745678901', 'client2@studio.com', '2025-08-05', 'Event video booking', 'pending'),
    (3, 3, 'Client One', 'Mwanza', '0734567890', 'client1@studio.com', '2025-08-10', 'Portrait session', 'completed'),
    (4, 4, 'Client Two', 'Dodoma', '0745678901', 'client2@studio.com', '2025-08-15', 'Photo printing', 'cancelled')
");

// TESTIMONIALS
$conn->query("DELETE FROM testimonials");
$conn->query("INSERT INTO testimonials (user_id, service_id, client_name, feedback, is_approved) VALUES
    (3, 1, 'Client One', 'Amazing wedding photos!', 1),
    (4, 2, 'Client Two', 'Great event video coverage.', 1),
    (3, 3, 'Client One', 'Loved the portrait session.', 1),
    (4, 4, 'Client Two', 'Photo prints were top quality.', 1)
");

// CUSTOMER MEDIA
$conn->query("DELETE FROM customer_media");
$conn->query("INSERT INTO customer_media (user_id, booking_id, file_path, media_type, description, is_active) VALUES
    (3, 1, 'assets/client_media/client1_photo1.jpg', 'image', 'Wedding photo for Client One', 1),
    (4, 2, 'assets/client_media/client2_video1.mp4', 'video', 'Event video for Client Two', 1),
    (3, 3, 'assets/client_media/client1_photo2.jpg', 'image', 'Portrait for Client One', 1),
    (4, 4, 'assets/client_media/client2_photo1.jpg', 'image', 'Printed photo for Client Two', 1)
");

header("Location: ../services");
}

catch(PDOException $e){
    exit;
}
?>