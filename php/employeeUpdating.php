<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../php/connection.php';

$input = file_get_contents("php://input");
$employeeInfo = json_decode($input, true);

$employee_id =  $employeeInfo['employeeDetail']['employeeId'];
$employee_fname = $employeeInfo['employeeDetail']['employeeFname'];
$employee_lname = $employeeInfo['employeeDetail']['employeeLname'];
$employee_username = $employeeInfo['employeeDetail']['employeeUsername'];
$employee_email = $employeeInfo['employeeDetail']['employeeEmail'];
$employee_conctact_number = $employeeInfo['employeeDetail']['employeeContactNumber'];

// Check if username or email already exists in `employee` (excluding the current employee) or `user`
$checkSql = "
    SELECT Username, Email 
    FROM employee 
    WHERE (Username = :username OR Email = :email) AND Employee_ID != :id
    UNION ALL
    SELECT Username, Email
    FROM user
    WHERE Username = :username OR Email = :email
";
$checkStmt = $pdo->prepare($checkSql);
$checkStmt->execute([
    ":username" => $employee_username,
    ":email" => $employee_email,
    ":id" => $employee_id
]);

if ($checkStmt->rowCount() > 0) {
    // Username or email already exists
    echo json_encode(['success' => false, 'message' => 'Username or Email already exists!']);
    exit();
}

// Proceed with updating the employee information
$sql = "
    UPDATE employee
    SET First_Name = :fname, Last_Name = :lname, Username = :username, Email = :email, Contact_Number = :contact_number
    WHERE Employee_ID = :id
";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":id", $employee_id);
$stmt->bindParam(":fname", $employee_fname);
$stmt->bindParam(":lname", $employee_lname);
$stmt->bindParam(":username", $employee_username);
$stmt->bindParam(":email", $employee_email);
$stmt->bindParam(":contact_number", $employee_conctact_number);

if ($stmt->execute()) {
    // Return success response
    $response = [
        'employeeId' => $employee_id,
        'success' => true,
        'message' => 'Employee successfully updated'
    ];
    echo json_encode($response);
} else {
    // Handle update failure
    echo json_encode(['success' => false, 'message' => 'Failed to update employee']);
}

?>
