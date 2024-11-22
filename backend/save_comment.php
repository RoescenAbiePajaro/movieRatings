<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'comments_db');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $comment = $conn->real_escape_string($_POST['comment']);

    // Insert comment into the database
    $sql = "INSERT INTO comments (username, comment) VALUES ('$username', '$comment')";
    if ($conn->query($sql) === TRUE) {
        echo "Comment added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
