<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}

include 'connect.php';
include 'encrypt_decrypt.php'; // Include encryption/decryption functions

$key = 'your-secure-encryption-key'; // Replace with a secure key

$movie_title = isset($_GET['movie_title']) ? htmlspecialchars(trim($_GET['movie_title']), ENT_QUOTES, 'UTF-8') : '';

if (empty($movie_title)) {
    echo json_encode(['error' => 'Movie title is required']);
    exit();
}

try {
    $query = "SELECT comment, created_at FROM movie_comments WHERE movie_title = :movie_title ORDER BY created_at DESC";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':movie_title', encryptData($movie_title, $key), PDO::PARAM_STR); // Encrypt search term
    $stmt->execute();
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Decrypt the retrieved comments
    foreach ($comments as &$comment) {
        $comment['comment'] = decryptData($comment['comment'], $key);
    }

    echo json_encode($comments);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
