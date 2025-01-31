<?php

// Debug: Output POST data to see if form is submitted correctly


// Fetch POST data
$name = $_POST['name'] ?? null;
$phone = $_POST['phone'] ?? null;
$email = $_POST['email'] ?? null;
$message = $_POST['message'] ?? null;

// Validate required fields
if (!$name || !$phone || !$email || !$message) {
    die("All fields are required.");
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'ram');

// Check connection
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
} else {
    echo "Database connection successful!"; // Debug message
}

// Prepare SQL statement
$stmt = $conn->prepare("INSERT INTO comment (name, phone, email, message) VALUES (?, ?, ?, ?)");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

// Bind parameters - Changed phone to string (s)
$stmt->bind_param("ssss", $name, $phone, $email, $message);

// Execute and check for success
if ($stmt->execute()) {
    echo "Message submitted successfully!";
} else {
    // Log and display detailed error message
    echo "Error executing statement: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$conn->close();

?>
