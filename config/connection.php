<?php
    function db_connect() {
     
        // Define connection as a static variable, to avoid connecting more than once
        static $connection;
     
        // Try and connect to the database, if a connection has not been established yet
        if(!isset($connection)) {
             // Load configuration as an array. Use the actual location of your configuration file
            $config = parse_ini_file(__DIR__.'/../config/config.ini'); 
        $connection = mysqli_connect('localhost',$config['username'],'',$config['dbname']);
        }
     
        // If connection was not successful, handle the error
        if($connection === false) {
            // Handle error - notify administrator, log to a file, show an error screen, etc.
            return mysqli_connect_error();
        }
        return $connection;
    }





function db_error() {
    $connection = db_connect();
    return mysqli_error($connection);




    function db_query($query) {
        // Connect to the database
        $connection = db_connect();
     
        // Query the database
        $result = mysqli_query($connection,$query);
     
        return $result;
    }

}
?>