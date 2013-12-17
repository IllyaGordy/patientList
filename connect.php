<?php 

session_start();

//connect.php
/*
$server	    = 'mysql1009.ixwebhosting.com';

$username	= 'C315316_forum';

$password	= 'Ccct123';

$database	= 'C315316_forum';
*/


$server	    = 'localhost';
$username	= 'illyagor_pUpdate';
$password	= 'Ccct123&';
$database	= 'illyagor_patientUpdate';


if(!mysql_connect($server, $username, $password))

{

 	exit('Error: could not establish database connection');

}

if(!mysql_select_db($database))

{

 	exit('Error: could not select the database');

}

?>