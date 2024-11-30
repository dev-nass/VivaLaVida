<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../php/connection.php';

$input = file_get_contents("php://input");
$userInfo = json_decode($input, true);

$user_id =  $userInfo['userDetail']['userId'];
$user_fname = $userInfo['userDetail']['userFname'];
$user_lname = $userInfo['userDetail']['userLname'];
$user_age = $userInfo['userDetail']['userAge'];
$user_username = $userInfo['userDetail']['userUsername'];
$user_email = $userInfo['userDetail']['userEmail'];
$user_conctact_number = $userInfo['userDetail']['userContactNumber'];
$user_address = $userInfo['userDetail']['userAddress'];

// Check if username or email already exists in `user` (excluding the current user) or `employee`
$checkSql = "
    SELECT Username, Email 
    FROM user 
    WHERE (Username = :username OR Email = :email) AND user_ID != :id
    UNION ALL
    SELECT Username, Email
    FROM employee
    WHERE Username = :username OR Email = :email
";
$checkStmt = $pdo->prepare($checkSql);
$checkStmt->execute([
    ":username" => $user_username,
    ":email" => $user_email,
    ":id" => $user_id
]);

if ($checkStmt->rowCount() > 0) {
    // Username or email already exists
    echo json_encode(['success' => false, 'message' => 'Username or Email already exists!']);
    exit();
}

// Proceed with updating the user information
$sql = "
    UPDATE user
    SET First_Name = :fname, Last_Name = :lname, Age = :age, Username = :username, Email = :email, Contact_Number = :contact_number, Address = :address
    WHERE user_ID = :id
";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":id", $user_id);
$stmt->bindParam(":fname", $user_fname);
$stmt->bindParam(":lname", $user_lname);
$stmt->bindParam(":age", $user_age);
$stmt->bindParam(":username", $user_username);
$stmt->bindParam(":email", $user_email);
$stmt->bindParam(":contact_number", $user_conctact_number);
$stmt->bindParam(":address", $user_address);

if ($stmt->execute()) {
    // Return success response
    $response = [
        'userId' => $user_id,
        'success' => true,
        'message' => 'User successfully updated'
    ];
    echo json_encode($response);
} else {
    // Handle update failure
    echo json_encode(['success' => false, 'message' => 'Failed to update user']);
}

?>
