<?php

session_start();
include '../php/connection.php';

if (!empty($_SESSION['Username'])) {
  $userNameInstance = $_SESSION['Username'];
  $textColor = "text-danger";
  $actionText = "Logout";
  $actionSign = "fa-solid fa-right-from-bracket";

  // For navbar profile picture
  $profilePicture = (!empty($_SESSION['Profile_Picture'])) ? $_SESSION['Profile_Picture'] : '../image retrieverv2/userProfiles/default-user-profile.png';

  // For navbar recent orders
  if (empty($_SESSION['Purchase_Status'])) {
    $previousOrder = "d-none";
  }
} else {
  $userNameInstance = 'Guess';
  $textColor = "text-success";
  $actionText = "Login";
  $actionSign = "fa-solid fa-right-to-bracket";
}



// update button (query and hsit)

// check user if logged in
if (!isset($_SESSION['User_ID'])) {
  // redirect pag di naka log in
  header("Location: loginForm.php");
  exit();
}

// fetch the current user's data from the database
$userID = $_SESSION['User_ID'];
$stmt = $pdo->prepare("SELECT * FROM user WHERE User_ID = :userID");
$stmt->execute([':userID' => $userID]);
$userData = $stmt->fetch(PDO::FETCH_ASSOC);

// Update handling
if (isset($_POST['saveBtn'])) {
  // get updated entries
  $updatedUsername = $_POST['username'];
  $updatedEmail = $_POST['email'];
  $updatedFirstName = $_POST['first-name'];
  $updatedLastName = $_POST['last-name'];
  $updatedAge = $_POST['age'];
  $updatedAddress = $_POST['address'];
  $updatedContactNumber = $_POST['contactNumber'];

  // Error handling
  $hasError = false;

  // cheecking special charss sa mga textfields tyes
  if (
    preg_match('/[^a-zA-Z0-9\s.@]/', $updatedUsername) or
    preg_match('/[^a-zA-Z0-9\s.]/', $updatedFirstName) or
    preg_match('/[^a-zA-Z0-9\s.]/', $updatedLastName) or
    preg_match('/[^a-zA-Z0-9\s.,\'\/\-&()#:éüñ]/', $updatedAddress)
  ) {
    // Address checking is updated
    $_SESSION['status'] = 'Special characters are not allowed. Please try again.';
    $_SESSION['status_type'] = 'danger';
    $hasError = true;
  }

  // check email duplicate
  if (!$hasError) {
    $stmtEmailCheck = $pdo->prepare("SELECT Email FROM user 
                                      WHERE Email = :email AND User_ID != :userID
                                      UNION ALL
                                      SELECT Email FROM employee
                                      WHERE Email = :email AND Employee_ID != :userID");
    $stmtEmailCheck->execute([':email' => $updatedEmail, ':userID' => $userID]);
    if ($stmtEmailCheck->rowCount() > 0) {
      $_SESSION['status'] = 'Email address already exists. Please try again.';
      $_SESSION['status_type'] = 'danger';
      $hasError = true;
    }
  }

  // check username dupss
  if (!$hasError) {
    $stmtUsernameCheck = $pdo->prepare("SELECT Username FROM user 
                                          WHERE Username = :username AND User_ID != :userID
                                          UNION ALL
                                          SELECT Username FROM employee
                                          WHERE Username = :username AND Employee_ID != :userID");
    $stmtUsernameCheck->execute([':username' => $updatedUsername, ':userID' => $userID]);
    if ($stmtUsernameCheck->rowCount() > 0) {
      $_SESSION['status'] = 'Username already exists. Please try again.';
      $_SESSION['status_type'] = 'danger';
      $hasError = true;
    }
  }

  // check contact number
  if (!$hasError) {
    $stmtConNumberCheck = $pdo->prepare("SELECT Contact_Number FROM user 
                                          WHERE Contact_Number = :contact_number AND User_ID != :userID
                                          UNION ALL
                                          SELECT Contact_Number FROM employee
                                          WHERE Contact_Number = :contact_number AND Employee_ID != :userID");
    $stmtConNumberCheck->execute([':contact_number' => $updatedContactNumber, ':userID' => $userID]);
    if ($stmtConNumberCheck->rowCount() > 0) {
      $_SESSION['status'] = 'Contact number already exists. Please try again.';
      $_SESSION['status_type'] = 'danger';
      $hasError = true;
    }
  }

  // update handling
  if (!$hasError) {
    $updateStmt = $pdo->prepare("UPDATE user SET 
          Username = :username,
          Email = :email,
          First_Name = :firstName,
          Last_Name = :lastName,
          Age = :age,
          Address = :address,
          Contact_Number = :contactNumber
          WHERE User_ID = :userID");

    $updateStmt->bindParam(':username', $updatedUsername);
    $updateStmt->bindParam(':email', $updatedEmail);
    $updateStmt->bindParam(':firstName', $updatedFirstName);
    $updateStmt->bindParam(':lastName', $updatedLastName);
    $updateStmt->bindParam(':age', $updatedAge);
    $updateStmt->bindParam(':address', $updatedAddress);
    $updateStmt->bindParam(':contactNumber', $updatedContactNumber);
    $updateStmt->bindParam(':userID', $userID);


    if ($updateStmt->execute()) {
      // Update session data with new values
      $_SESSION['Username'] = $updatedUsername;
      $_SESSION['Email'] = $updatedEmail;
      $_SESSION['First_Name'] = $updatedFirstName;
      $_SESSION['Last_Name'] = $updatedLastName;
      $_SESSION['Age'] = $updatedAge;
      $_SESSION['Address'] = $updatedAddress;
      $_SESSION['Contact_Number'] = $updatedContactNumber;

      // status notif
      $_SESSION['status'] = 'Profile updated successfully!';
      $_SESSION['status_type'] = 'success';
      header("Location: profile.php");
      exit();
    } else {
      $_SESSION['status'] = 'Error updating profile!';
      $_SESSION['status_type'] = 'danger';
    }
  }
}

// profile picture handling
// reference internet
if (isset($_FILES['profile_pic'])) {


  // Directory to save the profile pictures
  $uploadDir = '../image retrieverv2/userProfiles/';

  // Generate a unique filename for the uploaded file
  $filename = uniqid() . '-' . basename($_FILES['profile_pic']['name']);
  $uploadFilePath = $uploadDir . $filename;

  // Validate and upload the file
  if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $uploadFilePath)) {
    // Update the database with the new profile picture path
    $stmt = $pdo->prepare("UPDATE user SET Profile_Picture = :profilePicture WHERE User_ID = :userID");
    $stmt->execute([
      ':profilePicture' => $uploadFilePath,
      ':userID' => $_SESSION['User_ID']
    ]);

    // Update session to reflect new profile picture
    $_SESSION['Profile_Picture'] = $uploadFilePath;

    $_SESSION['status'] = 'Profile picture updated successfully!';
    $_SESSION['status_type'] = 'success';
  } else {
    $_SESSION['status'] = 'Failed to upload profile picture.';
    $_SESSION['status_type'] = 'danger';
  }

  // Redirect back to profile page
  header('Location: profile.php');
  exit();
}

// Fetch user profile data from the database for displaying
$stmt = $pdo->prepare("SELECT * FROM user WHERE User_ID = :userID");
$stmt->execute([':userID' => $_SESSION['User_ID']]);
$user = $stmt->fetch();

// If no profile picture is set, use the default one
$profilePicture = isset($user['Profile_Picture']) ? $user['Profile_Picture'] : '../image retrieverv2/userProfiles/default-user-profile.png';
$_SESSION['Profile_Picture'] = $profilePicture; // Update session with profile picture path

$profileAnchor = (!empty($_SESSION['Username'])) ? '../php/profile.php' : '../loginForm.php';

$contactNumberPlaceHolder = (!empty($user['Contact_Number'])) ? $user['Contact_Number'] : "09XXXXXXXXX";

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VLV | Profile</title>

  <!--Bootstrap Link-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <!-- Star Icons Cloud Flare -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Custom CSS -->
  <link href="../css/aboutUs.css" rel="stylesheet">
  <link href="../css/util.css" rel="stylesheet" />
  <link href="../css/navbar.css" rel="stylesheet" />
  <link href="../css/footer.css" rel="stylesheet" />
  <link href="../css/profile.css" rel="stylesheet" />
</head>

<body>
  <!-- HEADER -->
  <header class="main-header">
    <nav class="navbar header-nav navbar-expand-lg">
      <div class="container">
        <!-- Brand Name/logo -->
        <a id="brand" href="../index.php">
          <div class="mb-0"><img src="../img/brand-logo.jpg" alt=""></div>
        </a>

        <!-- Menu -->
        <div id="navbar-collapse-toggle" class="collapse navbar-collapse justify-content-end">

          <!-- Profile (Small screen) -->
          <div class="ms-auto d-flex d-lg-none flex-column align-items-center justify-content-center mt-3">
            <div class="profile">
              <div class="dropdown-center">
                <button class="btn dropdown-toggle no-arrow p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <?php if (!empty($_SESSION['Username']) && !empty($_SESSION['Profile_Picture'])) : ?>
                    <img src="<?php echo $profilePicture ?>" alt="pfp" style="width: 50px; height: 50px; border-radius: 40px;">
                  <?php else : ?>
                    <i class="fa-solid fa-user m-3"></i>
                  <?php endif ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li><a href="<?php echo $profileAnchor ?>" class="normal-font dropdown-item"">Hello, <?php echo $userNameInstance; ?> </a></li>
                  <li>
                    <hr class=" dropdown-divider">
                  </li>
                  <li class="<?php echo $previousOrder ?>"><a class="normal-font dropdown-item" href="previousOrderHistoryPage.php">Previous Order <i class="fa-solid fa-rotate-left"></i></a></li>
                  <li class="<?php echo $previousOrder ?>">
                    <hr class="dropdown-divider">
                  </li>
                  <li>
                    <form action="../php/logout.php" method="POST">
                      <button type="submit" class="dropdown-item <?php echo $textColor; ?>">
                        <?php echo $actionText; ?><i class="<?php echo $actionSign; ?> ms-1"></i>
                      </button>
                    </form>
                  </li>
                </ul>
              </div>

            </div>
          </div>

          <ul class="navbar-nav mx-auto">
            <li>
              <a href="../index.php" class="nav-link">Home</a>
            </li>
            <li>
              <a href="../php/itemList.php" class="nav-link">Guitars</a>
            </li>
            <li>
              <a href="../aboutUs.php" class="nav-link">About</a>
            </li>
            <li>
              <a href="../findStore.php" class="nav-link">Find Store</a>
            </li>
          </ul>

          <!-- <div id="div-search" class="ms-auto d-flex d-lg-none justify-content-center">
            <input id="input-search" class="form-control w-auto me-2" type="search" placeholder="Search" aria-label="Search">
            <button id="button-search" class="btn btn-outline-light" type="submit">Search</button>
          </div> -->




        </div>

        <!-- Profile (Large scren) -->
        <div class="ms-auto d-none d-lg-flex align-items-center">
          <div class="profile">
            <div class="dropdown-center">
              <button class="btn dropdown-toggle no-arrow p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?php if (!empty($_SESSION['Username']) && !empty($_SESSION['Profile_Picture'])) : ?>
                  <img src="<?php echo $profilePicture ?>" alt="pfp" style="width: 50px; height: 50px; border-radius: 40px;">
                <?php else : ?>
                  <i class="fa-solid fa-user m-3"></i>
                <?php endif ?>
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="normal-font dropdown-item" href="<?php echo $profileAnchor ?>">Hello, <?php echo $userNameInstance; ?> </a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li class="<?php echo $previousOrder ?>"><a class="normal-font dropdown-item" href="../php/previousOrderHistoryPage.php">Previous Orders <i class="fa-solid fa-clock-rotate-left"></i></a></li>
                <li class="<?php echo $previousOrder ?>">
                  <hr class="dropdown-divider">
                </li>
                <li>
                  <form action="../php/logout.php" method="POST">
                    <button type="submit" class="dropdown-item <?php echo $textColor; ?>">
                      <?php echo $actionText; ?><i class="<?php echo $actionSign; ?> ms-1"></i>
                    </button>
                  </form>
                </li>
              </ul>
            </div>

          </div>
        </div>

        <!-- Small screen toggle -->
        <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-collapse-toggle">
          <span></span>
          <span></span>
          <span></span>
        </button>
      </div>
    </nav>
  </header>

  <!-- Main Profile Section -->
  <main style="padding: 15rem 0;">
    <section class="vh-100 d-flex flex-column justify-content-center align-items-center position-relative">

      <!-- notif point -->
      <div class="row w-45 position-absolute" style="top: 7%; z-index: 1050;">
        <div class="col-12">
          <?php
          if (isset($_SESSION['status'])) {
            $statusType = $_SESSION['status_type'] == 'success' ? 'alert-success' : 'alert-danger';
            echo "<div class='alert $statusType' role='alert'>" . $_SESSION['status'] . "</div>";
            unset($_SESSION['status']);
            unset($_SESSION['status_type']);
          }
          ?>
        </div>
      </div>

      <div class="w-100 card-profile p-4 rounded shadow border border-dark" style="max-width: 500px;">

        <!-- Profile Information -->
        <h5 class="text-center fw-bold myfont">Profile</h5>
        <hr class="profile-hr">

        <!-- Profile Picture -->
        <div class="profile-pic">
          <form id="profilePicForm" action="profile.php" method="POST" enctype="multipart/form-data">
            <label class="-label" for="file">
              <span class="glyphicon glyphicon-camera myfont"></span>
              <span>Change Image</span>
            </label>
            <input
              id="file"
              name="profile_pic"
              type="file"
              accept="image/*"
              onchange="previewAndConfirm(event)" />
            <img
              src="<?php echo isset($_SESSION['Profile_Picture']) ? $_SESSION['Profile_Picture'] : '../image retrieverv2/userProfiles/default-user-profile.png'; ?>"
              id="output"
              width="200" />
          </form>
        </div>

        <!-- Username and Edit Option -->
        <h3 class="text-center fw-bold myfont mt-3"><?php echo $userNameInstance ?></h3>
        <h6 class="text-center fw-semibold" data-bs-toggle="modal" data-bs-target="#editProfileModal" style="cursor: pointer; color:rgb(170, 39, 170)"><u><i>Edit Profile</i></u></h6>

        <hr class="profile-hr">

        <!-- Profile Details -->
        <!-- user info -->
        <!-- ginawang dynamic display -->
        <div class="mb-3">
          <h5 class="fs-5 fw-bold myfont text-center"><i>User Info</i></h5>
        </div>
        <div class="mb-3">
          <p class="fs-5 fw-semibold myfont">First Name: <span><?php echo htmlspecialchars($userData['First_Name']); ?></span></p>
        </div>
        <div class="mb-3">
          <p class="fs-5 fw-semibold myfont">Last Name: <span><?php echo htmlspecialchars($userData['Last_Name']); ?></span></p>
          <div class="mb-3">
            <p class="fs-5 fw-semibold myfont">Address: <span><?php echo htmlspecialchars($userData['Address']); ?></span></p>
          </div>
        </div>
        <div class="mb-3">
          <p class="fs-5 fw-semibold myfont">Age: <span><?php echo htmlspecialchars($userData['Age']); ?></span></p>
        </div>

        <hr class="profile-hr">
        <!-- account info -->
        <div class="mb-3">
          <h5 class="fs-5 fw-bold myfont text-center"><i>Account Info</i></h5>
        </div>
        <div class="mb-3">
          <p class="fs-5 fw-semibold myfont">Contact Number: <?php echo htmlspecialchars($userData['Contact_Number']); ?></p>
        </div>
        <div class="mb-3">
          <p class="fs-5 fw-semibold myfont">Email: <?php echo htmlspecialchars($userData['Email']); ?></p>
        </div>
        <div class="mb-3">
          <p class="fs-5 fw-semibold myfont">User ID: <?php echo htmlspecialchars($userData['User_ID']); ?></p>
        </div>

        <hr class="profile-hr">

      </div>
    </section>
  </main>

  <!-- modal formsssss -->
  <!-- Modal for Editing Profile -->
  <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content profile-modal border border-dark">
        <!-- Modal Header -->
        <div class="modal-header">
          <h5 class="modal-title myfont " id="editProfileModalLabel">
            <center>Edit Profile Information</center>
          </h5>
        </div>

        <!-- Modal Body -->
        <div class="modal-body myfont fw-semibold">
          <form action="profile.php" method="POST">
            <!-- User Info Section -->
            <h5 class="mb-3 fw-bold"><i>User Info</i></h5>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="firstName" class="form-label">First Name:</label>
                <input type="text" name="first-name" id="firstName" class="form-control"
                  value="<?= htmlspecialchars($userData['First_Name']); ?>"
                  placeholder="<?= htmlspecialchars($userData['First_Name']); ?>">
              </div>
              <div class="col-md-6 mb-3">
                <label for="lastName" class="form-label">Last Name:</label>
                <input type="text" name="last-name" id="lastName" class="form-control"
                  value="<?= htmlspecialchars($userData['Last_Name']); ?>"
                  placeholder="<?= htmlspecialchars($userData['Last_Name']); ?>">
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="age" class="form-label">Age:</label>
                <input type="text" name="age" id="age" class="form-control" oninput="this.value = this.value.replace(/[^0-9 ]/g, '');"
                  value="<?= htmlspecialchars($userData['Age']); ?>"
                  placeholder="<?= htmlspecialchars($userData['Age']); ?>"
                  maxlength="2">
              </div>
              <div class="col-md-6 mb-3">
                <label for="address" class="form-label">Address:</label>
                <input type="text" name="address" id="address" class="form-control"
                  value="<?= htmlspecialchars($userData['Address']); ?>"
                  placeholder="<?= htmlspecialchars($userData['Address']); ?>">
              </div>
            </div>

            <hr class="profile-hr">

            <!-- Account Info Section -->
            <h5 class="mb-3 fw-bold"><i>Account Info</i></h5>
            <div class="mb-3">
              <label for="contactNumber" class="form-label">Contact Number:</label>
              <input type="text" name="contactNumber" id="contactNumber" class="form-control"
                value="<?= htmlspecialchars($userData['Contact_Number']); ?>"
                placeholder="<?= htmlspecialchars($contactNumberPlaceHolder); ?>"
                maxlength="11">
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email:</label>
              <input type="email" name="email" id="email" class="form-control"
                value="<?= htmlspecialchars($userData['Email']); ?>"
                placeholder="<?= htmlspecialchars($userData['Email']); ?>">
            </div>
            <div class="mb-3">
              <label for="username" class="form-label">Username:</label>
              <input type="text" name="username" id="username" class="form-control"
                value="<?= htmlspecialchars($userData['Username']); ?>"
                placeholder="<?= htmlspecialchars($userData['Username']); ?>">
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <input class="btn btn-warning" name="saveBtn" type="submit" value="Save">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- end ng modal formmssss -->

  <!-- FOOTER -->
  <footer class=" text-white pt-5 pb-4" style="background-color: #3e3731;">
    <div class="container text-md-left">
      <!-- about our company -->
      <div class="row text-md-left">

        <!-- Company name -->
        <div class="col-sm-12 col-md-6 col-lg-3">
          <h1 class="text-warning">VL<span style="color: var(--clr-white);">V</span></h1>
          <p>At Viva La Vida, we empower each individual to express their own harmony through the strings of guitars that bonds us together.</p>
        </div>

        <!-- Contact -->
        <div class="col-sm-12 col-md-6 col-lg-3">
          <h4 class="text-uppercase mb-4 font-weight-bold text-warning"> Contact US </h4>
          <p>
            <i class="fa-solid fa-location-dot"></i> Dasmarinas, Cavite, PH
          </p>
          <p>
            <i class="fa-regular fa-envelope"></i> <a href="mailto:tampol.ninomarcoc.kld@gmail.com"> vivalavida2024212@gmail.com </a>
          </p>
          <p>
            <i class="fa-solid fa-phone"></i> </i> 995-300-8741
          </p>

        </div>

        <!-- Customer support -->
        <div class="col-sm-12 col-md-6 col-lg-3">
          <h4 class="text-uppercase mb-4 font-weight-bold text-warning">Help & Tools</h4>
          <p> <a href="../footer content/contactSupport.php">Contact Support</a> </p>
          <p> <a href="../footer content/termsAndConditions.php">Terms & Conditions</a> </p>
          <p> <a href="../footer content/guidelines.php"> Guidelines </a> </p>
          <p> <a href="#">Age 8+</a> </p>
        </div>

        <!-- Social medias -->
        <div class="col-sm-12 col-md-6 col-lg-3">
          <h4 class="text-uppercase mb-4  text-warning"> Social Media </h4>
          <p>
            <a class="footer-socials" href="https://www.facebook.com/clouieanne07"><i class="fa-brands fa-facebook"></i><span>Facebook</span></a>
          </p>
          <p>
            <a class="footer-socials" href="https://www.instagram.com/hagire.kaname/profilecard/?igsh=em8xcDh5dnY5cWtv"><i class="fa-brands fa-instagram"></i><span>Instagram</span></a>
          </p>
          <p>
            <a class="footer-socials" href="https://x.com/Akaneechii25"><i class="fa-brands fa-x-twitter"></i><span>Twitter</span>
            </a>
          </p>
        </div>
      </div>
    </div>
  </footer>

  <script src="../js/profile.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>