<?php
session_start();
include './includes/header.php';

// Include your database configuration
$host = 'localhost';
$dbname = "tollgatebooth";
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Process the payment form submission

        // Extract and sanitize data from the form
        $paymentMethod = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';
        $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
        $amount = isset($_POST['amount']) ? $_POST['amount'] : null; // Use null instead of 0

        // Additional MoMo fields
        $momoNumber = ($paymentMethod === 'mobile_money') ? (isset($_POST['momo_number']) ? $_POST['momo_number'] : '') : null;

        // Validate the data (add more validation as needed)
        if (empty($paymentMethod) || empty($email) || is_null($amount)) {
            echo "Invalid data. Please check your input.";
            exit();
        }

        // Perform database update
        $stmt = $conn->prepare("UPDATE transactions SET amount = :amount, payment_method = :payment_method, momo_number = :momo_number WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindParam(':amount', $amount, PDO::PARAM_STR | PDO::PARAM_NULL); // Add PDO::PARAM_NULL
        $stmt->bindParam(':payment_method', $paymentMethod, PDO::PARAM_STR);
        $stmt->bindParam(':momo_number', $momoNumber, PDO::PARAM_STR);

        // Execute the statement
        if ($stmt->execute()) {
            // If the update is successful, you can redirect or perform additional actions
            header("Location: deposit.php");
            exit();
        } else {
            // If there's an error with the database update, handle it accordingly
            echo "Error updating payment. Please try again.";
        }
    }

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}
?>


    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h1 {
            color: #007bff;
        }

        form {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 80%; /* Make the form wider */
            max-width: 400px; /* Set a maximum width for responsiveness */
            transition: box-shadow 0.3s, transform 0.3s;
        }

        form:hover {
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
            transform: scale(1.02); /* Add a subtle scale effect on hover */
        }

        label {
            margin-bottom: 12px;
            display: block;
            color: #333;
        }

        input,
        select {
            width: 100%;
            padding: 12px;
            margin-bottom: 24px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 6px;
            transition: border-color 0.3s;
        }


        input:focus,
        select:focus {
            outline: none;
            border-color: #007bff;
        }


        button {
            background-color: #007bff;
            color: #ffffff;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        #momo_fields {
            display: none;
        }

        /* Add a fade-in animation for the form */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        form {
            animation: fadeIn 0.5s ease-out;
        }
    </style>

    <body>
        <?php include_once './includes/components/appHeader.php' ?>

        <form action="processing_script.php" method="post">
    <label for="payment_method">Select Payment Method:</label>
    <select name="payment_method" id="payment_method">
        <option value="card">Credit Card</option>
        <option value="mobile_money">Mobile Money</option>
    </select>
    <br>
    <label for="email">Email:</label>
    <input type="email" name="email" required>
    <br>
    <label for="amount">Amount (GH):</label>
    <input type="number" name="amount" value="1" required>

    <br>
    <!-- Additional MoMo fields -->
    <div id="momo_fields" style="display:none;">
        <label for="momo_number">Mobile Money Number:</label>
        <input type="text" name="momo_number" required>
        <br>
    </div>
    <!-- Hidden field for payment method -->
    <input type="hidden" name="hidden_payment_method" id="hidden_payment_method" value="card">
    <br>
    <button type="submit">Pay Now</button>
</form>

 


 

        <script>
            document.getElementById('payment_method').addEventListener('change', function () {
                var hiddenPaymentMethod = document.getElementById('hidden_payment_method');
                var momoFields = document.getElementById('momo_fields');

                hiddenPaymentMethod.value = this.value;
                momoFields.style.display = (this.value === 'mobile_money') ? 'block' : 'none';
            });

            function prepareForm() {
                // Additional actions before submitting the form, if needed
                document.forms[0].submit();
            }
        </script>

        <?php include './includes/footer.php' ?>
    </body>
    </html>
