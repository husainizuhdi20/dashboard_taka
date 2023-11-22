<?php
session_start();
if( !isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

require "function.php";
if(isset($_GET['searchData'])) {
    $tgl1 = $_GET['tgl1'];
    $tgl2 = $_GET['tgl2'];
  
    // total time
    $totalTime = powerOnF($tgl1, $tgl2);
    foreach($totalTime as $p){
      $qp =  $p['timePowerOn'];
    }
  
    // // Planned Downtime
    // $break = breakA($tgl1, $tgl2);
    // foreach($break as $br1){
    //   $qbreak1 =  $br1['timeBreak'];
    // }
  
    // $breakdown = breakdownA($tgl1, $tgl2);
    // foreach($breakdown as $breakdown1){
    //   $qbreakdown =  $breakdown1['timeBreakdown'];
    // }
    // $plannedDownTime = ($qbreak1 + $qbreakdown)/100;

    // $husain = total($tgl1, $tgl2);
  
  
    $facilityDowntime;
  
    $setupAndAdjustment;
  
    $materialShortages;
  
    $manpowerAbsence;
   
      
  // Readiness
  // Availability of Facility
  // Changover Efficiency
  // Availability of Material
  // Availability of Manpower
  // Quality Rate
  // Performance Rate
  // ORE
  // OEE
  
  // Equipment Failure
  // Setup and Adjustment
  // Idling and Minor Stoppages
  // Reduce Speed
  // Defect and Rework
  // Reduced Yield
  
  }
  
  else{
  // Readiness
  
  // Availability of Facility
  // Changover Efficiency
  // Availability of Material
  // Availability of Manpower
  // Quality Rate
  // Performance Rate
  // ORE
  // OEE
  
  
  // Equipment Failure
  // Setup and Adjustment
  // Idling and Minor Stoppages
  // Reduce Speed
  // Defect and Rework
  // Reduced Yield
  
  
  // energy consumption
  //   $queryc = currentMonth();
  //   foreach($queryc as $c2){
  //     $qc =  $c2['total_data'];
  //   }
  
  
  }



?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Taka Turbomachinary</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End Plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />
    <!-- Apex Chart -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:../../partials/_sidebar.html -->
      <?php include 'pages/sidebar/sidebar.php'; ?>
      
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:../../partials/_navbar.html -->
        <?php include 'pages/navbar/navbar.php'; ?>
        
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Analysis ?> </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Analysis</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Lathe</li>
                    <!-- <button class="btn btn-primary">ORE</button>
                    <button class="btn btn-primary">Six Big Losses</button> -->
                </ol>
              </nav>
            </div>
            
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <form class="row g-3" action="" method="GET">
                        <div class="col-auto">    
                            <input type="date" class="form-control" id="inputTgl1" name="tgl1" placeholder="Input First Date" autocomplete="off">
                        </div>
                        <div class="col-auto">    
                            <input type="date" class="form-control" id="inputTgl2" name="tgl2" placeholder="Input Last Date" autocomplete="off">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary mb-3" name="searchData">Submit</button>
                        </div>
                    </form>
                  </div>
                </div>
              </div>  
            </div>
            <div class="page-header">
              <h3 class="page-title"> Overall Resource Effectiveness </h3>
              <!-- <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Analysis</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Lathe</li>
                    <button class="btn btn-primary">ORE</button>
                    <button class="btn btn-primary">Six Big Losses</button>
                </ol>
              </nav> -->
            </div>
            <div class="row">
                <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                    <h5>Readiness</h5>
                    <div class="row">
                        <div class="col-12">
                        <div id="readiness" style="height:100px"></div>
                        <!-- <div class="d-flex align-items-center align-self-start">
                            <h3 class="mb-0">10 %</h3>
                            <p class="text-success ml-2 mb-0 font-weight-medium"></p>
                        </div> -->
                        </div>
                        <div class="col-3">
                        <!-- <div class="icon icon-box-success ">
                            <span class="mdi mdi-arrow-top-right icon-item"></span>
                        </div> -->
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal"></h6>
                    </div>
                </div>
                </div>
                <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                    <h5>Availability of Facility</h5>
                    <div class="row">
                        <div class="col-12">
                            <div id="aof" style="height:100px"></div>
                            <!-- <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">10 %</h3>
                                <p class="text-success ml-2 mb-0 font-weight-medium"></p>
                            </div> -->
                            </div>
                            <div class="col-3">
                            <!-- <div class="icon icon-box-success ">
                                <span class="mdi mdi-arrow-top-right icon-item"></span>
                            </div> -->
                        </div>
                    </div>
                    <!-- <h6 class="text-muted font-weight-normal"><?= $bs; ?> - <?= $tbs; ?></h6>
                -->
                <!-- <h6 id="refBefStatus" class="text-muted font-weight-normal">30</h6> -->
                    </div>
                </div>
                </div>
                <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                    <h5>Changover Efficiency</h5>
                    <div class="row">
                        <div class="col-12">
                            <div id="ce" style="height:100px"></div>
                            <!-- <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">10 %</h3>
                                <p class="text-success ml-2 mb-0 font-weight-medium"></p>
                            </div> -->
                            </div>
                            <div class="col-3">
                            <!-- <div class="icon icon-box-success ">
                                <span class="mdi mdi-arrow-top-right icon-item"></span>
                            </div> -->
                        </div>
                    </div>
                    <h6 id="refDowntimeToday" class="text-muted font-weight-normal">Today - 50</h6>
                    </div>
                </div>
                </div>
                
            </div>

            <div class="row">
                <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                    <h5>Availability of Material</h5>
                    <div class="row">
                        <div class="col-12">
                        <div id="aomat" style="height:100px"></div>
                        <!-- <div class="d-flex align-items-center align-self-start">
                            <h3 class="mb-0">10 %</h3>
                            <p class="text-success ml-2 mb-0 font-weight-medium"></p>
                        </div> -->
                        </div>
                        <div class="col-3">
                        <!-- <div class="icon icon-box-success ">
                            <span class="mdi mdi-arrow-top-right icon-item"></span>
                        </div> -->
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal"></h6>
                    </div>
                </div>
                </div>
                <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                    <h5>Availability of Manpower</h5>
                    <div class="row">
                        <div class="col-12">
                            <div id="aoman" style="height:100px"></div>
                            <!-- <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">10 %</h3>
                                <p class="text-success ml-2 mb-0 font-weight-medium"></p>
                            </div> -->
                            </div>
                            <div class="col-3">
                            <!-- <div class="icon icon-box-success ">
                                <span class="mdi mdi-arrow-top-right icon-item"></span>
                            </div> -->
                        </div>
                    </div>
                    <!-- <h6 class="text-muted font-weight-normal"><?= $bs; ?> - <?= $tbs; ?></h6>
                -->
                <!-- <h6 id="refBefStatus" class="text-muted font-weight-normal">30</h6> -->
                    </div>
                </div>
                </div>
                <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                    <h5>Quality Rate</h5>
                    <div class="row">
                        <div class="col-12">
                            <div id="qt" style="height:100px"></div>
                            <!-- <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">10 %</h3>
                                <p class="text-success ml-2 mb-0 font-weight-medium"></p>
                            </div> -->
                            </div>
                            <div class="col-3">
                            <!-- <div class="icon icon-box-success ">
                                <span class="mdi mdi-arrow-top-right icon-item"></span>
                            </div> -->
                        </div>
                    </div>
                    <h6 id="refDowntimeToday" class="text-muted font-weight-normal">Today - 50</h6>
                    </div>
                </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                    <h5>Performance Rate</h5>
                    <div class="row">
                        <div class="col-12">
                        <div id="pt" style="height:100px"></div>
                        <!-- <div class="d-flex align-items-center align-self-start">
                            <h3 class="mb-0">10 %</h3>
                            <p class="text-success ml-2 mb-0 font-weight-medium"></p>
                        </div> -->
                        </div>
                        <div class="col-3">
                        <!-- <div class="icon icon-box-success ">
                            <span class="mdi mdi-arrow-top-right icon-item"></span>
                        </div> -->
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal"></h6>
                    </div>
                </div>
                </div>
                <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                    <h5>ORE</h5>
                    <div class="row">
                        <div class="col-12">
                            <div id="ore" style="height:100px"></div>
                            <!-- <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">10 %</h3>
                                <p class="text-success ml-2 mb-0 font-weight-medium"></p>
                            </div> -->
                            </div>
                            <div class="col-3">
                            <!-- <div class="icon icon-box-success ">
                                <span class="mdi mdi-arrow-top-right icon-item"></span>
                            </div> -->
                        </div>
                    </div>
                    <!-- <h6 class="text-muted font-weight-normal"><?= $bs; ?> - <?= $tbs; ?></h6>
                -->
                <!-- <h6 id="refBefStatus" class="text-muted font-weight-normal">30</h6> -->
                    </div>
                </div>
                </div>
                <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                    <h5>OEE</h5>
                    <div class="row">
                        <div class="col-12">
                            <div id="oee" style="height:100px"></div>
                            <!-- <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">10 %</h3>
                                <p class="text-success ml-2 mb-0 font-weight-medium"></p>
                            </div> -->
                            </div>
                            <div class="col-3">
                            <!-- <div class="icon icon-box-success ">
                                <span class="mdi mdi-arrow-top-right icon-item"></span>
                            </div> -->
                        </div>
                    </div>
                    <!-- <h6 class="text-muted font-weight-normal"><?= $bs; ?> - <?= $tbs; ?></h6>
                -->
                <!-- <h6 id="refBefStatus" class="text-muted font-weight-normal">30</h6> -->
                    </div>
                </div>
                </div>
                 
            </div>

            <div class="page-header">
              <h3 class="page-title"> Six Big Losses </h3>
              <!-- <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Analysis</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Lathe</li>
                    <button class="btn btn-primary">ORE</button>
                    <button class="btn btn-primary">Six Big Losses</button>
                </ol>
              </nav> -->
            </div>

            <div class="row">
                <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                    <h5>Equipment Failure</h5>
                    <div class="row">
                        <div class="col-12">
                        <div id="equipmentFailure" style="height:100px"></div>
                        <!-- <div class="d-flex align-items-center align-self-start">
                            <h3 class="mb-0">10 %</h3>
                            <p class="text-success ml-2 mb-0 font-weight-medium"></p>
                        </div> -->
                        </div>
                        <div class="col-3">
                        <!-- <div class="icon icon-box-success ">
                            <span class="mdi mdi-arrow-top-right icon-item"></span>
                        </div> -->
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal"></h6>
                    </div>
                </div>
                </div>
                <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                    <h5>Setup and Adjustment</h5>
                    <div class="row">
                        <div class="col-12">
                            <div id="setupAdjustment" style="height:100px"></div>
                            <!-- <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">10 %</h3>
                                <p class="text-success ml-2 mb-0 font-weight-medium"></p>
                            </div> -->
                            </div>
                            <div class="col-3">
                            <!-- <div class="icon icon-box-success ">
                                <span class="mdi mdi-arrow-top-right icon-item"></span>
                            </div> -->
                        </div>
                    </div>
                    <!-- <h6 class="text-muted font-weight-normal"><?= $bs; ?> - <?= $tbs; ?></h6>
                -->
                <!-- <h6 id="refBefStatus" class="text-muted font-weight-normal">30</h6> -->
                    </div>
                </div>
                </div>
                <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                    <h5>Idling and Minor Stoppages</h5>
                    <div class="row">
                        <div class="col-12">
                            <div id="idlingMinor" style="height:100px"></div>
                            <!-- <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">10 %</h3>
                                <p class="text-success ml-2 mb-0 font-weight-medium"></p>
                            </div> -->
                            </div>
                            <div class="col-3">
                            <!-- <div class="icon icon-box-success ">
                                <span class="mdi mdi-arrow-top-right icon-item"></span>
                            </div> -->
                        </div>
                    </div>
                    <!-- <h6 class="text-muted font-weight-normal"><?= $bs; ?> - <?= $tbs; ?></h6>
                -->
                <!-- <h6 id="refBefStatus" class="text-muted font-weight-normal">30</h6> -->
                    </div>
                </div>
                </div>
                 
            </div>

            <div class="row">
                <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                    <h5>Reduced Speed</h5>
                    <div class="row">
                        <div class="col-12">
                        <div id="reducedSpeed" style="height:100px"></div>
                        <!-- <div class="d-flex align-items-center align-self-start">
                            <h3 class="mb-0">10 %</h3>
                            <p class="text-success ml-2 mb-0 font-weight-medium"></p>
                        </div> -->
                        </div>
                        <div class="col-3">
                        <!-- <div class="icon icon-box-success ">
                            <span class="mdi mdi-arrow-top-right icon-item"></span>
                        </div> -->
                        </div>
                    </div>
                    <h6 class="text-muted font-weight-normal"></h6>
                    </div>
                </div>
                </div>
                <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                    <h5>Defect and Rework</h5>
                    <div class="row">
                        <div class="col-12">
                            <div id="defectRework" style="height:100px"></div>
                            <!-- <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">10 %</h3>
                                <p class="text-success ml-2 mb-0 font-weight-medium"></p>
                            </div> -->
                            </div>
                            <div class="col-3">
                            <!-- <div class="icon icon-box-success ">
                                <span class="mdi mdi-arrow-top-right icon-item"></span>
                            </div> -->
                        </div>
                    </div>
                    <!-- <h6 class="text-muted font-weight-normal"><?= $bs; ?> - <?= $tbs; ?></h6>
                -->
                <!-- <h6 id="refBefStatus" class="text-muted font-weight-normal">30</h6> -->
                    </div>
                </div>
                </div>
                <div class="col-xl-4 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                    <h5>Reduced Yield</h5>
                    <div class="row">
                        <div class="col-12">
                            <div id="reducedYield" style="height:100px"></div>
                            <!-- <div class="d-flex align-items-center align-self-start">
                                <h3 class="mb-0">10 %</h3>
                                <p class="text-success ml-2 mb-0 font-weight-medium"></p>
                            </div> -->
                            </div>
                            <div class="col-3">
                            <!-- <div class="icon icon-box-success ">
                                <span class="mdi mdi-arrow-top-right icon-item"></span>
                            </div> -->
                        </div>
                    </div>
                    <!-- <h6 class="text-muted font-weight-normal"><?= $bs; ?> - <?= $tbs; ?></h6>
                -->
                <!-- <h6 id="refBefStatus" class="text-muted font-weight-normal">30</h6> -->
                    </div>
                </div>
                </div>
                 
            </div>

            
          </div>
          <!-- content-wrapper ends -->
          <?php include 'pages/footer/footer.php'; ?>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="assets/vendors/chart.js/Chart.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="assets/js/chart.js"></script>
    <!-- <script src="assets/js/chart-new.js"></script> -->
    <!-- End custom js for this page -->

    <script>
      


// Readiness
var options = {
  chart: {
    height: 280,
    type: "radialBar"
  },
  
  series: [80],
  
  plotOptions: {
    radialBar: {
      hollow: {
        margin: 15,
        size: "70%"
      },
     
      dataLabels: {
        showOn: "always",
        name: {
          offsetY: -10,
          show: true,
          color: "#888",
          fontSize: "13px"
        },
        value: {
          style: {
            color: "#FFFFFF" // ubah warna di sini
          },
          fontSize: "30px",
          show: true
        }
      }
    }
  },

  stroke: {
    lineCap: "round",
  },
  labels: ["Readiness"]
};

var chart = new ApexCharts(document.querySelector("#readiness"), options);

chart.render();
// End Readiness

// AoF
var options = {
  chart: {
    height: 280,
    type: "radialBar"
  },
  
  series: [67],
  
  plotOptions: {
    radialBar: {
      hollow: {
        margin: 15,
        size: "70%"
      },
     
      dataLabels: {
        showOn: "always",
        name: {
          offsetY: -10,
          show: true,
          color: "#888",
          fontSize: "13px"
        },
        value: {
          style: {
            color: "#FFFFFF" // ubah warna di sini
          },
          fontSize: "30px",
          show: true
        }
      }
    }
  },

  stroke: {
    lineCap: "round",
  },
  labels: ["Availability of Facility"]
};

var chart = new ApexCharts(document.querySelector("#aof"), options);

chart.render();
// End AoF


// ce
var options = {
  chart: {
    height: 280,
    type: "radialBar"
  },
  
  series: [67],
  
  plotOptions: {
    radialBar: {
      hollow: {
        margin: 15,
        size: "70%"
      },
     
      dataLabels: {
        showOn: "always",
        name: {
          offsetY: -10,
          show: true,
          color: "#888",
          fontSize: "13px"
        },
        value: {
          style: {
            color: "#FFFFFF" // ubah warna di sini
          },
          fontSize: "30px",
          show: true
        }
      }
    }
  },

  stroke: {
    lineCap: "round",
  },
  labels: ["Changover Efficiency"]
};

var chart = new ApexCharts(document.querySelector("#ce"), options);

chart.render();
// End ce


// aomat
var options = {
  chart: {
    height: 280,
    type: "radialBar"
  },
  
  series: [67],
  
  plotOptions: {
    radialBar: {
      hollow: {
        margin: 15,
        size: "70%"
      },
     
      dataLabels: {
        showOn: "always",
        name: {
          offsetY: -10,
          show: true,
          color: "#888",
          fontSize: "13px"
        },
        value: {
          style: {
            color: "#FFFFFF" // ubah warna di sini
          },
          fontSize: "30px",
          show: true
        }
      }
    }
  },

  stroke: {
    lineCap: "round",
  },
  labels: ["Availability of Material"]
};

var chart = new ApexCharts(document.querySelector("#aomat"), options);

chart.render();
// End Aomat

// aoman
var options = {
  chart: {
    height: 280,
    type: "radialBar"
  },
  
  series: [67],
  
  plotOptions: {
    radialBar: {
      hollow: {
        margin: 15,
        size: "70%"
      },
     
      dataLabels: {
        showOn: "always",
        name: {
          offsetY: -10,
          show: true,
          color: "#888",
          fontSize: "13px"
        },
        value: {
          style: {
            color: "#FFFFFF" // ubah warna di sini
          },
          fontSize: "30px",
          show: true
        }
      }
    }
  },

  stroke: {
    lineCap: "round",
  },
  labels: ["Availability of Manpower"]
};

var chart = new ApexCharts(document.querySelector("#aoman"), options);

chart.render();
// End aoman


// qt
var options = {
  chart: {
    height: 280,
    type: "radialBar"
  },
  
  series: [67],
  
  plotOptions: {
    radialBar: {
      hollow: {
        margin: 15,
        size: "70%"
      },
     
      dataLabels: {
        showOn: "always",
        name: {
          offsetY: -10,
          show: true,
          color: "#888",
          fontSize: "13px"
        },
        value: {
          style: {
            color: "#FFFFFF" // ubah warna di sini
          },
          fontSize: "30px",
          show: true
        }
      }
    }
  },

  stroke: {
    lineCap: "round",
  },
  labels: ["Quality Rate"]
};

var chart = new ApexCharts(document.querySelector("#qt"), options);

chart.render();
// End Qt


// pt
var options = {
  chart: {
    height: 280,
    type: "radialBar"
  },
  
  series: [67],
  
  plotOptions: {
    radialBar: {
      hollow: {
        margin: 15,
        size: "70%"
      },
     
      dataLabels: {
        showOn: "always",
        name: {
          offsetY: -10,
          show: true,
          color: "#888",
          fontSize: "13px"
        },
        value: {
          style: {
            color: "#FFFFFF" // ubah warna di sini
          },
          fontSize: "30px",
          show: true
        }
      }
    }
  },

  stroke: {
    lineCap: "round",
  },
  labels: ["Performance Rate"]
};

var chart = new ApexCharts(document.querySelector("#pt"), options);

chart.render();
// End pt

// ore
var options = {
  chart: {
    height: 280,
    type: "radialBar"
  },
  
  series: [67],
  
  plotOptions: {
    radialBar: {
      hollow: {
        margin: 15,
        size: "70%"
      },
     
      dataLabels: {
        showOn: "always",
        name: {
          offsetY: -10,
          show: true,
          color: "#888",
          fontSize: "13px"
        },
        value: {
          style: {
            color: "#FFFFFF" // ubah warna di sini
          },
          fontSize: "30px",
          show: true
        }
      }
    }
  },

  stroke: {
    lineCap: "round",
  },
  labels: ["ORE"]
};

var chart = new ApexCharts(document.querySelector("#ore"), options);

chart.render();
// End ore

// oee
var options = {
  chart: {
    height: 280,
    type: "radialBar"
  },
  
  series: [67],
  
  plotOptions: {
    radialBar: {
      hollow: {
        margin: 15,
        size: "70%"
      },
     
      dataLabels: {
        showOn: "always",
        name: {
          offsetY: -10,
          show: true,
          color: "#888",
          fontSize: "13px"
        },
        value: {
          style: {
            color: "#FFFFFF" // ubah warna di sini
          },
          fontSize: "30px",
          show: true
        }
      }
    }
  },

  stroke: {
    lineCap: "round",
  },
  labels: ["OEE"]
};

var chart = new ApexCharts(document.querySelector("#oee"), options);

chart.render();
// End oee


// equipment failure
var options = {
  chart: {
    height: 280,
    type: "radialBar"
  },
  
  series: [67],
  
  plotOptions: {
    radialBar: {
      hollow: {
        margin: 15,
        size: "70%"
      },
     
      dataLabels: {
        showOn: "always",
        name: {
          offsetY: -10,
          show: true,
          color: "#888",
          fontSize: "13px"
        },
        value: {
          style: {
            color: "#FFFFFF" // ubah warna di sini
          },
          fontSize: "30px",
          show: true
        }
      }
    }
  },

  stroke: {
    lineCap: "round",
  },
  labels: ["Equipment Failure"]
};

var chart = new ApexCharts(document.querySelector("#equipmentFailure"), options);

chart.render();
// End equipment failure

// setupAdjustment
var options = {
  chart: {
    height: 280,
    type: "radialBar"
  },
  
  series: [67],
  
  plotOptions: {
    radialBar: {
      hollow: {
        margin: 15,
        size: "70%"
      },
     
      dataLabels: {
        showOn: "always",
        name: {
          offsetY: -10,
          show: true,
          color: "#888",
          fontSize: "13px"
        },
        value: {
          style: {
            color: "#FFFFFF" // ubah warna di sini
          },
          fontSize: "30px",
          show: true
        }
      }
    }
  },

  stroke: {
    lineCap: "round",
  },
  labels: ["Setup Adjustment"]
};

var chart = new ApexCharts(document.querySelector("#setupAdjustment"), options);

chart.render();
// End setupAdjustment


// idlingMinor
var options = {
  chart: {
    height: 280,
    type: "radialBar"
  },
  
  series: [67],
  
  plotOptions: {
    radialBar: {
      hollow: {
        margin: 15,
        size: "70%"
      },
     
      dataLabels: {
        showOn: "always",
        name: {
          offsetY: -10,
          show: true,
          color: "#888",
          fontSize: "13px"
        },
        value: {
          style: {
            color: "#FFFFFF" // ubah warna di sini
          },
          fontSize: "30px",
          show: true
        }
      }
    }
  },

  stroke: {
    lineCap: "round",
  },
  labels: ["Idling and Minor Stoppages"]
};

var chart = new ApexCharts(document.querySelector("#idlingMinor"), options);

chart.render();
// End Idling Minor

// Reduced Speed
var options = {
  chart: {
    height: 280,
    type: "radialBar"
  },
  
  series: [67],
  
  plotOptions: {
    radialBar: {
      hollow: {
        margin: 15,
        size: "70%"
      },
     
      dataLabels: {
        showOn: "always",
        name: {
          offsetY: -10,
          show: true,
          color: "#888",
          fontSize: "13px"
        },
        value: {
          style: {
            color: "#FFFFFF" // ubah warna di sini
          },
          fontSize: "30px",
          show: true
        }
      }
    }
  },

  stroke: {
    lineCap: "round",
  },
  labels: ["Reduced Speed"]
};

var chart = new ApexCharts(document.querySelector("#reducedSpeed"), options);

chart.render();
// End Reduced Speed


// Defect and Rework
var options = {
  chart: {
    height: 280,
    type: "radialBar"
  },
  
  series: [67],
  
  plotOptions: {
    radialBar: {
      hollow: {
        margin: 15,
        size: "70%"
      },
     
      dataLabels: {
        showOn: "always",
        name: {
          offsetY: -10,
          show: true,
          color: "#888",
          fontSize: "13px"
        },
        value: {
          style: {
            color: "#FFFFFF" // ubah warna di sini
          },
          fontSize: "30px",
          show: true
        }
      }
    }
  },

  stroke: {
    lineCap: "round",
  },
  labels: ["Defect Rework"]
};

var chart = new ApexCharts(document.querySelector("#defectRework"), options);

chart.render();
// End Defect and Rework


// Reduced Yield
var options = {
  chart: {
    height: 280,
    type: "radialBar"
  },
  
  series: [67],
  
  plotOptions: {
    radialBar: {
      hollow: {
        margin: 15,
        size: "70%"
      },
     
      dataLabels: {
        showOn: "always",
        name: {
          offsetY: -10,
          show: true,
          color: "#888",
          fontSize: "13px"
        },
        value: {
          style: {
            color: "#FFFFFF" // ubah warna di sini
          },
          fontSize: "30px",
          show: true
        }
      }
    }
  },

  stroke: {
    lineCap: "round",
  },
  labels: ["Reduced Yield"]
};

var chart = new ApexCharts(document.querySelector("#reducedYield"), options);

chart.render();
// End Reduced Yield







    </script>

  </body>
</html>