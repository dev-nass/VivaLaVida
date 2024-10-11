<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Viva La Vida | Guitar Shop</title>
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <!-- Swiper -->
  <link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet" />
  <!-- Star Icons Cloud Flare -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
  crossorigin="anonymous" referrerpolicy="no-referrer"/>
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
        <a id="brand" href="#">
          <div class="mb-0"><img src="img/brand-logo.jpg" alt=""></div>
        </a>

        <!-- Menu -->
        <div id="navbar-collapse-toggle" class="collapse navbar-collapse justify-content-end">
          <ul class="navbar-nav mx-auto">
            <li>
              <a href="#" class="nav-link">Home</a>
            </li>
            <li>
              <a href="aboutUs.php" class="nav-link">About Us</a>
            </li>
            <li>
              <a href="register.php" class="nav-link">Register</a>
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
                <div class="carousel-item active">
                  <picture>
                    <source media="(max-width: 799px)" srcset="img/acoustic-guitar-collection-cover-mb.png" />
                    <source media="(min-width: 800px)" srcset="img/acoustic-guitar-collection-cover.png">
                    <img src="img/acoustic-guitar-collection-cover.png" class="d-block w-100" alt="...">
                  </picture>
                </div>
                <div class="carousel-item">
                  <picture>
                    <source media="(max-width: 799px)" srcset="img/electric-guitar-collection-cover-mb.png" />
                    <source media="(min-width: 800px)" srcset="img/electric-guitar-collection-cover.png" />
                    <img src="img/electric-guitar-collection-cover.png" class="d-block w-100" alt="...">
                  </picture>
                </div>
                <div class="carousel-item">
                  <picture>
                    <source media="(max-width: 799px)" srcset="img/bass-guitar-collection-cover-mb.png" />
                    <source media="(min-width: 800px)" srcset="img/bass-guitar-collection-cover.png">
                    <img src="img/acoustic-drums-collection-cover.png" class="d-block w-100" alt="...">
                  </picture>
                </div>
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
          <div class="col-sm-12 col-lg-6">
            <a href="#"><img src="img/feature-1.png" alt="..."></a>
          </div>
          <div class="col-sm-12 col-lg-6 mt-2">
            <a href="#"><img src="img/feature-2.png" alt="..."></a>
          </div>
        </div>
      </div>
    </section>

    <!-- SECTON 3 -->
    <section id="section-three">
      <div class="container">
        <h1 class="h2 section-header">SHOP BY BRAND</h1>
        <!-- Slider main container -->
        <div id="logo-swiper" class="card-wrapper swiper border">
          <!-- Additional required wrapper -->
          <ul class="card-list swiper-wrapper">
            <li class="card-item swiper-slide">
              <div class="category-logo-container">
                <a href="#">
                  <img class="category-logo" src="img/logo/fender.png" alt="fender-logo">
                </a>
              </div>
            </li>
            <li class="card-item swiper-slide">
              <div class="category-logo-container">
                <a href="#">
                  <img class="category-logo" src="img/logo/squier.png" alt="squier-logo">
                </a>
              </div>
            </li>
            <li class="card-item swiper-slide">
              <div class="category-logo-container">
                <a href="#">
                  <img class="category-logo" src="img//logo/mr-logo.png" alt="mr-logo">
                </a>
              </div>
            </li>
            <li class="card-item swiper-slide">
              <div class="category-logo-container">
                <a href="#">
                  <img class="category-logo" src="img/logo/gibson.png" alt="gibson-logo">
                </a>
              </div>
            </li>
            <li class="card-item swiper-slide">
              <div class="category-logo-container">
                <a href="#">
                  <img class="category-logo" src="img/logo/epiphone.png" alt="epiphone-logo">
                </a>
              </div>
            </li>
            <li class="card-item swiper-slide">
              <div class="category-logo-container">
                <a href="#">
                  <img class="category-logo" src="img/logo/Ibanez.png" alt="ibanze-logo">
                </a>
              </div>
            </li>
            <li class="card-item swiper-slide">
              <div class="category-logo-container">
                <a href="#">
                  <img class="category-logo" src="img/logo/martin-logo.png" alt="martin-logo">
                </a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </section>

    <!-- SECTION 4 -->
    <section id="section-four">
      <div class="container">
        <h1 class="h2 section-header">TOP SELLERS</h1>
        <!-- Slider Main Container & Also Card Main Container -->
        <div id="product-swiper" class="card-wrapper swiper">
          <!-- Additional Required Wrapper -->
          <ul class="item-list card-list swiper-wrapper">
            <li class="card-item swiper-slide">
              <div class="card white-bg">
                <img class="card-img-top" src="img/guitars/Acoustic Guitar/Classical Guitar/Brand/History/HISTORY_CLASSICAL_HEG-120 v2.png" alt="...">
                <div class="card-body">
                  <h5 class="card-title">History Classical Heg 120</h5>
                  <h6>₱999, 999</h6>
                  <p class="text-success item-status">In stock</p>
                  <div class="star-container">
                    <span class="star-icon fa fa-star fa-1x checked"></span>
                    <span class="star-icon fa fa-star fa-1x checked"></span>
                    <span class="star-icon fa fa-star fa-1x checked"></span>
                    <span class="star-icon fa fa-star fa-1x"></span>
                    <span class="star-icon fa fa-star fa-1x"></span>
                  </div>
                  <div class="d-flex justify-content-between">
                    <a href="#" class="btn brown-button">View Item <i class="fa fa-external-link"></i></a>
                    <div>
                      <a href="#" class="btn brown-button"><i class="fa fa-heart"></i></a>
                      <a href="#" class="btn brown-button"><i class="fa fa-cart-shopping"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li class="card-item swiper-slide">
              <div class="card white-bg">
                <img class="card-img-top" src="img/guitars/Acoustic Guitar/Classical Guitar/Brand/Manuel Rodriguez/MANUEL_RODRIGUEZ_NATURAL.png" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Manuel Rodriguez Natural</h5>
                  <h6>₱999, 999</h6>
                  <p class="text-success item-status">In stock</p>
                  <div class="star-container">
                    <span class="star-icon fa fa-star fa-1x checked"></span>
                    <span class="star-icon fa fa-star fa-1x checked"></span>
                    <span class="star-icon fa fa-star fa-1x checked"></span>
                    <span class="star-icon fa fa-star fa-1x"></span>
                    <span class="star-icon fa fa-star fa-1x"></span>
                  </div>
                  <div class="d-flex justify-content-between">
                    <a href="#" class="btn brown-button">View Item <i class="fa fa-external-link"></i></a>
                    <div>
                      <a href="#" class="btn brown-button"><i class="fa fa-heart"></i></a>
                      <a href="#" class="btn brown-button"><i class="fa fa-cart-shopping"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li class="card-item swiper-slide">
              <div class="card white-bg">
                <img class="card-img-top" src="img/guitars/Bass Guitar/Brand/Fender/FENDER_BASS_OLYMPIC_WHITE.png" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Fender Bass Olymnpic White</h5>
                  <h6>₱999, 999</h6>
                  <p class="text-success item-status">In stock</p>
                  <div class="star-container">
                    <span class="star-icon fa fa-star fa-1x checked"></span>
                    <span class="star-icon fa fa-star fa-1x checked"></span>
                    <span class="star-icon fa fa-star fa-1x checked"></span>
                    <span class="star-icon fa fa-star fa-1x"></span>
                    <span class="star-icon fa fa-star fa-1x"></span>
                  </div>
                  <div class="d-flex justify-content-between">
                    <a href="#" class="btn brown-button">View Item <i class="fa fa-external-link"></i></a>
                    <div>
                      <a href="#" class="btn brown-button"><i class="fa fa-heart"></i></a>
                      <a href="#" class="btn brown-button"><i class="fa fa-cart-shopping"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li class="card-item swiper-slide">
              <div class="card white-bg">
                <img class="card-img-top" src="img/guitars/Electric Guitar/Models/Les Paul/Epiphone/EPIPHONE_LES_PAUL_EBONY.png" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Epiphone Les Paul Ebony</h5>
                  <h6>₱999, 999</h6>
                  <p class="text-success item-status">In stock</p>
                  <div class="star-container">
                    <span class="star-icon fa fa-star fa-1x checked"></span>
                    <span class="star-icon fa fa-star fa-1x checked"></span>
                    <span class="star-icon fa fa-star fa-1x checked"></span>
                    <span class="star-icon fa fa-star fa-1x"></span>
                    <span class="star-icon fa fa-star fa-1x"></span>
                  </div>
                  <div class="d-flex justify-content-between">
                    <a href="#" class="btn brown-button">View Item <i class="fa fa-external-link"></i></a>
                    <div>
                      <a href="#" class="btn brown-button"><i class="fa fa-heart"></i></a>
                      <a href="#" class="btn brown-button"><i class="fa fa-cart-shopping"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li class="card-item swiper-slide">
              <div class="card white-bg">
                <img class="card-img-top" src="img/guitars/Electric Guitar/Models/Stratcoaster/Fender/FENDER_STRATOCASTER_HONEY_BURST.png" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Stratcoaster Honey Burst</h5>
                  <h6>₱999, 999</h6>
                  <p class="text-success item-status">In stock</p>
                  <div class="star-container">
                    <span class="star-icon fa fa-star fa-1x checked"></span>
                    <span class="star-icon fa fa-star fa-1x checked"></span>
                    <span class="star-icon fa fa-star fa-1x checked"></span>
                    <span class="star-icon fa fa-star fa-1x"></span>
                    <span class="star-icon fa fa-star fa-1x"></span>
                  </div>
                  <div class="d-flex justify-content-between">
                    <a href="#" class="btn brown-button">View Item <i class="fa fa-external-link"></i></a>
                    <div>
                      <a href="#" class="btn brown-button"><i class="fa fa-heart"></i></a>
                      <a href="#" class="btn brown-button"><i class="fa fa-cart-shopping"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <li class="card-item swiper-slide">
              <div class="card white-bg">
                <img class="card-img-top" src="img/guitars/Electric Guitar/Models/Telecaster/Squier/Avril Lavigne Telecaster.jpg" alt="">
                <div class="card-body">
                  <h5 class="card-title">Telecaster Avril Lavigne</h5>
                  <h6>₱999, 999</h6>
                  <p class="text-success item-status">In stock</p>
                  <div class="star-container">
                    <span class="star-icon fa fa-star fa-1x checked"></span>
                    <span class="star-icon fa fa-star fa-1x checked"></span>
                    <span class="star-icon fa fa-star fa-1x checked"></span>
                    <span class="star-icon fa fa-star fa-1x"></span>
                    <span class="star-icon fa fa-star fa-1x"></span>
                  </div>
                  <div class="d-flex justify-content-between">
                    <a href="#" class="btn brown-button">View Item <i class="fa fa-external-link"></i></a>
                    <div>
                      <a href="#" class="btn brown-button"><i class="fa fa-heart"></i></a>
                      <a href="#" class="btn brown-button"><i class="fa fa-cart-shopping"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </li>
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
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum, eius.</p>
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
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum, eius.</p>
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
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum, eius.</p>
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
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum, eius.</p>
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
              <a href="#" class="btn read-more">Read More </a>
              <a href="#" class="btn brown-button">Contact Us <i class="fa fa-external-link"></i></a>
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



  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <!-- Swiper -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="js/swiper.js"></script>
</body>

</html>