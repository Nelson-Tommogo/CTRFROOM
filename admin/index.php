<?php
session_start();

// Define base path for consistent routing
define('BASE_PATH', dirname($_SERVER['SCRIPT_NAME']));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scoring System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }

        header {
            background-color: #2c3e50;
            color: white;
            padding: 20px 0;
            text-align: center;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        header h1 {
            margin-bottom: 10px;
        }

        nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        nav ul li {
            display: inline;
        }

        nav ul li a {
            text-decoration: none;
            color: #ecf0f1;
            padding: 8px 12px;
            border-radius: 4px;
            transition: background 0.3s;
        }

        nav ul li a:hover {
            background-color: #34495e;
        }

        main .welcome {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
            margin-bottom: 20px;
        }

        .welcome h2 {
            margin-bottom: 10px;
        }

        .welcome p {
            margin-bottom: 30px;
            font-size: 1.1em;
        }

        .navigation-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 20px;
        }

        .card {
            background-color: #ecf0f1;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 1px 6px rgba(0,0,0,0.1);
            text-align: left;
        }

        .card h3 {
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .card p {
            margin-bottom: 15px;
        }

        .card .btn {
            display: inline-block;
            padding: 10px 15px;
            background-color: #27ae60;
            color: white;
            border: none;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .card .btn:hover {
            background-color: #1e8449;
        }

        footer {
            text-align: center;
            margin-top: 40px;
            font-size: 0.9em;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Event Scoring System</h1>
            <nav>
                <ul>
                    <?php if (isset($_SESSION['admin_id'])): ?>
                        <li><a href="<?= BASE_PATH ?>index.php">Admin Panel</a></li>
                        <li><a href="<?= BASE_PATH ?>logout.php">Logout (<?php echo htmlspecialchars($_SESSION['admin_display_name']); ?>)</a></li>
                    <?php elseif (isset($_SESSION['judge_id'])): ?>
                        <li><a href="<?= BASE_PATH ?>/judge/index.php">Judge Portal</a></li>
                        <li><a href="<?= BASE_PATH ?>logout.php">Logout (<?php echo htmlspecialchars($_SESSION['judge_display_name']); ?>)</a></li>
                    <?php else: ?>
                        <li><a href="<?= BASE_PATH ?>/login.php">Admin Login</a></li>
                        <li><a href="<?= BASE_PATH ?>/judge/login.php">Judge Login</a></li>
                    <?php endif; ?>
                    <li><a href="<?= BASE_PATH ?>/scoreboard.php">Scoreboard</a></li>
                </ul>
            </nav>
        </header>
        
        <main>
            <section class="welcome">
                <h2>Welcome to the Event Scoring System</h2>
                <p>This system allows judges to score participants in an event.</p>
                
                <div class="navigation-cards">
                    <?php if (isset($_SESSION['admin_id'])): ?>
                        <div class="card">
                            <h3>Admin Panel</h3>
                            <p>Manage judges and view system data.</p>
                            <a href="<?= BASE_PATH ?>/admin/index.php" class="btn">Go to Admin Panel</a>
                        </div>
                    <?php elseif (!isset($_SESSION['judge_id'])): ?>
                        <div class="card">
                            <h3>Admin Login</h3>
                            <p>Login to manage judges and system settings.</p>
                            <a href="<?= BASE_PATH ?>/admin/login.php" class="btn">Admin Login</a>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($_SESSION['judge_id'])): ?>
                        <div class="card">
                            <h3>Judge Portal</h3>
                            <p>Assign scores to participants.</p>
                            <a href="<?= BASE_PATH ?>/judge/index.php" class="btn">Go to Judge Portal</a>
                        </div>
                    <?php elseif (!isset($_SESSION['admin_id'])): ?>
                        <div class="card">
                            <h3>Judge Login</h3>
                            <p>Login to score participants.</p>
                            <a href="<?= BASE_PATH ?>/judge/login.php" class="btn">Judge Login</a>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card">
                        <h3>Scoreboard</h3>
                        <p>View the current standings of all participants.</p>
                        <a href="<?= BASE_PATH ?>/scoreboard.php" class="btn">View Scoreboard</a>
                    </div>
                </div>
            </section>
        </main>
        
        <footer>
            <p>&copy; <?php echo date('Y'); ?> Event Scoring System</p>
        </footer>
    </div>
</body>
</html>