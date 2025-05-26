<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Scoring System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4cc9f0;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --success-color: #4bb543;
            --warning-color: #f0ad4e;
            --danger-color: #d9534f;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: var(--dark-color);
            background-color: #f5f7fa;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        header {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        header h1 {
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 20px;
            font-size: 2.5rem;
        }
        
        nav ul {
            display: flex;
            justify-content: center;
            list-style: none;
            gap: 20px;
        }
        
        nav a {
            text-decoration: none;
            color: var(--dark-color);
            font-weight: 500;
            padding: 10px 15px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        
        nav a:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        main {
            padding: 40px 0;
        }
        
        .welcome {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .welcome h2 {
            font-size: 2rem;
            margin-bottom: 15px;
            color: var(--secondary-color);
        }
        
        .welcome p {
            font-size: 1.1rem;
            max-width: 700px;
            margin: 0 auto 30px;
        }
        
        .navigation-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }
        
        .card {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-align: center;
            border-top: 4px solid var(--primary-color);
        }
        
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .card h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: var(--secondary-color);
        }
        
        .card p {
            margin-bottom: 20px;
            color: #666;
        }
        
        .btn {
            display: inline-block;
            background-color: var(--primary-color);
            color: white;
            padding: 12px 25px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }
        
        .btn:hover {
            background-color: var(--secondary-color);
        }
        
        .features {
            margin-top: 60px;
        }
        
        .features h3 {
            text-align: center;
            font-size: 1.8rem;
            margin-bottom: 30px;
            color: var(--secondary-color);
        }
        
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .feature-item {
            background-color: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            text-align: center;
        }
        
        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }
        
        footer {
            background-color: var(--dark-color);
            color: white;
            text-align: center;
            padding: 20px 0;
            margin-top: 60px;
        }
        
        @media (max-width: 768px) {
            header h1 {
                font-size: 2rem;
            }
            
            nav ul {
                flex-direction: column;
                align-items: center;
                gap: 10px;
            }
            
            .navigation-cards {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1><i class="fas fa-trophy"></i> Event Scoring System</h1>
            <nav>
                <ul>
                    <li><a href="admin/index.php"><i class="fas fa-user-shield"></i> Admin Panel</a></li>
                    <li><a href="judge/index.php"><i class="fas fa-gavel"></i> Judge Portal</a></li>
                    <li><a href="scoreboard.php"><i class="fas fa-list-ol"></i> Scoreboard</a></li>
                </ul>
            </nav>
        </header>
        
        <main>
            <section class="welcome">
                <h2>Welcome to the Event Scoring System</h2>
                <p>A comprehensive platform for managing competitions, judging participants, and displaying real-time scores in a professional manner.</p>
                
                <div class="navigation-cards">
                    <div class="card">
                        <div class="feature-icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <h3>Admin Panel</h3>
                        <p>Manage event judges, participants, and system settings with full administrative control.</p>
                        <a href="admin/index.php" class="btn">Go to Admin Panel</a>
                    </div>
                    
                    <div class="card">
                        <div class="feature-icon">
                            <i class="fas fa-gavel"></i>
                        </div>
                        <h3>Judge Portal</h3>
                        <p>Submit scores for participants with an intuitive interface designed for efficient judging.</p>
                        <a href="judge/index.php" class="btn">Go to Judge Portal</a>
                    </div>
                    
                    <div class="card">
                        <div class="feature-icon">
                            <i class="fas fa-list-ol"></i>
                        </div>
                        <h3>Scoreboard</h3>
                        <p>View live rankings with automatic updates and visual highlights for top performers.</p>
                        <a href="scoreboard.php" class="btn">View Scoreboard</a>
                    </div>
                </div>
            </section>
            
            <section class="features">
                <h3>System Features</h3>
                <div class="feature-grid">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h4>Real-time Updates</h4>
                        <p>Scores update instantly across all devices for accurate, up-to-date information.</p>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <h4>Secure Access</h4>
                        <p>Role-based authentication ensures only authorized users can access sensitive areas.</p>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4>Detailed Analytics</h4>
                        <p>Comprehensive reporting tools for analyzing competition results and trends.</p>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h4>Responsive Design</h4>
                        <p>Fully functional on all devices from desktops to smartphones.</p>
                    </div>
                </div>
            </section>
        </main>
        
        <footer>
            <p>&copy; <?php echo date('Y'); ?> Event Scoring System. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>