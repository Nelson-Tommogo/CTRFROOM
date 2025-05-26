<?php
session_start();
require_once '../config/db_connect.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $display_name = trim($_POST['display_name']);

    if (empty($username) || empty($password) || empty($confirm_password) || empty($display_name)) {
        $error = "All fields are required";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match";
    } elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters long";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM judges WHERE username = ?");
            $stmt->execute([$username]);
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                $error = "Username already exists";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
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
    <title>Register Judge</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
        }
        header h1 {
            text-align: center;
            color: #2a7a6d;
        }
        nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
            padding: 0;
            gap: 15px;
            margin-bottom: 20px;
        }
        nav a {
            text-decoration: none;
            color: #2a7a6d;
            font-weight: bold;
        }
        .error, .success {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .error {
            background-color: #ffe6e6;
            border: 1px solid #f5c6cb;
            color: #a94442;
        }
        .success {
            background-color: #e6ffea;
            border: 1px solid #58d68d;
            color: #1d8348;
        }
        form .form-group {
            margin-bottom: 15px;
        }
        form label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
        }
        form input[type="text"],
        form input[type="password"] {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #2a7a6d;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
        }
        button:hover {
            background-color: #245f58;
        }
    </style>
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

    <section>
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
                <input type="text" name="username" id="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required minlength="8">
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" name="confirm_password" id="confirm_password" required minlength="8">
            </div>

            <div class="form-group">
                <label for="display_name">Display Name:</label>
                <input type="text" name="display_name" id="display_name" required>
            </div>

            <button type="submit">Register Judge</button>
        </form>
    </section>
</div>
</body>
</html>
