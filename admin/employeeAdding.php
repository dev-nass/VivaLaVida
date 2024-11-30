<?php

session_start();
include '../php/connection.php';
$userNameInstance = $_SESSION['Username'];
$userRoleInstance = $_SESSION['Role'];

if (!empty($userNameInstance) and ($userRoleInstance === 'Admin' or $userRoleInstance === 'Employee')) {
  $userNameInstance = $_SESSION['Username'];
  $textColor = "text-danger";
  $actionText = "Logout";
  $actionSign = "fa-solid fa-right-from-bracket";

  // Ensure that certain operations are only visible for the Admin accounts
  $posLimiter = ($userRoleInstance === 'Employee') ? "" : "d-none"; // for Admin not accessing the POS
  $dashboardLimiter = ($userRoleInstance === 'Employee') ? "d-none" : ""; // this is updatedd instead of using if($userRoleInstance === 'Employee')
  // Adding Employee & Adding Customer link, they are on same <a>, will be updated depending on the Role
  $customerAddingDashboardLimiter = ($userRoleInstance === 'Employee') ? "../admin/customerAdding.php" : "../admin/employeeAdding.php";
  // Will update the 'Add Employee' OR 'Add Customer' depending on the Role
  $textChangerDashboard =  ($userRoleInstance === 'Employee') ? "Add Customer" : "Add Employee";

} else {
  // Redirect to 404 page if the user is not logged in
  header('Location: ../404.php');
  exit(); // Stop further execution after redirect
}


?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>VLV | Employee Adding</title>

  <!-- Bootstrap v5.3 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link href="../css/util.css" rel="stylesheet" />

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Child 1 / 3 -->
    <!-- BEGIN SIDEBAR / NAVIGATIION -->
    <!-- Sidebar -->
    <ul class="navbar-nav darkViva-bg sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../admin/adminIndex.php">
        <div class="sidebar-brand-text mx-3">
          <img src="../img/brand-logo-dark.jpg" alt="brand-logo-dark">
        </div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="../admin/adminIndex.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Interface
      </div>

      <!-- Nav Item - Pages Collapse Menu -->

      <li class="nav-item">
        <a class="nav-link <?php echo $posLimiter; ?>" href="../admin/orderingGuitar.php">
          <i class="fa-solid fa-cash-register"></i>
          <span>POS</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="../admin/guitarUploadingForm.php">
          <i class="fas fa-fw fa-upload"></i>
          <span>Upload</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="<?php echo $customerAddingDashboardLimiter; ?>">
          <i class="fa-solid fa-user-plus"></i>
          <span><?php echo $textChangerDashboard; ?></span></a>
      </li>


      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Heading -->
      <div class="sidebar-heading">
        Tables
      </div>

      <li class="nav-item">
        <a class="nav-link" href="../admin/guitarTablePage.php">
          <i class="fa-solid fa-guitar"></i>
          <span>Guitars</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="../admin/guitarTablePagePrice&Stock.php">
          <i class="fa-solid fa-boxes-stacked"></i>
          <span>Prices & Stocks</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="../admin/orderViewTable.php">
          <i class="fa-solid fa-receipt"></i>
          <span>Order</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="../admin/transactionViewTable.php">
          <i class="fa-solid fa-arrow-right-arrow-left"></i>
          <span>Transaction</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="../admin/customerViewTable.php">
          <i class="fa-solid fa-people-group"></i>
          <span>Customers</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link <?php echo $dashboardLimiter ?>" href="../admin/employeeViewTable.php">
          <i class="fa-solid fa-address-book"></i>
          <span>Employee</span></a>
      </li>
    </ul>
    <!-- End of Sidebar -->

    <!-- Child 2 / 3 -->
    <!-- BEGIN OF CENTER CONTENT -->
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="whiteViva-bg d-flex flex-column ">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light whiteViva-bg topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-block rounded-circle mr-3">
            <i class="darkViva-text fa-solid fa-bars"></i>
          </button>



          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <div class="topbar-divider d-block" style="border: .2px solid #3e3731 !important;"></div>

            <!-- Profile -->
            <div class="d-flex align-items-center me-2">
              <span class="darkViva-text"><?php echo $userNameInstance; ?></span>
            </div>
            <div class="ms-auto d-flex align-items-center">
              <div class="profile">
                <div class="dropdown-center">
                  <button class="btn dropdown-toggle no-arrow" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-user"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="normal-font dropdown-item" href="#">Hello, <?php echo $userNameInstance; ?> </a></li>
                    <li>
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

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid whiteViva-bg">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 darkViva-text section-header" style="text-transform: uppercase;">Add Employee</h1>
          </div>

          <!-- Content Row -->
          <div class="row justify-content-center">
            <!-- Form half div 2 / 2 -->
            <div class="col-sm-8 col-lg-6 white-bg p-3">
              <div class="validatorText-container text-center alert d-none" role="alert">
                <span class="validatorTextTrue"></span>
                <span class="validatorTextFalse"></span>
              </div>
              <form id="employeeAddingForm" enctype="multipart/form-data">

                <!-- First Name -->
                <div class="d-flex mb-3">
                  <div class="col-6 ps-0">
                    <label for="employee_fname" class="form-label darkViva-text">First Name</label>
                    <input name="employee_fname" type="text" class="form-control input-search" >
                  </div>
                  <!-- Last Name -->
                  <div class="col-6 pe-0">
                    <label for="employee_lname" class="form-label darkViva-text">Last Name</label>
                    <input name="employee_lname" type="text" class="form-control input-search" >
                  </div>
                </div>

                <div class="mb-3">
                  <!-- Username -->
                  <div class="col-12 ps-0 pe-0">
                    <label for="employee_username" class="form-label darkViva-text">Username</label>
                    <input name="employee_username" type="text" class="form-control input-search">
                  </div>
                </div>

                <div class="d-flex mb-3">
                  <!-- Email -->
                  <div class="col-6 ps-0">
                    <label for="employee_email" class="form-label darkViva-text">Email</label>
                    <input name="employee_email" type="email" class="form-control input-search" placeholder="juan@gmail.com">
                  </div>
                  <!-- Contact Number -->
                  <div class="col-6 pe-0">
                    <label for="employee_contact_number" class="form-label darkViva-text">Contact Number</label>
                    <input name="employee_contact_number" type="text" class="form-control input-search" oninput="this.value = this.value.replace(/[^0-9+\-() ]/g, '');" maxlength="11" placeholder="09XXXXXXXXX">
                  </div>
                </div>

                <div class="d-flex mb-3">
                  <!-- Password -->
                  <div class="col-6 ps-0">
                    <label for="employee_password" class="form-label darkViva-text">Password</label>
                    <input name="employee_password" type="password" class="employee_password_input form-control input-search" placeholder="Enter at least 8 letters" />
                  </div>
                  <!-- Re-type Password -->
                  <div class="col-6 pe-0">
                    <label for="neckMaterialInput" class="form-label darkViva-text">Re-type Password</label>
                    <input name="neckMaterialInput" type="password" class="employee_repassword_input form-control input-search" />
                  </div>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn brown-button">Upload<span><i class="fas fa-fw fa-arrow-up-from-bracket"></i></span></button>
                </div>
              </form>
            </div>

          </div>


        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <!-- <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2021</span>
          </div>
        </div>
      </footer> -->
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->


  <!-- Bootstrap v5.3 -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>


  <!-- Custom JS -->
  <script src="../js/employeeFormValidator.js"></script>
</body>

</html>