<?php

include 'php/connection.php';

function prompter($message)
{
  echo $message . ": ";
  /* 
  fgets() read line of input from a file or input stream
  STDIN means standard input, in the context of CLI refers to the input the user types in terminal,
  however it also reads the \n character at the end of the input because the enter button is pressed.
  trim() removes the white but also removes the \n that comes with the input
*/
  return trim(fgets(STDIN));
}

// Prompt the admin for the data / details / credentials
$admin_fname = prompter("Enter admin first name");
$admin_lname = prompter("Enter admin last name");
$admin_username = prompter("Enter admin username");
$admin_email = prompter("Enter admin email");

// Password input
echo "Enter admin password: ";
$admin_password = trim(fgets(STDIN));
echo "Re-enter password: ";
$admin_repassword = trim(fgets(STDIN));


// Validates the input
if (empty($admin_fname) || empty($admin_lname) || empty($admin_username) || empty($admin_email) || empty($admin_password)) {
  echo "All fields are required to fill!...\n";
  exit();
}

/*
 preg_match() returns either 0 or 1. 0 means the passed value after the coma ( , ) doesn't contain any value that's not defined inside of [ ]. 1 means taht it contains something that's not specified within [ ]. 


 a-zA-Z: Matches any lowercase (a-z) or uppercase (A-Z) letter.
 0-9: Matches any digit.
 \s: Matches any whitespace character (like spaces, tabs, newlines).
 .: Matches a literal period.
*/

if (!preg_match('/[^a-zA-Z\s.]/', $admin_fname) and !preg_match('/[^a-zA-Z\s.]/', $admin_lname) and !preg_match('/[^a-zA-Z0-9\s.]/', $admin_username)) {

  $checkUsernameStmt = $pdo->prepare("
    SELECT Username 
    FROM employee 
    WHERE Username = :username
    UNION
    SELECT Username
    FROM user
    WHERE Username = :username
  ");
  $checkUsernameStmt->execute([':username' => $admin_username]);
  $numberofUser = $checkUsernameStmt->rowCount();

  if ($numberofUser < 1) {
    // check if email address exist sa db
    // Check if email exists in either the employee or user table
    $checkEmailStmt = $pdo->prepare("
      SELECT Email 
      FROM employee 
      WHERE Email = :email
      UNION
      SELECT Email 
      FROM user 
      WHERE Email = :email
    ");

    $checkEmailStmt->execute([':email' => $admin_email]);
    $numberOfEmail = $checkEmailStmt->rowCount();


    if ($numberOfEmail < 1) {

      // checking for password characters, min of 8 characters
      if (strlen($admin_password) >= 8) {

        // check if pass are equal
        if ($admin_password == $admin_repassword) {

          // pass encryption
          $admin_hashed_password = password_hash($admin_password, PASSWORD_BCRYPT, array('cost' => 12));

          // registering entries sa db
          // prepare sql statement
          $sql = "INSERT INTO employee (First_Name, Last_Name, Username, Email, Password, Role) 
                    VALUES (:first_name, :last_name, :username, :email, :password, 'Admin')";

          $saveRecord = $pdo->prepare($sql);

          // bind parameters
          $saveRecord->bindParam(':first_name', $admin_fname);
          $saveRecord->bindParam(':last_name', $admin_lname);
          $saveRecord->bindParam(':username', $admin_username);
          $saveRecord->bindParam(':email', $admin_email);
          $saveRecord->bindParam(':password', $admin_hashed_password);

          // execution at error handling
          if ($saveRecord->execute()) {
            echo 'Recorded. New admin added...';
            exit();
          } else {
            echo 'Record not saved!!! Error: ' . implode(", ", $saveRecord->errorInfo());
          }
        } else {
          echo 'Password does not match. Please try again...';
          exit();
        }
      } else {
        echo 'Password is not atleast 8 characters long...';
        exit();
      }
    } else {
      echo 'Email address already exists. Please try again...';
      exit();
    }
  } else {
    echo 'Username already exists. Please try again...';
    exit();
  }
} else {
  echo "Special characters are not allowed";
  exit();
}
