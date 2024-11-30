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

  $guitarAllSql = "SELECT GuitarID, Type, Brand, Model, Guitar_Picture, Fretboard_Material, Neck_Material, Body_Material, Body_Shape, Number_of_Strings, Number_of_Frets, Description FROM guitar";
  $guitarAllStmt = $pdo->prepare($guitarAllSql);
  $guitarAllStmt->execute();
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

  <title>VLV | Guitar Details Table</title>

  <!-- Bootstrap v5.3 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


  <!-- Bootstrap and DataTables CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
  <link href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.bootstrap5.css" rel="stylesheet" />




  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link href="../css/util.css" rel="stylesheet" />
</head>

<body id="page-top">

  <!-- Page Wrapper  -->
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
            <h1 class="h3 mb-0 darkViva-text section-header" style="text-transform: uppercase;">Guitar Details Table</h1>
            <!-- <button type="button" class="btn brown-button mt-2" >
              <i class="fa-solid fa-list"></i>
            </button> -->
          </div>

          <!-- Modal: Guitar Inputs -->
          <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="color: var(--clr-dark);">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5 section-header" id="staticBackdropLabel">Guitar's Information</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div>
                    <div class="row mb-2">
                      <div class="col-12 col-lg-6">
                        <label for="" class="mb-0">Guitar ID:</label>
                        <input class="w-100 px-1" type="text" data-guitar-id disabled>
                      </div>
                      <div class="col-12 col-lg-6">
                        <label for="" class="mb-0">Type:</label>
                        <input class="w-100 px-1" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');" data-guitar-type />
                      </div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-12 col-lg-6">
                        <label for="" class="mb-0">Brand:</label>
                        <input class="w-100 px-1" type="text" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');" data-guitar-brand />
                      </div>
                      <div class="col-12 col-lg-6">
                        <label for="" class="mb-0">Model:</label>
                        <input class="w-100 px-1" type="text" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');" data-guitar-model />
                      </div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-12 col-lg-6">
                        <label for="" class="mb-0">Fret Board Material:</label>
                        <input class="w-100 px-1" type="text" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');" data-guitar-fretBoardMat />
                      </div>
                      <div class="col-12 col-lg-6">
                        <label for="" class="mb-0">Neck Material:</label>
                        <input class="w-100 px-1" type="text" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');" data-guitar-neckMat />
                      </div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-12 col-lg-6">
                        <label for="" class="mb-0">Body Material:</label>
                        <input class="w-100 px-1" type="text" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');" data-guitar-bodyMat />
                      </div>
                      <div class="col-12 col-lg-6">
                        <label for="" class="mb-0">Body Shape:</label>
                        <input class="w-100 px-1" type="text" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');" data-guitar-bodyShape />
                      </div>
                    </div>
                    <div class="row mb-2">
                      <div class="col-12 col-lg-6">
                        <label for="" class="mb-0">Number of Strings:</label>
                        <input class="w-100 px-1" type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '');" data-guitar-numberOfStrings />
                      </div>
                      <div class="col-12 col-lg-6">
                        <label for="" class="mb-0">Number of Frets:</label>
                        <input class="w-100 px-1" type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '');" data-guitar-numberOfFrets />
                      </div>
                    </div>
                    <div class="col-12 px-0">
                      <label class="mb-0">Guitar Image:</label>
                      <input class="form-control w-100" type="file" id="formFile" data-guitar-image>
                    </div>
                    <div>
                      <label class="mb-0">Description</label>
                      <textarea class="form-control" aria-label="With textarea" maxlength="255" data-guitar-description></textarea>
                    </div>
                    <!-- Removed
                    <div class="row mb-2">
                      <div class="col-12 col-lg-6">
                        <label for="" class="mb-0">Price:</label>
                        <input class="w-100 px-1" type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '');" data-guitar-price />
                      </div>
                      <div class="col-12 col-lg-6">
                        <label for="" class="mb-0">Stocks:</label>
                        <input class="w-100 px-1" type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '');" data-guitar-stocks />
                      </div>
                    </div>
                    -->
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-danger archive-btn">Archive</button>
                  <button type="button" class="btn btn-success update-btn">Update</button>
                </div>

              </div>
            </div>
          </div>
          <!-- End of Modal -->

          <!-- Content Row -->
          <div class="row justify-content-center">
            <!-- Form half div 2 / 2 -->
            <div class="col-12 white-bg p-0">

              <!-- Scrollable Table -->
              <div class="responsive-table py-3 px-1" style="color: var(--clr-dark);">
                <table id="guitarTable" class="table table-striped dataTable-Universal">
                  <thead>
                    <tr>
                      <th scope="col">ID</th>
                      <th scope="col">Type</th>
                      <th scope="col">Brand</th>
                      <th scope="col">Model</th>
                      <th scope="col">Picture</th>
                      <th scope="col">Fretboard Material</th>
                      <th scope="col">Neck Material</th>
                      <th scope="col">Body Matetrial</th>
                      <th scope="col">Body Shape</th>
                      <th scope="col">Num of Strings</th>
                      <th scope="col">Number of Frets</th>
                      <th scope="col">Action</th>
                      <th scope="col">Description</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    while ($guitarDataBase = $guitarAllStmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                      <tr>
                        <th scope="col" guitar-id-col><?php echo $guitarDataBase['GuitarID']; ?></th>
                        <td guitar-type-col><?php echo $guitarDataBase['Type']; ?></td>
                        <td guitar-brand-col><?php echo $guitarDataBase['Brand']; ?></td>
                        <td guitar-model-col><?php echo $guitarDataBase['Model']; ?></td>
                        <td><img src="<?php echo $guitarDataBase['Guitar_Picture'] ?>" alt="guitarImg" data-guitar-col-img></td>
                        <td guitar-fretMat-col><?php echo $guitarDataBase['Fretboard_Material']; ?></td>
                        <td guitar-neckMat-col><?php echo $guitarDataBase['Neck_Material']; ?></td>
                        <td guitar-bodyMat-col><?php echo $guitarDataBase['Body_Material']; ?></td>
                        <td guitar-BodyShape-col><?php echo $guitarDataBase['Body_Shape']; ?></td>
                        <td guitar-numOfStrings-col><?php echo $guitarDataBase['Number_of_Strings']; ?></td>
                        <td guitar-numberOfFrets-col><?php echo $guitarDataBase['Number_of_Frets']; ?></td>
                        <td><button id="edit-btn" type="button" class="btn brown-button" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Edit</button></td>
                        <td guitar-description-col><?php echo $guitarDataBase['Description']; ?></td>
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

      </div>

      <!-- Footer -->
      <!-- <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2021</span>
          </div>
        </div>
      </footer> -->
      <!-- End of Footer -->


      <!-- Scroll to Top Button-->
      <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
      </a>
    </div>
    <!-- End of Child 2 -->

  </div>
  <!-- End of Wrapper -->










  <!-- Bootstrap core JavaScript-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>


  <!-- Custom Vanilla JavaScript -->
  <script src="../js/guitarTableHandler.js"></script>


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


</html>