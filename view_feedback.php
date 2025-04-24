<?php
session_start();
if(!isset($_SESSION['admin'])) {
    header('location: admin_login.php');
    exit();
}
include 'connect_database.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Mark as read
    $update_sql = "UPDATE feedback SET status = 'read' WHERE id = ?";
    $stmt = $database->prepare($update_sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    // Get feedback details
    $sql = "SELECT * FROM feedback WHERE id = ?";
    $stmt = $database->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $feedback = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Feedback</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background: #0a1929;
            color: white;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: rgba(10, 15, 29, 0.8);
            padding: 20px;
            border-radius: 10px;
            border: 1px solid rgba(59, 130, 246, 0.2);
        }
        .feedback-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .back-btn {
            background: #3b82f6;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .feedback-details {
            background: rgba(59, 130, 246, 0.1);
            padding: 20px;
            border-radius: 8px;
        }
        .feedback-details p {
            margin: 10px 0;
        }
        .label {
            color: #3b82f6;
            font-weight: bold;
        }
        .message-box {
            background: rgba(255, 255, 255, 0.05);
            padding: 15px;
            border-radius: 8px;
            margin-top: 10px;
            white-space: pre-wrap;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="feedback-header">
            <h1>Feedback Details</h1>
            <a href="admin_dashboard.php" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
        
        <div class="feedback-details">
            <p><span class="label">Name:</span> <?php echo htmlspecialchars($feedback['name']); ?></p>
            <p><span class="label">Email:</span> <?php echo htmlspecialchars($feedback['email']); ?></p>
            <p><span class="label">Phone:</span> <?php echo htmlspecialchars($feedback['phone']); ?></p>
            <p><span class="label">Submitted on:</span> <?php echo date('d M Y H:i', strtotime($feedback['created_at'])); ?></p>
            <p><span class="label">Status:</span> <?php echo ucfirst($feedback['status']); ?></p>
            <p><span class="label">Message:</span></p>
            <div class="message-box">
                <?php echo nl2br(htmlspecialchars($feedback['message'])); ?>
            </div>
        </div>
    </div>
</body>
</html> 