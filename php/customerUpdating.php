<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../php/connection.php';

$input = file_get_contents("php://input");
$userInfo = json_decode($input, true);

$userInformation = $userInfo['userDetail'];

$user_id = $userInformation['userId'];
$user_Fname = $userInformation['user_fname'];
$user_Lname = $userInformation['user_fname'];
$user_email = $userInformation['email'];
$user_number = $userInformation['number'];

// Check and select if the user that has to be update already exist
$checkSql = "SELECT * FROM user WHERE user_ID = :id";
$checkStmt = $pdo->prepare($checkSql);
$checkStmt->bindParam(":id", $user_id);
$checkStmt->execute();


if ($checkStmt->rowCount() > 0) {
  // Updates the user information
  $sql = "UPDATE user SET First_Name = :fname, Last_Name = :lname, Email = :email, Contact_Number = :contact_number WHERE user_ID = :id";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(":id", $user_id);
  $stmt->bindParam(":fname", $user_Fname);
  $stmt->bindParam(":lname", $user_Lname);
  $stmt->bindParam(":email", $user_email);
  $stmt->bindParam(":contact_number", $user_number);

  // Execute the update
  if ($stmt->execute()) {
    // Return the success response
    $response = [
      'userId' => $user_id,
      'success' => true,
      'message' => 'user successfully updated'
    ];
    echo json_encode($response);
  } else {
    // Handle insertion failure
    echo json_encode(['success' => false, 'message' => 'Failed to update user']);
  }



} else {
  echo json_encode(['success' => false, 'message' => 'No existing user']);
}

?>