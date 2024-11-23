<?php
header("Access-Control-Allow-Origin: http://localhost:5173"); // Frontend URL
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include 'connect.php'; // Include the database connection

// Check if required POST data is present
if (isset($_POST['username']) && isset($_POST['comment'])) {
    $username = $_POST['username'];
    $comment = $_POST['comment'];
    $reply_id = isset($_POST['reply_id']) ? $_POST['reply_id'] : 0; // Default reply_id is 0 (top-level comment)

    // If reply_id is not 0, ensure the reply_id exists in the database
    if ($reply_id != 0) {
        $query = "SELECT id FROM comments WHERE id = :reply_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':reply_id', $reply_id);
        $stmt->execute();
        $reply = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$reply) {
            echo json_encode(['error' => 'Invalid reply_id: the comment does not exist.']);
            exit();
        }
    }

    try {
        // Insert the comment into the database
        $query = "INSERT INTO comments (username, comment, reply_id) VALUES (:username, :comment, :reply_id)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':comment', $comment);
        $stmt->bindParam(':reply_id', $reply_id);
        $stmt->execute();

        echo json_encode(['message' => 'Comment submitted successfully!']);
    } catch (Exception $e) {
        echo json_encode(['error' => 'Failed to submit comment: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Required data missing']);
}
?>
