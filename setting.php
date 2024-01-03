<?php
session_start();
include './includes/header.php';

// Include your database configuration
include_once './config/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch subscription information
$query = "SELECT subscription_type, subscription_date FROM toll_subscribe WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result) {
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $subscriptionType = $row['subscription_type'];
        $subscriptionDate = $row['subscription_date'];

        // Map subscription type to plan name
        $planName = "";
        switch ($subscriptionType) {
            case 1:
                $planName = "Basic Plan";
                break;
            case 2:
                $planName = "Regular Plan";
                break;
            case 3:
                $planName = "Premium Plan";
                break;
            default:
                $planName = "Unknown Plan";
        }

        // Calculate expiration date with a 30-day interval
        $expirationDate = date('Y-m-d', strtotime($subscriptionDate . ' + 30 days'));
    }
}
?>

<body class="app">
    <?php include_once './includes/components/appHeader.php' ?>

    <div class="app-wrapper">
        <div class="app-content pt-3 p-md-3 p-lg-4">
            <div class="container-xl">
                <h1 class="app-page-title">Settings</h1>
                <hr class="mb-4">
                <div class="row g-4 settings-section">
                    <div class="col-12 col-md-4">
                        <h3 class="section-title">Plan</h3>
                        <div class="section-intro">Settings section intro goes here. Lorem ipsum dolor sit amet, consectetur adipiscing elit. <a href="help.html">Learn more</a></div>
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="app-card app-card-settings shadow-sm p-4">

                            <div class="app-card-body">
                                <?php if (isset($subscriptionType) && isset($subscriptionDate)) : ?>
                                    <div class="mb-2"><strong>Current Plan:</strong> <?php echo $planName; ?></div>
                                    <div class="mb-2"><strong>Status:</strong> <span class="badge bg-success">Active</span></div>
                                    <div class="mb-2"><strong>Expires:</strong> <?php echo $expirationDate; ?></div>
                                    <div class="mb-4"><strong>Invoices:</strong> <a href="#">view</a></div>
                                    <div class="row justify-content-between">
                                        <div class="col-auto">
                                            <a class="btn app-btn-primary" href="#">Upgrade Plan</a>
                                        </div>
                                        <div class="col-auto">
                                            <a class="btn app-btn-secondary" href="#">Cancel Plan</a>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <p>No active subscription found.</p>
                                <?php endif; ?>
                            </div><!--//app-card-body-->

                        </div><!--//app-card-->
                    </div>
                </div><!--//row-->
                <hr class="my-4">
            </div><!--//container-fluid-->
        </div><!--//app-content-->

        <?php include './includes/footer.php' ?>
