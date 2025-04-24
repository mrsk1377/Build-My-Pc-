<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms and Conditions - BuildMyPC</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* Main Container */
        .terms-main {
            background: linear-gradient(135deg, #0a0f1d, #1a237e);
            min-height: 100vh;
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        /* Cyber Grid Background */
        .terms-main::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                linear-gradient(90deg, #0a0f1d 10px, transparent 1%) center,
                linear-gradient(#0a0f1d 10px, transparent 1%) center,
                rgba(59, 130, 246, 0.1);
            background-size: 12px 12px;
            animation: gridMove 20s linear infinite;
        }

        @keyframes gridMove {
            0% { background-position: 0 0; }
            100% { background-position: 12px 12px; }
        }

        /* Content Container */
        .terms-container {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
            background: rgba(10, 15, 29, 0.8);
            border-radius: 20px;
            padding: 40px;
            border: 2px solid rgba(59, 130, 246, 0.3);
            backdrop-filter: blur(10px);
            transform: translateY(30px);
            opacity: 0;
            animation: slideUp 0.5s ease forwards;
        }

        @keyframes slideUp {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Headings */
        h1 {
            color: #3b82f6;
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 40px;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 0 0 20px rgba(59, 130, 246, 0.5);
        }

        h2 {
            color: #3b82f6;
            font-size: 1.8rem;
            margin: 30px 0 20px;
            position: relative;
            padding-left: 20px;
        }

        h2::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: #3b82f6;
            border-radius: 2px;
        }

        /* Content Styling */
        .section {
            margin-bottom: 30px;
            padding: 20px;
            border-radius: 10px;
            background: rgba(59, 130, 246, 0.05);
            transition: all 0.3s ease;
        }

        .section:hover {
            background: rgba(59, 130, 246, 0.1);
            transform: translateX(10px);
        }

        p {
            color: #a3a3a3;
            line-height: 1.8;
            margin-bottom: 15px;
        }

        ul {
            list-style: none;
            padding-left: 20px;
        }

        li {
            color: #a3a3a3;
            margin: 10px 0;
            display: flex;
            align-items: center;
        }

        li::before {
            content: '\f054';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            color: #3b82f6;
            margin-right: 10px;
            font-size: 0.8rem;
        }

        /* Last Updated */
        .last-updated {
            text-align: center;
            color: #64748b;
            margin-top: 40px;
            font-style: italic;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .terms-main {
                padding: 20px;
            }

            .terms-container {
                padding: 20px;
            }

            h1 {
                font-size: 2rem;
            }

            h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <?php include 'navigation.php'; ?>

    <div class="terms-main">
        <div class="terms-container">
            <h1>Terms and Conditions</h1>

            <div class="section">
                <h2>1. Acceptance of Terms</h2>
                <p>By accessing and using BuildMyPC's services, you agree to be bound by these terms and conditions. If you do not agree with any part of these terms, please do not use our services.</p>
            </div>

            <div class="section">
                <h2>2. Product Information</h2>
                <p>While we strive to provide accurate product information, specifications, and pricing:</p>
                <ul>
                    <li>Product images are for illustration purposes only</li>
                    <li>Prices are subject to change without notice</li>
                    <li>Product availability is not guaranteed</li>
                    <li>Technical specifications may vary</li>
                </ul>
            </div>

            <div class="section">
                <h2>3. Order & Payment</h2>
                <p>By placing an order, you agree to:</p>
                <ul>
                    <li>Provide accurate and complete information</li>
                    <li>Pay the full amount as specified at checkout</li>
                    <li>Accept our payment processing terms</li>
                    <li>Verify your payment method if requested</li>
                </ul>
            </div>

            <div class="section">
                <h2>4. Warranty & Returns</h2>
                <p>Our warranty and returns policy includes:</p>
                <ul>
                    <li>30-day return policy for unopened products</li>
                    <li>Manufacturer warranty on all components</li>
                    <li>DOA (Dead On Arrival) protection</li>
                    <li>Technical support during warranty period</li>
                </ul>
            </div>

            <div class="section">
                <h2>5. Privacy & Security</h2>
                <p>We are committed to protecting your privacy:</p>
                <ul>
                    <li>Secure payment processing</li>
                    <li>Protection of personal information</li>
                    <li>No sharing of customer data with third parties</li>
                    <li>Regular security updates and monitoring</li>
                </ul>
            </div>

            <div class="section">
                <h2>6. Shipping & Delivery</h2>
                <p>Our shipping terms include:</p>
                <ul>
                    <li>Nationwide delivery service</li>
                    <li>Tracking information provided</li>
                    <li>Insurance on all shipments</li>
                    <li>Multiple shipping options available</li>
                </ul>
            </div>

            <p class="last-updated">Last Updated: December 2023</p>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html> 