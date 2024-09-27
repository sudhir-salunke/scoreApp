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

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

// Process POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $clubName = $conn->real_escape_string($input['clubName']);
    $city = $conn->real_escape_string($input['city']);
    $establishedYear = (int)$input['establishedYear'];
    $pincode = $conn->real_escape_string($input['pincode']);
    $ballType = $conn->real_escape_string($input['ballType']);
    $userId = (int)$_SESSION['user_id'];

    // Validate inputs
    if (empty($clubName) || empty($city) || empty($establishedYear) || empty($pincode) || empty($ballType)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all fields.']);
        exit;
    }

    if (!preg_match('/^\d{6}$/', $pincode)) { // Assuming pin code is 6 digits
        echo json_encode(['success' => false, 'message' => 'Invalid pin code format.']);
        exit;
    }

    // Build the SQL query
    $sql = "INSERT INTO register_club (name, city, pincode, establishedYear, ball_type, user_id) 
            VALUES ('$clubName', '$city', '$pincode', $establishedYear, '$ballType', $userId)";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Club registered successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to register club.']);
    }
}

$conn->close();
?>