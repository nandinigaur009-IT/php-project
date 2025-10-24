<?php
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Logged Out</title>
  <style>
    body {
      margin: 0;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Poppins', sans-serif;
      background: url('background image.jpg') no-repeat center center fixed;
      background-size: cover;
    }

    .logout-box {
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(10px);
      padding: 50px 60px;
      border-radius: 20px;
      text-align: center;
      color: #fff;
      box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
      max-width: 400px;
    }

    .logout-box h2 {
      font-size: 1.8rem;
      margin-bottom: 10px;
    }

    .logout-box p {
      margin: 10px 0 20px;
      font-size: 1rem;
      color: #f5f5f5;
    }

    .logout-box a {
      display: inline-block;
      text-decoration: none;
      font-weight: bold;
      background: linear-gradient(90deg, #7b2ff7, #f107a3);
      color: white;
      padding: 10px 25px;
      border-radius: 10px;
      transition: 0.3s;
    }

    .logout-box a:hover {
      opacity: 0.85;
      transform: scale(1.05);
    }
  </style>
</head>
<body>

  <div class="logout-box">
    <h2>You've been logged out 🌸</h2>
    <p>Thank you for visiting. See you soon!</p>
    <a href="login.php">Go to Login</a>
  </div>

</body>
</html>
