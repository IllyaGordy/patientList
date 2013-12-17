<?php
// ==============
// Configuration
// ==============

// Where you want the files to upload to
//Important: Make sure this folders permissions (CHMOD) is 0777!

// ==============
// Upload Part
// ==============

if($_SERVER['REQUEST_METHOD'] != 'POST')
{

	echo '<form action=”” method=”post” ENCTYPE=”multipart/form-data”>
	
	File: <input type=”file” name=”file” size=”30″>
	
	<input type=”submit” value=”Upload!”>
	
	</form>';

}

else
{
	$uploaddir = "uploads";
	
	if(is_uploaded_file($_FILES['file']['tmp_name']))
	{
		move_uploaded_file($_FILES['file']['tmp_name'],$uploaddir.'/'.$_FILES['file']['name']);
	}
	print "Your file has been uploaded successfully! Yay!";

}
?>
