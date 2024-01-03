<?php
session_start();
include '../includes/header.php';
include '../config/config.php';
include '../phpqrcode/qrlib.php';

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: ./../dashboard.php'); // Redirect to dashboard
    exit();
}

$error = ''; // Initialize the error variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Generate a random username
    $username = 'user' . rand(1000000, 99999999);

    // Check if the email already exists using a prepared statement
    $emailCheckQuery = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($emailCheckQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $emailCheckResult = $stmt->get_result();

    if ($emailCheckResult->num_rows > 0) {
        // Email already exists, display an error message
        $error = "Email already taken. Please choose another email.";
    } else {
        // Email is unique, proceed with registration
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Generate reset token
        $resetToken = bin2hex(random_bytes(32));
        $resetTokenExpiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Generate QR code data with user ID and profile page URL
        $profilePageUrl = "http://localhost/tollGate/profile_page.php";
        $qrcodeData = $profilePageUrl . "?user_id="; // Initialize with the base URL

        $insertQuery = "INSERT INTO users (username, email, password, full_name, reset_token, reset_token_expiry) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ssssss", $username, $email, $hashedPassword, $full_name, $resetToken, $resetTokenExpiry);

        if ($stmt->execute()) {
            $user_id = $stmt->insert_id;

            // Update the QR code data with the user ID
            $qrcodeData .= $user_id;

            // Create and save the QR code image
            $qrcodePath = "../user_qrcodes/user_" . $user_id . ".png"; // Adjust the path based on your directory structure

            // Create and save the QR code image
            QRcode::png($qrcodeData, $qrcodePath);

            // Insert a record into the qrcodes table
            $qrcodeInsertQuery = "INSERT INTO qrcodes (user_id, qr_code_data, qr_code_image_path) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($qrcodeInsertQuery);
            $stmt->bind_param("iss", $user_id, $qrcodeData, $qrcodePath);
            $stmt->execute();

            // Redirect after successful registration
            $_SESSION['success_message'] = "Registration successful! You can now login.";
            header('Location: login.php');
            exit();
        } else {
            $error = "Error: " . $stmt->error;
        }
    }
}
?>



<!-- Your HTML content goes here -->

<!DOCTYPE html>
<html lang="en"> 
<head>
    <title>Tollpass</title>
    
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <meta name="description" content="Tollpass">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">    
    <link rel="shortcut icon" href="favicon.ico"> 
    
    <!-- FontAwesome JS-->
    <script defer src="../../vendor/JS/plugins/fontawesome/js/all.min.js"></script>
    
    <!-- App CSS -->  
    <link id="theme-style" rel="stylesheet" href="../vendor/tailwindcss.css">
    <link rel="stylesheet" href="../vendor/bootstrap.css">
    <style>
    /* ============= Theme Mixins ============= */
 .app-login .auth-background-holder {
	 background: url("https://cdn.pixabay.com/photo/2017/06/17/20/46/under-construction-2413499_640.jpg") no-repeat center center;
	 -webkit-background-size: cover;
	 -moz-background-size: cover;
	 -o-background-size: cover;
	 background-size: cover;
	 height: 100vh;
	 min-height: 100%;
}
 .app-signup .auth-background-holder {
	 background: url("../images/background/background-2.jpg") no-repeat center center;
	 -webkit-background-size: cover;
	 -moz-background-size: cover;
	 -o-background-size: cover;
	 background-size: cover;
	 height: 100vh;
	 min-height: 100%;



}

#preloader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

#loader {
    border: 8px solid #f3f3f3;
    border-top: 8px solid #3498db;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.content {
    display: none; /* Hide content initially */
}
 
</style>

</head> 

<!-- Preloader -->
 

<body class="app app-login p-0">
<div class="row g-0 app-auth-wrapper">
    <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
        <div class="d-flex flex-column align-content-end">
            <div class="app-auth-body mx-auto">
                <div class="app-auth-branding mb-4">
                    <a class="app-logo" href="index.html"><img class="logo-icon me-2" src="../logo.png" alt="logo"></a>
                </div>
                <h2 class="auth-heading text-center mb-5">Register to Portal</h2>
                <div class="auth-form-container text-start">
                <form class="auth-form register-form" method="post" action="register.php">
    <!-- Your registration form fields -->
    <div class="full-name mb-3">
            <label class="sr-only" for="full-name">Full Name</label>
            <input id="full-name" name="full_name" type="text" class="form-control full-name" placeholder="Full Name" required="required">
        </div>
<div class="email mb-3">
    <label class="sr-only" for="signup-email">Email</label>
    
    <input id="signup-email" name="email" type="email" class="form-control signup-email" placeholder="Email address" required="required">
</div>
<div class="password mb-3">
    <label class="sr-only" for="signup-password">Password</label>
    <input id="signup-password" name="password" type="password" class="form-control signup-password" placeholder="Password" required="required">
</div>

    <!-- Add other registration fields as needed -->
    <div class="text-center">
        <button type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto">Sign Up</button>
    </div>
</form>

                    <div class="auth-option text-center pt-5">
                      I've an Account? Sign in <a class="text-link" href="login.php">here</a>.
                    </div>
                </div><!--//auth-form-container-->
            </div><!--//auth-body-->

            <footer class="app-auth-footer">
                <div class="container text-center py-3">
                    <!-- Your footer content -->
                </div>
            </footer><!--//app-auth-footer-->
        </div><!--//flex-column-->
    </div><!--//auth-main-col-->

    <div class="col-12 col-md-5 col-lg-6 h-100 auth-background-col">
        <div class="auth-background-holder"></div>
        <div class="auth-background-mask"></div>
        <div class="auth-background-overlay p-3 p-lg-5">
            <div class="d-flex flex-column align-content-end h-100">
                <div class="h-100"></div>
              
            </div>
        </div><!--//auth-background-overlay-->
    </div><!--//auth-background-col-->
</div><!--//row-->


<script> 
        // You can customize the alert message based on your requirements
        <?php
            if (!empty($error)) {
                echo 'alert("'.$error.'");';
            }
        ?>
    </script>