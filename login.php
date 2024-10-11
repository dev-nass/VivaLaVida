<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Star Icons Cloud Flare -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
  crossorigin="anonymous" referrerpolicy="no-referrer"/>
  <!-- Custom CSS -->
  <link href="css/login.css" rel="stylesheet">
  <link href="css/util.css" rel="stylesheet"/>
  <link href="css/navbar.css" rel="stylesheet"/>
  <link href="css/footer.css" rel="stylesheet"/>
</head>

<body>
  <!-- HEADER -->
  <header class="main-header">
    <nav class="navbar header-nav navbar-expand-lg">
      <div class="container">
        <!-- Brand Name/logo -->
        <a id="brand" href="#">
          <div class="mb-0"><img src="img/brand-logo.jpg" alt=""></div>
        </a>

        <!-- Menu -->
        <div id="navbar-collapse-toggle" class="collapse navbar-collapse justify-content-end">
          <ul class="navbar-nav mx-auto">
            <li>
              <a href="index.php" class="nav-link">Home</a>
            </li>
            <li>
              <a href="aboutUs.php" class="nav-link">About Us</a>
            </li>
            <li>
              <a href="register.php" class="nav-link">Register</a>
            </li>
            <li>
              <a href="#" class="nav-link">Login</a>
            </li>
          </ul>

          <div id="div-search" class="ms-auto d-flex d-lg-none justify-content-center">
            <input id="input-search" class="form-control w-auto me-2" type="search" placeholder="Search" aria-label="Search">
            <button id="button-search" class="btn btn-outline-light" type="submit">Search</button>
          </div>



        </div>

        <!-- Seach Bar -->
        <div class="ms-auto d-none d-lg-flex">
          <input id="input-search" class="form-control w-auto me-2" type="search" placeholder="Search" aria-label="Search">
          <button id="button-search" class="btn btn-outline-success" type="submit">Search</button>
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
    <section class="vh-100">
      <div class="container py-5 h-100">
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
                    <form>

                      <!-- logo icon -->
                      <div class="d-flex align-items-center mb-3 pb-1">
                        <img src="img/login & register/logo_icon.png" alt="logo icon" class="me-3 icon">
                        <span class="h1 fw-bold mb-0 myfont">Viva la Vida</span>
                      </div>

                      <h5 class=" mb-2 pb-2 myfont fw-semibold">Sign into your account</h5>

                      <!-- email -->
                      <div data-mdb-input-init class="form-outline mb-1">
                        <input type="email" id="email" class="form-control form-control-lg myfont" placeholder="Username or Email" />
                        <label class="form-label myfont fw-semibold" for="">Email address</label>
                      </div>

                      <!-- password -->
                      <div data-mdb-input-init class="form-outline mb-1">
                        <input type="password" id="password" class="form-control form-control-lg myfont" placeholder="Enter at least 6 characters..." />
                        <label class="form-label myfont fw-semibold" for="">Password</label>
                      </div>

                      <!-- login button -->
                      <div class="pt-1 mb-4">
                        <button class="btn btn-lg btn-block myfont" type="button">Login</button>
                      </div>

                      <!-- register at terms at not now-->
                      <div class="text-center mt-3 fw-semibold">
                        <a href="#!">Not Now</a>
                        <p class="mb-0 pb-lg--2">Don't have an account? <a href="#!">Register here</a></p>

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

  <!-- FOOTER -->
  <footer class=" text-white pt-5 pb-4" style="background-color: #3e3731;">
    <div class="container text-md-left">
      <!-- about our company -->
      <div class="row text-md-left">

        <!-- Company name -->
        <div class="col-sm-12 col-md-6 col-lg-3">
          <h1 class="text-warning">VL<span style="color: var(--clr-white);">V</span></h1>
          <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Cumque odit, obcaecati quo suscipit alias ducimus.</p>
        </div>

        <!-- Contact -->
        <div class="col-sm-12 col-md-6 col-lg-3">
          <h4 class="text-uppercase mb-4 font-weight-bold text-warning"> Contact US </h4>
          <p>
            <i class="fa-solid fa-location-dot"></i> Dasmarinas, Cavite, PH
          </p>
          <p>
            <i class="fa-regular fa-envelope"></i> <a href="mailto:tampol.ninomarcoc.kld@gmail.com"> VivalaVida@gmail.com </a>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>