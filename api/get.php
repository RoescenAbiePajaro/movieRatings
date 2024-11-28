<?php
header("Access-Control-Allow-Origin: http://localhost:5173"); // Frontend URL
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'connect.php'; // Include the database connection

// Get movie_title from the query string
$movie_title = isset($_GET['movie_title']) ? $_GET['movie_title'] : '';

if (empty($movie_title)) {
    echo json_encode(['error' => 'Movie title is required']);
    exit();
}

try {
    // Fetch comments for the specific movie
    $query = "SELECT * FROM movie_comments WHERE movie_title = :movie_title ORDER BY created_at DESC";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':movie_title', $movie_title);
    $stmt->execute();

    // Fetch the results and encode them in JSON format
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($comments);

} catch (PDOException $e) {
    // Catch any database-related errors
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
