<!-- php script part -->
<?php

// suppress error
// error_reporting(0);
// ini_set('display_errors', 0);

// db konektor
include 'php/connection.php';

// notification 
$notifico = '';
$regNotif = '';

// notif event 
if (isset($_POST['submitBtn'])) {

  // check missing filed
  if (
    !empty($_POST['email']) and !empty($_POST['username']) and !empty($_POST['password']) and
    !empty($_POST['rePass'])
  ) {


    // check special character

    if (
      !preg_match('/[^a-zA-Z0-9\s.]/', $_POST['username'])
    ) 
    {
      // declare users input as variable
      $inputUsername = ($_POST['username']);
      $inputEmail = ($_POST['email']);
      $inputPassword = ($_POST['password']);
      $inputRePass = ($_POST['rePass']);
      // check if username exist sa db
      $checkUsernameStmt = $pdo->prepare("
          SELECT Username 
          FROM user 
          WHERE Username = :username
          UNION
          SELECT Username 
          FROM employee 
          WHERE Username = :username
      ");
      $checkUsernameStmt->execute([':username' => $inputUsername]);
      $numberofUser = $checkUsernameStmt->rowCount();


      if ($numberofUser < 1) {
        // check if email address exist sa db
        $checkEmailStmt = $pdo->prepare("
          SELECT Email 
          FROM user 
          WHERE Email = :email
          UNION
          SELECT Email 
          FROM employee 
          WHERE Email = :email
        ");
        $checkEmailStmt->execute([':email' => $inputEmail]);
        $numberOfEmail = $checkEmailStmt->rowCount();


        if ($numberOfEmail < 1) {

          // checking for password characters, min of 8 characters
          if (strlen($inputPassword) >= 8) {

            // check if pass are equal
            if ($inputPassword == $inputRePass) {

              // pass encryption
              $hashPassword = password_hash($inputPassword, PASSWORD_BCRYPT, array('cost' => 12));

              // registering entries sa db
              // prepare sql statement
              $sql = "INSERT INTO user (First_Name, Last_Name, Age, Contact_Number, Address, 
                        Email, Username, Password, role) 
                        VALUES (NULL, NULL, NULL, NULL, NULL, 
                        :email, :username, :user_password, 'User')";

              $saveRecord = $pdo->prepare($sql);

              // bind parameters
              $saveRecord->bindParam(':username', $inputUsername);
              $saveRecord->bindParam(':email', $inputEmail);
              $saveRecord->bindParam(':user_password', $hashPassword);

              // execution at error handling
              if ($saveRecord->execute()) {
                header('Location: loginForm.php');
              } else {
                $notifico = 'Record not saved!!! Error: ' . implode(", ", $saveRecord->errorInfo());
              }
            } else {
              $notifico = 'Password does not match. Please try again...';
            }
          } else {
            $notifico = 'Password is not atleast 8 characters long...';
          }
        } else {
          $notifico = 'Email address already exists. Please try again...';
        }
      } else {
        $notifico = 'Username already exists. Please try again...';
      }
    } else {
      $notifico = 'Special Characters are not allowed. Please try again...';
    }
  } else {
    // Notify if a required field is missing
    $notifico = 'Missing a field. Make sure to fill up all necessary fields...';
  }
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration</title>
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Star Icons Cloud Flare -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Custom CSS -->
  <link href="css/registerv2.css" rel="stylesheet">
  <link href="css/util.css" rel="stylesheet" />
  <link href="css/navbar.css" rel="stylesheet" />
  <link href="css/footer.css" rel="stylesheet" />
</head>

<body id="bg-giver" class="m-0">


  <!-- MAIN -->
  <main>
    <section class="vh-100">
      <div class="container pb-5">
        <div class="row">
          <div class="col-lg-3"></div>
          <div class="col-lg-6">
            <div id="ui" class="border border-dark shadow">


              <span class="h1 fw-bold mb-0 myfont">
                <center>Viva la Vida</center>
              </span>


              <h5 class=" mb-2 pb-3 myfont fw-semibold text-center">Create an account...</h5>

              <!-- notif part -->
              <span class="warn text-danger fs-5">
                <i>
                  <center><?php
                          echo "$notifico";
                          ?></center>
                </i></span>

              <!-- notif part successful register-->
              <span class="text-success fs-5">
                <i>
                  <center><?php
                          echo "$regNotif";
                          ?></center>
                </i></span>

              <!-- start ng form -->
              <form class="form-group text-center" action="registrationForm.php" method='POST'>

                <!-- update: removed first and last name fields, and address -->
                <div class="row mt-3">
                  <!-- username -->
                  <div class="col-lg-6">
                    <label class="text-black myfont fw-semibold">Username:</label>
                    <input type="text" name="username" class="form-control fw-semibold" placeholder="Enter your Username" oninput="this.value = this.value.replace(/[^a-zA-Z-0-9]/g, '');">
                  </div>
                  <!-- email -->
                  <div class="col-lg-6">
                    <label class="text-black myfont fw-semibold">E-Mail:</label>
                    <input type="email" name="email" class="form-control fw-semibold" placeholder="Enter your E-Mail">
                  </div>
                </div>
                <br>

                <div class="row">
                  <!-- password -->
                  <div class="col-lg-6">
                    <label class="text-black myfont fw-semibold">Password:</label>
                    <input type="password" name="password" class="form-control fw-semibold" placeholder="Enter at least 8 characters">
                  </div>
                  <!-- retype password -->
                  <div class="col-lg-6">
                    <label class="text-black myfont fw-semibold">Re-Type Password:</label>
                    <input type="password" name="rePass" class="form-control fw-semibold" placeholder="Re-type your Password">
                  </div>
                </div>

                <br>
                <!-- submit button -->
                <input type="submit" name="submitBtn" value="Submit" class="btn btn-lg mt-2 text-black fw-semibold" style="width: 100%;">

                <!-- already have an account?? -->
                <div class="text-center mt-4 text-white myfont">
                  <p class="mb-0 pb-lg--2 text-black fw-semibold">Already have an account? <a href="loginForm.php">Log in</a></p>
                </div>

              </form>
              <!-- end ng form -->
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>



  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>