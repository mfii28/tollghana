<?php
session_start();
include './includes/header.php';

// Include your database configuration
$host = 'localhost';
$dbname = "tollgatebooth";
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

// Fetch user data from the user table
$user_id = $_SESSION['user_id'];
$stmt_user = $pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");
$stmt_user->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_user->execute();
$user = $stmt_user->fetch(PDO::FETCH_ASSOC);

// Fetch amount from the transactions table
$stmt_transaction = $pdo->prepare("SELECT amount FROM transactions WHERE user_id = :user_id ORDER BY created_at DESC LIMIT 1");
$stmt_transaction->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_transaction->execute();
$last_transaction = $stmt_transaction->fetch(PDO::FETCH_ASSOC);

$default_amount = $last_transaction ? $last_transaction['amount'] : 0;
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
        width: 80%;
        max-width: 400px;
        transition: box-shadow 0.3s, transform 0.3s;
    }

    form:hover {
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
        transform: scale(1.02);
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
    <?php
    include_once './includes/components/appHeader.php'
    ?>

    <form action="process_payment.php" method="post" target="_blank">
        <label for="payment_method">Select Payment Method:</label>
        <select name="payment_method" id="payment_method">
            <option value="card">Credit Card</option>
            <option value="mobile_money">Mobile Money</option>
        </select>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
        <br>
        <label for="amount">Amount (GH):</label>
        <input type="number" name="amount" value="<?php echo $default_amount; ?>" required>
        <br>
        <div id="momo_fields" style="display:none;">
            <label for="momo_number">Mobile Money Number:</label>
            <input type="text" name="momo_number" required>
            <br>
        </div>
        <input type="hidden" name="hidden_payment_method" id="hidden_payment_method" value="card">
        <br>
        <button type="button" onclick="prepareForm()">Confirm Payment</button>

        <script>
            document.getElementById('payment_method').addEventListener('change', function () {
                var hiddenPaymentMethod = document.getElementById('hidden_payment_method');
                var momoFields = document.getElementById('momo_fields');

                hiddenPaymentMethod.value = this.value;
                momoFields.style.display = (this.value === 'mobile_money') ? 'block' : 'none';
            });

            function prepareForm() {
                document.forms[0].submit();
            }
        </script>
    </form>

    <script>
        function handleSuccessfulPayment() {
            fetch('/update-data-endpoint.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        amount: <?php echo $amount; ?>,
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Data updated successfully:', data);
                    window.location.href = 'dashboard.php';
                })
                .catch(error => {
                    console.error('Error updating data:', error);
                });
        }

        function prepareForm() {
        // Open the form in a new tab
        var form = document.forms[0];
        var formWindow = window.open('', '_blank');
        form.target = '_blank';
        form.action = 'process_payment.php';
        form.submit();

        // After the form is submitted, redirect to dashboard.php
        formWindow.onload = function () {
            formWindow.location.href = 'dashboard.php';
        };
    }
    </script>
    <script>
 
</script>


    <?php include './includes/footer.php' ?>
</body>

</html>
