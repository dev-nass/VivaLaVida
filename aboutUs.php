<?php

session_start();
include 'php/connection.php';

if (!empty($_SESSION['Username']) and $_SESSION['Role'] === 'User') {
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


?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us</title>

  <!--Bootstrap Link-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <!-- Star Icons Cloud Flare -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Custom CSS -->
  <link href="css/aboutUs.css" rel="stylesheet">
  <link href="css/util.css" rel="stylesheet" />
  <link href="css/navbar.css" rel="stylesheet" />
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


  <main>
    <!-- SECTION 1 -->
    <section id="hero">
      <div class="container min-vh-100 d-flex align-items-center justify-content-center text-center"">
        <div class=" row">
        <div class="col-12">
          <h1 class="text-uppercase text-white fw-semibold display-1 anton-font">LONG LIVE LIFE</h1>
          <p class="text-white">That's the name of shop translated to english. Living a life full of creativity and expressing oneself is a fulfilling one, it allows us to enjoy more of life's grace. Hence, our shop aims to foster creative expression through music, empowering individuals to explore and share their unique sound.</p>
        </div>
      </div>
      </div>
    </section>

    <!-- SECTION 2 -->
    <section id="whyWeCreateThis">
      <div class="container">
        <div class="row">
          <h1 class="anton-font display-3 text-center">WHY WE CREATED THIS</h1>
          <div class="d-flex flex-column align-items-center flex-lg-row border">
            <div id="logo-description-container" class="col-sm-12 col-lg-6 d-flex flex-column d-flex flex-row justify-content-center ps-2 pe-2 p-lg-0">
              <p>This web-based system is our final project for this semester. A large-scale project like this will serve as our foundation for understanding web systems and the tech stack that encompasses them.</p>
              <p>Our group shares one thing in common: a love for music. Each of us has our own unique musical taste. This is perhaps the reason why we came together and started this Point of Sale Guitar Store named Viva La Vida.</p>
            </div>
            <div id="logo-square-container" class="col-sm-12 col-lg-6 d-flex justify-content-center">
              <div class="card" style="width: 23rem;">
                <img src="img/about us/brand-square.png" alt="logo">
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- SECTION 3 -->
    <section id="membersSection">
      <div class="container">
        <div class="row justify-content-center">
          <h1 class="anton-font display-3 text-center">OUR TEAM</h1>
          <p class="text-center mb-0">We are group of students from BSCIS 212</p>
          <!-- Bootstrap Card -->
          <div class="row row-cols-1 row-cols-md-2 g-4 border">
            <div class="col">
              <div class="card">
                <img class="member-bg" src="img/about us/bg-1.jpg" class="card-img-top" alt="...">
                <div class="card-body pr">
                  <img class="member" src="img/about us/paetuc.jpg" alt="">
                  <h5 class="card-title pt-5 text-center">Jonas Vince Macawile</h5>
                  <p class="card-text text-center">Admin Programmer</p>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card">
                <img class="member-bg" src="img/about us/bg-2.jpg" class="card-img-top" alt="...">
                <div class="card-body pr">
                  <img class="member" src="img/about us/noel.jpg" alt="">
                  <h5 class="card-title pt-5 text-center">Noel Gurrero Jr.</h5>
                  <p class="card-text text-center">Business Process Manager</p>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card">
                <img class="member-bg" src="img/about us/bg-3.jpg" class="card-img-top" alt="...">
                <div class="card-body pr">
                  <img class="member" src="img/about us/alien.jpg" alt="">
                  <h5 class="card-title pt-5 text-center">Nino Marco Tampol</h5>
                  <p class="card-text text-center">Front-End Programmer</p>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card">
                <img class="member-bg" src="img/about us/bg-4.jpg" class="card-img-top" alt="...">
                <div class="card-body pr">
                  <img class="member" src="img/about us/martin.jpg" alt="">
                  <h5 class="card-title pt-5 text-center">Martin Greg Taguiad</h5>
                  <p class="card-text text-center">Back-end Programmer</p>
                </div>
              </div>
            </div>

            <div class="col">
              <div class="card">
                <img class="member-bg" src="img/about us/bg-5.jpg" class="card-img-top" alt="...">
                <div class="card-body pr">
                  <img class="member" src="img/about us/axcel.jpg" alt="">
                  <h5 class="card-title pt-5 text-center">Axcel Rose Javillo</h5>
                  <p class="card-text text-center">Front-end Programmer</p>
                </div>
              </div>
            </div>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>