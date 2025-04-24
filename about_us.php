<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>About Us</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        /* Main Container */
        .about-main {
            background: linear-gradient(135deg, #0a0f1d, #1a237e);
            min-height: 100vh;
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        /* Remove animated background */
        .about-main::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(59, 130, 246, 0.1);
        }

        /* Content Container */
        .about-container {
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            padding: 20px;
        }

        /* Section Styling */
        .about-section {
            background: rgba(10, 15, 29, 0.8);
            border-radius: 20px;
            padding: 30px;
            color: white;
            border: 2px solid rgba(59, 130, 246, 0.3);
            backdrop-filter: blur(10px);
        }

        .mission-section {
            animation-delay: 0.2s;
        }

        /* Headings */
        h1, h2 {
            color: #3b82f6;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
            margin-bottom: 30px;
        }

        h1 {
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 50px;
            text-shadow: 0 0 20px rgba(59, 130, 246, 0.5);
        }

        h2 {
            font-size: 1.8rem;
        }

        h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 60px;
            height: 3px;
            background: #3b82f6;
            transition: width 0.3s ease;
        }

        .about-section:hover h2::after {
            width: 100px;
        }

        /* Text Content */
        p {
            line-height: 1.8;
            color: #a3a3a3;
            margin-bottom: 20px;
        }

        /* Feature List */
        .feature-list {
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }

        .feature-list li {
            margin: 15px 0;
            display: flex;
            align-items: center;
            gap: 15px;
            transform: translateX(-20px);
            opacity: 0;
            animation: slideIn 0.5s ease forwards;
        }

        .feature-list li i {
            color: #3b82f6;
            font-size: 1.2rem;
            width: 24px;
        }

        @keyframes slideIn {
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Stats Section */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 30px;
        }

        .stat-card {
            background: rgba(59, 130, 246, 0.1);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            border: 1px solid rgba(59, 130, 246, 0.2);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 2rem;
            color: #3b82f6;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .stat-label {
            color: #a3a3a3;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .about-container {
                grid-template-columns: 1fr;
            }

            .about-main {
                padding: 20px;
            }

            h1 {
                font-size: 2rem;
            }
        }
    </style>
  </head>
  <body>
    <!-- header -->
    <?php include 'navigation.php'?>

    <!-- main content -->
    <div class="about-main">
        <h1>About BuildMyPC</h1>
        
        <div class="about-container">
            <div class="about-section">
                <h2>Who We Are</h2>
                <p>BuildMyPC is a premier destination for PC enthusiasts and professionals seeking top-quality custom builds and pre-built systems. Founded in 2025, we've quickly established ourselves as a trusted name in the custom PC building industry.</p>
                
                <h2>What We Offer</h2>
                <ul class="feature-list">
                    <li style="animation-delay: 0.1s"><i class="fas fa-tools"></i> Custom PC Building Services</li>
                    <li style="animation-delay: 0.2s"><i class="fas fa-desktop"></i> Pre-built Gaming Systems</li>
                    <li style="animation-delay: 0.3s"><i class="fas fa-headset"></i> Expert Technical Support</li>
                    <li style="animation-delay: 0.4s"><i class="fas fa-truck"></i> Nationwide Delivery</li>
                    <li style="animation-delay: 0.5s"><i class="fas fa-wrench"></i> After-sales Service</li>
                </ul>

                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Custom Builds Delivered</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">98%</div>
                        <div class="stat-label">Customer Satisfaction</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Technical Support</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">2+</div>
                        <div class="stat-label">Years Experience</div>
                    </div>
                </div>
            </div>

            <div class="about-section mission-section">
                <h2>Our Mission</h2>
                <p>At BuildMyPC, our mission is to make high-quality custom PC building accessible to everyone. We believe in providing transparent pricing, expert guidance, and exceptional customer service throughout your PC building journey.</p>

                <h2>Why Choose Us</h2>
                <ul class="feature-list">
                    <li style="animation-delay: 0.6s"><i class="fas fa-check-circle"></i> Quality Assured Components</li>
                    <li style="animation-delay: 0.7s"><i class="fas fa-bolt"></i> Performance Optimization</li>
                    <li style="animation-delay: 0.8s"><i class="fas fa-shield-alt"></i> Extended Warranty Options</li>
                    <li style="animation-delay: 0.9s"><i class="fas fa-hand-holding-usd"></i> Competitive Pricing</li>
                    <li style="animation-delay: 1s"><i class="fas fa-users"></i> Expert Team</li>
                </ul>

                <h2>Our Commitment</h2>
                <p>We are committed to providing:</p>
                <ul class="feature-list">
                    <li style="animation-delay: 1.1s"><i class="fas fa-star"></i> Premium Quality Components</li>
                    <li style="animation-delay: 1.2s"><i class="fas fa-clock"></i> Quick Turnaround Time</li>
                    <li style="animation-delay: 1.3s"><i class="fas fa-heart"></i> Dedicated Customer Support</li>
                    <li style="animation-delay: 1.4s"><i class="fas fa-sync"></i> Regular Updates & Maintenance</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- footer -->
    <?php include 'footer.php' ?>
  </body>
</html>
