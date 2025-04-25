<?php

$server = "localhost";
$user = "root";
$password = "";
$db = "cpc_app";
$conn = mysqli_connect($server, $user, $password, $db);

if(mysqli_connect_errno()){
    echo mysqli_connect_errno();
}

?>