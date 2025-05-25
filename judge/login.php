<?php
session_start();
require_once '../config/db_connect.php';

// Check if already logged in
if (isset($_SESSION['judge_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    if (empty($username) || empty($password)) {
        $error = 'Please enter both username and password';
    } else {
        // Get judge from database
        $stmt = $pdo->prepare("SELECT * FROM judges WHERE username = ?");
        $stmt->execute([$username]);
        $judge = $stmt->fetch();
        
        if ($judge && password_verify($password, $judge['password'])) {
            // Login successful
            $_SESSION['judge_id'] = $judge['judge_id'];
            $_SESSION['judge_username'] = $judge['username'];
            $_SESSION['judge_display_name'] = $judge['display_name'];
            $_SESSION['user_type'] = 'judge';
            
            header('Location: index.php');
            exit;
        } else {
            $error = 'Invalid username or password';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Judge Login - Scoring System</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Judge Login</h1>
            <nav>
                <ul>
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="../admin/login.php">Admin Login</a></li>
                    <li><a href="../scoreboard.php">Scoreboard</a></li>
                </ul>
            </nav>
        </header>
        
        <main>
            <section class="login-form">
                <h2>Judge Login</h2>
                
                <?php if (!empty($error)): ?>
                    <div class="error"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="post">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    
                    <button type="submit">Login</button>
                </form>
            </section>
        </main>
    </div>
</body>
</html>