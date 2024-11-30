<?php

session_start();
include 'php/connection.php';

if (!empty($_SESSION['Username']) and $_SESSION['Role'] == 'User') {
  $userNameInstance = $_SESSION['Username'];
  $textColor = "text-danger";
  $actionText = "Logout";
  $actionSign = "fa-solid fa-right-from-bracket";

  // For navbar profile picture
  $profilePath = (!empty($_SESSION['Profile_Picture'])) ? $_SESSION['Profile_Picture'] : 'image retrieverv2/userProfiles/default-user-profile.png';
  $profilePicture = str_replace('../', '', $profilePath);

  // For navbar recent orders
  if (empty($_SESSION['Purchase_Status'])) {
    $previousOrder = "d-none";
  }
} else {
  $userNameInstance = 'Guess';
  $textColor = "text-success";
  $actionText = "Login";
  $actionSign = "fa-solid fa-right-to-bracket";
  $previousOrder = 'd-none';
}

$profileAnchor = (!empty($_SESSION['Username'])) ? 'php/profile.php' : 'loginForm.php';

$guitarSql = "SELECT * FROM guitar LIMIT 7";
$guitarStmt = $pdo->prepare($guitarSql);
$guitarStmt->execute();

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VLV | Guitar Shop</title>
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <!-- Swiper -->
  <link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet" />
  <!-- Star Icons Cloud Flare -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Custom CSS -->
  <link href="css/util.css" rel="stylesheet" />
  <link href="css/navbar.css" rel="stylesheet" />
  <link href="css/home.css" rel="stylesheet" />
  <link href="css/footer.css" rel="stylesheet" />
</head>

<body>
  <!-- HEADER -->
  <header class="main-header">
    <nav class="navbar header-nav navbar-expand-lg">
      <div class="container">
        <!-- Brand Name/logo -->
        <a id="brand" href="index.php">
          <div class="mb-0"><img src="img/brand-logo.jpg" alt=""></div>
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
                  <li class="<?php echo $previousOrder ?>"><a class="normal-font dropdown-item" href="php/previousOrderHistoryPage.php">Previous Order <i class="fa-solid fa-rotate-left"></i></a></li>
                  <li class="<?php echo $previousOrder ?>">
                    <hr class="dropdown-divider">
                  </li>
                  <li>
                    <form action="php/logout.php" method="POST">
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
              <a href="index.php" class="nav-link">Home</a>
            </li>
            <li>
              <a href="php/itemList.php" class="nav-link">Guitars</a>
            </li>
            <li>
              <a href="aboutUs.php" class="nav-link">About</a>
            </li>
            <li>
              <a href="findStore.php" class="nav-link">Find Store</a>
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
                <li class="<?php echo $previousOrder ?>"><a class="normal-font dropdown-item" href="php/previousOrderHistoryPage.php">Previous Orders <i class="fa-solid fa-clock-rotate-left"></i></a></li>
                <li class="<?php echo $previousOrder ?>">
                  <hr class="dropdown-divider">
                </li>
                <li>
                  <form action="php/logout.php" method="POST">
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
  <main>
    <!-- SECTION 1 -->
    <section id="section-one">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <!-- carousel -->
            <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
              </div>
              <div class="carousel-inner">
                <a href="php/itemList.php?filter=Acoustic">
                  <div class="carousel-item active">
                    <picture class="carousel-hover-change w-100">
                      <source media="(max-width: 799px)" srcset="img/acoustic-guitar-collection-cover-mb.png" />
                      <source media="(min-width: 800px)" srcset="img/acoustic-guitar-collection-cover.png">
                      <img src="img/acoustic-guitar-collection-cover.png" class="d-block w-100" alt="...">
                    </picture>
                  </div>
                </a>
                <!-- the ?filter=Electric will go the URl using that the redirected page can use GET to access it -->
                <a href="php/itemList.php?filter=Electric">
                  <div class="carousel-item">
                    <picture class="carousel-hover-change w-100">
                      <source media="(max-width: 799px)" srcset="img/electric-guitar-collection-cover-mb.png" />
                      <source media="(min-width: 800px)" srcset="img/electric-guitar-collection-cover.png" />
                      <img src="img/electric-guitar-collection-cover.png" class="d-block w-100" alt="...">
                    </picture>
                  </div>
                </a>
                <a href="php/itemList.php?filter=Bass">
                  <div class="carousel-item">
                    <picture class="carousel-hover-change w-100">
                      <source media="(max-width: 799px)" srcset="img/bass-guitar-collection-cover-mb.png" />
                      <source media="(min-width: 800px)" srcset="img/bass-guitar-collection-cover.png">
                      <img src="img/bass-guitar-collection-cover.png" class="d-block w-100" alt="...">
                    </picture>
                  </div>
                </a>
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- SECTION 2 -->
    <section id="section-two">
      <div class="container">
        <div class="row justify-content-center gy-sm-2 gx-lg-3">
          <div class="col-sm-12 col-md-6">
            <a href="php/itemList.php?filter=History"><img class="carousel-hover-change" src="img/feature-1.png" alt="..."></a>
          </div>
          <div class="col-sm-12 col-md-6 mt-2">
            <a href="php/itemList.php?filter=Fender"><img class="carousel-hover-change" src="img/feature-2.png" alt="..."></a>
          </div>
        </div>
      </div>
    </section>

    <!-- SECTON 3 -->
    <section id="section-three">
      <div class="container">
        <h1 class="h2 section-header">BRANDS</h1>
        <!-- Slider main container -->
        <div id="logo-swiper" class="card-wrapper swiper border">
          <!-- Additional required wrapper -->
          <ul class="card-list swiper-wrapper">
            <li class="card-item swiper-slide">
              <div class="category-logo-container">
                <img class="category-logo" src="img/logo/fender.png" alt="fender-logo">
              </div>
            </li>
            <li class="card-item swiper-slide">
              <div class="category-logo-container">
                <img class="category-logo" src="img/logo/squier.png" alt="squier-logo">
              </div>
            </li>
            <li class="card-item swiper-slide">
              <div class="category-logo-container">
                <img class="category-logo" src="img//logo/mr-logo.png" alt="mr-logo">
              </div>
            </li>
            <li class="card-item swiper-slide">
              <div class="category-logo-container">
                <img class="category-logo" src="img/logo/gibson.png" alt="gibson-logo">
              </div>
            </li>
            <li class="card-item swiper-slide">
              <div class="category-logo-container">
                <img class="category-logo" src="img/logo/epiphone.png" alt="epiphone-logo">
              </div>
            </li>
            <li class="card-item swiper-slide">
              <div class="category-logo-container">
                <img class="category-logo" src="img/logo/Ibanez.png" alt="ibanze-logo">
              </div>
            </li>
            <li class="card-item swiper-slide">
              <div class="category-logo-container">
                <img class="category-logo" src="img/logo/martin-logo.png" alt="martin-logo">
              </div>
            </li>
          </ul>
        </div>
      </div>
    </section>

    <!-- SECTION 4 -->
    <section id="section-four">
      <div class="container">
        <h1 class="h2 section-header">FEATURE GUITARS</h1>
        <!-- Slider Main Container & Also Card Main Container -->
        <div id="product-swiper" class="card-wrapper swiper">
          <!-- Additional Required Wrapper -->
          <ul class="item-list card-list swiper-wrapper">
            <?php
            while ($databaseData = $guitarStmt->fetch(PDO::FETCH_ASSOC)) {
              $guiatarModPath = str_replace('../', '', $databaseData["Guitar_Picture"]);
            ?>

              <li class="card-item swiper-slide">
                <div class="card white-bg">
                  <div class="card-body">
                    <!-- card img -->
                    <img class="card-img-top" src="<?php echo $guiatarModPath; ?>" alt="guitar-image">
                    <div class="card-body darkViva-text">
                      <h5 class="card-title card-guitar-model" style="font-size: 1rem;"><span style="font-size: .7rem;">Model:</span> <?php echo $databaseData["Model"]; ?></h5>
                      <h6 class="card-guitar-brand"><span style="font-size: .7rem;">Brand:</span> <?php echo $databaseData["Brand"]; ?></h6>
                      <h6><span style="font-size: .7rem;">Price:</span> ₱<?php echo number_format($databaseData["Price"], 2); ?></h6>
                      <p class="greenViva-text item-status"><span style="font-size: .7rem;">Stocks:</span> <?php echo $databaseData["Stocks"]; ?></p>
                      <!-- individualItemPage.php is the base URL where the user will be directed if they clicked | ?guitarID= Query String that sends the value to the server via GET request when the link is clicked -->
                      <!-- the ? seperates the baseURl to the Query String -->
                      <!-- Multiple parameters can also be done here such as (?UserID=php[] & Role=php[] -->
                      <a href="php/individualItemPage.php?GuitarID=<?php echo $databaseData['GuitarID']; ?>" class="btn brown-button w-100">View Item <i class="fa fa-external-link"></i></a>
                    </div>
                  </div>
              </li>
            <?php
            }
            ?>
          </ul>
        </div>
      </div>
    </section>

    <!-- SECTION 5 -->
    <!-- ADD A PADDING ON THIS SECTION -->
    <section id="section-five">
      <div class="container">
        <h1 class="h2 section-header">WE VALUE</h1>
        <div class="row border">
          <div class="col-sm-6 col-lg-3">
            <div class="d-flex justify-content-between align-items-center flex-row flex-lg-column text-sm-start text-lg-center">
              <div>
                <div class="cirlce-container me-2 me-sm-3 mb-lg-3">
                  <i class="feature-icon fa fa-truck"></i>
                </div>
              </div>
              <div>
                <p class="d-block mb-1 fw-bold">Fast & Free Shipping</p>
                <p>We deliver your guitar to your door with the utmost care and ease.</p>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="d-flex justify-content-between align-items-center flex-row flex-lg-column text-sm-start text-lg-center">
              <div>
                <div class="cirlce-container me-2 me-sm-3 mb-lg-3">
                  <i class="feature-icon fa fa-lock"></i>
                </div>
              </div>
              <div>
                <p class="d-block mb-1 fw-bold">Secure Payment</p>
                <p>Shop confidently with secure transactions protecting your privacy.</p>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="d-flex justify-content-between align-items-center flex-row flex-lg-column text-sm-start text-lg-center">
              <div>
                <div class="cirlce-container me-2 me-sm-3 mb-lg-3">
                  <i class="feature-icon fa fa-heart"></i>
                </div>
              </div>
              <div>
                <p class="d-block mb-1 fw-bold">Customer Satisfaction</p>
                <p>Your happiness is our priority, ensuring quality service always.</p>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="d-flex justify-content-between align-items-center flex-row flex-lg-column text-sm-start text-lg-center">
              <div>
                <div class="cirlce-container me-2 me-sm-3 mb-lg-3">
                  <i class="feature-icon fa fa-comments"></i>
                </div>
              </div>
              <div>
                <p class="d-block mb-1 fw-bold">Customer Support</p>
                <p> We're here to assist you anytime, ensuring your needs are met.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- SECTION 6 -->
    <section id="section-six">
      <div class="container">
        <div class="row">
          <div class="col-sm-12 col-lg-6 d-flex flex-column justify-content-center">
            <h1 class="h3 section-header  text-center">INDULGE TO BLISTERING JOY OF LEARNING MUSIC</h1>
            <p class="text-justify">Whether you're a seasoned guitar player, exploring new instrument, or someone who's planning to indulge with the joy of learning their first one, we're here to support your musical journey. Our shop is designed to suit your taste and help to bring you what you came for.</p>
            <div class="d-flex justify-content-center">
              <a href="aboutUs.php" class="btn read-more">Read More </a>
              <a href="mailto:vivalavida2024212@gmail.com" class="btn brown-button">Contact Us <i class="fa fa-external-link"></i></a>
            </div>


          </div>
          <!-- https://drive.google.com/uc?export=download&id=videoID -->
          <!-- https://drive.google.com/uc?id=1TvGROdAOTbfMc8dviAhNQob8TLBiblqE -->
          <div class="col-sm-12 col-lg-6 mt-3">
            <iframe class="video-clip" src="https://drive.google.com/file/d/1EeMo30A_XySg275SPg2LBXN6BuPvaWLr/preview" allow="autoplay"></iframe>
          </div>
        </div>
      </div>
    </section>

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
          <p> <a href="footer content/contactSupport.php">Contact Support</a> </p>
          <p> <a href="footer content/termsAndConditions.php">Terms & Conditions</a> </p>
          <p> <a href="footer content/guidelines.php"> Guidelines </a> </p>
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



  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <!-- Swiper -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="js/swiper.js"></script>
</body>

</html>