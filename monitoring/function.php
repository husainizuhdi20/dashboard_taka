<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "digitalisasi_bubut";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if(!$koneksi){
    echo "Connection Failed";
}

function query($query) {
    global $koneksi;
    $result = mysqli_query($koneksi, $query);
    $rows = []; //wadah untuk menyimpan array
    while( $row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;

}

function tambah($data) {
    global $koneksi;
    $machine_id = $data['machine_id'];
    $work_identity = $data['work_identity'];
    $job_id = $data['job_id'];
    $operator_id = $data['operator_id'];
    $start_date = $data['start_date'];
    $standard_time = $data['standard_time'];
    $status = "Pending";

    $qu = "INSERT INTO tb_form_plan VALUES('',current_timestamp(), '$machine_id','$work_identity', '$job_id', '$operator_id', $start_date, '$standard_time', '$status')";
    $insert = mysqli_query($koneksi, $qu);     
}

function absen($data) {
    global $koneksi;
    $name = $data['op_name'];
    $position = $data['position'];
    $machine_id2 = $data['machine_id'];
    $time = $data['time'];
    $qabsen = "INSERT INTO tb_absen VALUES('',current_timestamp(),'$name', '$position', '$machine_id2','$time')";
    $insert = mysqli_query($koneksi, $qabsen);    
    
}


function registrasi($data) {
    global $koneksi;
    $username = mysqli_real_escape_string($koneksi, $data["username"]);
    $password = mysqli_real_escape_string($koneksi, $data["password"]);
    $password2 = mysqli_real_escape_string($koneksi, $data["password2"]);

    // cek username sudah ada atau belum
    $result = mysqli_query($koneksi, "SELECT username FROM tb_login WHERE username = '$username'");

    if(mysqli_fetch_assoc($result)) {
        echo "<script>
        alert('username yang dipilih sudah terdaftar')
        </script>";
        return false;
    }

    // cek konfirmasi password
    if($password !== $password2) {
        echo "<script> alert('konfirmasi password tidak sesuai!') </script>";
        return false;
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);
    // tambah user baru ke database
    mysqli_query($koneksi, "INSERT INTO tb_login VALUES('', '$username', '$password', '')");
    return mysqli_affected_rows($koneksi);
}

function query_data(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT * FROM tb_energy");
    mysqli_close($koneksi);
    return $result;
}


// ------------------------- Energy -----------------------
function currentMonth(){
    global $koneksi;
    $result = query("SELECT SUM(wpp) as total_data FROM tb_sensor WHERE MONTH(tmp) = MONTH(CURRENT_DATE())");
    
    return $result;    
}

function lastMonth(){
    global $koneksi;
    $result = query("SELECT *, SUM(wpp) as last_month_energy FROM tb_sensor WHERE tmp >= DATE_ADD(NOW(), INTERVAL -1 MONTH) AND tmp < LAST_DAY(DATE_ADD(NOW(), INTERVAL -1 MONTH))+ INTERVAL 1 DAY");
    return $result;    
}

// Filter
function tahunEnergyConsumptionF($inputTahun){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT *, CONCAT(YEAR(tmp), '/' , MONTH(tmp)) AS tahunEn, ROUND(wpp, 2) AS totalEn
    FROM tb_sensor
    WHERE tmp IN (
        SELECT MAX(tmp) FROM tb_sensor GROUP BY YEAR(tmp), MONTH(tmp)
    ) AND CONCAT(YEAR(tmp)) = '$inputTahun' GROUP BY YEAR(tmp), MONTH(tmp)
    ");
    return $result; 
}

function dataEnergyConsumptionF($inputTahun){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT *, CONCAT(YEAR(tmp), '/' , MONTH(tmp)) AS tahunEn, ROUND(wpp, 2) AS totalEn
    FROM tb_sensor
    WHERE tmp IN (
        SELECT MAX(tmp) FROM tb_sensor GROUP BY YEAR(tmp), MONTH(tmp)
    ) AND CONCAT(YEAR(tmp)) = '$inputTahun' GROUP BY YEAR(tmp), MONTH(tmp)
    ");
    return $result; 
}

// Non filter
function tahunEnergyAnnualConsumptionN(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT 
    YEAR(tmp) AS tahun, 
    MAX(wpp) AS energy 
    FROM tb_sensor 
    WHERE YEAR(tmp) BETWEEN YEAR(NOW()) - 5 AND YEAR(NOW()) + 5 
    GROUP BY YEAR(tmp) ORDER BY YEAR(tmp)");
    return $result;
}
function dataEnergyAnnualConsumptionN(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT 
    YEAR(tmp) AS tahun, 
    MAX(wpp) AS energy 
    FROM tb_sensor 
    WHERE YEAR(tmp) BETWEEN YEAR(NOW()) - 5 AND YEAR(NOW()) + 5 
    GROUP BY YEAR(tmp) ORDER BY YEAR(tmp)");
    return $result; 
}

function bulanEnergyMonthlyConsumptionN(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT tahunEn AS thnE FROM monthly_power_ak");
    return $result; 
}
function dataEnergyMonthlyConsumptionN(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT selisihEn AS slsE FROM monthly_power_ak ");
    return $result; 
}
// function bulanEnergyMonthlyConsumptionN(){
//     global $koneksi;
//     $result = mysqli_query($koneksi, "SELECT tahunnEn FROM monthly_power_ak"
    // "SELECT CONCAT(YEAR(tmp),'/',MONTH(tmp)) AS tahunEn, ROUND(SUM(wpp),2) AS totalEn FROM tb_sensor WHERE CONCAT(YEAR(tmp))= YEAR(NOW()) GROUP BY YEAR(tmp),MONTH(tmp)"
//     "SELECT 
//     tahunEn, 
//     totalEn,
//     totalEn - COALESCE(LAG(totalEn) OVER (ORDER BY tahunEn), 0) - 
//     COALESCE(LAG(totalEn, 2) OVER (ORDER BY tahunEn), 0) - 
//     COALESCE(LAG(totalEn, 3) OVER (ORDER BY tahunEn), 0) - 
//     COALESCE(LAG(totalEn, 4) OVER (ORDER BY tahunEn), 0) - 
//     COALESCE(LAG(totalEn, 5) OVER (ORDER BY tahunEn), 0) - 
//     COALESCE(LAG(totalEn, 6) OVER (ORDER BY tahunEn), 0) - 
//     COALESCE(LAG(totalEn, 7) OVER (ORDER BY tahunEn), 0) - 
//     COALESCE(LAG(totalEn, 8) OVER (ORDER BY tahunEn), 0) - 
//     COALESCE(LAG(totalEn, 9) OVER (ORDER BY tahunEn), 0) AS selisihEn
//   FROM 
//     monthly_power
//   ORDER BY 
//     tahunEn"
//     );
//     return $result; 
// }

// function dataEnergyMonthlyConsumptionN(){
//     global $koneksi;
//     $result = mysqli_query($koneksi, "SELECT selisihEn FROM monthly_power_ak" 
    // "SELECT CONCAT(YEAR(tmp),'/',MONTH(tmp)) AS tahunEn, ROUND(SUM(wpp),2) AS totalEn FROM tb_sensor WHERE CONCAT(YEAR(tmp))= YEAR(NOW()) GROUP BY YEAR(tmp),MONTH(tmp)"
//     "SELECT 
//     tahunEn, 
//     totalEn,
//     totalEn - COALESCE(LAG(totalEn) OVER (ORDER BY tahunEn), 0) - 
//     COALESCE(LAG(totalEn, 2) OVER (ORDER BY tahunEn), 0) - 
//     COALESCE(LAG(totalEn, 3) OVER (ORDER BY tahunEn), 0) - 
//     COALESCE(LAG(totalEn, 4) OVER (ORDER BY tahunEn), 0) - 
//     COALESCE(LAG(totalEn, 5) OVER (ORDER BY tahunEn), 0) - 
//     COALESCE(LAG(totalEn, 6) OVER (ORDER BY tahunEn), 0) - 
//     COALESCE(LAG(totalEn, 7) OVER (ORDER BY tahunEn), 0) - 
//     COALESCE(LAG(totalEn, 8) OVER (ORDER BY tahunEn), 0) - 
//     COALESCE(LAG(totalEn, 9) OVER (ORDER BY tahunEn), 0) AS selisihEn
//   FROM 
//     monthly_power
//   ORDER BY 
//     tahunEn"
//     );
//     return $result; 
// }

// ------------------------- End Energy -------------------------


// ------------------------- History ----------------------------
// Filter
  // rekap waktu
function powerOnF($d1, $d2){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SEC_TO_TIME( SUM(time_to_sec(durasi))) AS timePowerOn FROM tb_durasi WHERE status LIKE '%Power On%' AND tmp BETWEEN  '$d1' and DATE_ADD('$d2', INTERVAL 1 DAY)");
    return $result; 
}
function mtbfF($d1, $d2){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SEC_TO_TIME( SUM(time_to_sec(durasi))) AS timeMtbf FROM tb_durasi WHERE status LIKE '%mtbf%' AND tmp BETWEEN  '$d1' and DATE_ADD('$d2', INTERVAL 1 DAY)");
    return $result; 
}
function qcF($d1, $d2){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SEC_TO_TIME( SUM(time_to_sec(durasi))) AS timeQc FROM tb_durasi WHERE status LIKE '%qc%' AND tmp BETWEEN  '$d1' and DATE_ADD('$d2', INTERVAL 1 DAY)");
    return $result; 
}
function runningF($d1, $d2){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SEC_TO_TIME( SUM(time_to_sec(durasi))) AS timeRun FROM tb_durasi WHERE status LIKE '%Running%' AND tmp BETWEEN  '$d1' and DATE_ADD('$d2', INTERVAL 1 DAY)");
    return $result; 
}
function setupF($d1, $d2){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SEC_TO_TIME( SUM(time_to_sec(durasi))) AS timeSet FROM tb_durasi WHERE status LIKE '%Setup%' AND tmp BETWEEN '$d1' AND DATE_ADD('$d2', INTERVAL 1 DAY)");
    return $result; 
}
function loginOnF($d1, $d2){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SEC_TO_TIME( SUM(time_to_sec(durasi))) AS timeLogin FROM tb_durasi WHERE status LIKE '%Login On%' AND tmp BETWEEN '$d1' AND DATE_ADD('$d2', INTERVAL 1 DAY)");
    return $result; 
}
function idleF($d1, $d2){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SEC_TO_TIME( SUM(time_to_sec(durasi))) AS timeIdle FROM tb_durasi WHERE status LIKE '%Idle%' AND tmp BETWEEN '$d1' AND DATE_ADD('$d2', INTERVAL 1 DAY)");
    return $result; 
}
function breakF($d1, $d2){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SEC_TO_TIME( SUM(time_to_sec(durasi))) AS timeBreak FROM tb_durasi WHERE status LIKE 'Break' AND tmp BETWEEN '$d1' AND DATE_ADD('$d2', INTERVAL 1 DAY)");
    return $result; 
}
function breakdownF($d1, $d2){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SEC_TO_TIME( SUM(time_to_sec(durasi))) AS timeBreakdown FROM tb_durasi WHERE status LIKE '%Breakdown%' AND tmp BETWEEN '$d1' AND DATE_ADD('$d2', INTERVAL 1 DAY)");
    return $result; 
}
function workpieceF($d1, $d2){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SEC_TO_TIME( SUM(time_to_sec(durasi))) AS timeWorkpiece FROM tb_durasi WHERE status LIKE '%Workpiece%' AND tmp BETWEEN '$d1' AND DATE_ADD('$d2', INTERVAL 1 DAY)");
    return $result; 
}
function toolsF($d1, $d2){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SEC_TO_TIME( SUM(time_to_sec(durasi))) AS timeTools FROM tb_durasi WHERE status LIKE '%Tools%' AND tmp BETWEEN '$d1' AND DATE_ADD('$d2', INTERVAL 1 DAY)");
    return $result; 
}

  // Grafik Energy
function tmpEnergyF($d1, $d2){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT * FROM tb_sensor WHERE tmp BETWEEN '$d1' AND DATE_ADD('$d2', INTERVAL 1 DAY)");
    return $result; 
}
function dataEnergyF($d1, $d2){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT * FROM tb_sensor WHERE tmp BETWEEN '$d1' AND DATE_ADD('$d2', INTERVAL 1 DAY)");
    return $result; 
}
  // Grafik Utilisasi
function tmpUtilF($d1, $d2){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT DATE(tmp) as time_new
    FROM tb_durasi
    WHERE tmp BETWEEN '$d1' AND DATE_ADD('$d2', INTERVAL 1 DAY)  
    GROUP BY DATE(tmp)");
    return $result; 
}
function idleUtilF($d1, $d2){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT DATE(tmp) AS time_new_idle, SEC_TO_TIME(SUM(TIME_TO_SEC(durasi))) AS total_durasi_idle,
    TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(durasi))), '%H.%i') AS konversi_idle
    FROM tb_durasi
    WHERE status LIKE '%Idle%' AND tmp BETWEEN '$d1' AND DATE_ADD('$d2', INTERVAL 1 DAY)
    GROUP BY DATE(tmp) ");
    return $result; 
}
function runningUtilF($d1, $d2){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT DATE(tmp) AS time_new_running, SEC_TO_TIME(SUM(TIME_TO_SEC(durasi))) AS total_durasi_running,
    TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(durasi))), '%H.%i') AS konversi_running
    FROM tb_durasi
    WHERE status LIKE '%Running%' AND tmp BETWEEN '$d1' AND DATE_ADD('$d2', INTERVAL 1 DAY)
    GROUP BY DATE(tmp)");
    return $result; 
}
function workpieceUtilF($d1, $d2){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT DATE(tmp) AS time_new_work, SEC_TO_TIME(SUM(TIME_TO_SEC(durasi))) AS total_durasi_work,
    TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(durasi))), '%H.%i') AS konversi_work
    FROM tb_durasi
    WHERE status LIKE '%Workpiece Setup%' AND tmp BETWEEN '$d1' AND DATE_ADD('$d2', INTERVAL 1 DAY)
    GROUP BY DATE(tmp)");
    return $result; 
}
function downtimeUtilF($d1, $d2){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT DATE(tmp) AS time_new_downtime, SEC_TO_TIME(SUM(TIME_TO_SEC(durasi))) AS total_durasi_downtime,
    TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(durasi))), '%H.%i') AS konversi_downtime
    FROM tb_durasi
    WHERE status LIKE '%Downtime%' AND tmp BETWEEN '$d1' AND DATE_ADD('$d2', INTERVAL 1 DAY)
    GROUP BY DATE(tmp)");
    return $result; 
}
function toolsUtilF($d1, $d2){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT DATE(tmp) AS time_new_tools, SEC_TO_TIME(SUM(TIME_TO_SEC(durasi))) AS total_durasi_tools,
    TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(durasi))), '%H.%i') AS konversi_tools
    FROM tb_durasi
    WHERE status LIKE '%Tools%' AND tmp BETWEEN '$d1' AND DATE_ADD('$d2', INTERVAL 1 DAY)
    GROUP BY DATE(tmp)");
    return $result; 
}

  // Tabel
function dataTableF($d1, $d2){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT * FROM tb_form_plan WHERE tmp BETWEEN  '$d1' and DATE_ADD('$d2', INTERVAL 1 DAY)");
    return $result;
}


// Non Filter
  //Rekap waktu
function powerOnN(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SEC_TO_TIME( SUM(time_to_sec(durasi))) AS timePowerOn FROM tb_durasi WHERE status LIKE '%Power On%'");
    return $result;
}
function mtbfN(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SEC_TO_TIME( SUM(time_to_sec(durasi))) AS timeMtbf FROM tb_durasi WHERE status LIKE '%mtbf%' ");
    return $result; 
}
function qcN(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SEC_TO_TIME( SUM(time_to_sec(durasi))) AS timeQc FROM tb_durasi WHERE status LIKE '%qc%' ");
    return $result; 
}
function runningN(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SEC_TO_TIME( SUM(time_to_sec(durasi))) AS timeRun FROM tb_durasi WHERE status LIKE '%Running%' ");
    return $result; 
}
function setupN(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SEC_TO_TIME( SUM(time_to_sec(durasi))) AS timeSet FROM tb_durasi WHERE status LIKE '%Setup%'");
    return $result; 
}
function loginOnN(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SEC_TO_TIME( SUM(time_to_sec(durasi))) AS timeLogin FROM tb_durasi WHERE status LIKE '%Login On%'");
    return $result; 
}
function idleN(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SEC_TO_TIME( SUM(time_to_sec(durasi))) AS timeIdle FROM tb_durasi WHERE status LIKE '%Idle%'");
    return $result; 
}
function breakN(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SEC_TO_TIME( SUM(time_to_sec(durasi))) AS timeBreak FROM tb_durasi WHERE status LIKE 'Break'");
    return $result; 
}
function breakdownN(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SEC_TO_TIME( SUM(time_to_sec(durasi))) AS timeBreakdown FROM tb_durasi WHERE status LIKE '%Breakdown%'");
    return $result; 
}
function workpieceN(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SEC_TO_TIME( SUM(time_to_sec(durasi))) AS timeWorkpiece FROM tb_durasi WHERE status LIKE '%Workpiece%'");
    return $result; 
}
function toolsN(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SEC_TO_TIME( SUM(time_to_sec(durasi))) AS timeTools FROM tb_durasi WHERE status LIKE '%Tools%'");
    return $result; 
}

  // Grafik Energy
function tmpEnergyN(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT * FROM tb_sensor ORDER BY id DESC LIMIT 10 ");
    return $result; 
}
function dataEnergyN(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT * FROM tb_sensor ORDER BY id DESC LIMIT 10");
    return $result; 
}

 // Utilisasi
function tmpUtilN(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT DATE(tmp) as time_new
    FROM tb_durasi  
    GROUP BY DATE(tmp) DESC LIMIT 5");
    return $result; 
}
function idleUtilN(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT DATE(tmp) AS time_new_idle, SEC_TO_TIME(SUM(TIME_TO_SEC(durasi))) AS total_durasi_idle,
    TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(durasi))), '%H.%i') AS konversi_idle
    FROM tb_durasi
    WHERE status LIKE '%Idle%' 
    GROUP BY DATE(tmp) DESC LIMIT 5");
    return $result; 
}
function runningUtilN(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT DATE(tmp) AS time_new_running, SEC_TO_TIME(SUM(TIME_TO_SEC(durasi))) AS total_durasi_running,
    TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(durasi))), '%H.%i') AS konversi_running
    FROM tb_durasi
    WHERE status LIKE '%Running%' 
    GROUP BY DATE(tmp) DESC LIMIT 5");
    return $result; 
}
function workpieceUtilN(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT DATE(tmp) AS time_new_work, SEC_TO_TIME(SUM(TIME_TO_SEC(durasi))) AS total_durasi_work,
    TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(durasi))), '%H.%i') AS konversi_work
    FROM tb_durasi
    WHERE status LIKE '%Workpiece Setup%' 
    GROUP BY DATE(tmp) DESC LIMIT 5");
    return $result; 
}
function downtimeUtilN(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT DATE(tmp) AS time_new_downtime, SEC_TO_TIME(SUM(TIME_TO_SEC(durasi))) AS total_durasi_downtime,
    TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(durasi))), '%H.%i') AS konversi_downtime
    FROM tb_durasi
    WHERE status LIKE '%Downtime%' 
    GROUP BY DATE(tmp) DESC LIMIT 5");
    return $result; 
}
function toolsUtilN(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT DATE(tmp) AS time_new_tools, SEC_TO_TIME(SUM(TIME_TO_SEC(durasi))) AS total_durasi_tools,
    TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(durasi))), '%H.%i') AS konversi_tools
    FROM tb_durasi
    WHERE status LIKE '%Tools Setup%' 
    GROUP BY DATE(tmp) DESC LIMIT 5");
    return $result; 
}

  // Tabel
function dataTableN(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT * FROM tb_form_plan ORDER BY id DESC LIMIT 10");
    return $result;
}
// ------------------------- End History ------------------------




// ------------------------- Summary --------------------------
// Utilisasi
function tmpUtilDash(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT DATE(tmp) AS time_new, SEC_TO_TIME(SUM(TIME_TO_SEC(durasi))) AS total_durasi,
    TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(durasi))), '%H.%i') AS konversi_time
    FROM tb_durasi
    WHERE DATE(tmp) >= CURDATE() - INTERVAL 1 DAY
    GROUP BY DATE(tmp) LIMIT 2");
    return $result; 
}
function idleUtilDash(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT DATE(tmp) AS time_new_idle, SEC_TO_TIME(SUM(TIME_TO_SEC(durasi))) AS total_durasi_idle,
    TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(durasi))), '%H.%i') AS konversi_idle
    FROM tb_durasi
    WHERE status LIKE '%Idle%' AND DATE(tmp) >= CURDATE() - INTERVAL 1 DAY
    GROUP BY DATE(tmp) LIMIT 2
    ");
    return $result; 
}
function runningUtilDash(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT DATE(tmp) AS time_new_run, SEC_TO_TIME(SUM(TIME_TO_SEC(durasi))) AS total_durasi_run,
    TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(durasi))), '%H.%i') AS konversi_run
    FROM tb_durasi
    WHERE status LIKE '%Running%' AND DATE(tmp) >= CURDATE() - INTERVAL 1 DAY
    GROUP BY DATE(tmp) LIMIT 2");
    return $result; 
}
function workpieceUtilDash(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT DATE(tmp) AS time_new_work, SEC_TO_TIME(SUM(TIME_TO_SEC(durasi))) AS total_durasi_work,
    TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(durasi))), '%H.%i') AS konversi_work
    FROM tb_durasi
    WHERE status LIKE '%Workpiece Setup%' AND DATE(tmp) >= CURDATE() - INTERVAL 1 DAY
    GROUP BY DATE(tmp) LIMIT 2");
    return $result; 
}
function downtimeUtilDash(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT DATE(tmp) AS time_new_downtime, SEC_TO_TIME(SUM(TIME_TO_SEC(durasi))) AS total_durasi_downtime,
    TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(durasi))), '%H.%i') AS konversi_downtime
    FROM tb_durasi
    WHERE status LIKE '%Downtime%' AND DATE(tmp) >= CURDATE() - INTERVAL 1 DAY
    GROUP BY DATE(tmp) LIMIT 2");
    return $result; 
}
function toolsUtilDash(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT DATE(tmp) AS time_new_tools, SEC_TO_TIME(SUM(TIME_TO_SEC(durasi))) AS total_durasi_tools,
    TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(durasi))), '%H.%i') AS konversi_tools
    FROM tb_durasi
    WHERE status LIKE '%Tools Setup%' AND DATE(tmp) >= CURDATE() - INTERVAL 1 DAY
    GROUP BY DATE(tmp) LIMIT 2");
    return $result; 
}

  // Tabel
function dataTableDash(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT * FROM tb_form_plan ORDER BY id DESC LIMIT 5");
    return $result;
}

// ------------------------- End Dashboard ----------------------


// ------------------------- Card -------------------------------
function lastStatus(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT * FROM tb_status WHERE value = 1 ORDER BY id DESC LIMIT 1");
    return $result;
} 
function timeDown(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SEC_TO_TIME( SUM(time_to_sec(durasi))) AS all_breakdown FROM tb_durasi WHERE status LIKE '%Downtime%'");
    return $result;
}
function timeTodayDown(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SEC_TO_TIME( SUM(time_to_sec(durasi))) AS waktu_downtime FROM tb_durasi WHERE status LIKE '%Downtime%' AND DATE(tmp) = CURDATE()");
    return $result;
}
function timeRun(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SEC_TO_TIME( SUM(time_to_sec(durasi))) AS all_running FROM tb_durasi WHERE status LIKE '%Running%'");
    return $result;
}
function timeTodayRun(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SEC_TO_TIME( SUM(time_to_sec(durasi))) AS waktu_running FROM tb_durasi WHERE status LIKE '%Running%' AND DATE(tmp) = CURDATE()");
    return $result;
}
function beforeStatus(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT * FROM tb_status ORDER BY id DESC LIMIT 1, 1");
    return $result;
}
function timeBeforeStatus(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT * FROM tb_durasi ORDER BY id DESC LIMIT 1");
    return $result;
}
// ------------------------- End Card ---------------------------


// ------------------------- Report ----------------------------
// Filter
  // rekap waktu

function jumPekerjaanFr($thn){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT *, COUNT(*) AS jumPekerjaanAn FROM tb_form_plan WHERE tmp LIKE CONCAT('%', $thn, '%')");
    return $result; 
}

  // function powerOnF($d1, $d2){
//     global $koneksi;
//     $result = mysqli_query($koneksi, "SELECT SEC_TO_TIME( SUM(time_to_sec(durasi))) AS timePowerOn FROM tb_durasi WHERE status LIKE '%Power On%' AND tmp BETWEEN  '$d1' and DATE_ADD('$d2', INTERVAL 1 DAY)");
//     return $result; 
// }
// function mtbfF($d1, $d2){
//     global $koneksi;
//     $result = mysqli_query($koneksi, "SELECT SEC_TO_TIME( SUM(time_to_sec(durasi))) AS timeMtbf FROM tb_durasi WHERE status LIKE '%mtbf%' AND tmp BETWEEN  '$d1' and DATE_ADD('$d2', INTERVAL 1 DAY)");
//     return $result; 
// }
// function qcF($d1, $d2){
//     global $koneksi;
//     $result = mysqli_query($koneksi, "SELECT SEC_TO_TIME( SUM(time_to_sec(durasi))) AS timeQc FROM tb_durasi WHERE status LIKE '%qc%' AND tmp BETWEEN  '$d1' and DATE_ADD('$d2', INTERVAL 1 DAY)");
//     return $result; 
// }

function utilisasiFr($thn){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT *, SUM(TIME_TO_SEC(durasi)) AS availAn FROM tb_durasi WHERE status LIKE '%Power On%' AND tmp LIKE CONCAT('%', $thn, '%')");
    return $result;
}

function runningFr($thn){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SEC_TO_TIME( SUM(time_to_sec(durasi))) AS timeRunAn FROM tb_durasi WHERE status LIKE '%Running%' AND tmp LIKE CONCAT('%', $thn, '%')");
    return $result; 
}
function setupFr($thn){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SEC_TO_TIME( SUM(time_to_sec(durasi))) AS timeSetAn FROM tb_durasi WHERE status LIKE '%Setup%' AND tmp LIKE CONCAT('%', $thn, '%')");
    return $result; 
}
// function loginOnF($d1, $d2){
//     global $koneksi;
//     $result = mysqli_query($koneksi, "SELECT SEC_TO_TIME( SUM(time_to_sec(durasi))) AS timeLogin FROM tb_durasi WHERE status LIKE '%Login On%' AND tmp BETWEEN '$d1' AND DATE_ADD('$d2', INTERVAL 1 DAY)");
//     return $result; 
// }
function idleFr($thn){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SEC_TO_TIME( SUM(time_to_sec(durasi))) AS timeIdleAn FROM tb_durasi WHERE status LIKE '%Idle%' AND tmp LIKE CONCAT('%', $thn, '%')");
    return $result; 
}
function breakFr($thn){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SEC_TO_TIME( SUM(time_to_sec(durasi))) AS timeBreakAn FROM tb_durasi WHERE status LIKE 'Break' AND tmp = LIKE CONCAT('%', $thn, '%')");
    return $result; 
}
function breakdownFr($thn){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SEC_TO_TIME( SUM(time_to_sec(durasi))) AS timeBreakdownAn FROM tb_durasi WHERE status LIKE '%Breakdown%' AND tmp LIKE CONCAT('%', $thn, '%')");
    return $result; 
}
function workpieceFr($thn){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SEC_TO_TIME( SUM(time_to_sec(durasi))) AS timeWorkpieceAn FROM tb_durasi WHERE status LIKE '%Workpiece%' AND tmp LIKE CONCAT('%', $thn, '%')");
    return $result; 
}
function toolsFr($thn){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SEC_TO_TIME( SUM(time_to_sec(durasi))) AS timeToolsAn FROM tb_durasi WHERE status LIKE '%Tools%' AND tmp LIKE CONCAT('%', $thn, '%')");
    return $result; 
}

function goodFr($thn){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT *, COUNT(status) AS timeGoodAn FROM tb_status WHERE status like '%Good Product%' AND tmp LIKE CONCAT('%', $thn, '%')");
    return $result; 
}

function rejectFr($thn){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT *, COUNT(status) AS timeRejectAn FROM tb_status WHERE status like '%Reject Product%' AND tmp LIKE CONCAT('%', $thn, '%')");
    return $result; 
}

function currentMonthFr(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SUM(energy) as energyMonthAn FROM tb_energy WHERE MONTH(tmp) = MONTH(CURRENT_DATE())");
    return $result;    
}



  // Grafik Energy
// function tmpEnergyF($d1, $d2){
//     global $koneksi;
//     $result = mysqli_query($koneksi, "SELECT * FROM tb_energy WHERE tmp BETWEEN '$d1' AND DATE_ADD('$d2', INTERVAL 1 DAY)");
//     return $result; 
// }
// function dataEnergyF($d1, $d2){
//     global $koneksi;
//     $result = mysqli_query($koneksi, "SELECT * FROM tb_energy WHERE tmp BETWEEN '$d1' AND DATE_ADD('$d2', INTERVAL 1 DAY)");
//     return $result; 
// }
//   // Grafik Utilisasi
// function tmpUtilF($d1, $d2){
//     global $koneksi;
//     $result = mysqli_query($koneksi, "SELECT DATE_FORMAT(tmp, '%Y-%m-%d') AS time_new
//     FROM tb_durasi WHERE WEEKDAY(tmp) NOT IN (5,6) AND tmp BETWEEN  '$d1' and DATE_ADD('$d2', INTERVAL 1 DAY)
//     GROUP BY YEAR(time_new), WEEK(time_new)
//     ORDER BY time_new ASC");
//     return $result; 
// }
// function idleUtilF($d1, $d2){
//     global $koneksi;
//     $result = mysqli_query($koneksi, "SELECT *, DATE_FORMAT(tmp, '%Y-%m-%d') AS time_new_idle, SEC_TO_TIME( SUM(time_to_sec(durasi))) AS total_waktu_idle, TIME_FORMAT(SEC_TO_TIME( SUM(time_to_sec(durasi))), '%H.%i') AS konversi_idle
//     FROM tb_durasi
//     WHERE WEEKDAY(tmp) NOT IN (5,6) AND status LIKE '%Idle%' AND tmp BETWEEN  '$d1' and DATE_ADD('$d2', INTERVAL 1 DAY)
//     GROUP BY YEAR(time_new_idle), WEEK(time_new_idle)
//     ORDER BY time_new_idle ASC");
//     return $result; 
// }
// function runningUtilF($d1, $d2){
//     global $koneksi;
//     $result = mysqli_query($koneksi, "SELECT *, DATE_FORMAT(tmp, '%Y-%m-%d') AS time_new_run, SEC_TO_TIME( SUM(time_to_sec(durasi))) AS total_waktu_run, TIME_FORMAT(SEC_TO_TIME( SUM(time_to_sec(durasi))), '%H.%i') AS konversi_run
//     FROM tb_durasi
//     WHERE WEEKDAY(tmp) NOT IN (5,6) AND status LIKE '%Running%' AND tmp BETWEEN  '$d1' and DATE_ADD('$d2', INTERVAL 1 DAY) 
//     GROUP BY YEAR(time_new_run), WEEK(time_new_run)
//     ORDER BY time_new_run ASC");
//     return $result; 
// }
// function workpieceUtilF($d1, $d2){
//     global $koneksi;
//     $result = mysqli_query($koneksi, "SELECT *, DATE_FORMAT(tmp, '%Y-%m-%d') AS time_new_work, SEC_TO_TIME( SUM(time_to_sec(durasi))) AS total_waktu_work, TIME_FORMAT(SEC_TO_TIME( SUM(time_to_sec(durasi))), '%H.%i') AS konversi_work
//     FROM tb_durasi
//     WHERE WEEKDAY(tmp) NOT IN (5,6) AND status LIKE '%Workpiece%' AND tmp BETWEEN  '$d1' and DATE_ADD('$d2', INTERVAL 1 DAY) 
//     GROUP BY YEAR(time_new_work), WEEK(time_new_work)
//     ORDER BY time_new_work ASC");
//     return $result; 
// }
// function breakdownUtilF($d1, $d2){
//     global $koneksi;
//     $result = mysqli_query($koneksi, "SELECT *, DATE_FORMAT(tmp, '%Y-%m-%d') AS time_new_breakdown, SEC_TO_TIME( SUM(time_to_sec(durasi))) AS total_waktu_breakdown, TIME_FORMAT(SEC_TO_TIME( SUM(time_to_sec(durasi))), '%H.%i') AS konversi_breakdown
//     FROM tb_durasi
//     WHERE WEEKDAY(tmp) NOT IN (5,6) AND status LIKE '%Breakdown%' AND tmp BETWEEN  '$d1' and DATE_ADD('$d2', INTERVAL 1 DAY) 
//     GROUP BY YEAR(time_new_breakdown), WEEK(time_new_breakdown)
//     ORDER BY time_new_breakdown ASC");
//     return $result; 
// }
// function toolsUtilF($d1, $d2){
//     global $koneksi;
//     $result = mysqli_query($koneksi, "SELECT *, DATE_FORMAT(tmp, '%Y-%m-%d') AS time_new_tools, SEC_TO_TIME( SUM(time_to_sec(durasi))) AS total_waktu_tools, TIME_FORMAT(SEC_TO_TIME( SUM(time_to_sec(durasi))), '%H.%i') AS konversi_tools
//     FROM tb_durasi
//     WHERE WEEKDAY(tmp) NOT IN (5,6) AND status LIKE '%Tools%' AND tmp BETWEEN  '$d1' and DATE_ADD('$d2', INTERVAL 1 DAY) 
//     GROUP BY YEAR(time_new_tools), WEEK(time_new_tools)
//     ORDER BY time_new_tools ASC");
//     return $result; 
// }

//   // Tabel
// function dataTableF($d1, $d2){
//     global $koneksi;
//     $result = mysqli_query($koneksi, "SELECT * FROM tb_form_plan WHERE tmp BETWEEN  '$d1' and DATE_ADD('$d2', INTERVAL 1 DAY)");
//     return $result;
// }

// ------------- Analysis -------------
// -------- Filter ---------
// ---- ORE ----
function powerOnA($d1, $d2){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SUM(time_to_sec(durasi)) AS timePowerOn FROM tb_durasi WHERE status LIKE '%Power On%' AND tmp BETWEEN  '$d1' and DATE_ADD('$d2', INTERVAL 1 DAY)");
    return $result; 
}
function mtbfA($d1, $d2){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SUM(time_to_sec(durasi)) AS timeMtbf FROM tb_durasi WHERE status LIKE '%mtbf%' AND tmp BETWEEN  '$d1' and DATE_ADD('$d2', INTERVAL 1 DAY)");
    return $result; 
}
function qcA($d1, $d2){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SUM(time_to_sec(durasi)) AS timeQc FROM tb_durasi WHERE status LIKE '%qc%' AND tmp BETWEEN  '$d1' and DATE_ADD('$d2', INTERVAL 1 DAY)");
    return $result; 
}
function runningA($d1, $d2){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SUM(time_to_sec(durasi)) AS timeRun FROM tb_durasi WHERE status LIKE '%Running%' AND tmp BETWEEN  '$d1' and DATE_ADD('$d2', INTERVAL 1 DAY)");
    return $result; 
}
function setupA($d1, $d2){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SUM(time_to_sec(durasi)) AS timeSet FROM tb_durasi WHERE status LIKE '%Setup%' AND tmp BETWEEN '$d1' AND DATE_ADD('$d2', INTERVAL 1 DAY)");
    return $result; 
}
function loginOnA($d1, $d2){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SUM(time_to_sec(durasi)) AS timeLogin FROM tb_durasi WHERE status LIKE '%Login On%' AND tmp BETWEEN '$d1' AND DATE_ADD('$d2', INTERVAL 1 DAY)");
    return $result; 
}
function idleA($d1, $d2){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SUM(time_to_sec(durasi)) AS timeIdle FROM tb_durasi WHERE status LIKE '%Idle%' AND tmp BETWEEN '$d1' AND DATE_ADD('$d2', INTERVAL 1 DAY)");
    return $result; 
}
function breakA($d1, $d2){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SUM(time_to_sec(durasi)) AS timeBreak FROM tb_durasi WHERE status LIKE 'Break' AND tmp BETWEEN '$d1' AND DATE_ADD('$d2', INTERVAL 1 DAY)");
    return $result; 
}
function breakdownA($d1, $d2){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SUM(time_to_sec(durasi)) AS timeBreakdown FROM tb_durasi WHERE status LIKE '%Breakdown%' AND tmp BETWEEN '$d1' AND DATE_ADD('$d2', INTERVAL 1 DAY)");
    return $result; 
}
function workpieceA($d1, $d2){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SUM(time_to_sec(durasi)) AS timeWorkpiece FROM tb_durasi WHERE status LIKE '%Workpiece%' AND tmp BETWEEN '$d1' AND DATE_ADD('$d2', INTERVAL 1 DAY)");
    return $result; 
}
function toolsA($d1, $d2){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SUM(time_to_sec(durasi)) AS timeTools FROM tb_durasi WHERE status LIKE '%Tools%' AND tmp BETWEEN '$d1' AND DATE_ADD('$d2', INTERVAL 1 DAY)");
    return $result; 
}
// ------ End Filter -------

// Non FIlter
function powerOnNA(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SUM(time_to_sec(durasi)) AS timePowerOn FROM tb_durasi WHERE status LIKE '%Power On%'");
    return $result;
}
function mtbfNA(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SUM(time_to_sec(durasi)) AS timeMtbf FROM tb_durasi WHERE status LIKE '%mtbf%' ");
    return $result; 
}
function qcNA(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SUM(time_to_sec(durasi)) AS timeQc FROM tb_durasi WHERE status LIKE '%qc%' ");
    return $result; 
}
function runningNA(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SUM(time_to_sec(durasi)) AS timeRun FROM tb_durasi WHERE status LIKE '%Running%' ");
    return $result; 
}
function setupNA(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SUM(time_to_sec(durasi)) AS timeSet FROM tb_durasi WHERE status LIKE '%Setup%'");
    return $result; 
}
function loginOnNA(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SUM(time_to_sec(durasi)) AS timeLogin FROM tb_durasi WHERE status LIKE '%Login On%'");
    return $result; 
}
function idleNA(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SUM(time_to_sec(durasi)) AS timeIdle FROM tb_durasi WHERE status LIKE '%Idle%'");
    return $result; 
}
function breakNA(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SUM(time_to_sec(durasi)) AS timeBreak FROM tb_durasi WHERE status LIKE 'Break'");
    return $result; 
}
function breakdownNA(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SUM(time_to_sec(durasi)) AS timeBreakdown FROM tb_durasi WHERE status LIKE '%Breakdown%'");
    return $result; 
}
function workpieceNA(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SUM(time_to_sec(durasi)) AS timeWorkpiece FROM tb_durasi WHERE status LIKE '%Workpiece%'");
    return $result; 
}
function toolsNA(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SUM(time_to_sec(durasi)) AS timeTools FROM tb_durasi WHERE status LIKE '%Tools%'");
    return $result; 
}

// ---- End Non Filter


// total time
function totalTime($d1, $d2){
    global $koneksi;
    // power on 
    $powerOn = powerOnA($d1, $d2);
    foreach($powerOn as $p){
        $qp =  $p['timePowerOn'];
    }
    return $qp;

}

// Planned Downtime
function plannedDownTime($d1, $d2){
    global $koneksi;
    $break = breakA($d1, $d2);
    foreach($break as $br1){
      $qbreak1 =  $br1['timeBreak'];
    }
    $breakdown = breakdownA($d1, $d2);
    foreach($breakdown as $breakdown1){
      $qbreakdown =  $breakdown1['timeBreakdown'];
    }
    // QC 
    $quc = qcA($d1, $d2);
    foreach($quc as $c){
        $qc =  $c['timeQc'];
    }
    $plannedDownTime = ($qbreak1 + $qbreakdown + $qc);
    return $plannedDownTime;
}

// Facility downtime
function facilityDowntime($d1, $d2){
    global $koneksi;
    
}

// Setup and Adjustment
function setupAdjustment($d1, $d2){
    global $koneksi;
    // Workpiece 
    $workpiece = workpieceA($d1, $d2);
    foreach($workpiece as $w){
        $qpiece =  $w['timeWorkpiece'];
    }  

    // Tools 
    $tools = toolsA($d1, $d2);
    foreach($tools as $t){
        $qtools =  $t['timeTools'];
    }
    $setupAdjustment = $qpiece + $qtools;  
}

function materialShortages($d1, $d2){
    global $koneksi;
    // idle
    $idle = idleA($d1, $d2);
    foreach($idle as $i){
        $qi =  $i['timeIdle'];
    }
}

function manpowerAbsence($d1, $d2){
    global $koneksi;

}


// Dashboard
// Realtime
function loginOnNow(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT SUM(TIME_TO_SEC(durasi)) AS timeUtilDash FROM
    tb_durasi WHERE status LIKE '%Login On%' AND DATE(tmp) = CURDATE()");
    return $result;

}

function jobidNow(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT *, CONCAT(work_identity, ' ',job_id) AS gabungan FROM tb_form_plan ORDER BY id DESC LIMIT 1");
    return $result;
}

function operatorNow(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT * FROM tb_form_plan ORDER BY id DESC LIMIT 1");
    return $result;
}
function kwhNow(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT * FROM tb_sensor ORDER BY id DESC LIMIT 1");
    return $result;
}


function utilNowDash(){
    global $koneksi;
    $utilNow = loginOnNow();
    foreach($utilNow as $utn){
        $qutil = $utn['timeUtilDash'];
    }
    $utilNowDash = ($qutil / 28800) * 100; //28800 satuan detik dari 8 jam
    return $utilNowDash;
}

function jobidNowDash(){
    global $koneksi;
    $jobidNow = jobidNow();
    foreach($jobidNow as $jbn){
        $qjobid = $jbn['gabungan'];
    }
    $jbid = $qjobid;
    return $jbid;
}

function operatorNowDash(){
    global $koneksi;
    $operatorNow = operatorNow();
    foreach($operatorNow as $on){
        $qoperator = $on['operator_id'];
    }
    $optrid = $qoperator;
    return $optrid;
}

function kwhNowDash(){
    global $koneksi;
    $kwhNow = kwhNow();
    foreach($kwhNow as $kwhn){
        $qkwh = $kwhn['wpp'];
    }
    $kwh = $qkwh;
    return $kwh;
}

// Utilisasi
function tmpUtilNow(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT DATE(tmp) as time_util
    FROM tb_durasi
    WHERE DATE(tmp) = DATE(CURRENT_TIMESTAMP)
    GROUP BY DATE(tmp)");
    return $result; 
}
function idleUtilNow(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT DATE(tmp) as time_idle, SEC_TO_TIME(SUM(TIME_TO_SEC(durasi))) as total_durasi_idle, TIME_FORMAT(SEC_TO_TIME( SUM(time_to_sec(durasi))), '%H.%i') AS t_idle
    FROM tb_durasi
    WHERE status LIKE '%Idle%' AND DATE(tmp) = DATE(CURRENT_TIMESTAMP)
    GROUP BY DATE(tmp)");
    return $result; 
}
function runningUtilNow(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT DATE(tmp) as time_running, SEC_TO_TIME(SUM(TIME_TO_SEC(durasi))) as total_durasi_running, TIME_FORMAT(SEC_TO_TIME( SUM(time_to_sec(durasi))), '%H.%i') AS t_run
    FROM tb_durasi
    WHERE status LIKE '%Running%' AND DATE(tmp) = DATE(CURRENT_TIMESTAMP)
    GROUP BY DATE(tmp)");
    return $result; 
}
function workpieceUtilNow(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT DATE(tmp) as time_work, SEC_TO_TIME(SUM(TIME_TO_SEC(durasi))) as total_durasi_work, TIME_FORMAT(SEC_TO_TIME( SUM(time_to_sec(durasi))), '%H.%i') AS t_work
    FROM tb_durasi
    WHERE status LIKE '%Workpiece Setup%' AND DATE(tmp) = DATE(CURRENT_TIMESTAMP)
    GROUP BY DATE(tmp)");
    return $result; 
}
function downtimeUtilNow(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT DATE(tmp) as time_down, SEC_TO_TIME(SUM(TIME_TO_SEC(durasi))) as total_durasi_downtime, TIME_FORMAT(SEC_TO_TIME( SUM(time_to_sec(durasi))), '%H.%i') AS t_downtime
    FROM tb_durasi
    WHERE status LIKE '%Downtime%' AND DATE(tmp) = DATE(CURRENT_TIMESTAMP)
    GROUP BY DATE(tmp)");
    return $result; 
}
function toolsUtilNow(){
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT DATE(tmp) as time_tools, SEC_TO_TIME(SUM(TIME_TO_SEC(durasi))) as total_durasi_tools, TIME_FORMAT(SEC_TO_TIME( SUM(time_to_sec(durasi))), '%H.%i') AS t_tools
    FROM tb_durasi
    WHERE status LIKE '%Tools Setup%' AND DATE(tmp) = DATE(CURRENT_TIMESTAMP)
    GROUP BY DATE(tmp)");
    return $result; 
}


?>


