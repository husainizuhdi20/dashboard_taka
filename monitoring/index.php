<?php
session_start();
require 'function.php';
if( !isset($_SESSION["login"])) {
  header("Location: login.php");
}

// Cek apakah session mesin sudah di-set
if (!isset($_SESSION['mesin'])) {
	// Jika belum, redirect ke halaman mesin option
	header("Location: machine_option.php");
	exit();
}

if(isset($_POST["logout"])) {
  session_destroy();
  header("Location : login.php");
  exit;
}

// tmp utilisasi 
$tmp_util_grap = tmpUtilDash();
// Utilisasi Idle
$data_idle_grap = idleUtilDash();
// Utilisasi Running
$data_run_grap = runningUtilDash();
// Utilisasi Workpiece
$data_work_grap = workpieceUtilDash();
// Utilisasi Breakdown
$data_downtime_grap = downtimeUtilDash();
// Utilisasi Tools
$data_tools_grap = toolsUtilDash();
$data_table = dataTableDash();
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
            <?php include 'pages/card/card.php'; ?>
            <div class="row">
              <!-- <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Job Progress</h4>
                    <div id="allActual" class="transaction-chart"></div>
                    <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                      <div class="text-md-center text-xl-left">
                        <h6 class="mb-1">Presentase Job Progress</h6>
                         <p class="text-muted mb-0">07 Jan 2019, 09:12AM</p> 
                      </div>
                      <div class="align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">Details</button>
                      </div>
                      
                      <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                              <form id="form">
                                  <label for="duration">Duration (in seconds):</label>
                                 
                                  <br>
                                  <input type="submit" value="Submit" id="submit">
                                  <input type="button" value="Stop" id="stop" disabled>
                                  <input type="button" value="Finish" id="finish" disabled>
                              </form>
                              <div id="progress-bar"></div>
                              <div id="timer"></div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Understood</button>
                          </div>
                        </div>
                      </div>
</div> -->



    

    <!-- <script>
      const form = document.getElementById('form');
    const progressBar = document.getElementById('progress-bar');
    const timer = document.getElementById('timer');
    const submitButton = document.getElementById('submit');
    const stopButton = document.getElementById('stop');
    const finishButton = document.getElementById('finish');

    let intervalId;
    let timeElapsed = 0;
    let totalTime = 0;
    let progressStoped = false;

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        totalTime = 5; //waktu yang dimasukkan dalam sekon
        startProgress();
    });

    function startProgress() {
        progressBar.style.backgroundColor = 'yellow';
        intervalId = setTimeout(updateProgress, 100);
        submitButton.disabled = true;
        stopButton.disabled = false;
        finishButton.disabled = false;
    }

    function stopProgress() {
        clearInterval(intervalId);
        if (timeElapsed >= totalTime) {
            progressBar.style.backgroundColor = 'red';
        } else {
            progressBar.style.backgroundColor = 'green';
        }
        submitButton.disabled = false;
        stopButton.disabled = true;
        finishButton.disabled = false;
        progressStoped = false;
    }

    function updateProgress() {
        timeElapsed += 0.1;
        const progress = timeElapsed / totalTime * 100;
        progressBar.style.width = ${progress}%;

        if (timeElapsed >= totalTime) {
            progressBar.style.backgroundColor = 'red';
            
        } else {
            intervalId = setTimeout(updateProgress, 100);
        }
        timer.innerHTML = ${timeElapsed.toFixed(1)} seconds;
    }

    stopButton.addEventListener('click', stopProgress);

    finishButton.addEventListener('click', () => {
        finishButton.disabled = false;
        timer.innerHTML = Elapsed time: ${timeElapsed.toFixed(1)} seconds;
        if (progressStoped) {
            submitButton.disabled = false;
        }
    });
            
    </script> -->
                      <!-- <div class="align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0">
                        <button class="btn btn-primary" data-toggle="modal" data-target=#modalProgress">Details</button>
                      </div> -->
                      <!-- Modal -->
                      <!-- <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content bg-light text-dark">
                              <div class="modal-header">
                                  <h5 class="modal-title" id="myModalLabel">Job Progress</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                              </div>
                              <div class="modal-body">
                              <div id="jobProgress" class="transaction-chart"></div>
                              </div>
                              <div class="modal-footer">
                                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                              </div>
                            </div>
                        </div>
                      </div> -->



                    <!-- </div> -->
                    <!-- <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                      <div class="text-md-center text-xl-left">
                        <h6 class="mb-1">Tranfer to Stripe</h6>
                        <p class="text-muted mb-0">07 Jan 2019, 09:12AM</p>
                      </div>
                      <div class="align-self-center flex-grow text-right text-md-center text-xl-right py-md-2 py-xl-0">
                        <h6 class="font-weight-bold mb-0">$593</h6>
                      </div>
                    </div> -->
                    
                  <!-- </div>
                </div>
              </div> -->
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex flex-row justify-content-between">
                      <h4 class="card-title mb-1">Utilization</h4>
                      <p class="text-muted mb-1">Your data status</p>
                    </div>
                    <!-- <div class="row">
                      <div class="col-12">
                        <div class="preview-list">
                          <div class="preview-item border-bottom">
                            <div class="preview-thumbnail">
                              <div class="preview-icon bg-primary">
                                <i class="mdi mdi-file-document"></i>
                              </div>
                            </div>
                            <div class="preview-item-content d-sm-flex flex-grow">
                              <div class="flex-grow">
                                <h6 class="preview-subject">Admin dashboard design</h6>
                                <p class="text-muted mb-0">Broadcast web app mockup</p>
                              </div>
                              <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                <p class="text-muted">15 minutes ago</p>
                                <p class="text-muted mb-0">30 tasks, 5 issues </p>
                              </div>
                            </div>
                          </div>
                          <div class="preview-item border-bottom">
                            <div class="preview-thumbnail">
                              <div class="preview-icon bg-success">
                                <i class="mdi mdi-cloud-download"></i>
                              </div>
                            </div>
                            <div class="preview-item-content d-sm-flex flex-grow">
                              <div class="flex-grow">
                                <h6 class="preview-subject">Wordpress Development</h6>
                                <p class="text-muted mb-0">Upload new design</p>
                              </div>
                              <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                <p class="text-muted">1 hour ago</p>
                                <p class="text-muted mb-0">23 tasks, 5 issues </p>
                              </div>
                            </div>
                          </div>
                          <div class="preview-item border-bottom">
                            <div class="preview-thumbnail">
                              <div class="preview-icon bg-info">
                                <i class="mdi mdi-clock"></i>
                              </div>
                            </div>
                            <div class="preview-item-content d-sm-flex flex-grow">
                              <div class="flex-grow">
                                <h6 class="preview-subject">Project meeting</h6>
                                <p class="text-muted mb-0">New project discussion</p>
                              </div>
                              <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                <p class="text-muted">35 minutes ago</p>
                                <p class="text-muted mb-0">15 tasks, 2 issues</p>
                              </div>
                            </div>
                          </div>
                          <div class="preview-item border-bottom">
                            <div class="preview-thumbnail">
                              <div class="preview-icon bg-danger">
                                <i class="mdi mdi-email-open"></i>
                              </div>
                            </div>
                            <div class="preview-item-content d-sm-flex flex-grow">
                              <div class="flex-grow">
                                <h6 class="preview-subject">Broadcast Mail</h6>
                                <p class="text-muted mb-0">Sent release details to team</p>
                              </div>
                              <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                <p class="text-muted">55 minutes ago</p>
                                <p class="text-muted mb-0">35 tasks, 7 issues </p>
                              </div>
                            </div>
                          </div>
                          <div class="preview-item">
                            <div class="preview-thumbnail">
                              <div class="preview-icon bg-warning">
                                <i class="mdi mdi-chart-pie"></i>
                              </div>
                            </div>
                            <div class="preview-item-content d-sm-flex flex-grow">
                              <div class="flex-grow">
                                <h6 class="preview-subject">UI Design</h6>
                                <p class="text-muted mb-0">New application planning</p>
                              </div>
                              <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                <p class="text-muted">50 minutes ago</p>
                                <p class="text-muted mb-0">27 tasks, 4 issues </p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div> -->
                    <div id="machineUtilizationDaily" ></div>
                  </div>
                </div>
              </div>
            </div>
            <!-- <div class="row">
              <div class="col-sm-4 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h5>Revenue</h5>
                    <div class="row">
                      <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                          <h2 class="mb-0">$32123</h2>
                          <p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p>
                        </div>
                        <h6 class="text-muted font-weight-normal">11.38% Since last month</h6>
                      </div>
                      <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                        <i class="icon-lg mdi mdi-codepen text-primary ml-auto"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-4 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h5>Sales</h5>
                    <div class="row">
                      <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                          <h2 class="mb-0">$45850</h2>
                          <p class="text-success ml-2 mb-0 font-weight-medium">+8.3%</p>
                        </div>
                        <h6 class="text-muted font-weight-normal"> 9.61% Since last month</h6>
                      </div>
                      <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                        <i class="icon-lg mdi mdi-wallet-travel text-danger ml-auto"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-4 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h5>Purchase</h5>
                    <div class="row">
                      <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                          <h2 class="mb-0">$2039</h2>
                          <p class="text-danger ml-2 mb-0 font-weight-medium">-2.1% </p>
                        </div>
                        <h6 class="text-muted font-weight-normal">2.27% Since last month</h6>
                      </div>
                      <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                        <i class="icon-lg mdi mdi-monitor text-success ml-auto"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div> -->
            <div class="row ">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Job Table</h4>
                    <div class="table-responsive">
                      <!-- <table class="table">
                        <thead>
                          <tr>
                            <th>
                              <div class="form-check form-check-muted m-0">
                                <label class="form-check-label">
                                  <input type="checkbox" class="form-check-input">
                                </label>
                              </div>
                            </th>
                            <th> No </th>
                            <th> Tanggal </th>
                            <th> Operator Id </th>
                            <th> Work Order </th>
                            <th> Job Name </th>
                            <th> Standart Time </th>
                            <th> Job Time </th>
                            <th> Status </th>
                            
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>
                              <div class="form-check form-check-muted m-0">
                                <label class="form-check-label">
                                  <input type="checkbox" class="form-check-input">
                                </label>
                              </div>
                            </td>
                            <td> 
                              <img src="assets/images/faces/face1.jpg" alt="image" />
                              <span class="pl-2">Henry Klein</span>
                            </td>
                            <td> 02312 </td>
                            <td> $14,500 </td>
                            <td> Dashboard </td>
                            <td> Credit card </td>
                            <td> 04 Dec 2019 </td>
                            <td>
                              <div class="badge badge-outline-success">Approved</div>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <div class="form-check form-check-muted m-0">
                                <label class="form-check-label">
                                  <input type="checkbox" class="form-check-input">
                                </label>
                              </div>
                            </td>
                            <td>
                              <img src="assets/images/faces/face2.jpg" alt="image" />
                              <span class="pl-2">Estella Bryan</span>
                            </td>
                            <td> 02312 </td>
                            <td> $14,500 </td>
                            <td> Website </td>
                            <td> Cash on delivered </td>
                            <td> 04 Dec 2019 </td>
                            <td>
                              <div class="badge badge-outline-warning">Pending</div>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <div class="form-check form-check-muted m-0">
                                <label class="form-check-label">
                                  <input type="checkbox" class="form-check-input">
                                </label>
                              </div>
                            </td>
                            <td>
                              <img src="assets/images/faces/face5.jpg" alt="image" />
                              <span class="pl-2">Lucy Abbott</span>
                            </td>
                            <td> 02312 </td>
                            <td> $14,500 </td>
                            <td> App design </td>
                            <td> Credit card </td>
                            <td> 04 Dec 2019 </td>
                            <td>
                              <div class="badge badge-outline-danger">Rejected</div>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <div class="form-check form-check-muted m-0">
                                <label class="form-check-label">
                                  <input type="checkbox" class="form-check-input">
                                </label>
                              </div>
                            </td>
                            <td>
                              <img src="assets/images/faces/face3.jpg" alt="image" />
                              <span class="pl-2">Peter Gill</span>
                            </td>
                            <td> 02312 </td>
                            <td> $14,500 </td>
                            <td> Development </td>
                            <td> Online Payment </td>
                            <td> 04 Dec 2019 </td>
                            <td>
                              <div class="badge badge-outline-success">Approved</div>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <div class="form-check form-check-muted m-0">
                                <label class="form-check-label">
                                  <input type="checkbox" class="form-check-input">
                                </label>
                              </div>
                            </td>
                            <td>
                              <img src="assets/images/faces/face4.jpg" alt="image" />
                              <span class="pl-2">Sallie Reyes</span>
                            </td>
                            <td> 02312 </td>
                            <td> $14,500 </td>
                            <td> Website </td>
                            <td> Credit card </td>
                            <td> 04 Dec 2019 </td>
                            <td>
                              <div class="badge badge-outline-success">Approved</div>
                            </td>
                          </tr>
                        </tbody>
                      </table> -->
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
            <!-- <div class="row">
              <div class="col-md-6 col-xl-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex flex-row justify-content-between">
                      <h4 class="card-title">Messages</h4>
                      <p class="text-muted mb-1 small">View all</p>
                    </div>
                    <div class="preview-list">
                      <div class="preview-item border-bottom">
                        <div class="preview-thumbnail">
                          <img src="assets/images/faces/face6.jpg" alt="image" class="rounded-circle" />
                        </div>
                        <div class="preview-item-content d-flex flex-grow">
                          <div class="flex-grow">
                            <div class="d-flex d-md-block d-xl-flex justify-content-between">
                              <h6 class="preview-subject">Leonard</h6>
                              <p class="text-muted text-small">5 minutes ago</p>
                            </div>
                            <p class="text-muted">Well, it seems to be working now.</p>
                          </div>
                        </div>
                      </div>
                      <div class="preview-item border-bottom">
                        <div class="preview-thumbnail">
                          <img src="assets/images/faces/face8.jpg" alt="image" class="rounded-circle" />
                        </div>
                        <div class="preview-item-content d-flex flex-grow">
                          <div class="flex-grow">
                            <div class="d-flex d-md-block d-xl-flex justify-content-between">
                              <h6 class="preview-subject">Luella Mills</h6>
                              <p class="text-muted text-small">10 Minutes Ago</p>
                            </div>
                            <p class="text-muted">Well, it seems to be working now.</p>
                          </div>
                        </div>
                      </div>
                      <div class="preview-item border-bottom">
                        <div class="preview-thumbnail">
                          <img src="assets/images/faces/face9.jpg" alt="image" class="rounded-circle" />
                        </div>
                        <div class="preview-item-content d-flex flex-grow">
                          <div class="flex-grow">
                            <div class="d-flex d-md-block d-xl-flex justify-content-between">
                              <h6 class="preview-subject">Ethel Kelly</h6>
                              <p class="text-muted text-small">2 Hours Ago</p>
                            </div>
                            <p class="text-muted">Please review the tickets</p>
                          </div>
                        </div>
                      </div>
                      <div class="preview-item border-bottom">
                        <div class="preview-thumbnail">
                          <img src="assets/images/faces/face11.jpg" alt="image" class="rounded-circle" />
                        </div>
                        <div class="preview-item-content d-flex flex-grow">
                          <div class="flex-grow">
                            <div class="d-flex d-md-block d-xl-flex justify-content-between">
                              <h6 class="preview-subject">Herman May</h6>
                              <p class="text-muted text-small">4 Hours Ago</p>
                            </div>
                            <p class="text-muted">Thanks a lot. It was easy to fix it .</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-xl-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Portfolio Slide</h4>
                    <div class="owl-carousel owl-theme full-width owl-carousel-dash portfolio-carousel" id="owl-carousel-basic">
                      <div class="item">
                        <img src="assets/images/dashboard/Rectangle.jpg" alt="">
                      </div>
                      <div class="item">
                        <img src="assets/images/dashboard/Img_5.jpg" alt="">
                      </div>
                      <div class="item">
                        <img src="assets/images/dashboard/img_6.jpg" alt="">
                      </div>
                    </div>
                    <div class="d-flex py-4">
                      <div class="preview-list w-100">
                        <div class="preview-item p-0">
                          <div class="preview-thumbnail">
                            <img src="assets/images/faces/face12.jpg" class="rounded-circle" alt="">
                          </div>
                          <div class="preview-item-content d-flex flex-grow">
                            <div class="flex-grow">
                              <div class="d-flex d-md-block d-xl-flex justify-content-between">
                                <h6 class="preview-subject">CeeCee Bass</h6>
                                <p class="text-muted text-small">4 Hours Ago</p>
                              </div>
                              <p class="text-muted">Well, it seems to be working now.</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <p class="text-muted">Well, it seems to be working now. </p>
                    <div class="progress progress-md portfolio-progress">
                      <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-12 col-xl-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">To do list</h4>
                    <div class="add-items d-flex">
                      <input type="text" class="form-control todo-list-input" placeholder="enter task..">
                      <button class="add btn btn-primary todo-list-add-btn">Add</button>
                    </div>
                    <div class="list-wrapper">
                      <ul class="d-flex flex-column-reverse text-white todo-list todo-list-custom">
                        <li>
                          <div class="form-check form-check-primary">
                            <label class="form-check-label">
                              <input class="checkbox" type="checkbox"> Create invoice </label>
                          </div>
                          <i class="remove mdi mdi-close-box"></i>
                        </li>
                        <li>
                          <div class="form-check form-check-primary">
                            <label class="form-check-label">
                              <input class="checkbox" type="checkbox"> Meeting with Alita </label>
                          </div>
                          <i class="remove mdi mdi-close-box"></i>
                        </li>
                        <li class="completed">
                          <div class="form-check form-check-primary">
                            <label class="form-check-label">
                              <input class="checkbox" type="checkbox" checked> Prepare for presentation </label>
                          </div>
                          <i class="remove mdi mdi-close-box"></i>
                        </li>
                        <li>
                          <div class="form-check form-check-primary">
                            <label class="form-check-label">
                              <input class="checkbox" type="checkbox"> Plan weekend outing </label>
                          </div>
                          <i class="remove mdi mdi-close-box"></i>
                        </li>
                        <li>
                          <div class="form-check form-check-primary">
                            <label class="form-check-label">
                              <input class="checkbox" type="checkbox"> Pick up kids from school </label>
                          </div>
                          <i class="remove mdi mdi-close-box"></i>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Visitors by Countries</h4>
                    <div class="row">
                      <div class="col-md-5">
                        <div class="table-responsive">
                          <table class="table">
                            <tbody>
                              <tr>
                                <td>
                                  <i class="flag-icon flag-icon-us"></i>
                                </td>
                                <td>USA</td>
                                <td class="text-right"> 1500 </td>
                                <td class="text-right font-weight-medium"> 56.35% </td>
                              </tr>
                              <tr>
                                <td>
                                  <i class="flag-icon flag-icon-de"></i>
                                </td>
                                <td>Germany</td>
                                <td class="text-right"> 800 </td>
                                <td class="text-right font-weight-medium"> 33.25% </td>
                              </tr>
                              <tr>
                                <td>
                                  <i class="flag-icon flag-icon-au"></i>
                                </td>
                                <td>Australia</td>
                                <td class="text-right"> 760 </td>
                                <td class="text-right font-weight-medium"> 15.45% </td>
                              </tr>
                              <tr>
                                <td>
                                  <i class="flag-icon flag-icon-gb"></i>
                                </td>
                                <td>United Kingdom</td>
                                <td class="text-right"> 450 </td>
                                <td class="text-right font-weight-medium"> 25.00% </td>
                              </tr>
                              <tr>
                                <td>
                                  <i class="flag-icon flag-icon-ro"></i>
                                </td>
                                <td>Romania</td>
                                <td class="text-right"> 620 </td>
                                <td class="text-right font-weight-medium"> 10.25% </td>
                              </tr>
                              <tr>
                                <td>
                                  <i class="flag-icon flag-icon-br"></i>
                                </td>
                                <td>Brasil</td>
                                <td class="text-right"> 230 </td>
                                <td class="text-right font-weight-medium"> 75.00% </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <div class="col-md-7">
                        <div id="audience-map" class="vector-map"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div> -->
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


    <script>
    // all progress



    var options = {
          series: [50],
          chart: {
          type: 'radialBar',
          offsetY: -20,
          sparkline: {
            enabled: true
          }
        },
        plotOptions: {
          radialBar: {
            startAngle: -90,
            endAngle: 90,
            track: {
              background: "#e7e7e7",
              strokeWidth: '97%',
              margin: 5, // margin is in pixels
              dropShadow: {
                enabled: true,
                top: 2,
                left: 0,
                color: '#999',
                opacity: 1,
                blur: 2
              }
            },
            dataLabels: {
              name: {
                show: false
              },
              value: {
                offsetY: -2,
                fontSize: '22px'
              }
            }
          }
        },
        grid: {
          padding: {
            top: -10
          }
        },
        fill: {
          type: 'gradient',
          gradient: {
            shade: 'light',
            shadeIntensity: 0.4,
            inverseColors: false,
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 50, 53, 91]
          },
        },
        labels: ['Average Results'],
        };

        var chart = new ApexCharts(document.querySelector("#allActual"), options);
        chart.render();



        
    // var options = {
    //   chart: {
    //     height: 280,
    //     type: "radialBar",
    //   },
    
    //   series: [90],
    //   colors: ["#20E647"],
    //   plotOptions: {
    //     radialBar: {
    //       hollow: {
    //         margin: 0,
    //         size: "70%",
    //         background: "#293450"
    //       },
    //       track: {
    //         dropShadow: {
    //           enabled: true,
    //           top: 2,
    //           left: 0,
    //           blur: 4,
    //           opacity: 0.15
    //         }
    //       },
    //       dataLabels: {
    //         name: {
    //           offsetY: -10,
    //           color: "#fff",
    //           fontSize: "13px"
    //         },
    //         value: {
    //           color: "#fff",
    //           fontSize: "30px",
    //           show: true
    //         }
    //       }
    //     }
    //   },
    //   fill: {
    //     type: "gradient",
    //     gradient: {
    //       shade: "dark",
    //       type: "vertical",
    //       gradientToColors: ["#87D4F9"],
    //       stops: [0, 100]
    //     }
    //   },
    //   stroke: {
    //     lineCap: "round"
    //   },
    //   labels: ["Progress"]
    // };
    // var chart = new ApexCharts(document.querySelector("#allActual"), options);
    // chart.render(); 
// end all progress


// chart utilizasi
var options = {
    series: [{
    name: 'Idle',
    data: [<?php while ($ui = mysqli_fetch_assoc($data_idle_grap)) { echo '"' . $ui['konversi_idle'] . '",';}?>]
  }, {
    name: 'Running',
    data: [<?php while ($ur = mysqli_fetch_assoc($data_run_grap)) { echo '"' . $ur['konversi_run'] . '",';}?>]
  }, {
    name: 'Workpiece',
    data: [<?php while ($uw = mysqli_fetch_assoc($data_work_grap)) { echo '"' . $uw['konversi_work'] . '",';}?>]
  }, {
    name: 'Downtime',
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
  var chart = new ApexCharts(document.querySelector("#machineUtilizationDaily"), options);
  chart.render();

//   end chart utilisasi

// grafik progress time
var options = {
  series: [{
    data: [0]
  }],
  chart: {
    height: 350,
    type: 'bar'
  },
  plotOptions: {
    bar: {
      horizontal: true,
      barHeight: '40%',
      dataLabels: {
        position: 'bottom'
      }
    }
  },
  dataLabels: {
    enabled: true,
    formatter: function (val) {
      return val + "%";
    },
    offsetY: 20,
    style: {
      fontSize: '20px',
      colors: ['#304758']
    }
  },
  xaxis: {
    categories: ['Progress'],
    tickAmount: 1
  },
  yaxis: {
    min: 0,
    max: 100
  }
};
var chart = new ApexCharts(document.querySelector("#jobProgress"), options);
chart.render();
var currentProgress = 0;
var durationInSeconds = 60;
var interval = setInterval(function() {
  currentProgress++;
  if (currentProgress > 100) {
    clearInterval(interval);
  }
  chart.updateSeries([{    data: [currentProgress]
  }]);
  if (currentProgress === 100) {
    setTimeout(function() {
      chart.updateSeries([{        data: [0]
      }]);
      currentProgress = 0;
    }, durationInSeconds * 1000);
  }
}, durationInSeconds * 10);

// end progress time

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
  </body>
</html>