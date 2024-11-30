<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../php/connection.php';

$input = file_get_contents("php://input");
$customerInfo = json_decode($input, true);

$newCustomerInformation = $customerInfo['customerDetail'];

$newFname = $newCustomerInformation['customer_fname'];
$newLname = $newCustomerInformation['customer_lname'];
$newEmail = $newCustomerInformation['email'];
$newContactNum = $newCustomerInformation['number'];

// First, check if the email or contact number already exists in the database
$checkSql = "SELECT * FROM customer WHERE (First_Name = :fname AND Last_Name = :lname) OR (Email = :email OR Contact_Number = :contact_number)";
$checkStmt = $pdo->prepare($checkSql);
$checkStmt->bindParam(":fname", $newFname);
$checkStmt->bindParam(":lname", $newLname);
$checkStmt->bindParam(":email", $newEmail);
$checkStmt->bindParam(":contact_number", $newContactNum);
$checkStmt->execute();


if ($checkStmt->rowCount() > 0) {
  // If a record is found, send a response indicating duplication
  echo json_encode(['success' => false, 'message' => 'Name, Email or contact number already exists']);
} else {
  // Proceed with insertion if no duplicates are found
  $sql = "INSERT INTO customer (First_Name, Last_Name, Email, Contact_Number) VALUES (:fname, :lname,:email, :contact_number)";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(":fname", $newFname);
  $stmt->bindParam(":lname", $newLname);
  $stmt->bindParam(":email", $newEmail);
  $stmt->bindParam(":contact_number", $newContactNum);

  // Execute the insertion
  if ($stmt->execute()) {
    // Fetch the last inserted ID (CustomerID)
    $customerId = $pdo->lastInsertId();

    // Return the success response with CustomerID
    $response = [
      'customerId' => $customerId,
      'success' => true,
      'message' => 'Customer successfully added'
    ];
    echo json_encode($response);
  } else {
    // Handle insertion failure
    echo json_encode(['success' => false, 'message' => 'Failed to insert customer']);
  }
}
