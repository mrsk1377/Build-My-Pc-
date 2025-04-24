<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .footer {
            background: linear-gradient(180deg, rgba(10, 15, 29, 0.95), #0a0f1d);
            padding: 60px 0 20px;
            position: relative;
            z-index: 1;
            border-top: 2px solid rgba(59, 130, 246, 0.3);
            overflow: hidden;
        }

        /* Remove animated background */
        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(59, 130, 246, 0.05);
            opacity: 0.3;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 40px;
            padding: 0 20px;
            position: relative;
        }

        .footer-section {
            background: rgba(10, 15, 29, 0.5);
            padding: 20px;
            border-radius: 15px;
            border: 1px solid rgba(59, 130, 246, 0.2);
            backdrop-filter: blur(10px);
        }

        .footer-section h3 {
            color: #3b82f6;
            font-size: 1.2rem;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .footer-section h3::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 40px;
            height: 2px;
            background: linear-gradient(90deg, #3b82f6, transparent);
        }

        .footer-section ul {
            list-style: none;
            padding: 0;
        }

        .footer-section ul li {
            margin: 15px 0;
            opacity: 0.8;
        }

        .footer-section ul li a {
            color: #a3a3a3;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .footer-section ul li a:hover {
            color: #3b82f6;
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-links a {
            color: #a3a3a3;
            font-size: 1.5rem;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        .social-links a:hover {
            color: #3b82f6;
            background: rgba(59, 130, 246, 0.2);
        }

        .footer-bottom {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid rgba(59, 130, 246, 0.1);
            position: relative;
        }

        .footer-bottom::before {
            content: '';
            position: absolute;
            top: -1px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 2px;
            background: linear-gradient(90deg, transparent, #3b82f6, transparent);
        }

        .footer-bottom p {
            color: #64748b;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Logo Section */
        .footer-logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .footer-logo img {
            width: 150px;
            height: auto;
        }

        @media (max-width: 768px) {
            .footer {
                padding: 40px 0 20px;
            }

            .footer-content {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .footer-section {
                text-align: center;
            }

            .footer-section h3::after {
                left: 50%;
                transform: translateX(-50%);
            }

            .social-links {
                justify-content: center;
            }

            .footer-section ul li a {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <footer class="footer">
        <div class="footer-logo">
            <a href="home.php">
                <img src="images/circular_logo.png" alt="BuildMyPC Logo">
            </a>
        </div>
        <div class="footer-content">
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="custom_rigs.php">Custom Build</a></li>
                    <li><a href="prebuilt.php">Pre-Built PCs</a></li>
                    <li><a href="about_us.php">About Us</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Support</h3>
                <ul>
                    <li><a href="contact.php">Contact Us</a></li>
                    <li><a href="terms.php">Terms & Conditions</a></li>
                    <li><a href="mailto:buildmypc07@gmail.com">Email Support</a></li>
                    <li><a href="tel:8975555923">Call Support</a></li>
                    <li><a href="admin_login.php"><i class="fas fa-lock"></i> Admin Access</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Connect With Us</h3>
                <p style="color: #a3a3a3; margin-bottom: 15px;">Follow us on social media for updates and offers</p>
                <div class="social-links">
                    <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 BuildMyPC. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>