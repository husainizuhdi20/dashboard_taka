<?php
require 'function.php';

// ambil nilai waktu saat ini dan waktu maksimum dari database
$sql = "SELECT *, tmp, TIME_TO_SEC(durasi) AS durasi_detik FROM tb_durasi ORDER BY id DESC LIMIT 1";
$result = $koneksi->query($sql);
$row = $result->fetch_assoc();

// kirim nilai waktu saat ini dan waktu maksimum dalam format JSON ke JavaScript
echo json_encode($row);

$koneksi->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>
<body>
    <div id="chart"></div>

    <script>
        // buat chart baru menggunakan ApexCharts
var chart = new ApexCharts(document.querySelector("#chart"), {
  series: [{
    name: 'Progress',
    data: [0]
  }],
  chart: {
    height: 350,
    type: 'bar',
    toolbar: {
      show: false
    }
  },
  plotOptions: {
    bar: {
      horizontal: true,
      dataLabels: {
        position: 'top'
      },
    }
  },
  dataLabels: {
    enabled: true,
    formatter: function(val) {
      return val.toFixed(2) + '%';
    },
    offsetY: -20,
    style: {
      fontSize: '12px',
      colors: ['#333']
    }
  },
  xaxis: {
    categories: ['Progress']
  },
  yaxis: {
    min: 0,
    max: 100,
    labels: {
      show: false
    }
  }
});

// update chart setiap 1 detik
setInterval(function() {
  // buat AJAX request ke file PHP untuk mendapatkan nilai waktu saat ini dan waktu maksimum dari database
  $.ajax({
    url: 'get_progress.php',
    type: 'POST',
    dataType: 'json',
    success: function(response) {
      // hitung persentase kemajuan
      var percent = response.tmp / response.durasi_detik * 100;

      // update data pada chart dengan nilai persentase kemajuan
      chart.updateSeries([{
        name: 'Progress',
        data: [percent]
      }]);
    }
  });
}, 1000);
// render chart
chart.render();

    </script>
    
</body>
</html>
