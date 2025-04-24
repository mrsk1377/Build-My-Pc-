<?php
session_start();
include 'connect_database.php';

if(isset($_POST['submit'])) {
    $first_name = mysqli_real_escape_string($database, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($database, $_POST['last_name']);
    $contact_number = mysqli_real_escape_string($database, $_POST['contact_number']);
    $address = mysqli_real_escape_string($database, $_POST['address']);
    $city = mysqli_real_escape_string($database, $_POST['city']);
    $state = mysqli_real_escape_string($database, $_POST['state']);
    $country = mysqli_real_escape_string($database, $_POST['country']);
    $zip_code = mysqli_real_escape_string($database, $_POST['zip-code']);
    $user_id = $_SESSION['customer'];

    // Check if user already exists in user_details
    $check_sql = "SELECT * FROM user_details WHERE user_id = '$user_id'";
    $result = mysqli_query($database, $check_sql);

    if(mysqli_num_rows($result) > 0) {
        // Update existing user details
        $sql = "UPDATE user_details SET 
                first_name = '$first_name',
                last_name = '$last_name',
                contact_number = '$contact_number',
                address = '$address',
                city = '$city',
                state = '$state',
                country = '$country',
                zip_code = '$zip_code'
                WHERE user_id = '$user_id'";
                
        if(mysqli_query($database, $sql)) {
            $_SESSION['update'] = "Details Updated Successfully!";
            header('location:myaccount.php');
            exit();
        } else {
            $_SESSION['update'] = "Failed to Update Details";
            header('location:myaccount.php');
            exit();
        }
    } else {
        // Insert new user details
        $sql = "INSERT INTO user_details (
                user_id, first_name, last_name, contact_number, 
                address, city, state, country, zip_code
            ) VALUES (
                '$user_id', '$first_name', '$last_name', '$contact_number',
                '$address', '$city', '$state', '$country', '$zip_code'
            )";

        if(mysqli_query($database, $sql)) {
            $_SESSION['update'] = "Details Added Successfully!";
            header('location:myaccount.php');
            exit();
        } else {
            $_SESSION['update'] = "Failed to Add Details";
            header('location:myaccount.php');
            exit();
        }
    }
} else {
    header('location:myaccount.php');
    exit();
}
?>

<style>
    .success-message {
        position: fixed;
        top: 20px;
        right: 20px;
        background: rgba(34, 197, 94, 0.9);
        color: white;
        padding: 15px 25px;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(34, 197, 94, 0.3);
        animation: slideIn 0.5s ease forwards;
        z-index: 1000;
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
</style>

    



?>