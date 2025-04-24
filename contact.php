<?php
session_start();
include 'connect_database.php';

if(isset($_POST['submit_feedback'])) {
    // Sanitize inputs
    $name = mysqli_real_escape_string($database, $_POST['first_name']);
    $phone = mysqli_real_escape_string($database, $_POST['phone']);
    $email = mysqli_real_escape_string($database, $_POST['email']);
    $message = mysqli_real_escape_string($database, $_POST['message']);
    
    // Validate inputs
    if(empty($name) || empty($phone) || empty($email) || empty($message)) {
        echo "<script>alert('Please fill all the fields!');</script>";
    } else {
        // Insert into database
        $sql = "INSERT INTO feedback (name, phone, email, message) VALUES (?, ?, ?, ?)";
        $stmt = $database->prepare($sql);
        $stmt->bind_param("ssss", $name, $phone, $email, $message);
        
        if($stmt->execute()) {
            echo "<script>
                alert('Thank you! Your feedback has been submitted successfully.');
                document.getElementById('feedbackForm').reset();
            </script>";
        } else {
            echo "<script>alert('Error submitting feedback. Please try again.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact us</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        /* Main Container */
        .contact-main {
            background: linear-gradient(135deg, #0a0f1d, #1a237e);
            min-height: 100vh;
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        /* Remove animated background */
        .contact-main::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(59, 130, 246, 0.1);
        }

        /* Flex Container */
        .flex-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
            padding: 20px;
        }

        /* Contact Info Section */
        .contact {
            background: rgba(10, 15, 29, 0.8);
            border-radius: 20px;
            padding: 30px;
            color: white;
            border: 2px solid rgba(59, 130, 246, 0.3);
            backdrop-filter: blur(10px);
        }

        /* Form Section */
        .form {
            background: rgba(10, 15, 29, 0.8);
            border-radius: 20px;
            padding: 30px;
            color: white;
            border: 2px solid rgba(59, 130, 246, 0.3);
            backdrop-filter: blur(10px);
        }

        /* Headings */
        h2 {
            font-size: 2rem;
            color: #3b82f6;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
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

        .contact:hover h2::after,
        .form:hover h2::after {
            width: 100px;
        }

        /* Links */
        a {
            color: #3b82f6;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #60a5fa;
            text-shadow: 0 0 10px rgba(59, 130, 246, 0.5);
        }

        /* Form Elements */
        label {
            display: block;
            margin-bottom: 8px;
            color: #3b82f6;
            font-weight: bold;
            letter-spacing: 1px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(59, 130, 246, 0.3);
            border-radius: 8px;
            color: white;
            transition: all 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.3);
            transform: translateY(-2px);
        }

        /* Button */
        button {
            width: 100%;
            padding: 15px;
            background: transparent;
            color: #3b82f6;
            border: 2px solid #3b82f6;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: #3b82f6;
            transition: transform 0.3s ease;
            z-index: -1;
        }

        button:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(59, 130, 246, 0.3);
        }

        button:hover::before {
            transform: translateX(100%);
        }

        /* Bank Details */
        .bank-details {
            margin-top: 30px;
            padding: 20px;
            background: rgba(59, 130, 246, 0.1);
            border-radius: 10px;
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        /* About Section */
        .about-text {
            margin: 30px 0;
            line-height: 1.6;
            color: #a3a3a3;
            text-align: justify;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .flex-container {
                grid-template-columns: 1fr;
            }

            .contact-main {
                padding: 20px;
            }
        }

        /* Icon Styling */
        .contact-info i {
            color: #3b82f6;
            width: 24px;
            margin-right: 10px;
        }

        .contact-info p {
            margin: 15px 0;
            display: flex;
            align-items: center;
        }

        textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(59, 130, 246, 0.3);
            border-radius: 8px;
            color: white;
            resize: vertical;
            min-height: 100px;
            font-family: inherit;
        }

        textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.3);
        }
    </style>
  </head>
  <body>
    <?php include 'navigation.php'; ?>

    <div class="contact-main">
        <div class="flex-container">
            <div class="contact">
                <h2>Contact Us</h2>
                <div class="contact-info">
                    <p><i class="fas fa-map-marker-alt"></i> 415124 Karad Maharashtra /Vidyanagar SGM Collage Karad, India</p>
                    <p><i class="fas fa-envelope"></i> Email: <a href="mailto:buildmypc07@gmail.com">buildmypc07@gmail.com</a></p>
                    <p><i class="fas fa-clock"></i> Office Timings: 10AM - 6PM, MON-SAT</p>
                    <p><i class="fas fa-phone"></i> Phone: 8975555923/8080654310</p>
                    
                    <div class="bank-details">
                        <h3>Bank Details</h3>
                        <p><i class="fas fa-university"></i> State Bank Of India</p>
                        <p><i class="fas fa-credit-card"></i> ACC NO: 64127857839</p>
                        <p><i class="fas fa-user"></i> ACC NAME: build my pc PVL</p>
                        <p><i class="fas fa-file-invoice"></i> Type: CURRENT</p>
                        <p><i class="fas fa-code"></i> IFSC: SBIN0001372</p>
                        <p><i class="fas fa-building"></i> Branch: 
                            <br>1. Pune Katraj
                            <br>2. Karad Vidyanagar
                        </p>
                    </div>
                </div>
            </div>

            <div class="form">
                <h2>Feedback</h2>
                <form method="POST" id="feedbackForm">
                    <label for="first_name">Name</label>
                    <input type="text" placeholder="Enter your name" name="first_name" id="first_name" required />

                    <label for="phone">Phone Number</label>
                    <input type="tel" placeholder="Enter phone number" name="phone" id="phone" required />

                    <label for="email">Email</label>
                    <input type="email" placeholder="Enter Email" name="email" id="email" required />

                    <label for="message">Your Feedback</label>
                    <textarea name="message" id="message" placeholder="Write your feedback here..." required rows="4"></textarea>

                    <button type="submit" name="submit_feedback">Submit Feedback</button>
                </form>

                <p class="about-text">
                    BuildMyPC is a dedicated platform for custom PC builds, pre-built computers, and computer accessories, catering to enthusiasts and professionals alike. Whether users are looking to build a high-performance gaming rig, a workstation for productivity, or an affordable everyday PC, BuildMyPC provides a seamless experience.
                </p>
            </div>
        </div>
    </div>

    <?php include 'footer.php' ?>

    <script>
        document.getElementById('feedbackForm').addEventListener('submit', function(e) {
            // Remove the preventDefault to allow form submission
            const button = this.querySelector('button');
            button.innerHTML = 'Submitting...';
            
            // Form will submit normally due to method="POST"
            setTimeout(() => {
                button.innerHTML = 'Submit Feedback';
            }, 2000);
        });
    </script>
  </body>
</html>
