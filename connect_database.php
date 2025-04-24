<?php
/*
This file contains database connection configurationuser "root" and password ""
*/

define('DB_SERVER', 'localhost');/* localhost */ /* sql110.epizy.com */
define('DB_USERNAME', 'root');/* root */ 
define('DB_PASSWORD', '');/*  */ 
define('DB_NAME', 'wp_project');/* wp_project */ 

// $database - variable
$database = mysqli_connect("localhost", "root", "", "wp_project");

if (!$database) {
    die("Connection failed: " . mysqli_connect_error());
}


?>
