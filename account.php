<?php
session_start();
include './includes/header.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tollgatebooth";

$conn = new mysqli($servername, $username, $password, $dbname);

// Error handling for database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

// Read operation
$query = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$vehicleQuery = "SELECT * FROM vehicles WHERE user_id = ?";
$vehicleStmt = $conn->prepare($vehicleQuery);
$vehicleStmt->bind_param('i', $_SESSION['user_id']);
$vehicleStmt->execute();
$vehicleResult = $vehicleStmt->get_result();
$vehicle = $vehicleResult->fetch_assoc();  

// Update operation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form is submitted for profile picture upload
    if (isset($_FILES['profile_picture'])) {
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

        // Validate file type on the server side
        if (!in_array($fileExtension, $allowedFileTypes) || exif_imagetype($targetFilePath) === false) {
            die("Error: Invalid file type. Allowed types are " . implode(', ', $allowedFileTypes));
        }

        // Move the uploaded file to the desired directory
        if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
            // File upload successful

            // Update the file path in the database
            $updateQuery = "UPDATE users SET profile_picture = ? WHERE user_id = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param('si', $targetFilePath, $_SESSION['user_id']);

            if ($updateStmt->execute()) {
                // Database update successful
                header("Location: account.php");
                exit();
            } else {
                // Database update failed
                die("Error: Failed to update the database.");
            }

            $updateStmt->close();
        } else {
            die("Error: Failed to move the file.");
        }
    } else {
      // Handle other form submissions (first_name, last_name, gender, address, phone_number)
$first_name = htmlspecialchars($_POST['first_name']);
$last_name = htmlspecialchars($_POST['last_name']);
$gender = htmlspecialchars($_POST['gender']);
$address = htmlspecialchars($_POST['address']);
$phone_number = htmlspecialchars($_POST['phone_number']);

// Concatenate first_name and last_name to update full_name
$full_name = $first_name . ' ' . $last_name;

// Update user information excluding the profile picture
$updateQuery = "UPDATE users SET first_name = ?, last_name = ?, gender = ?, address = ?, phone_number = ?, full_name = ? WHERE user_id = ?";
$updateStmt = $conn->prepare($updateQuery);

// Adjust the bind_param to match the number and types of placeholders
$updateStmt->bind_param('ssssssi', $first_name, $last_name, $gender, $address, $phone_number, $full_name, $_SESSION['user_id']);

if ($updateStmt->execute()) {
    // Update successful
    header("Location: account.php");
    exit();
} else {
    // Update failed
    $error = "Failed to update user information: " . $updateStmt->error;
    echo $error;
}


    }
}





// Close database connection
$conn->close();
?>

<body class="app">   	
	<?php
        include_once './includes/components/appHeader.php'
    ?>  

    <div class="app-wrapper">
	    
	    <div class="app-content pt-3 p-md-3 p-lg-4">
		    <div class="container-xl">
			    
			    <h1 class="app-page-title">My Account</h1>
                <div class="row gy-4">
	                <div class="col-12 col-lg-6">
		                <div class="app-card app-card-account shadow-sm d-flex flex-column align-items-start">
						    <div class="app-card-header p-3 border-bottom-0">
						        <div class="row align-items-center gx-3">
							        <div class="col-auto">
								        <div class="app-icon-holder">
										    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M10 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
</svg>
									    </div><!--//icon-holder-->
						                
							        </div><!--//col-->
							        <div class="col-auto">
								        <h4 class="app-card-title">Profile</h4>
							        </div><!--//col-->
						        </div><!--//row-->
						    </div><!--//app-card-header-->
						    <div class="app-card-body px-4 w-100">
							   <!-- ... (other HTML) ... -->

							   <div class="item border-bottom py-3">
    <div class="row justify-content-between align-items-center">
        <div class="col-auto">
            <div class="item-label mb-2"><strong>Photo</strong></div>
            <div class="item-data">
            <?php
                                                // Include your database connection code

                                                // Replace 1 with the actual user ID
                                                $userId = $_SESSION['user_id'];

                                                $db = new mysqli("localhost", "root", "", "tollgatebooth");

                                                // Error handling for database connection
                                                if ($db->connect_error) {
                                                    die("Connection failed: " . $db->connect_error);
                                                }

                                                $selectQuery = "SELECT profile_picture FROM users WHERE user_id = ?";
                                                $selectStmt = $db->prepare($selectQuery);
                                                $selectStmt->bind_param('i', $userId);

                                                $selectStmt->execute();
                                                $selectStmt->bind_result($profilePicture);
                                                $selectStmt->fetch();

                                                $selectStmt->close();
                                                $db->close();
                                                ?>

                                                <?php if ($profilePicture) : ?>
                                                    <img class="profile-image" src="<?php echo htmlspecialchars($profilePicture); ?>" alt="Profile Picture" style="width: 150px; height: 150px;">
                                                <?php else : ?>
                                                    <img class="profile-image" src="assets/defaults/profile.png" alt="Default Profile Picture" style="width: 150px; height: 150px;">
                                                <?php endif; ?>
            </div>
        </div><!--//col-->
        <div class="col text-end">
            <button type="button" class="btn-sm app-btn-secondary" data-bs-toggle="modal" data-bs-target="#uploadProfilePicModal">Change</button>
        </div><!--//col-->
    </div><!--//row-->
</div><!--//item-->


<!-- ... (other HTML) ... -->
 



<!-- Bootstrap Modal for Profile Picture Upload -->
<div class="modal fade" id="uploadProfilePicModal" tabindex="-1" aria-labelledby="uploadProfilePicModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadProfilePicModalLabel">Upload Profile Picture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Upload Profile Picture Form -->
                <!-- Upload Profile Picture Form -->
                <form method="POST" action="process_profile_pic.php" enctype="multipart/form-data">
                                                    <div class="mb-3">
                                                        <label for="profile_picture" class="form-label">Choose Image</label>
                                                        <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Upload</button>
                                                </form>
<!-- End of Upload Profile Picture Form -->

                <!-- End of Upload Profile Picture Form -->
            </div>
        </div>
    </div>
</div>

<!-- ... (other HTML) ... -->
<!--//item-->
							    <div class="item border-bottom py-3">
								    <div class="row justify-content-between align-items-center">
									    <div class="col-auto">
										    <div class="item-label"><strong>Name</strong></div>
									        <div class="item-data"><?= $user['full_name'] ?></div>
									    </div><!--//col-->
									    
								    </div><!--//row-->
							    </div><!--//item-->
							    <div class="item border-bottom py-3">
								    <div class="row justify-content-between align-items-center">
									    <div class="col-auto">
										    <div class="item-label"><strong>Email</strong></div>
									        <div class="item-data"><?= $user['email'] ?></div>
									    </div><!--//col-->
									    
								    </div><!--//row-->
							    </div><!--//item-->
							    <div class="item border-bottom py-3">
								    <div class="row justify-content-between align-items-center">
									    <div class="col-auto">
										    <div class="item-label"><strong>Phone</strong></div>
									        <div class="item-data">
											<?= $user['phone_number'] ?>
									        </div>
									    </div><!--//col-->
									    
								    </div><!--//row-->
							    </div><!--//item-->
							    <div class="item border-bottom py-3">
								    <div class="row justify-content-between align-items-center">
									    <div class="col-auto">
										    <div class="item-label"><strong>Address</strong></div>
									        <div class="item-data">
											<?= $user['address'] ?>
									        </div>
									    </div><!--//col-->
									    
								    </div><!--//row-->
							    </div><!--//item-->
						    </div><!--//app-card-body-->
						    <div class="app-card-footer p-4 mt-auto">
							   <a   data-bs-toggle="modal" data-bs-target="#updateModal" class="btn app-btn-secondary" href="#">Manage Profile</a>
				 
						    </div><!--//app-card-footer-->
						   
						</div><!--//app-card-->
	                </div><!--//col-->
	                <div class="col-12 col-lg-6">
		                <div class="app-card app-card-account shadow-sm d-flex flex-column align-items-start">
						    <div class="app-card-header p-3 border-bottom-0">
						        <div class="row align-items-center gx-3">
							        <div class="col-auto">
								        <div class="app-icon-holder">
										    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-sliders" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M11.5 2a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM9.05 3a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0V3h9.05zM4.5 7a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM2.05 8a2.5 2.5 0 0 1 4.9 0H16v1H6.95a2.5 2.5 0 0 1-4.9 0H0V8h2.05zm9.45 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm-2.45 1a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0v-1h9.05z"/>
</svg>
									    </div><!--//icon-holder-->
						                
							        </div><!--//col-->
							        <div class="col-auto" id="vehicle">
								        <h4 class="app-card-title">vehicle</h4>
							        </div><!--//col-->
						        </div><!--//row-->
						    </div><!--//app-card-header-->
						    <div class="app-card-body px-4 w-100">
							    
							<div class="item border-bottom py-3">
    <div class="row justify-content-between align-items-center">
        <div class="col-auto">
            <div class="item-label"><strong>Vehicle Type</strong></div>
            <div class="item-data"><?= isset($vehicle['vehicle_type']) ? $vehicle['vehicle_type'] : '' ?></div>
        </div><!--//col-->
    </div><!--//row-->
</div><!--//item-->

<div class="item border-bottom py-3">
    <div class="row justify-content-between align-items-center">
        <div class="col-auto">
            <div class="item-label"><strong>Registration Number</strong></div>
            <div class="item-data"><?= isset($vehicle['registration_number']) ? $vehicle['registration_number'] : '' ?></div>
        </div><!--//col-->
    </div><!--//row-->
</div><!--//item-->

<div class="item border-bottom py-3">
    <div class="row justify-content-between align-items-center">
        <div class="col-auto">
            <div class="item-label"><strong>Toll Bill Per</strong></div>
            <div class="item-data">
                <?php
                if (isset($vehicle['vehicle_type'])) {
                    $vehicle_type = strtolower($vehicle['vehicle_type']);
                    switch ($vehicle_type) {
                        case 'private car':
                            echo 'GH₵2.00';
                            break;
                        case '4x4 vehicles (4wd)':
                            echo 'GH₵3.00';
                            break;
                        case 'motorbike':
                            echo 'GH₵1.00';
                            break;
                        case 'tricyles':
                            echo 'GH₵1.00';
                            break;
                        case 'heavy goods vehicles':
                            echo 'GH₵30.00';
                            break;
                        case 'minibuses':
                            echo 'GH₵5.00';
                            break;
                        default:
                            echo "No match for vehicle type: " . htmlspecialchars($vehicle['vehicle_type']);
                            break;
                    }
                } else {
                    echo 'Vehicle type not set';
                }
                ?>
            </div>
        </div><!--//col-->
    </div><!--//row-->
</div><!--//item-->

							    <div class="item border-bottom py-3">
								    <div class="row justify-content-between align-items-center">
									    <div class="col-auto">
										    <div class="item-label"><strong>paid_status</strong></div>
									        <div class="item-data">Cedis</div>
									    </div><!--//col-->
									    
								    </div><!--//row-->
							    </div><!--//item-->
							    <div class="item border-bottom py-3">
								    <div class="row justify-content-between align-items-center">
									    <div class="col-auto">
										    <div class="item-label"><strong></strong></div>
									        <div class="item-data">Off</div>
									    </div><!--//col-->
									    
								    </div><!--//row-->
							    </div><!--//item-->
							    <div class="item border-bottom py-3">
								    <div class="row justify-content-between align-items-center">
									    <div class="col-auto">
										    <div class="item-label"><strong>SMS Notifications</strong></div>
									        <div class="item-data">On</div>
									    </div><!--//col-->
									    
								    </div><!--//row-->
							    </div><!--//item-->

<!-- Bootstrap Modal for Update/Create Vehicle -->
<div class="modal fade" id="updateVehicleModal" tabindex="-1" aria-labelledby="updateVehicleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateVehicleModalLabel">Update/Create Vehicle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Update/Create Vehicle Form -->
            <!-- Your existing HTML and UI code goes here -->

<!-- The form for updating/creating vehicle information -->
<form method="POST" action="process_vehicle.php" enctype="multipart/form-data">
    <!-- Input fields for vehicle information -->
    <div class="mb-3">
        <label for="vehicle_type" class="form-label">Vehicle Type</label>
        <select class="form-select" id="vehicle_type" name="vehicle_type" required>
            <?php
            $vehicleTypes = ['Private car', '4x4 Vehicles', 'Minibuses', 'Motorbike', 'Heavy Goods Vehicles', 'Tricycles'];
            foreach ($vehicleTypes as $type) {
                $selected = ($type === $vehicle['vehicle_type']) ? 'selected' : '';
                echo "<option value=\"$type\" $selected>$type</option>";
            }
            ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="registration_number" class="form-label">Registration Number</label>
        <input type="text" class="form-control" id="registration_number" name="registration_number" placeholder="Enter registration number" required>
    </div>
    
    <!-- New fields for vehicle information -->
    <!-- <div class="mb-3">
        <label for="last_toll_paid_date" class="form-label">Last Toll Paid Date</label>
        <input type="datetime-local" class="form-control" id="last_toll_paid_date" name="last_toll_paid_date" required>
    </div> -->
<!-- Existing HTML and UI code ... -->

<!-- New field for vehicle model as a select dropdown -->
<div class="mb-3">
    <label for="model" class="form-label">Model</label>
    <select class="form-select" id="model" name="model" required>
        <?php
        // List of 20 popular car models (replace with actual models)
        $carModels = [
            'Corolla', 'Civic', 'Focus', 'Altima', 'Malibu', 'Elantra', 'Golf', 'Sorento', 'CX-5',
            'Outback', 'E-Class', '3 Series', 'A4', 'RX', 'Cherokee', 'Model S', 'Range Rover', '911', 'F-PACE', 'Others'
        ];

        // Iterate through the models and generate options
        foreach ($carModels as $model) {
            $selected = ($model === $vehicle['model']) ? 'selected' : '';
            echo "<option value=\"$model\" $selected>$model</option>";
        }
        ?>
    </select>
</div>


<!-- Existing HTML and UI code ... -->

    <!-- Existing HTML and UI code ... -->

<!-- New field for vehicle manufacturing year as a select dropdown -->
<div class="mb-3">
    <label for="year" class="form-label">Year</label>
    <select class="form-select" id="year" name="year" required>
        <?php
        // Generate a list of years, adjust the range as needed
        $currentYear = date('Y');
        for ($i = $currentYear; $i >= $currentYear - 30; $i--) {
            $selected = ($i === $vehicle['year']) ? 'selected' : '';
            echo "<option value=\"$i\" $selected>$i</option>";
        }
        ?>
    </select>
</div>

<!-- New field for vehicle color as a select dropdown -->
<div class="mb-3">
    <label for="colour" class="form-label">Colour</label>
    <select class="form-select" id="colour" name="colour" required>
        <?php
        // List of 10 common car colors
        $carColors = ['Black', 'White', 'Silver', 'Gray', 'Blue', 'Red', 'Green', 'Yellow', 'Brown', 'Orange'];

        // Iterate through the colors and generate options
        foreach ($carColors as $color) {
            $selected = ($color === $vehicle['colour']) ? 'selected' : '';
            echo "<option value=\"$color\" $selected>$color</option>";
        }
        ?>
    </select>
</div>

<!-- Existing HTML and UI code ... -->

    <div class="mb-3">
        <label for="insurance_company" class="form-label">Insurance Company</label>
        <input type="text" class="form-control" id="insurance_company" name="insurance_company" placeholder="Enter insurance company" required>
    </div>
    <div class="mb-3">
        <label for="photo" class="form-label">Photo</label>
        <input type="file" class="form-control" id="photo" name="photo" accept="image/*" required>
    </div>
	<button type="submit" class="btn btn-primary" name="updateVehicle">Update Vehicle</button>
</form>

 

                <!-- End of Update/Create Vehicle Form -->
            </div>
        </div>
    </div>
</div>

						    </div><!--//app-card-body-->
						    <div class="app-card-footer p-4 mt-auto">
							<button type="button" class="btn app-btn-secondary" ></button>
							   <a class="btn app-btn-secondary" href="#" data-bs-toggle="modal" data-bs-target="#updateVehicleModal">Manage Vehicle</a>
						    </div><!--//app-card-footer-->
						   
						</div><!--//app-card-->
	                </div><!--//col-->
	                <div class="col-12 col-lg-6">
		                <div class="app-card app-card-account shadow-sm d-flex flex-column align-items-start">
						    <div class="app-card-header p-3 border-bottom-0">
						        <div class="row align-items-center gx-3">
							        <div class="col-auto">
								        <div class="app-icon-holder">
										    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-shield-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M5.443 1.991a60.17 60.17 0 0 0-2.725.802.454.454 0 0 0-.315.366C1.87 7.056 3.1 9.9 4.567 11.773c.736.94 1.533 1.636 2.197 2.093.333.228.626.394.857.5.116.053.21.089.282.11A.73.73 0 0 0 8 14.5c.007-.001.038-.005.097-.023.072-.022.166-.058.282-.111.23-.106.525-.272.857-.5a10.197 10.197 0 0 0 2.197-2.093C12.9 9.9 14.13 7.056 13.597 3.159a.454.454 0 0 0-.315-.366c-.626-.2-1.682-.526-2.725-.802C9.491 1.71 8.51 1.5 8 1.5c-.51 0-1.49.21-2.557.491zm-.256-.966C6.23.749 7.337.5 8 .5c.662 0 1.77.249 2.813.525a61.09 61.09 0 0 1 2.772.815c.528.168.926.623 1.003 1.184.573 4.197-.756 7.307-2.367 9.365a11.191 11.191 0 0 1-2.418 2.3 6.942 6.942 0 0 1-1.007.586c-.27.124-.558.225-.796.225s-.526-.101-.796-.225a6.908 6.908 0 0 1-1.007-.586 11.192 11.192 0 0 1-2.417-2.3C2.167 10.331.839 7.221 1.412 3.024A1.454 1.454 0 0 1 2.415 1.84a61.11 61.11 0 0 1 2.772-.815z"/>
  <path fill-rule="evenodd" d="M10.854 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
</svg>
									    </div><!--//icon-holder-->
						                
							        </div><!--//col-->
							        <div class="col-auto">
								        <h4 class="app-card-title">Security</h4>
							        </div><!--//col-->
						        </div><!--//row-->
						    </div><!--//app-card-header-->
						    <div class="app-card-body px-4 w-100">
							    
							    <div class="item border-bottom py-3">
								    <div class="row justify-content-between align-items-center">
									    <div class="col-auto">
										    <div class="item-label"><strong>Password</strong></div>
									        <div class="item-data">••••••••</div>
									    </div><!--//col-->
									    
								    </div><!--//row-->
							    </div><!--//item-->
							    <div class="item border-bottom py-3">
								    <div class="row justify-content-between align-items-center">
									    <div class="col-auto">
										    <div class="item-label"><strong>Two-Factor Authentication</strong></div>
									        <div class="item-data">Coming Soon</div>
									    </div><!--//col-->
									    <div class="col text-end">
										    <a class="btn-sm app-btn-secondary" href="#">Set up</a>
									    </div><!--//col-->
								    </div><!--//row-->
							    </div><!--//item-->
						    </div><!--//app-card-body-->
						    
						    <div class="app-card-footer p-4 mt-auto">
							    
                               <button type="button" class="btn app-btn-secondary" data-bs-toggle="modal" data-bs-target="#passwordResetModal">
    Change Password
</button>
						    </div><!--//app-card-footer-->
						   <!-- Button to trigger the modal -->
 

<!-- Password Reset Modal -->
<div class="modal fade" id="passwordResetModal" tabindex="-1" aria-labelledby="passwordResetModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="passwordResetModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Password Reset Form -->
                <form id="passwordResetForm" method="POST" action="process_password_reset.php">
                    <div class="mb-3">
                        <label for="oldPassword" class="form-label">Old Password</label>
                        <input type="password" class="form-control" id="oldPassword" name="oldPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </form>
                <!-- End Password Reset Form -->
            </div>
        </div>
    </div>
</div>

						</div><!--//app-card-->
	                </div>
	                <div class="col-12 col-lg-6">
		                <div class="app-card app-card-account shadow-sm d-flex flex-column align-items-start">
						    <div class="app-card-header p-3 border-bottom-0">
						        <div class="row align-items-center gx-3">
							        <div class="col-auto">
								        <div class="app-icon-holder">
										    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-credit-card" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1H2zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7z"/>
  <path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1z"/>
</svg>
									    </div><!--//icon-holder-->
						                
							        </div><!--//col-->
							        <div class="col-auto">
								        <h4 class="app-card-title">Payment methods</h4>
							        </div><!--//col-->
						        </div><!--//row-->
						    </div><!--//app-card-header-->
						    <div class="app-card-body px-4 w-100">
							    
							    <div class="item border-bottom py-3">
								    <div class="row justify-content-between align-items-center">
									    <div class="col-auto">
										    <div class="item-label"><i class="fab fa-cc-visa me-2"></i><strong>Credit/Debit Card </strong></div>
									        <div class="item-data">1234*******5678</div>
									    </div><!--//col-->
									    <div class="col text-end">
										    <a class="btn-sm app-btn-secondary" href="#">Edit</a>
									    </div><!--//col-->
								    </div><!--//row-->
							    </div><!--//item-->
							    <div class="item border-bottom py-3">
								    <div class="row justify-content-between align-items-center">
									    <div class="col-auto">
										    <div class="item-label"><i class="fab fa-paypal me-2"></i><strong>PayPal</strong></div>
									        <div class="item-data">Not connected</div>
									    </div><!--//col-->
									    <div class="col text-end">
										    <a class="btn-sm app-btn-secondary" href="#">Connect</a>
									    </div><!--//col-->
								    </div><!--//row-->
							    </div><!--//item-->
							    <div class="item border-bottom py-3">
								    <div class="row justify-content-between align-items-center">
									    <div class="col-auto">
										    <div class="item-label"><i class="fab fa-paypal me-2"></i><strong>Momo</strong></div>
									        <div class="item-data">Through PayStack</div>
									    </div><!--//col-->
									    <div class="col text-end">
										    <a class="btn-sm app-btn-secondary" href="#">Connect</a>
									    </div><!--//col-->
								    </div><!--//row-->
							    </div><!--//item-->
						    </div><!--//app-card-body-->
						    <div class="app-card-footer p-4 mt-auto">
							   <a class="btn app-btn-secondary" href="#">Manage Payment</a>
						    </div><!--//app-card-footer-->
						   
						</div><!--//app-card-->
	                </div>
                </div><!--//row-->
			        <!-- Bootstrap Modal for Update -->
                    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update User Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Update Form -->
                <form method="POST" action="">
                    <!-- Input fields for first_name, last_name, gender, address, and phone_number -->
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?= $user['first_name'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?= $user['last_name'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-select" id="gender" name="gender">
                            <option value="Male" <?= ($user['gender'] == 'Male') ? 'selected' : '' ?>>Male</option>
                            <option value="Female" <?= ($user['gender'] == 'Female') ? 'selected' : '' ?>>Female</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="<?= $user['address'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?= $user['phone_number'] ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
                <!-- End of Update Form -->
            </div>
        </div>
    </div>
</div>






</div>
		 
			 
	   
	    
		<?php include './includes/footer.php' ?>



 

