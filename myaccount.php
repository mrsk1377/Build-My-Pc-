<?php
    if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<?php //check if already logged in
        if(!isset($_SESSION['customer']) || empty($_SESSION['customer']) )
        {
            header('location:login.php');
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        .account {
            background: linear-gradient(135deg, #0a0f1d, #1a237e);
            min-height: 100vh;
            padding: 40px 20px;
            position: relative;
            overflow: hidden;
        }

        /* Cyber Grid Background */
        .account::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                linear-gradient(90deg, rgba(59, 130, 246, 0.05) 1px, transparent 1px),
                linear-gradient(rgba(59, 130, 246, 0.05) 1px, transparent 1px);
            background-size: 20px 20px;
            animation: gridMove 20s linear infinite;
            opacity: 0.3;
        }

        @keyframes gridMove {
            0% { transform: translateY(0); }
            100% { transform: translateY(20px); }
        }

        .account h1 {
            color: #3b82f6;
            text-align: center;
            font-size: 2rem;
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
        }

        .address-details {
            max-width: 800px;
            margin: 0 auto;
            background: rgba(10, 15, 29, 0.8);
            padding: 40px;
            border-radius: 20px;
            border: 2px solid rgba(59, 130, 246, 0.3);
            backdrop-filter: blur(10px);
            position: relative;
            z-index: 1;
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

        .flex-outer {
            list-style: none;
            padding: 0;
            max-width: 600px;
            margin: 0 auto;
        }

        .flex-outer li {
            margin-bottom: 20px;
            opacity: 0;
            transform: translateX(-20px);
            animation: slideIn 0.5s ease forwards;
        }

        @keyframes slideIn {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .flex-outer li label {
            display: block;
            color: #3b82f6;
            margin-bottom: 10px;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .flex-outer li input,
        .flex-outer li textarea {
            width: 100%;
            padding: 12px;
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.2);
            border-radius: 8px;
            color: white;
            transition: all 0.3s ease;
        }

        .flex-outer li input:focus,
        .flex-outer li textarea:focus {
            border-color: #3b82f6;
            outline: none;
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.2);
            transform: translateY(-2px);
        }

        .flex-outer li:last-child {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 30px;
            gap: 20px;
        }

        #submit_button {
            padding: 12px 30px;
            background: transparent;
            border: 2px solid #3b82f6;
            color: #3b82f6;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }

        #submit_button:hover {
            background: #3b82f6;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(59, 130, 246, 0.3);
        }

        .success-message {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.2);
            color: #22c55e;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Apply animation delay to form fields */
        .flex-outer li:nth-child(1) { animation-delay: 0.1s; }
        .flex-outer li:nth-child(2) { animation-delay: 0.2s; }
        .flex-outer li:nth-child(3) { animation-delay: 0.3s; }
        .flex-outer li:nth-child(4) { animation-delay: 0.4s; }
        .flex-outer li:nth-child(5) { animation-delay: 0.5s; }
        .flex-outer li:nth-child(6) { animation-delay: 0.6s; }
        .flex-outer li:nth-child(7) { animation-delay: 0.7s; }
        .flex-outer li:nth-child(8) { animation-delay: 0.8s; }
        .flex-outer li:nth-child(9) { animation-delay: 0.9s; }

        /* Responsive Design */
        @media (max-width: 768px) {
            .address-details {
                padding: 20px;
            }

            .flex-outer li:last-child {
                flex-direction: column;
            }

            #submit_button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <?php 
    include 'navigation.php';
    include 'connect_database.php';//$database  
     
    ;?>
    <section class="account">
        <?php if(isset($_SESSION['update'])): ?>
            <h1 class="success-message">
                <i class="fas fa-check-circle"></i>
                <?php echo $_SESSION['update']; ?>
            </h1>
        <?php endif; ?>
        <div class="address-details">
            <h1><i class="fas fa-user-circle"></i> Account Details</h1>
            <form method='post' action="register_user.php">
                <ul class="flex-outer">
                    <li>
                        <label for="first-name"><i class="fas fa-user"></i> First Name</label>
                        <input type="text" id="first-name" name='first_name' placeholder="Enter your first name here">
                    </li>
                    <li>
                        <label for="last-name"><i class="fas fa-user"></i> Last Name</label>
                        <input type="text" id="last-name" name='last_name' placeholder="Enter your last name here">
                    </li>
                    
                    <li>
                        <label for="phone"><i class="fas fa-phone"></i> Contact Number</label>
                        <input type="text" id="phone" name='contact_number' placeholder="Enter your phone number here">
                    </li>
                    <li>
                        <label for="address"><i class="fas fa-home"></i> Address</label>
                        <textarea rows="6" id="address" name='address' placeholder="Enter your address here"></textarea>
                    </li>
                    <li>
                        
                        <label for="city"><i class="fas fa-city"></i> City</label>
                        <input type="text" id="city" name='city' placeholder="Enter your City">
                    </li>
                    <li>
                        <label for="state"><i class="fas fa-map-marker-alt"></i> State</label>
                        <input type="text" id="state" name='state' placeholder="Enter your State">
                    </li>
                    <li>
                        
                        <label for="country"><i class="fas fa-globe"></i> Country</label>
                        <input type="text" id="country" name='country' placeholder="Enter your country"></li>
                        <li>
                        <label for="zip-code"><i class="fas fa-map-pin"></i> Zip code</label>
                        <input type="text" id="zip-code" name='zip-code' placeholder="Enter your Zip Code">    
                            
                        </li>
                    
                    
                    <li>
                        <button type="submit" id='submit_button' name='submit'>
                            <i class="fas fa-save"></i> Update Details
                        </button>
                    </li>
                </ul>
            </form>
        </div>
    </section>

    <?php include 'footer.php';?>
</body>
</html>