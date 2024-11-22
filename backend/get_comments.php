<?php
// Enable CORS
header("Access-Control-Allow-Origin: *");  // Allows requests from any domain
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true"); // Allow credentials

// If it's an OPTIONS request (preflight), respond with a success status
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit(0);
}

// Connect to your database
$host = 'localhost'; // Your database host
$dbname = 'comment_db'; // Your database name
$username = 'root'; // Your database username
$password = ''; // Your database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to get all comments
    $stmt = $pdo->query("SELECT username, comment, timestamp FROM comments ORDER BY timestamp DESC");
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return comments as JSON
    echo json_encode($comments);

} catch (PDOException $e) {
    // Handle database connection errors
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed: " . $e->getMessage()]);
}
?>
