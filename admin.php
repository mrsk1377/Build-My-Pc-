<?php
session_start();
if(isset($_SESSION['admin'])) {
    header('location: admin_dashboard.php');
    exit();
}

// Redirect to admin login
header('location: admin_login.php');
exit();
?> 