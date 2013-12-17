<?php 

session_start();

//connect.php

$server	    = 'localhost';
$username	= 'serverNAME'; //these have been over written must set-up a DB before going further
$password	= 'serverPASSWORD&';
$database	= 'databaseNAME';


if(!mysql_connect($server, $username, $password))

{

 	exit('Error: could not establish database connection');

}

if(!mysql_select_db($database))

{

 	exit('Error: could not select the database');

}

?>
