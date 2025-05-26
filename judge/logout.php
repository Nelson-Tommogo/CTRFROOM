<?php
session_start();

// Clear all session variables
$_SESSION = array();

// Destroy the session
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Logging out...</title>
<style>
    body {
    background-color: #f8f9fa;
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    color: #555;
    }
    .message-box {
    text-align: center;
    padding: 30px 40px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    font-size: 1.2rem;
    }
</style>
<meta http-equiv="refresh" content="2;url=login.php" />
</head>
<body>
<div class="message-box">
    <p>You are being logged out...</p>
    <p>Please wait.</p>
</div>
</body>
</html>
