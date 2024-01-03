<?php
include_once 'config/paystack_config.php'; // Include or define $paystack_secret_key here
include_once 'config/config.php';
session_start(); // Start the session

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $payment_method = $_POST["hidden_payment_method"];
    $amount = $_POST["amount"];

    // Check if user_id is set in the session
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    // Insert data into the correct table - "transactions"
    $insertQuery = "INSERT INTO transactions (user_id, amount, payment_method) VALUES (?, ?, ?)";
    $insertStmt = $conn->prepare($insertQuery);

    if (!$insertStmt) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }

    $insertStmt->bind_param('ids', $user_id, $amount, $payment_method);

    if ($insertStmt->execute()) {
        // Additional processing for Paystack integration
        if ($payment_method === 'mobile_money') {
            $momo_number = isset($_POST['momo_number']) ? $_POST['momo_number'] : null;
        } else {
            $momo_number = null;
        }

        $amount_in_kobo = $amount * 100; // Convert amount to kobo

        $reference = 'txn_' . time() . '_' . uniqid();

        $url = 'https://api.paystack.co/transaction/initialize';
        $data = [
            'email' => $_POST['email'],
            'amount' => $amount_in_kobo,
            'reference' => $reference,
            'channels' => [$payment_method],
            'metadata' => [
                'momo_number' => $momo_number,
            ],
        ];

        $headers = [
            'Authorization: Bearer ' . $paystack_secret_key,
            'Content-Type: application/json',
        ];

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);

        if ($response === false) {
            die('Curl error: ' . curl_error($ch));
        }

        curl_close($ch);

        file_put_contents('paystack_response.log', $response);

        $transaction = json_decode($response);

        if (isset($transaction->status) && $transaction->status === true && isset($transaction->data->authorization_url)) {
            // Redirect to Paystack authorization URL
            echo "<script>window.location.href = '{$transaction->data->authorization_url}';</script>";
        } else {
            echo "Error: Invalid response from Paystack API";
        }
    } else {
        echo "Error: " . $insertQuery . "<br>" . $insertStmt->error;
    }

    $insertStmt->close(); // Close the prepared statement
    $conn->close(); // Close the database connection
} else {
    // Handle non-POST requests or direct access to the script
    echo "Invalid request";
}
?>
