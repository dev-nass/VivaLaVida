<!-- 

 * Instead of using $_SESSION we use $_GET
 * $_GET is used to retrieve paramaters from the URL typically used for filtering, searching, pagination or navigation between item/pages.

-->


<?php
session_start();
include '../php/connection.php'; // Include your PDO connection file

// Get the GuitarID from the URL query string
if (isset($_GET['GuitarID'])) {
  $guitarIdInstance = $_GET['GuitarID'];

  // Fetch the item details using GuitarID
  $stmt = $pdo->prepare("SELECT * FROM guitar WHERE GuitarID = :GuitarID");
  $stmt->bindParam(':GuitarID', $guitarIdInstance, PDO::PARAM_INT);
  $stmt->execute();
  $itemDetails = $stmt->fetch(PDO::FETCH_ASSOC);

  // Check if the item was found
  if ($itemDetails) {
    $modelInstance = $itemDetails['Model'];
    $brandInstance = $itemDetails['Brand'];
    $imgInstance = $itemDetails['Guitar_Picture'];
    $priceInstance = $itemDetails['Price'];
    $stockInstance = $itemDetails['Stocks'];
    $descriptionInstance = $itemDetails['Description'];

    $typeInstance = $itemDetails['Type'];
    $fretBoardMatInstance = $itemDetails['Fretboard_Material'];
    $neckMatInstance = $itemDetails['Neck_Material'];
    $bodyMatInstance = $itemDetails['Body_Material'];
    $bodyShapeInstance = $itemDetails['Body_Shape'];
    $numOfStringsInstance = $itemDetails['Number_of_Strings'];
    $numberOfFretsInstance = $itemDetails['Number_of_Frets'];
    // Any other details can be fetched here
  } else {
    // Handle case when item is not found
    echo "Item not found.";
    exit;
  }
} else {
  echo "No item selected.";
  exit;
}

$userNameInstance = $_SESSION['Username'];

if (!empty($userNameInstance) and $_SESSION['Role'] == 'User') {
  // Fetch guitar data
  $sql = "SELECT * FROM guitar";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();


  // Set variables for display
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
  // Redirect to 404 page if the user is not logged in
  header('Location: ../404.php');
  exit(); // Stop further execution after redirect
}

$profileAnchor = (!empty($_SESSION['Username'])) ? '../php/profile.php' : '../loginForm.php';



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Item Info | Item sa Database</title>
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <!-- Font Aweasome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet" />
  <!-- Custom CSS -->
  <link href="../css/util.css" rel="stylesheet" />
  <link href="../css/navbar.css" rel="stylesheet" />
  <link href="../css/home.css" rel="stylesheet" />
  <link href="../css/footer.css" rel="stylesheet" />
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
                    <button type="submit" class="dropdown-item <?php echo $textColor; ?>" >
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

  <!-- MAIN -->
  <main class="p-5">
    <div class="container p-5">
      <div class="row">
        <div class="col-sm-12 col-md-6 white-bg">
          <img class="w-100" src="<?php echo htmlspecialchars($imgInstance); ?>" />
        </div>
        <div class="col-sm-12 col-md-6 pt-3">
          <h1 class="fw-bolder"></span><?php echo htmlspecialchars($brandInstance); ?> <?php echo htmlspecialchars($modelInstance); ?></h1>
          <div class="container">
            <div class="row">
              <div class="col-12 g-0">
                <h4 class="text-success">₱<?php echo number_format(($priceInstance), 2); ?></h4>
              </div>
              <div class="col-12 p-0">
                <p><?php echo $descriptionInstance; ?></p>
              </div>
            </div>
          </div>

          <!-- Accordion -->
          <div class="container">
            <div class="row">
              <div class="accordion g-0" id="accordionExample">
                <div class="accordion-item darkViva-text">
                  <h2 class="accordion-header">
                    <button class="accordion-button collapsed darkViva-bg whiteViva-text" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                      Details
                    </button>
                  </h2>
                  <div id="collapseTwo" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                    <div class="accordion-body active">
                      <p><strong>Type:</strong> <?php echo ($typeInstance); ?></p>
                      <hr>
                      <p><strong>Fret Board Material:</strong> <?php echo ($fretBoardMatInstance); ?></p>
                      <hr>
                      <p><strong>Neck Material:</strong> <?php echo ($neckMatInstance); ?></p>
                      <hr>
                      <p><strong>Body Material:</strong> <?php echo ($bodyMatInstance); ?></p>
                      <hr>
                      <p><strong>Body Shape:</strong> <?php echo ($bodyShapeInstance); ?></p>
                      <hr>
                      <p><strong>Number of Strings:</strong> <?php echo ($numOfStringsInstance); ?></p>
                      <hr>
                      <p><strong>Number of Frets:</strong> <?php echo ($numberOfFretsInstance); ?></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>