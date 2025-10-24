<<?php
session_start();
include("config.php"); // ✅ Connects to your MySQL database

// Redirect logged-in user
if (isset($_SESSION['username'])) {
    header("Location: welcome.php");
    exit;
}

$error = "";
$success = "";

// Show success message after registration
if (isset($_GET['registered'])) {
    $success = "🎉 Registration successful! Please log in below.";
}

// Handle login
if (isset($_POST['login'])) {
    $input = trim($_POST['username_email']);
    $password = $_POST['password'];

    // Prepare SQL to check if username or email exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=? OR email=?");
    $stmt->bind_param("ss", $input, $input);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['welcome_message'] = "Welcome back, " . ucfirst($user['username']) . " 🎉";
            header("Location: welcome.php");
            exit;
        } else {
            $error = "⚠️ Invalid password!";
        }
    } else {
        $error = "⚠️ No user found with that username or email!";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}
body {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: url('background image.jpg') no-repeat center center/cover;
    position: relative;
    overflow: hidden;
}
body::before {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
}
.container {
    position: relative;
    z-index: 1;
    width: 420px;
    padding: 40px 35px;
    border-radius: 20px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(25px);
    box-shadow: 0 25px 45px rgba(0, 0, 0, 0.5);
    animation: fadeIn 1s ease;
    color: #fff;
}
h2 {
    text-align: center;
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 25px;
    letter-spacing: 0.5px;
}
.error, .success {
    margin-bottom: 15px;
    padding: 10px 12px;
    border-radius: 8px;
    font-size: 14px;
}
.error {
    background: rgba(255, 71, 71, 0.2);
    color: #ffbaba;
    border: 1px solid rgba(255,71,71,0.4);
}
.success {
    background: rgba(0, 255, 136, 0.15);
    color: #baffde;
    border: 1px solid rgba(0,255,136,0.4);
}
.input-group {
    position: relative;
    margin-bottom: 18px;
}
input[type="text"], input[type="password"] {
    width: 100%;
    padding: 12px 45px 12px 15px;
    border: none;
    border-radius: 10px;
    background: rgba(255,255,255,0.15);
    color: #fff;
    font-size: 15px;
    outline: none;
    transition: 0.3s;
}
input::placeholder {
    color: rgba(255,255,255,0.75);
}
input:focus {
    background: rgba(255,255,255,0.3);
    box-shadow: 0 0 10px rgba(0, 212, 255, 0.5);
}
.toggle-password {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 20px;
    transition: 0.3s;
}
.toggle-password:hover {
    transform: translateY(-50%) scale(1.2);
}
button {
    width: 100%;
    padding: 13px;
    border: none;
    border-radius: 10px;
    background: linear-gradient(90deg, #2575fc, #6a11cb);
    color: white;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s ease;
    margin-top: 5px;
}
button:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 15px rgba(37,117,252,0.5);
}
p {
    margin-top: 15px;
    font-size: 14px;
    color: #ddd;
    text-align: center;
}
a {
    color: #00d4ff;
    text-decoration: none;
    font-weight: 500;
}
a:hover {
    text-decoration: underline;
}
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
</style>
</head>
<body>

<div class="container">
    <h2>Welcome 👋</h2>
    <?php 
        if($error) echo "<div class='error'>$error</div>"; 
        if($success) echo "<div class='success'>$success</div>";
    ?>
    <form method="post" action="">
        <div class="input-group">
            <input type="text" name="username_email" placeholder="Username or Email" required>
        </div>

        <div class="input-group">
            <input type="password" name="password" id="password" placeholder="Password" required>
            <span class="toggle-password" onclick="togglePassword()">🙈</span>
        </div>

        <button type="submit" name="login">Login</button>
    </form>

    <p>Don’t have an account? <a href="register.php">Register here</a></p>
</div>

<script>
function togglePassword() {
    const pwd = document.getElementById('password');
    const icon = document.querySelector('.toggle-password');
    if (pwd.type === 'password') {
        pwd.type = 'text';
        icon.textContent = '👀';
    } else {
        pwd.type = 'password';
        icon.textContent = '🙈';
    }
}
</script>

</body>
</html>
