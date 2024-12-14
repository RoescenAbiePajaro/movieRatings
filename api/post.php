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

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!isset($data['movie_title']) || !isset($data['comment'])) {
    echo json_encode(['error' => 'Required data (movie_title, comment) is missing']);
    exit();
}

$movie_title = htmlspecialchars(trim($data['movie_title']), ENT_QUOTES, 'UTF-8');
$comment = htmlspecialchars(trim($data['comment']), ENT_QUOTES, 'UTF-8');

if (empty($movie_title) || empty($comment)) {
    echo json_encode(['error' => 'Movie title and comment cannot be empty']);
    exit();
}

try {
    $encrypted_title = encryptData($movie_title, $key);
    $encrypted_comment = encryptData($comment, $key);

    $query = "INSERT INTO movie_comments (movie_title, comment) VALUES (:movie_title, :comment)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':movie_title', $encrypted_title, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $encrypted_comment, PDO::PARAM_STR);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Comment submitted successfully!']);
    } else {
        echo json_encode(['error' => 'Failed to submit comment']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
