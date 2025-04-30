<?php
session_start(); // Start the session at the very beginning

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "spotifywebsite";

header('Content-Type: application/json'); // Ensure JSON response

// Connect to database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
    exit();
}

// Get email and password from POST data
$email = $_POST['email'] ?? null;
$password_input = $_POST['password'] ?? null; // Renamed to avoid conflict

if (!$email || !$password_input) {
     echo json_encode(["success" => false, "message" => "Email and password are required."]);
     exit();
}

// Prepare statement to prevent SQL injection
$stmt = $conn->prepare("SELECT id, email, password FROM users WHERE email = ?");
if (!$stmt) {
    echo json_encode(["success" => false, "message" => "Database prepare error: " . $conn->error]);
    exit();
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Verify the password
    if (password_verify($password_input, $user['password'])) {
        // Password is correct, set session variable
        $_SESSION['user_id'] = $user['id']; // Store user ID in session

        echo json_encode(["success" => true, "message" => "Login successful."]);
    } else {
        // Invalid password
        echo json_encode(["success" => false, "message" => "Invalid email or password."]); // Generic message for security
    }
} else {
    // No user found with that email
    echo json_encode(["success" => false, "message" => "Invalid email or password."]); // Generic message for security
}

$stmt->close();
$conn->close();
?>