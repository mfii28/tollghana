<?php
session_start();
include './includes/header.php';

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
 
?>

 
<body class="app">   	
	<?php
        include_once './includes/components/appHeader.php'
    ?>  

    
    <div class="app-wrapper">
	    
	    <div class="app-content pt-3 p-md-3 p-lg-4">
		    <div class="container-xl">
			    
			    <h1 class="app-page-title">Help Center</h1>
                <div class="app-card app-card-accordion shadow-sm mb-4">
				    <div class="app-card-header p-4 pb-2  border-0">
				       <h4 class="app-card-title">Product</h4>
				    </div><!--//app-card-header-->
				    <div class="app-card-body p-4 pt-0">
					    <div id="faq1-accordion" class="faq1-accordion faq-accordion accordion">
						    
						<div class="accordion-item">
    <h2 class="accordion-header" id="faq-subscription-heading">
        <button class="accordion-button btn btn-link" type="button" data-bs-toggle="collapse"  data-bs-target="#faq-subscription" aria-expanded="false" aria-controls="faq-subscription">
            How does the subscription for toll booth payments work?
        </button>
    </h2>
    <div id="faq-subscription" class="accordion-collapse collapse border-0" aria-labelledby="faq-subscription-heading">
        <div class="accordion-body text-start p-4">
            Our toll booth payment platform offers a convenient subscription model for users. With a subscription, you can enjoy seamless access to toll booths without the need for manual payments for each use.

            <p>
                <strong>Subscription Plans:</strong> We offer different subscription plans to cater to various user needs. Whether you are an occasional user or a frequent traveler, we have plans that suit your requirements.
            </p>

            <p>
                <strong>Payment Methods:</strong> You can subscribe and pay for your chosen plan using two main payment methods:
                <ul>
                    <li><strong>Credit Card:</strong> Securely pay for your subscription using your credit card. We support major credit cards for a hassle-free transaction.</li>
                    <li><strong>Mobile Money (MOMO):</strong> Simplify your payments by using mobile money services. Easily link your mobile money account for quick and efficient transactions.</li>
                </ul>
            </p>

            <p>
                <strong>How to Subscribe:</strong> Follow these simple steps to subscribe to a plan:
                <ol>
                    <li>Log in to your account or sign up if you are a new user.</li>
                    <li>Navigate to the Subscription section.</li>
                    <li>Choose the plan that best suits your needs.</li>
                    <li>Select your preferred payment method (Credit Card or MOMO).</li>
                    <li>Complete the payment process.</li>
                </ol>
            </p>

            <p>
                <strong>Benefits of Subscription:</strong> Subscribers enjoy benefits such as faster toll booth access, discounts, and exclusive offers. Experience the convenience of a seamless toll payment system with our subscription plans.
            </p>
        </div>
    </div>
</div><!--//accordion-item-->

						    
<div class="accordion-item">
    <h2 class="accordion-header" id="faq-security-heading">
        <button class="accordion-button btn btn-link" type="button" data-bs-toggle="collapse"  data-bs-target="#faq-security" aria-expanded="false" aria-controls="faq-security">
            How can I ensure the security of my toll booth payment account?
        </button>
    </h2>
    <div id="faq-security" class="accordion-collapse collapse border-0" aria-labelledby="faq-security-heading">
        <div class="accordion-body text-start p-4">
            At TollGH, we prioritize the security of your account information. Here are some key tips and features to help you ensure the safety of your toll booth payment account:

            <p>
                <strong>1. Strong Password:</strong> Create a strong and unique password for your account. Include a mix of uppercase and lowercase letters, numbers, and special characters to enhance security.
            </p>

            <p>
                <strong>2. Two-Factor Authentication (2FA):</strong> Enable 2FA for an extra layer of security. This adds an additional step to the login process, usually involving a verification code sent to your registered mobile device.
            </p>

            <p>
                <strong>3. Regular Password Updates:</strong> Change your password periodically to reduce the risk of unauthorized access. Avoid using easily guessable passwords and refrain from sharing your password with others.
            </p>

            <p>
                <strong>4. Account Activity Monitoring:</strong> Keep an eye on your account activity. If you notice any suspicious or unfamiliar transactions, report them to our support team immediately.
            </p>

            <p>
                <strong>5. Update Contact Information:</strong> Ensure that your email address and phone number associated with your account are up to date. This allows us to notify you promptly of any account-related activities.
            </p>

            <p>
                <strong>6. Account Recovery:</strong> Familiarize yourself with the account recovery process. In case you forget your password or encounter login issues, our platform provides secure account recovery options.
            </p>

            <p>
                <strong>7. Avoid Public Devices:</strong> Refrain from accessing your toll booth payment account from public or shared devices. Use secure and trusted devices to log in and make transactions.
            </p>

            <p>
                <strong>8. Logout After Sessions:</strong> Always log out of your account after completing your toll booth transactions. This ensures that your account remains secure, especially on shared computers.
            </p>

            <p>
                If you have any further questions or concerns about the security of your account, feel free to reach out to our support team through the <a href="#contact-us">Contact Us</a> section.
            </p>
        </div>
    </div>
</div><!--//accordion-item-->

						    
						    
<div class="accordion-item">
    <h2 class="accordion-header" id="faq-subscription-heading">
        <button class="accordion-button btn btn-link" type="button" data-bs-toggle="collapse"  data-bs-target="#faq-subscription" aria-expanded="false" aria-controls="faq-subscription">
            How do I subscribe to a plan on TollGH?
        </button>
    </h2>
    <div id="faq-subscription" class="accordion-collapse collapse border-0" aria-labelledby="faq-subscription-heading">
        <div class="accordion-body text-start p-4">
            Subscribing to a plan on TollGH is a simple process. Follow these steps to get started:

            <p>
                <strong>1. Explore Subscription Plans:</strong> Visit the "Subscription Plans" section on our platform to explore the available plans. Each plan comes with unique features and pricing, catering to different user needs.
            </p>

            <p>
                <strong>2. Select Your Preferred Plan:</strong> Once you've reviewed the available plans, choose the one that best suits your requirements. Click on the plan to view more details, including the benefits it offers.
            </p>

            <p>
                <strong>3. Check Plan Details:</strong> Review the plan details, including the pricing, benefits, and any special features. Make sure the plan aligns with your usage and preferences.
            </p>

            <p>
                <strong>4. Subscribe to the Plan:</strong> After deciding on a plan, click on the "Subscribe Now" or similar button. You'll be directed to a secure checkout page where you can confirm your subscription.
            </p>

            <p>
                <strong>5. Provide Payment Information:</strong> Enter your payment details, whether it's credit card information or mobile money, to complete the subscription process. TollGH ensures a secure payment experience.
            </p>

            <p>
                <strong>6. Confirmation and Activation:</strong> Once the payment is successful, you'll receive a confirmation of your subscription. Your plan will be activated immediately, and you can start enjoying the benefits.
            </p>

            <p>
                <strong>7. Manage Subscriptions:</strong> In your account settings, you can view and manage your active subscriptions. This includes checking the renewal date, upgrading or downgrading plans, or canceling subscriptions.
            </p>

            <p>
                If you have any questions or encounter issues during the subscription process, feel free to contact our support team through the <a href="#contact-us">Contact Us</a> section for assistance.
            </p>
        </div>
    </div>
</div><!--//accordion-item-->

							<div class="accordion-item">
							    <h2 class="accordion-header" id="faq1-heading-4">
							      <button class="accordion-button btn btn-link" type="button" data-bs-toggle="collapse"  data-bs-target="#faq1-4" aria-expanded="false" aria-controls="faq1-4">
							        Can I raw denim aesthetic synth nesciunt?
							      </button>
							    </h2>
							    <div id="faq1-4" class="accordion-collapse collapse border-0" aria-labelledby="faq1-heading-4">
							        <div class="accordion-body text-start p4">
							            Anim pariatur cliche reprehenderit, enim eiusmod high life
	                                    accusamus terry richardson ad squid. 3 wolf moon officia
	                                    aute, non cupidatat skateboard dolor brunch. Food truck
	                                    quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor,
	                                    sunt aliqua put a bird on it squid single-origin coffee
	                                    nulla assumenda shoreditch et. Nihil anim keffiyeh
	                                    helvetica, craft beer labore wes anderson cred nesciunt
	                                    sapiente ea proident. Ad vegan excepteur butcher vice lomo.
	                                    Leggings occaecat craft beer farm-to-table, raw denim
	                                    aesthetic synth nesciunt you probably haven't heard of them
	                                    accusamus labore sustainable VHS.
							        </div>
							    </div>
							</div><!--//accordion-item-->
							
							<div class="accordion-item">
    <h2 class="accordion-header" id="faq-security-heading">
        <button class="accordion-button btn btn-link" type="button" data-bs-toggle="collapse"  data-bs-target="#faq-security" aria-expanded="false" aria-controls="faq-security">
            How secure is TollGH for online transactions?
        </button>
    </h2>
    <div id="faq-security" class="accordion-collapse collapse border-0" aria-labelledby="faq-security-heading">
        <div class="accordion-body text-start p-4">
            At TollGH, the security of your online transactions is our top priority. Here are some key measures we take to ensure a secure experience:

            <p>
                <strong>SSL Encryption:</strong> We use industry-standard SSL encryption to protect the communication between your browser and our servers. This ensures that your personal and financial information remains confidential.
            </p>

            <p>
                <strong>Secure Payment Gateways:</strong> Our platform integrates with trusted and secure payment gateways. Whether you choose credit card payments or mobile money, your transactions are processed securely.
            </p>

            <p>
                <strong>Strict Data Protection:</strong> We adhere to strict data protection regulations. Your personal information is handled with the utmost confidentiality, and we do not share it with third parties without your consent.
            </p>

            <p>
                <strong>Fraud Prevention:</strong> We employ advanced fraud prevention mechanisms to detect and prevent unauthorized activities. Our systems continuously monitor transactions for any unusual patterns.
            </p>

            <p>
                <strong>Regular Security Audits:</strong> Our platform undergoes regular security audits and assessments to identify and address potential vulnerabilities. We stay updated with the latest security standards.
            </p>

            <p>
                If you have specific security concerns or encounter any suspicious activity, please contact our support team immediately through the <a href="#contact-us">Contact Us</a> section.
            </p>
        </div>
    </div>
</div><!--//accordion-item-->

							
<div class="accordion-item">
    <h2 class="accordion-header" id="faq-compatibility-heading">
        <button class="accordion-button btn btn-link" type="button" data-bs-toggle="collapse"  data-bs-target="#faq-compatibility" aria-expanded="false" aria-controls="faq-compatibility">
            What devices are compatible with TollGH?
        </button>
    </h2>
    <div id="faq-compatibility" class="accordion-collapse collapse border-0" aria-labelledby="faq-compatibility-heading">
        <div class="accordion-body text-start p-4">
            TollGH is designed to be accessible and user-friendly across various devices. Here's a quick overview of device compatibility:

            <p>
                <strong>Web Browsers:</strong> You can access TollGH through popular web browsers such as Google Chrome, Mozilla Firefox, Safari, and Microsoft Edge. Ensure you are using the latest browser version for the best experience.
            </p>

            <p>
                <strong>Mobile Devices:</strong> Our platform is mobile-responsive, making it compatible with smartphones and tablets. Whether you use an iOS or Android device, you can conveniently access TollGH on the go.
            </p>

            <p>
                <strong>Desktop Computers:</strong> Enjoy the full features of TollGH on desktop computers and laptops. The platform is optimized for different screen sizes, providing a seamless experience on larger screens.
            </p>

            <p>
                <strong>Operating Systems:</strong> TollGH is compatible with major operating systems, including Windows, macOS, iOS, and Android. Ensure your device is running a supported operating system for optimal performance.
            </p>

            <p>
                If you encounter any issues related to device compatibility or have specific questions about your device, feel free to reach out to our support team through the <a href="#contact-us">Contact Us</a> section.
            </p>
        </div>
    </div>
</div><!--//accordion-item-->

							</div><!--//accordion-item-->
							                  
	                    </div><!--//faq1-accordion-->
				    </div><!--//app-card-body-->
				</div><!--//app-card-->
			    <div class="app-card app-card-accordion shadow-sm mb-4">
				    <div class="app-card-header p-3">
				       <h4 class="app-card-title">Account</h4>
				    </div><!--//app-card-header-->
				    <div class="app-card-body p-4 pt-0">
					    <div id="faq2-accordion" class="faq2-accordion faq-accordion accordion">
						<div class="accordion-item">
    <h2 class="accordion-header" id="faq-create-account-heading">
        <button class="accordion-button btn btn-link" type="button" data-bs-toggle="collapse"  data-bs-target="#faq-create-account" aria-expanded="false" aria-controls="faq-create-account">
            How do I create an account on TollGH?
        </button>
    </h2>
    <div id="faq-create-account" class="accordion-collapse collapse border-0" aria-labelledby="faq-create-account-heading">
        <div class="accordion-body text-start p-4">
            Creating an account on TollGH is quick and straightforward. Follow these steps to get started:

            <ol>
                <li>Visit our website at [Your Platform URL].</li>
                <li>Click on the "Sign Up" or "Create Account" button.</li>
                <li>Fill in the required information, including your email address, password, and other relevant details.</li>
                <li>Verify your email address by clicking on the confirmation link sent to your inbox.</li>
                <li>Once verified, log in to your new account and start exploring the features of TollGH.</li>
            </ol>

            <p>
                If you encounter any issues during the account creation process, please refer to our <a href="#faq-contact">Contact Us</a> section for assistance.
            </p>
        </div>
    </div>
</div><!--//accordion-item-->

						    
<div class="accordion-item">
    <h2 class="accordion-header" id="faq-update-info-heading">
        <button class="accordion-button btn btn-link" type="button" data-bs-toggle="collapse"  data-bs-target="#faq-update-info" aria-expanded="false" aria-controls="faq-update-info">
            How can I update my account information on TollGH?
        </button>
    </h2>
    <div id="faq-update-info" class="accordion-collapse collapse border-0" aria-labelledby="faq-update-info-heading">
        <div class="accordion-body text-start p-4">
            Keeping your account information up-to-date is important. Here's how you can update your details:

            <ol>
                <li>Log in to your TollGH account.</li>
                <li>Navigate to the "Account Settings" or "Profile" section.</li>
                <li>Update the relevant information, such as email address, contact details, or any other fields.</li>
                <li>Save the changes to apply the updated information to your account.</li>
            </ol>

            <p>
                If you encounter any difficulties or have specific questions about updating your account, please contact our <a href="#faq-contact">customer support</a>.
            </p>
        </div>
    </div>
</div><!--//accordion-item-->

			
							                     
	                    </div><!--//faq2-accordion-->
				    </div><!--//app-card-body-->
				</div><!--//app-card-->
				<div class="app-card app-card-accordion shadow-sm mb-4">
				    <div class="app-card-header p-3">
				       <h4 class="app-card-title">Payment</h4>
				    </div><!--//app-card-header-->
				    <div class="app-card-body p-4 pt-0">
					    <div id="faq3-accordion" class="faq3-accordion faq-accordion accordion">
                            <div class="accordion-item">
							    <h2 class="accordion-header" id="faq3-heading-1">
							      <button class="accordion-button btn btn-link" type="button" data-bs-toggle="collapse"  data-bs-target="#faq3-1" aria-expanded="false" aria-controls="faq3-1">
							        How to vegan excepteur butcher vice lomo?
							      </button>
							    </h2>
							    <div id="faq3-1" class="accordion-collapse collapse border-0" aria-labelledby="faq3-heading-1">
							        <div class="accordion-body text-start p4">
							            Anim pariatur cliche reprehenderit, enim eiusmod high life
	                                    accusamus terry richardson ad squid. 3 wolf moon officia
	                                    aute, non cupidatat skateboard dolor brunch. Food truck
	                                    quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor,
	                                    sunt aliqua put a bird on it squid single-origin coffee
	                                    nulla assumenda shoreditch et. Nihil anim keffiyeh
	                                    helvetica, craft beer labore wes anderson cred nesciunt
	                                    sapiente ea proident. Ad vegan excepteur butcher vice lomo.
	                                    Leggings occaecat craft beer farm-to-table, raw denim
	                                    aesthetic synth nesciunt you probably haven't heard of them
	                                    accusamus labore sustainable VHS.
							        </div>
							    </div>
							</div><!--//accordion-item-->
						    
						    <div class="accordion-item">
							    <h2 class="accordion-header" id="faq3-heading-2">
							      <button class="accordion-button btn btn-link" type="button" data-bs-toggle="collapse"  data-bs-target="#faq3-2" aria-expanded="false" aria-controls="faq3-2">
							        Can I raw denim aesthetic synth nesciunt?
							      </button>
							    </h2>
							    <div id="faq3-2" class="accordion-collapse collapse border-0" aria-labelledby="faq3-heading-2">
							        <div class="accordion-body text-start p4">
							            Anim pariatur cliche reprehenderit, enim eiusmod high life
	                                    accusamus terry richardson ad squid. 3 wolf moon officia
	                                    aute, non cupidatat skateboard dolor brunch. Food truck
	                                    quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor,
	                                    sunt aliqua put a bird on it squid single-origin coffee
	                                    nulla assumenda shoreditch et. Nihil anim keffiyeh
	                                    helvetica, craft beer labore wes anderson cred nesciunt
	                                    sapiente ea proident. Ad vegan excepteur butcher vice lomo.
	                                    Leggings occaecat craft beer farm-to-table, raw denim
	                                    aesthetic synth nesciunt you probably haven't heard of them
	                                    accusamus labore sustainable VHS.
							        </div>
							    </div>
							</div><!--//accordion-item-->
                                                                              
	                    </div><!--//faq3-accordion-->
				    </div><!--//app-card-body-->
				</div><!--//app-card-->
				
				<div class="row g-4">
					<div class="col-12 col-md-6">
						<div class="app-card app-card-basic d-flex flex-column align-items-start shadow-sm">
						    <div class="app-card-header p-3 border-bottom-0">
						        <div class="row align-items-center gx-3">
							        <div class="col-auto">
								        <div class="app-icon-holder icon-holder-mono">
										    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-headset" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M8 1a5 5 0 0 0-5 5v4.5H2V6a6 6 0 1 1 12 0v4.5h-1V6a5 5 0 0 0-5-5z"/>
  <path d="M11 8a1 1 0 0 1 1-1h2v4a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1V8zM5 8a1 1 0 0 0-1-1H2v4a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1V8z"/>
  <path fill-rule="evenodd" d="M13.5 8.5a.5.5 0 0 1 .5.5v3a2.5 2.5 0 0 1-2.5 2.5H8a.5.5 0 0 1 0-1h3.5A1.5 1.5 0 0 0 13 12V9a.5.5 0 0 1 .5-.5z"/>
  <path d="M6.5 14a1 1 0 0 1 1-1h1a1 1 0 1 1 0 2h-1a1 1 0 0 1-1-1z"/>
</svg>
									    </div><!--//icon-holder-->
						                
							        </div><!--//col-->
							        <div class="col-auto">
								        <h4 class="app-card-title">Need more help?</h4>
							        </div><!--//col-->
						        </div><!--//row-->
						    </div><!--//app-card-header-->
						    <div class="app-card-body px-4">
							    
							    <div class="intro mb-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam aliquet eros vel diam semper mollis.</div>
							    <ul class="list-unstyled">
								    <li><strong>Tel:</strong> 0800 1234 5678</li>
								    <li><strong>Email:</strong> <a href="#">support@website.com</a></li>
							    </ul>
						    </div><!--//app-card-body-->
						    <div class="app-card-footer p-4 mt-auto">
							   <a class="btn app-btn-secondary" href="#">Start Live Chat</a>
						    </div><!--//app-card-footer-->
						</div><!--//app-card-->
					</div><!--//col-->
					<div class="col-12 col-md-6">
						<div class="app-card app-card-basic d-flex flex-column align-items-start shadow-sm">
						    <div class="app-card-header p-3 border-bottom-0">
						        <div class="row align-items-center gx-3">
							        <div class="col-auto">
								        <div class="app-icon-holder icon-holder-mono">
										    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-life-preserver" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M14.43 10.772l-2.788-1.115a4.015 4.015 0 0 1-1.985 1.985l1.115 2.788a7.025 7.025 0 0 0 3.658-3.658zM5.228 14.43l1.115-2.788a4.015 4.015 0 0 1-1.985-1.985L1.57 10.772a7.025 7.025 0 0 0 3.658 3.658zm9.202-9.202a7.025 7.025 0 0 0-3.658-3.658L9.657 4.358a4.015 4.015 0 0 1 1.985 1.985l2.788-1.115zm-8.087-.87L5.228 1.57A7.025 7.025 0 0 0 1.57 5.228l2.788 1.115a4.015 4.015 0 0 1 1.985-1.985zM8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm0-5a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
</svg>
									    </div><!--//icon-holder-->
						                
							        </div><!--//col-->
							        <div class="col-auto">
								        <h4 class="app-card-title">Want to upgrade?</h4>
							        </div><!--//col-->
						        </div><!--//row-->
						    </div><!--//app-card-header-->
						    <div class="app-card-body px-4">
							    
							    <div class="intro mb-3">Quisque non nisi odio. Proin at viverra enim. Ut vitae ligula neque. Praesent id ligula ut sem suscipit eleifend id vel ex.</div>
							    <ul class="list-unstyled">
								    <li>
									    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check2 text-primary me-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
	  <path fill-rule="evenodd" d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
	</svg> 
                                        Phasellus varius vel risus vel aliquam.
                                    </li>
                                    <li>
									    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check2 text-primary me-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
	  <path fill-rule="evenodd" d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
	</svg> 
                                        Maecenas varius nulla.
                                    </li>
                                     <li>
									    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check2 text-primary me-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
	  <path fill-rule="evenodd" d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
	</svg> 
                                        Lorem ipsum dolor sit amet.
                                    </li>

							    </ul>
						    </div><!--//app-card-body-->
						    <div class="app-card-footer p-4 mt-auto">
							   <a class="btn app-btn-primary" href="#">Upgrade Now</a>
						    </div><!--//app-card-footer-->
						</div><!--//app-card-->
					</div><!--//col-->
				</div><!--//row-->
			    
		    </div><!--//container-fluid-->
	    </div><!--//app-content-->
	    
	    <footer class="app-footer">
		    <div class="container text-center py-3">
		           
		    </div>
	    </footer><!--//app-footer-->
	    
    </div><!--//app-wrapper-->    					

 
   		 
			 
	   
	    
		<?php include './includes/footer.php' ?>



 

