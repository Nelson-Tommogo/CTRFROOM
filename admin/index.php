<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scoring System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Event Scoring System</h1>
            <nav>
                <ul>
                    <?php if (isset($_SESSION['admin_id'])): ?>
                        <li><a href="admin/index.php">Admin Panel</a></li>
                        <li><a href="admin/logout.php">Logout (<?php echo htmlspecialchars($_SESSION['admin_display_name']); ?>)</a></li>
                    <?php elseif (isset($_SESSION['judge_id'])): ?>
                        <li><a href="judge/index.php">Judge Portal</a></li>
                        <li><a href="judge/logout.php">Logout (<?php echo htmlspecialchars($_SESSION['judge_display_name']); ?>)</a></li>
                    <?php else: ?>
                        <li><a href="admin/login.php">Admin Login</a></li>
                        <li><a href="judge/login.php">Judge Login</a></li>
                    <?php endif; ?>
                    <li><a href="scoreboard.php">Scoreboard</a></li>
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
                            <a href="admin/index.php" class="btn">Go to Admin Panel</a>
                        </div>
                    <?php elseif (!isset($_SESSION['judge_id'])): ?>
                        <div class="card">
                            <h3>Admin Login</h3>
                            <p>Login to manage judges and system settings.</p>
                            <a href="admin/login.php" class="btn">Admin Login</a>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($_SESSION['judge_id'])): ?>
                        <div class="card">
                            <h3>Judge Portal</h3>
                            <p>Assign scores to participants.</p>
                            <a href="judge/index.php" class="btn">Go to Judge Portal</a>
                        </div>
                    <?php elseif (!isset($_SESSION['admin_id'])): ?>
                        <div class="card">
                            <h3>Judge Login</h3>
                            <p>Login to score participants.</p>
                            <a href="judge/login.php" class="btn">Judge Login</a>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card">
                        <h3>Scoreboard</h3>
                        <p>View the current standings of all participants.</p>
                        <a href="scoreboard.php" class="btn">View Scoreboard</a>
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
