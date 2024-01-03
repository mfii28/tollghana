

<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tollgatebooth";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $vehicle_type = htmlspecialchars($_POST['vehicle_type']);
    $registration_number = htmlspecialchars($_POST['registration_number']);
    $model = htmlspecialchars($_POST['model']);
    $year = (int)$_POST['year'];
    $colour = htmlspecialchars($_POST['colour']);
    $insurance_company = htmlspecialchars($_POST['insurance_company']);

    // Calculate toll amount based on vehicle type
    $toll_amount = 0.00; // Default value if no match is found
    switch (strtolower($vehicle_type)) {
        case 'private car':
            $toll_amount = 2.00;
            break;
        case '4x4 vehicles (4wd)':
            $toll_amount = 3.00;
            break;
        case 'motorbike':
            $toll_amount = 1.00;
            break;
        case 'tricyles':
            $toll_amount = 1.00;
            break;
        case 'heavy goods vehicles':
            $toll_amount = 30.00;
            break;
        case 'minibuses':
            $toll_amount = 5.00;
            break;
        // Add more cases for other vehicle types if needed
    }

    // File upload handling
    $photo_name = uniqid() . '_' . $_FILES['photo']['name'];
    $photo_tmp = $_FILES['photo']['tmp_name'];
    $photo_destination = __DIR__ . "/upload/" . $photo_name;

    // Check if a record already exists for the user
    $checkRecordQuery = "SELECT * FROM vehicles WHERE user_id = ?";
    $checkRecordStmt = $conn->prepare($checkRecordQuery);

    if (!$checkRecordStmt) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }

    $checkRecordStmt->bind_param('i', $_SESSION['user_id']);
    $checkRecordStmt->execute();
    $result = $checkRecordStmt->get_result();

    if ($result->num_rows > 0) {
        // If a record exists, update the existing record
        $updateVehicleQuery = "UPDATE vehicles SET vehicle_type = ?, registration_number = ?, model = ?, year = ?, colour = ?, insurance_company = ?, photo = ?, toll_amount = ? WHERE user_id = ?";
        $updateVehicleStmt = $conn->prepare($updateVehicleQuery);

        if (!$updateVehicleStmt) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }

        $updateVehicleStmt->bind_param('sssiisssd', $vehicle_type, $registration_number, $model, $year, $colour, $insurance_company, $photo_name, $toll_amount, $_SESSION['user_id']);

        if ($updateVehicleStmt->execute()) {
            // Update successful
            header("Location: account.php");
            exit();
        } else {
            // Update failed
            die("Failed to update vehicle information: " . $updateVehicleStmt->error);
        }
    } else {
        // If no record exists, create a new record
        $insertVehicleQuery = "INSERT INTO vehicles (user_id, vehicle_type, registration_number, model, year, colour, insurance_company, photo, toll_amount) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $insertVehicleStmt = $conn->prepare($insertVehicleQuery);

        if (!$insertVehicleStmt) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }

        $insertVehicleStmt->bind_param('isssisssd', $_SESSION['user_id'], $vehicle_type, $registration_number, $model, $year, $colour, $insurance_company, $photo_name, $toll_amount);

        if ($insertVehicleStmt->execute()) {
            // Insert successful
            header("Location: account.php");
            exit();
        } else {
            // Insert failed
            die("Failed to create vehicle entry: " . $insertVehicleStmt->error);
        }
    }
}
?>


