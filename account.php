<?php
session_start(); // Start the session

header('Content-Type: application/json'); // Ensure JSON response

// Database configuration
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "spotifywebsite";

// Response array
$response = ["success" => false, "message" => "", "data" => null];

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $response["message"] = "Unauthorized access. Please log in.";
    echo json_encode($response);
    exit();
}

$userId = $_SESSION['user_id'];

// Connect to database
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    $response["message"] = "Database connection failed: " . $conn->connect_error;
    echo json_encode($response);
    exit();
}

// Handle different request methods
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // --- Handle Fetching User Data (GET) ---
    // Removed 'name' AND 'company' from the SELECT statement
    $stmt = $conn->prepare("SELECT username, email FROM users WHERE id = ?");
    if (!$stmt) {
        $response["message"] = "Database prepare error (GET): " . $conn->error;
        echo json_encode($response);
        $conn->close();
        exit();
    }

    $stmt->bind_param("i", $userId);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($userData = $result->fetch_assoc()) {
            $response["success"] = true;
            $response["message"] = "User data fetched successfully.";
            $response["data"] = $userData; // Will contain username, email
        } else {
            $response["message"] = "User not found.";
        }
    } else {
        $response["message"] = "Database execute error (GET): " . $stmt->error;
    }
    $stmt->close();

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // --- Handle Updating User Data (POST) ---
    $username_update = $_POST['username'] ?? null;
    // $name_update variable is removed
    $email_update = $_POST['email'] ?? null;
    // $company_update variable is removed

    // Basic validation
    if (empty($username_update) || empty($email_update)) {
        $response["message"] = "Username and Email cannot be empty.";
        echo json_encode($response);
        $conn->close();
        exit();
    }
    if (!filter_var($email_update, FILTER_VALIDATE_EMAIL)) {
        $response["message"] = "Invalid email format.";
        echo json_encode($response);
        $conn->close();
        exit();
    }

    // Prepare UPDATE statement - Removed 'name = ?' AND 'company = ?'
    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
     if (!$stmt) {
        $response["message"] = "Database prepare error (POST): " . $conn->error;
        echo json_encode($response);
        $conn->close();
        exit();
    }

    // Bind parameters - Removed bindings for name and company
    // Binding signature changed from "sssi" to "ssi"
    $stmt->bind_param("ssi", $username_update, $email_update, $userId);

    // Execute update
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $response["success"] = true;
            $response["message"] = "Profile updated successfully.";
        } else {
             $response["success"] = true;
            $response["message"] = "No changes detected or profile already up-to-date.";
        }
    } else {
        if ($conn->errno == 1062) {
             $response["message"] = "Error updating profile: Email address already in use.";
        } else {
             $response["message"] = "Error updating profile: " . $stmt->error;
        }
    }
    $stmt->close();

} else {
    $response["message"] = "Invalid request method.";
}

$conn->close();
echo json_encode($response);
?>