<?php
// suppress error
// error_reporting(0);
// ini_set('display_errors', 0);

// session start
session_start();

// db konektor
include 'php/connection.php';

// notif 
$userNotif = '';
$passNotif = '';
$mainNotif = '';

// Notification event
if (isset($_POST['logBtn'])) {
  // Check if fields are empty
  if (empty($_POST['userMail'])) {
    $userNotif = '*Missing email/username...';
  } elseif (empty($_POST['password'])) {
    $passNotif = '*Missing password...';
  } else {

    // check for special characters
    if (!preg_match('/[^a-zA-Z0-9\s.@]/', $_POST['userMail'])) {
      // db authentication
      // get value from formssss
      $user = ($_POST['userMail']);
      $password = ($_POST['password']);

      // Query gt users
      $stmtUser = $pdo->prepare("SELECT * FROM user WHERE Username = :user OR Email = :user");
      $stmtUser->execute([':user' => $user]);
      $numberQueryUser = $stmtUser->rowCount();

      // Query get employee
      $stmtEmployee = $pdo->prepare("SELECT * FROM employee WHERE Username = :user OR Email = :user");
      $stmtEmployee->execute([':user' => $user]);
      $numberQueryEmployee = $stmtEmployee->rowCount();

      // user handling
      if ($numberQueryUser > 0) {
        // fetch user data
        while ($row = $stmtUser->fetch(PDO::FETCH_ASSOC)) {
          $outUsername = $row['Username'];
          $outPassword = $row['Password'];
          $outRole = $row['Role'];
          // dinagdagan pang get ng id para sa profile
          $outUserId = $row['User_ID']; //bago para makuha user id
          $outEmail = $row['Email'];
          $outAddress = $row['Address'];
          $outContacts = $row['Contact_Number'];
          $outFname = $row['First_Name'];
          $outLname = $row['Last_Name'];
          $outAge = $row['Age'];
          $outProfilePic = $row["Profile_Picture"];
          $outPurchase_Status = $row['Purchase_Status'];
          break;
        }

        // user authentication
        if (($outUsername == $user or $outEmail == $user) and password_verify($password, $outPassword) and $outRole == 'User') {
          
          // mahalga
          $_SESSION['Username'] = $outUsername;
          $_SESSION['User_ID'] = $outUserId; // store ng user id
          $_SESSION['Email'] = $outEmail; 
          $_SESSION['Profile_Picture'] = $outProfilePic;
          $_SESSION['Purchase_Status'] = $outPurchase_Status;
          $_SESSION['Role'] = 'User';
          // // para sa profile
          // $_SESSION['Address'] = $outAddress;
          // $_SESSION['Contact_Number'] = $outContacts;
          // $_SESSION['First_Name'] = $outFname;
          // $_SESSION['Last_Name'] = $outLname;
          // $_SESSION['Age'] = $outAge;

          header("Location: index.php");
          exit();
        }
      }

      // admin handling
      if ($numberQueryEmployee > 0) {
        // fetch employee data
        while ($row = $stmtEmployee->fetch(PDO::FETCH_ASSOC)) {
          $outUsername = $row['Username'];
          $outEmail = $row['Email'];
          $outPassword = $row['Password'];
          $outRole = $row['Role'];

          break;
        }

        // admin authentication 
        // siningit ko   lang muna yung sa employee kaya walang pass verification
        if (($outUsername == $user or $outEmail == $user) and password_verify($password, $outPassword) and ($outRole == 'Admin' OR $outRole == 'Employee')) {
          // session admin
          // Updated by Jonas para sa Admin Panel
          $_SESSION['Username'] = $outUsername;
          $_SESSION['Email'] = $outEmail;
          $_SESSION['Password'] = $password;
          $_SESSION['Role'] = $outRole;
          header("Location: admin/adminIndex.php"); //pa konek nalang nung admin
          exit();
        }
      }


      $mainNotif = 'Incorrect password or user does not exist...';
    } else {
      $userNotif = '*Special Characters are not allowed. Please try again...';
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VLV | Login Page</title>
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Star Icons Cloud Flare -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Custom CSS -->
  <link href="css/login.css" rel="stylesheet">
  <link href="css/util.css" rel="stylesheet" />
  <link href="css/navbar.css" rel="stylesheet" />
  <link href="css/footer.css" rel="stylesheet" />
</head>

<body>


  <main>
    <section class="vh-100">
      <div class="container py-5 h-100 pt-5 pb-5">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col col-xl-10">
            <div class="card shadow border border-dark">
              <div class="row g-0">
                <div class="col-md-6 col-lg-5 xl-5 d-none d-md-block">
                  <!-- bg image -->
                  <img src="img/login & register/login-bg.jpg"
                    alt="login bg" class="img-fluid" />
                </div>
                <div class="col-md-6 col-lg-7 d-flex align-items-center">
                  <div class="card-body p-4 p-lg-5 text-black">

                    <!-- start ng login form -->
                    <form action='./loginForm.php' method='POST'>

                      <!-- logo icon -->
                      <div class="d-flex align-items-center mb-2 pb-1">
                        <img src="img/login & register/logo_icon.png" alt="logo icon" class="me-3 icon">
                        <span class="h1 fw-bold mb-0 myfont">Viva la Vida</span>

                      </div>


                      <h5 class=" mb-2 pb-3 myfont fw-semibold">Sign into your account</h5>

                      <!-- email -->
                      <div data-mdb-input-init class="form-outline mb-1">
                        <input type="text" name="userMail" class="form-control form-control-lg myfont" placeholder="Username/Email" />
                        <!-- notif point near the label -->
                        <label class="form-label myfont fw-semibold" for="">Email or Username<span class="warn text-danger ms-3"><i><?php echo "$userNotif"; ?></i></span></label>
                      </div>

                      <!-- password -->
                      <div data-mdb-input-init class="form-outline mb-1">
                        <input type="password" name="password" class="form-control form-control-lg myfont" placeholder="Enter password..." />
                        <!-- notif point near the label -->
                        <label class="form-label myfont fw-semibold" for="">Password<span class="warn text-danger ms-3"><i><?php echo "$passNotif"; ?></i></span></label>
                      </div>

                      <!-- login button -->
                      <div class="pt-1 mb-4">
                        <input class="btn btn-lg btn-block myfont" name="logBtn" type="submit" value="Login">
                      </div>

                      <!-- added a notif point -->
                      <span class="warn text-danger mt-0 mb-0"><i>
                          <center><?php echo "$mainNotif"; ?></center>
                        </i></span>

                      <!-- register-->
                      <div class="text-center mt-0 fw-semibold">
                        <p class="mb-0 pb-lg--2">Don't have an account? <a href="registrationForm.php">Register here</a></p>
                      </div>
                    </form>

                    <!-- end ng login form -->

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

 

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>