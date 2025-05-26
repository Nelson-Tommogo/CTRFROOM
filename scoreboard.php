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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Scoreboard - Scoring System</title>
    <meta http-equiv="refresh" content="30" />
    <style>
        /* Basic reset */
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
        }
        .container {
            max-width: 960px;
            margin: 30px auto;
            background: white;
            padding: 20px 30px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        header {
            text-align: center;
            margin-bottom: 25px;
        }
        header h1 {
            margin: 0 0 8px;
            color: #2c3e50;
        }
        nav ul {
            list-style: none;
            padding: 0;
            margin: 0 auto;
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        nav ul li a {
            color: #2980b9;
            text-decoration: none;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        nav ul li a:hover {
            background-color: #2980b9;
            color: white;
        }
        main h2 {
            color: #34495e;
            margin-bottom: 20px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        thead {
            background-color: #2c3e50;
            color: white;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        tbody tr:hover {
            background-color: #ecf0f1;
        }
        /* Medal colors */
        tr.gold {
            background-color: #ffd70033; /* light gold */
            font-weight: 700;
        }
        tr.silver {
            background-color: #c0c0c033; /* light silver */
            font-weight: 700;
        }
        tr.bronze {
            background-color: #cd7f3233; /* light bronze */
            font-weight: 700;
        }
        .refresh-note {
            text-align: center;
            font-size: 0.9rem;
            color: #7f8c8d;
        }
        @media (max-width: 600px) {
            nav ul {
                flex-direction: column;
                gap: 10px;
            }
            th, td {
                padding: 10px 8px;
            }
        }
    </style>
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
                                if ($prev_points !== $score['total_points']) {
                                    $rank = $rank_counter;
                                }
                                $class = '';
                                if ($rank === 1) $class = 'gold';
                                elseif ($rank === 2) $class = 'silver';
                                elseif ($rank === 3) $class = 'bronze';
                            ?>
                            <tr class="<?= $class ?>">
                                <td><?= $rank ?></td>
                                <td><?= htmlspecialchars($score['display_name']) ?></td>
                                <td><?= $score['total_points'] ?></td>
                            </tr>
                            <?php 
                                $prev_points = $score['total_points'];
                                $rank_counter++;
                            endforeach; 
                            ?>
                        </tbody>
                    </table>
                <?php endif; ?>

                <p class="refresh-note">This page auto-refreshes every 30 seconds. Last updated: <?= date('Y-m-d H:i:s') ?></p>
            </section>
        </main>
    </div>

    <script>
        // Alternative to meta refresh - JS refresh after 30 seconds
        setTimeout(() => location.reload(), 30000);
    </script>
</body>
</html>
