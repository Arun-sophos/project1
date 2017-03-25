<?php
function dbconnect(){
    $server = "localhost";
    $username = "";
    $password = "";
    $dbname = "";
    return mysqli_connect($server, $username, $password, $dbname);
}
?>