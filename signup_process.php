<?php
    include 'connect_database.php';
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .message-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            animation: slideIn 0.5s ease forwards;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .message {
            padding: 15px 25px;
            border-radius: 8px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
        }

        .success {
            background: rgba(34, 197, 94, 0.9);
            color: white;
            border: 1px solid rgba(34, 197, 94, 0.2);
        }

        .error {
            background: rgba(239, 68, 68, 0.9);
            color: white;
            border: 1px solid rgba(239, 68, 68, 0.2);
            animation: shake 0.5s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(10, 15, 29, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 999;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 3px solid rgba(59, 130, 246, 0.2);
            border-radius: 50%;
            border-top-color: #3b82f6;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .redirect {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: rgba(10, 15, 29, 0.8);
            color: #3b82f6;
            padding: 15px 25px;
            border-radius: 8px;
            border: 1px solid rgba(59, 130, 246, 0.2);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body>

<?php
if(isset($_POST['submit'])) {
    $user_name = mysqli_real_escape_string($database, $_POST['user_name']);
    $pass1 = $_POST['password'];
    $pass2 = $_POST['confirm-password'];

    // Reset error messages
    $_SESSION['email_error'] = '';
    $_SESSION['password_error'] = '';
    $_SESSION['pass_length_error'] = '';

    // Validate input
    $valid = true;

    // First check if email already exists
    $check_email = "SELECT * FROM user WHERE email = '$user_name'";
    $result = mysqli_query($database, $check_email);
    
    if(mysqli_num_rows($result) > 0) {
        $_SESSION['email_error'] = 'Email already registered';
        $valid = false;
    }
    else if(!filter_var($user_name, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['email_error'] = 'Invalid email format';
        $valid = false;
    }

    if($pass1 != $pass2) {
        $_SESSION['password_error'] = 'Passwords do not match';
        $valid = false;
    }

    if(strlen($pass1) < 7) {
        $_SESSION['pass_length_error'] = 'Password must be at least 7 characters';
        $valid = false;
    }

    if($valid) {
        $password = password_hash($pass1, PASSWORD_DEFAULT);
        $sql = "INSERT INTO user (email, password) VALUES ('$user_name', '$password')";

        if(mysqli_query($database, $sql)) {
            $_SESSION['customer'] = $user_name;
            header('location: cart.php');
            exit();
        } else {
            $_SESSION['email_error'] = 'Registration failed. Please try again.';
            header('location: signup.php');
            exit();
        }
    } else {
        header('location: signup.php');
        exit();
    }
}
?>

</body>
</html>