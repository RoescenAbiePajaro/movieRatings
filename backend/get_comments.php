<?php
// Enable CORS for all origins
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");

// If it's an OPTIONS request (preflight), respond with a success status
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit(0);
}

// Include database connection
require 'connect.php';

try {
    // Query to get all comments
    $stmt = $pdo->query("SELECT id, username, comment, timestamp FROM comments ORDER BY timestamp DESC");
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return comments as JSON
    echo json_encode($comments);
} catch (PDOException $e) {
    // Handle database connection errors
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed: " . $e->getMessage()]);
}
?>
