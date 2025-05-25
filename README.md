# Event Scoring System

A simple LAMP-based application for managing event scoring by judges.

## Features

- Secure Authentication: Login system for admins and judges
- Admin Panel: Add and manage judges
- Judge Portal: Assign scores to participants
- Public Scoreboard: View real-time standings with auto-refresh

## Setup Instructions

### Prerequisites

- XAMPP, WAMP, LAMP, or any PHP/MySQL environment
- PHP 7.0 or higher
- MySQL 5.6 or higher

### Installation

1. Clone or download this repository to your web server directory (e.g., `htdocs` for XAMPP)
2. Create a database named `scoring_system` in MySQL
3. Import the `scoring_system.sql` file to set up the database schema and sample data
4. Update database connection details in `config/db_connect.php` if needed
5. Access the application through your web browser (e.g., `http://localhost/scoring-system`)

### Default Login Credentials

- Admin: username `admin`, password `password123`
- Judge: username `judge1`, password `password123`

## Database Schema

The application uses four main tables:

```sql
-- Admins table
CREATE TABLE admins (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    display_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Judges table
CREATE TABLE judges (
    judge_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    display_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Users (participants) table
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    display_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Scores table
CREATE TABLE scores (
    score_id INT AUTO_INCREMENT PRIMARY KEY,
    judge_id INT NOT NULL,
    user_id INT NOT NULL,
    points INT NOT NULL CHECK (points BETWEEN 1 AND 100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (judge_id) REFERENCES judges(judge_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);
```

## Security Features

- Password hashing using PHP's `password_hash()` function
- Session-based authentication
- Protection against SQL injection using prepared statements
- Input validation and sanitization
- CSRF protection for forms

## Design Choices

### Database Design

- **Admins Table**: Stores admin credentials and information
- **Judges Table**: Stores information about judges who can assign scores
- **Users Table**: Stores information about participants who receive scores
- **Scores Table**: Junction table that records each scoring event with foreign keys to both judges and users

### PHP Implementation

- Used PDO for database connections with prepared statements for security
- Implemented basic error handling and form validation
- Separated database connection logic into a reusable configuration file
- Session-based authentication system

### Frontend

- Simple, responsive design using CSS flexbox
- Auto-refreshing scoreboard (both via meta tag and JavaScript)
- Visual highlighting of top performers on the scoreboard
- Conditional UI elements based on user role

## Assumptions

- For simplicity, authentication is not implemented but would be required in a production environment
- Users (participants) are pre-populated in the database
- Scores are cumulative (total points from all judges)
- A judge can score the same participant multiple times

## Future Enhancements

If I had more time, I would add:

1. Password reset functionality
2. Email verification for new accounts
3. Ability to create and manage different events
4. More advanced scoring options (e.g., different categories, weighted scoring)
5. Admin interface to manage participants
6. Data visualization for score trends
7. Export functionality for results
8. Real-time updates using WebSockets instead of page refresh
9. Two-factor authentication for added security

## License

This project is open-source and available for educational purposes.
