<?php
session_start();
if(!isset($_SESSION['admin'])) {
    header('location: admin_login.php');
    exit();
}
include 'connect_database.php';

// Handle Add Item
if(isset($_POST['add_item'])) {
    $name = $_POST['item_name'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $supplier = $_POST['supplier'];
    
    $sql = "INSERT INTO inventory (item_name, category, quantity, price, supplier) VALUES (?, ?, ?, ?, ?)";
    $stmt = $database->prepare($sql);
    $stmt->bind_param("ssids", $name, $category, $quantity, $price, $supplier);
    $stmt->execute();
}

// Handle Update Quantity
if(isset($_POST['update_quantity'])) {
    $id = $_POST['item_id'];
    $new_quantity = $_POST['new_quantity'];
    
    $sql = "UPDATE inventory SET quantity = ? WHERE id = ?";
    $stmt = $database->prepare($sql);
    $stmt->bind_param("ii", $new_quantity, $id);
    $stmt->execute();
}

// Handle Delete Item
if(isset($_POST['delete_item'])) {
    $id = $_POST['item_id'];
    
    $sql = "DELETE FROM inventory WHERE id = ?";
    $stmt = $database->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

// Get inventory items
$items = $database->query("SELECT * FROM inventory ORDER BY category, item_name");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventory Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f0f2f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .add-form {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .btn {
            background: #1a237e;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-danger {
            background: #dc3545;
        }
        .inventory-table {
            width: 100%;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        th {
            background: #f8f9fa;
            font-weight: 600;
        }
        .quantity-form {
            display: flex;
            gap: 10px;
        }
        .quantity-form input {
            width: 80px;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .category-header {
            background: #e3f2fd;
            font-weight: bold;
        }
        .low-stock {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-boxes"></i> Inventory Management</h1>
            <a href="admin_dashboard.php" class="btn">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        <!-- Add Item Form -->
        <div class="add-form">
            <h2><i class="fas fa-plus-circle"></i> Add New Item</h2>
            <form method="POST" class="form-grid">
                <div class="form-group">
                    <label>Item Name</label>
                    <input type="text" name="item_name" required>
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <select name="category" required>
                        <option value="CPU">CPU</option>
                        <option value="GPU">GPU</option>
                        <option value="RAM">RAM</option>
                        <option value="Storage">Storage</option>
                        <option value="Motherboard">Motherboard</option>
                        <option value="PSU">Power Supply</option>
                        <option value="Case">Case</option>
                        <option value="Cooling">Cooling</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" name="quantity" min="0" required>
                </div>
                <div class="form-group">
                    <label>Price (₹)</label>
                    <input type="number" name="price" min="0" step="0.01" required>
                </div>
                <div class="form-group">
                    <label>Supplier</label>
                    <input type="text" name="supplier">
                </div>
                <div class="form-group">
                    <label>&nbsp;</label>
                    <button type="submit" name="add_item" class="btn">Add Item</button>
                </div>
            </form>
        </div>

        <!-- Inventory Table -->
        <div class="inventory-table">
            <table>
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Supplier</th>
                        <th>Last Updated</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $current_category = '';
                    while($item = mysqli_fetch_assoc($items)): 
                        if($current_category != $item['category']):
                            $current_category = $item['category'];
                    ?>
                        <tr class="category-header">
                            <td colspan="7"><?php echo $current_category; ?></td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                        <td><?php echo htmlspecialchars($item['category']); ?></td>
                        <td class="<?php echo $item['quantity'] < 5 ? 'low-stock' : ''; ?>">
                            <form method="POST" class="quantity-form">
                                <input type="hidden" name="item_id" value="<?php echo $item['id']; ?>">
                                <input type="number" name="new_quantity" value="<?php echo $item['quantity']; ?>" min="0">
                                <button type="submit" name="update_quantity" class="btn">Update</button>
                            </form>
                        </td>
                        <td>₹<?php echo number_format($item['price'], 2); ?></td>
                        <td><?php echo htmlspecialchars($item['supplier']); ?></td>
                        <td><?php echo date('d M Y H:i', strtotime($item['last_updated'])); ?></td>
                        <td>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="item_id" value="<?php echo $item['id']; ?>">
                                <button type="submit" name="delete_item" class="btn btn-danger" 
                                        onclick="return confirm('Are you sure you want to delete this item?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html> 