<?php
session_start();
include '../php/connection.php';
$userNameInstance = $_SESSION['Username'];
$userEmailInstance = $_SESSION['Email'];
$userPassInstance = $_SESSION['Password'];
$userRoleInstance = $_SESSION['Role'];

// Update condition HERE

if (!empty($userNameInstance) and !empty($userEmailInstance) and !empty($userPassInstance) and ($userRoleInstance === 'Admin' or $userRoleInstance === 'Employee')) {
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

  $sql = "SELECT * FROM guitar";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();

  $stmtEmployee = $pdo->prepare("SELECT Employee_ID, Password FROM employee WHERE Username = :user AND Email = :email");
  $stmtEmployee->execute([
    ':user' => $userNameInstance,
    ':email' => $userEmailInstance
  ]);

  // Contains the ID and Password
  $employeeOfTheDay = $stmtEmployee->fetch(PDO::FETCH_ASSOC);

  if ($employeeOfTheDay && password_verify($userPassInstance, $employeeOfTheDay['Password'])) {
    $employeeId = $employeeOfTheDay['Employee_ID'];

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


    // Query with LIMIT and OFFSET
    $sql = "SELECT User_ID, First_Name, Last_Name, Email, Contact_Number, Purchase_Status FROM user";
    $customerStmt = $pdo->prepare($sql);
    $customerStmt->execute();
  } else {
    echo "No employee found with the provided credentials.";
  }
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

  <title>VLV | Ordering Guitar</title>

  <!-- Boostrap v5.2 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- Star Icons Cloud Flare -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Template Custom -->
  <!-- <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> -->
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link href="css/orderGuitar.css" rel="stylesheet" />
  <link href="../css/util.css" rel="stylesheet" />

</head>

<body id="page-top">
  <input class="employee-id d-none" type="text" value="<?php echo $employeeId; ?>" />
  <input class="employee-name d-none" type="text" value="<?php echo $userNameInstance; ?>" />

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
    <div id="content-wrapper" class="whiteViva-bg d-flex flex-column">
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

      <!-- Main Contents -->
      <div id="content" class="tracker">

        <div class="row">



          <!-- left-side -->
          <div class="col-12 px-3">
            <div>



              <!-- Page Content -->
              <div id="products-main-container" class="container-fluid">

                <!-- Page Heading -->
                <div id="page-heading" class="d-sm-flex align-items-center justify-content-between mb-4">
                  <h1 class="h3 mb-0 darkViva-text section-header" style="text-transform: uppercase;">Guitar Dashboard</h1>
                  <div class="d-flex align-items-center">
                    <div class="me-1 d-flex">
                      <input id="searchGuitarAdmin-input" class="form-control input-search me-1" type="text" placeholder="Search Guitar" />
                      <button class="btn brown-button" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop" aria-controls="offcanvasTop"><i class="fa fa-sort"></i></button>
                    </div>
                    <button class="btn brown-button" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling"><i class="fas fa-bag-shopping"></i></button>
                  </div>
                </div>

                <!-- Filtering Offcanvas -->
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
                          <input type="checkbox" class="brand-filter" value="<?php echo $brandFilter['Brand']; ?>" />
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
                          <input type="checkbox" class="type-filter" value="<?php echo $typeFilter['Type']; ?>" />
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
              </div>

              <div class="container-fluid pb-3">
                <!-- Content Row -->
                <div class="row">
                  <?php
                  while ($databaseData = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    // $_SESSION['GuitarID'] = $databaseData['GuitarID'];
                    // $_SESSION['Name'] = $databaseData['Name'];
                    // $_SESSION['Brand'] = $databaseData['Brand'];
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
                            <button onclick="addGuitar(<?php echo $databaseData['GuitarID']; ?>)" class="btn border-giver brown-button w-100">Add Item <i class="fa fa-external-link"></i></button>
                          </div>
                        </div>
                      </div>
                    </div>

                  <?php
                  }
                  ?>
                </div>


              </div>
              <!-- End Page content or /.container-fluid -->
            </div>
            <!-- End of Left side -->
          </div>


          <!-- RIGHT SIDE -->
          <div class="offcanvas offcanvas-end whiteViva-bg" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
            <div class="offcanvas-header">
              <h1 class="h3 mb-0 darkViva-text">Order Items</h1>
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
              <div class="right-content p-2 whiteViva-bg">
                <div class="ordered-items">
                  <!-- content here are created through JS -->
                </div>
                <div class="item-prices row">
                  <div class="col-6 text-start totalPriceText"></div>
                  <div class="col-6 text-end totalPriceValue font-weight-bold"></div>
                  <!-- content here are created through JS -->
                </div>

                <!-- Modal Start -->
                <div>


                  <!-- Modal: Customer Information -->
                  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5 section-header" id="staticBackdropLabel">Customer's Information</h1>
                          <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>  -->
                        </div>
                        <div class="modal-body">
                          <div>
                            <div class="row mb-2">
                              <div class="col-12 col-lg-4">
                                <label for="" class="mb-0">User ID:</label>
                                <input class="w-100 px-1" type="text" data-user-id disabled>
                              </div>
                              <div class="col-12 col-lg-4">
                                <label for="" class="mb-0">First Name:</label>
                                <input class="w-100 px-1" type="text" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');" data-user-fname />
                              </div>
                              <div class="col-12 col-lg-4">
                                <label for="" class="mb-0">Last Name:</label>
                                <input class="w-100 px-1" type="text" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');" data-user-lname />
                              </div>
                            </div>
                            <div class="row mb-2">
                              <div class="col-12 col-lg-8">
                                <label for="" class="mb-0">Email:</label>
                                <input class="w-100 px-1" type="email" data-user-email />
                              </div>
                              <div class="col-12 col-lg-4">
                                <label for="" class="mb-0">Contact Number:</label>
                                <input class="w-100 px-1" type="text" oninput="this.value = this.value.replace(/[^0-9+\-() ]/g, '');" data-user-number maxlength="11" placeholder="09XXXXXXXXX"/>
                              </div>
                            </div>
                            <div class="row mb-1 ">
                              <div class="col-12 col-lg-4">
                                <label for="" class="mb-0">Search Customer</label>
                                <input class="w-100 px-1" type="text" placeholder=". . ." data-user-search />
                              </div>
                            </div>



                          </div>
                          <div>

                          </div>

                          <!-- Scrollable Table -->
                          <div style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-striped">
                              <thead>
                                <tr>
                                  <th scope="col">User ID</th>
                                  <th scope="col">First Name</th>
                                  <th scope="col">Last Name</th>
                                  <th scope="col">Email</th>
                                  <th scope="col">Contact Number</th>
                                  <th scope="col">Purchase Status</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                while ($customerDataBase = $customerStmt->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                  <tr class="userRow">
                                    <th scope="row" user-id-col><?php echo $customerDataBase['User_ID']; ?></th>
                                    <td user-fname-col><?php echo $customerDataBase['First_Name']; ?></td>
                                    <td user-lname-col><?php echo $customerDataBase['Last_Name']; ?></td>
                                    <td user-email-col><?php echo $customerDataBase['Email']; ?></td>
                                    <td user-number-col><?php echo $customerDataBase['Contact_Number']; ?></td>
                                    <td user-purchase-status-col><?php echo $customerDataBase['Purchase_Status']; ?></td>
                                    <td><button type="button" class="btn brown-button select-btn">Select</button></td>
                                  </tr>
                                <?php
                                }
                                ?>
                              </tbody>
                            </table>
                          </div>


                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-success update-btn">Update</button>
                          <button type="button" class="btn btn-danger proceed-btn" data-bs-dismiss="modal">Proceed</button>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>

                <!-- Place Order -->
                <div class="place-order-container d-none mt-1">
                  <label for="paymentAmount">Payment Amount:</label>
                  <div class="d-flex">
                    <div class="col-2 py-2 g-0 flex-center pesoHolder" style="background-color: #198754;">
                      <span class="m-0 h-100 text-center flex-center text-white">₱</span>
                    </div>
                    <div class="col-10 p-0 g-0">
                      <input name="paymentAmound" type="text" class="h-100 ps-1 amount-paid w-100 paymentHolder input-search" bayadKoPo oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^(\d+\.\d{0,2}).*/g, '$1');" maxlength="7">
                    </div>
                  </div>

                  <div class="d-flex justify-content-end">
                    <div class="col-10 p-0">
                      <button onclick="placeOrder()" class="place-order-btn btn brown-button w-100 mt-2">Place Order</button>
                    </div>
                    <div class="col-2">
                      <button type="button" class="btn brown-button mt-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        <i class="fa-solid fa-user"></i>
                      </button>
                    </div>
                  </div>

                  <!-- Holds the Selected Customer Information -->
                  <div class="alert alert-light customer-row my-2 d-none darkViva-text" role="alert">
                  </div>

                  <!-- Holds the Visible Receipt -->
                  <div class="receipt-generate-container"></div>

                </div>

              </div>
            </div>
          </div>



        </div>



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


  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/sb-admin-2.min.js"></script>


  <!-- Custom Vanilla JavaScript -->
  <script src="../js/borderStyle.js"></script> <!-- onclick red border -->
  <script src="../js/quantityHandler.js"></script> <!-- event listener for add and minus quantity btns -->
  
  <!-- Vanilla JavaScript sending AJAX request on JSON format -->
  <script src="../js/rightContent.js"></script>
  <script src="../js/customerSearchList.js"></script>
</body>

</html>