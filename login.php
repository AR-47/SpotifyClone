<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "spotifywebsite";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Connection failed."]);
    exit();
}

// Retrieve form data
$email = $_POST['email'];
$password = $_POST['password'];

// Use prepared statements to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    
    // Verify password
    if (password_verify($password, $user['password'])) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Invalid password."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "No user found with that email."]);
}

// Close connections
$stmt->close();
$conn->close();
?>
