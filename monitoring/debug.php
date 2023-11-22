<?php
require 'function.php';

// Last Status
$lastStatus = lastStatus();
// Mengecek hasil query
if ($lastStatus->num_rows > 0) {
    foreach($lastStatus as $a){
        $l =  $a['status'];
    }
} else {
    $l = "Tidak ada data ";
}

echo $l;

?>