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
                    <li><a href="admin/index.php">Admin Panel</a></li>
                    <li><a href="judge/index.php">Judge Portal</a></li>
                    <li><a href="scoreboard.php">Scoreboard</a></li>
                </ul>
            </nav>
        </header>
        
        <main>
            <section class="welcome">
                <h2>Welcome to the Event Scoring System</h2>
                <p>This system allows judges to score participants in an event.</p>
                
                <div class="navigation-cards">
                    <div class="card">
                        <h3>Admin Panel</h3>
                        <p>Add and manage judges for the event.</p>
                        <a href="admin/index.php" class="btn">Go to Admin Panel</a>
                    </div>
                    
                    <div class="card">
                        <h3>Judge Portal</h3>
                        <p>Judges can assign scores to participants.</p>
                        <a href="judge/index.php" class="btn">Go to Judge Portal</a>
                    </div>
                    
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