<?php
require_once 'config/db_connect.php';

// Get all users with their total scores
$stmt = $pdo->query("
    SELECT u.user_id, u.display_name, COALESCE(SUM(s.points), 0) AS total_points
    FROM users u
    LEFT JOIN scores s ON u.user_id = s.user_id
    GROUP BY u.user_id
    ORDER BY total_points DESC
");
$scores = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scoreboard - Scoring System</title>
    <link rel="stylesheet" href="css/style.css">
    <meta http-equiv="refresh" content="30"> <!-- Auto-refresh every 30 seconds -->
</head>
<body>
    <div class="container">
        <header>
            <h1>Public Scoreboard</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="admin/index.php">Admin Panel</a></li>
                    <li><a href="judge/index.php">Judge Portal</a></li>
                </ul>
            </nav>
        </header>
        
        <main>
            <section class="scoreboard">
                <h2>Current Standings</h2>
                
                <?php if (empty($scores)): ?>
                    <p>No scores available.</p>
                <?php else: ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Participant</th>
                                <th>Total Points</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $rank = 1;
                            $prev_points = null;
                            $rank_counter = 1;
                            
                            foreach ($scores as $index => $score): 
                                // If this score is different from the previous one, update the rank
                                if ($prev_points !== $score['total_points']) {
                                    $rank = $rank_counter;
                                }
                                
                                // Determine CSS class based on rank
                                $class = '';
                                if ($rank === 1) {
                                    $class = 'gold';
                                } elseif ($rank === 2) {
                                    $class = 'silver';
                                } elseif ($rank === 3) {
                                    $class = 'bronze';
                                }
                            ?>
                                <tr class="<?php echo $class; ?>">
                                    <td><?php echo $rank; ?></td>
                                    <td><?php echo htmlspecialchars($score['display_name']); ?></td>
                                    <td><?php echo $score['total_points']; ?></td>
                                </tr>
                            <?php 
                                $prev_points = $score['total_points'];
                                $rank_counter++;
                            endforeach; 
                            ?>
                        </tbody>
                    </table>
                <?php endif; ?>
                
                <p class="refresh-note">This page auto-refreshes every 30 seconds. Last updated: <?php echo date('Y-m-d H:i:s'); ?></p>
            </section>
        </main>
    </div>
    
    <script>
        // Alternative to meta refresh - JavaScript-based refresh
        setTimeout(function() {
            location.reload();
        }, 30000); // 30 seconds
    </script>
</body>
</html>