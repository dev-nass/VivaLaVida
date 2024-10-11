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
  <link href="css/register.css" rel="stylesheet">
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
              <a href="#" class="nav-link">Register</a>
            </li>
            <li>
              <a href="login.php" class="nav-link">Login</a>
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

  <!-- MAIN -->
  <main>
    <section id="bg-giver" class="vh-100">
      <div class="container">
        <div class="row">
          <div class="col-lg-3"></div>
          <div class="col-lg-6">
            <div id="ui">
              <h1 class="text-center"> VIVA LA VIDA </h1>
              <form class="form-group text-center">
                <div class="row">
                  <div class="col-lg-6">
                    <label> First Name: </label>
                    <input type="text" name="username" class="form-control" placeholder="Enter your First Name">
                  </div>

                  <div class="col-lg-6">
                    <label> Last Name: </label>
                    <input type="text" name="username" class="form-control" placeholder="Enter your Last Name">
                  </div>
                </div>
                <br>

                <div class="row">
                  <div class="col-lg-6">
                    <label> Address: </label>
                    <input type="text" name="address" class="form-control" placeholder="Enter your Address">
                  </div>
                  <div class="col-lg-6">
                    <label> E-Mail: </label>
                    <input type="email" name="email" class="form-control" placeholder="Enter your E-Mail">
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-lg-6">
                    <label> Password </label>
                    <input type="password" name="password" class="form-control" placeholder="Enter your Password">
                  </div>
                  <div class="col-lg-6">
                    <label> Re-Type Password: </label>
                    <input type="password" name="password" class="form-control" placeholder="Re-type your Password">
                  </div>
                </div>
                <br>
                <select class="form-control">
                  <option>Choose Gender</option>
                  <option> Female </option>
                  <option> Male</option>
                  <option> Other</option>
                </select>
                <br>
                <input type="submit" name="submit" value="Submit" class="btn btn-primary btn-block-lg">
              </form>
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


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>