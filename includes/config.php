<?php
    session_start();
    function dbconnect(){
        $server = "localhost";
        $username = "arun_siddharth";
        $password = "3vXt73bGW7mEcGnI";
        $dbname = "project1";
        return mysqli_connect($server, $username, $password, $dbname);
    }
    function redirect($location)
    {
        if (headers_sent($file, $line))
        {
            trigger_error("HTTP headers already sent at {$file}:{$line}", E_USER_ERROR);
        }
        header("Location: {$location}");
        exit;
    }
?>