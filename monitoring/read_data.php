<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "digitalisasi_bubut";

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mengambil data terbaru dari tabel status
$sql = "SELECT * FROM tb_status WHERE value = 1 ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

// Mengecek hasil query
if ($result->num_rows > 0) {
    // Mengambil data dari query dan mengembalikan hasil dalam bentuk string
    $row = $result->fetch_assoc();
    echo $row["status"];
} else {
    echo "Tidak ada data";
}

// Menutup koneksi
$conn->close();
?>




