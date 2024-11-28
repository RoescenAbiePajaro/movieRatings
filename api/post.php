<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204); // No Content response
    exit();

}

include 'connect.php'; // Include the database connection

// Get the raw POST data and decode it
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Check if the required data is available
if (!isset($data['movie_title']) || !isset($data['comment'])) {
    echo json_encode(['error' => 'Required data (movie_title, comment) is missing']);
    exit();
}

$movie_title = trim($data['movie_title']);
$comment = trim($data['comment']);

// Validate the movie title and comment
if (empty($movie_title) || empty($comment)) {
    echo json_encode(['error' => 'Movie title and comment cannot be empty']);
    exit();
}

// Further sanitize inputs to avoid any unwanted characters (security best practice)
$movie_title = htmlspecialchars($movie_title, ENT_QUOTES, 'UTF-8');
$comment = htmlspecialchars($comment, ENT_QUOTES, 'UTF-8');

try {
    // Check database connection
    if (!$conn) {
        throw new Exception('Database connection failed');
    }

    // Prepare and execute the SQL query
    $query = "INSERT INTO movie_comments (movie_title, comment) VALUES (:movie_title, :comment)";
    $stmt = $conn->prepare($query);

    // Bind the parameters safely
    $stmt->bindParam(':movie_title', $movie_title, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);

    // Execute the query
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Comment submitted successfully!']);
    } else {
        echo json_encode(['error' => 'Failed to submit comment']);
    }

} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(['error' => 'An error occurred: ' . $e->getMessage()]);
}
?>
