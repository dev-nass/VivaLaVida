<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../php/connection.php';

$input = file_get_contents("php://input");
$userInfo = json_decode($input, true);

$user_id =  $userInfo['userDetail']['userId'];




// Updates the user information
$sql = "DELETE FROM user WHERE User_ID = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":id", $user_id);


// Execute the archived
if ($stmt->execute()) {
  // Return the success response
  $response = [
    'userId' => $user_id,
    'success' => true,
    'message' => 'user successfully archived'
  ];
  echo json_encode($response);
} else {
  // Handle archived failure
  echo json_encode(['success' => false, 'message' => 'Failed to archived user']);
}


?>