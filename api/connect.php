<?php
$servername = "localhost";
$username = "root"; // XAMPP default username
$password = ""; // XAMPP default password is empty
$dbname = "movie_reviews"; // New database name

try {
    // Establish the PDO connection to the new database
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Connection failed: ' . $e->getMessage()]);
    exit();
}
?>
