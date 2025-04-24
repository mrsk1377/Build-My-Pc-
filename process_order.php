<?php
session_start();
include 'connect_database.php';

if(!isset($_SESSION['customer'])) {
    header('location:login.php');
    exit();
}

if(isset($_SESSION['prebuilt_pc'])) {
    // Process prebuilt PC order
    $user_id = $_SESSION['customer'];
    $total_price = $_SESSION['prebuilt_pc']['price'];
    $payment_method = $_POST['payment_method'];
    
    // Insert into product_details table
    $sql = "INSERT INTO product_details (userid, total_price, mode_of_payment, order_status, timestamp) 
            VALUES (?, ?, ?, 'Pending', NOW())";
    
    $stmt = $database->prepare($sql);
    $stmt->bind_param("sds", $user_id, $total_price, $payment_method);
    
    if($stmt->execute()) {
        // Clear the cart after successful order
        unset($_SESSION['prebuilt_pc']);
        $_SESSION['order_success'] = true;
        
        if($payment_method === 'cod') {
            header('Location: order_confirmation.php');
        } else {
            header('Location: payment.php');
        }
        exit();
    } else {
        $_SESSION['order_error'] = "Failed to place order. Please try again.";
        header('location:cart.php');
        exit();
    }
} else {
    $user_id = $_SESSION['customer'];
    $payment_method = $_POST['payment_method'];
    $total_amount = isset($_SESSION['total_price']) ? $_SESSION['total_price'] : 0;

    if($payment_method === 'cod') {
        // For Cash on Delivery
        $sql = "INSERT INTO payments (user_id, amount, payment_method, payment_status) 
                VALUES (?, ?, 'COD', 'pending')";
                
        $stmt = mysqli_prepare($database, $sql);
        mysqli_stmt_bind_param($stmt, "sd", $user_id, $total_amount);
        
        if(mysqli_stmt_execute($stmt)) {
            $payment_id = mysqli_insert_id($database);
            $_SESSION['payment_id'] = $payment_id;
            
            // Clear cart items from session
            unset($_SESSION['cabinet_full_name']);
            unset($_SESSION['cabinet_price']);
            unset($_SESSION['cpu_full_name']);
            unset($_SESSION['cpu_price']);
            unset($_SESSION['cpu_cooler_full_name']);
            unset($_SESSION['cpu_cooler_price']);
            unset($_SESSION['motherboard_full_name']);
            unset($_SESSION['motherboard_price']);
            unset($_SESSION['ram_full_name']);
            unset($_SESSION['ram_price']);
            unset($_SESSION['storage_full_name']);
            unset($_SESSION['storage_price']);
            unset($_SESSION['gpu_full_name']);
            unset($_SESSION['gpu_price']);
            unset($_SESSION['psu_full_name']);
            unset($_SESSION['psu_price']);
            unset($_SESSION['total_price']);
            
            // Store order details in session for confirmation page
            $_SESSION['order_success'] = true;
            $_SESSION['order_amount'] = $total_amount;
            $_SESSION['payment_method'] = 'Cash on Delivery';
            
            header('location:order_confirmation.php');
            exit();
        } else {
            $_SESSION['order_error'] = "Failed to place order. Please try again.";
            header('location:cart.php');
            exit();
        }
    } else {
        // For Online Payment
        $_SESSION['total_amount'] = $total_amount;
        header('location:payment.php');
        exit();
    }
}
?> 