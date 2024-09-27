<?php
header('Content-Type: application/json');
require 'database.php'; // Include your database connection

// if (!isset($_SESSION['user_id'])) {
//     echo json_encode(['success' => false, 'message' => 'User not logged in.']);
//     exit;
// }

$userId =1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $tournamentName = trim($input['tournamentName']);
    $register_club_id = trim($input['register_club_id']);
    $season = trim($input['season']);
    $season_year = trim($input['season_year']);
    $ball_type = trim($input['ballType']);    
    $startDate = $input['startDate'];
    $endDate = $input['endDate'];

    // Server-side validation
    if (empty($tournamentName) || empty($register_club_id) || empty($season) || empty($season_year) || empty($ball_type) || empty($startDate) || empty($endDate)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    if (strtotime($startDate) > strtotime($endDate)) {
        echo json_encode(['success' => false, 'message' => 'End date must be after start date.']);
        exit;
    }

    // Insert into the database
    try {
        $stmt = $pdo->prepare('INSERT INTO tournaments (name, register_club_id, season, season_year, ball_type, start_date, end_date, user_id) VALUES (?, ?, ?, ?, ?,?,?,?)');
        $stmt->execute([$tournamentName, $register_club_id, $season, $season_year, $ball_type, $startDate, $endDate, $userId]);
        echo json_encode(['success' => true, 'message' => 'Tournament created successfully']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
}
?>
