<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../php/connection.php';

$input = file_get_contents("php://input");
$orderInfo = json_decode($input, true);

$order_id =  $orderInfo['orderDetail']['orderId'];





// Updates the customer information
$sql = "DELETE FROM urder WHERE Order_ID = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":id", $order_id);


// Execute the archived
if ($stmt->execute()) {
  // Return the success response
  $response = [
    'orderId' => $order_id,
    'success' => true,
    'message' => 'Order successfully archived'
  ];
  echo json_encode($response);
} else {
  // Handle archived failure
  echo json_encode(['success' => false, 'message' => 'Failed to archived order']);
}


?>