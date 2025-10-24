<?php
session_start();

if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit;
}

$welcomeMessage = $_SESSION['welcome_message'] ?? "Welcome back!";
unset($_SESSION['welcome_message']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Welcome</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');

body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    height: 100vh;

    /* ✨ Elegant Professional Background */
    background: url('background image.jpg')
        no-repeat center center/cover;

    display: flex;
    justify-content: center;
    align-items: center;
    color: #fff;
}

/* Glassmorphic Container */
.container {
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 50px 60px;
    text-align: center;
    box-shadow: 0 10px 35px rgba(0,0,0,0.3);
    animation: fadeIn 1s ease;
}

/* Typography */
h1 {
    font-size: 32px;
    margin-bottom: 10px;
    letter-spacing: 0.5px;
}

p {
    margin-bottom: 25px;
    font-size: 16px;
    color: #f0f0f0;
}

/* Button Styling */
button {
    padding: 12px 28px;
    border: none;
    border-radius: 8px;
    background: linear-gradient(90deg, #6a11cb, #2575fc);
    color: white;
    cursor: pointer;
    font-size: 16px;
    font-weight: 600;
    transition: 0.3s ease;
}
button:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(37,117,252,0.5);
}

/* Animation */
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
</style>
</head>
<body>
<div class="container">
    <h1><?= htmlspecialchars($welcomeMessage) ?> 👋</h1>
    <p>You are logged in as <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>.</p>
    <form method="post" action="logout.php">
        <button type="submit">Logout</button>
    </form>
</div>
</body>
</html>
