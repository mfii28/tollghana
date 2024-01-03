<?php
session_start();
include 'config/config.php';
include 'phpqrcode/qrlib.php';

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

// User is logged in, retrieve the user_id from the session
$user_id = $_SESSION['user_id'];

// Generate QR code data with user ID and profile page URL
$profilePageUrl = "http://localhost/tollGate/profile_page.php";
$qrcodeData = $profilePageUrl . "?user_id=" . $user_id;

// Specify the path to save the QR code
$qrcodePath = "user_qrcodes/user_" . $user_id . ".png";

// Create and save the QR code image
if (!QRcode::png($qrcodeData, $qrcodePath)) {
    die("Failed to generate QR code.");
}

// Set the user_id as the active user
$updateActiveUserQuery = "UPDATE users SET active_user_id = ? WHERE user_id = ?";
$stmt = $conn->prepare($updateActiveUserQuery);

// Check if the prepare statement is successful
if (!$stmt) {
    die("Error in prepare statement: " . $conn->error);
}

// Bind parameters
$user_id_param = $user_id; // Assuming user_id is an integer
$stmt->bind_param("ii", $user_id_param, $user_id_param);

// Check if the bind_param is successful
if (!$stmt->execute()) {
    die("Error in execute statement: " . $stmt->error);
}

// Echo the file path to be used in the AJAX response
echo $qrcodePath;
?>
