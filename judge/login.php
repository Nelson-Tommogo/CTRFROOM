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
        $stmt = $pdo->prepare("SELECT * FROM judges WHERE username = ?");
        $stmt->execute([$username]);
        $judge = $stmt->fetch();

        if ($judge && password_verify($password, $judge['password'])) {
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
    <title>Judge Login - Scoring System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 960px;
            margin: auto;
            padding: 20px;
            background: #fff;
            min-height: 100vh;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        header {
            background: #2c3e50;
            color: white;
            padding: 20px 0;
            text-align: center;
        }
        header nav ul {
            list-style: none;
            padding: 0;
            margin: 10px 0 0;
            display: flex;
            justify-content: center;
        }
        header nav ul li {
            margin: 0 15px;
        }
        header nav ul li a {
            color: #ecf0f1;
            text-decoration: none;
            font-weight: bold;
        }
        header nav ul li a:hover {
            text-decoration: underline;
        }
        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
        }
        .login-form {
            max-width: 500px;
            margin: auto;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: 600;
            margin-bottom: 6px;
            display: block;
            color: #333;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background: #27ae60;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background: #1e8449;
        }
        .error {
            background: #e74c3c;
            color: white;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        @media (max-width: 600px) {
            header nav ul {
                flex-direction: column;
                align-items: center;
            }
            header nav ul li {
                margin: 10px 0;
            }
        }
    </style>
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
                        <input type="text" name="username" id="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" name="password" id="password" required>
                    </div>
                    <button type="submit">Login</button>
                </form>
            </section>
        </main>
    </div>
</body>
</html>
