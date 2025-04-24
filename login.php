<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BuildMyPC</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        .login-main {
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
        .login-main::before {
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
            transform: translateY(30px);
            opacity: 0;
            animation: slideUp 0.5s ease forwards;
        }

        @keyframes slideUp {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .login-container h1 {
            color: #3b82f6;
            font-size: 2rem;
            text-align: center;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 0 0 10px rgba(59, 130, 246, 0.3);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: #3b82f6;
            margin-bottom: 8px;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.2);
            border-radius: 8px;
            color: white;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            border-color: #3b82f6;
            outline: none;
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.2);
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            background: transparent;
            border: 2px solid #3b82f6;
            color: #3b82f6;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 20px 0;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .login-btn:hover {
            background: #3b82f6;
            color: white;
            transform: translateY(-2px);
        }

        .signup-link {
            text-align: center;
            margin-top: 20px;
        }

        .signup-link a {
            color: #3b82f6;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .signup-link a:hover {
            color: white;
            text-shadow: 0 0 10px rgba(59, 130, 246, 0.5);
        }

        .error-message {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #ef4444;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
            animation: shake 0.5s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
    </style>
</head>
<body>
    <?php include 'navigation.php' ?>

    <div class="login-main">
        <div class="login-container">
            <h1><i class="fas fa-user-circle"></i> Login</h1>
            
            <?php if(isset($_REQUEST['message']) && $_GET['message'] == '1'): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i> Invalid credentials
                </div>
            <?php endif; ?>

            <form method="post" action="login_process.php">
                <div class="form-group">
                    <label for="username">
                        <i class="fas fa-envelope"></i> Email
                    </label>
                    <input type="email" id="username" name="username" required>
                </div>

                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock"></i> Password
                    </label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" name="submit" class="login-btn">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>

                <div class="signup-link">
                    <a href="signup.php">
                        <i class="fas fa-user-plus"></i> Create New Account
                    </a>
                </div>
            </form>
        </div>
    </div>

    <?php include 'footer.php' ?>
</body>
</html>