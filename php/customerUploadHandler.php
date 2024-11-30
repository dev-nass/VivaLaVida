<?php

include "../php/connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    // gets the inputs by their names
    $fname = $_POST["customer_fname"];
    $lname = $_POST["customer_lname"];
    $username = $_POST['customer_username'];
    $email = $_POST["customer_email"];
    $contact_number = $_POST["customer_contact_number"];
    $password = $_POST["customer_password"];

    // pass encryption
    $hashPassword = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));



    $checkCustomerSql = "SELECT Username, Email, Contact_Number
                        FROM employee 
                        WHERE Username = :username OR Email = :email OR Contact_Number = :cnumber
                        UNION ALL
                        SELECT Username, Email, Contact_Number
                        FROM user
                        Where Username = :username OR Email = :email OR Contact_Number = :cnumber";
    $checkStmt = $pdo->prepare($checkCustomerSql);
    $checkStmt->execute([
      ":username" => $username,
      ":email" => $email,
      ":cnumber" => $contact_number
    ]);

    if($checkStmt->rowCount() > 0) {
      echo json_encode([
        'status' => 'error', // Changed to 'error' for consistency
        'message' => 'Customer already exist'
      ]);
    } else {
      // insert into database
      $sql = "INSERT INTO user (First_Name, Last_Name, Username, Email, Contact_Number, Password) VALUES (:fname, :lname, :username, :email, :contact, :password)";
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
        'message' => 'Customer has been added successfully.'
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
