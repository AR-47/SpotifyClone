<?php

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "spotifywebsite"; 


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $email = $_POST['email'] ?? null;
    $email_confirm = $_POST['email_confirm'] ?? null;
    $password = $_POST['password'] ?? null;
    $password_confirm = $_POST['password_confirm'] ?? null;
    $username = $_POST['username'] ?? null;
    $dob = $_POST['dob'] ?? null;
    $gender = $_POST['gender'] ?? null;

    
    if ($email !== $email_confirm) {
        die("Email addresses do not match.");
    }

    if ($password !== $password_confirm) {
        die("Passwords do not match.");
    }

    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    
    $stmt = $conn->prepare("INSERT INTO users (email, username, password, date_of_birth, gender) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $email, $username, $hashed_password, $dob, $gender);

    
    if ($stmt->execute()) {
        
        header("Location: index.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    
    $stmt->close();
}


$conn->close();
?>
