<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        <?php include 'styles/navigation.css' ?>
    </style>

    <!-- Add Internal CSS for Animations -->
    <style>
        /* Navigation Link Animations */
        .links a {
            position: relative;
            transition: color 0.3s ease;
            padding: 5px 15px;
            overflow: hidden;
        }

        /* Underline Effect */
        .links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: #3b82f6;
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.3s ease;
        }

        .links a:hover::after {
            transform: scaleX(1);
            transform-origin: left;
        }

        /* Glow Effect on Hover */
        .links a:hover {
            color: #3b82f6;
            text-shadow: 0 0 10px rgba(59, 130, 246, 0.5);
        }

        /* Active Link Style */
        .links a.active {
            color: #3b82f6;
        }

        .links a.active::after {
            transform: scaleX(1);
        }

        /* Bounce Effect on Hover */
        .links a:hover {
            animation: bounce 0.5s ease;
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-3px);
            }
        }

        /* Special Highlight for Build Options */
        .links a[href*="custom_rigs.php"],
        .links a[href*="prebuilt.php"] {
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .links a[href*="custom_rigs.php"]:hover,
        .links a[href*="prebuilt.php"]:hover {
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.2), transparent);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(59, 130, 246, 0.2);
        }

        /* Cart and User Icon Animations */
        .kart a {
            transition: transform 0.3s ease;
        }

        .kart a:hover {
            transform: scale(1.1);
        }

        .kart a:hover img {
            animation: wiggle 0.5s ease;
        }

        @keyframes wiggle {
            0%, 100% { transform: rotate(0); }
            25% { transform: rotate(-10deg); }
            75% { transform: rotate(10deg); }
        }

        /* Hamburger Menu Animation */
        .hamburger-menu {
            transition: transform 0.3s ease;
        }

        .hamburger-menu:hover {
            transform: scale(1.1);
            cursor: pointer;
        }

        /* Logo Animation */
        .logo img {
            transition: transform 0.3s ease;
        }

        .logo:hover img {
            transform: scale(1.05);
            filter: brightness(1.2);
        }

        /* Add these styles to your existing navigation CSS */
        .user-menu {
            position: relative;
            display: inline-block;
        }

        .user-menu-content {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background: rgba(10, 15, 29, 0.95);
            min-width: 200px;
            border-radius: 10px;
            border: 1px solid rgba(59, 130, 246, 0.2);
            backdrop-filter: blur(10px);
            z-index: 1000;
            overflow: hidden;
            transform: translateY(10px);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .user-menu:hover .user-menu-content {
            display: block;
            transform: translateY(0);
            opacity: 1;
        }

        .user-menu-content a {
            color: #a3a3a3;
            padding: 12px 20px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .user-menu-content a:hover {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }

        .user-menu-content .divider {
            height: 1px;
            background: rgba(59, 130, 246, 0.2);
            margin: 5px 0;
        }

        .user-email {
            padding: 12px 20px;
            color: #3b82f6;
            font-size: 0.9rem;
            border-bottom: 1px solid rgba(59, 130, 246, 0.2);
        }

        .logout-btn {
            color: #ef4444 !important;
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.1) !important;
            color: #ef4444 !important;
        }
    </style>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,300;0,500;1,300&display=swap" rel="stylesheet">
</head>
<body>
    
    <header class="header">
          <div class="hamburger-menu" onclick="menu_open()">
            <img src="images/hamb-menu.png" alt="" style="width: 32px" />
          </div>
    
          <div class="logo">
            <a href="home.php"><img src="images/circular_logo.png" alt="" /></a>
          </div>
    
          <navigation class="links" id="navigation_links">
            <a href="custom_rigs.php">CUSTOM RIG</a>
            <a href="prebuilt.php">Pre-Built PCs</a>
            <a href="contact.php">CONTACT</a>
            <a href="about_us.php">ABOUT US</a>
            <a href="cart.php">CART</a>
          </navigation>
    
          <div class="kart">  
            <?php if(isset($_SESSION['customer'])): ?>
                <div class="user-menu">
                    <a class="active">
                        <img src="images/user.png" alt="" style="width: 32px"/>
                    </a>
                    <div class="user-menu-content">
                        <div class="user-email">
                            <i class="fas fa-user"></i> <?php echo $_SESSION['customer']; ?>
                        </div>
                        <a href="myaccount.php">
                            <i class="fas fa-user-circle"></i> My Account
                        </a>
                        <a href="cart.php">
                            <i class="fas fa-shopping-cart"></i> My Cart
                        </a>
                        <div class="divider"></div>
                        <a href="logout.php" class="logout-btn">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <a class="active" href="login.php">
                    <img src="images/user.png" alt="" style="width: 32px"/>
                </a>
            <?php endif; ?>
            
            <a class="active" href="cart.php"
              ><img src="images/cart.png" alt="" style="width: 32px"/>
            </a>
          </div>
    </header>
    
    <script>
        <?php include 'script/navigation.js' ?>
    </script>
</body>
</html>