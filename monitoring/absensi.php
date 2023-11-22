<?php
session_start();
if( !isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;

}

require 'function.php';

if(isset($_POST['submitAbsen']) ) {
  
  if(absen($_POST) > 0) {
    echo "<script>
      Swal.fire({title: 'Tambah Data Berhasil',text: '',icon: 'success',confirmButtonText: 'OK'
      }).then((result) => {if (result.value){
          window.location = 'job-planning.php';
          }
      })</script>";
    }else{
      echo "<script>
      Swal.fire({title: 'Tambah Data Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
      }).then((result) => {if (result.value){
          window.location = 'job-planning.php';
          }
      })</script>";
  }
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
    <link rel="stylesheet" href="assets/vendors/select2/select2.min.css">
    <link rel="stylesheet" href="assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:../../partials/_sidebar.html -->
      <?php include 'pages/sidebar/sidebar.php'; ?>
      <div class="container-fluid page-body-wrapper">
        <!-- partial:../../partials/_navbar.html -->
        <?php include 'pages/navbar/navbar.php'; ?>
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">Presensi</h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Presensi</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Lathe</li>
                </ol>
              </nav>
            </div>
            <div class="row">
              <div class="col-md-10 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Absent</h4>
                    <!-- <p class="card-description"> Basic form layout </p> -->
                    <form class="forms-sample" action="" method="POST">
                      <div class="form-group">
                        <label>Employee Name</label>
                        <select class="form-control text-white" name="op_name" style="width:100%">
                          <option >Aksa</option>  
                          <option >Wilmar</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Position</label>
                        <select class="form-control text-white" name="position" style="width:100%">
                          <option >Supervisor</option>  
                          <option >Operator</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Machine Name</label>
                        <select class="form-control text-white" name="machine_id" style="width:100%">
                          <option >Lathe</option>  
                          <option >Honing</option>
                          <option >Milling</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Time</label>
                        <input type="date" class="form-control" name="time" id="exampleInputEmail1" placeholder="Input Workorder" autocomplete="off">
                      </div>     
                      <button type="submit" name="submitAbsen" class="btn btn-primary mr-2">Submit</button>
                      <!-- <button type="button" onclick="addInput()" class="btn btn-dark">Add Job</button> -->
                    </form>
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
    <script src="assets/vendors/select2/select2.min.js"></script>
    <script src="assets/vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="assets/js/file-upload.js"></script>
    <script src="assets/js/typeahead.js"></script>
    <script src="assets/js/select2.js"></script>
    <!-- End custom js for this page -->

    <script>
      function addInput() {
      var inputCount = document.querySelectorAll('#form-inputs job_name').length;
      var newInput = document.createElement('Job_name');
      newInput.type = 'text';
      newInput.name = 'job_name' + (inputCount + 1);
      newInput.placeholder = 'Job_name ' + (inputCount + 1);
      document.getElementById('form-inputs').appendChild(newInput);
    }
    </script>
  </body>
</html>