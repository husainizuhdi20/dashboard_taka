<?php
session_start();

unset($_SESSION['mesin']);
header("Location: ../machine_option.php");

?>