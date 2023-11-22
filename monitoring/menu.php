<?php
// Inisialisasi session
session_start();
// session_destroy();

// Cek apakah mesin telah dipilih
if(isset($_POST['mesin'])) {
  // Simpan nama mesin yang dipilih ke session
  $_SESSION['mesin'] = $_POST['mesin'];
}

// Cek apakah session mesin telah diset
if(isset($_SESSION['mesin'])) {
  // Jika session mesin telah diset, arahkan ke dashboard utama mesin yang dipilih
  header("Location: index.php?mesin=".$_SESSION['mesin']);
  exit();
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
    <!-- Tampilan menu list nama mesin -->
<form method="post">
    <select name="mesin">
        <option value="">Pilih mesin</option>
        <option value="mesin1">Mesin 1</option>
        <option value="mesin2">Mesin 2</option>
        <option value="mesin3">Mesin 3</option>
    </select>
    <button type="submit">Pilih</button>
</form> 
</body>
</html>