<?php
session_start();
if(!isset($_SESSION['admin'])) {
    header('location: admin_login.php');
    exit();
}
include 'connect_database.php';

// Get selected month and year
$selected_month = isset($_GET['month']) ? $_GET['month'] : date('m');
$selected_year = isset($_GET['year']) ? $_GET['year'] : date('Y');
$month_name = date('F Y', mktime(0, 0, 0, $selected_month, 1, $selected_year));

// Get all orders for the selected month with simplified order type detection
$orders_query = "SELECT 
    DATE(timestamp) as sale_date,
    userid,
    total_price,
    mode_of_payment,
    CASE 
        WHEN gpu_id IS NOT NULL OR ram_id IS NOT NULL THEN 'Custom Build'
        ELSE 'Prebuilt PC'
    END as order_type
    FROM product_details 
    WHERE MONTH(timestamp) = ? 
    AND YEAR(timestamp) = ?
    ORDER BY timestamp DESC";

$stmt = $database->prepare($orders_query);
$stmt->bind_param("ss", $selected_month, $selected_year);
$stmt->execute();
$result = $stmt->get_result();

// Initialize arrays to store different types of orders
$custom_builds = array();
$prebuilt_sales = array();
$custom_total = 0;
$prebuilt_total = 0;
$custom_count = 0;
$prebuilt_count = 0;

// Sort orders into appropriate arrays
while($row = mysqli_fetch_assoc($result)) {
    if($row['order_type'] == 'Custom Build') {
        $custom_builds[] = $row;
        $custom_total += $row['total_price'];
        $custom_count++;
    } else {
        $prebuilt_sales[] = $row;
        $prebuilt_total += $row['total_price'];
        $prebuilt_count++;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monthly Statistics</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f0f2f5;
        }
        .stats-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
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
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .sales-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .sales-section h2 {
            color: #1a237e;
            margin-top: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        th {
            background: #f8f9fa;
            font-weight: 600;
        }
        .total-row {
            font-weight: bold;
            background: #f8f9fa;
        }
        .back-btn {
            background: #1a237e;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
    </style>
</head>
<body>
    <div class="stats-container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h1>Monthly Statistics - <?php echo $month_name; ?></h1>
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

        <!-- Custom Builds Section -->
        <div class="sales-section">
            <h2><i class="fas fa-tools"></i> Custom PC Builds</h2>
            <table>
                <tr>
                    <th>Date</th>
                    <th>Customer ID</th>
                    <th>Payment Method</th>
                    <th>Amount</th>
                </tr>
                <?php foreach($custom_builds as $row): ?>
                <tr>
                    <td><?php echo date('d M Y', strtotime($row['sale_date'])); ?></td>
                    <td><?php echo $row['userid']; ?></td>
                    <td><?php echo $row['mode_of_payment']; ?></td>
                    <td>₹<?php echo number_format($row['total_price'], 2); ?></td>
                </tr>
                <?php endforeach; ?>
                <tr class="total-row">
                    <td colspan="2">Total Custom Builds: <?php echo $custom_count; ?></td>
                    <td colspan="2">Total Revenue: ₹<?php echo number_format($custom_total, 2); ?></td>
                </tr>
            </table>
        </div>

        <!-- Prebuilt PCs Section -->
        <div class="sales-section">
            <h2><i class="fas fa-desktop"></i> Prebuilt PC Sales</h2>
            <table>
                <tr>
                    <th>Date</th>
                    <th>Customer ID</th>
                    <th>Payment Method</th>
                    <th>Amount</th>
                </tr>
                <?php foreach($prebuilt_sales as $row): ?>
                <tr>
                    <td><?php echo date('d M Y', strtotime($row['sale_date'])); ?></td>
                    <td><?php echo $row['userid']; ?></td>
                    <td><?php echo $row['mode_of_payment']; ?></td>
                    <td>₹<?php echo number_format($row['total_price'], 2); ?></td>
                </tr>
                <?php endforeach; ?>
                <tr class="total-row">
                    <td colspan="2">Total Prebuilt Sales: <?php echo $prebuilt_count; ?></td>
                    <td colspan="2">Total Revenue: ₹<?php echo number_format($prebuilt_total, 2); ?></td>
                </tr>
            </table>
        </div>

        <!-- Monthly Summary -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Sales</h3>
                <p>₹<?php echo number_format($custom_total + $prebuilt_total, 2); ?></p>
                <small>Custom: ₹<?php echo number_format($custom_total, 2); ?></small><br>
                <small>Prebuilt: ₹<?php echo number_format($prebuilt_total, 2); ?></small>
            </div>
            <div class="stat-card">
                <h3>Total Orders</h3>
                <p><?php echo $custom_count + $prebuilt_count; ?></p>
                <small>Custom Builds: <?php echo $custom_count; ?></small><br>
                <small>Prebuilt PCs: <?php echo $prebuilt_count; ?></small>
            </div>
            <div class="stat-card">
                <h3>Average Order Value</h3>
                <p>₹<?php 
                    $total_orders = $custom_count + $prebuilt_count;
                    echo $total_orders > 0 ? 
                        number_format(($custom_total + $prebuilt_total) / $total_orders, 2) : 
                        '0.00'; 
                ?></p>
            </div>
        </div>
    </div>
</body>
</html> 