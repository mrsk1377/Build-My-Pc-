<?php
    if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['customer']) && empty($_SESSION['customer'])) {
    header('location:login.php');
    exit();
}

// Initialize total price
$total_price = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* Main Container */
        .main_cart {
            background: linear-gradient(135deg, #0a0f1d, #1a237e);
            min-height: 100vh;
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        /* Cyber Grid Background */
        .main_cart::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                linear-gradient(90deg, #0a0f1d 10px, transparent 1%) center,
                linear-gradient(#0a0f1d 10px, transparent 1%) center,
                rgba(59, 130, 246, 0.1);
            background-size: 12px 12px;
            animation: gridMove 20s linear infinite;
        }

        @keyframes gridMove {
            0% { background-position: 0 0; }
            100% { background-position: 12px 12px; }
        }

        /* Cart Container */
        .cart-container {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        /* Empty Cart Message */
        h1 {
            color: #3b82f6;
            text-align: center;
            font-size: 2rem;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 0 0 20px rgba(59, 130, 246, 0.5);
        }

        /* Table Styling */
        .order-table {
            width: 100%;
            background: rgba(10, 15, 29, 0.8);
            border-radius: 20px;
            border-collapse: separate;
            border-spacing: 0;
            overflow: hidden;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(59, 130, 246, 0.3);
            margin-bottom: 40px;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeIn 0.5s ease forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Table Headers */
        th {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
            padding: 20px;
            text-align: left;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            border-bottom: 2px solid rgba(59, 130, 246, 0.2);
        }

        /* Table Cells */
        td {
            padding: 15px 20px;
            color: #fff;
            border-bottom: 1px solid rgba(59, 130, 246, 0.1);
            transition: background-color 0.3s ease;
        }

        tr:hover td {
            background: rgba(59, 130, 246, 0.05);
        }

        /* Total Row */
        tr:last-child td {
            border-bottom: none;
            background: rgba(59, 130, 246, 0.1);
            font-weight: bold;
            color: #3b82f6;
        }

        /* Payment Section */
        .payment-container {
            background: rgba(10, 15, 29, 0.8);
            border-radius: 20px;
            padding: 30px;
            border: 2px solid rgba(59, 130, 246, 0.3);
            backdrop-filter: blur(10px);
            margin-top: 40px;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeIn 0.5s ease forwards 0.3s;
        }

        .payment-container h1 {
            margin-bottom: 30px;
        }

        /* Payment Methods */
        .methods {
            margin-bottom: 30px;
        }

        .delivery-option {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
            background: rgba(59, 130, 246, 0.05);
            border-radius: 10px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .delivery-option:hover {
            transform: translateY(-2px);
            background: rgba(59, 130, 246, 0.1);
            box-shadow: 0 5px 15px rgba(59, 130, 246, 0.2);
        }

        /* Radio Buttons */
        input[type="radio"] {
            margin-right: 10px;
            accent-color: #3b82f6;
        }

        label {
            color: #fff;
            font-size: 1.1rem;
            cursor: pointer;
        }

        /* Place Order Button */
        .checkout-btn {
            width: 100%;
            padding: 15px 30px;
            background: linear-gradient(45deg, #1a237e, #3b82f6);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.2rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .checkout-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }

        .checkout-btn:hover::before {
            left: 100%;
        }

        .checkout-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
            background: linear-gradient(45deg, #3b82f6, #1a237e);
        }

        .checkout-btn:active {
            transform: translateY(0);
        }

        .checkout-btn i {
            font-size: 1.4rem;
            transition: transform 0.3s ease;
        }

        .checkout-btn:hover i {
            transform: translateX(5px);
        }

        .checkout-btn.disabled {
            opacity: 0.7;
            cursor: not-allowed;
            background: #666;
        }

        /* Loading state */
        .checkout-btn.loading {
            cursor: wait;
        }

        .checkout-btn.loading i {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Payment Method Images */
        .delivery-option img {
            transition: transform 0.3s ease;
        }

        .delivery-option:hover img {
            transform: scale(1.1);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main_cart {
                padding: 20px;
            }

            .order-table {
                display: block;
                overflow-x: auto;
            }

            td, th {
                min-width: 200px;
            }

            [data-th] {
                font-weight: bold;
                color: #3b82f6;
            }
        }

        .payment-options {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .payment-option {
            flex: 1;
            padding: 15px;
            background: rgba(10, 15, 29, 0.8);
            border: 2px solid rgba(59, 130, 246, 0.3);
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }

        .payment-option:hover {
            border-color: #3b82f6;
            transform: translateY(-2px);
        }

        .payment-option input[type="radio"] {
            margin-right: 10px;
        }

        .payment-option input[type="radio"]:checked + .option-content {
            color: #3b82f6;
        }

        .option-content {
            color: #a3a3a3;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.1rem;
        }

        .payment-option:has(input[type="radio"]:checked) {
            border-color: #3b82f6;
            background: rgba(59, 130, 246, 0.1);
        }
    </style>
</head>

<body>
    <?php 
    include 'navigation.php';
    include 'connect_database.php';//$database  
    
    ?>


    <div class="main_cart">
        <div class="cart-container">
            <?php
            if(empty($_SESSION['cabinet_full_name']))
            {
                echo '<h1><i class="fas fa-shopping-cart"></i> Cart is Empty</h1>';
            }
            ?>
            <table class="order-table">
                <?php if(isset($_SESSION['prebuilt_pc'])): ?>
                    <!-- Prebuilt PC Order -->
                    <tr>
                        <th>Product</th>
                        <th>Description</th>
                        <th>Price</th>
                    </tr>
                    <tr>
                        <td data-th="PRODUCTS">Prebuilt Gaming PC</td>
                        <td data-th="PRODUCT DESCRIPTION">
                            <?php echo $_SESSION['prebuilt_pc']['name']; ?>
                            <div class="specs-list">
                                <p><i class="fas fa-microchip"></i> CPU: <?php echo $_SESSION['prebuilt_pc']['specs']['cpu']; ?></p>
                                <p><i class="fas fa-desktop"></i> GPU: <?php echo $_SESSION['prebuilt_pc']['specs']['gpu']; ?></p>
                                <p><i class="fas fa-memory"></i> RAM: <?php echo $_SESSION['prebuilt_pc']['specs']['ram']; ?></p>
                                <p><i class="fas fa-hdd"></i> Storage: <?php echo $_SESSION['prebuilt_pc']['specs']['storage']; ?></p>
                            </div>
                        </td>
                        <td data-th="PRICE">₹<?php echo number_format($_SESSION['prebuilt_pc']['price'], 2); ?></td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td>--</td>
                        <td>₹<?php echo number_format($_SESSION['prebuilt_pc']['price'], 2); ?></td>
                    </tr>
                    <?php $total_price = $_SESSION['prebuilt_pc']['price']; ?>
                <?php else: ?>
                    <!-- Display Custom Build Components -->
                    <tr>
                        <td data-th="PRODUCTS">Cabinet</td>
                        <td data-th="PRODUCT DESCRIPTION">
                            <?php
                                if(!empty($_SESSION["cabinet_full_name"])) 
                                {echo $_SESSION["cabinet_full_name"];} 
                                else
                                {
                                    echo '';
                                }
                            
                            ?>
                        </td>
                        <td data-th="PRICE">
                            <?php 
                                if(!empty($_SESSION['cabinet_price']))
                                {
                                    echo $_SESSION['cabinet_price'];
                                    $total_price=$total_price+$_SESSION['cabinet_price'] ;
                                }
                                else
                                {
                                    echo '';
                                }
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td data-th="PRODUCTS">CPU</td>
                        <td data-th="PRODUCT DESCRIPTION">
                            <?php
                                if(!empty($_SESSION["cpu_full_name"])) 
                                {echo $_SESSION["cpu_full_name"];} 
                                else
                                {
                                    echo '';
                                }
                            
                            ?>
                        </td>
                        <td data-th="PRICE">
                            <?php 
                                if(!empty($_SESSION['cpu_price']))
                                {
                                    echo $_SESSION['cpu_price'];
                                    $total_price=$total_price+$_SESSION['cpu_price'] ;
                                }
                                else
                                {
                                    echo '';
                                }
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td data-th="PRODUCTS">GPU</td>
                        <td data-th="PRODUCT DESCRIPTION">
                            <?php
                                if(!empty($_SESSION["gpu_full_name"])) 
                                {echo $_SESSION["gpu_full_name"];} 
                                else
                                {
                                    echo '';
                                }
                            
                            ?>
                        </td>
                        <td data-th="PRICE">
                            <?php 
                                if(!empty($_SESSION['gpu_price']))
                                {
                                    echo $_SESSION['gpu_price'];
                                    $total_price=$total_price+$_SESSION['gpu_price'] ;
                                }
                                else
                                {
                                    echo '';
                                }
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td data-th="PRODUCTS">Ram</td>
                        <td data-th="PRODUCT DESCRIPTION">
                            <?php
                                if(!empty($_SESSION["ram_full_name"])) 
                                {echo $_SESSION["ram_full_name"];} 
                                else
                                {
                                    echo '';
                                }
                            
                            ?>
                        </td>
                        <td data-th="PRICE">
                            <?php 
                                if(!empty($_SESSION['ram_price']))
                                {
                                    echo $_SESSION['ram_price'];
                                    $total_price=$total_price+$_SESSION['ram_price'] ;
                                }
                                else
                                {
                                    echo '';
                                }
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td data-th="PRODUCTS">Motherboard</td>
                        <td data-th="PRODUCT DESCRIPTION">
                            <?php
                                if(!empty($_SESSION["mb_full_name"])) 
                                {echo $_SESSION["mb_full_name"];} 
                                else
                                {
                                    echo '';
                                }
                            
                            ?>
                        </td>
                        <td data-th="PRICE">
                            <?php 
                                if(!empty($_SESSION['mb_price']))
                                {
                                    echo $_SESSION['mb_price'];
                                    $total_price=$total_price+$_SESSION['mb_price'] ;
                                }
                                else
                                {
                                    echo '';
                                }
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td data-th="PRODUCTS">SSD</td>
                        <td data-th="PRODUCT DESCRIPTION">
                            <?php
                                if(!empty($_SESSION["ssd_full_name"])) 
                                {echo $_SESSION["ssd_full_name"];} 
                                else
                                {
                                    echo '';
                                }
                            
                            ?>
                        </td>
                        <td data-th="PRICE">
                            <?php 
                                if(!empty($_SESSION['ssd_price']))
                                {
                                    echo $_SESSION['ssd_price'];
                                    $total_price=$total_price+$_SESSION['ssd_price'] ;
                                }
                                else
                                {
                                    echo '';
                                }
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td data-th="PRODUCTS">HDD</td>
                        <td data-th="PRODUCT DESCRIPTION">
                            <?php
                                if(!empty($_SESSION["hdd_full_name"])) 
                                {echo $_SESSION["hdd_full_name"];} 
                                else
                                {
                                    echo '';
                                }
                            
                            ?>
                        </td>
                        <td data-th="PRICE">
                            <?php 
                                if(!empty($_SESSION['hdd_price']))
                                {
                                    echo $_SESSION['hdd_price'];
                                    $total_price=$total_price+$_SESSION['hdd_price'] ;
                                }
                                else
                                {
                                    echo '';
                                }
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td data-th="PRODUCTS">Power Supply</td>
                        <td data-th="PRODUCT DESCRIPTION">
                            <?php
                                if(!empty($_SESSION["power_supply_full_name"])) 
                                {echo $_SESSION["power_supply_full_name"];} 
                                else
                                {
                                    echo '';
                                }
                            
                            ?>
                        </td>
                        <td data-th="PRICE">
                            <?php 
                                if(!empty($_SESSION['power_supply_price']))
                                {
                                    echo $_SESSION['power_supply_price'];
                                    $total_price=$total_price+$_SESSION['power_supply_price'] ;
                                }
                                else
                                {
                                    echo '';
                                }
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td data-th="PRODUCTS">Cpu Cooler</td>
                        <td data-th="PRODUCT DESCRIPTION">
                            <?php
                                if(!empty($_SESSION["cpu_cooler_full_name"])) 
                                {echo $_SESSION["cpu_cooler_full_name"];} 
                                else
                                {
                                    echo '';
                                }
                            
                            ?>
                        </td>
                        <td data-th="PRICE">
                            <?php 
                                if(!empty($_SESSION['cpu_cooler_price']))
                                {
                                    echo $_SESSION['cpu_cooler_price'];
                                    $total_price=$total_price+$_SESSION['cpu_cooler_price'] ;
                                }
                                else
                                {
                                    echo '';
                                }
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td>Total</td>
                        <td>--</td>
                        <td>
                            <?php 
                            if($total_price!=0)
                            {
                                $_SESSION['total_price']=$total_price;
                                echo $total_price;
                            }
                            else{
                                echo '';
                            }
                        ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </table>

            <div class="payment-container">
                <h1><i class="fas fa-credit-card"></i> PAYMENT METHOD</h1>
                <form method="post" action="process_order.php" id="checkoutForm">
                    <div class="payment-selection" style="margin: 20px 0;">
                        <h3 style="color: #3b82f6; margin-bottom: 15px;">Select Payment Method</h3>
                        
                        <div class="payment-options">
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="cod" checked>
                                <span class="option-content">
                                    <i class="fas fa-money-bill-wave"></i>
                                    Cash on Delivery
                                </span>
                            </label>
                            
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="online">
                                <span class="option-content">
                                    <i class="fas fa-mobile-alt"></i>
                                    Online Payment (UPI)
                                </span>
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="checkout-btn <?php echo ($total_price == 0) ? 'disabled' : ''; ?>" 
                            <?php echo ($total_price == 0) ? 'disabled' : ''; ?>>
                        <i class="fas <?php echo ($total_price == 0) ? 'fa-shopping-cart' : 'fa-shopping-cart'; ?>"></i>
                        <?php echo ($total_price == 0) ? 'Cart is Empty' : 'Place Order ₹' . number_format($total_price, 2); ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
    </div>
    <?php include 'footer.php' ?>

    <script>
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const form = document.getElementById('checkoutForm');
            const btn = form.querySelector('.checkout-btn');
            const icon = btn.querySelector('i');
            
            if(this.value === 'online') {
                form.action = 'payment.php';
                icon.className = 'fas fa-credit-card';
                btn.innerHTML = `<i class="fas fa-credit-card"></i> Proceed to Payment ₹${<?php echo number_format($total_price, 2); ?>}`;
            } else {
                form.action = 'process_order.php';
                icon.className = 'fas fa-shopping-cart';
                btn.innerHTML = `<i class="fas fa-shopping-cart"></i> Place Order ₹${<?php echo number_format($total_price, 2); ?>}`;
            }
        });
    });

    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        const btn = this.querySelector('.checkout-btn');
        
        // Don't submit if disabled
        if(btn.classList.contains('disabled')) {
            e.preventDefault();
            return;
        }
        
        // Add loading state
        btn.classList.add('loading');
        const originalText = btn.innerHTML;
        btn.innerHTML = `<i class="fas fa-spinner fa-spin"></i> Processing...`;
        
        // Optional: Remove the setTimeout in production
        if(this.action.includes('process_order.php')) {
            setTimeout(() => {
                btn.classList.remove('loading');
                btn.innerHTML = originalText;
            }, 2000);
        }
    });
    </script>
</body>

</html>