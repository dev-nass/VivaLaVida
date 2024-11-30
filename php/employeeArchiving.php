<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../php/connection.php';

$input = file_get_contents("php://input");
$employeeInfo = json_decode($input, true);

$employee_id =  $employeeInfo['employeeDetail']['employeeId'];




// Updates the employee information
$sql = "DELETE FROM employee WHERE Employee_ID = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":id", $employee_id);


// Execute the archived
if ($stmt->execute()) {
  // Return the success response
  $response = [
    'employeeId' => $employee_id,
    'success' => true,
    'message' => 'employee successfully archived'
  ];
  echo json_encode($response);
} else {
  // Handle archived failure
  echo json_encode(['success' => false, 'message' => 'Failed to archived employee']);
}


?>