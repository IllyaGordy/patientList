<?php
//create_site.php
include 'connect.php';
include 'header.php';


echo '<script>
		function validateFormOnSubmit(theForm) {
			var reason = "";
			
				reason += validateEmpty(theForm.site_name);
				reason += validateEmpty(theForm.site_study);
				reason += validateEmpty(theForm.site_address);
				reason += validatePhone(theForm.site_phone); 
				
				if (reason != "") {
					alert("Some fields need correction:\n" + reason);
					return false;
				}
				
				return true;
		}

		function validateEmpty(fld) {
			var error = "";
		  
			if (fld.value.length == 0) {
				fld.style.background = "Yellow"; 
				error = "The required field has not been filled in.\n"
			} else {
				fld.style.background = "White";
			}
			
			return error;  
		}

		function validatePhone(fld) {
			var error = "";
			var stripped = fld.value.replace(/[\(\)\.\-\ ]/g, \'\');     
		
		   if (fld.value == "") {
				error = "You didn\'t enter a phone number.\n";
				fld.style.background = "Yellow";
			} else if (isNaN(parseInt(stripped))) {
				error = "The phone number contains illegal characters.\n";
				fld.style.background = "Yellow";
			} else if (!(stripped.length == 10)) {
				error = "The phone number is the wrong length. Make sure you included an area code.\n";
				fld.style.background = "Yellow";
			} 
			return error;
		}
</script>';








echo '<h2>Create a site</h2>';
if($_SESSION['signed_in'] == false | $_SESSION['user_level'] != 1 )
{
	//the user is not an admin
	echo 'Sorry, you do not have sufficient rights to access this page.';
}
else
{
	//the user has admin rights
	if($_SERVER['REQUEST_METHOD'] != 'POST')
	{
		//the form hasn't been posted yet, display it
		echo '<form method="post" action="" onsubmit="return validateFormOnSubmit(this)" >
			<table style="width:300px" >
				<tr >
					<td>Site name:</td>
					<td><input length="30" type="text" name="site_name" /></td>
				</tr>
				<tr>
					<td>Site study: </td>
					<td><input type="text" name="site_study" /></td>
				</tr>
				<tr>
					<td>Site address: </td>
					<td><input type="text" name="site_address" /></td>
				</tr>
				<tr>
					<td>Site phone: </td>
					<td><input type="text" name="site_phone" /></td>
				</tr>
				<tr>
					<td>Site fax: </td>
					<td><input type="text" name="site_fax" /></td>
				</tr>
				<tr>
					<td><input type="submit" value="Add Site" /></td>
				</tr>
			</table>
		 </form>';
	}
	else
	{
		//the form has been posted, so save it
		$sql = "INSERT INTO sites(site_name, site_study, site_address, site_phone, site_fax)
		   VALUES('" . mysql_real_escape_string($_POST['site_name']) . "',
				 '" . mysql_real_escape_string($_POST['site_study']) . "',
				 '" . mysql_real_escape_string($_POST['site_address']) . "',
				 '" . mysql_real_escape_string($_POST['site_phone']) . "',
				 '" . mysql_real_escape_string($_POST['site_fax']) . "')";
		$result = mysql_query($sql);
		if(!$result)
		{
			//something went wrong, display the error
			echo 'Error:  ' . mysql_error();
		}
		else
		{
			echo 'New category succesfully added.';
			echo '<meta http-equiv="refresh" content="1; URL=index.php">';
		}
	}
}

include 'footer.php';
?>
