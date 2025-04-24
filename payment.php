<?php
session_start();
if(!isset($_SESSION['customer'])) {
    header('location:login.php');
    exit();
}

include 'connect_database.php';

// Store order details in session
$_SESSION['order_amount'] = $_SESSION['total_price'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - BuildMyPC</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        .payment-container {
            background: linear-gradient(135deg, #0a0f1d, #1a237e);
            min-height: 100vh;
            padding: 40px 20px;
            position: relative;
            overflow: hidden;
        }

        /* Remove animated background */
        .payment-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(59, 130, 246, 0.1);
        }

        .payment-box {
            max-width: 800px;
            margin: 0 auto;
            background: rgba(10, 15, 29, 0.8);
            padding: 40px;
            border-radius: 20px;
            border: 2px solid rgba(59, 130, 246, 0.3);
            backdrop-filter: blur(10px);
            position: relative;
            z-index: 1;
        }

        .payment-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .payment-header h1 {
            color: #3b82f6;
            font-size: 2rem;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .payment-amount {
            font-size: 2.5rem;
            color: #22c55e;
            margin: 20px 0;
            text-align: center;
        }

        .payment-methods {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            justify-content: center;
        }

        .payment-method {
            padding: 15px 30px;
            border: 2px solid rgba(59, 130, 246, 0.3);
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #a3a3a3;
        }

        .payment-method.active {
            border-color: #3b82f6;
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }

        .payment-method:hover {
            transform: translateY(-2px);
        }

        .upi-section {
            display: none;
        }

        .upi-section.active {
            display: block;
        }

        .qr-code {
            max-width: 300px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
        }

        .qr-code img {
            width: 100%;
            height: auto;
        }

        .upi-id {
            color: #3b82f6;
            font-size: 1.2rem;
            margin: 20px 0;
            padding: 10px;
            background: rgba(59, 130, 246, 0.1);
            border-radius: 5px;
            display: inline-block;
        }

        .transaction-form {
            max-width: 400px;
            margin: 30px auto;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: #3b82f6;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.2);
            border-radius: 8px;
            color: white;
        }

        .verify-btn {
            width: 100%;
            padding: 15px;
            background: #3b82f6;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .verify-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(59, 130, 246, 0.3);
        }

        .copy-btn {
            padding: 5px 10px;
            background: #3b82f6;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
        }

        .payment-steps {
            color: #a3a3a3;
            margin: 20px 0;
            padding: 20px;
            border: 1px solid rgba(59, 130, 246, 0.2);
            border-radius: 10px;
        }

        .payment-steps ol {
            margin-left: 20px;
        }

        .payment-steps li {
            margin: 10px 0;
        }

        .payment-status {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            text-align: center;
        }
        .success {
            background: rgba(34, 197, 94, 0.1);
            color: #22c55e;
        }
        .error {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }
    </style>
</head>
<body>
    <?php include 'navigation.php'; ?>

    <div class="payment-container">
        <div class="payment-box">
            <div class="payment-header">
                <h1><i class="fas fa-credit-card"></i> Payment Gateway</h1>
                <p>Complete your payment to place the order</p>
            </div>

            <div class="payment-amount">
                ₹<?php echo number_format($_SESSION['order_amount'], 2); ?>
            </div>

            <form method="POST" action="process_payment.php" id="paymentForm">
                <div class="payment-methods">
                    <label class="payment-method">
                        <input type="radio" name="payment_method" value="upi" checked>
                        UPI Payment
                    </label>
                    <label class="payment-method">
                        <input type="radio" name="payment_method" value="cod">
                        Cash on Delivery
                    </label>
                </div>

                <div id="upiSection">
                    <div class="qr-code">
                        <img src="images/UPI.jpg" alt="UPI QR Code">
                    </div>
                    <div class="upi-details">
                        <p>UPI ID: <span id="upiId">buildmypc@upi</span>
                        <button type="button" onclick="copyUpiId()" class="copy-btn">Copy</button></p>
                    </div>
                    <div class="transaction-form">
                        <input type="text" name="transaction_id" placeholder="Enter UPI Transaction ID" required>
                    </div>
                </div>

                <button type="submit" name="submit_payment" class="verify-btn">
                    Complete Payment
                </button>
            </form>
        </div>
    </div>

    <script>
    function copyUpiId() {
        const upiId = document.getElementById('upiId').textContent;
        navigator.clipboard.writeText(upiId);
        alert('UPI ID copied!');
    }

    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const upiSection = document.getElementById('upiSection');
            upiSection.style.display = this.value === 'upi' ? 'block' : 'none';
        });
    });
    </script>

    <?php include 'footer.php'; ?>
</body>
</html> 