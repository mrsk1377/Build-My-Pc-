<?php
session_start();
if(!isset($_SESSION['admin'])) {
    header('location: admin_login.php');
    exit();
}

include 'connect_database.php';

// Add new component
if(isset($_POST['add_component'])) {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $stock = $_POST['stock'];
    $price = $_POST['price'];
    
    $sql = "INSERT INTO components (name, category, stock, price) VALUES (?, ?, ?, ?)";
    $stmt = $database->prepare($sql);
    $stmt->bind_param("ssid", $name, $category, $stock, $price);
    $stmt->execute();
}

// Get total orders
$orders_query = "SELECT COUNT(*) as total FROM product_details";
$orders_result = mysqli_query($database, $orders_query);
$total_orders = mysqli_fetch_assoc($orders_result)['total'];

// Get total revenue
$revenue_query = "SELECT SUM(total_price) as total FROM product_details";
$revenue_result = mysqli_query($database, $revenue_query);
$total_revenue = mysqli_fetch_assoc($revenue_result)['total'];

// Get total customers
$customers_query = "SELECT COUNT(DISTINCT userid) as total FROM product_details";
$customers_result = mysqli_query($database, $customers_query);
$total_customers = mysqli_fetch_assoc($customers_result)['total'];

// Get recent payments
$payments_query = "SELECT p.*, u.first_name, u.last_name 
    FROM payments p 
    LEFT JOIN user_details u ON p.user_id = u.user_id 
    ORDER BY p.created_at DESC LIMIT 5";
$payments = mysqli_query($database, $payments_query);

// Get low stock items
$stock_query = "SELECT * FROM components WHERE stock < 10";
$low_stock = mysqli_query($database, $stock_query);

// Add this query with your other queries at the top
$feedback_query = "SELECT * FROM feedback ORDER BY created_at DESC LIMIT 5";
$feedback_result = mysqli_query($database, $feedback_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - BuildMyPC</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        .admin-dashboard {
            background: #ffffff;
            min-height: 100vh;
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        /* Remove the cyber grid background */
        .admin-dashboard::before {
            display: none;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .dashboard-header h1 {
            color: #1a237e;
            font-size: 2rem;
        }

        .logout-btn {
            padding: 10px 20px;
            background: transparent;
            border: 2px solid #3b82f6;
            color: #3b82f6;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: #3b82f6;
            color: white;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: #ffffff;
            padding: 20px;
            border-radius: 15px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .stat-card h3 {
            color: #a3a3a3;
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .stat-card .value {
            color: #1a237e;
            font-size: 2rem;
            font-weight: bold;
        }

        .section {
            background: #ffffff;
            padding: 20px;
            border-radius: 15px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .section h2 {
            color: #1a237e;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #ffffff;
            border: 1px solid #e2e8f0;
        }

        th, td {
            padding: 12px;
            text-align: left;
            color: #333;
            border-bottom: 1px solid rgba(59, 130, 246, 0.1);
        }

        th {
            background: #f8fafc;
            color: #1a237e;
        }

        tr:hover td {
            background: rgba(59, 130, 246, 0.05);
        }

        .low-stock {
            color: #ef4444;
        }

        @media (max-width: 768px) {
            .admin-dashboard {
                padding: 20px;
            }

            .dashboard-header {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }
        }

        /* Admin Navigation Styling */
        .admin-nav {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .nav-link {
            min-width: 200px;
            padding: 15px 25px;
            background: #1a237e;
            border: none;
            border-radius: 12px;
            color: #ffffff;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .nav-link:hover {
            background: #3949ab;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .nav-link i {
            font-size: 1.2rem;
        }

        /* Form Styling */
        .add-component-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .add-component-form input,
        .add-component-form select {
            padding: 12px;
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.3);
            border-radius: 8px;
            color: white;
            font-size: 1rem;
        }

        .add-component-form button {
            background: #1a237e;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .add-component-form button:hover {
            background: #3949ab;
        }

        /* Password Change Form */
        .admin-section form {
            display: grid;
            gap: 15px;
            max-width: 400px;
            margin: 20px 0;
        }

        .admin-section input {
            padding: 12px;
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.3);
            border-radius: 8px;
            color: white;
        }

        .admin-section button {
            background: #1a237e;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .admin-section button:hover {
            background: #3949ab;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .admin-nav {
                flex-direction: column;
            }
            
            .nav-link {
                width: 100%;
            }
            
            .add-component-form {
                grid-template-columns: 1fr;
            }
        }

        .view-btn {
            background: #1a237e;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.9em;
        }

        .view-btn:hover {
            background: #3949ab;
        }
    </style>
</head>
<body>
    <div class="admin-dashboard">
        <div class="dashboard-container">
            <div class="dashboard-header">
                <h1>Admin Dashboard</h1>
                <a href="admin_logout.php" class="logout-btn">Logout</a>
            </div>

            <!-- Add this after the dashboard header -->
            <div class="admin-nav">
                <a href="inventory.php" class="nav-link">
                    <i class="fas fa-boxes"></i> Inventory Management
                </a>
                <a href="profit-loss.php" class="nav-link">
                    <i class="fas fa-chart-line"></i> Profit & Loss
                </a>
                <a href="monthly-stats.php" class="nav-link">
                    <i class="fas fa-calendar-alt"></i> Monthly Stats
                </a>
                <a href="manage-orders.php" class="nav-link">
                    <i class="fas fa-shopping-cart"></i> Manage Orders
                </a>
                <a href="all_feedback.php" class="nav-link">
                    <i class="fas fa-comments"></i> View All Feedback
                </a>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Total Orders</h3>
                    <div class="value"><?php echo $total_orders; ?></div>
                </div>
                <div class="stat-card">
                    <h3>Total Revenue</h3>
                    <div class="value">₹<?php echo number_format($total_revenue, 2); ?></div>
                </div>
                <div class="stat-card">
                    <h3>Total Customers</h3>
                    <div class="value"><?php echo $total_customers; ?></div>
                </div>
            </div>

            <div class="section">
                <h2>Add New Component</h2>
                <form method="POST" class="add-component-form">
                    <input type="text" name="name" placeholder="Component Name" required>
                    <select name="category" required>
                        <option value="">Select Category</option>
                        <option value="CPU">CPU</option>
                        <option value="GPU">GPU</option>
                        <option value="RAM">RAM</option>
                        <option value="Storage">Storage</option>
                    </select>
                    <input type="number" name="stock" placeholder="Stock Quantity" required>
                    <input type="number" name="price" placeholder="Price" required>
                    <button type="submit" name="add_component">Add Component</button>
                </form>
            </div>

            <div class="section">
                <h2>Recent Payments</h2>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Status</th>
                    </tr>
                    <?php while($payment = mysqli_fetch_assoc($payments)): ?>
                    <tr>
                        <td>#<?php echo $payment['payment_id']; ?></td>
                        <td><?php echo $payment['first_name'] . ' ' . $payment['last_name']; ?></td>
                        <td>₹<?php echo number_format($payment['amount'], 2); ?></td>
                        <td><?php echo $payment['payment_method']; ?></td>
                        <td><?php echo $payment['payment_status']; ?></td>
                    </tr>
                    <?php endwhile; ?>
                </table>
            </div>

            <div class="section">
                <h2>Recent Feedback</h2>
                <table>
                    <tr>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    <?php while($feedback = mysqli_fetch_assoc($feedback_result)): ?>
                    <tr>
                        <td><?php echo date('d M Y', strtotime($feedback['created_at'])); ?></td>
                        <td><?php echo htmlspecialchars($feedback['name']); ?></td>
                        <td><?php echo htmlspecialchars($feedback['email']); ?></td>
                        <td><?php echo htmlspecialchars($feedback['phone']); ?></td>
                        <td>
                            <span class="status-badge <?php echo $feedback['status']; ?>">
                                <?php echo ucfirst($feedback['status']); ?>
                            </span>
                        </td>
                        <td>
                            <a href="view_feedback.php?id=<?php echo $feedback['id']; ?>" class="view-btn">
                                <i class="fas fa-eye"></i> View
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </table>
                <div class="view-all">
                    <a href="all_feedback.php" class="nav-link">View All Feedback</a>
                </div>
            </div>

            <!-- Add this section to change admin password -->
            <div class="admin-section">
                <h2>Change Admin Password</h2>
                <form method="post" action="change_admin_password.php">
                    <input type="password" name="current_password" placeholder="Current Password" required>
                    <input type="password" name="new_password" placeholder="New Password" required>
                    <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
                    <button type="submit" name="change_password">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html> 