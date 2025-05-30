<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION["email"])) {
    header("location: /projectlab2/login/login.php");
    exit();
}

// Include database connection settings
$host = "127.0.0.1";
$dbname = "ecommerce";
$username = "root";
$password = "";

try {
    // Create a new PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare and execute the query to check if user exists
    $stmt = $pdo->prepare("SELECT email FROM users WHERE email = :email");
    $stmt->bindParam(":email", $_SESSION["email"], PDO::PARAM_STR);
    $stmt->execute();

    // If the user does not exist, destroy session and redirect to login
    if (!$stmt->fetchColumn()) {
        session_destroy();
        header("location: /projectlab2/login/login.php");
        exit();
    }

    // Regenerate session ID for security
    session_regenerate_id(true);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>