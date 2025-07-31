<?php
    require_once 'db.php';
// Fetch all services
function getServices($conn) {
    $sql = "SELECT * FROM services";
    $result = $conn->query($sql);
    $services = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $services[] = $row;
        }
    }
    return $services;
}

// Fetch all portfolio items
function getPortfolio($conn) {
    $sql = "SELECT * FROM portfolio ORDER BY uploaded_at DESC";
    $result = $conn->query($sql);
    $portfolio = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $portfolio[] = $row;
        }
    }
    return $portfolio;
}

// Fetch all testimonials
function getTestimonials($conn) {
    $sql = "SELECT * FROM testimonials ORDER BY created_at DESC";
    $result = $conn->query($sql);
    $testimonials = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $testimonials[] = $row;
        }
    }
    return $testimonials;
}

// Function to handle booking requests
function handleBooking($conn, $data) {
    $service_type = $data['service_type'];
    $date = $data['date'];
    $phone = $data['phone'];
    $client_location = isset($data['client_location']) ? $data['client_location'] : '';

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO bookings (service_type, date, phone, client_location) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $service_type, $date, $phone, $client_location);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Booking request submitted successfully!";
    } else {
        $_SESSION['error'] = "Error submitting booking request: " . $stmt->error;
    }

    $stmt->close();
}       