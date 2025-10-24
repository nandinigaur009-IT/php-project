<?php
session_start();
require("config.php"); 

$error = "";
$success = "";


if (isset($_POST['register'])) {
    $username = strtolower(trim($_POST['username']));
    $email = strtolower(trim($_POST['email']));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "⚠️ Please fill out all fields!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "⚠️ Please enter a valid email address!";
    } elseif ($password !== $confirm_password) {
        $error = "❌ Passwords do not match!";
    } else {
        
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "⚠️ Username or Email already exists!";
        } else {
            
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            if ($stmt->execute()) {
                header("Location: login.php?registered=1");
                exit;
            } else {
                $error = "❌ Registration failed! Please try again.";
            }
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register</title>
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
    background: url('background image.jpg') no-repeat center center/cover;
    display: flex;
    justify-content: center;
    align-items: center;
}


.container {
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(18px);
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    width: 380px;
    padding: 45px 40px;
    text-align: center;
    color: #fff;
}

h2 {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 25px;
    letter-spacing: 0.5px;
}


.input-group {
    position: relative;
    margin-bottom: 15px;
}

input[type="text"], input[type="email"], input[type="password"] {
    width: 100%;
    padding: 12px 45px 12px 15px;
    border: none;
    border-radius: 8px;
    background: rgba(255,255,255,0.2);
    color: #fff;
    font-size: 15px;
    outline: none;
    transition: 0.3s;
}

input::placeholder {
    color: rgba(255,255,255,0.7);
}

input:focus {
    background: rgba(255,255,255,0.3);
    box-shadow: 0 0 10px rgba(0,212,255,0.4);
}

.toggle-eye {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 20px;
}


button {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 8px;
    background: linear-gradient(90deg, #6a11cb, #2575fc);
    color: white;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s ease;
}

button:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 15px rgba(37,117,252,0.5);
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


p {
    margin-top: 15px;
    font-size: 14px;
    color: #eee;
}

a {
    color: #00d4ff;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}


.toggle-btn {
    background: none;
    border: none;
    font-size: 22px;
    cursor: pointer;
    margin-top: 10px;
    transition: 0.3s;
}
.toggle-btn:hover {
    transform: scale(1.2);
}
</style>
</head>
<body>
<div class="container">
    <h2 id="registerTitle">Create Account ✨</h2>
    <?php 
        if($error) echo "<div class='error'>$error</div>"; 
        if($success) echo "<div class='success'>$success</div>";
    ?>
    <form method="post" action="">
        <div class="input-group">
            <input type="text" name="username" placeholder="Username" required autocomplete="username">
        </div>
        <div class="input-group">
            <input type="email" name="email" placeholder="Email" required autocomplete="email">
        </div>
        <div class="input-group">
            <input type="password" id="password" name="password" placeholder="Password" required autocomplete="new-password">
            <span class="toggle-eye" onclick="togglePassword('password', this)">🔒</span>
        </div>
        <div class="input-group">
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required autocomplete="new-password">
            <span class="toggle-eye" onclick="togglePassword('confirm_password', this)">🔒</span>
        </div>
        <button type="submit" name="register">Register</button>
    </form>

    <button class="toggle-btn" type="button" onclick="toggleEmoji()">🌸</button>

    <p>Already have an account? <a href="login.php">Login here</a></p>
</div>

<script>
const title = document.getElementById('registerTitle');
const emojis = ['✨', '🌸', '🌈', '💫', '🌿', '🌟'];
let index = 0;

function toggleEmoji() {
    index = (index + 1) % emojis.length;
    title.innerHTML = 'Create Account ' + emojis[index];
}

function togglePassword(id, el) {
    const input = document.getElementById(id);
    if (input.type === "password") {
        input.type = "text";
        el.textContent = "👁️";
    } else {
        input.type = "password";
        el.textContent = "🔒";
    }
}
</script>
</body>
</html>
