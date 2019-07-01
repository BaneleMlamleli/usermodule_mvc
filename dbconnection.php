<?php
    //20190614 - Created projectFunction.php - Banele
    //20190614 - Added an alert pop-up message instead of a console printout when there is a successful or unsuccessful database connection - Banele

    include_once('projectFunction.php');

    $serverName = "";
    $username = "";
    $password = "";
    $dbName = "";


    switch($_SERVER["SERVER_NAME"]){
        case "localhost":
            $serverName = "localhost";
            $username = "root";
            $password = "";
            $dbName = "usermodule";
            break;

        case "lamp":
            $serverName = "lamp";
            $username = "root";
            $password = "123ert";
            $dbName = "usermodule";
            break; 
    }

    // Create connection
    $conn = new mysqli($serverName, $username, $password, $dbName);

    // Check connection
    if ($conn->connect_error) {
        //20190616 - Added an alert pop-up message instead of a console printout for an unsuccessful database connection- Banele
        echo "<script type=text/javascript>alert('Database Connection failed')</script>";
        die($conn->connect_error);
    } 
    //20190614 - Added an alert pop-up message instead of a console printout for a successful database connection- Banele
    //echo "<script type=text/javascript>alert('Database Connected successfully')</script>";
?>