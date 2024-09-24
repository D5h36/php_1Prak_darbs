<?php 
session_start(); 
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "praktiskais_darbs";
    
    
    $connect = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

    if (!$connect) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>