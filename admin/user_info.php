
<?php 
include 'header.php';
include '../config/config.php';

$userStatusFilter = "";

if (isset($_GET['tab'])) {
    switch ($_GET['tab']) {
        case 'orders-paid':
            // Filter subscribers
            $userStatusFilter = " WHERE toll_subscribe.subscription_type IS NOT NULL";
            break;
        case 'orders-pending':
            // Filter unsubscribers
            $userStatusFilter = " WHERE toll_subscribe.subscription_type IS NULL";
            break;
        case 'orders-cancelled':
            // Filter new users
            $userStatusFilter = " WHERE users.created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
            break;
        // For 'All', no additional filter is needed
        default:
            break;
    }
}

$query = "SELECT users.*, toll_subscribe.subscription_type
          FROM users
          LEFT JOIN toll_subscribe ON users.user_id = toll_subscribe.user_id" . $userStatusFilter;

$result = mysqli_query($conn, $query);
?>



<div class="app-wrapper">
	    
	    <div class="app-content pt-3 p-md-3 p-lg-4">
		    <div class="container-xl">
			    
			    <div class="row g-3 mb-4 align-items-center justify-content-between">
				    <div class="col-auto">
			            <h1 class="app-page-title mb-0">Orders</h1>
				    </div>
				    <div class="col-auto">
					     <div class="page-utilities">
						    <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
							    <div class="col-auto">
								    <form class="table-search-form row gx-1 align-items-center">
					                    <div class="col-auto">
					                        <input type="text" id="search-orders" name="searchorders" class="form-control search-orders" placeholder="Search">
					                    </div>
					                    <div class="col-auto">
					                        <button type="submit" class="btn app-btn-secondary">Search</button>
					                    </div>
					                </form>
					                
							    </div><!--//col-->
							    <div class="col-auto">
								    
								    <select class="form-select w-auto" >
										  <option selected value="option-1">All</option>
										  <option value="option-2">This week</option>
										  <option value="option-3">This month</option>
										  <option value="option-4">Last 3 months</option>
										  
									</select>
							    </div>
							    <div class="col-auto">						    
								    <a class="btn app-btn-secondary" href="#">
									    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-download me-1" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
		  <path fill-rule="evenodd" d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
		  <path fill-rule="evenodd" d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
		</svg>
									    Download CSV
									</a>
							    </div>
						    </div><!--//row-->
					    </div><!--//table-utilities-->
				    </div><!--//col-auto-->
			    </div><!--//row-->
			   
			    
			    <nav id="orders-table-tab" class="orders-table-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
				<a class="flex-sm-fill text-sm-center nav-link active" id="orders-all-tab" href="?tab=orders-all" role="tab" aria-controls="orders-all" aria-selected="true">All</a>
<a class="flex-sm-fill text-sm-center nav-link" id="orders-paid-tab" href="?tab=orders-paid" role="tab" aria-controls="orders-paid" aria-selected="false">Subscribers</a>
<a class="flex-sm-fill text-sm-center nav-link" id="orders-pending-tab" href="?tab=orders-pending" role="tab" aria-controls="orders-pending" aria-selected="false">Unsubscribers</a>
<a class="flex-sm-fill text-sm-center nav-link" id="orders-cancelled-tab" href="?tab=orders-cancelled" role="tab" aria-controls="orders-cancelled" aria-selected="false">New User</a>
	</nav>
				
				
				<div class="tab-content" id="orders-table-tab-content">
			        <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
					    <div class="app-card app-card-orders-table shadow-sm mb-5">
						    <div class="app-card-body">
							    <div class="table-responsive">
                                <table class="table app-table-hover mb-0 text-left">
    <thead>
        <tr>
            <th class="cell">Username</th>
            <th class="cell">Full Name</th>
            <th class="cell">Email</th>
            <th class="cell">Phone Number</th>
            <th class="cell">Subscription Type</th>
            <th class="cell"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "tollgatebooth";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = "SELECT users.*, toll_subscribe.subscription_type
                  FROM users
                  LEFT JOIN toll_subscribe ON users.user_id = toll_subscribe.user_id";
        $result = mysqli_query($conn, $query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td class="cell">' . $row['username'] . '</td>';
                echo '<td class="cell">' . $row['full_name'] . '</td>';
                echo '<td class="cell">' . $row['email'] . '</td>';
                echo '<td class="cell">' . $row['phone_number'] . '</td>';

                // Check subscription type and display the corresponding badge
                echo '<td class="cell">';
                if ($row['subscription_type'] === null) {
                    echo '<span class="badge bg-success">Basic</span>';
                } elseif ($row['subscription_type'] === 1) {
                    echo '<span class="badge bg-primary">Basic</span>';
                } elseif ($row['subscription_type'] === 2) {
                    echo '<span class="badge bg-primary">Regular</span>';
                } elseif ($row['subscription_type'] === 3) {
                    echo '<span class="badge bg-primary">Premium</span>';
                }
                echo '</td>';

                echo '<td class="cell"><a class="btn-sm app-btn-secondary" href="#">View</a></td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="6">Error executing query: ' . mysqli_error($conn) . '</td></tr>';
        }

        mysqli_close($conn);
        ?>
    </tbody>
</table>

						        </div><!--//table-responsive-->
						       
						    </div><!--//app-card-body-->		
						</div><!--//app-card-->
						<nav class="app-pagination">
							<ul class="pagination justify-content-center">
								<li class="page-item disabled">
									<a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
							    </li>
								<li class="page-item active"><a class="page-link" href="#">1</a></li>
								<li class="page-item"><a class="page-link" href="#">2</a></li>
								<li class="page-item"><a class="page-link" href="#">3</a></li>
								<li class="page-item">
								    <a class="page-link" href="#">Next</a>
								</li>
							</ul>
						</nav><!--//app-pagination-->
						
			        </div><!--//tab-pane-->
			        
	 
			    
		    </div><!--//container-fluid-->
	    </div><!--//app-content-->
	    
	    <footer class="app-footer">
		    <div class="container text-center py-3">
		     
		    </div>
	    </footer><!--//app-footer-->
	    
    </div><!--//app-wrapper-->    					
	<?php include 'footer.php' ?>