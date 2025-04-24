<?php
session_start();
include 'connect_database.php';

if(!isset($_SESSION['customer']) || !isset($_POST['transaction_id'])) {
    header('location:cart.php');
    exit();
}

$user_id = $_SESSION['customer'];
$total_amount = $_SESSION['total_amount'];
$transaction_id = mysqli_real_escape_string($database, $_POST['transaction_id']);

// Insert payment into database
$sql = "INSERT INTO payments (user_id, amount, payment_method, payment_status, transaction_id) 
        VALUES ('$user_id', $total_amount, 'UPI', 'completed', '$transaction_id')";

if(mysqli_query($database, $sql)) {
    $payment_id = mysqli_insert_id($database);
    $_SESSION['payment_id'] = $payment_id;
    
    // Clear cart after successful payment
    $clear_cart = "DELETE FROM cart WHERE user_id = '$user_id'";
    mysqli_query($database, $clear_cart);
    
    header('location:order_confirmation.php');
    exit();
} else {
    $_SESSION['payment_error'] = "Payment verification failed. Please try again.";
    header('location:payment.php');
    exit();
}
?> 