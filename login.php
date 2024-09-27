<?php
session_start();
header('Content-Type: application/json');

// Database connection (update with your credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "score_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed']));
}

// Process POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $mobile = $input['mobile'];

    // Check if the mobile number exists in the database
    $stmt = $conn->prepare("SELECT id FROM users WHERE mobile = ?");
    $stmt->bind_param("s", $mobile);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Mobile number found, start session
        $stmt->bind_result($user_id);
        $stmt->fetch();
        $_SESSION['user_id'] = $user_id;
        echo json_encode(['success' => true, 'message' => 'Login successful']);
    } else {
        // Mobile number not found, insert new user
        $stmt = $conn->prepare("INSERT INTO users (mobile) VALUES (?)");
        $stmt->bind_param("s", $mobile);
        if ($stmt->execute()) {
            $_SESSION['user_id'] = $stmt->insert_id;
            echo json_encode(['success' => true, 'message' => 'Login successful, new user registered']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Registration failed']);
        }
    }

    $stmt->close();
}

$conn->close();
?>