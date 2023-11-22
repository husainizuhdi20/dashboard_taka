<?php
require 'function.php';
if(isset($_POST['submitJob']) ) {
  
    if(tambah($_POST) > 0) {
        echo 
        // "<script>
		// 	setTimeout(function() {
		// 		sendBroker();
		// 	}, 5000); // 5000 milidetik = 5 detik
        //     header('Location: mqtt.php');
	    // </script>";
        require('assets/mqtt/phpMQTT.php');
        $server = 'localhost';     // change if necessary
        $port = 1883;                     // change if necessary
        $username = '';                   // set your username
        $password = '';                   // set your password
        $client_id = 'phpMQTT-publisher'; // make sure this is unique for connecting to sever - you could use uniqid()
        $mqtt = new Bluerhinos\phpMQTT($server, $port, $client_id);


        $query = mysqli_query($koneksi, "SELECT * FROM tb_form_plan ORDER BY id DESC LIMIT 1");
        // var_dump($query);
        while($result = mysqli_fetch_assoc($query)){
        $workorder = $result["wo_id"];
        $optid = $result["opt_id"];
        $jobname = $result["job_name"];
        $jobid = $result['job_id'];
        }
        // var_dump($workorder);


        // Buat array data JSON
        $data = array(
        'workorder' => array($workorder),
        'jobname' => array($jobname), 
        'operatorid' => array($optid),
        'jobid' => array($jobid)
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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    
</head>
<body>
    <form class="forms-sample" action="" method="POST">
        <div class="form-group">
        <label>Machine Option</label>
        <select class="form-control" name="machine_id" style="width:100%">
            <option >Choose a Machine</option>  
            <option >Lathe</option>
            <option >Milling</option>
            <option >Honning</option>
        </select>
        </div>
        <div class="form-group">
        <label for="exampleInputEmail1">Work Order Id</label>
        <input type="text" class="form-control" name="wo_id" id="exampleInputEmail1" placeholder="Input Workorder" autocomplete="off">
        </div>
        <div class="form-group">
        <label for="jobid">Job Id</label>
        <input type="text" class="form-control" name="job_id" id="jobid" placeholder="Input job id" autocomplete="off">
        </div>
        <div class="form-group">
        <label for="exampleInputPassword1">Operator Id</label>
        <input type="text" class="form-control" name="opt_id" id="exampleInputPassword1" placeholder="Input Operator" autocomplete="off">
        </div>
        <div id="form-inputs">
        <div class="form-group row" >
            <div class="col">
            <label>Job Name</label>
            <div id="the-basics">
                <input class="typeahead" type="text" name="job_name" placeholder="Input job name">
            </div>
            </div>
            <div class="col">
            <label>Time Plan</label>
                <div id="bloodhound">
                <input class="typeahead" type="text" name="time_plan" placeholder="Input time plan">
                </div>
            </div>
        </div>
        </div>
        
        
        <button type="submit" name="submitJob" class="btn btn-primary mr-2">Submit</button>
        <!-- <button type="button" onclick="addInput()" class="btn btn-dark">Add Job</button> -->
        <!-- <a type="submit" href="mqtt.php" class="btn btn-success mr-2">Send to operator</a> -->
    </form>



    <button onclick="insertDatabase()">Start Program 1 dan 2</button>

    <script>
		function insertDatabase() {
			// kode program insert
			// alert("Program 1 dijalankan!");
			// set timer untuk menjalankan program 2

			setTimeout(function() {
				sendBroker();
			}, 5000); // 5000 milidetik = 5 detik
		}

		function sendBroker() {
			// kode program send broker
			alert("Program 2 dijalankan!");
		}
	</script>
</body>
</html>
