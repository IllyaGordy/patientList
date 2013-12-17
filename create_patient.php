<?php
//create_topic.php
include 'connect.php';
include 'header.php';
include 'randomNum.php';


echo '<script>
		function validateFormOnSubmit(theForm) {
			var reason = "";
			
				reason += validateEmpty(theForm.patient_subjectNum);
				reason += validateEmpty(theForm.patient_initial);
				reason += validateName(theForm.patient_fName);
				reason += validateName(theForm.patient_lName);
				reason += validatePhone(theForm.patient_phone);  
				
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

		function validateName(fld) {
			var error = "";
			var illegalChars = /\W/;   
		
		   if (fld.value == "") {
				fld.style.background = "Yellow"; 
				error = "You didn\'t enter a name.\n";
			}else if (illegalChars.test(fld.value)) {
				fld.style.background = "Yellow"; 
				error = "The name contains illegal characters.\n";
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


echo '<h2>Create a new Patient</h2>';

if($_SESSION['signed_in'] == false || !($_SESSION['user_level'] == 1))
{
	//the user is not signed in
	echo 'You do not have sufficient priviliges to access this page.';
}

else
{
	if($_SERVER['REQUEST_METHOD'] != 'POST')
	{
		
		//Set up the Site
		$sqlS = "SELECT
					site_id,
					site_name,
					site_study
				FROM
					sites";
		
		$resultS = mysql_query($sqlS);
		
		if(!$resultS)
		{
			//the query failed, uh-oh :-(
			echo 'Error while selecting from database. Please try again later.';
		}
		
		else
		{
			if(mysql_num_rows($resultS) == 0)
			{
				//There are no Sites Yet
				echo 'You have not created any sites yet.';
			}
			else
			{
				
				echo '<form method="POST" enctype="multipart/form-data" action="create_patient.php" onsubmit="return validateFormOnSubmit(this)" >
				
				<table style="width:500px" >
				<tr >
					<td>Site:</td>
					<td>'; 
				
				echo '<select name="patient_site">';
					while($rowS = mysql_fetch_assoc($resultS))
					{
						echo '<option value="' . $rowS['site_id'] . '">Site: '  . $rowS['site_name'] . ' Study: ' . $rowS['site_study'] .'</option>';
					}
				echo '</select></td></tr>';
				
				echo '
				<tr>
					<td>Date Fax/Email Sent:</td>
					<td><input type="text" name="patient_dateContacted" class="datepicker" /></td>
				</tr>
				<tr>
					<td>Subject Number:</td>
					<td><input type="text" name="patient_subjectNum" /></td>
				</tr>
				<tr>
					<td>Patient Initials:</td>
					<td><input type="text" name="patient_initial" /></td>
				</tr>
				<tr>
					<td>First Name:</td>
					<td><input type="text" name="patient_fName" /></td>
				</tr>
				<tr>
					<td>Last Name:</td>
					<td><input type="text" name="patient_lName" /></td>
				</tr>
				<tr>
					<td>Phone Number:</td>
					<td><input type="text" name="patient_phone" /></td>
				</tr>
				<tr>
					<td>Choose a Pre-Screen From(PDF):</td>
					<td><input name="uploaded" type="file" /></td>
				</tr>
				
				<tr>
					<td><input type="submit" value="Create new Patient" /></td>
				</tr>
				</table>
				 </form>';
				 
			}
		}
	}
	else
	{
		//start the transaction
		$query  = "BEGIN WORK;";
		$result = mysql_query($query);
		
		
		if(!$result)
		{
			//Damn! the query failed, quit
			echo 'An error occured while creating your topic. Please try again later.';
		}
		else
		{
		
			//the form has been posted, so save it
			//insert the topic into the topics table first, then we'll save the post into the posts table
			$sqlP = "SELECT  patient_num
				FROM patients
				WHERE patient_site = " . mysql_real_escape_string($_POST['patient_site']);
			
			$resultP = mysql_query($sqlP);
			
			
			if(!$resultP)
			{
				//something went wrong, display the error
				echo 'An error occured while inserting your data. Please try again later.<br /><br />' . mysql_error();
			}
			else
			{
				
				
				$pNum = 1;
				while($row = mysql_fetch_array($resultP))
				{
					for($i = 0; $i <= mysql_num_rows($resultP); $i++)
					{
						$pNum = $i + 1;
					}
				}
			
				$URLrandom = get_rand_id(10);
				
				$target = "uploadFiles/"; 
				$target = $target . $URLrandom . '.pdf' ; 
				
			
				if (!($uploaded_type === "application/pdf")) {
					echo "You may only upload PDF files.<br>";
					echo '<meta http-equiv="refresh" content="2;" ';
					$ok=0;
				}
				else{
					$ok=1;
				}
				if($ok==1 && move_uploaded_file($_FILES['uploaded']['tmp_name'], $target)) 
				{
					$URLvalue = $URLrandom;
					
					$sql = "INSERT INTO 
								patients(patient_num,
									   patient_dateContacted,
									   patient_subjectNum,
									   patient_initial,
									   patient_fName,
									   patient_lName,
									   patient_phone,
									   patient_status,
									   patient_site,
									   patient_PDFform)
						   VALUES('" . $pNum . "',
										'" . mysql_real_escape_string($_POST['patient_dateContacted']) . "',
										'" . mysql_real_escape_string($_POST['patient_subjectNum']) . "',
										'" . mysql_real_escape_string($_POST['patient_initial']) . "',
										'" . mysql_real_escape_string($_POST['patient_fName']) . "',
										'" . mysql_real_escape_string($_POST['patient_lName']) . "',
										'" . mysql_real_escape_string($_POST['patient_phone']) . "',
										'CONTACT',
										'" . mysql_real_escape_string($_POST['patient_site']) . "',
										'" . mysql_real_escape_string($URLvalue) . "'
										)";
							 
					$result = mysql_query($sql);
					if(!$result)
					{
						//something went wrong, display the error
						echo 'An error occured while inserting your data. Please try again later.<br /><br />' . mysql_error();
						$sql = "ROLLBACK;";
						$result = mysql_query($sql);
					}
					else
					{
						echo 'You have succesfully created a new patient</a>.';
							
						echo '<meta http-equiv="refresh" content="1; URL=index.php">';
					
					}
				}
			
			}
		
		}
	}

}

include 'footer.php';
?>
