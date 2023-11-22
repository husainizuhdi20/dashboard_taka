<?php
if(isset($_POST["exportPdf"])) {
    $tahunReport = $_POST["inputReport"];
    echo $tahunReport;
}


?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Annual Report</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <!-- Layout styles -->
        <!-- <link rel="stylesheet" href="assets/css/style_report.css"> -->

        <!-- Fontawesome -->
        <script src="https://kit.fontawesome.com/bb82ed4168.js" crossorigin="anonymous"></script>
        <!-- Apex Chart -->
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    </head>
    <body scroll="auto">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-3 grid-margin">
                    <h1 style="font-size: 70px;">Annual Machine Report</h1>
                    <hr color="#00000" size="10" width="50%">
                </div>
                <div class="col-md-3 text-center">
                    <img src="assets/images/logo.jpg" alt="" width="200" height="50">
                    <h2>GENERAL REPORT</h2>
                    <h3>Wed, 10 Jan 2023 11:30 AM</h3>
                </div>
            </div>
            <div class="row justify-content-center text-center">
                <div class="col-md-3 grid-margin">
                    <h4>Machine ID : <strong>Semeru</strong></h4>
                    <img src="assets/images/machine/bubut.png" alt="" width="100" height="100">
                </div>
                <div class="col-md-9 grid-margin">
                    <div class="table-responsive">
                        <table class="table table-bordered border-dark">
                            <tbody>
                            <tr>
                                <td>Jumlah Pekerjaan</td>
                                <td><strong>35</strong></td>
                            </tr>
                            <tr>
                                <td>Maintenance</td>
                                <td><strong>4/4</strong></td>
                            </tr>
                            <tr>
                                <td>Breakdown</td>
                                <td><strong>-</strong></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>                    
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-6 grid-margin ">
                    <div class="card-body">
                        <h4 class="card-title">Hours</h4>
                        <i class="fa-regular fa-clock"></i>
                        <div class="chart-container" style="height:50%; width:100%">
                            <div id="hoursGeneral"></div>
                        </div> 
                    </div>
                </div>
                <div class="col-lg-6 grid-margin">   
                    <div class="card-body">
                        <!-- <h4 class="card-title"></h4> -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="chart-container" style="height:50%; width:100%">
                                    <div id="utilisasiGeneral"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="chart-container" style="height:50%; width:100%">
                                    <div id="maintenanceGeneral"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-lg-12 ">
                                <!-- <i class="fa-sharp fa-solid fa-arrows-rotate"></i> -->
                                <h4>Parts Replaced</h4>
                                <h1>3<sub>Pcs</sub></h1>
                                <h4>Parts Repaired</h4>
                                <h1>2<sub>Pcs</sub></h1>
                            </div>
                        </div>   
                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-lg-6 grid-margin ">
                    <div class="card-body">
                        <h4 class="card-title">Energy</h4>
                        <i class="fa-regular fa-clock"></i>
                        <div class="chart-container" style="height:50%; width:100%">
                            <div id="energyGeneral"></div>
                        </div> 
                    </div>
                </div>
                <div class="col-lg-6 grid-margin">   
                    <div class="card-body">
                        <!-- <h4 class="card-title"></h4> -->
                            <div class="col-lg-6">
                                <div class="chart-container" style="height:50%; width:100%">
                                    <div id="utilisasiGeneral"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="chart-container" style="height:50%; width:100%">
                                    <div id="maintenanceGeneral"></div>
                                </div>
                            </div>
                        
                            <div class="col-lg-12 text-center">
                                <!-- <i class="fa-sharp fa-solid fa-arrows-rotate"></i> -->
                                <h4>Machine Runtime</h4>
                                <h1>103.803<sub>Jam</sub></h1>
                                <h4>Total Energy</h4>
                                <h1>9854<sub>kWh</sub></h1>
                            </div>
                           
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script src="assets/js/report.js"></script>
    </body>
</html>