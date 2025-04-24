<?php
session_start();
include 'connect_database.php';

if(isset($_POST['login'])) {
    $username = mysqli_real_escape_string($database, $_POST['username']);
    $password = mysqli_real_escape_string($database, $_POST['password']);
    
    // Check both username and email
    $query = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($database, $query);
    
    if(mysqli_num_rows($result) == 1) {
        $_SESSION['admin'] = $username;
        header('location: admin_dashboard.php');
    } else {
        $error = "Invalid credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - BuildMyPC</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        .admin-login {
            background: linear-gradient(135deg, #0a0f1d, #1a237e);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        /* Cyber Grid Background */
        .admin-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                linear-gradient(90deg, rgba(59, 130, 246, 0.05) 1px, transparent 1px),
                linear-gradient(rgba(59, 130, 246, 0.05) 1px, transparent 1px);
            background-size: 20px 20px;
            animation: gridMove 20s linear infinite;
            opacity: 0.3;
        }

        @keyframes gridMove {
            0% { transform: translateY(0); }
            100% { transform: translateY(20px); }
        }

        .login-container {
            background: rgba(10, 15, 29, 0.8);
            padding: 40px;
            border-radius: 20px;
            border: 2px solid rgba(59, 130, 246, 0.3);
            backdrop-filter: blur(10px);
            width: 100%;
            max-width: 400px;
            position: relative;
            z-index: 1;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h1 {
            color: #3b82f6;
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .login-form input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.2);
            border-radius: 8px;
            color: white;
            transition: all 0.3s ease;
        }

        .login-form input:focus {
            border-color: #3b82f6;
            outline: none;
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.2);
        }

        .login-form button {
            width: 100%;
            padding: 12px;
            background: transparent;
            border: 2px solid #3b82f6;
            color: #3b82f6;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .login-form button:hover {
            background: #3b82f6;
            color: white;
            transform: translateY(-2px);
        }

        .error-message {
            color: #ef4444;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="admin-login">
        <div class="login-container">
            <div class="login-header">
                <h1>Admin Login</h1>
                <p style="color: #a3a3a3;">Enter your credentials to access the dashboard</p>
            </div>
            
            <?php if(isset($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>

            <form class="login-form" method="POST">
                <input type="text" name="username" placeholder="Username or Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Login</button>
            </form>
        </div>
    </div>
</body>
</html> 