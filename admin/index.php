<?php include 'header.php' ?>
    <div class="app-wrapper">
	    
	    <div class="app-content pt-3 p-md-3 p-lg-4">
		    <div class="container-xl">
			    
			    <h1 class="app-page-title">Overview</h1>
			    
			    <div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration" role="alert">
				    <div class="inner">
					    <div class="app-card-body p-3 p-lg-4">
						    <h3 class="mb-3">Welcome, developer!</h3>
						    <div class="row gx-5 gy-3">
						        <div class="col-12 col-lg-9">
							        
							 
  <path d="M4 0h5.5v1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h1V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z"/>
  <path d="M9.5 3V0L14 4.5h-3A1.5 1.5 0 0 1 9.5 3z"/>
  <path fill-rule="evenodd" d="M8 6a.5.5 0 0 1 .5.5v3.793l1.146-1.147a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 1 1 .708-.708L7.5 10.293V6.5A.5.5 0 0 1 8 6z"/>
 
							    </div><!--//col-->
						    </div><!--//row-->
						    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					    </div><!--//app-card-body-->
					    
				    </div><!--//inner-->
			    </div><!--//app-card-->
				    
			    <div class="row g-4 mb-4">
                <div class="col-6 col-lg-3">
    <div class="app-card app-card-stat shadow-sm h-100">
        <div class="app-card-body p-3 p-lg-4">
            <h4 class="stats-type mb-1">Sales</h4>

            <?php
            // Assuming you have a database connection established
            $servername = "localhost";
           $username = "root";
           $password = "";
           $dbname = "tollgatebooth";
           

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Perform a query to get the total number of active subscribers
            $query = "SELECT COUNT(user_id) AS total_sales FROM toll_subscribe WHERE subscription_type > 0";
            $result = mysqli_query($conn, $query);

            // Check if the query was successful
            if ($result) {
                // Fetch the result as an associative array
                $row = mysqli_fetch_assoc($result);

                // Extract the total number of active subscribers (sales)
                $totalSales = $row['total_sales'];

                // Output the total number of sales in your HTML
                echo '<div class="stats-figure">' . $totalSales . '</div>';
            } else {
                // Handle the case where the query fails
                echo 'Error executing query: ' . mysqli_error($conn);
            }

            // Close the database connection
            mysqli_close($conn);
            ?>

            <div class="stats-meta">
                Total Sales (Active Subscribers)</div>
        </div><!--//app-card-body-->
        <a class="app-card-link-mask" href="#"></a>
    </div><!--//app-card-->
</div><!--//col-->


<div class="col-6 col-lg-3">
    <div class="app-card app-card-stat shadow-sm h-100">
        <div class="app-card-body p-3 p-lg-4">
            <h4 class="stats-type mb-1">Users</h4>

            <?php
            // Assuming you have a database connection established
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "tollgatebooth";
            

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Perform a query to get the total number of users
            $query = "SELECT COUNT(user_id) AS total_users FROM users";
            $result = mysqli_query($conn, $query);

            // Check if the query was successful
            if ($result) {
                // Fetch the result as an associative array
                $row = mysqli_fetch_assoc($result);

                // Extract the total number of users
                $totalUsers = $row['total_users'];

                // Output the total number of users in your HTML
                echo '<div class="stats-figure">' . $totalUsers . '</div>';
            } else {
                // Handle the case where the query fails
                echo 'Error executing query: ' . mysqli_error($conn);
            }

            // Close the database connection
            mysqli_close($conn);
            ?>

            <div class="stats-meta">
                Total Users</div>
        </div><!--//app-card-body-->
        <a class="app-card-link-mask" href="#"></a>
    </div><!--//app-card-->
</div><!--//col-->


<div class="col-6 col-lg-3">
    <div class="app-card app-card-stat shadow-sm h-100">
        <div class="app-card-body p-3 p-lg-4">
            <h4 class="stats-type mb-1">Earnings</h4>

            <?php
           $servername = "localhost";
           $username = "root";
           $password = "";
           $dbname = "tollgatebooth";
           

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Perform a query to get the total earnings
            $query = "SELECT SUM(amount) AS total_earnings FROM earning";
            $result = mysqli_query($conn, $query);

            // Check if the query was successful
            if ($result) {
                // Fetch the result as an associative array
                $row = mysqli_fetch_assoc($result);

                // Extract the total earnings amount
                $totalEarnings = $row['total_earnings'];

                // Output the total earnings amount in your HTML
                echo '<div class="stats-figure">$' . number_format($totalEarnings, 2) . '</div>';
            } else {
                // Handle the case where the query fails
                echo 'Error executing query: ' . mysqli_error($conn);
            }

            // Close the database connection
            mysqli_close($conn);
            ?>

            <div class="stats-meta">
                Total Earnings</div>
        </div><!--//app-card-body-->
        <a class="app-card-link-mask" href="#"></a>
    </div><!--//app-card-->
</div><!--//col-->
<div class="col-6 col-lg-3">
    <div class="app-card app-card-stat shadow-sm h-100">
        <div class="app-card-body p-3 p-lg-4">
            <h4 class="stats-type mb-1">Registered Vehicles</h4>

            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "tollgatebooth";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Perform a query to get the total number of registered vehicles
            $query = "SELECT COUNT(vehicle_id) AS total_vehicles FROM vehicles";
            $result = mysqli_query($conn, $query);

            // Check if the query was successful
            if ($result) {
                // Fetch the result as an associative array
                $row = mysqli_fetch_assoc($result);

                // Extract the total number of registered vehicles
                $totalVehicles = $row['total_vehicles'];

                // Output the total number of registered vehicles in your HTML
                echo '<div class="stats-figure">' . $totalVehicles . '</div>';
            } else {
                // Handle the case where the query fails
                echo 'Error executing query: ' . mysqli_error($conn);
            }

            // Close the database connection
            mysqli_close($conn);
            ?>

            <div class="stats-meta">
                Total Registered Vehicles</div>
        </div><!--//app-card-body-->
        <a class="app-card-link-mask" href="#"></a>
    </div><!--//app-card-->
</div><!--//col-->

        </div>
		  
	    
	  <?php include 'footer.php' ?>


