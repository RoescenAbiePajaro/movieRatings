

<?php
$servername = "sql304.infinityfree.com";
$username = "	if0_37824771"; // Default XAMPP username
$password = "yeboi222GB"; // Default XAMPP password is empty
$dbname = "if0_37824771_movie_reviews"; // Database name

try {
    // Establish PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Connection failed: ' . $e->getMessage()]);
    exit();
}
?>

