<?php
// $host = "localhost";
// $user = "root";
// $pass = "";
// $db = "digitalisasi_bubut";

// $koneksi = mysqli_connect($host, $user, $pass, $db);


// $breakdown = "SELECT *, COUNT(status) AS jumlah FROM tb_status WHERE status like '%breakdown%'";
// $qBrdown = mysqli_query($koneksi, $breakdown);
// foreach($qBrdown as $b){
//     $br =  $b['jumlah'];
// }









// $timeBeforeStatus = timeBeforeStatus();
// foreach($timeBeforeStatus as $d){
//     $tbs = $d['durasi'];
// }

$mesin = $_SESSION['mesin'];



// Last Status
$lastStatus = lastStatus();
// Mengecek hasil query
if ($lastStatus->num_rows > 0) {
    foreach($lastStatus as $a){
        $l =  $a['status'];
    }
} else {
    echo "Tidak ada data ";
}

// before status
$beforeStatus = beforeStatus();
if ($beforeStatus->num_rows > 0) {
    foreach($beforeStatus as $c){
        $bs = $c['status'];
    }
} else {
    echo "Tidak ada data ";
}

// downtime
$timeDown = timeDown();
if ($timeDown->num_rows > 0) {
    foreach($timeDown as $b1){
        $td =  $b1['all_breakdown'];
    }
} else {
    echo "00:00:00";
}

// downtime today
$timeTodayDown = timeTodayDown();
if ($timeTodayDown->num_rows > 0) {
    foreach($timeTodayDown as $b2){
        $ttd =  $b2['waktu_downtime'];
    }    
} else {
    echo "00:00:00";
}

// Running
$timeRun = timeRun();
if ($timeRun->num_rows > 0) {
    foreach($timeRun as $e1){
        $tr =  $e1['all_running'];
    }
} else {
    echo "00:00:00";
}


$timeTodayRun = timeTodayRun();
if ($timeTodayRun->num_rows > 0) {
    foreach($timeTodayRun as $e2){
        $ttr =  $e2['waktu_running'];
    }
} else {
    echo "00:00:00";
}


// Menutup koneksi
$koneksi->close();
?>

<div class="row">
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
        <h5>Machine Name</h5>
        <div class="row">
            <div class="col-9">
            <div class="d-flex align-items-center align-self-start">
                <h3 class="mb-0"><?= $mesin; ?></h3>
                <p class="text-success ml-2 mb-0 font-weight-medium"></p>
            </div>
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
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
        <h5>Last Status</h5>
        <div class="row">
            <div class="col-9">
            <div class="d-flex align-items-center align-self-start">
                <h3 id = "refLastStatus" class="mb-0"><?= $l; ?></h3>
                <!-- <p class="text-success ml-2 mb-0 font-weight-medium">+11%</p> -->
            </div>
            </div>
            <div class="col-3">
            <!-- <div class="icon icon-box-success">
                <span class="mdi mdi-arrow-top-right icon-item"></span>
            </div> -->
            </div>
        </div>
        <!-- <h6 class="text-muted font-weight-normal"><?= $bs; ?> - <?= $tbs; ?></h6>
     -->
     <h6 id="refBefStatus" class="text-muted font-weight-normal"><?= $bs; ?></h6>
        </div>
    </div>
    </div>
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
        <h5>Downtime</h5>
        <div class="row">
            <div class="col-9">
            <div class="d-flex align-items-center align-self-start">
                <h3 id="refDowntime" class="mb-0"><?= $td; ?></h3>
                <!-- <p class="text-danger ml-2 mb-0 font-weight-medium">-2.4%</p> -->
            </div>
            </div>
            <div class="col-3">
            <!-- <div class="icon icon-box-danger">
                <span class="mdi mdi-arrow-bottom-left icon-item"></span>
            </div> -->
            </div>
        </div>
        <h6 id="refDowntimeToday" class="text-muted font-weight-normal">Today - <?= $ttd; ?></h6>
        </div>
    </div>
    </div>
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
        <h5>Running</h5>
        <div class="row">
            <div class="col-9">
            <div class="d-flex align-items-center align-self-start">
                <h3 id="refRunning" class="mb-0"><?= $tr; ?></h3>
                <!-- <p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p> -->
            </div>
            </div>
            <div class="col-3">
            <!-- <div class="icon icon-box-success ">
                <span class="mdi mdi-arrow-top-right icon-item"></span>
            </div> -->
            </div>
        </div>
        <h6 id="refRunningToday" class="text-muted font-weight-normal">Today - <?= $ttr; ?></h6>
        </div>
    </div>
    </div>
</div>

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