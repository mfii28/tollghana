<?php
session_start();
include './includes/header.php';
include_once './config/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT vehicle_type FROM vehicles WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    $vehicleType = "Private car";
    echo "Error fetching vehicle type: " . mysqli_error($conn);
} else {
    $row = mysqli_fetch_assoc($result);

    if ($row && isset($row['vehicle_type'])) {
        $vehicleType = $row['vehicle_type'];
    } else {
        $vehicleType = "Private car";
        echo "Error: Vehicle type not found in the database.";
    }
}

if ($vehicleType == "Private car") {
    $basePrice = 2.00;
} elseif ($vehicleType == "4x4 Vehicles (4Wd)") {
    $basePrice = 3.00;
} elseif ($vehicleType == "motorbike" || $vehicleType == "Tricyles") {
    $basePrice = 1.00;
} elseif ($vehicleType == "Heavy Goods Vehicles") {
    $basePrice = 30.00;
} elseif ($vehicleType == "Mini Buses") {
    $basePrice = 5.00;
} else {
    $basePrice = 0.00;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["purchase_now"])) {
    $planType = $_POST["plan_type"];
    $planPrice = calculatePlanPrice($basePrice, $planType);

    // Fetch the total amount from the deposits table
    $queryTotalAmount = "SELECT SUM(amount) AS total_amount FROM deposits WHERE user_id = ?";
    $stmtTotalAmount = mysqli_prepare($conn, $queryTotalAmount);
    mysqli_stmt_bind_param($stmtTotalAmount, "i", $user_id);
    mysqli_stmt_execute($stmtTotalAmount);
    $resultTotalAmount = mysqli_stmt_get_result($stmtTotalAmount);

    if ($resultTotalAmount) {
        $rowTotalAmount = mysqli_fetch_assoc($resultTotalAmount);

        if ($rowTotalAmount && isset($rowTotalAmount['total_amount'])) {
            $totalAmount = $rowTotalAmount['total_amount'];

            if ($totalAmount >= $planPrice) {
                // Subtract the planPrice from the total amount in deposits
                $newTotalAmount = $totalAmount - $planPrice;

                // Update the deposits table with the new total amount
                $updateTotalAmountQuery = "UPDATE deposits SET amount = ? WHERE user_id = ?";
                $stmtUpdateTotalAmount = mysqli_prepare($conn, $updateTotalAmountQuery);
                mysqli_stmt_bind_param($stmtUpdateTotalAmount, "di", $newTotalAmount, $user_id);
                mysqli_stmt_execute($stmtUpdateTotalAmount);

                // Insert the subtracted amount into the earning table
                $insertEarningQuery = "INSERT INTO earning (user_id, amount, earnings_date) VALUES (?, ?, NOW())";
                $stmtInsertEarning = mysqli_prepare($conn, $insertEarningQuery);
                mysqli_stmt_bind_param($stmtInsertEarning, "id", $user_id, $planPrice);
                mysqli_stmt_execute($stmtInsertEarning);

                if (isEligibleForSubscription($conn, $user_id)) {
                    $insertQuery = "INSERT INTO toll_subscribe (user_id, subscription_type, subscription_date) VALUES (?, ?, NOW())";
                    $stmt = mysqli_prepare($conn, $insertQuery);
                    mysqli_stmt_bind_param($stmt, "ii", $user_id, getSubscriptionType($planType));
                    mysqli_stmt_execute($stmt);

                    echo '<script>alert("Purchase successful!");</script>';

                    // Redirect to prevent resubmission
                    header("Location: {$_SERVER['PHP_SELF']}");
                    exit();
                } else {
                    echo '<script>alert("User already has an active subscription. Wait until it expires after 30 days.");</script>';
                }
            } else {
                echo '<script>alert("Insufficient balance. Please top up your account.");</script>';
            }
        } else {
            echo '<script>alert("Error fetching total amount.");</script>';
        }
    } else {
        echo '<script>alert("Error fetching total amount: ' . mysqli_error($conn) . '");</script>';
    }
}


function isEligibleForSubscription($conn, $user_id) {
    $lastSubscriptionDate = getLastSubscriptionDate($conn, $user_id);

    if ($lastSubscriptionDate === null) {
        return true;
    }

    $currentDate = date('Y-m-d');
    $lastSubscriptionTimestamp = strtotime($lastSubscriptionDate);
    $currentTimestamp = strtotime($currentDate);

    $daysDifference = floor(($currentTimestamp - $lastSubscriptionTimestamp) / (60 * 60 * 24));

    return $daysDifference >= 30;
}

function getLastSubscriptionDate($conn, $user_id) {
    $query = "SELECT MAX(subscription_date) AS last_subscription_date FROM toll_subscribe WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if (!$stmt) {
        echo "Error preparing statement: " . mysqli_error($conn);
        return null;
    }

    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        echo "Error fetching result: " . mysqli_error($conn);
        return null;
    }

    $row = mysqli_fetch_assoc($result);
    return $row['last_subscription_date'];
}

function getSubscriptionType($planType) {
    if ($planType == "basic") {
        return 1;
    } elseif ($planType == "regular") {
        return 2;
    } elseif ($planType == "premium") {
        return 3;
    }
}

function calculatePlanPrice($basePrice, $planType) {
    $adjustment = 0;

    if ($planType == "basic") {
        $adjustment = 30;
    } elseif ($planType == "regular") {
        $adjustment = 50;
    } elseif ($planType == "premium") {
        $adjustment = 80;
    }

    $planPrice = $basePrice * $adjustment;

    return $planPrice;
}
?>


 
<style>
    body{margin-top:20px;}
.pricing-box {
  -webkit-box-shadow: 0px 5px 30px -10px rgba(0, 0, 0, 0.1);
          box-shadow: 0px 5px 30px -10px rgba(0, 0, 0, 0.1);
  padding: 35px 50px;
  border-radius: 20px;
  position: relative;
}

.pricing-box .plan {
  font-size: 34px;
}

.pricing-badge {
  position: absolute;
  top: 0;
  z-index: 999;
  right: 0;
  width: 100%;
  display: block;
  font-size: 15px;
  padding: 0;
  overflow: hidden;
  height: 100px;
}

.pricing-badge .badge {
  float: right;
  -webkit-transform: rotate(45deg);
          transform: rotate(45deg);
  right: -67px;
  top: 17px;
  position: relative;
  text-align: center;
  width: 200px;
  font-size: 13px;
  margin: 0;
  padding: 7px 10px;
  font-weight: 500;
  color: #ffffff;
  background: #fb7179;
}
.mb-2, .my-2 {
    margin-bottom: .5rem!important;
}
p {
    line-height: 1.7;
}
</style>

<?php
     include_once './includes/components/appHeader.php'
?>   
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.css" integrity="sha256-NAxhqDvtY0l4xn+YVa6WjAcmd94NNfttjNsDmNatFVc=" crossorigin="anonymous" />
<div class="app-wrapper">
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <section class="section" id="pricing">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="title-box text-center">
                                <h3 class="title-heading mt-2">Best Pricing Package </h3>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1 pt-2">
               <!-- Basic Plan -->
   
 
    <!-- Basic Plan -->
<div class="col-lg-4">
    <div class="pricing-box mt-4">
        <i class="mdi mdi-account h1"></i>
        <h4 class="f-20">Basic Plan</h4>
        <div class="mt-4 pt-2">
            <p class="mb-2 f-18">Features</p>
            <p class="mb-2">
                <i class="mdi mdi-checkbox-marked-circle text-success f-18 mr-2"></i><b>40</b>
                Booth Access
            </p>
        </div>
        <p class="mt-4 pt-2 text-muted">Ideal for individuals or businesses with moderate toll booth usage.</p>
        <div class="pricing-plan mt-4 pt-2">
            <h4 class="text-muted"> <?php echo 'GH' . number_format($basePrice * 30, 2); ?>  </h4>
            <p class="text-muted mb-0">Per Month</p>
        </div>
        <div class="mt-4 pt-3">
            <!-- Add this line for the submit button -->
            <form method="post" action="">
                <input type="hidden" name="plan_type" value="basic">
                <button type="submit" class="btn btn-primary btn-rounded" name="purchase_now">Purchase Now</button>
            </form>
        </div>
    </div>
</div>
 

    <!-- Regular Plan -->
    <div class="col-lg-4" id="regular">
        <div class="pricing-box mt-4">
            <div class="pricing-badge">
                <span class="badge">Featured</span>
            </div>
            <i class="mdi mdi-account-multiple h1 text-primary"></i>
            <h4 class="f-20 text-primary">Regular</h4>
            <div class="mt-4 pt-2">
                <p class="mb-2 f-18">Features</p>
                <p class="mb-2">
                    <i class="mdi mdi-checkbox-marked-circle text-success f-18 mr-2"></i><b>40</b>
                    Booth Access
                </p>
                <p class="mb-2">
                    <i class="mdi mdi-close-circle text-danger f-18 mr-2"></i><b>10%</b> Discount for Regular Users
                </p>
            </div>
            <p class="mt-4 pt-2 text-muted">Perfect for frequent toll booth users with additional savings.</p>
            <div class="pricing-plan mt-4 pt-2">
               
            <h4 class="text-muted">
            <?php echo '<span style="text-decoration: line-through;">$' . number_format($basePrice * 50, 2) . '</span>'; ?>

    <span class="plan pl-3 text-dark">
        $<?php echo number_format(($basePrice * 50) * 0.9, 2); ?>
    </span>
</h4>
                <p class="text-muted mb-0">Per Month</p>
            </div>
            <div class="mt-4 pt-3">
            <form method="post" action="">
                <input type="hidden" name="plan_type" value="basic">
                <button type="submit" class="btn btn-primary btn-rounded" name="purchase_now">Purchase Now</button>
            </form>
            </div>
        </div>
    </div>

    <!-- Premium Plan -->
    <div class="col-lg-4">
        <div class="pricing-box mt-4">
            <i class="mdi mdi-account-multiple-plus h1"></i>
            <h4 class="f-20">Premium</h4>
            <div class="mt-4 pt-2">
                <p class="mb-2 f-18">Features</p>
                <p class="mb-2">
                    <i class="mdi mdi-checkbox-marked-circle text-success f-18 mr-2"></i><b>Unlimited</b> Booth Access
                </p>
                <p class="mb-2">
                    <i class="mdi mdi-close-circle text-danger f-18 mr-2"></i><b>17%</b> Discount for Premium Users
                </p>
            </div>
            <p class="mt-4 pt-2 text-muted">Enjoy the ultimate convenience with unlimited toll booth access and exclusive discounts.</p>
            <div class="pricing-plan mt-4 pt-2">
            <h4 class="text-muted">
    <span class="text-decoration-line-through text-secondary">
        $<?php echo number_format($basePrice * 70, 2); ?>
    </span>
    <span class="plan pl-3 text-dark small  ">
        $<?php echo number_format(($basePrice * 70) * 0.8, 2); ?>
    </span>
</h4>

                <p class="text-muted mb-0">Per Month</p>
            </div>
            <div class="mt-4 pt-3">
            <form method="post" action="">
                <input type="hidden" name="plan_type" value="basic">
                <button type="submit" class="btn btn-primary btn-rounded" name="purchase_now">Purchase Now</button>
            </form>
            </div>
        </div>
    </div>

 
</body>

<?php
include './includes/footer.php'
?>