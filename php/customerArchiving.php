<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../php/connection.php';

$input = file_get_contents("php://input");
$customerInfo = json_decode($input, true);

$customer_id =  $customerInfo['customerDetail']['customerId'];




// Updates the customer information
$sql = "DELETE FROM user WHERE User_ID = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":id", $customer_id);


// Execute the archived
if ($stmt->execute()) {
  // Return the success response
  $response = [
    'userId' => $customer_id,
    'success' => true,
    'message' => 'user successfully archived'
  ];
  echo json_encode($response);
} else {
  // Handle archived failure
  echo json_encode(['success' => false, 'message' => 'Failed to archived user']);
}


?>