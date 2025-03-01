<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Basic Page Needs
================================================== -->
    <meta charset="utf-8">
    <title>Constra - Construction Html5 Template</title>

    <!-- Mobile Specific Metas
================================================== -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Construction Html5 Template">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">

    <!-- Favicon
================================================== -->
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/favicon.png') ?>">

    <!-- CSS
================================================== -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/bootstrap/bootstrap.min.css') ?>">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="<? base_url('assets/vendor/flatpickr/dist/flatpickr.min.css') ?>">

    <link rel="stylesheet" href="<?= base_url('assets/plugins/fontawesome/css/all.min.css') ?>">
    <!-- Animation -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/animate-css/animate.css') ?>">
    <!-- slick Carousel -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/slick/slick.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/plugins/slick/slick-theme.css') ?>">
    <!-- Colorbox -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/colorbox/colorbox.css') ?>">
    <!-- Template styles-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <?= $this->renderSection('head') ?>

</head>

<body>
    <?= $this->include('layouts/header') ?>

    <div class="body-inner">

        <!--/ Topbar end -->
        <!-- Header start -->

        <!--/ Header end -->
        <div class="banner-carousel banner-carousel-1 mb-0">
            <div class="banner-carousel-item" style="background-image:url(<?= base_url('assets/images/slider-main/bg1.jpg') ?>">
                <div class="slider-content">
                    <div class="container " style="margin-top: 15rem;">
                        <div class="facts-wrapper">
                            <div class="row">
                                <div class="col-md-3 col-sm-6 ts-facts">
                                    <a href="/documents/index">
                                        <div class="ts-facts-img d-flex justify-content-center">
                                            <img loading="lazy" src="<?= base_url('assets/images/icon-image/fact1.png') ?>" alt="facts-img">
                                        </div>
                                        <div class="ts-facts-content">
                                            <h2 class="ts-facts-num"><span class="counterUp">TASK 1</span></h2>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-md-3 col-sm-6 ts-facts mt-5 mt-sm-0">
                                    <a href="/excel">
                                        <div class="ts-facts-img d-flex justify-content-center">
                                            <img loading="lazy" src="<?= base_url('assets/images/icon-image/fact2.png') ?>" alt="facts-img">
                                        </div>
                                        <div class="ts-facts-content">
                                            <h2 class="ts-facts-num"><span class="counterUp">TASK 2</span></h2>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-md-3 col-sm-6 ts-facts mt-5 mt-md-0">
                                    <a href="/dashboard">
                                        <div class="ts-facts-img d-flex justify-content-center">
                                            <img loading="lazy" src="<?= base_url('assets/images/icon-image/fact3.png') ?>" alt="facts-img">
                                        </div>
                                        <div class="ts-facts-content">
                                            <h2 class="ts-facts-num"><span class="counterUp">TASK 3</span></h2>
                                        </div>
                                    </a>
                                </div><!-- Col end -->

                                <div class="col-md-3 col-sm-6 ts-facts mt-5 mt-md-0">
                                    <a href="/revenue">
                                        <div class="ts-facts-img d-flex justify-content-center">
                                            <img loading="lazy" src="<?= base_url('assets/images/icon-image/fact4.png') ?>" alt="facts-img">
                                        </div>
                                        <div class="ts-facts-content">
                                            <h2 class="ts-facts-num"><span class="counterUp">TASK 4</span></h2>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-md-3 col-sm-6 ts-facts mt-5 mt-md-0">
                                    <a href="/account">
                                        <div class="ts-facts-img d-flex justify-content-center">
                                            <img loading="lazy" src="<?= base_url('assets/images/icon-image/fact2.png') ?>" alt="facts-img">
                                        </div>
                                        <div class="ts-facts-content">
                                            <h2 class="ts-facts-num"><span class="counterUp">TASK 6</span></h2>
                                        </div>
                                    </a>
                                </div>
                                <!-- Col end -->

                            </div> <!-- Facts end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>





        <?= $this->include('layouts/footer') ?>

        <!--/ News end -->

        <!-- Javascript Files
  ================================================== -->

        <!-- initialize jQuery Library -->
        <script src="<?= base_url('assets/plugins/jQuery/jquery.min.js') ?>"></script>
        <!-- Bootstrap jQuery -->
        <script src="<?= base_url('assets/plugins/bootstrap/bootstrap.min.js') ?>" defer></script>
        <!-- Slick Carousel -->
        <script src="<?= base_url('assets/plugins/slick/slick.min.js') ?>"></script>
        <script src="<?= base_url('assets/plugins/slick/slick-animation.min.js') ?>"></script>
        <!-- Color box -->
        <script src="<?= base_url('assets/plugins/colorbox/jquery.colorbox.js') ?>"></script>
        <!-- shuffle -->
        <script src="<?= base_url('assets/plugins/shuffle/shuffle.min.js') ?>" defer></script>

        <script src="<?= base_url('assets/vendor/flatpickr/dist/flatpickr.min.js') ?>"></script>
        <script src="<?= base_url('assets/js/plugins/flatpickr.js') ?>" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcABaamniA6OL5YvYSpB3pFMNrXwXnLwU" defer></script>
        <!-- Google Map API Key-->
        <script src="<?= base_url('assets/plugins/google-map/map.js') ?>" defer></script>

        <!-- Template custom -->
        <script src="<?= base_url('assets/js/script.js') ?>"></script>
        <!-- Google Map Plugin-->
        <?= $this->renderSection('scripts') ?>

    </div><!-- Body inner end -->
</body>

</html>