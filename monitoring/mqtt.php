<?php
session_start();
if(isset($_SESSION['sendmqtt'])){
    header("Location: index.php");
}


require('assets/mqtt/phpMQTT.php');
require 'function.php';
// Buat koneksi MQTT
$server = 'localhost';     // change if necessary
$port = 1883;                     // change if necessary
$username = '';                   // set your username
$password = '';                   // set your password
$client_id = 'phpMQTT-publisher'; // make sure this is unique for connecting to sever - you could use uniqid()
$mqtt = new Bluerhinos\phpMQTT($server, $port, $client_id);


$query = mysqli_query($koneksi, "SELECT * FROM tb_form_plan ORDER BY id DESC LIMIT 1");
// var_dump($query);
while($result = mysqli_fetch_assoc($query)){
$machine_id = $result["machine_id"];
$work_identity = $result["work_identity"];
$job_id = $result['job_id'];
$operator_id = $result["operator_id"];
$standard_time = $result["standard_time"];

}
// var_dump($workorder);


// Buat array data JSON
$data = array(
// 'workorder' => array($workorder),
'machine_id' => array($machine_id),
'work_identity' => array($work_identity),
'job_id' => array($job_id),
// 'standard_time' => array($standard_time), 
'operator_id' => array($operator_id),
);
$json_data = json_encode($data);


// Publish data JSON
if ($mqtt->connect()) {
    $mqtt->publish("jobplan", $json_data, 0);
    $mqtt->close();
    header("Location: job_plan.php");
    // echo "Data JSON berhasil dipublish ke broker MQTT";
} else {
    echo "Koneksi ke broker MQTT gagal";
}

?>

