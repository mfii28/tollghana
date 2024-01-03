<?php
session_start();
include __DIR__ . '/../includes/header.php';
include_once __DIR__ . '/../config/config.php';

if (isset($_SESSION['user_id'], $_SESSION['email'])) {
    $user_id = $_SESSION['user_id'];
    $email = $_SESSION['email'];

    // Check if the user is an admin based on the admin_user table
    $adminCheckQuery = "SELECT * FROM admin_user WHERE email = ?";
    $stmt = $conn->prepare($adminCheckQuery);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $adminCheckResult = $stmt->get_result();

    if ($adminCheckResult->num_rows == 1) {
        // Allow access to the admin section
        include 'admin/index.php';
        exit();
    } else {
        header("Location: ./../dashboard.php");
        exit();
    }
}

// For regular users, continue with your login logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Implement secure login logic, such as input validation

    // Check user credentials in the users table
    $userLoginQuery = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($userLoginQuery);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            // Password is correct, start a session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email']; // Set the email in the session
            header('Location: ./../dashboard.php'); // Redirect to dashboard after login
            exit();
        } else {
            $error = 'Invalid password';
        }
    } else {
        $error = 'User not found';
    }
}
?>


<!-- Continue with the rest of your HTML and code -->


<!DOCTYPE html>
<html lang="en"> 
<head>
    <title></title>
    
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
<div id="preloader">
    <div id="loader"></div>
</div>
 <body class="app app-login p-0">
<div class="row g-0 app-auth-wrapper">
    <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
        <div class="d-flex flex-column align-content-end">
            <div class="app-auth-body mx-auto">
                <div class="app-auth-branding mb-4">
                    <a class="app-logo" href="index.html">
                        <img class="logo-icon me-2" src="../logo.png" alt="logo">
                   
                    </a>
                </div>
                <h2 class="auth-heading text-center mb-5">Log in to Portal</h2>
                <div class="auth-form-container text-start">
                <form method="post" action="" class="auth-form login-form" >         
							<div class="email mb-3">
                            <label class="sr-only" for="signin-email">Email</label>
        <input id="signin-email" name="email" type="email" class="form-control signin-email" placeholder="Email address" required="required">
    </div><!--//form-group-->
							<div class="password mb-3">
                            <label class="sr-only" for="signin-password">Password</label>
        <input id="signin-password" name="password" type="password" class="form-control signin-password" placeholder="Password" required="required">
        <div class="extra mt-3 row justify-content-between">
									<div class="col-6">
										<div class="form-check">
											<input class="form-check-input" type="checkbox" value="" id="RememberPassword">
											<label class="form-check-label" for="RememberPassword">
											Remember me
											</label>
										</div>
							</div><!--//col-6-->
									<div class="col-6">
										<div class="forgot-password text-end">
											<a href="reset-password.html">Forgot password?</a>
										</div>
									</div><!--//col-6-->
								</div><!--//extra-->
							</div><!--//form-group-->
							<div class="text-center">
								<button type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto">Log In</button>
							</div>
						</form>

                    <div class="auth-option text-center pt-5">
                        No Account? Sign up <a class="text-link" href="register.php">here</a>.
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
 

  document.addEventListener("DOMContentLoaded", function () {
    // Simulate delay (you can replace this with the actual time-consuming operations)
    setTimeout(function () {
        // Hide the preloader
        document.getElementById("preloader").style.display = "none";
        
        // Show the content
        document.querySelector(".content").style.display = "block";
    }, 2000); // Replace 2000 with the actual time it takes to load your content
});

</script>
</body>
</html>
 
