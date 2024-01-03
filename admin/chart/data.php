<?php
// Connect to your database (replace these values with your actual database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tollgatebooth";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Query to get subscription count per month and subscription type
$sql = "SELECT MONTH(subscription_date) AS month, subscription_type, COUNT(*) AS subscription_count 
        FROM toll_subscribe 
        GROUP BY MONTH(subscription_date), subscription_type";
$result = $conn->query($sql);

// Prepare data for JavaScript
$data = array('labels' => array(), 'datasets' => array());

while ($row = $result->fetch_assoc()) {
  $month = date("F", mktime(0, 0, 0, $row['month'], 1));
  $data['labels'][] = $month;

  if (!isset($data['datasets'][$row['subscription_type']])) {
    $data['datasets'][$row['subscription_type']] = array(
      'label' => 'Subscription Type ' . $row['subscription_type'],
      'data' => array(),
      'backgroundColor' => 'rgba(' . rand(0, 255) . ', ' . rand(0, 255) . ', ' . rand(0, 255) . ', 0.2)',
      'borderColor' => 'rgba(' . rand(0, 255) . ', ' . rand(0, 255) . ', ' . rand(0, 255) . ', 1)',
      'borderWidth' => 1
    );
  }

  $data['datasets'][$row['subscription_type']]['data'][] = $row['subscription_count'];
}

// Close the database connection
$conn->close();

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
