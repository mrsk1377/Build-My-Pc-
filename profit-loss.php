<?php
session_start();
if(!isset($_SESSION['admin'])) {
    header('location: admin_login.php');
    exit();
}
include 'connect_database.php';

// Handle loss entry form submission
if(isset($_POST['add_loss'])) {
    $amount = $_POST['loss_amount'];
    $reason = $_POST['loss_reason'];
    $date = $_POST['loss_date'];
    $category = $_POST['loss_category'];
    
    $loss_sql = "INSERT INTO losses (amount, reason, date, category) VALUES (?, ?, ?, ?)";
    $stmt = $database->prepare($loss_sql);
    $stmt->bind_param("dsss", $amount, $reason, $date, $category);
    $stmt->execute();
}

// Get selected month and year
$selected_month = isset($_GET['month']) ? $_GET['month'] : date('m');
$selected_year = isset($_GET['year']) ? $_GET['year'] : date('Y');

// Get monthly stats
$monthly_stats = "SELECT 
    SUM(total_price) as total_revenue,
    COUNT(*) as total_orders,
    COUNT(DISTINCT userid) as unique_customers,
    AVG(total_price) as avg_order_value
    FROM product_details 
    WHERE MONTH(timestamp) = ? AND YEAR(timestamp) = ?";
$stmt = $database->prepare($monthly_stats);
$stmt->bind_param("ss", $selected_month, $selected_year);
$stmt->execute();
$stats = $stmt->get_result()->fetch_assoc();

// Get losses for selected month
$losses_query = "SELECT 
    SUM(amount) as total_losses,
    COUNT(*) as loss_count,
    GROUP_CONCAT(CONCAT('₹', amount, ' - ', reason) SEPARATOR '<br>') as loss_details
    FROM losses 
    WHERE MONTH(date) = ? AND YEAR(date) = ?";
$stmt = $database->prepare($losses_query);
$stmt->bind_param("ss", $selected_month, $selected_year);
$stmt->execute();
$losses = $stmt->get_result()->fetch_assoc();

// Calculate net profit/loss
$net_profit = ($stats['total_revenue'] ?? 0) - ($losses['total_losses'] ?? 0);

// Get payment method breakdown
$payment_stats = "SELECT 
    mode_of_payment,
    COUNT(*) as count,
    SUM(total_price) as amount
    FROM product_details 
    WHERE MONTH(timestamp) = ? AND YEAR(timestamp) = ?
    GROUP BY mode_of_payment";
$stmt = $database->prepare($payment_stats);
$stmt->bind_param("ss", $selected_month, $selected_year);
$stmt->execute();
$payment_methods = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profit & Loss - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f0f2f5;
        }
        
        .profit-loss-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            background: #1a237e;
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-card h3 {
            color: #666;
            margin: 0 0 10px 0;
            font-size: 16px;
            font-weight: 500;
        }
        
        .value {
            font-size: 28px;
            font-weight: 600;
            color: #1a237e;
        }
        
        .profit-table {
            width: 100%;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .profit-table th {
            background: #1a237e;
            color: white;
            padding: 15px;
            text-align: left;
        }

        .profit-table td {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        .profit-table tr:hover {
            background: #f8f9fa;
        }

        .back-btn {
            background: white;
            color: #1a237e;
            padding: 8px 16px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background: #e8eaf6;
        }

        .revenue {
            color: #388e3c;
            font-weight: 500;
        }

        .chart-section {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .month-selector {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            gap: 20px;
            align-items: center;
        }
        .month-selector select {
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .loss-form {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .loss-form input, .loss-form select, .loss-form textarea {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        .profit { color: #388e3c; }
        .loss { color: #d32f2f; }
        .payment-methods {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        .payment-card {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="profit-loss-container">
        <div class="header">
            <h1><i class="fas fa-chart-line"></i> Profit & Loss Analysis</h1>
            <a href="admin_dashboard.php" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
        
        <!-- Month Selector -->
        <div class="month-selector">
            <form method="GET">
                <select name="month" onchange="this.form.submit()">
                    <?php for($m = 1; $m <= 12; $m++): ?>
                        <option value="<?php echo $m; ?>" <?php echo $m == $selected_month ? 'selected' : ''; ?>>
                            <?php echo date('F', mktime(0, 0, 0, $m, 1)); ?>
                        </option>
                    <?php endfor; ?>
                </select>
                <select name="year" onchange="this.form.submit()">
                    <?php for($y = 2020; $y <= date('Y'); $y++): ?>
                        <option value="<?php echo $y; ?>" <?php echo $y == $selected_year ? 'selected' : ''; ?>>
                            <?php echo $y; ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </form>
        </div>

        <!-- Record Loss Form -->
        <div class="loss-form">
            <h3><i class="fas fa-exclamation-triangle"></i> Record Product Return/Loss</h3>
            <form method="POST">
                <input type="number" name="loss_amount" placeholder="Loss Amount" required>
                <select name="loss_category" required>
                    <option value="">Select Loss Category</option>
                    <option value="return">Product Return</option>
                    <option value="damage">Product Damage</option>
                    <option value="theft">Theft/Missing</option>
                    <option value="other">Other</option>
                </select>
                <textarea name="loss_reason" placeholder="Detailed reason for loss" required></textarea>
                <input type="date" name="loss_date" required>
                <button type="submit" name="add_loss" class="btn">Record Loss</button>
            </form>
        </div>

        <!-- Summary Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Revenue</h3>
                <div class="value">₹<?php echo number_format($stats['total_revenue'] ?? 0, 2); ?></div>
            </div>
            <div class="stat-card">
                <h3>Total Orders</h3>
                <div class="value"><?php echo $stats['total_orders'] ?? 0; ?></div>
            </div>
            <div class="stat-card">
                <h3>Unique Customers</h3>
                <div class="value"><?php echo $stats['unique_customers'] ?? 0; ?></div>
            </div>
            <div class="stat-card">
                <h3>Total Losses</h3>
                <div class="value loss">₹<?php echo number_format($losses['total_losses'] ?? 0, 2); ?></div>
            </div>
            <div class="stat-card">
                <h3>Net Profit/Loss</h3>
                <div class="value <?php echo $net_profit >= 0 ? 'profit' : 'loss'; ?>">
                    ₹<?php echo number_format($net_profit, 2); ?>
                </div>
            </div>
            <div class="stat-card">
                <h3>Average Order Value</h3>
                <div class="value">₹<?php echo number_format($stats['avg_order_value'] ?? 0, 2); ?></div>
            </div>
        </div>

        <!-- Payment Methods -->
        <div class="chart-section">
            <h2><i class="fas fa-credit-card"></i> Payment Methods</h2>
            <div class="payment-methods">
                <?php while($payment = mysqli_fetch_assoc($payment_methods)): ?>
                <div class="payment-card">
                    <h4><?php echo ucfirst($payment['mode_of_payment']); ?></h4>
                    <p>Orders: <?php echo $payment['count']; ?></p>
                    <p>Total: ₹<?php echo number_format($payment['amount'], 2); ?></p>
                </div>
                <?php endwhile; ?>
            </div>
        </div>

        <!-- Loss Details -->
        <?php if($losses['loss_count'] > 0): ?>
        <div class="chart-section">
            <h2><i class="fas fa-exclamation-circle"></i> Loss Details</h2>
            <div class="loss-details">
                <?php echo $losses['loss_details']; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</body>
</html> 