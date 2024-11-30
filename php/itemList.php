<?php

session_start(); // Ensure session is started
include 'connection.php';
$userNameInstance = $_SESSION['Username'];

if (!empty($userNameInstance) and $_SESSION['Role'] == 'User') {

  // Fetch guitar data
  $sql = "SELECT * FROM guitar";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();

  // For Brand Filtering
  $sqlBrand = "SELECT DISTINCT Brand FROM guitar";
  $stmtBrand = $pdo->prepare($sqlBrand);
  $stmtBrand->execute();

  // For Model Filtering
  $sqlModel = "SELECT DISTINCT Model FROM guitar";
  $stmtModel = $pdo->prepare($sqlModel);
  $stmtModel->execute();

  // For Type Filtering
  $sqlType = "SELECT DISTINCT Type FROM guitar";
  $stmtType = $pdo->prepare($sqlType);
  $stmtType->execute();

  // For Fretboard_Material Filtering
  $sqlFretboard = "SELECT DISTINCT Fretboard_Material FROM guitar";
  $stmtFretboard = $pdo->prepare($sqlFretboard);
  $stmtFretboard->execute();

  // For Neck_Material Filtering
  $sqlNeck = "SELECT DISTINCT Neck_Material FROM guitar";
  $stmtNeck = $pdo->prepare($sqlNeck);
  $stmtNeck->execute();

  // For Body_Material Filtering
  $sqlBodyMaterial = "SELECT DISTINCT Body_Material FROM guitar";
  $stmtBodyMaterial = $pdo->prepare($sqlBodyMaterial);
  $stmtBodyMaterial->execute();

  // For Body_Shape Filtering
  $sqlBodyShape = "SELECT DISTINCT Body_Shape FROM guitar";
  $stmtBodyShape = $pdo->prepare($sqlBodyShape);
  $stmtBodyShape->execute();

  // For Number_of_Strings Filtering
  $sqlStrings = "SELECT DISTINCT Number_of_Strings FROM guitar";
  $stmtStrings = $pdo->prepare($sqlStrings);
  $stmtStrings->execute();

  // For Number_of_Frets Filtering
  $sqlFrets = "SELECT DISTINCT Number_of_Frets FROM guitar";
  $stmtFrets = $pdo->prepare($sqlFrets);
  $stmtFrets->execute();


  // For carousel filtering
  $filter = isset($_GET['filter']) ? $_GET['filter'] : '';

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
  <title>VLV | Guitars</title>
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <!-- Star Icons Cloud Flare -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
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

  <!-- MAIN -->
  <main class="pb-5" style="padding-top: 5rem; margin-bottom: 5rem; min-height: 100vh;">
    <div class="container pt-5">
      <div class="row mb-3">
        <div class="col-12 col-lg-6">
          <h1 class="h2 section-header">GUITAR LIST</h1>
        </div>
        <div class="col-12 col-lg-6 d-flex">
          <div class="col-11">
            <input id="searchGuitarAdmin-input" class="form-control input-search me-1 w-100" type="text" placeholder="Search Guitar" />
          </div>
          <div class="col-1 ms-1">
            <button class="btn brown-button" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop" aria-controls="offcanvasTop"><i class="fa-solid fa-sort"></i></button>
          </div>
        </div>
      </div>



      <!-- Off canvas Filter -->
      <div class="offcanvas offcanvas-end whiteViva-bg" tabindex="-1" id="offcanvasTop" aria-labelledby="offcanvasTopLabel">
        <div class="offcanvas-header pb-1">
          <h3 class="offcanvas-title section-header" id="offcanvasTopLabel">Filter Guitars</h3>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="px-3">
          <hr style="border: 1px solid var(--clr-dark) !important;">
        </div>
        <div class="offcanvas-body">
          <!-- Brand container filter -->
          <div>
            <h4 class="section-header">Brand</h4>
            <?php while ($brandFilter = $stmtBrand->fetch(PDO::FETCH_ASSOC)) { ?>
              <div>
                <input
                  type="checkbox"
                  class="brand-filter"
                  value="<?php echo $brandFilter['Brand']; ?>"
                  <?php
                  // Check if the current type should be pre-checked
                  echo (isset($filter) && (
                    $filter === $brandFilter['Brand'] ||
                    (is_array($filter) && in_array($brandFilter['Brand'], $filter))
                  )) ? 'checked' : '';
                  ?> />
                <span><?php echo $brandFilter['Brand']; ?></span>
              </div>
            <?php } ?>
          </div>

          <!-- Model container filter -->
          <div class="mt-3">
            <h4 class="section-header">Model</h4>
            <?php while ($modelFilter = $stmtModel->fetch(PDO::FETCH_ASSOC)) { ?>
              <div>
                <input type="checkbox" class="model-filter" value="<?php echo $modelFilter['Model']; ?>" />
                <span><?php echo $modelFilter['Model']; ?></span>
              </div>
            <?php } ?>
          </div>

          <!-- Type container filter -->
          <div class="mt-3">
            <h4 class="section-header">Type</h4>
            <?php while ($typeFilter = $stmtType->fetch(PDO::FETCH_ASSOC)) { ?>
              <div>
                <input
                  type="checkbox"
                  class="type-filter"
                  value="<?php echo $typeFilter['Type']; ?>"
                  <?php
                  // Check if the current type should be pre-checked
                  echo (isset($filter) && (
                    $filter === $typeFilter['Type'] ||
                    (is_array($filter) && in_array($typeFilter['Type'], $filter))
                  )) ? 'checked' : '';
                  ?> />
                <span><?php echo $typeFilter['Type']; ?></span>
              </div>
            <?php } ?>
          </div>

          <!-- Fretboard Material filter -->
          <div class="mt-3">
            <h4 class="section-header">Fretboard Material</h4>
            <?php while ($fretboardFilter = $stmtFretboard->fetch(PDO::FETCH_ASSOC)) { ?>
              <div>
                <input type="checkbox" class="fretboard-filter" value="<?php echo $fretboardFilter['Fretboard_Material']; ?>" />
                <span><?php echo $fretboardFilter['Fretboard_Material']; ?></span>
              </div>
            <?php } ?>
          </div>

          <!-- Neck Material filter -->
          <div class="mt-3">
            <h4 class="section-header">Neck Material</h4>
            <?php while ($neckFilter = $stmtNeck->fetch(PDO::FETCH_ASSOC)) { ?>
              <div>
                <input type="checkbox" class="neck-filter" value="<?php echo $neckFilter['Neck_Material']; ?>" />
                <span><?php echo $neckFilter['Neck_Material']; ?></span>
              </div>
            <?php } ?>
          </div>

          <!-- Body Material filter -->
          <div class="mt-3">
            <h4 class="section-header">Body Material</h4>
            <?php while ($bodyMaterialFilter = $stmtBodyMaterial->fetch(PDO::FETCH_ASSOC)) { ?>
              <div>
                <input type="checkbox" class="body-material-filter" value="<?php echo $bodyMaterialFilter['Body_Material']; ?>" />
                <span><?php echo $bodyMaterialFilter['Body_Material']; ?></span>
              </div>
            <?php } ?>
          </div>

          <!-- Body Shape filter -->
          <div class="mt-3">
            <h4 class="section-header">Body Shape</h4>
            <?php while ($bodyShapeFilter = $stmtBodyShape->fetch(PDO::FETCH_ASSOC)) { ?>
              <div>
                <input type="checkbox" class="body-shape-filter" value="<?php echo $bodyShapeFilter['Body_Shape']; ?>" />
                <span><?php echo $bodyShapeFilter['Body_Shape']; ?></span>
              </div>
            <?php } ?>
          </div>

          <!-- Number of Strings filter -->
          <div class="mt-3">
            <h4 class="section-header">Number of Strings</h4>
            <?php while ($stringsFilter = $stmtStrings->fetch(PDO::FETCH_ASSOC)) { ?>
              <div>
                <input type="checkbox" class="strings-filter" value="<?php echo $stringsFilter['Number_of_Strings']; ?>" />
                <span><?php echo $stringsFilter['Number_of_Strings']; ?></span>
              </div>
            <?php } ?>
          </div>

          <!-- Number of Frets filter -->
          <div class="mt-3">
            <h4 class="section-header">Number of Frets</h4>
            <?php while ($fretsFilter = $stmtFrets->fetch(PDO::FETCH_ASSOC)) { ?>
              <div>
                <input type="checkbox" class="frets-filter" value="<?php echo $fretsFilter['Number_of_Frets']; ?>" />
                <span><?php echo $fretsFilter['Number_of_Frets']; ?></span>
              </div>
            <?php } ?>
          </div>

          <!-- Pringe Range Filter -->
          <div class="mt-3">
            <h4 class="section-header">Price Range</h4>
            <div class="price-filter">
              <label for="minPrice">Min Price:</label>
              <input type="number" id="minPrice" placeholder="Minimum Price" class="form-control mb-2">

              <label for="maxPrice">Max Price:</label>
              <input type="number" id="maxPrice" placeholder="Maximum Price" class="form-control mb-4">
            </div>
          </div>

        </div>
        <!-- ... container filter -->
      </div>
      <!-- End of off canvas -->





      <div class="container-fluid">
        <!-- Content Row: Item List / Guitar lists -->
        <div class="row">
          <?php
          while ($databaseData = $stmt->fetch(PDO::FETCH_ASSOC)) {
          ?>
            <div class="col-sm-6 col-md-3 guitar-cards mt-3"
              data-guitar-brand="<?php echo $databaseData["Brand"]; ?>"
              data-guitar-model="<?php echo $databaseData["Model"]; ?>"
              data-guitar-type="<?php echo $databaseData["Type"]; ?>"
              data-guitar-fretboard="<?php echo $databaseData["Fretboard_Material"]; ?>"
              data-guitar-neck="<?php echo $databaseData["Neck_Material"]; ?>"
              data-guitar-body-material="<?php echo $databaseData["Body_Material"]; ?>"
              data-guitar-body-shape="<?php echo $databaseData["Body_Shape"]; ?>"
              data-guitar-strings="<?php echo $databaseData["Number_of_Strings"]; ?>"
              data-guitar-frets="<?php echo $databaseData["Number_of_Frets"]; ?>"
              data-guitar-price="<?php echo $databaseData["Price"]; ?>">
              <div class="card-group">
                <!-- Additional Required Wrapper -->
                <div class="card white-bg">
                  <!-- card img -->
                  <img class="card-img-top" src="<?php echo $databaseData["Guitar_Picture"]; ?>" alt="guitar-image">
                  <div class="card-body darkViva-text">
                    <h5 class="card-title card-guitar-model" style="font-size: 1rem;"><span style="font-size: .7rem;">Model:</span> <?php echo $databaseData["Model"]; ?></h5>
                    <h6 class="card-guitar-brand"><span style="font-size: .7rem;">Brand:</span> <?php echo $databaseData["Brand"]; ?></h6>
                    <h6><span style="font-size: .7rem;">Price:</span> ₱<?php echo number_format($databaseData["Price"], 2); ?></h6>
                    <p class="greenViva-text item-status"><span style="font-size: .7rem;">Stocks:</span> <?php echo $databaseData["Stocks"]; ?></p>
                    <!-- individualItemPage.php is the base URL where the user will be directed if they clicked | ?guitarID= Query String that sends the value to the server via GET request when the link is clicked -->
                    <!-- the ? seperates the baseURl to the Query String -->
                    <!-- Multiple parameters can also be done here such as (?UserID=php[] & Role=php[] -->
                    <!-- Note that those are only variable the thing are the ? what really should matter is the value that they will be equal to = -->
                    <a href="../php/individualItemPage.php?GuitarID=<?php echo $databaseData['GuitarID']; ?>" class="btn brown-button w-100">View Item <i class="fa fa-external-link"></i></a>

                  </div>
                </div>
              </div>
            </div>

          <?php
          }
          ?>
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

  <script src="../js/itemListSearch.js"></script>
  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <!-- Swiper -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</body>

</html>