<!-- /*
* Template Name: Property
* Template Author: Untree.co
* Template URI: https://untree.co/
* License: https://creativecommons.org/licenses/by/3.0/
*/ -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="author" content="Untree.co" />
    <link rel="shortcut icon" href="E:\bootstrap html project\EstateAgency\Property\nngp.ico" />

    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap5" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap"
      rel="stylesheet"
    />

    <link rel="stylesheet" href="fonts/icomoon/style.css" />
    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css" />

    <link rel="stylesheet" href="css/tiny-slider.css" />
    <link rel="stylesheet" href="css/aos.css" />
    <link rel="stylesheet" href="css/style.css" />

    <title>
      Cari Property &mdash; NNGProperty
    </title>
  </head>
  <body>
    <div class="site-mobile-menu site-navbar-target">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close">
          <span class="icofont-close js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>

    <nav class="site-nav">
      <div class="container">
        <div class="menu-bg-wrap">
          <div class="site-navigation">
            <a href="index.php" class="logo m-0 float-start">Property</a>

            <ul
              class="js-clone-nav d-none d-lg-inline-block text-start site-menu float-end"
            >
              <li><a href="index.php">Home</a></li>
              <li class="has-children active">
                <a href="properties.php">Properties</a>
                <ul class="dropdown">
                  <li><a href="#">Beli Properti</a></li>
                      <li><a href="#">Sewa Properti</a></li>
                      <li><a href="#">Ajukan KPR Rumah</a></li>
            
                  </li>
                </ul>
              </li>
              <li><a href="services.php">Layanan Kami</a></li>
              <li><a href="about.php">Tentang Kami</a></li>
              <li><a href="contact.php">Hubungi Kami Sekarang</a></li>
            </ul>

            <a
              href="#"
              class="burger light me-auto float-end mt-1 site-menu-toggle js-menu-toggle d-inline-block d-lg-none"
              data-toggle="collapse"
              data-target="#main-navbar"
            >
              <span></span>
            </a>
          </div>
        </div>
      </div>
    </nav>

    <div
      class="hero page-inner overlay"
      style="background-image: url('images/hero_bg_1.jpg')"
    >
      <div class="container">
        <div class="row justify-content-center align-items-center">
          <div class="col-lg-9 text-center mt-5">
            <h1 class="heading" data-aos="fade-up">Properties</h1>

            <nav
              aria-label="breadcrumb"
              data-aos="fade-up"
              data-aos-delay="200"
            >
              <ol class="breadcrumb text-center justify-content-center">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li
                  class="breadcrumb-item active text-white-50"
                  aria-current="page"
                >
                  Properties
                </li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </div>

    <div class="section">
      <div class="container">
        <div class="row mb-5 align-items-center">
          <div class="col-lg-6 text-center mx-auto">
            <h2 class="font-weight-bold text-primary heading">
              Featured Properties
            </h2>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="property-slider-wrap">
              <div class="property-slider">
                <div class="property-item">
                  <a href="property-single.php" class="img">
                    <img src="images/img_1.jpg" alt="Image" class="img-fluid" />
                  </a>

                  <div class="property-content">
                    <div class="price mb-2"><span>Rp 2.850.000.000</span></div>
                    <div>
                      <span class="d-block mb-2 text-black-50"
                        >Jl. Kebon Jeruk Raya No. 15</span
                      >
                      <span class="city d-block mb-3">Jakarta Barat, DKI Jakarta</span>

                      <div class="specs d-flex mb-4">
                        <span class="d-block d-flex align-items-center me-3">
                          <span class="icon-bed me-2"></span>
                          <span class="caption">3 kamar</span>
                        </span>
                        <span class="d-block d-flex align-items-center">
                          <span class="icon-bath me-2"></span>
                          <span class="caption">2 kamar mandi</span>
                        </span>
                      </div>

                      <a
                        href="property-single.php"
                        class="btn btn-primary py-2 px-3"
                        >Lihat Detail</a
                      >
                    </div>
                  </div>
                </div>
                <!-- .item -->

                <div class="property-item">
                  <a href="property-single.php" class="img">
                    <img src="images/img_2.jpg" alt="Image" class="img-fluid" />
                  </a>

                  <div class="property-content">
                    <div class="price mb-2"><span>Rp 1.750.000.000</span></div>
                    <div>
                      <span class="d-block mb-2 text-black-50"
                        >Jl. Buah Batu No. 88</span
                      >
                      <span class="city d-block mb-3">Bandung, Jawa Barat</span>

                      <div class="specs d-flex mb-4">
                        <span class="d-block d-flex align-items-center me-3">
                          <span class="icon-bed me-2"></span>
                          <span class="caption">4 kamar</span>
                        </span>
                        <span class="d-block d-flex align-items-center">
                          <span class="icon-bath me-2"></span>
                          <span class="caption">3 kamar mandi</span>
                        </span>
                      </div>

                      <a
                        href="property-single.php"
                        class="btn btn-primary py-2 px-3"
                        >Lihat Detail</a
                      >
                    </div>
                  </div>
                </div>
                <!-- .item -->

                <div class="property-item">
                  <a href="property-single.php" class="img">
                    <img src="images/img_3.jpg" alt="Image" class="img-fluid" />
                  </a>

                  <div class="property-content">
                    <div class="price mb-2"><span>Rp 3.200.000.000</span></div>
                    <div>
                      <span class="d-block mb-2 text-black-50"
                        >Jl. Dharmahusada Indah Timur</span
                      >
                      <span class="city d-block mb-3">Surabaya, Jawa Timur</span>

                      <div class="specs d-flex mb-4">
                        <span class="d-block d-flex align-items-center me-3">
                          <span class="icon-bed me-2"></span>
                          <span class="caption">5 kamar</span>
                        </span>
                        <span class="d-block d-flex align-items-center">
                          <span class="icon-bath me-2"></span>
                          <span class="caption">4 kamar mandi</span>
                        </span>
                      </div>

                      <a
                        href="property-single.php"
                        class="btn btn-primary py-2 px-3"
                        >Lihat Detail</a
                      >
                    </div>
                  </div>
                </div>
                <!-- .item -->

                <div class="property-item">
                  <a href="property-single.php" class="img">
                    <img src="images/img_4.jpg" alt="Image" class="img-fluid" />
                  </a>

                  <div class="property-content">
                    <div class="price mb-2"><span>Rp 1.450.000.000</span></div>
                    <div>
                      <span class="d-block mb-2 text-black-50"
                        >Jl. Kaliurang KM 7.5</span
                      >
                      <span class="city d-block mb-3">Yogyakarta, DIY</span>

                      <div class="specs d-flex mb-4">
                        <span class="d-block d-flex align-items-center me-3">
                          <span class="icon-bed me-2"></span>
                          <span class="caption">3 kamar</span>
                        </span>
                        <span class="d-block d-flex align-items-center">
                          <span class="icon-bath me-2"></span>
                          <span class="caption">2 kamar mandi</span>
                        </span>
                      </div>

                      <a
                        href="property-single.php"
                        class="btn btn-primary py-2 px-3"
                        >Lihat Detail</a
                      >
                    </div>
                  </div>
                </div>
                <!-- .item -->

                <div class="property-item">
                  <a href="property-single.php" class="img">
                    <img src="images/img_5.jpg" alt="Image" class="img-fluid" />
                  </a>

                  <div class="property-content">
                    <div class="price mb-2"><span>Rp 2.100.000.000</span></div>
                    <div>
                      <span class="d-block mb-2 text-black-50"
                        >Jl. Imam Bonjol No. 25</span
                      >
                      <span class="city d-block mb-3">Denpasar, Bali</span>

                      <div class="specs d-flex mb-4">
                        <span class="d-block d-flex align-items-center me-3">
                          <span class="icon-bed me-2"></span>
                          <span class="caption">4 kamar</span>
                        </span>
                        <span class="d-block d-flex align-items-center">
                          <span class="icon-bath me-2"></span>
                          <span class="caption">3 kamar mandi</span>
                        </span>
                      </div>

                      <a
                        href="property-single.php"
                        class="btn btn-primary py-2 px-3"
                        >Lihat Detail</a
                      >
                    </div>
                  </div>
                </div>
                <!-- .item -->

                <div class="property-item">
                  <a href="property-single.php" class="img">
                    <img src="images/img_6.jpg" alt="Image" class="img-fluid" />
                  </a>

                  <div class="property-content">
                    <div class="price mb-2"><span>Rp 1.950.000.000</span></div>
                    <div>
                      <span class="d-block mb-2 text-black-50"
                        >Jl. Diponegoro No. 42</span
                      >
                      <span class="city d-block mb-3">Semarang, Jawa Tengah</span>

                      <div class="specs d-flex mb-4">
                        <span class="d-block d-flex align-items-center me-3">
                          <span class="icon-bed me-2"></span>
                          <span class="caption">4 kamar</span>
                        </span>
                        <span class="d-block d-flex align-items-center">
                          <span class="icon-bath me-2"></span>
                          <span class="caption">3 kamar mandi</span>
                        </span>
                      </div>

                      <a
                        href="property-single.php"
                        class="btn btn-primary py-2 px-3"
                        >Lihat Detail</a
                      >
                    </div>
                  </div>
                </div>
                <!-- .item -->

                <div class="property-item">
                  <a href="property-single.php" class="img">
                    <img src="images/img_7.jpg" alt="Image" class="img-fluid" />
                  </a>

                  <div class="property-content">
                    <div class="price mb-2"><span>Rp 2.650.000.000</span></div>
                    <div>
                      <span class="d-block mb-2 text-black-50"
                        >Jl. Ahmad Yani No. 75</span
                      >
                      <span class="city d-block mb-3">Makassar, Sulawesi Selatan</span>

                      <div class="specs d-flex mb-4">
                        <span class="d-block d-flex align-items-center me-3">
                          <span class="icon-bed me-2"></span>
                          <span class="caption">5 kamar</span>
                        </span>
                        <span class="d-block d-flex align-items-center">
                          <span class="icon-bath me-2"></span>
                          <span class="caption">4 kamar mandi</span>
                        </span>
                      </div>

                      <a
                        href="property-single.php"
                        class="btn btn-primary py-2 px-3"
                        >Lihat Detail</a
                      >
                    </div>
                  </div>
                </div>
                <!-- .item -->

                <div class="property-item">
                  <a href="property-single.php" class="img">
                    <img src="images/img_8.jpg" alt="Image" class="img-fluid" />
                  </a>

                  <div class="property-content">
                    <div class="price mb-2"><span>Rp 1.800.000.000</span></div>
                    <div>
                      <span class="d-block mb-2 text-black-50"
                        >Jl. Sudirman No. 88</span
                      >
                      <span class="city d-block mb-3">Medan, Sumatera Utara</span>

                      <div class="specs d-flex mb-4">
                        <span class="d-block d-flex align-items-center me-3">
                          <span class="icon-bed me-2"></span>
                          <span class="caption">3 kamar</span>
                        </span>
                        <span class="d-block d-flex align-items-center">
                          <span class="icon-bath me-2"></span>
                          <span class="caption">2 kamar mandi</span>
                        </span>
                      </div>

                      <a
                        href="property-single.php"
                        class="btn btn-primary py-2 px-3"
                        >Lihat Detail</a
                      >
                    </div>
                  </div>
                </div>
                <!-- .item -->

                <div class="property-item">
                  <a href="property-single.php" class="img">
                    <img src="images/img_1.jpg" alt="Image" class="img-fluid" />
                  </a>

                  <div class="property-content">
                    <div class="price mb-2"><span>Rp 2.300.000.000</span></div>
                    <div>
                      <span class="d-block mb-2 text-black-50"
                        >Jl. Gajah Mada No. 125</span
                      >
                      <span class="city d-block mb-3">Palembang, Sumatera Selatan</span>

                      <div class="specs d-flex mb-4">
                        <span class="d-block d-flex align-items-center me-3">
                          <span class="icon-bed me-2"></span>
                          <span class="caption">4 kamar</span>
                        </span>
                        <span class="d-block d-flex align-items-center">
                          <span class="icon-bath me-2"></span>
                          <span class="caption">3 kamar mandi</span>
                        </span>
                      </div>

                      <a
                        href="property-single.php"
                        class="btn btn-primary py-2 px-3"
                        >Lihat Detail</a
                      >
                    </div>
                  </div>
                </div>
                <!-- .item -->
              </div>

              <div
                id="property-nav"
                class="controls"
                tabindex="0"
                aria-label="Carousel Navigation"
              >
                <span
                  class="prev"
                  data-controls="prev"
                  aria-controls="property"
                  tabindex="-1"
                  >Prev</span
                >
                <span
                  class="next"
                  data-controls="next"
                  aria-controls="property"
                  tabindex="-1"
                  >Next</span
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="section section-properties">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
            <div class="property-item mb-30">
              <a href="property-single.php" class="img">
                <img src="images/img_1.jpg" alt="Image" class="img-fluid" />
              </a>

              <div class="property-content">
                <div class="price mb-2"><span>Rp 1.650.000.000</span></div>
                <div>
                  <span class="d-block mb-2 text-black-50"
                    >Perumahan Bumi Serpong Damai</span
                  >
                  <span class="city d-block mb-3">Tangerang Selatan, Banten</span>

                  <div class="specs d-flex mb-4">
                    <span class="d-block d-flex align-items-center me-3">
                      <span class="icon-bed me-2"></span>
                      <span class="caption">3 kamar</span>
                    </span>
                    <span class="d-block d-flex align-items-center">
                      <span class="icon-bath me-2"></span>
                      <span class="caption">2 kamar mandi</span>
                    </span>
                  </div>

                  <a
                    href="property-single.php"
                    class="btn btn-primary py-2 px-3"
                    >Lihat Detail</a
                  >
                </div>
              </div>
            </div>
            <!-- .item -->
          </div>
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
            <div class="property-item mb-30">
              <a href="property-single.php" class="img">
                <img src="images/img_2.jpg" alt="Image" class="img-fluid" />
              </a>

              <div class="property-content">
                <div class="price mb-2"><span>Rp 2.850.000.000</span></div>
                <div>
                  <span class="d-block mb-2 text-black-50"
                    >Komplek Pondok Indah Residence</span
                  >
                  <span class="city d-block mb-3">Jakarta Selatan, DKI Jakarta</span>

                  <div class="specs d-flex mb-4">
                    <span class="d-block d-flex align-items-center me-3">
                      <span class="icon-bed me-2"></span>
                      <span class="caption">4 kamar</span>
                    </span>
                    <span class="d-block d-flex align-items-center">
                      <span class="icon-bath me-2"></span>
                      <span class="caption">3 kamar mandi</span>
                    </span>
                  </div>

                  <a
                    href="property-single.php"
                    class="btn btn-primary py-2 px-3"
                    >Lihat Detail</a
                  >
                </div>
              </div>
            </div>
            <!-- .item -->
          </div>
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
            <div class="property-item mb-30">
              <a href="property-single.php" class="img">
                <img src="images/img_3.jpg" alt="Image" class="img-fluid" />
              </a>

              <div class="property-content">
                <div class="price mb-2"><span>Rp 1.350.000.000</span></div>
                <div>
                  <span class="d-block mb-2 text-black-50"
                    >Villa Puncak Resort</span
                  >
                  <span class="city d-block mb-3">Bogor, Jawa Barat</span>

                  <div class="specs d-flex mb-4">
                    <span class="d-block d-flex align-items-center me-3">
                      <span class="icon-bed me-2"></span>
                      <span class="caption">5 kamar</span>
                    </span>
                    <span class="d-block d-flex align-items-center">
                      <span class="icon-bath me-2"></span>
                      <span class="caption">4 kamar mandi</span>
                    </span>
                  </div>

                  <a
                    href="property-single.php"
                    class="btn btn-primary py-2 px-3"
                    >Lihat Detail</a
                  >
                </div>
              </div>
            </div>
            <!-- .item -->
          </div>

          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
            <div class="property-item mb-30">
              <a href="property-single.php" class="img">
                <img src="images/img_4.jpg" alt="Image" class="img-fluid" />
              </a>

              <div class="property-content">
                <div class="price mb-2"><span>Rp 2.200.000.000</span></div>
                <div>
                  <span class="d-block mb-2 text-black-50"
                    >Graha Family Residence</span
                  >
                  <span class="city d-block mb-3">Surabaya, Jawa Timur</span>

                  <div class="specs d-flex mb-4">
                    <span class="d-block d-flex align-items-center me-3">
                      <span class="icon-bed me-2"></span>
                      <span class="caption">4 kamar</span>
                    </span>
                    <span class="d-block d-flex align-items-center">
                      <span class="icon-bath me-2"></span>
                      <span class="caption">3 kamar mandi</span>
                    </span>
                  </div>

                  <a
                    href="property-single.php"
                    class="btn btn-primary py-2 px-3"
                    >Lihat Detail</a
                  >
                </div>
              </div>
            </div>
            <!-- .item -->
          </div>
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
            <div class="property-item mb-30">
              <a href="property-single.php" class="img">
                <img src="images/img_5.jpg" alt="Image" class="img-fluid" />
              </a>

              <div class="property-content">
                <div class="price mb-2"><span>Rp 3.500.000.000</span></div>
                <div>
                  <span class="d-block mb-2 text-black-50"
                    >Sanur Beach Villa</span
                  >
                  <span class="city d-block mb-3">Denpasar, Bali</span>

                  <div class="specs d-flex mb-4">
                    <span class="d-block d-flex align-items-center me-3">
                      <span class="icon-bed me-2"></span>
                      <span class="caption">6 kamar</span>
                    </span>
                    <span class="d-block d-flex align-items-center">
                      <span class="icon-bath me-2"></span>
                      <span class="caption">5 kamar mandi</span>
                    </span>
                  </div>

                  <a
                    href="property-single.php"
                    class="btn btn-primary py-2 px-3"
                    >Lihat Detail</a
                  >
                </div>
              </div>
            </div>
            <!-- .item -->
          </div>
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
            <div class="property-item mb-30">
              <a href="property-single.php" class="img">
                <img src="images/img_6.jpg" alt="Image" class="img-fluid" />
              </a>

              <div class="property-content">
                <div class="price mb-2"><span>Rp 1.750.000.000</span></div>
                <div>
                  <span class="d-block mb-2 text-black-50"
                    >Taman Ciputat Indah</span
                  >
                  <span class="city d-block mb-3">Tangerang Selatan, Banten</span>

                  <div class="specs d-flex mb-4">
                    <span class="d-block d-flex align-items-center me-3">
                      <span class="icon-bed me-2"></span>
                      <span class="caption">3 kamar</span>
                    </span>
                    <span class="d-block d-flex align-items-center">
                      <span class="icon-bath me-2"></span>
                      <span class="caption">2 kamar mandi</span>
                    </span>
                  </div>

                  <a
                    href="property-single.php"
                    class="btn btn-primary py-2 px-3"
                    >Lihat Detail</a
                  >
                </div>
              </div>
            </div>
            <!-- .item -->
          </div>

          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
            <div class="property-item mb-30">
              <a href="property-single.php" class="img">
                <img src="images/img_7.jpg" alt="Image" class="img-fluid" />
              </a>

              <div class="property-content">
                <div class="price mb-2"><span>Rp 2.950.000.000</span></div>
                <div>
                  <span class="d-block mb-2 text-black-50"
                    >Pantai Indah Kapuk</span
                  >
                  <span class="city d-block mb-3">Jakarta Utara, DKI Jakarta</span>

                  <div class="specs d-flex mb-4">
                    <span class="d-block d-flex align-items-center me-3">
                      <span class="icon-bed me-2"></span>
                      <span class="caption">5 kamar</span>
                    </span>
                    <span class="d-block d-flex align-items-center">
                      <span class="icon-bath me-2"></span>
                      <span class="caption">4 kamar mandi</span>
                    </span>
                  </div>

                  <a
                    href="property-single.php"
                    class="btn btn-primary py-2 px-3"
                    >Lihat Detail</a
                  >
                </div>
              </div>
            </div>
            <!-- .item -->
          </div>
          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
            <div class="property-item mb-30">
              <a href="property-single.php" class="img">
                <img src="images/img_8.jpg" alt="Image" class="img-fluid" />
              </a><div class="property-content">
               <div class="price mb-2"><span>Rp 1.900.000.000</span></div>
               <div>
                 <span class="d-block mb-2 text-black-50"
                   >Komplek Permata Hijau</span
                 >
                 <span class="city d-block mb-3">Jakarta Selatan, DKI Jakarta</span>

                 <div class="specs d-flex mb-4">
                   <span class="d-block d-flex align-items-center me-3">
                     <span class="icon-bed me-2"></span>
                     <span class="caption">4 kamar</span>
                   </span>
                   <span class="d-block d-flex align-items-center">
                     <span class="icon-bath me-2"></span>
                     <span class="caption">3 kamar mandi</span>
                   </span>
                 </div>

                 
                   <a
                    href="property-single.php"
                    class="btn btn-primary py-2 px-3"
                    >Lihat Detail</a>
               </div>
             </div>
           </div>
           <!-- .item -->
         </div>
         <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
           <div class="property-item mb-30">
             <a href="property-single.php" class="img">
               <img src="images/img_1.jpg" alt="Image" class="img-fluid" />
             </a>

             <div class="property-content">
               <div class="price mb-2"><span>Rp 1.450.000.000</span></div>
               <div>
                 <span class="d-block mb-2 text-black-50"
                   >Cibubur Country Estate</span
                 >
                 <span class="city d-block mb-3">Depok, Jawa Barat</span>

                 <div class="specs d-flex mb-4">
                   <span class="d-block d-flex align-items-center me-3">
                     <span class="icon-bed me-2"></span>
                     <span class="caption">3 kamar</span>
                   </span>
                   <span class="d-block d-flex align-items-center">
                     <span class="icon-bath me-2"></span>
                     <span class="caption">2 kamar mandi</span>
                   </span>
                 </div>

                 
                   <a
                    href="property-single.php"
                    class="btn btn-primary py-2 px-3"
                    >Lihat Detail</a>
               </div>
             </div>
           </div>
           <!-- .item -->
         </div>
       </div>
     </div>
   </div>

   <div class="site-footer">
     <div class="container">
       <div class="row">
         <div class="col-lg-4">
           <div class="widget">
             <h3>Kontak Kami</h3>
             <address>Jl. Sudirman No. 123, Jakarta Pusat 10110</address>
             <ul class="list-unstyled links">
               <li><a href="tel://11234567890">+62 21 1234 5678</a></li>
               <li><a href="tel://11234567890">+62 811 2345 6789</a></li>
               <li>
                 <a href="mailto:info@nngproperty.com">info@nngproperty.com</a>
               </li>
             </ul>
           </div>














           <!-- /.widget -->
         </div>












         
         <!-- /.col-lg-4 -->
         <div class="col-lg-4">
           <div class="widget">
             <h3>Sumber</h3>
             <ul class="list-unstyled float-start links">
               <li><a href="#">Tentang Kami</a></li>
               <li><a href="#">Layanan Kami</a></li>
               <li><a href="#">Visi dan Misi</a></li>
               <li><a href="#">Tim Kami</a></li>
             </ul>
             <ul class="list-unstyled float-start links">
               <li><a href="#">Privasi</a></li>
               <li><a href="#">Hubungi Kami</a></li>
               <li><a href="#">Karir</a></li>
             </ul>
           </div>
           <!-- /.widget -->
         </div>
         <!-- /.col-lg-4 -->
         <div class="col-lg-4">
           <div class="widget">
             <h3>Link</h3>
             <ul class="list-unstyled links">
               <li><a href="#">Properties Terbaru</a></li>
               <li><a href="#">Properties Terlaris</a></li>
               <li><a href="#">Investasi Properti</a></li>
               <li><a href="#">Tips Membeli Rumah</a></li>
               <li><a href="#">Kredit Pemilikan Rumah</a></li>
             </ul>

             <ul class="list-unstyled social">
               <li>
                 <a href="#"><span class="icon-instagram"></span></a>
               </li>
               <li>
                 <a href="#"><span class="icon-twitter"></span></a>
               </li>
               <li>
                 <a href="#"><span class="icon-facebook"></span></a>
               </li>
               <li>
                 <a href="#"><span class="icon-linkedin"></span></a>
               </li>
               <li>
                 <a href="#"><span class="icon-pinterest"></span></a>
               </li>
               <li>
                 <a href="#"><span class="icon-dribbble"></span></a>
               </li>
             </ul>
           </div>
           <!-- /.widget -->
         </div>
         <!-- /.col-lg-4 -->
       </div>
       <!-- /.row -->

       <div class="row mt-5">
         <div class="col-12 text-center">
           <p>
             Copyright &copy;
             <script>
               document.write(new Date().getFullYear());
             </script>
             . All Rights Reserved. &mdash; Designed with love by
             <a href="https://untree.co">Untree.co</a>
             <!-- License information: https://untree.co/license/ -->
           </p>
         </div>
       </div>
     </div>
     <!-- /.container -->
   </div>
   <!-- /.site-footer -->

   <!-- Preloader -->
   <div id="overlayer"></div>
   <div class="loader">
     <div class="spinner-border" role="status">
       <span class="visually-hidden">Loading...</span>
     </div>
   </div>

   <script src="js/bootstrap.bundle.min.js"></script>
   <script src="js/tiny-slider.js"></script>
   <script src="js/aos.js"></script>
   <script src="js/navbar.js"></script>
   <script src="js/counter.js"></script>
   <script src="js/custom.js"></script>
 </body>
</html>