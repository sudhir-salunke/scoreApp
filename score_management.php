<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "score_management";  // Update with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $score = $input['score'] ?? 0;
    $wickets = $input['wickets'] ?? 0;
    $overs = $input['overs'] ?? 0;

    $sql = "INSERT INTO match_scores (score, wickets, overs) VALUES ('$score', '$wickets', '$overs')";
    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
        echo json_encode([
            'success' => 'Score updated successfully',
            'last_id' => $last_id
        ]);
    } else {
        echo json_encode(['error' => 'Error: ' . $sql . '<br>' . $conn->error]);
    }
} elseif ($method == 'GET') {
    $sql = "SELECT id, score, wickets, overs FROM match_scores ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'No data found']);
    }
}

$conn->close();
?>
