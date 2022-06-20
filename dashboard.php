<?php

require_once "core/init.php";

if (!$user->is_loggedIn()) {
    Session::flash('index', 'Anda harus login untuk mengakses halaman ini');
    Redirect::to('index');
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Virtual Power Plant</title>

    <link rel="stylesheet" href="assets/css/bootstrap.css">

    <link rel="stylesheet" href="assets/vendors/chartjs/Chart.min.css">

    <link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon">
</head>

<body>
    <div id="app">

        <!-- Sidebar -->
        <?php include 'templates/sidebar.php' ?>

        <div id="main">

            <!-- Header -->
            <?php include 'templates/header.php' ?>

            <div class="main-content container-fluid">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>Dashboard</h3>
                            <p class="text-subtitle text-muted">Statistik</p>
                        </div>
                        <!-- <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class='breadcrumb-header'>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                                </ol>
                            </nav>
                        </div> -->
                    </div>
                    <section class="section">
                        <div class="row mb-2">
                            <div class="col-12 col-md-4">
                                <div class="card card-statistic">
                                    <div class="card-body p-0">
                                        <div class="d-flex flex-column">
                                            <div class='px-3 py-3 d-flex justify-content-between'>
                                                <h5 class='card-title'>Daya Baterai</h5>
                                            </div>
                                            <div class="chart-wrapper">
                                                <div class="card-right d-flex align-items-center">
                                                    <p style="margin-left: 150px;padding-top: 5px; font-weight: bold;">50%</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="card card-statistic">
                                    <div class="card-body p-0">
                                        <div class="d-flex flex-column">
                                            <div class='px-3 py-3 d-flex justify-content-between'>
                                                <h5 class='card-title'>Solar Panel (W)</h5>
                                            </div>
                                            <div class="chart-wrapper">
                                                <canvas id="canvas1" style="height:100px !important"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="card card-statistic">
                                    <div class="card-body p-0">
                                        <div class="d-flex flex-column">
                                            <div class='px-3 py-3 d-flex justify-content-between'>
                                                <h5 class='card-title'>Baterai (W)</h5>
                                            </div>
                                            <div class="chart-wrapper">
                                                <canvas id="canvas2" style="height:100px !important"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Power watt realtime chart</h4>
                                        </div>
                                        <div class="card-body">
                                            <div id="line"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Persentase Baterai</h4>
                                        </div>
                                        <div class="card-body">
                                            <div id="radialGradient"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2020 &copy; Voler</p>
                    </div>
                    <div class="float-end">
                        <p>Support with <span class='text-danger'><i data-feather="heart"></i></span> by <a href="http://antheiz.me">Antheiz</a></p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="assets/js/feather-icons/feather.min.js"></script>
    <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/app.js"></script>

    <script src="assets/vendors/chartjs/Chart.min.js"></script>
    <script src="assets/js/dayjs/dayjs.min.js"></script>
    <script src="assets/vendors/apexcharts/apexcharts.min.js"></script>
    <script src="assets/js/pages/ui-apexchart.js"></script>

    <script src="assets/js/main.js"></script>

    <script>
        var config1 = {
            type: "line",
            data: {
                labels: ["January", "February", "March", "April", "May", "June", "July"],
                datasets: [{
                    label: "Balance",
                    backgroundColor: "#fff",
                    borderColor: "#fff",
                    data: [20, 40, 20, 70, 10, 50, 20],
                    fill: false,
                    pointBorderWidth: 100,
                    pointBorderColor: "transparent",
                    pointRadius: 3,
                    pointBackgroundColor: "transparent",
                    pointHoverBackgroundColor: "rgba(63,82,227,1)",
                }, ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: -10,
                        top: 10,
                    },
                },
                legend: {
                    display: false,
                },
                title: {
                    display: false,
                },
                tooltips: {
                    mode: "index",
                    intersect: false,
                },
                hover: {
                    mode: "nearest",
                    intersect: true,
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            drawBorder: false,
                            display: false,
                        },
                        ticks: {
                            display: false,
                        },
                    }, ],
                    yAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false,
                        },
                        ticks: {
                            display: false,
                        },
                    }, ],
                },
            },
        };

        let ctx1 = document.getElementById("canvas1").getContext("2d");

        var lineChart1 = new Chart(ctx1, config1);

        var config2 = {
            type: "line",
            data: {
                labels: ["January", "February", "March", "April", "May", "June", "July"],
                datasets: [{
                    label: "Revenue",
                    backgroundColor: "#fff",
                    borderColor: "#fff",
                    data: [20, 800, 300, 400, 10, 50, 20],
                    fill: false,
                    pointBorderWidth: 100,
                    pointBorderColor: "transparent",
                    pointRadius: 3,
                    pointBackgroundColor: "transparent",
                    pointHoverBackgroundColor: "rgba(63,82,227,1)",
                }, ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: -10,
                        top: 10,
                    },
                },
                legend: {
                    display: false,
                },
                title: {
                    display: false,
                },
                tooltips: {
                    mode: "index",
                    intersect: false,
                },
                hover: {
                    mode: "nearest",
                    intersect: true,
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            drawBorder: false,
                            display: false,
                        },
                        ticks: {
                            display: false,
                        },
                    }, ],
                    yAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false,
                        },
                        ticks: {
                            display: false,
                        },
                    }, ],
                },
            },
        };

        let ctx2 = document.getElementById("canvas2").getContext("2d");

        var lineChart1 = new Chart(ctx2, config2);
    </script>

</body>

</html>