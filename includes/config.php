<?php
session_start();
function dbconnect(){
    $server = "localhost";
    $username = "arun_siddharth";
    $password = "3vXt73bGW7mEcGnI";
    $dbname = "";
    return mysqli_connect($server, $username, $password, $dbname);
}
?>