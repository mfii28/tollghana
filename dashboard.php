<?php
session_start();
include './includes/header.php';

// Include your database configuration
include_once './config/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT full_name FROM users WHERE user_id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $full_name = $row['full_name'];
} else {
    $full_name = 'User';
}

 


 


    // Fetch the QR code image path for the user from the qrcodes table
    $qrcodeQuery = "SELECT qr_code_image_path FROM qrcodes WHERE user_id = ?";
    $stmt = $conn->prepare($qrcodeQuery);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $qrcodeResult = $stmt->get_result();

    if ($qrcodeResult->num_rows > 0) {
        $qrcode_row = $qrcodeResult->fetch_assoc();
        $qrcode_img_path = $qrcode_row['qr_code_image_path'];
        $img_src = $qrcode_img_path;
    } else {
        // Handle the case where the user or QR code is not found
        $img_src = "path/to/default/image.jpg"; // Replace with a default image path
    }
 



?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">


    <style>
    
    .road-safety-carousel {
        margin-top: 20px; /* Adjust spacing as needed */
    }

    .road-safety-tip {
        background-color: #f0f0f0;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 15px;
        font-size: 16px;
        line-height: 1.6;
    }

    </style>

 
<body class="app">  
	 	<!-- Preloader -->
<div id="preloader">
<div id="loader"></div>
</div>
    <?php
        include_once './includes/components/appHeader.php'
    ?>     
    <div class="app-wrapper">
	    
	    <div class="app-content pt-3 p-md-3 p-lg-4">
		    <div class="container-xl">
			    
			    <h1 class="app-page-title">Overview</h1>
			    
			    <div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration" role="alert">
				    <div class="inner">
					    <div class="app-card-body p-3 p-lg-4">
						<h3 class="mb-3">Welcome, <?php echo strtoupper($full_name); ?>!</h3>
                        <div class="">
                        
                        <button type="button" class="btn-sm app-btn-secondary" data-bs-toggle="modal" data-bs-target="#viewQrCodeModal">View My QrCode</button>

<!-- Bootstrap Modal for Viewing QR Code -->
<div class="modal fade" id="viewQrCodeModal" tabindex="-1" aria-labelledby="viewQrCodeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewQrCodeModalLabel">Your QR Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="qrcodeImageContainer">
                <img src="user_qrcodes/user_<?php echo htmlspecialchars($user_id); ?>.png" alt="QR Code Image" style="width: 450px; height: 450px;">

                <div class="text-center mt-3">
                    <button type="button" class="btn btn-primary" onclick="printQRCode()">Print QR Code</button>
                </div>
            </div>
        </div>
    </div>
</div>

                    </div>
						    <div class="row gx-5 gy-5">
							<div class="col-12 col-lg-9">
   
    <div class="owl-carousel road-safety-carousel">
        <div class="road-safety-tip p-5 mt-2">
            <strong >Road Safety Tip 1:</strong> Always wear your seatbelt and ensure all passengers do the same.
        </div>
        <div class="road-safety-tip p-5 mt-2">
            <strong >Road Safety Tip 2:</strong> Avoid using mobile phones while driving to minimize distractions.
        </div>
        <div class="road-safety-tip p-5 mt-2">
            <strong >Road Safety Tip 3:</strong> Follow speed limits and adjust your speed based on road conditions.
        </div>
        <div class="road-safety-tip p-5 mt-2">
            <strong >Road Safety Tip 4:</strong> Keep a safe following distance from the vehicle in front of you.
        </div>
        <div class="road-safety-tip p-5 mt-2">
            <strong >Road Safety Tip 5:</strong> Obey traffic signals, including stop signs, lights, and yield signs.
        </div>
        <div class="road-safety-tip p-5 mt-2">
            <strong >Road Safety Tip 6:</strong> Avoid distracted driving – no texting or eating while driving.
        </div>
        <div class="road-safety-tip p-5 mt-2">
            <strong >Road Safety Tip 7:</strong> Check blind spots before changing lanes or making turns.
        </div>
        <div class="road-safety-tip p-5 mt-2">
            <strong >Road Safety Tip 8:</strong> Use turn signals to indicate your intentions to other drivers.
        </div>
        <div class="road-safety-tip p-5 mt-2">
            <strong >Road Safety Tip 9:</strong> Be mindful of pedestrians and cyclists, especially in urban areas.
        </div>
        <div class="road-safety-tip p-5 mt-2">
            <strong >Road Safety Tip 10:</strong> Adjust your driving to weather conditions, and ensure regular vehicle maintenance.
        </div>
    </div>
</div><!--//col-->

<div class="container-fluid">
    <!-- Your content goes here -->
    <script src="https://static.elfsight.com/platform/platform.js" data-use-service-core defer></script>
    <div class="elfsight-app-551166b7-4868-44cf-8f7f-1a84e8e4f1c6" data-elfsight-app-lazy></div>
</div>
</div><!--//col-->
<!--//row-->
						    <!-- </div>
						    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					    </div> -->
						<!--//app-card-body-->
					    
				    </div><!--//inner-->
			    </div><!--//app-card-->
				    
  
				<script>


if ("<?php echo $error; ?>" !== "") {
    alert("<?php echo $error; ?>");
  }

  document.addEventListener("DOMContentLoaded", function () {
    // Simulate delay (you can replace this with the actual time-consuming operations)
    setTimeout(function () {
        // Hide the preloader
        document.getElementById("preloader").style.display = "none";
        
        // Show the content
        document.querySelector(".content").style.display = "block";
    }, 2000); // Replace 2000 with the actual time it takes to load your content
});
					
/* ===== Enable Bootstrap Popover (on element  ====== */
const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))

  /* ==== Enable Bootstrap Alert ====== */
 var alertList = document.querySelectorAll('.alert')
 alertList.forEach(function (alert) {
 new bootstrap.Alert(alert)
 });

const alertList = document.querySelectorAll('.alert')
const alerts = [...alertList].map(element => new bootstrap.Alert(element))


/* ===== Responsive Sidepanel ====== */
const sidePanelToggler = document.getElementById('sidepanel-toggler'); 
const sidePanel = document.getElementById('app-sidepanel');  
const sidePanelDrop = document.getElementById('sidepanel-drop'); 
const sidePanelClose = document.getElementById('sidepanel-close'); 

window.addEventListener('load', function(){
	responsiveSidePanel(); 
});

window.addEventListener('resize', function(){
	responsiveSidePanel(); 
});


function responsiveSidePanel() {
    let w = window.innerWidth;
	if(w >= 1200) {
	    // if larger 
	    //console.log('larger');
		sidePanel.classList.remove('sidepanel-hidden');
		sidePanel.classList.add('sidepanel-visible');
		
	} else {
	    // if smaller
	    //console.log('smaller');
	    sidePanel.classList.remove('sidepanel-visible');
		sidePanel.classList.add('sidepanel-hidden');
	}
};

sidePanelToggler.addEventListener('click', () => {
	if (sidePanel.classList.contains('sidepanel-visible')) {
		console.log('visible');
		sidePanel.classList.remove('sidepanel-visible');
		sidePanel.classList.add('sidepanel-hidden');
		
	} else {
		console.log('hidden');
		sidePanel.classList.remove('sidepanel-hidden');
		sidePanel.classList.add('sidepanel-visible');
	}
});



sidePanelClose.addEventListener('click', (e) => {
	e.preventDefault();
	sidePanelToggler.click();
});

sidePanelDrop.addEventListener('click', (e) => {
	sidePanelToggler.click();
});



  if ("<?php echo $error; ?>" !== "") {
    alert("<?php echo $error; ?>");
  }

  document.addEventListener("DOMContentLoaded", function () {
    // Simulate delay (you can replace this with the actual time-consuming operations)
    setTimeout(function () {
        // Hide the preloader
        document.getElementById("preloader").style.display = "none";
        
        // Show the content
        document.querySelector(".content").style.display = "block";
    }, 2000); // Replace 2000 with the actual time it takes to load your content
});

				</script>
 


        <?php include './includes/footer.php' ?>
<!-- Add this script before the closing body tag -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
                <script>
                    $(document).ready(function () {
                        $(".road-safety-carousel").owlCarousel({
                            loop: true,
                            margin: 10,
                            nav: false,
                            items: 1,
                            autoplay: true,
                            autoplayTimeout: 7000, // Adjust the timeout as needed
                             
                        });
                    });
                </script>






<script>
document.getElementById('generateQrCodeBtn').addEventListener('click', function() {
    // Make an AJAX request to generate QR code
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var imagePath = xhr.responseText;
            // Update modal content with the generated QR code
            document.getElementById('qrcodeImageContainer').innerHTML = '<img src="' + imagePath + '" alt="QR Code Image" style="width: 450px; height: 450px;">';
        }
    };
    xhr.open('GET', 'generateQrCode.php', true);
    xhr.send();
});
</script>

<script>
    function printQRCode() {
        // Select the modal body content
        var qrCodeImage = document.getElementById('qrcodeImageContainer').getElementsByTagName('img')[0].outerHTML;
        var userName = "<?php echo $full_name; ?>"; // Assuming $full_name is the variable holding the user's name

        // Open a new window for printing
        var printWindow = window.open('', '_blank');
        
        // Write the content to the new window
        printWindow.document.write('<html><head><title>Print QR Code</title></head><body>');
        printWindow.document.write('<div style="text-align: center;">' + '<img src="logo.png" alt="Logo" style="width: 100px; height: 100px;">' + '</div>');
        printWindow.document.write('<div style="text-align: center;">' + qrCodeImage + '</div>');
        printWindow.document.write('<div style="text-align: center; margin-top: 10px;">' + userName + '</div>');
        printWindow.document.write('</body></html>');

        // Close the document stream
        printWindow.document.close();

        // Trigger the print dialog
        printWindow.print();
    }
</script>