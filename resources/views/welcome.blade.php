<!DOCTYPE html>
<html dir="ltr" lang="en-US">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="SemiColonWeb" />

    <!-- Stylesheets
	============================================= -->
    <link
      href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700|Poppins:300,400,500,600,700|PT+Serif:400,400i&display=swap"
      rel="stylesheet"
      type="text/css"
    />
    <link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="style.css" type="text/css" />
    <link rel="stylesheet" href="css/swiper.css" type="text/css" />
    <link rel="stylesheet" href="css/dark.css" type="text/css" />
    <link rel="stylesheet" href="css/font-icons.css" type="text/css" />
    <link rel="stylesheet" href="css/animate.css" type="text/css" />
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css" />

    <link rel="stylesheet" href="css/custom.css" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Document Title
	============================================= -->
    <title>AIM Aeriel</title>
  </head>

  <body class="stretched">
    <!-- Document Wrapper
	============================================= -->
    <div id="wrapper" class="clearfix">
      <!-- Header
		============================================= -->
        <header
        id="header"
        class="full-header transparent-header"
        data-sticky-class="not-dark"
    >
        <div id="header-wrap">
            <div class="container">
                <div class="header-row">
                    <!-- Logo
                ============================================= -->
                    <div id="logo">
                        <a
                            href="/"
                            >Home</a> <!-- standard logo -->
                        {{-- <a
                            href="index"
                            class="retina-logo"
                            data-dark-logo="images/logo-dark@2x.png"
                            ><img
                                src="images/logo@2x.png"
                                alt="Canvas Logo"
                        /></a> <!-- mobile logo -->
                        <a
                            href="/"
                            class="standard-logo"
                            data-dark-logo="images/demo.png"
                            ><img
                                src="images/demo.png"
                                alt="Canvas Logo"
                        /></a> <!-- standard logo -->--}}
                    </div>
                    <!-- #logo end -->
                <div class="header-misc">
                    <!-- Header Search Begin
                ============================================= -->
                    <div id="top-search" class="header-misc-icon">
                        <a href="#" id="top-search-trigger"
                            ><i class="icon-line-search"></i
                            ><i class="icon-line-cross"></i
                        ></a>
                    </div>
                </div>
                <!-- Primary Navigation
                    ============================================= -->
                    <nav class="primary-menu">
                        <ul class="menu-container">
                          <li class="menu-item">
                            {{-- <a class="menu-link" href={{route('drones.index')}} style="padding-top: 39px; padding-bottom: 39px;"><div>Drones</div></a> --}}
                            @if (Auth::user())
                              <li class="menu-item">
                                  <a href="dashboard" class="menu link button button-circle button-green">Dashboard</a>
                                  {{-- <li class="menu-item">
                                      <a href="logout" class="menu link button button-circle button-black">Logout</a>     --}}
                            @else
                            <li class="menu-item">
                                <a href="login" class="menu link button button-circle button-blue">Login</a>
                            <li class="menu-item">
                                <div>or</div>
                            <li class="menu-item">
                                <a href="register" class="menu link button button-circle button-green">Register</a>

                          @endif
                        </ul>
                    </nav>

                <form
                class="top-search-form"
                action="search.html"
                method="get"
                >
                <input
                    type="text"
                    name="q"
                    class="form-control"
                    value=""
                    placeholder="Type &amp; Hit Enter.."
                    autocomplete="on"
                />
                </form>
                </div>
            </div>
        </div>
    </header>
      <!-- #header end -->

      <section
        id="slider"
        class="slider-element slider-parallax swiper_wrapper min-vh-60 min-vh-md-100 include-header"
      >
        <div class="slider-inner">
          <div class="swiper-container swiper-parent">
            <div class="swiper-wrapper">
              <div class="swiper-slide dark">
                <div class="container">
                  <div class="slider-caption slider-caption-center">
                    <h2 data-animate="fadeInUp">LUIS</h2>
                    <p
                      class="d-none d-sm-block"
                      data-animate="fadeInUp"
                      data-delay="200"
                    >
                    Layered User Identification Systems for sensitive data management across any industry, agency and business.
                    </p>
                  </div>
                </div>
                <div
                  class="swiper-slide-bg"
                  style="background-image: url('images/slider/swiper/1.jpg')"
                ></div>
              </div>
              <div class="swiper-slide dark">
                <div class="container">
                  <div class="slider-caption slider-caption-center">
                    <h2 data-animate="fadeInUp">Curated automation solutions</h2>
                    <p
                      class="d-none d-sm-block"
                      data-animate="fadeInUp"
                      data-delay="200"
                    >
                      Specialised hardware and software solutions for multiple industries.
                    </p>
                  </div>
                </div>
                <div class="video-wrap">
                  <video
                    id="slide-video"
                    poster="images/videos/explore-poster.jpg"
                    preload="auto"
                    loop
                    autoplay
                    muted
                  >
                    <source
                      src="images/videos/explore.webm"
                      type="video/webm"
                    />
                    <source src="images/videos/explore.mp4" type="video/mp4" />
                  </video>
                  <div
                    class="video-overlay"
                    style="background-color: rgba(0, 0, 0, 0.55)"
                  ></div>
                </div>
              </div>
              {{-- <div class="swiper-slide">
                <div class="container">
                  <div class="slider-caption">
                    <h2 data-animate="fadeInUp">Lorem ipsum dolor sit amet</h2>
                    <p
                      class="d-none d-sm-block"
                      data-animate="fadeInUp"
                      data-delay="200"
                    >
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed blandit felis non tellus aliquam scelerisque. Phasellus vitae nisl elit. Mauris iaculis.
                    </p>
                  </div>
                </div>
                <div
                  class="swiper-slide-bg"
                  style="
                    background-image: url('images/slider/swiper/3.jpg');
                    background-position: center top;
                  "
                ></div>
              </div> --}}
            </div>
            <div class="slider-arrow-left"><i class="icon-angle-left"></i></div>
            <div class="slider-arrow-right">
              <i class="icon-angle-right"></i>
            </div>
          </div>

          <a
            href="#"
            data-scrollto="#content"
            data-offset="100"
            class="one-page-arrow dark"
            ><i class="icon-angle-down infinite animated fadeInDown"></i
          ></a>
        </div>
      </section>

      <!-- Content
		============================================= -->
      <section id="content">
        <div class="content-wrap">
          <div class="container">
            <div class="row align-items-center">
              <div class="col-lg-5">
                <div class="heading-block">
                  <h1>Powered by Aim Aerial Technologies.</h1>
                </div>
                <p class="lead">
                Born in 2021, AAT’s mission is to secure our homes and data from today without compromise and expand the use off automation, robotics and IoT platforms.
                </p>
              </div>

              <div class="col-lg-7 align-self-end">
                <div class="position-relative overflow-hidden">
                  <img
                    src="images/drone-image.jpg"
                    data-animate="fadeInUp"
                    data-delay="100"
                    alt="Chrome"
                  />
                </div>
              </div>
            </div>
          </div>

          <div class="section my-0">
            <div class="container">
              <div class="row mt-4 col-mb-50">
                <div class="col-lg-4">
                  <i
                    class="i-plain color i-large icon-line2-screen-desktop inline-block"
                    style="margin-bottom: 15px"
                  ></i>
                  <div
                    class="heading-block border-bottom-0"
                    style="margin-bottom: 15px"
                  >
                    {{-- <span class="before-heading">Lorem ipsum dolor sit amet.</span> --}}
                    <h4>Securely Manage Your Future</h4>
                  </div>
                  <p>With LUIS we target to give the world the capability to securely manage their data and IoT platforms, which truly is our intimate space in todays world.
                  </p>
                </div>

                <div class="col-lg-4">
                  <i
                    class="i-plain color i-large icon-line2-energy inline-block"
                    style="margin-bottom: 15px"
                  ></i>
                  <div
                    class="heading-block border-bottom-0"
                    style="margin-bottom: 15px"
                  >
                    {{-- <span class="before-heading"
                      >Lorem ipsum dolor sit amet.</span
                    > --}}
                    <h4>Automated Robotic and Drone Solutions</h4>
                  </div>
                  <p>
                    We’re pushing Industries into automation to push the world towards, efficiency, sustainability and sustainability across platforms and industries.
                  </p>
                </div>

                <div class="col-lg-4">
                  <i
                    class="i-plain color i-large icon-line2-equalizer inline-block"
                    style="margin-bottom: 15px"
                  ></i>
                  <div
                    class="heading-block border-bottom-0"
                    style="margin-bottom: 15px"
                  >
                    {{-- <span class="before-heading"
                      >Lorem ipsum dolor sit amet.</span
                    > --}}
                    <h4>Transparency is Key</h4>
                  </div>
                  <p>
                    Our data management solutions are authenticated on blockchain (T3) to ensure transparency across Users & Clients.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- #content end -->
    </div>
    <!-- #wrapper end -->

    <!-- Go To Top
	============================================= -->
    <div id="gotoTop" class="icon-angle-up"></div>

    <!-- JavaScripts
	============================================= -->
    <script src="js/jquery.js"></script>
    <script src="js/plugins.min.js"></script>

    <!-- Footer Scripts
	============================================= -->
    <script src="js/functions.js"></script>
  </body>
</html>
