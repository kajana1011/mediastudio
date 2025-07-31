-- Users: login and registration    
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    role ENUM('admin', 'staff', 'client') DEFAULT 'client',
    is_active TINYINT(1) DEFAULT 1,
    last_login DATETIME,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Portfolio: photos and videos
CREATE TABLE portfolio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100),
    description TEXT,
    media_type ENUM('image', 'video'),
    file_path VARCHAR(255),
    thumbnail_path VARCHAR(255),
    is_active TINYINT(1) DEFAULT 1,
    uploaded_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Services offered (with sample image)
CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    description TEXT,
    price DECIMAL(10,2),
    sample_image VARCHAR(255),
    category VARCHAR(100),
    is_active TINYINT(1) DEFAULT 1
);

-- Bookings: service requests
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    service_id INT,
    client_name VARCHAR(100),
    client_location VARCHAR(255),
    phone VARCHAR(20),
    email VARCHAR(100),
    booking_date DATE,
    notes TEXT,
    requested_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME,
    status ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (service_id) REFERENCES services(id)
);

-- Testimonials: client feedback
CREATE TABLE testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    service_id INT,
    client_name VARCHAR(100),
    feedback TEXT,
    is_approved TINYINT(1) DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (service_id) REFERENCES services(id)
);

-- Customer media: photos and videos uploaded by clients
CREATE TABLE customer_media (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT, -- Link to the client (nullable if guest)
    booking_id INT, -- Link to the booking (optional)
    file_path VARCHAR(255) NOT NULL,
    media_type ENUM('image', 'video') NOT NULL,
    uploaded_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    description TEXT,
    is_active TINYINT(1) DEFAULT 1,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (booking_id) REFERENCES bookings(id)
);

