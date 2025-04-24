<?php
session_start();
if(!isset($_SESSION['admin'])) {
    header('location: admin_login.php');
    exit();
}
include 'connect_database.php';

// Handle order status updates
if(isset($_POST['update_order'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    
    $update_sql = "UPDATE product_details SET order_status = ? WHERE id = ?";
    $stmt = $database->prepare($update_sql);
    $stmt->bind_param("si", $status, $order_id);
    
    if($stmt->execute()) {
        $_SESSION['status_update'] = "Order #$order_id status updated to $status!";
    } else {
        $_SESSION['status_update'] = "Error updating order #$order_id";
    }
    
    header("Location: manage-orders.php");
    exit();
}

// Get orders from product_details table
$orders_query = "SELECT pd.*, u.first_name, u.last_name 
                FROM product_details pd 
                LEFT JOIN user_details u ON pd.userid = u.user_id 
                WHERE pd.mode_of_payment IS NOT NULL 
                ORDER BY pd.timestamp DESC";

$orders_result = mysqli_query($database, $orders_query);

// Debug: Print the query and number of results
if (!$orders_result) {
    echo "Error in query: " . mysqli_error($database);
} else {
    $num_rows = mysqli_num_rows($orders_result);
    if ($num_rows == 0) {
        echo "<p style='color: black;'>No orders found in database.</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Orders - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: #f0f2f5;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .orders-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }

        .orders-box {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h1 {
            color: #1a237e;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .status-message {
            background: #4CAF50;
            color: white;
            padding: 15px 25px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: none;
            font-weight: 500;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        th {
            background: #1a237e;
            color: white;
            font-weight: 500;
        }

        tr:hover {
            background: #f5f5f5;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            display: inline-block;
        }
        
        .status-Pending {
            background: #fff3e0;
            color: #f57c00;
        }
        
        .status-Processing {
            background: #e3f2fd;
            color: #1976d2;
        }
        
        .status-Shipped {
            background: #f3e5f5;
            color: #7b1fa2;
        }
        
        .status-Delivered {
            background: #e8f5e9;
            color: #388e3c;
        }
        
        .status-Cancelled {
            background: #ffebee;
            color: #d32f2f;
        }

        .update-btn {
            padding: 8px 16px;
            background: #1a237e;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .update-btn:hover {
            background: #283593;
            transform: translateY(-1px);
        }

        .status-select {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-right: 8px;
            width: 140px;
        }

        .back-btn {
            display: inline-block;
            padding: 10px 20px;
            background: #1a237e;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .back-btn:hover {
            background: #283593;
        }
    </style>
</head>
<body>
    <div class="orders-container">
        <a href="admin_dashboard.php" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>

        <?php if(isset($_SESSION['status_update'])): ?>
            <div class="status-message" style="display: block;">
                <?php 
                    echo $_SESSION['status_update'];
                    unset($_SESSION['status_update']);
                ?>
            </div>
        <?php endif; ?>

        <div class="orders-box">
            <h1><i class="fas fa-shopping-cart"></i> Manage Orders</h1>
            
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Payment</th>
                    <th>Date</th>
                    <th>Current Status</th>
                    <th>Update Status</th>
                </tr>
                <?php while($order = mysqli_fetch_assoc($orders_result)): ?>
                <tr>
                    <td>#<?php echo $order['id']; ?></td>
                    <td><?php echo $order['first_name'] . ' ' . $order['last_name']; ?></td>
                    <td>₹<?php echo number_format($order['total_price'], 2); ?></td>
                    <td><?php echo ucfirst($order['mode_of_payment']); ?></td>
                    <td><?php echo date('d M Y', strtotime($order['timestamp'])); ?></td>
                    <td>
                        <span class="status-badge status-<?php echo $order['order_status'] ?? 'Pending'; ?>">
                            <?php echo $order['order_status'] ?? 'Pending'; ?>
                        </span>
                    </td>
                    <td>
                        <form method="POST" style="display: flex; align-items: center;" onsubmit="return confirm('Are you sure you want to update this order status?');">
                            <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                            <select name="status" class="status-select">
                                <option value="Pending" <?php echo ($order['order_status'] ?? 'Pending') == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="Processing" <?php echo ($order['order_status'] ?? '') == 'Processing' ? 'selected' : ''; ?>>Processing</option>
                                <option value="Shipped" <?php echo ($order['order_status'] ?? '') == 'Shipped' ? 'selected' : ''; ?>>Shipped</option>
                                <option value="Delivered" <?php echo ($order['order_status'] ?? '') == 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                                <option value="Cancelled" <?php echo ($order['order_status'] ?? '') == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                            <button type="submit" name="update_order" class="update-btn">
                                <i class="fas fa-sync-alt"></i> Update
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>

    <script>
        // Auto-hide status message after 3 seconds
        setTimeout(function() {
            const statusMessage = document.querySelector('.status-message');
            if(statusMessage) {
                statusMessage.style.display = 'none';
            }
        }, 3000);
    </script>
</body>
</html> 