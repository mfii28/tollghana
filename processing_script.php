<?php
session_start();
include './includes/header.php';

// Include your database configuration
$host = 'localhost';
$dbname = "tollgatebooth";
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Process the payment form submission

        // Extract and sanitize data from the form
        $paymentMethod = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';
        $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
        $amount = isset($_POST['amount']) ? $_POST['amount'] : 0; // Use null instead of 0

        // Additional MoMo fields
        $momoNumber = ($paymentMethod === 'mobile_money') ? (isset($_POST['momo_number']) ? $_POST['momo_number'] : '') : null;

        // Validate the data (add more validation as needed)
        if (empty($paymentMethod) || empty($email) || is_null($amount)) {
            echo "Invalid data. Please check your input.";
            exit();
        }

        // Perform database insert into the 'deposits' table
        $stmt = $conn->prepare("INSERT INTO deposits (user_id, created_at, amount, payment_method, momo_number) VALUES (:user_id, NOW(), :amount, :payment_method, :momo_number)");
        $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindParam(':amount', $amount, PDO::PARAM_STR | PDO::PARAM_NULL); // Add PDO::PARAM_NULL
        $stmt->bindParam(':payment_method', $paymentMethod, PDO::PARAM_STR);
        $stmt->bindParam(':momo_number', $momoNumber, PDO::PARAM_STR);

        // Execute the statement
        if ($stmt->execute()) {
            // If the insert is successful, you can redirect or perform additional actions
            header("Location: deposit.php");
            exit();
        } else {
            // If there's an error with the database insert, handle it accordingly
            echo "Error processing payment. Please try again.";
        }
    }

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}
?>
