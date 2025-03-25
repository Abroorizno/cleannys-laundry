<?php
session_start();
session_regenerate_id();
include '../db/koneksi.php';

if (!isset($_SESSION["email"])) {
    header("Location: ../session/login.php");
    exit();
}
?>

<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Cleanny's Laundry</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../assets/js/config.js"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <?php include_once '../inc/sidebar.php'; ?>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav
                    class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <?php include_once '../inc/navbar.php'; ?>
                </nav>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <section class="section">
                        <?php
                        if (isset($_GET['page'])) {
                            if (file_exists('../content/' . $_GET['page'] . ".php")) {
                                include_once '../content/' . $_GET['page'] . ".php";
                            }
                        } else {
                            include '../content/home.php'; // default page
                        }
                        ?>
                        <!-- / Content -->
                    </section>
                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <?php include_once '../inc/footer.php'; ?>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="../assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <script src="../assets/js/jquery-3.7.1.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script> -->

    <script>
        $('#id_service').change(function() {
            let id_service = $(this).val();
            $.ajax({
                url: "get-service.php?id_service=" + id_service,
                method: "get",
                dataType: "JSON",
                success: function(res) {
                    console.log(res);
                    $('#service_price').val(res.data.price)
                }
            });
        }); // end change

        $('.add-row').click(function() {
            let countDisplay = document.getElementById('countDisplay');
            let currentCount = parseInt(countDisplay.value) || 0;
            currentCount++;
            countDisplay.value = currentCount;

            let service_name = $('#id_service').find("option:selected").text();
            let service_price = $('#service_price').val();

            let newRow = "";
            newRow += `<tr>`;
            newRow += `<td> ${currentCount} </td>`;
            newRow += `<td> ${service_name} <input class="form-control" name="serviceName[]" type="hidden" value="${service_name}"></td>`;
            newRow += `<td> ${service_price.toLocaleString()} <input class="form-control" name="total[]" type="hidden" value="${service_price.toLocaleString()}"></input></td>`;
            newRow += `<td><input class="form-control" name="qty[]" type="number"></input></td>`;
            newRow += `<td><input class="form-control" name="notes[]" type="text"></input></td>`;
            newRow += `<td><button class="btn btn-light btn-sm remove">REMOVE</button></td>`;
            newRow += `</tr>`;

            $('.table-order tbody').append(newRow);

            $('.remove').click(function(event) {
                event.preventDefault();
                $(this).closest('tr').remove(); // remove the row
            });
        });
    </script>

    <script>
        // Fungsi untuk mendapatkan tanggal hari ini dalam format YYYY-MM-DD
        function formatDate(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2)
                month = '0' + month;
            if (day.length < 2)
                day = '0' + day;

            return [year, month, day].join('-');
        }

        // Mengatur nilai input tanggal dengan tanggal hari ini
        document.getElementById('tgl_order').value = formatDate(new Date());
    </script>

    <script>
        $('#amount').on('input', function() {
            let total = parseFloat($('#total_transaksi').val()) || 0;
            let amount = parseFloat($(this).val()) || 0;
            let change = amount - total;
            $('#change').val(change);
        });
    </script>
</body>

</html>