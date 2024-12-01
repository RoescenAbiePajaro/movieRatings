<?php


// CORS headers to allow requests from your frontend (ensure frontend matches this domain)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");

// Handle OPTIONS requests to enable pre-flight CORS checksy
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}

// Include database connection file
include 'connect.php';

// Get the raw input data
$input = file_get_contents('php://input');

// Log raw input for debugging
file_put_contents('php://stderr', "Raw input: " . $input . "\n");

// Decode the JSON input
$data = json_decode($input, true);

// Check if required data is present
if (!isset($data['movie_title']) || !isset($data['comment'])) {
    echo json_encode(['error' => 'Required data (movie_title, comment) is missing']);
    exit();
}

// Sanitize and trim inputs
$movie_title = htmlspecialchars(trim($data['movie_title']), ENT_QUOTES, 'UTF-8');
$comment = htmlspecialchars(trim($data['comment']), ENT_QUOTES, 'UTF-8');

// Check if inputs are empty
if (empty($movie_title) || empty($comment)) {
    echo json_encode(['error' => 'Movie title and comment cannot be empty']);
    exit();
}

// Attempt to insert the comment into the database
try {
    $query = "INSERT INTO movie_comments (movie_title, comment) VALUES (:movie_title, :comment)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':movie_title', $movie_title, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Comment submitted successfully!']);
    } else {
        echo json_encode(['error' => 'Failed to submit comment']);
    }
} catch (PDOException $e) {
    // Log the error message and show a friendly message
    file_put_contents('php://stderr', "Database error: " . $e->getMessage() . "\n");
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
