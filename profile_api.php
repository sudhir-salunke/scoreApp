<?php
session_start(); // Start the session to store user ID

header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_management";  // Update with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['error' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize input data
    $fullName = $conn->real_escape_string($_POST['fullName']);
    $mobileNumber = $conn->real_escape_string($_POST['mobileNumber']);
    $email = $conn->real_escape_string($_POST['email']);
    $jerseyName = $conn->real_escape_string($_POST['jerseyName']);
    $jerseyNumber = intval($_POST['jerseyNumber']);

    // Handle file upload
    $photo = $_FILES['photo'];
    $photoPath = '';

    if ($photo['error'] === UPLOAD_ERR_OK) {
        // Ensure the uploads directory exists
        $uploadDir = 'uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Insert into database first to get user ID
        $sql = "INSERT INTO users (full_name, mobile_number, email, jersey_name, jersey_number) VALUES ('$fullName', '$mobileNumber', '$email', '$jerseyName', $jerseyNumber)";
        
        if ($conn->query($sql) === TRUE) {
            // Retrieve the last inserted user ID
            $userId = $conn->insert_id;

            // Create user-specific directory inside uploads
            $profileDir = $uploadDir . 'profile/' . $userId . '/';
            if (!file_exists($profileDir)) {
                mkdir($profileDir, 0755, true);
            }

            // Move the uploaded photo to the user-specific directory
            $photoPath = $profileDir . basename($photo['name']);
            if (move_uploaded_file($photo['tmp_name'], $photoPath)) {
                // Update photo path in database
                $updateSql = "UPDATE users SET photo = '$photoPath' WHERE id = $userId";
                if ($conn->query($updateSql) === TRUE) {
                    // Store user ID in session
                    $_SESSION['user_id'] = $userId;
                    echo json_encode(['success' => 'User created successfully']);
                } else {
                    echo json_encode(['error' => 'Error updating photo path: ' . $conn->error]);
                }
            } else {
                echo json_encode(['error' => 'Failed to move uploaded photo']);
            }
        } else {
            echo json_encode(['error' => 'Error inserting user: ' . $conn->error]);
        }
    } else {
        echo json_encode(['error' => 'File upload error: ' . $photo['error']]);
    }

    $conn->close();
}
?>
