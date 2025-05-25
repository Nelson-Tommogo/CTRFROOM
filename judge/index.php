<?php
require_once '../config/db_connect.php';

// Get all judges for the dropdown
$stmt = $pdo->query("SELECT * FROM judges ORDER BY display_name");
$judges = $stmt->fetchAll();

// Get all users
$stmt = $pdo->query("SELECT * FROM users ORDER BY display_name");
$users = $stmt->fetchAll();

// Handle form submission for adding a score
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_score'])) {
    $judge_id = $_POST['judge_id'];
    $user_id = $_POST['user_id'];
    $points = $_POST['points'];
    
    // Basic validation
    if (empty($judge_id) || empty($user_id) || empty($points)) {
        $error = "All fields are required";
    } elseif ($points < 1 || $points > 100) {
        $error = "Points must be between 1 and 100";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO scores (judge_id, user_id, points) VALUES (?, ?, ?)");
            $stmt->execute([$judge_id, $user_id, $points]);
            $success = "Score added successfully!";
        } catch (PDOException $e) {
            $error = "Error adding score: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Judge Portal - Scoring System</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Judge Portal</h1>
            <nav>
                <ul>
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="../admin/index.php">Admin Panel</a></li>
                    <li><a href="../scoreboard.php">Scoreboard</a></li>
                </ul>
            </nav>
        </header>
        
        <main>
            <section class="add-score">
                <h2>Add Score</h2>
                
                <?php if (isset($error)): ?>
                    <div class="error"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <?php if (isset($success)): ?>
                    <div class="success"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <form method="post">
                    <div class="form-group">
                        <label for="judge_id">Judge:</label>
                        <select id="judge_id" name="judge_id" required>
                            <option value="">Select Judge</option>
                            <?php foreach ($judges as $judge): ?>
                                <option value="<?php echo $judge['judge_id']; ?>">
                                    <?php echo htmlspecialchars($judge['display_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="user_id">Participant:</label>
                        <select id="user_id" name="user_id" required>
                            <option value="">Select Participant</option>
                            <?php foreach ($users as $user): ?>
                                <option value="<?php echo $user['user_id']; ?>">
                                    <?php echo htmlspecialchars($user['display_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="points">Points (1-100):</label>
                        <input type="number" id="points" name="points" min="1" max="100" required>
                    </div>
                    
                    <button type="submit" name="add_score">Add Score</button>
                </form>
            </section>
            
            <section class="recent-scores">
                <h2>Recent Scores</h2>
                
                <?php
                $stmt = $pdo->query("
                    SELECT s.score_id, j.display_name AS judge_name, u.display_name AS user_name, s.points, s.created_at
                    FROM scores s
                    JOIN judges j ON s.judge_id = j.judge_id
                    JOIN users u ON s.user_id = u.user_id
                    ORDER BY s.created_at DESC
                    LIMIT 10
                ");
                $recent_scores = $stmt->fetchAll();
                ?>
                
                <?php if (empty($recent_scores)): ?>
                    <p>No scores found.</p>
                <?php else: ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Judge</th>
                                <th>Participant</th>
                                <th>Points</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_scores as $score): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($score['judge_name']); ?></td>
                                    <td><?php echo htmlspecialchars($score['user_name']); ?></td>
                                    <td><?php echo $score['points']; ?></td>
                                    <td><?php echo $score['created_at']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </section>
        </main>
    </div>
</body>
</html>