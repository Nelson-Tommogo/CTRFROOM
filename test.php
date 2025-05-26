<?php
$host = '127.0.0.1'; // Force TCP/IP instead of socket
$db = 'smartmav_event_scoring_system';
$user = 'smartmav_event';
$pass = '6LDz6e}i[DeJ';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    $stmt = $pdo->query("SELECT NOW() AS current_time");
    $row = $stmt->fetch();

    echo "<h2>Database Connection Successful!</h2>";
    echo "<p>Current server time: <strong>" . $row['current_time'] . "</strong></p>";

    // Optional: log to terminal (Linux/Mac only)
    error_log("✅ DB connection successful at " . $row['current_time'] . "\n", 3, "/tmp/db_test_log.log");

} catch (PDOException $e) {
    echo "<h2>Database Connection Failed</h2>";
    echo "<p>Error: " . $e->getMessage() . "</p>";

    // Log detailed error to terminal log
    error_log("❌ DB connection failed: " . $e->getMessage() . "\n", 3, "/tmp/db_test_log.log");
}
?>
