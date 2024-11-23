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

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the POST data
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $comment = isset($_POST['comment']) ? $_POST['comment'] : '';

    // Basic validation
    if (empty($username) || empty($comment)) {
        http_response_code(400); // Bad Request
        echo json_encode(["error" => "Username and comment are required"]);
        exit();
    }

    // Insert comment into the database
    $stmt = $pdo->prepare("INSERT INTO comments (username, comment, timestamp) VALUES (?, ?, ?)");
    $stmt->execute([$username, $comment, date('Y-m-d H:i:s')]);

    // Respond with success
    echo json_encode(["success" => "Comment added successfully"]);
} else {
    // Handle invalid request method
    http_response_code(405); // Method Not Allowed
    echo json_encode(["error" => "Invalid request method"]);
}
?>
