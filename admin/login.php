<?php
session_start();
require_once '../config/db_connect.php';

// Redirect if already logged in
if (isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';

// Local fallback users (offline login)
$local_users = [
    'admin' => [
        'password_hash' => '$2y$10$s5G2VZ/nvhFK2DgQztvOaOWql7/n1ub01wYP5EKwdvHvuYcefg7mu', // password: admin123
        'display_name' => 'Admin',
        'user_type' => 'admin'
    ],
    'judge' => [
        'password_hash' => '$2y$10$FzPfaQieCjs/4RM3zZ0jH.CWp47GUxVnESoYO8P7HH3/xZdcAK/Je', // password: judge123
        'display_name' => 'Judge',
        'user_type' => 'judge'
    ]
];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = 'Please enter both username and password';
    } else {
        try {
            // Fetch user from DB
            $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
            $stmt->execute([$username]);
            $admin = $stmt->fetch();

            if ($admin && password_verify($password, $admin['password'])) {
                // DB login success
                $_SESSION['admin_id'] = $admin['admin_id'];
                $_SESSION['admin_username'] = $admin['username'];
                $_SESSION['admin_display_name'] = $admin['display_name'];
                $_SESSION['user_type'] = 'admin';

                header('Location: index.php');
                exit;
            } else {
                throw new Exception("Invalid DB credentials or not found.");
            }
        } catch (Exception $e) {
            // Fallback offline login
            if (isset($local_users[$username]) && password_verify($password, $local_users[$username]['password_hash'])) {
                $_SESSION['admin_id'] = 'offline_' . $username;
                $_SESSION['admin_username'] = $username;
                $_SESSION['admin_display_name'] = $local_users[$username]['display_name'];
                $_SESSION['user_type'] = $local_users[$username]['user_type'];

                header('Location: index.php');
                exit;
            } else {
                $error = 'Invalid username or password';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Login - Scoring System</title>
    <style>
        * {
            margin: 0; padding: 0; box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }
        .container {
            max-width: 500px;
            margin: 60px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        header {
            text-align: center;
            margin-bottom: 30px;
        }
        header h1 {
            color: #2c3e50;
            margin-bottom: 10px;
        }
        nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
            gap: 15px;
        }
        nav ul li a {
            text-decoration: none;
            color: #2980b9;
            font-weight: bold;
        }
        nav ul li a:hover {
            text-decoration: underline;
        }
        main h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #34495e;
        }
        .error {
            background: #e74c3c;
            color: white;
            padding: 10px;
            margin-bottom: 20px;
            text-align: center;
            border-radius: 5px;
        }
        .login-form {
            width: 100%;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 1em;
        }
        button[type="submit"] {
            width: 100%;
            padding: 12px;
            background: #27ae60;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button[type="submit"]:hover {
            background: #1e8449;
        }
        @media (max-width: 600px) {
            .container {
                margin: 20px;
                padding: 20px;
            }
            nav ul {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <header>
        <h1>Admin Login</h1>
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="../judge/login.php">Judge Login</a></li>
                <li><a href="../scoreboard.php">Scoreboard</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="login-form">
            <h2>Admin Login</h2>
            <?php if ($error): ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <form method="post" action="">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required autofocus />
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required />
                </div>
                <button type="submit">Login</button>
            </form>
        </section>
    </main>
</div>
</body>
</html>
