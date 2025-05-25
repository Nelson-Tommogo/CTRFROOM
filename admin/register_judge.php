<?php
session_start();
require_once '../config/db_connect.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Handle form submission for adding a new judge
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $display_name = trim($_POST['display_name']);
    
    // Basic validation
    if (empty($username) || empty($password) || empty($confirm_password) || empty($display_name)) {
        $error = "All fields are required";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match";
    } elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters long";
    } else {
        try {
            // Check if username already exists
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM judges WHERE username = ?");
            $stmt->execute([$username]);
            $count = $stmt->fetchColumn();
            
            if ($count > 0) {
                $error = "Username already exists";
            } else {
                // Hash the password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                // Insert new judge
                $stmt = $pdo->prepare("INSERT INTO judges (username, password, display_name) VALUES (?, ?, ?)");
                $stmt->execute([$username, $hashed_password, $display_name]);
                $success = "Judge registered successfully!";
            }
        } catch (PDOException $e) {
            $error = "Error registering judge: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Judge - Scoring System</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Admin Panel</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Dashboard</a></li>
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="../scoreboard.php">Scoreboard</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </header>
        
        <main>
            <section class="register-judge">
                <h2>Register New Judge</h2>
                
                <?php if (isset($error)): ?>
                    <div class="error"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <?php if (isset($success)): ?>
                    <div class="success"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <form method="post">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required minlength="8">
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password:</label>
                        <input type="password" id="confirm_password" name="confirm_password" required minlength="8">
                    </div>
                    
                    <div class="form-group">
                        <label for="display_name">Display Name:</label>
                        <input type="text" id="display_name" name="display_name" required>
                    </div>
                    
                    <button type="submit">Register Judge</button>
                </form>
            </section>
        </main>
    </div>
</body>
</html>