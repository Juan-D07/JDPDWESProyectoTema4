<?php
$host = 'localhost';
$db   = 'your_database_name';
$user = 'root';
$pass = 'wrong_password'; // Simulating a typo
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// 1. Set options to handle errors securely
$options = [
    // This tells PDO to throw exceptions when things go wrong
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // 2. Attempt the connection
    $pdo = new PDO($dsn, $user, $pass, $options);
    
    // If the password is correct, execution continues smoothly here
    echo "Connected successfully!"; 

} catch (PDOException $e) {
    // 3. Catch the error so the page does NOT crash
    
    // Log the actual error internally for your eyes only
    error_log("Database connection failed: " . $e->getMessage());

    // Show a clean, user-friendly message to the visitor
    echo "<h1>Service Temporarily Unavailable</h1>";
    echo "<p>We are experiencing technical difficulties. Please try again later.</p>";
    
    // Gracefully stop the script without throwing a fatal crash
    exit; 
}

// 4. The rest of your web page will still load safely below if connection succeeds!
?>
<!DOCTYPE html>
<html>
<body>
    <p>Rest of the webpage layout continues here...</p>
</body>
</html>
