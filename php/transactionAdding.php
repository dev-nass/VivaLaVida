<?php

include '../php/connection.php';

$input = file_get_contents("php://input"); // receive the data from JS
$guitarOrders = json_decode($input, true);

$amount_due = 0;
$amount_paid = 0;
$change = 0;

$guitarOrderDetails = $guitarOrders['guitarOrders']; // access the ARRAY on orderData
$guitarsTransaction = $guitarOrders['transactionDetails']; // access the JSON on orderData
$newuserInformation = $guitarOrders['userDetail'];


// echo (var_dump($guitarsTransaction)); CAUSED THE SYNTAX ERROR AT COLUMN 1

$individualTransaction = [];

$userId = (int) $newuserInformation['userId'];
$employeeId = (int) $guitarsTransaction['employee_id'];
$amount_due += (float) $guitarsTransaction['amount_due'];
$amount_paid += (float) $guitarsTransaction['amount_paid'];
$change += (float) $guitarsTransaction['sukli'];

// RESPONSIBLE FOR INSERTING NEW TRANSACTION
$sql = "INSERT INTO transaction(User_ID, Employee_ID, Amount_Due, Amount_Paid, Sukli) VALUES (:user_id,:employee_id, :amount_due, :amount_paid, :sukli)";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":user_id", $userId);
$stmt->bindParam(":employee_id", $employeeId);
$stmt->bindParam(":amount_due", $amount_due);
$stmt->bindParam(":amount_paid", $amount_paid);
$stmt->bindParam(":sukli", $change);
$stmt->execute();





// FETCH THE LAST ID (TransactionID)
$transactionId = $pdo->lastInsertId();
if ($transactionId) {
  // Return the TransactionID as a response
  $response = [
    'transactionId' => $transactionId,
    'success' => true,
    'message' => 'Transaction ID successfully retrieved'
  ];
  echo json_encode($response);
} else {
  // Handle insertion failure
  echo json_encode(['success' => false, 'message' => 'Failed to retrieve Transaction ID']);
}






// RESPONSIBLE FOR INSERTING NEW EACH TRANSACTION TO ORDER TABLE BASED ON LAST TRANSACTION ID
foreach ($guitarOrderDetails as $guitarToOrder) {
  $totalPrice = $guitarToOrder['price'] * $guitarToOrder['quantity'];
  
  $sql_v2 = "INSERT INTO urder(Transaction_ID, Guitar_ID, Quantity, Total_Price) VALUES (:transactionId, :guitarId, :quantity, :totalPrice)";
  $stmt_v2 = $pdo->prepare($sql_v2);
  $stmt_v2->bindParam(":transactionId", $transactionId);
  $stmt_v2->bindParam(":guitarId", $guitarToOrder['id']);
  $stmt_v2->bindParam(":quantity", $guitarToOrder['quantity']);
  $stmt_v2->bindParam(":totalPrice", $totalPrice);
  $stmt_v2->execute();
}

