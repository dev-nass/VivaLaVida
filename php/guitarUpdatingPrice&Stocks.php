<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../php/connection.php';

$input = file_get_contents("php://input");
$guitarInfo = json_decode($input, true);

$guitar_id =  $guitarInfo['guitarDetail']['guitarId'];
$guitar_price = $guitarInfo['guitarDetail']['guitarPrice'];
(float) $guitar_stocks = $guitarInfo['guitarDetail']['guitarStocks'];





// Updates the customer information
$sql = "UPDATE guitar
        SET Price = :price, Stocks = :stocks
        WHERE GuitarID = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":price", $guitar_price);
$stmt->bindParam(":stocks", $guitar_stocks);
$stmt->bindParam(":id", $guitar_id);


// Execute the archived
if ($stmt->execute()) {
  // Return the success response
  $response = [
    'guitarId' => $guitar_id,
    'success' => true,
    'message' => 'Guitar successfully archived'
  ];
  echo json_encode($response);
} else {
  // Handle archived failure
  echo json_encode(['success' => false, 'message' => 'Failed to archived guitar']);
}


?>