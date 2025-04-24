<?php
session_start();
if(!isset($_SESSION['customer']) || !isset($_SESSION['order_success'])) {
    header('location:cart.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - BuildMyPC</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        .confirmation-container {
            background: linear-gradient(135deg, #0a0f1d, #1a237e);
            min-height: 100vh;
            padding: 40px 20px;
            position: relative;
            overflow: hidden;
        }

        .confirmation-box {
            max-width: 600px;
            margin: 40px auto;
            background: rgba(10, 15, 29, 0.8);
            padding: 40px;
            border-radius: 20px;
            border: 2px solid rgba(59, 130, 246, 0.3);
            backdrop-filter: blur(10px);
            text-align: center;
        }

        .success-icon {
            font-size: 4rem;
            color: #22c55e;
            margin-bottom: 20px;
        }

        h1 {
            color: #3b82f6;
            margin-bottom: 20px;
        }

        .order-details {
            margin: 30px 0;
            text-align: left;
            color: #fff;
        }

        .order-details p {
            margin: 10px 0;
            padding: 10px;
            background: rgba(59, 130, 246, 0.1);
            border-radius: 8px;
        }

        .continue-btn {
            display: inline-block;
            padding: 15px 30px;
            background: #3b82f6;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin-top: 20px;
            transition: all 0.3s ease;
        }

        .continue-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(59, 130, 246, 0.3);
        }
    </style>
</head>
<body>
    <?php include 'navigation.php'; ?>

    <div class="confirmation-container">
        <div class="confirmation-box">
            <i class="fas fa-check-circle success-icon"></i>
            <h1>Order Placed Successfully!</h1>
            
            <div class="order-details">
                <p><strong>Order Amount:</strong> ₹<?php echo number_format($_SESSION['order_amount'], 2); ?></p>
                <p><strong>Payment Method:</strong> <?php echo $_SESSION['payment_method']; ?></p>
                <p><strong>Order Status:</strong> Processing</p>
            </div>

            <a href="home.php" class="continue-btn">
                <i class="fas fa-home"></i> Continue Shopping
            </a>
        </div>
    </div>

    <?php 
    include 'footer.php';
    // Clear the order success session
    unset($_SESSION['order_success']);
    unset($_SESSION['order_amount']);
    unset($_SESSION['payment_method']);
    ?>
</body>
</html> 