<?php
session_start();
include 'connect_database.php';

if(!isset($_SESSION['customer'])) {
    header('location:login.php');
    exit();
}

if(isset($_POST['submit_payment'])) {
    $user_id = $_SESSION['customer'];
    $total_amount = $_SESSION['order_amount'];
    $payment_method = $_POST['payment_method'];
    $transaction_id = ($payment_method == 'upi') ? $_POST['transaction_id'] : NULL;
    
    // Get user details
    $user_query = "SELECT first_name, last_name FROM user_details WHERE user_id = ?";
    $stmt = $database->prepare($user_query);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_data = $result->fetch_assoc();
    
    $customer_name = $user_data['first_name'] . ' ' . $user_data['last_name'];
    
    // Insert into orders table
    $insert_order = "INSERT INTO orders (user_id, customer_name, total_amount, payment_method, transaction_id) 
                     VALUES (?, ?, ?, ?, ?)";
    $stmt = $database->prepare($insert_order);
    $stmt->bind_param("ssdss", $user_id, $customer_name, $total_amount, $payment_method, $transaction_id);
    
    if($stmt->execute()) {
        // Clear cart/session data
        unset($_SESSION['order_amount']);
        // Redirect to order confirmation page
        header('location: order_confirmation.php');
    } else {
        header('location: payment.php?error=1');
    }
}
?> 