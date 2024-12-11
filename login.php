<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "spotifywebsite";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Connection failed."]);
    exit();
}


$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();


if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    
    
    if (password_verify($password, $user['password'])) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Invalid password."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "No user found with that email."]);
}


$stmt->close();
$conn->close();
?>
