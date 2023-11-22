<?php
include 'function.php';

// $lastStatus = lastStatus();
// foreach($lastStatus as $a){
//     $l =  $a['status'];
// }
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
    <h1>Status Terbaru:</h1>
    <div id="lastStatus"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function loadData() {
            $.ajax({
                url: 'pages/card/card.php',
                type: 'GET',
                dataType: 'text',
                success: function(data) {
                    $('#lastStatus').html(data);
                }
            });
        }

        setInterval(function() {
            loadData();
        }, 1000); 
    </script>
</body>

</html>


<!-- <!DOCTYPE html>
<html>
<head>
    <title>Auto Refresh Tag HTML</title>
</head>
<body>
    <h1>Status Terbaru:</h1>
    <div id="lastStatus"></div>
    <br>
    <div id="lastTmp"></div>

    <script>
        function loadData() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("lastStatus").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "read_data.php", true);
            xhttp.send();
        }

        function loadTmp() {
            var tmpp = new XMLHttpRequest();
            tmpp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("lastTmp").innerHTML = this.responseText;
                }
            };
            tmpp.open("GET", "read_data.php", true);
            tmpp.send();
        }



        setInterval(function() {
            loadTmp();
        }, 5000);
    </script>
</body>
</html> -->