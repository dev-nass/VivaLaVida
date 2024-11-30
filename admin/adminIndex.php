<?php

session_start();
include '../php/connection.php';
$userNameInstance = $_SESSION['Username'];
$userEmailInstance = $_SESSION['Email'];
$userPassInstance = $_SESSION['Password'];
$userRoleInstance = $_SESSION['Role'];


// UPDATE THIS CONSIDIDTION

if (!empty($userNameInstance) && ($userRoleInstance === 'Admin' or $userRoleInstance === 'Employee')) {
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


  // FOR TOTAL SALES
  $totalSalesSql = "SELECT SUM(Total_Price) as Total_Sales FROM urder;";
  $totalSalesStmt = $pdo->prepare($totalSalesSql);
  $totalSalesStmt->execute();
  $overAllSales = $totalSalesStmt->fetch(PDO::FETCH_ASSOC)['Total_Sales'];

  $totalSalesFormatted = number_format($overAllSales); // Format the total sales with commas as thousands separators



  // FOR TOTAL ORDER
  $allOrdersSql = "SELECT COUNT(*) AS Order_Count FROM urder";
  $allOrdersStmt = $pdo->prepare($allOrdersSql);
  $allOrdersStmt->execute();
  $overAllOrders = $allOrdersStmt->fetch(PDO::FETCH_ASSOC)['Order_Count'];

  $allOrdersFormated = number_format($overAllOrders);



  // FOR TOTAL STOCKS
  $totalStocksSql = "SELECT SUM(Stocks) as Total_Stocks FROM guitar;";
  $totalStocksStmt = $pdo->prepare($totalStocksSql);
  $totalStocksStmt->execute();
  $overAllStocks = $totalStocksStmt->fetch(PDO::FETCH_ASSOC)['Total_Stocks'];

  $totalStocksFormatted = number_format($overAllStocks);


  // FOR TOTAL CUSTOMER
  $allCustomerSql = "SELECT COUNT(*) as Customer_Count FROM user WHERE Purchase_Status = 'Walk-in'; ";
  $allCustoemrStmt = $pdo->prepare($allCustomerSql);
  $allCustoemrStmt->execute();
  $overAllCustomer = $allCustoemrStmt->fetch(PDO::FETCH_ASSOC)['Customer_Count'];

  $allCustomerFormated = number_format($overAllCustomer);



  // FOR PREVIEWS ORDER
  $previewsTransactionSql =
    "SELECT 
      u.Order_ID, 
      u.Transaction_ID, 
      CONCAT(c.First_Name, ' ', c.Last_Name) AS Customer_Info, 
      CONCAT(g.Brand, ' ', g.Model) AS Guitar_Detail, 
      g.Guitar_Picture, 
      u.Quantity, 
      u.Total_Price
    FROM 
      urder AS u
    INNER JOIN 
      guitar AS g ON u.Guitar_ID = g.GuitarID
    INNER JOIN 
    `transaction` AS t ON u.Transaction_ID = t.Transaction_ID
    INNER JOIN 
      user AS c ON t.User_ID = c.User_ID
    ORDER BY 
      u.Order_ID DESC;";

  $previewsTransactionStmt = $pdo->prepare($previewsTransactionSql);
  $previewsTransactionStmt->execute();



  // FOR MOST SALE ITEMS
  $topItemsSql =
    "SELECT u.Guitar_ID, CONCAT(g.Brand , ' ', g.Model) as Guitar_Detail, g.Guitar_Picture , SUM(u.Quantity) AS Most_Sale_Item
    FROM urder AS u
    INNER JOIN guitar AS g ON u.Guitar_ID = g.GuitarID
    GROUP BY u.Guitar_ID ORDER BY Most_Sale_Item DESC
    LIMIT 5;";
  $topItemsStmt = $pdo->prepare($topItemsSql);
  $topItemsStmt->execute();
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

  <title>VLV | Admin Dashboard</title>


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <!-- Star Icons Cloud Flare -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Custom fonts for this template-->
  <!-- <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> -->
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

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
            <h1 class="h3 mb-0 darkViva-text section-header" style="text-transform: uppercase;">Dashboard</h1>
          </div>

          <!-- Content Row -->
          <div class="row">


            <!-- Total Earnings -->
            <div class="col-xl-3 col-md-6 mb-4">
              <a class="brown-button" href="../admin/transactionViewTable.php">
                <div class="card shadow h-100 py-2">
                  <div class="card-body py-2 px-3">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">
                          <p class="darkViva-text mb-0">Total Earning</p>
                          <span>(Overall)</span>
                        </div>

                      </div>
                      <div class="col-auto">
                        <div class="darkViva-bgv2">
                          <i class="fa-solid fa-peso-sign"></i>
                        </div>
                      </div>
                    </div>
                    <!-- Amount of Earning -->
                    <div class="row">
                      <div class="h3 mt-2 mb-0 font-weight-bold text-gray-800"><?php echo $totalSalesFormatted; ?></div>
                    </div>
                  </div>
                </div>
              </a>
            </div>


            <!-- Total Orders -->
            <div class="col-xl-3 col-md-6 mb-4">
              <a class="brown-button" href="../admin/orderViewTable.php">
                <div class="card shadow h-100 py-2">
                  <div class="card-body py-2 px-3">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">
                          <p class="darkViva-text mb-0">Total Orders</p>
                          <span>(Overall)</span>
                        </div>

                      </div>
                      <div class="col-auto">
                        <div class="darkViva-bgv2">
                          <i class="fa-solid fa-receipt"></i>
                        </div>
                      </div>
                    </div>
                    <!-- Total of Orders -->
                    <div class="row">
                      <div class="h3 mt-2 mb-0 font-weight-bold text-gray-800"><?php echo $allOrdersFormated; ?></div>
                    </div>
                  </div>
                </div>
              </a>
            </div>


            <!-- Total Stocks -->
            <div class="col-xl-3 col-md-6 mb-4">
              <a class="brown-button" href="../admin/guitarTablePagePrice&Stock.php">
                <div class="card shadow h-100 py-2">
                  <div class="card-body py-2 px-3">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">
                          <p class="darkViva-text mb-0">Guitar Stocks</p>
                        </div>

                      </div>
                      <div class="col-auto">
                        <div class="darkViva-bgv2">
                          <i class="fa-solid fa-boxes-stacked"></i>
                        </div>
                      </div>
                    </div>
                    <!-- Total of Stocks -->
                    <div class="row">
                      <div class="h3 mt-2 mb-0 font-weight-bold text-gray-800"><?php echo $totalStocksFormatted; ?></div>
                    </div>
                  </div>
                </div>
              </a>
            </div>


            <!-- Overall Customer / Total Customer  -->
            <div class="col-xl-3 col-md-6 mb-4">
              <a class="brown-button" href="../admin/customerViewTable.php">
                <div class="card shadow h-100 py-2">
                  <div class="card-body py-2 px-3">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">
                          <p class="darkViva-text mb-0">Customer Count</p>

                        </div>

                      </div>
                      <div class="col-auto">
                        <div class="darkViva-bgv2">
                          <i class="fa-solid fa-people-group"></i>
                        </div>
                      </div>
                    </div>
                    <!-- Total of Visit -->
                    <div class="row">
                      <div class="h3 mt-2 mb-0 font-weight-bold text-gray-800"><?php echo $allCustomerFormated ?></div>
                    </div>
                  </div>
                </div>
              </a>
            </div>

          </div>

          <!-- Content Row -->

          <div class="row">
            <div class="col-12">
              <div class="card mb-4 ">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between darkViva-bg">
                  <h6 class="m-0 font-weight-bold whiteViva-text">Recent Orders</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body p-1">
                  <!-- Scrollable Table -->
                  <div style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th scope="col">Order ID</th>
                          <th scope="col">Transaction ID</th>
                          <th scope="col">Full Name</th>
                          <th scope="col">Guitar Detail</th>
                          <th scope="col">Picture</th>
                          <th scope="col">Quantity</th>
                          <th scope="col">Total Price</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        while ($customerDataBase = $previewsTransactionStmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                          <tr class="customerRow">
                            <th scope="row" customer-id-col><?php echo $customerDataBase['Order_ID']; ?></th>
                            <td customer-fname-col><?php echo $customerDataBase['Transaction_ID']; ?></td>
                            <td customer-lname-col><?php echo $customerDataBase['Customer_Info']; ?></td>
                            <td customer-number-col><?php echo $customerDataBase['Guitar_Detail']; ?></td>
                            <td customer-number-col><img src="<?php echo $customerDataBase['Guitar_Picture']; ?>" alt="guitar-img" height="80px" width="100px" /></td>
                            <td customer-number-col><?php echo $customerDataBase['Quantity']; ?></td>
                            <td customer-number-col><?php echo number_format($customerDataBase['Total_Price'], 2); ?></td>
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

          <div class="row">
            <!-- Pie Chart -->
            <div class="col-12">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between darkViva-bg">
                  <h6 class="m-0 font-weight-bold whiteViva-text">Most Sales</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body p-1">
                  <!-- Scrollable Table -->
                  <div style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th scope="col">Guitar ID</th>
                          <th scope="col">Guitar Detail</th>
                          <th scope="col">Picture</th>
                          <th scope="col">Number of Sales</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        while ($topItems = $topItemsStmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                          <tr class="customerRow">
                            <th scope="row" customer-id-col><?php echo $topItems['Guitar_ID']; ?></th>
                            <td customer-fname-col><?php echo $topItems['Guitar_Detail']; ?></td>
                            <td customer-fname-col><img src="<?php echo $topItems['Guitar_Picture']; ?>" alt="guitar-img" height="80px" width="90px" /></td>
                            <td customer-fname-col><?php echo $topItems['Most_Sale_Item']; ?></td>
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

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>


    <!-- Bootstrap core JavaScript-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>


    <!-- Chart.js -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js" integrity="sha512-L0Shl7nXXzIlBSUUPpxrokqq4ojqgZFQczTYlGjzONGTDAcLremjwaWv5A+EDLnxhQzY5xUZPWLOLqYRkY0Cbw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <!-- <script src="../js/totalEarnings.js"></script> -->
</body>

</html>