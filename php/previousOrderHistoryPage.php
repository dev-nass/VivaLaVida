<?php

// CHANGE THE CUSTOM JS AT THE BOTTOM IF SIR DENIED AND INSTRUCTED THAT YOU SHOULD HAVE ACTION BTNS ON THIS


session_start();
include '../php/connection.php';
$userNameInstance = $_SESSION['Username'];

if (!empty($_SESSION['Username'])) {
  // Used for dynamically updating the navbar contents
  $userNameInstance = $_SESSION['Username'];
  $textColor = "text-danger";
  $actionText = "Logout";
  $actionSign = "fa-solid fa-right-from-bracket";

  // for the tables
  $userIdInstance = $_SESSION['User_ID'];
  $previousOrderSql =
    "SELECT urder.Order_ID, CONCAT(guitar.Brand, ' ',guitar.Model) AS Guitar_Detail, guitar.Guitar_Picture, transaction.Transaction_Date, urder.Quantity, urder.Total_Price
    FROM urder
    INNER JOIN guitar ON urder.Guitar_ID=guitar.GuitarID
    INNER JOIN transaction ON urder.Transaction_ID=transaction.Transaction_ID
    INNER JOIN user ON transaction.User_ID=user.User_ID
    WHERE transaction.User_ID = :userId";
  $previousorderStmt = $pdo->prepare($previousOrderSql);
  $previousorderStmt->bindParam(":userId", $userIdInstance);
  $previousorderStmt->execute();

  // For navbar profile picture
  $profilePicture = (!empty($_SESSION['Profile_Picture'])) ? $_SESSION['Profile_Picture'] : '../image retrieverv2/userProfiles/default-user-profile.png';

  // For navbar recent orders
  if (empty($_SESSION['Purchase_Status'])) {
    $previousOrder = "d-none";
  }
} else {
  header('Location: ../404.php');
  exit();
}

$profileAnchor = (!empty($_SESSION['Username'])) ? '../php/profile.php' : '../loginForm.php';

?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>VLV | Previous Order</title>
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- Bootstrap and DataTables CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
  <link href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.bootstrap5.css" rel="stylesheet" />

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
  <main class="py-5 h-100">
    <div class="container py-5">
      <div class="pt-3">
        <h1 class="g-0 text-center section-header">Previous Order History</h1>
      </div>
      <div class="row">
        <div class="col-12 mt-2">
          <div>
            <table class="table table-striped dataTable-Universal">
              <thead class="darkViva-bg">
                <tr>
                  <th scope="col">Order ID</th>
                  <th scope="col">Guitar Detail</th>
                  <th scope="col">Picture</th>
                  <th scope="col">Transaction Date</th>
                  <th scope="col">Quantity</th>
                  <th scope="col">Total Price</th>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($previousOrderDatabase = $previousorderStmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                  <tr class="customerRow">
                    <th scope="row" customer-id-col><?php echo $previousOrderDatabase['Order_ID']; ?></th>
                    <td customer-fname-col><?php echo $previousOrderDatabase['Guitar_Detail']; ?></td>
                    <td customer-lname-col><img src="<?php echo $previousOrderDatabase['Guitar_Picture']; ?>" alt="guitar-pic" height="80px" width="100px" /></td>
                    <td customer-number-col><?php echo $previousOrderDatabase['Transaction_Date']; ?></td>
                    <td customer-number-col><?php echo $previousOrderDatabase['Quantity']; ?></td>
                    <td customer-number-col><?php echo number_format($previousOrderDatabase['Total_Price'], 2); ?></td>
                  </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
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










  <!-- Bootstrap core JavaScript-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>



  <!-- jQuery and Bootstrap JavaScript -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

  <!-- DataTables JavaScript -->
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
  <script src="https://cdn.datatables.net/responsive/3.0.3/js/dataTables.responsive.js"></script>
  <script src="https://cdn.datatables.net/responsive/3.0.3/js/responsive.bootstrap5.js"></script>

  <script src="../js/dataTable.js"></script>

  <!-- <script src="../js/transactionTableHandler.js"></script> -->
</body>

</html>