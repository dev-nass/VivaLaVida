<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../php/connection.php';

$input = file_get_contents("php://input");
$transactionInfo = json_decode($input, true);

$transaction_id =  $transactionInfo['transactionDetail']['transactionId'];





// Updates the customer information
$sql = "DELETE FROM transaction WHERE Transaction_ID = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":id", $transaction_id);


// Execute the archived
if ($stmt->execute()) {
  // Return the success response
  $response = [
    'orderId' => $transaction_id,
    'success' => true,
    'message' => 'Transaction successfully archived'
  ];
  echo json_encode($response);
} else {
  // Handle archived failure
  echo json_encode(['success' => false, 'message' => 'Failed to archived order']);
}


?>