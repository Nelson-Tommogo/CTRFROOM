
<?php
session_start();
require_once '../config/db_connect.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Get all judges
$stmt = $pdo->query("SELECT * FROM judges ORDER BY judge_id");
$judges = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Scoring System</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Admin Panel</h1>
            <nav>
                <ul>
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="register_judge.php">Register Judge</a></li>
                    <li><a href="../scoreboard.php">Scoreboard</a></li>
                    <li><a href="logout.php">Logout (<?php echo htmlspecialchars($_SESSION['admin_display_name']); ?>)</a></li>
                </ul>
            </nav>
        </header>
        
        <main>
            <section class="admin-dashboard">
                <h2>Admin Dashboard</h2>
                <p>Welcome, <?php echo htmlspecialchars($_SESSION['admin_display_name']); ?>!</p>
                
                <div class="admin-actions">
                    <a href="register_judge.php" class="btn">Register New Judge</a>
                </div>
            </section>
            
            <section class="judges-list">
                <h2>Current Judges</h2>
                
                <?php if (empty($judges)): ?>
                    <p>No judges found.</p>
                <?php else: ?>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Display Name</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($judges as $judge): ?>
                                <tr>
                                    <td><?php echo $judge['judge_id']; ?></td>
                                    <td><?php echo htmlspecialchars($judge['username']); ?></td>
                                    <td><?php echo htmlspecialchars($judge['display_name']); ?></td>
                                    <td><?php echo $judge['created_at']; ?></td>
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
