<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="nl" lang="nl">
<head>
 	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 	<meta name="description" content="A short description." />
 	<meta name="keywords" content="clinical, trials, canada" />
 	<title>Patient Update Site</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    
	<link rel="stylesheet" href="css/redmond/jquery-ui-1.8.20.custom.css">
    <script src="js/jquery-1.7.2.min.js"></script>
	<script src="js/jquery-ui-1.8.20.custom.min.js"></script>

    <script>
	
		$(function() {
			$( '.datepicker' ).datepicker(
				{dateFormat: 'yy-mm-dd'}
			);
		});
	</script>
    
    
	
    
</head>
<body>
<h1>Patient Update Site</h1>
	<div id="wrapper">
	<div id="menu">
    	<table style="border:none; margin-top:-4px;" >
        	<tr>
            
				<?php
                if($_SESSION['signed_in'])
                {
                    if($_SESSION['user_level'] == 1)
                    {
                        echo '<td><a class="item" href="index.php">Home</a> - ';
                        echo '<a class="item" href="create_site.php">Create a site</a> - ';
                        echo '<a class="item" href="create_patient.php">Create a new patient</a> - ';
                        echo '<a class="item" href="setUser.php">Set User</a></td>';
                        echo '<td width="150" ></td>';
                        echo '<td>Hello <b>' . htmlentities($_SESSION['user_name']) . '</b>. Not you? <a class="item" href="signout.php">Sign out</a> or <a class="item" href="signup.php">create an account</a></td>';
                    }
                    else
                    {
                        echo '<td><a class="item" href="index.php" >Home</a></td>';
                        echo '<td width="600" ></td>';
                        echo '<td>Hello <b>' . htmlentities($_SESSION['user_name']) . '</b>. Not you? <a class="item" href="signout.php">Sign out</a></td>';
                    }
                    
                }
                else
                {
                    echo '<td><a class="item" href="index.php" >Home</a></td>';
					echo '<td width="600" ></td>';
                    echo '<td><a class="item" href="signin.php" id="signinID" >Sign in</a></td>';
                    
                }
                ?>
            	</tr>
            </table>
	</div>
		<div id="content">