<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'comment_db');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch comments
$sql = "SELECT username, comment, timestamp FROM comments ORDER BY timestamp DESC";
$result = $conn->query($sql);

$comments = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $comments[] = $row;
    }
}

echo json_encode($comments);

$conn->close();
?>
