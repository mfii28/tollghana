<?php
session_start();
include 'config/config.php';

// Include your database connection code here

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize inputs
    $oldPassword = htmlspecialchars($_POST['oldPassword']);
    $newPassword = htmlspecialchars($_POST['newPassword']);
    $confirmPassword = htmlspecialchars($_POST['confirmPassword']);

    // Add additional validation as needed

    // Check if the old password matches the current password
    $userId = $_SESSION['user_id'];
    $checkPasswordQuery = "SELECT password FROM users WHERE user_id = ?";
    $checkPasswordStmt = $conn->prepare($checkPasswordQuery);

    if (!$checkPasswordStmt) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }

    $checkPasswordStmt->bind_param('i', $userId);
    $checkPasswordStmt->execute();
    $checkPasswordStmt->store_result();

    if ($checkPasswordStmt->num_rows > 0) {
        $checkPasswordStmt->bind_result($hashedPassword);
        $checkPasswordStmt->fetch();

        // Verify old password
        if (password_verify($oldPassword, $hashedPassword)) {
            // Old password is correct, proceed to update the password
            if ($newPassword === $confirmPassword) {
                // Hash the new password
                $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // Update the password in the database
                $updatePasswordQuery = "UPDATE users SET password = ? WHERE user_id = ?";
                $updatePasswordStmt = $conn->prepare($updatePasswordQuery);

                if (!$updatePasswordStmt) {
                    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
                }

                $updatePasswordStmt->bind_param('si', $hashedNewPassword, $userId);

                if ($updatePasswordStmt->execute()) {
                    // Password update successful
                    echo '<script>alert("Password updated successfully!");</script>';
                    header("Location: account.php");
                    exit(); // Ensure script stops execution after redirect
                } else {
                    // Password update failed
                    die("Failed to update password: " . $updatePasswordStmt->error);
                }
            } else {
                // New password and confirm password do not match
                echo '<script>alert("New password and confirm password do not match.");</script>';
            }
        } else {
            // Old password is incorrect
            echo '<script>alert("Incorrect old password.");</script>';
        }
    } else {
        // User not found
        echo '<script>alert("User not found.");</script>';
    }

    // Close the prepared statement
    $checkPasswordStmt->close();
} else {
    // Redirect to the login page or handle as needed
    header("Location: auth/login.php");
    exit();
}

// Close the database connection
$conn->close();
?>
