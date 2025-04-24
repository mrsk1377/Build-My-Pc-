<?php
  session_start();
  include 'connect_database.php'; // Database connection

  // Handle adding prebuilt PC to cart
  if(isset($_GET['pc'])) {
      $pc_id = $_GET['pc'];
      $query = "SELECT * FROM prebuilt_pcs WHERE id = ?";
      $stmt = $database->prepare($query);
      $stmt->bind_param("i", $pc_id);
      $stmt->execute();
      $result = $stmt->get_result();
      
      if($pc = $result->fetch_assoc()) {
          // Store prebuilt PC details in session
          $_SESSION['prebuilt_pc'] = array(
              'id' => $pc['id'],
              'name' => $pc['name'],
              'price' => $pc['price'],
              'specs' => array(
                  'cpu' => $pc['cpu'],
                  'gpu' => $pc['gpu'],
                  'ram' => $pc['ram'],
                  'storage' => $pc['storage']
              )
          );
          
          // Clear any custom build selections
          unset(
              $_SESSION['processor_name'],
              $_SESSION['processor_price'],
              $_SESSION['gpu_name'],
              $_SESSION['gpu_price'],
              $_SESSION['ram_name'],
              $_SESSION['ram_price'],
              $_SESSION['mb_name'],
              $_SESSION['mb_price'],
              $_SESSION['ssd_name'],
              $_SESSION['ssd_price'],
              $_SESSION['hdd_name'],
              $_SESSION['hdd_price'],
              $_SESSION['power_supply_name'],
              $_SESSION['power_supply_price'],
              $_SESSION['cpu_cooler_name'],
              $_SESSION['cpu_cooler_price']
          );

          // Set total price for the prebuilt PC
          $_SESSION['total_price'] = $pc['price'];
          
          // Redirect to cart
          header('Location: cart.php?added=prebuilt');
          exit();
      }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pre-Built Gaming PCs</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        /* Main Container */
        .prebuilt-main {
            background: linear-gradient(135deg, #0a0f1d, #1a237e);
            min-height: 100vh;
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        /* Remove animated grid background */
        .prebuilt-main::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(59, 130, 246, 0.1);
        }

        /* Section Header */
        .section-header {
            text-align: center;
            color: white;
            margin-bottom: 50px;
            position: relative;
            z-index: 1;
        }

        .section-title {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 3px;
        }

        /* PC Grid */
        .prebuilt-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
            padding: 20px;
        }

        /* PC Card */
        .pc-card {
            background: rgba(10, 15, 29, 0.8);
            border-radius: 20px;
            overflow: hidden;
            border: 2px solid rgba(59, 130, 246, 0.3);
            backdrop-filter: blur(10px);
        }

        /* PC Image Container */
        .pc-image {
            position: relative;
            height: 300px;
            overflow: hidden;
            background: rgba(0, 0, 0, 0.2);
        }

        .pc-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Price Tag */
        .price-tag {
            position: absolute;
            top: 20px;
            right: -35px;
            background: #ff4d4d;
            color: white;
            padding: 8px 40px;
            transform: rotate(45deg);
            font-weight: bold;
            z-index: 2;
        }

        /* PC Details */
        .pc-details {
            padding: 25px;
            color: white;
        }

        .pc-title {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: #3b82f6;
            text-transform: uppercase;
        }

        /* Specs List */
        .specs-list {
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }

        .specs-list li {
            margin: 10px 0;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #a3a3a3;
        }

        .specs-list i {
            color: #3b82f6;
            width: 20px;
            text-align: center;
        }

        /* Button */
        .buy-button {
            display: inline-block;
            width: 100%;
            padding: 15px;
            background: #3b82f6;
            color: white;
            text-decoration: none;
            text-align: center;
            border-radius: 8px;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: bold;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .prebuilt-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .prebuilt-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <?php include 'navigation.php'; ?>

    <div class="prebuilt-main">
        <div class="section-header">
            <h1 class="section-title">Pre-Built Gaming PCs</h1>
            <p>Professional Gaming Rigs Ready for Action</p>
        </div>

        <div class="prebuilt-grid">
            <?php
            // Fetch all pre-built PCs from database
            $query = "SELECT * FROM prebuilt_pcs ORDER BY price ASC";
            $result = mysqli_query($database, $query);

            if($result && mysqli_num_rows($result) > 0) {
                while($pc = mysqli_fetch_assoc($result)) {
                    // Check if image exists
                    $image_path = $pc['image_url'];
                    if(!file_exists($image_path)) {
                        $image_path = 'assets/images/default-pc.jpg'; // Fallback image
                    }
                    ?>
                    <div class="pc-card">
                        <div class="pc-image">
                            <img src="<?php echo htmlspecialchars($image_path); ?>" 
                                 alt="<?php echo htmlspecialchars($pc['name']); ?>"
                                 onerror="this.src='assets/images/default-pc.jpg'">
                            <div class="price-tag">₹<?php echo number_format($pc['price']); ?></div>
                        </div>
                        <div class="pc-details">
                            <h3 class="pc-title"><?php echo htmlspecialchars($pc['name']); ?></h3>
                            <ul class="specs-list">
                                <li><i class="fas fa-microchip"></i> <?php echo htmlspecialchars($pc['cpu']); ?></li>
                                <li><i class="fas fa-desktop"></i> <?php echo htmlspecialchars($pc['gpu']); ?></li>
                                <li><i class="fas fa-memory"></i> <?php echo htmlspecialchars($pc['ram']); ?></li>
                                <li><i class="fas fa-hdd"></i> <?php echo htmlspecialchars($pc['storage']); ?></li>
                            </ul>
                            <a href="prebuilt.php?pc=<?php echo $pc['id']; ?>" class="buy-button">Add to Cart</a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<div class="no-results">No pre-built PCs available at the moment.</div>';
            }
            ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        // Remove all animation code
        document.addEventListener('DOMContentLoaded', function() {
            // Keep empty for future functionality if needed
        });
    </script>
</body>
</html> 