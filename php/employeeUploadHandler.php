<?php

include "../php/connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    // gets the inputs by their names
    $fname = $_POST["employee_fname"];
    $lname = $_POST["employee_lname"];
    $username = $_POST['employee_username'];
    $email = $_POST["employee_email"];
    $contact_number = $_POST["employee_contact_number"];
    $password = $_POST["employee_password"];

    // pass encryption
    $hashPassword = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));



    $checkEmployeeSql = "SELECT Username, Email, Contact_Number
                        FROM employee 
                        WHERE Username = :username OR Contact_Number = :contact_number OR Email = :email
                        UNION ALL
                        SELECT Username, Email, Contact_Number
                        FROM user
                        Where Username = :username OR Contact_Number = :contact_number OR Email = :email";
    $checkStmt = $pdo->prepare($checkEmployeeSql);
    $checkStmt->execute([
      ":username" => $username,
      ":email" => $email,
      ":contact_number" => $contact_number,
    ]);

    if($checkStmt->rowCount() > 0) {
      echo json_encode([
        'status' => 'error', // Changed to 'error' for consistency
        'message' => 'Employee already exist'
      ]);
    } else {
      // insert into database
      $sql = "INSERT INTO employee (First_Name, Last_Name, Username, Email, Contact_Number, Password) VALUES (:fname, :lname, :username, :email, :contact, :password)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([
        ":fname" => $fname,
        ":lname" => $lname,
        ":username" => $username,
        ":email" => $email,
        ":contact" => $contact_number,
        ":password" => $hashPassword
      ]);

      echo json_encode([
        'status' => 'success',
        'message' => 'Employee has been added successfully.'
      ]);
    } 
  } catch (PDOException $e) {
    echo json_encode([
      'status' => 'error',
      'message' => 'Database error: ' . $e->getMessage()
    ]);
  }
}

?>
