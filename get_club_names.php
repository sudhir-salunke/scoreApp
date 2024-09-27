<?php
session_start();
header('Content-Type: application/json');

require 'database.php'; // Include your database connection

// if (!isset($_SESSION['user_id'])) {
//     echo json_encode(['success' => false, 'message' => 'User not logged in.']);
//     exit;
// }

// $userId = $_SESSION['user_id'];
$userId = 1;

// Fetch club names for the logged-in user
try {
    $stmt = $pdo->prepare('SELECT id, name FROM register_club WHERE user_id = ?');
    $stmt->execute([$userId]);
    $clubs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'clubs' => $clubs]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
