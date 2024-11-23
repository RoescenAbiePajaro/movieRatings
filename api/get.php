<?php
header("Access-Control-Allow-Origin: http://localhost:5173"); // Frontend URL
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'connect.php'; // Include the database connection

// Fetch all top-level comments (where reply_id is 0)
$query = "SELECT * FROM comments WHERE reply_id = 0 ORDER BY timestamp DESC";
$stmt = $conn->prepare($query);
$stmt->execute();

// Fetch the results and encode them in JSON format
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($comments);
?>
