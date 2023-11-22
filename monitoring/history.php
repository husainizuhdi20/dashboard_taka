<?php
session_start();
if( !isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

require "function.php";
if(isset($_GET['dateSearch'])) {
  $date1 = $_GET['date1'];
  $date2 = $_GET['date2'];

  // power on 
  $powerOn = powerOnF($date1, $date2);
  foreach($powerOn as $p){
    $qp =  $p['timePowerOn'];
  }

  // MTBF 
  $mtbf = mtbfF($date1, $date2);
  foreach($mtbf as $m){
    $qm =  $m['timeMtbf'];
  }

  // QC 
  $quc = qcF($date1, $date2);
  foreach($quc as $c){
    $qc =  $c['timeQc'];
  }

  // running 
  $run = runningF($date1, $date2);
  foreach($run as $r){
    $qr =  $r['timeRun'];
  }

  // setup
  $setup = setupF($date1, $date2);
  foreach($setup as $s){
    $qs =  $s['timeSet'];
  }

  // login on
  $loginOn = loginOnF($date1, $date2);
  foreach($loginOn as $l){
    $ql =  $l['timeLogin'];
  }

  // idle
  $idle = idleF($date1, $date2);
  foreach($idle as $i){
    $qi =  $i['timeIdle'];
  }

  // break 
  $break = breakF($date1, $date2);
  foreach($break as $br1){
    $qbreak1 =  $br1['timeBreak'];
  }

  // breakdown 
  $breakdown = breakdownF($date1, $date2);
  foreach($breakdown as $breakdown1){
    $qbreakdown =  $breakdown1['timeBreakdown'];
  }
  
  // Workpiece 
  $workpiece = workpieceF($date1, $date2);
  foreach($workpiece as $w){
    $qpiece =  $w['timeWorkpiece'];
  }  

  // Tools 
  $tools = toolsF($date1, $date2);
  foreach($tools as $t){
    $qtools =  $t['timeTools'];
  }  

// QUERY GRAFIK
  // $tmpConsumption = mysqli_query($koneksi, "SELECT * FROM tb_energy WHERE tmp BETWEEN '$date1' AND '$date2' ");
  $tmpEnergy = tmpEnergyF($date1, $date2);
  $dataEnergy = dataEnergyF($date1, $date2);

  // Query Job Result
  // $energy = mysqli_query($koneksi, "SELECT *, SUM(energy) AS jumlahEnergi FROM tb_energy WHERE tmp BETWEEN '$date1' AND '$date2'");
  // foreach($energy as $en){
  //   $qenergy =  $en['jumlahEnergi'];
  // }  


  // tmp utilisasi 
  $tmp_util_grap = tmpUtilF($date1, $date2);

  // Utilisasi Idle
  $data_idle_grap = idleUtilF($date1, $date2);

  // Utilisasi Running
  $data_run_grap = runningUtilF($date1, $date2);

  // Utilisasi Workpiece
  $data_work_grap = workpieceUtilF($date1, $date2);

  // Utilisasi Breakdown
  $data_downtime_grap = downtimeUtilF($date1, $date2);

  // Utilisasi Tools
  $data_tools_grap = toolsUtilF($date1, $date2);


  // Table
  $data_table = dataTableF($date1, $date2);


}
else{
// power on 
$powerOn = powerOnN();
foreach($powerOn as $p){
  $qp =  $p['timePowerOn'];
}

// MTBF 
$mtbf = mtbfN();
foreach($mtbf as $m){
  $qm =  $m['timeMtbf'];
}

// QC 
$quc = qcN();
foreach($quc as $c){
  $qc =  $c['timeQc'];
}

  // running 
$run = runningN();
foreach($run as $r){
  $qr =  $r['timeRun'];
}

// setup
$setup = setupN();
foreach($setup as $s){
  $qs =  $s['timeSet'];
}

// login on
$loginOn = loginOnN();
foreach($loginOn as $l){
  $ql =  $l['timeLogin'];
}

// idle
$idle = idleN();
foreach($idle as $i){
  $qi =  $i['timeIdle'];
}

// break 
$break = breakN();
foreach($break as $br1){
  $qbreak1 = $br1['timeBreak'];
}

// breakdown 
$breakdown = breakdownN();
foreach($breakdown as $breakdown){
  $qbreakdown = $breakdown['timeBreakdown'];
}

// Workpiece 
$workpiece = workpieceN();
foreach($workpiece as $w){
  $qpiece =  $w['timeWorkpiece'];
}  

// Tools 
$tools = toolsN();
foreach($tools as $t){
  $qtools =  $t['timeTools'];
}

$tmpEnergy = tmpEnergyN();
$dataEnergy = dataEnergyN();


// tmp utilisasi 
$tmp_util_grap = tmpUtilN();

// Utilisasi Idle
$data_idle_grap = idleUtilN();

// Utilisasi Running
$data_run_grap = runningUtilN();

// Utilisasi Workpiece
$data_work_grap = workpieceUtilN();

// Utilisasi Breakdown
$data_downtime_grap = downtimeUtilN();

// Utilisasi Tools
$data_tools_grap = toolsUtilN();

$bulanEnergyMonthlyConsumption = bulanEnergyMonthlyConsumptionN();
$dataEnergyMonthlyConsumption = dataEnergyMonthlyConsumptionN();


// table
$data_table = dataTableN();
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
    <!-- End plugin css for this page -->
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
      <!-- <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
          <a class="sidebar-brand brand-logo" href="../../index.html"><img src="../../assets/images/logo.svg" alt="logo" /></a>
          <a class="sidebar-brand brand-logo-mini" href="../../index.html"><img src="../../assets/images/logo-mini.svg" alt="logo" /></a>
        </div>
        <ul class="nav">
          <li class="nav-item profile">
            <div class="profile-desc">
              <div class="profile-pic">
                <div class="count-indicator">
                  <img class="img-xs rounded-circle " src="../../assets/images/faces/face15.jpg" alt="">
                  <span class="count bg-success"></span>
                </div>
                <div class="profile-name">
                  <h5 class="mb-0 font-weight-normal">Henry Klein</h5>
                  <span>Gold Member</span>
                </div>
              </div>
              <a href="#" id="profile-dropdown" data-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
              <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
                <a href="#" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-settings text-primary"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1 text-small">Account settings</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-onepassword  text-info"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1 text-small">Change Password</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-calendar-today text-success"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1 text-small">To-do list</p>
                  </div>
                </a>
              </div>
            </div>
          </li>
          <li class="nav-item nav-category">
            <span class="nav-link">Navigation</span>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="../../index.html">
              <span class="menu-icon">
                <i class="mdi mdi-speedometer"></i>
              </span>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-icon">
                <i class="mdi mdi-laptop"></i>
              </span>
              <span class="menu-title">Basic UI Elements</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="../../pages/ui-features/buttons.html">Buttons</a></li>
                <li class="nav-item"> <a class="nav-link" href="../../pages/ui-features/dropdowns.html">Dropdowns</a></li>
                <li class="nav-item"> <a class="nav-link" href="../../pages/ui-features/typography.html">Typography</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="../../pages/forms/basic_elements.html">
              <span class="menu-icon">
                <i class="mdi mdi-playlist-play"></i>
              </span>
              <span class="menu-title">Form Elements</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="../../pages/tables/basic-table.html">
              <span class="menu-icon">
                <i class="mdi mdi-table-large"></i>
              </span>
              <span class="menu-title">Tables</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="../../pages/charts/chartjs.html">
              <span class="menu-icon">
                <i class="mdi mdi-chart-bar"></i>
              </span>
              <span class="menu-title">Charts</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="../../pages/icons/mdi.html">
              <span class="menu-icon">
                <i class="mdi mdi-contacts"></i>
              </span>
              <span class="menu-title">Icons</span>
            </a>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
              <span class="menu-icon">
                <i class="mdi mdi-security"></i>
              </span>
              <span class="menu-title">User Pages</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/blank-page.html"> Blank Page </a></li>
                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/error-404.html"> 404 </a></li>
                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/error-500.html"> 500 </a></li>
                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/login.html"> Login </a></li>
                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/register.html"> Register </a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="http://www.bootstrapdash.com/demo/corona-free/jquery/documentation/documentation.html">
              <span class="menu-icon">
                <i class="mdi mdi-file-document-box"></i>
              </span>
              <span class="menu-title">Documentation</span>
            </a>
          </li>
        </ul>
      </nav> -->
      <?php
        if($_SESSION['username'] == 'planner'){
          include 'pages/sidebar/sidebar_planner.php'; 
        }else{
          include 'pages/sidebar/sidebar_all.php';
        } 
                
      ?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:../../partials/_navbar.html -->
        <?php include 'pages/navbar/navbar.php'; ?>
        <!-- <nav class="navbar p-0 fixed-top d-flex flex-row">
          <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
            <a class="navbar-brand brand-logo-mini" href="index.php"><img src="assets/images/logo-mini.svg" alt="logo" /></a>
          </div>
          <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
              <span class="mdi mdi-menu"></span>
            </button>
            <ul class="navbar-nav w-100">
              <li class="nav-item w-100">
                <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search">
                  <input type="text" class="form-control" placeholder="Search products">
                </form>
              </li>
            </ul>
            <ul class="navbar-nav navbar-nav-right">
              <li class="nav-item dropdown d-none d-lg-block">
                <a class="nav-link btn btn-success create-new-button" id="createbuttonDropdown" data-toggle="dropdown" aria-expanded="false" href="#">+ Create New Project</a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="createbuttonDropdown">
                  <h6 class="p-3 mb-0">Projects</h6>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-file-outline text-primary"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">Software Development</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-web text-info"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">UI Development</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-layers text-danger"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">Software Testing</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <p class="p-3 mb-0 text-center">See all projects</p>
                </div>
              </li>
              <li class="nav-item nav-settings d-none d-lg-block">
                <a class="nav-link" href="#">
                  <i class="mdi mdi-view-grid"></i>
                </a>
              </li>
              <li class="nav-item dropdown border-left">
                <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                  <i class="mdi mdi-email"></i>
                  <span class="count bg-success"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                  <h6 class="p-3 mb-0">Messages</h6>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <img src="assets/images/faces/face4.jpg" alt="image" class="rounded-circle profile-pic">
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">Mark send you a message</p>
                      <p class="text-muted mb-0"> 1 Minutes ago </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <img src="assets/images/faces/face2.jpg" alt="image" class="rounded-circle profile-pic">
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">Cregh send you a message</p>
                      <p class="text-muted mb-0"> 15 Minutes ago </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <img src="assets/images/faces/face3.jpg" alt="image" class="rounded-circle profile-pic">
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">Profile picture updated</p>
                      <p class="text-muted mb-0"> 18 Minutes ago </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <p class="p-3 mb-0 text-center">4 new messages</p>
                </div>
              </li>
              <li class="nav-item dropdown border-left">
                <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                  <i class="mdi mdi-bell"></i>
                  <span class="count bg-danger"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                  <h6 class="p-3 mb-0">Notifications</h6>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-calendar text-success"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Event today</p>
                      <p class="text-muted ellipsis mb-0"> Just a reminder that you have an event today </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-settings text-danger"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Settings</p>
                      <p class="text-muted ellipsis mb-0"> Update dashboard </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-link-variant text-warning"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Launch Admin</p>
                      <p class="text-muted ellipsis mb-0"> New admin wow! </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <p class="p-3 mb-0 text-center">See all notifications</p>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                  <div class="navbar-profile">
                    <img class="img-xs rounded-circle" src="assets/images/faces/face15.jpg" alt="">
                    <p class="mb-0 d-none d-sm-block navbar-profile-name">Henry Klein</p>
                    <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                  </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                  <h6 class="p-3 mb-0">Profile</h6>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-settings text-success"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Settings</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-logout text-danger"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Log out</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <p class="p-3 mb-0 text-center">Advanced settings</p>
                </div>
              </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
              <span class="mdi mdi-format-line-spacing"></span>
            </button>
          </div>
        </nav> -->
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> History </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">History</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Lathe</li>
                </ol>
              </nav>
            </div>
            <?php include 'pages/card/card.php'; ?>
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <form class="row g-3" action="" method="GET">
                        <div class="col-auto">    
                            <input type="date" name="date1" class="form-control" id="inputPassword2" placeholder="Password">
                        </div>
                        <div class="col-auto">    
                            <input type="date" name="date2" class="form-control" id="inputPassword2" placeholder="Password">
                        </div>
                        <div class="col-auto">
                            <button type="submit" name="dateSearch" class="btn btn-primary mb-3">Submit</button>
                        </div>
                    </form>
                  </div>
                </div>
              </div>  
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Total Time Status</h4>
                    
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Status</th>
                            <th>Total Time</th>
                            <th>Status</th>
                            <th>Total Time</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>Power On</td>
                            <td><label class="badge badge-warning"><?= $qp; ?></label></td>
                            <td>Break Time</td>
                            <td><label class="badge badge-warning"><?= $qbreak1; ?></label></td>
                          </tr>
                          <tr>
                            <td>MTBF</td>
                            <td><label class="badge badge-warning"><?= $qm; ?></label></td>
                            <td>QC Time</td>
                            <td><label class="badge badge-warning"><?= $qc; ?></label></td>
                          </tr>
                          <tr>
                            <td>Idle Time</td>
                            <td><label class="badge badge-warning"><?= $qi; ?></label></td>
                            <td>Breakdown Time</td>
                            <td><label class="badge badge-warning"><?= $qbreakdown; ?></label></td>
                          </tr>
                          <tr>
                            <td>Setup Time</td>
                            <td><label class="badge badge-warning"><?= $qs; ?></label></td>
                            <td>Down Time</td>
                            <td><label class="badge badge-warning"><?= $qbreakdown; ?></label></td>
                          </tr>
                          <tr>
                            <td>Login On Time</td>
                            <td><label class="badge badge-warning"><?= $ql; ?></label></td>
                            <td>Running Time</td>
                            <td><label class="badge badge-warning"><?= $qr; ?></label></td>
                          </tr>
                          <tr>
                            <td>Workpiece Status</td>
                            <td><label class="badge badge-warning"><?= $qpiece; ?></label></td>
                            <td>Tools Setup</td>
                            <td><label class="badge badge-warning"><?= $qtools; ?></label></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <!-- <div class="col-lg-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Presentase Status Time</h4>
                    <div id="weeklyConsumption"></div> -->
                    <!-- <p class="card-description"> Add class <code>.table</code>
                    </p>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Status</th>
                            <th>Total Time</th>
                            <th>Status</th>
                            <th>Total Time</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>Power On Time</td>
                            <td><label class="badge badge-danger">Pending</label></td>
                            <td>Break Time</td>
                            <td><label class="badge badge-danger">Pending</label></td>
                          </tr>
                          <tr>
                            <td>MTBF</td>
                            <td><label class="badge badge-danger">Pending</label></td>
                            <td>QC Time</td>
                            <td><label class="badge badge-warning">In progress</label></td>
                          </tr>
                          <tr>
                            <td>Idle Time</td>
                            <td><label class="badge badge-danger">Pending</label></td>
                            <td>Breakdown Time</td>
                            <td><label class="badge badge-info">Fixed</label></td>
                          </tr>
                          <tr>
                            <td>Setup Time</td>
                            <td><label class="badge badge-danger">Pending</label></td>
                            <td>Down Time</td>
                            <td><label class="badge badge-success">Completed</label></td>
                          </tr>
                          <tr>
                            <td>Login On Time</td>
                            <td><label class="badge badge-danger">40:00:00</label></td>
                            <td>Good Product</td>
                            <td><label class="badge badge-warning">In progress</label></td>
                          </tr>
                          <tr>
                            <td>Running Time</td>
                            <td><label class="badge badge-danger">40:00:00</label></td>
                            <td>Reject Product</td>
                            <td><label class="badge badge-warning">In progress</label></td>
                          </tr>
                          <tr>
                            <td>Workpiece Status</td>
                            <td><label class="badge badge-danger">40:00:00</label></td>
                            <td>Tools Setup</td>
                            <td><label class="badge badge-warning">In progress</label></td>
                          </tr>
                        </tbody>
                      </table>
                    </div> -->
                  <!-- </div>
                </div>
              </div> -->
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Utilization</h4>
                    <div id="utilizationHistory"></div>
                  </div>
                </div>
              </div>
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Power Energy</h4>
                    <div id="energy"></div>
                  </div>
                </div>
              </div>
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Details Table</h4>
                    <div class="table-responsive">
                    <table class="table">
                        <thead>
                          <tr>
                            <!-- <th>
                              <div class="form-check form-check-muted m-0">
                                <label class="form-check-label">
                                  <input type="checkbox" class="form-check-input">
                                </label>
                              </div>
                            </th> -->
                            <!-- <th> No </th> -->
                            <th> Date </th>
                            <th> Machine Name </th>
                            <th> Work Order </th>
                            <th> Job Id </th>
                            <th> Operator Id </th>
                            <th> Start Date </th>
                            <th> Standard Time </th>
                            <th> Status </th>
                          </tr>
                        </thead>
                        <?php
                        // $no = 1;
                        while($d = mysqli_fetch_array($data_table)){
                                            ?>
                                            


                        <tbody>
                          <tr>
                            <!-- <td> <?= $no++ ?></td> -->
                            <td> <?= $d["tmp"]; ?></td>
                            <td> <?= $d["machine_id"]; ?></td>
                            <td> <?= $d["work_identity"]; ?></td>
                            <td> <?= $d["job_id"]; ?></td>
                            <td> <?= $d["operator_id"]; ?></td>
                            <td> <?= $d["start_date"]; ?></td>
                            <td> <?= $d["standard_time"]; ?></td>
                            <td>
                            <?php if ($d["status"] == 'Pending'): ?>
                                <!-- Jika kondisi pertama terpenuhi -->
                                <div class="badge badge-outline-danger"><?= $d["status"]; ?></div>
                            <?php elseif ($d["status"] == 'Confirmed'): ?>
                                <!-- Jika kondisi kedua terpenuhi -->
                                <div class="badge badge-outline-warning"><?= $d["status"]; ?></div>
                            <?php elseif ($d["status"] == 'Finish'): ?>
                                <!-- Jika kondisi ketiga terpenuhi -->
                                <div class="badge badge-outline-success"><?= $d["status"]; ?></div>
                            <?php else: ?>
                                <!-- Jika tidak ada kondisi yang terpenuhi -->
                                <div class="badge badge-outline-info"><?= $d["status"]; ?></div>
                            <?php endif; ?>

                            
                    
                            </td>
                          </tr>
                          
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
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
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <!-- End custom js for this page -->
    <!-- <script src="assets/js/chart-new.js"></script> -->
    <script>



// Weekly Consumption
// var options = {
//   series: [
//     <?php
//     $resF1 = $data_run_pres->num_rows;
//     echo $resF1;
//     ?>,
//     <?php
//     $resF2 = $data_idle_pres->num_rows;
//     echo $resF2;
//     ?>,
//     <?php
//     $resF3 = $data_breakdown_pres->num_rows;
//     echo $resF3;
//     ?>



//   ],
//   chart: {
//   width: '100%',
//   type: 'pie',
// },
// labels: ["Running", "Idle", "Breakdown"],
// theme: {
//   monochrome: {
//     enabled: true
//   }
// },
// plotOptions: {
//   pie: {
//     dataLabels: {
//       offset: -5
//     },
//     colors: ['#007bff', '#28a745', '#dc3545'] // Ubah warna data series menjadi biru, hijau, dan merah
//   }
// },

// dataLabels: {
//   formatter(val, opts) {
//     const name = opts.w.globals.labels[opts.seriesIndex]
//     return [name, val.toFixed(1) + '%']
//   }
// },
// legend: {
//   show: false
// },

// };
// var chart = new ApexCharts(document.querySelector("#weeklyConsumption"), options);
// chart.render();
// end consumption


// chart utilizasi
var options = {
  series: [{
  name: 'Idle',
  data: [<?php while ($ui = mysqli_fetch_assoc($data_idle_grap)) { echo '"' . $ui['konversi_idle'] . '",';}?>]
}, {
  name: 'Running',
  data: [<?php while ($ur = mysqli_fetch_assoc($data_run_grap)) { echo '"' . $ur['konversi_running'] . '",';}?>]
}, {
  name: 'Workpiece',
  data: [<?php while ($uw = mysqli_fetch_assoc($data_work_grap)) { echo '"' . $uw['konversi_work'] . '",';}?>]
}, {
  name: 'Breakdown',
  data: [<?php while ($ub = mysqli_fetch_assoc($data_downtime_grap)) { echo '"' . $ub['konversi_downtime'] . '",';}?>]
}, {
  name: 'Tools',
  data: [<?php while ($ut = mysqli_fetch_assoc($data_tools_grap)) { echo '"' . $ut['konversi_tools'] . '",';}?>]
}],
  chart: {
  type: 'bar',
  height: 350,
  stacked: true,
  stackType: '100%'
},
plotOptions: {
  bar: {
    horizontal: true,
  },
},
stroke: {
  width: 1,
  colors: ['#fff']
},
xaxis: {
  categories: [<?php while ($ccc = mysqli_fetch_assoc($tmp_util_grap)) { echo '"' . $ccc['time_new'] . '",';}?>],
  labels: {
    style: {
      colors: '#ffffff', // ganti dengan warna yang diinginkan
    }
  }
},
yaxis: {
labels: {
  style: {
    colors: '#ffffff', // ganti dengan warna yang diinginkan
  }
}
},
fill: {
  opacity: 1
},
legend: {
  position: 'top',
  horizontalAlign: 'left',
  offsetX: 90
},
tooltip: {
    theme: 'dark',
    style: {
      fontSize: '12px',
      background: '#FF0000', // ganti dengan warna yang diinginkan
    }
}
};
var chart = new ApexCharts(document.querySelector("#utilizationHistory"), options);
chart.render();
//   end chart utilisasi


// energy
var options = {
  series: [{
  name: 'Energy',
  data: [<?php while ($e1 = mysqli_fetch_assoc($dataEnergy)) { echo '"' . $e1['wpp'] . '",';}?>]
}],
  chart: {
  height: 350,
  type: 'area'
},
dataLabels: {
  enabled: false
},
stroke: {
  curve: 'smooth'
},
xaxis: {
  type: 'datetime',
  categories: [<?php while ($e2 = mysqli_fetch_assoc($tmpEnergy)) { echo '"' . $e2['tmp'] . '",';}?>],
  labels: {
      style: {
        colors: '#ffffff', // ganti dengan warna yang diinginkan
      }
    },
  reverse: true
},
yaxis: {
  labels: {
    style: {
      colors: '#ffffff', // ganti dengan warna yang diinginkan
    }
  }
},
tooltip: {
  x: {
    format: 'dd/MM/yy HH:mm'
  },
  theme: 'dark',
    style: {
      fontSize: '12px',
      background: '#FF0000', // ganti dengan warna yang diinginkan
  }
},
};
var chart = new ApexCharts(document.querySelector("#energy"), options);
chart.render();
// end energy
    </script>
  </body>
</html>