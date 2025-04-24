<?php
session_start();
include 'connect_database.php';

if(!isset($_SESSION['admin'])) {
    header('location:admin_login.php');
    exit();
}

if(isset($_POST['change_password'])) {
    $current = $_POST['current_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];
    
    if($new !== $confirm) {
        $_SESSION['error'] = "New passwords do not match";
        header('location:admin_dashboard.php');
        exit();
    }
    
    // Verify current password
    $admin_email = $_SESSION['admin'];
    $check_password = "SELECT password FROM user WHERE email = ? AND is_admin = 1";
    $stmt = mysqli_prepare($database, $check_password);
    mysqli_stmt_bind_param($stmt, "s", $admin_email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $admin = mysqli_fetch_assoc($result);
    
    if(password_verify($current, $admin['password'])) {
        // Update password
        $hashed_password = password_hash($new, PASSWORD_DEFAULT);
        $update_password = "UPDATE user SET password = ? WHERE email = ? AND is_admin = 1";
        $stmt = mysqli_prepare($database, $update_password);
        mysqli_stmt_bind_param($stmt, "ss", $hashed_password, $admin_email);
        
        if(mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = "Password updated successfully";
        } else {
            $_SESSION['error'] = "Failed to update password";
        }
    } else {
        $_SESSION['error'] = "Current password is incorrect";
    }
    
    header('location:admin_dashboard.php');
    exit();
}
?> 