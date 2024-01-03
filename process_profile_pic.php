<?php
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the file is selected
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        // Process the uploaded file
        $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
        $fileName = $_FILES['profile_picture']['name'];
        $fileSize = $_FILES['profile_picture']['size'];
        $fileType = $_FILES['profile_picture']['type'];

        // Customize the upload directory as per your requirements
        $uploadDirectory = './upload/';
        $targetFilePath = $uploadDirectory . $fileName;

        // Check file size (you can customize this limit)
        $maxFileSize = 5 * 1024 * 1024; // 5 MB
        if ($fileSize > $maxFileSize) {
            die("Error: File size is too large.");
        }

        // Allow certain file formats (you can customize this list)
        $allowedFileTypes = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExtension = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        if (!in_array($fileExtension, $allowedFileTypes)) {
            die("Error: Invalid file type. Allowed types are " . implode(', ', $allowedFileTypes));
        }

        // Move the uploaded file to the desired directory
        if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
            // File upload successful

            // Insert the file path into the database
            $userId = $_SESSION['user_id'];
            $db = new mysqli("localhost", "root", "", "tollgatebooth");

            if ($db->connect_error) {
                die("Connection failed: " . $db->connect_error);
            }

            $insertQuery = "UPDATE users SET profile_picture = ? WHERE user_id = ?";
            $insertStmt = $db->prepare($insertQuery);
            $insertStmt->bind_param('si', $targetFilePath, $userId);

            if ($insertStmt->execute()) {
                // Database update successful
                // Redirect back to account.php
                header("Location: account.php");
                exit();
            } else {
                // Database update failed
                die("Error: Failed to update the database.");
            }

            $insertStmt->close();
            $db->close();
        } else {
            die("Error: Failed to move the file.");
        }
    } else {
        die("Error: No file selected or an error occurred.");
    }
}
?>
