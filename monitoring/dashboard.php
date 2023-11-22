<?php
session_start();
require 'function.php';
if( !isset($_SESSION["login"])) {
  header("Location: login.php");
}

// // Cek apakah session mesin sudah di-set
// if (!isset($_SESSION['mesin'])) {
// 	// Jika belum, redirect ke halaman mesin option
// 	header("Location: dashboard.php");
// 	exit();
// }

// Last Status
$lastStatus = lastStatus();
// Mengecek hasil query

$varUtilDash = utilNowDash();
$varJobId = jobidNowDash();
$varOperatorId = operatorNowDash();
$varKwh = kwhNowDash();

// tmp utilisasi 
$tmp_util_grap = tmpUtilNow();
// Utilisasi Idle
$data_idle_grap = idleUtilNow();
// Utilisasi Running
$data_run_grap = runningUtilNow();
// Utilisasi Workpiece
$data_work_grap = workpieceUtilNow();
// Utilisasi Breakdown
$data_downtime_grap = downtimeUtilNow();
// Utilisasi Tools
$data_tools_grap = toolsUtilNow();


$data_table = dataTableDash();



if ($lastStatus->num_rows > 0) {
    foreach($lastStatus as $a){
        $l =  $a['status'];
    }
} else {
    echo "Tidak ada data ";
}

if(isset($_POST["logout"])) {
  session_destroy();
  header("Location : login.php");
  exit;
}

// // tmp utilisasi 
// $tmp_util_grap = tmpUtilDash();
// // Utilisasi Idle
// $data_idle_grap = idleUtilDash();
// // Utilisasi Running
// $data_run_grap = runningUtilDash();
// // Utilisasi Workpiece
// $data_work_grap = workpieceUtilDash();
// // Utilisasi Breakdown
// $data_breakdown_grap = breakdownUtilDash();
// // Utilisasi Tools
// $data_tools_grap = toolsUtilDash();
// $data_table = dataTableDash();
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
    <link rel="stylesheet" href="assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/vendors/owl-carousel-2/owl.theme.default.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />   
    <!-- Apex Chart -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <style>
      .wrapper{
    width:100%;
    display:block;
    overflow:hidden;
    margin:0 auto;
    /* padding: 60px 50px; */
    background:gray;
    border-radius:4px;
  }

  canvas{
    background: #191c24;
    height:200px;
  }

  h1{
    font-family: Roboto;
    color: #fff;
    margin-top:50px;
  }  
    </style>
    

  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      <?php
        if($_SESSION['username'] == 'planner'){
          include 'pages/sidebar/sidebar_planner.php'; 
        }else{
          include 'pages/sidebar/sidebar_all.php';
        } 
                
      ?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_navbar.html -->
        
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Dashboard </h3>
              <nav aria-label="breadcrumb">
                <!-- <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Lathe</li>
                </ol> -->
                <!-- <button class="btn btn-primary">Annual Report</button> -->
                <button class="btn btn-primary" data-toggle="modal" data-target="#modalAnnual">Annual Report</button>
                      
                      <!-- Modal -->
                      <div class="modal fade" id="modalAnnual" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="myModalLabel">Choose Year</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                            <!-- <div id="jobProgress" class="transaction-chart"></div> -->
                            <form action="pdfnew.php" method="POST">
                              <div class="input-group mb-3">
                                <input type="text" name="inputReport" class="form-control" placeholder="Input tahun" aria-label="input tahun" aria-describedby="button-addon2">
                                <button class="btn btn-outline-secondary" name="exportPdf" type="submit" id="button-addon2">Export to Pdf</button>
                              </div>
                              </div>
                              <div class="modal-footer">
                                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                              </div>
                            </form>



                          </div>
                        </div>
                      </div>
              </nav>
            </div>
            <?php include 'pages/navbar/navbar.php'; ?>
            
            <div class="page-header">
              <h3 class="page-title"> Lathe 1 Machine </h3>
            </div>
            <div class="row">
              <div class="col-md-3 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-8">
                        <h4 id="refLastStatus"><?= $l; ?></h4>
                          <!-- Konten untuk kolom kedua (bagian 1) -->
                      </div>
                    </div>
                    <div class="row">
                      <img src="assets/images/machine/bubut.png" class="img-fluid">
                      <!-- <div id="machineUtilizationDaily" ></div> -->
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-9 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="row">
                          <div class="col-md-12">
                            <h4>Utilization</h4>
                              <!-- Konten untuk kolom kedua (bagian 1) -->
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                          <div id="availLathe1"></div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-8">
                        <div class="row">
                          <div class="col-md-6">
                            <h4><?= $varJobId; ?></h4>
                          </div>
                          <div class="col-md-6">
                            <h4><?= $varOperatorId; ?></h4>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                          <div class="wrapper">
                            <canvas id="utilLathe1"></canvas>
                          </div>
                          </div>                
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                          <h4><?= $varKwh; ?></h4>
                          </div>                
                        </div>                        
                      </div>
                    </div>                  
                    
                    <!-- <div id="machineUtilizationDaily" ></div> -->
                  </div>
                </div>
              </div>
            </div>

            <div class="page-header">
              <h3 class="page-title"> Lathe 2 Machine </h3>
            </div>
            <div class="row">
              <div class="col-md-3 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-8">
                        <h3 >Running</h3>
                          <!-- Konten untuk kolom kedua (bagian 1) -->
                      </div>
                    </div>
                    <div class="row">
                      <img src="assets/images/machine/bubut.png" class="img-fluid">
                      <!-- <div id="machineUtilizationDaily" ></div> -->
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-9 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="row">
                          <div class="col-md-12">
                            <h3>Utilization</h3>
                              <!-- Konten untuk kolom kedua (bagian 1) -->
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                          <div id="availLathe2"></div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-8">
                        <div class="row">
                          <div class="col-md-6">
                            <h3>Job ID</h3>
                          </div>
                          <div class="col-md-6">
                            <h3>Operator</h3>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                          <div class="wrapper">
                            <canvas id="utilLathe2"></canvas>
                          </div>
                          </div>                
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                          <h3>Kwh</h3>
                          </div>                
                        </div>                        
                      </div>
                    </div>                  
                    
                    <!-- <div id="machineUtilizationDaily" ></div> -->
                  </div>
                </div>
              </div>
            </div> 

            <div class="page-header">
              <h3 class="page-title"> Lathe 3 Machine </h3>
            </div>
            <div class="row">
              <div class="col-md-3 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-8">
                        <h3>Running</h3>
                          <!-- Konten untuk kolom kedua (bagian 1) -->
                      </div>
                    </div>
                    <div class="row">
                      <img src="assets/images/machine/bubut.png" class="img-fluid">
                      <!-- <div id="machineUtilizationDaily" ></div> -->
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-9 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="row">
                          <div class="col-md-12">
                            <h3>Availability</h3>
                              <!-- Konten untuk kolom kedua (bagian 1) -->
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                          <div id="availLathe3"></div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-8">
                        <div class="row">
                          <div class="col-md-6">
                            <h3>Job ID</h3>
                          </div>
                          <div class="col-md-6">
                            <h3>Operator</h3>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                          <div class="wrapper">
                            <canvas id="utilLathe3"></canvas>
                          </div>
                          </div>                
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                          <h3>Kwh</h3>
                          </div>                
                        </div>                        
                      </div>
                    </div>                  
                    
                    <!-- <div id="machineUtilizationDaily" ></div> -->
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
    <script src="assets/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
    <!-- End plugin js for this page -->
    
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <!-- <script src="assets/js/chart-new.js"></script> -->
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="assets/js/dashboard.js"></script>
    <!-- End custom js for this page -->
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>


    <script>
    // availLathe
    var options1 = {
  chart: {
    height: 280,
    type: "radialBar",
  },
  series: [<?= number_format($varUtilDash, 2); ?>],
  colors: ["#20E647"],
  plotOptions: {
    radialBar: {
      startAngle: -135,
      endAngle: 135,
      track: {
        background: '#333',
        startAngle: -135,
        endAngle: 135,
      },
      dataLabels: {
        name: {
          show: false,
        },
        value: {
          fontSize: "30px",
          show: true
        }
      }
    }
  },
  fill: {
    type: "gradient",
    gradient: {
      shade: "dark",
      type: "horizontal",
      gradientToColors: ["#87D4F9"],
      stops: [0, 100]
    }
  },
  stroke: {
    lineCap: "butt"
  },
  labels: ["Progress"]
};

new ApexCharts(document.querySelector("#availLathe1"), options1).render();

// availLathe2
var options1 = {
  chart: {
    height: 280,
    type: "radialBar",
  },
  series: [67],
  colors: ["#20E647"],
  plotOptions: {
    radialBar: {
      startAngle: -135,
      endAngle: 135,
      track: {
        background: '#333',
        startAngle: -135,
        endAngle: 135,
      },
      dataLabels: {
        name: {
          show: false,
        },
        value: {
          fontSize: "30px",
          show: true
        }
      }
    }
  },
  fill: {
    type: "gradient",
    gradient: {
      shade: "dark",
      type: "horizontal",
      gradientToColors: ["#87D4F9"],
      stops: [0, 100]
    }
  },
  stroke: {
    lineCap: "butt"
  },
  labels: ["Progress"]
};

new ApexCharts(document.querySelector("#availLathe2"), options1).render();

// availLathe3
var options1 = {
  chart: {
    height: 280,
    type: "radialBar",
  },
  series: [67],
  colors: ["#20E647"],
  plotOptions: {
    radialBar: {
      startAngle: -135,
      endAngle: 135,
      track: {
        background: '#333',
        startAngle: -135,
        endAngle: 135,
      },
      dataLabels: {
        name: {
          show: false,
        },
        value: {
          fontSize: "30px",
          show: true
        }
      }
    }
  },
  fill: {
    type: "gradient",
    gradient: {
      shade: "dark",
      type: "horizontal",
      gradientToColors: ["#87D4F9"],
      stops: [0, 100]
    }
  },
  stroke: {
    lineCap: "butt"
  },
  labels: ["Progress"]
};

new ApexCharts(document.querySelector("#availLathe3"), options1).render();

// Util Lathe1
var ctx = document.getElementById("utilLathe1").getContext('2d');
var myChart = new Chart(ctx, {
  type: 'horizontalBar',
  data: {
    labels: [<?php while ($ccc = mysqli_fetch_assoc($tmp_util_grap)) { echo '"' . $ccc['time_util'] . '",';}?>],
    datasets: [{
      label: 'Idle Time',
      backgroundColor: "#caf270",
      data: [<?php while ($ui = mysqli_fetch_assoc($data_idle_grap)) { echo '"' . $ui['t_idle'] . '",';}?>],
    }, {
      label: 'Running Time',
      backgroundColor: "#45c490",
      data: [<?php while ($ur = mysqli_fetch_assoc($data_run_grap)) { echo '"' . $ur['t_run'] . '",';}?>],
    }, {
      label: 'Workpiece Time',
      backgroundColor: "#008d93",
      data: [<?php while ($uw = mysqli_fetch_assoc($data_work_grap)) { echo '"' . $uw['t_work'] . '",';}?>],
    }, {
      label: 'Tools Time',
      backgroundColor: "#2e5468",
      data: [<?php while ($ut = mysqli_fetch_assoc($data_tools_grap)) { echo '"' . $ut['t_tools'] . '",';}?>],
    }, {
      label: 'Breakdown Time',
      backgroundColor: "#2e5468",
      data: [<?php while ($ub = mysqli_fetch_assoc($data_downtime_grap)) { echo '"' . $ub['t_downtime'] . '",';}?>],
    }],
  },
options: {
    tooltips: {
      displayColors: true,
      callbacks:{
        mode: 'x',
      },
    },
    scales: {
      xAxes: [{
        stacked: true,
        ticks: {
          beginAtZero: true,
          fontColor: "#ffffff",
        },
        gridLines: {
          color: "#ffffff",
        },
      }],
      yAxes: [{
        stacked: true,
        ticks: {
          beginAtZero: true,
          fontColor: "#ffffff",
        },
        gridLines: {
          color: "#ffffff",
        },
      }]
    },
    responsive: true,
    maintainAspectRatio: false,
    legend: { position: 'bottom', labels: { fontColor: '#ffffff' } },
  }
});

// Util Lathe2
var ctx = document.getElementById("utilLathe2").getContext('2d');
var myChart = new Chart(ctx, {
  type: 'horizontalBar',
  data: {
    labels: ["2023"],
    datasets: [{
      label: 'Idle Time',
      backgroundColor: "#caf270",
      data: [12],
    }, {
      label: 'Running Time',
      backgroundColor: "#45c490",
      data: [12],
    }, {
      label: 'Workpiece Time',
      backgroundColor: "#008d93",
      data: [12],
    }, {
      label: 'Tools Time',
      backgroundColor: "#2e5468",
      data: [12],
    }, {
      label: 'Breakdown Time',
      backgroundColor: "#2e5468",
      data: [12],
    }],
  },
options: {
    tooltips: {
      displayColors: true,
      callbacks:{
        mode: 'x',
      },
    },
    scales: {
      xAxes: [{
        stacked: true,
        ticks: {
          beginAtZero: true,
          fontColor: "#ffffff",
        },
        gridLines: {
          color: "#ffffff",
        },
      }],
      yAxes: [{
        stacked: true,
        ticks: {
          beginAtZero: true,
          fontColor: "#ffffff",
        },
        gridLines: {
          color: "#ffffff",
        },
      }]
    },
    responsive: true,
    maintainAspectRatio: false,
    legend: { position: 'bottom', labels: { fontColor: '#ffffff' } },
  }
});

// Util Lathe3
var ctx = document.getElementById("utilLathe3").getContext('2d');
var myChart = new Chart(ctx, {
  type: 'horizontalBar',
  data: {
    labels: [2023],
    datasets: [{
      label: 'Idle Time',
      backgroundColor: "#caf270",
      data: [12],
    }, {
      label: 'Running Time',
      backgroundColor: "#45c490",
      data: [12],
    }, {
      label: 'Workpiece Time',
      backgroundColor: "#008d93",
      data: [12],
    }, {
      label: 'Tools Time',
      backgroundColor: "#2e5468",
      data: [12],
    }, {
      label: 'Breakdown Time',
      backgroundColor: "#2e5468",
      data: [12],
    }],
  },
options: {
    tooltips: {
      displayColors: true,
      callbacks:{
        mode: 'x',
      },
    },
    scales: {
      xAxes: [{
        stacked: true,
        ticks: {
          beginAtZero: true,
          fontColor: "#ffffff",
        },
        gridLines: {
          color: "#ffffff",
        },
      }],
      yAxes: [{
        stacked: true,
        ticks: {
          beginAtZero: true,
          fontColor: "#ffffff",
        },
        gridLines: {
          color: "#ffffff",
        },
      }]
    },
    responsive: true,
    maintainAspectRatio: false,
    legend: { position: 'bottom', labels: { fontColor: '#ffffff' } },
  }
});



        
// refresh
// Fungsi untuk merefresh data
function refreshData() {
  // Membuat objek XMLHttpRequest
  var xhttp = new XMLHttpRequest();
  
  // Menetapkan fungsi callback untuk menerima respon dari server
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      // Memperbarui bagian tertentu di halaman web dengan data baru
      document.getElementById("refLastStatus").innerHTML = this.responseText;
    }
  };
  
  // Mengirim permintaan ke server untuk mendapatkan data baru
  xhttp.open("GET", "data.php", true);
  xhttp.send();
}

// Mengatur waktu refresh data (dalam milidetik)
var refreshInterval = setInterval(refreshData, 5000);



    </script>

<script>
        function loadLastStatus() {
            var vLastStatus = new XMLHttpRequest();
            vLastStatus.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("refLastStatus").innerHTML = this.responseText;
                }
            };
            vLastStatus.open("GET", "read_data.php", true);
            vLastStatus.send();
        }

        function loadbefStatus() {
            var vBefStatus = new XMLHttpRequest();
            vBefStatus.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("refBeforeStatus").innerHTML = this.responseText;
                }
            };
            vBefStatus.open("GET", "read_data.php", true);
            vBefStatus.send();
        }

        function loadDowntime() {
            var vDowntime = new XMLHttpRequest();
            vDowntime.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("refDowntime").innerHTML = this.responseText;
                }
            };
            vDowntime.open("GET", "read_data.php", true);
            vDowntime.send();
        }

        function loadDowntimeToday() {
            var vDowntimeToday = new XMLHttpRequest();
            vDowntimeToday.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("refDowntimeToday").innerHTML = this.responseText;
                }
            };
            vDowntimeToday.open("GET", "read_data.php", true);
            vDowntimeToday.send();
        }

        function loadRunning() {
            var vRun = new XMLHttpRequest();
            vRun.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("refRunning").innerHTML = this.responseText;
                }
            };
            vRun.open("GET", "read_data.php", true);
            vRun.send();
        }

        function loadRunningToday() {
            var vRunningToday = new XMLHttpRequest();
            vRunningToday.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("refRunningToday").innerHTML = this.responseText;
                }
            };
            vRunningToday.open("GET", "read_data.php", true);
            vRunningToday.send();
        }


        setInterval(function() {
            loadLastStatus();
            loadBefStatus();
            loadDowntime();
            loadDowntimeToday();
            loadRunning();
            loadRunningToday();
        }, 5000);
    </script>
  </body>
</html>


