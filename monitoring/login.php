<?php
session_start();
if(isset($_SESSION["login"])) {
  header("Location: dashboard.php");
  exit;
}

require 'function.php';
if(isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // cek username apakah username input ada di dalam database
  $result = mysqli_query($koneksi, "SELECT * FROM tb_login WHERE username = '$username'");

  // cek username
  if(mysqli_num_rows($result) === 1) {
    
    // cek password
    $row = mysqli_fetch_assoc($result);
    if(password_verify($password, $row["password"])) {
      // set session
      $_SESSION["login"] = true;
      $_SESSION["username"] = $username;
      $_SESSION["password"] = $password; 
      header("Location: dashboard.php");
      exit;
    }
  }

  $error = true;

  
  


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
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
          <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login">
            <div class="card col-lg-4 mx-auto">
              <div class="card-body px-5 py-5">
                <h3 class="card-title text-left mb-3">LOGIN</h3>
                <h3 class="card-title text-left mb-3">PT TAKA TURBOMACHINERY</h3>
                <?php if(isset($error)) :?>
                  <p style="font-size: italic;" >Username / password salah</p>
                <?php endif ?>
                <form action="" method="POST">
                  <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Input Username" autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Input Password" autocomplete="off">
                  </div>
                  <div class="form-group d-flex align-items-center justify-content-between">
                    <!-- <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input"> Remember me </label>
                    </div>
                    <a href="#" class="forgot-pass">Forgot password</a> -->
                  </div>
                  <div class="text-center">
                    
                    <button type="submit" name="login" class="btn btn-primary btn-block enter-btn">LOGIN</button>
                  </div>
                  <!-- <div class="d-flex">
                    <button class="btn btn-facebook mr-2 col">
                      <i class="mdi mdi-facebook"></i> Facebook </button>
                    <button class="btn btn-google col">
                      <i class="mdi mdi-google-plus"></i> Google plus </button>
                  </div> -->
                  <p class="sign-up">Don't have an Account?<a href="signup.php"> Sign Up</a></p>
                </form>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
        </div>
        <!-- row ends -->
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
  </body>
</html>