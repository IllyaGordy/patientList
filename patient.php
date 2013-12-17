<?php
//create_topic.php
include 'connect.php';
include 'header.php';


echo '<script>
		function validateFormOnSubmitA(theForm) {
			var reason = "";
			
				reason += validateEmpty(theForm.patient_subjectNum);
				reason += validateEmpty(theForm.patient_initial);
				reason += validateName(theForm.patient_fName);
				reason += validateName(theForm.patient_lName);
				reason += validatePhone(theForm.patient_phone);
				reason += validateEnrollFail(theForm.patient_dateEnroll, theForm.patient_dateScreeFail);
				reason += validateAttempt(theForm.patient_thirdAtt, theForm.patient_secondAtt);  //Third not empty, but the second is
				reason += validateAttempt(theForm.patient_secondAtt, theForm.patient_firstAtt);  //second not empty, but the second is validateFailCriteria
				reason += validateFailCriteria(theForm.patient_dateScreeFail, theForm.patient_failCriteria); //If fail date selected then fill the fail criteira
				
				
				if (reason != "") {
					alert("Some fields need correction:\n" + reason);
					return false;
				}
				
				return true;
		}
		
		function validateFormOnSubmitU(theForm) {
			var reason = "";
			
				reason += validateEnrollFail(theForm.patient_dateEnroll, theForm.patient_dateScreeFail);
				reason += validateAttempt(theForm.patient_thirdAtt, theForm.patient_secondAtt);  //Third not empty, but the second is
				reason += validateAttempt(theForm.patient_secondAtt, theForm.patient_firstAtt);  //second not empty, but the second is validateFailCriteria
				reason += validateFailCriteria(theForm.patient_dateScreeFail, theForm.patient_failCriteria); //If fail date selected then fill the fail criteira
				
				
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
		
		
		function validateEnrollFail(fld, fld2) {
			var error = "";    
		
		   if (fld.value != "0000-00-00" && fld2.value != "0000-00-00") {
				error = "You can\'t have a patient that both failed and enrolled.\n";
				fld.style.background = "Yellow";
				fld2.style.background = "Yellow";
			} 
			return error;
		}
		
		function validateAttempt(fld, fld2) {
			var error = "";    
		
		   if (fld.value != "" && fld2.value == "") {
				error = "You have to fill out the previous attempt before you can fill the next one.\n";
				fld.style.background = "Yellow";
				fld2.style.background = "Yellow";
			} 
			return error;
		}
		
		function validateFailCriteria(fld, fld2) {
			var error = ""; 
		
		   if (fld.value != "0000-00-00" && fld2.value == "") {
				fld.style.background = "Yellow"; 
				fld2.style.background = "Yellow";
				error = "You must fill out the Failing Criteria.\n";
			}else if (fld.value == "0000-00-00" && fld2.value != "") {
				fld.style.background = "Yellow"; 
				fld2.style.background = "Yellow";
				error = "You must fill out the date of Screen Fail.\n";
			} else {
				fld.style.background = "White";
			} 
			return error;
		}
		
		
		
</script>';




echo '<h2>Patient Information</h2>';

if($_SESSION['signed_in']){
	$sql = "SELECT  site_user
			FROM sites
			WHERE site_id = " . mysql_real_escape_string($_GET['site']);
	
	$result = mysql_query($sql);
		
	
	while($row = mysql_fetch_array($result))
	{
		if($_SESSION['user_level'] == 1 || $row['site_user'] == $_SESSION['user_id'])
		{
			if($_SERVER['REQUEST_METHOD'] != 'POST')
			{
				
				$sqlNum = "SELECT
							patient_id
						FROM
							patients
						WHERE 
							patient_site = " . mysql_real_escape_string($_GET['site']);
							
				$resultNum = mysql_query($sqlNum);
				
				if(!$resultNum)
				{
					//the query failed, uh-oh :-(
					echo 'Error while selecting from database. Please try again later.';
				}
				else
				{
					$num_rowsShow = mysql_num_rows($resultNum);
				}
			
			
				$sqlP = "SELECT
							patient_id,
							patient_num,
							patient_dateContacted,
							patient_subjectNum,
							patient_initial,
							patient_fName,
							patient_lName,
							patient_phone,
							patient_firstAtt,
							patient_secondAtt,
							patient_thirdAtt,
							patient_dateScreened,
							patient_show,
							patient_comment,
							patient_dateEnroll,
							patient_dateScreeFail,
							patient_failCriteria,
							patient_consent,
							patient_status,
							patient_site,
							patient_PDFform
						FROM
							patients
						WHERE 
							patient_id = " . mysql_real_escape_string($_GET['pat']);
			
				$resultP = mysql_query($sqlP);
				
				if(!$resultP)
				{
					//the query failed, uh-oh :-(
					echo 'Error while selecting from database. Please try again later.';
				}
				else
				{
					if(mysql_num_rows($resultP) == 0)
					{
						if($_SESSION['user_level'] == 1)
						{
							echo 'You have not created any record in this Site.<br>';
							echo '<a href="create_patient.php">Create one now</a>';
						}
						else
						{
							echo 'There are now records in this site';
						}
					}
					else
					{
						while($rowP = mysql_fetch_assoc($resultP))
						{
						/*
						*  Patient Table for Admins
						*  Allows to change all the Criteria
						*  
						*/
						
						
							if($_SESSION['user_level'] == 1)
							{
								
								
								echo '<h3>Viewing patient number ' . $rowP['patient_num'] . ' out of ' . $num_rowsShow . '.</h3>';
								
								echo '
								<form name="demo" method="post" action="" onsubmit="return validateFormOnSubmitA(this)" >
								<table border="1">
									<tr>
										<td>Patient Number: ' . $rowP['patient_num'] . '</td>
										<td>Date Contacted: <input type="text" name="patient_dateContacted" class="datepicker" value="' . $rowP['patient_dateContacted'] . '" "/></td>
									</tr>
									<tr>
										<td>Subject Number: <input type="text" name="patient_subjectNum" value="' . $rowP['patient_subjectNum'] . '"/></td>
										<td>Patient Initial: <input type="text" name="patient_initial" value="' . $rowP['patient_initial'] . '"/></td>
									</tr>
									<tr>
										<td>First Name: <input type="text" name="patient_fName" value="' . $rowP['patient_fName'] . '"/></td>
										<td>Last Name: <input type="text" name="patient_lName" value="' . $rowP['patient_lName'] . '"/></td>
									</tr>
									<tr>
										<td>Phone: <input type="text" name="patient_phone" value="' . $rowP['patient_phone'] . '"/></td>
										<td>First Attempt: 
											<select name="patient_firstAtt" >
												<option value""></option>
												<option value="VM"';
												if($rowP['patient_firstAtt'] == "VM"){ 
												echo ' selected ';
												}
												echo '>Voicemail</option>
												<option value="LM"';
												if($rowP['patient_firstAtt'] == "LM"){ 
												echo ' selected ';
												}
												echo '>Left Message</option>
												<option value="UM"';
												if($rowP['patient_firstAtt'] == "UM"){ 
												echo ' selected ';
												}
												echo '>Unable to Leave Message</option>
												<option value="BA"';
												if($rowP['patient_firstAtt'] == "BA"){ 
												echo ' selected ';
												}
												echo '>Booked Appointment</option>
												<option value="NA"';
												if($rowP['patient_firstAtt'] == "NA"){ 
												echo ' selected ';
												}
												echo '>Not Available for Study Dates</option>
												<option value="NE"';
												if($rowP['patient_firstAtt'] == "NE"){ 
												echo ' selected ';
												}
												echo '>Not Eligible for Study</option>
												<option value="NI"';
												if($rowP['patient_firstAtt'] == "NI"){ 
												echo ' selected ';
												}
												echo '>Not interested in study</option>
												<option value="OS"';
												if($rowP['patient_firstAtt'] == "OS"){ 
												echo ' selected ';
												}
												echo '>In Another Study</option>
												<option value="IS"';
												if($rowP['patient_firstAtt'] == "IS"){ 
												echo ' selected ';
												}
												echo '>Already In Study</option>
												<option value="WCB"';
												if($rowP['patient_firstAtt'] == "WCB"){ 
												echo ' selected ';
												}
												echo '>Subject Will Call Back</option>
												<option value="CB"';
												if($rowP['patient_firstAtt'] == "CB"){ 
												echo ' selected ';
												}
												echo '>We Have to Call Subject Back</option>
												<option value="DNC"';
												if($rowP['patient_firstAtt'] == "DNC"){ 
												echo ' selected ';
												}
												echo '>Do Not Contact for Any Studies</option>
											</select>
											</td>
									</tr>
									<tr>
										<td>Second Attempt: 
											<select name="patient_secondAtt" >
												<option value""></option>
												<option value="VM"';
												if($rowP['patient_secondAtt'] == "VM"){ 
												echo ' selected ';
												}
												echo '>Voicemail</option>
												<option value="LM"';
												if($rowP['patient_secondAtt'] == "LM"){ 
												echo ' selected ';
												}
												echo '>Left Message</option>
												<option value="UM"';
												if($rowP['patient_secondAtt'] == "UM"){ 
												echo ' selected ';
												}
												echo '>Unable to Leave Message</option>
												<option value="BA"';
												if($rowP['patient_secondAtt'] == "BA"){ 
												echo ' selected ';
												}
												echo '>Booked Appointment</option>
												<option value="NA"';
												if($rowP['patient_secondAtt'] == "NA"){ 
												echo ' selected ';
												}
												echo '>Not Available for Study Dates</option>
												<option value="NE"';
												if($rowP['patient_secondAtt'] == "NE"){ 
												echo ' selected ';
												}
												echo '>Not Eligible for Study</option>
												<option value="NI"';
												if($rowP['patient_secondAtt'] == "NI"){ 
												echo ' selected ';
												}
												echo '>Not interested in study</option>
												<option value="OS"';
												if($rowP['patient_secondAtt'] == "OS"){ 
												echo ' selected ';
												}
												echo '>In Another Study</option>
												<option value="IS"';
												if($rowP['patient_secondAtt'] == "IS"){ 
												echo ' selected ';
												}
												echo '>Already In Study</option>
												<option value="WCB"';
												if($rowP['patient_secondAtt'] == "WCB"){ 
												echo ' selected ';
												}
												echo '>Subject Will Call Back</option>
												<option value="CB"';
												if($rowP['patient_secondAtt'] == "CB"){ 
												echo ' selected ';
												}
												echo '>We Have to Call Subject Back</option>
												<option value="DNC"';
												if($rowP['patient_secondAtt'] == "DNC"){ 
												echo ' selected ';
												}
												echo '>Do Not Contact for Any Studies</option>
											</select>
											</td>
										<td>Third Attempt: 
											<select name="patient_thirdAtt" >
												<option value""></option>
												<option value="VM"';
												if($rowP['patient_thirdAtt'] == "VM"){ 
												echo ' selected ';
												}
												echo '>Voicemail</option>
												<option value="LM"';
												if($rowP['patient_thirdAtt'] == "LM"){ 
												echo ' selected ';
												}
												echo '>Left Message</option>
												<option value="UM"';
												if($rowP['patient_thirdAtt'] == "UM"){ 
												echo ' selected ';
												}
												echo '>Unable to Leave Message</option>
												<option value="BA"';
												if($rowP['patient_thirdAtt'] == "BA"){ 
												echo ' selected ';
												}
												echo '>Booked Appointment</option>
												<option value="NA"';
												if($rowP['patient_thirdAtt'] == "NA"){ 
												echo ' selected ';
												}
												echo '>Not Available for Study Dates</option>
												<option value="NE"';
												if($rowP['patient_thirdAtt'] == "NE"){ 
												echo ' selected ';
												}
												echo '>Not Eligible for Study</option>
												<option value="NI"';
												if($rowP['patient_thirdAtt'] == "NI"){ 
												echo ' selected ';
												}
												echo '>Not interested in study</option>
												<option value="OS"';
												if($rowP['patient_thirdAtt'] == "OS"){ 
												echo ' selected ';
												}
												echo '>In Another Study</option>
												<option value="IS"';
												if($rowP['patient_thirdAtt'] == "IS"){ 
												echo ' selected ';
												}
												echo '>Already In Study</option>
												<option value="WCB"';
												if($rowP['patient_thirdAtt'] == "WCB"){ 
												echo ' selected ';
												}
												echo '>Subject Will Call Back</option>
												<option value="CB"';
												if($rowP['patient_thirdAtt'] == "CB"){ 
												echo ' selected ';
												}
												echo '>We Have to Call Subject Back</option>
												<option value="DNC"';
												if($rowP['patient_thirdAtt'] == "DNC"){ 
												echo ' selected ';
												}
												echo '>Do Not Contact for Any Studies</option>
											</select>
											</td>
									</tr>
									<tr>
										<td>Date Screened: <input type="text" name="patient_dateScreened" class="datepicker" value="' . $rowP['patient_dateScreened'] . '"/></td>
										<td>Patient Showed Up: <input type="checkbox" name="patient_show"';
										if($rowP['patient_show'] == "on"){
											echo ' checked="checked" ';
										}
										else{
											echo ' ';
										}
										echo '/>
										</td>
									</tr>
									<tr>
										<td>Comment: <input type="text" name="patient_comment" value="' . $rowP['patient_comment'] . '"/></td>
										<td>Date Enrolled: <input type="text" name="patient_dateEnroll" class="datepicker" value="' . $rowP['patient_dateEnroll'] . '"/></td>
									</tr>
									<tr>
										<td>Date Screen Fail: <input type="text" name="patient_dateScreeFail" class="datepicker" value="' . $rowP['patient_dateScreeFail'] . '"/></td>
										<td>Failing Criteria: <input type="text" name="patient_failCriteria" value="' . $rowP['patient_failCriteria'] . '"/></td>
									</tr>
									<tr>
										<td>Have Consent: <input type="checkbox" name="patient_consent"';
										if($rowP['patient_consent'] == "on"){
											echo ' checked="checked" ';
										}
										else{
											echo ' ';
										}
										echo '/>
										</td>
										<td>Pre-Screen: <a href=upload.php?patient=' . $rowP[patient_id] . ' >View the PDF</a></td>
									</tr>
								</table>
								<input type="submit" name="next_no" value="Update Patient and Go Back to the List" />
								<input type="submit" name="next_yes" value="Update Patient and Go to Next Record" />
								</form>';
								echo '<br><br><a href=site.php?id=', $_GET['site'], ' >Got back to the List</a>';

								//echo '<br><br><a href=upload.php?patient=' . $rowP[patient_id] . ' >View the PDF</a>';
								
								
							
							}
							else if($_SESSION['user_level'] == 0)
							{
						
						
						/*
						*  Patient Table for Users
						*  Limited Ability to Change Criteria
						*  
						*/
						
								echo '<h3>Viewing patient number ' . $rowP['patient_num'] . ' out of ' . $num_rowsShow . '.</h3>';
								
								echo '
								<form method="post" action="" onsubmit="return validateFormOnSubmitU(this)" >
								<table border="1">
									<tr>
										<td>Patient Number: ' . $rowP['patient_num'] . '</td>
										<td>Date Contacted: ' . $rowP['patient_dateContacted'] . '</td>
									</tr>
									<tr>
										<td>Subject Number: ' . $rowP['patient_subjectNum'] . '</td>
										<td>Patient Initial: ' . $rowP['patient_initial'] . '</td>
									</tr>
									<tr>
										<td>First Name: ' . $rowP['patient_fName'] . '</td>
										<td>Last Name: ' . $rowP['patient_lName'] . '</td>
									</tr>
									<tr>
										<td>Phone: ' . $rowP['patient_phone'] . '</td>
										<td>First Attempt: 
											<select name="patient_firstAtt" >
												<option value""></option>
												<option value="VM"';
												if($rowP['patient_firstAtt'] == "VM"){ 
												echo ' selected ';
												}
												echo '>Voicemail</option>
												<option value="LM"';
												if($rowP['patient_firstAtt'] == "LM"){ 
												echo ' selected ';
												}
												echo '>Left Message</option>
												<option value="UM"';
												if($rowP['patient_firstAtt'] == "UM"){ 
												echo ' selected ';
												}
												echo '>Unable to Leave Message</option>
												<option value="BA"';
												if($rowP['patient_firstAtt'] == "BA"){ 
												echo ' selected ';
												}
												echo '>Booked Appointment</option>
												<option value="NA"';
												if($rowP['patient_firstAtt'] == "NA"){ 
												echo ' selected ';
												}
												echo '>Not Available for Study Dates</option>
												<option value="NE"';
												if($rowP['patient_firstAtt'] == "NE"){ 
												echo ' selected ';
												}
												echo '>Not Eligible for Study</option>
												<option value="NI"';
												if($rowP['patient_firstAtt'] == "NI"){ 
												echo ' selected ';
												}
												echo '>Not interested in study</option>
												<option value="OS"';
												if($rowP['patient_firstAtt'] == "OS"){ 
												echo ' selected ';
												}
												echo '>In Another Study</option>
												<option value="IS"';
												if($rowP['patient_firstAtt'] == "IS"){ 
												echo ' selected ';
												}
												echo '>Already In Study</option>
												<option value="WCB"';
												if($rowP['patient_firstAtt'] == "WCB"){ 
												echo ' selected ';
												}
												echo '>Subject Will Call Back</option>
												<option value="CB"';
												if($rowP['patient_firstAtt'] == "CB"){ 
												echo ' selected ';
												}
												echo '>We Have to Call Subject Back</option>
												<option value="DNC"';
												if($rowP['patient_firstAtt'] == "DNC"){ 
												echo ' selected ';
												}
												echo '>Do Not Contact for Any Studies</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Second Attempt: 
											<select name="patient_secondAtt" >
												<option value""></option>
												<option value="VM"';
												if($rowP['patient_secondAtt'] == "VM"){ 
												echo ' selected ';
												}
												echo '>Voicemail</option>
												<option value="LM"';
												if($rowP['patient_secondAtt'] == "LM"){ 
												echo ' selected ';
												}
												echo '>Left Message</option>
												<option value="UM"';
												if($rowP['patient_secondAtt'] == "UM"){ 
												echo ' selected ';
												}
												echo '>Unable to Leave Message</option>
												<option value="BA"';
												if($rowP['patient_secondAtt'] == "BA"){ 
												echo ' selected ';
												}
												echo '>Booked Appointment</option>
												<option value="NA"';
												if($rowP['patient_secondAtt'] == "NA"){ 
												echo ' selected ';
												}
												echo '>Not Available for Study Dates</option>
												<option value="NE"';
												if($rowP['patient_secondAtt'] == "NE"){ 
												echo ' selected ';
												}
												echo '>Not Eligible for Study</option>
												<option value="NI"';
												if($rowP['patient_secondAtt'] == "NI"){ 
												echo ' selected ';
												}
												echo '>Not interested in study</option>
												<option value="OS"';
												if($rowP['patient_secondAtt'] == "OS"){ 
												echo ' selected ';
												}
												echo '>In Another Study</option>
												<option value="IS"';
												if($rowP['patient_secondAtt'] == "IS"){ 
												echo ' selected ';
												}
												echo '>Already In Study</option>
												<option value="WCB"';
												if($rowP['patient_secondAtt'] == "WCB"){ 
												echo ' selected ';
												}
												echo '>Subject Will Call Back</option>
												<option value="CB"';
												if($rowP['patient_secondAtt'] == "CB"){ 
												echo ' selected ';
												}
												echo '>We Have to Call Subject Back</option>
												<option value="DNC"';
												if($rowP['patient_secondAtt'] == "DNC"){ 
												echo ' selected ';
												}
												echo '>Do Not Contact for Any Studies</option>
											</select>
											</td>
										<td>Third Attempt: 
											<select name="patient_thirdAtt" >
												<option value""></option>
												<option value="VM"';
												if($rowP['patient_thirdAtt'] == "VM"){ 
												echo ' selected ';
												}
												echo '>Voicemail</option>
												<option value="LM"';
												if($rowP['patient_thirdAtt'] == "LM"){ 
												echo ' selected ';
												}
												echo '>Left Message</option>
												<option value="UM"';
												if($rowP['patient_thirdAtt'] == "UM"){ 
												echo ' selected ';
												}
												echo '>Unable to Leave Message</option>
												<option value="BA"';
												if($rowP['patient_thirdAtt'] == "BA"){ 
												echo ' selected ';
												}
												echo '>Booked Appointment</option>
												<option value="NA"';
												if($rowP['patient_thirdAtt'] == "NA"){ 
												echo ' selected ';
												}
												echo '>Not Available for Study Dates</option>
												<option value="NE"';
												if($rowP['patient_thirdAtt'] == "NE"){ 
												echo ' selected ';
												}
												echo '>Not Eligible for Study</option>
												<option value="NI"';
												if($rowP['patient_thirdAtt'] == "NI"){ 
												echo ' selected ';
												}
												echo '>Not interested in study</option>
												<option value="OS"';
												if($rowP['patient_thirdAtt'] == "OS"){ 
												echo ' selected ';
												}
												echo '>In Another Study</option>
												<option value="IS"';
												if($rowP['patient_thirdAtt'] == "IS"){ 
												echo ' selected ';
												}
												echo '>Already In Study</option>
												<option value="WCB"';
												if($rowP['patient_thirdAtt'] == "WCB"){ 
												echo ' selected ';
												}
												echo '>Subject Will Call Back</option>
												<option value="CB"';
												if($rowP['patient_thirdAtt'] == "CB"){ 
												echo ' selected ';
												}
												echo '>We Have to Call Subject Back</option>
												<option value="DNC"';
												if($rowP['patient_thirdAtt'] == "DNC"){ 
												echo ' selected ';
												}
												echo '>Do Not Contact for Any Studies</option>
											</select>
											</td>
									</tr>
									<tr>
										<td>Date Screened: <input type="text" name="patient_dateScreened" class="datepicker" value="' . $rowP['patient_dateScreened'] . '"/></td>
										<td>Patient Showed Up: <input type="checkbox" name="patient_show"';
										if($rowP['patient_show'] == "on"){
											echo ' checked="checked" ';
										}
										else{
											echo ' ';
										}
										echo '/>
										</td>
									</tr>
									<tr>
										<td>Comment: <input type="text" name="patient_comment" value="' . $rowP['patient_comment'] . '"/></td>
										<td>Date Enrolled: <input type="text" name="patient_dateEnroll" class="datepicker" value="' . $rowP['patient_dateEnroll'] . '"/></td>
									</tr>
									<tr>
										<td>Date Screen Fail: <input type="text" name="patient_dateScreeFail" class="datepicker"  value="' . $rowP['patient_dateScreeFail'] . '"/></td>
										<td>Failing Criteria: <input type="text" name="patient_failCriteria" value="' . $rowP['patient_failCriteria'] . '"/></td>
									</tr>
									<tr>
										<td>Have Consent: <input type="checkbox" name="patient_consent"';
										if($rowP['patient_consent'] == "on"){
											echo ' checked="checked" ';
										}
										else{
											echo ' ';
										}
										echo '/>
										</td>
										<td>Pre-Screen: <a href=upload.php?patient=' . $rowP[patient_id] . ' >View the PDF</a></td>
									</tr>
								</table>
								<input type="submit" name="next_no" value="Update Patient" />
								<input type="submit" name="next_yes" value="Update Patient and Go to Next Record" />
								</form>';
								echo '<br><br><a href=site.php?id=', $_GET['site'], ' >Got back to the List</a>';
								
								
							}
							else
							{
								echo 'Error something went wrong';
							}
						
						
							
						}
					}
						/*
				*/
				}
				//echo 'Access granted';
				
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
					
					
					
					if(mysql_real_escape_string($_POST['patient_dateEnroll']) != "0000-00-00" && mysql_real_escape_string($_POST['patient_dateScreeFail']) == "0000-00-00")
					{
						$patient_statusU='ENROLLED';
					}
					else if(mysql_real_escape_string($_POST['patient_dateScreeFail']) != "0000-00-00" && mysql_real_escape_string($_POST['patient_dateEnroll']) == "0000-00-00")
					{
						$patient_statusU='FAILED';
					}
					else if(mysql_real_escape_string($_POST['patient_dateScreeFail']) != "0000-00-00" && mysql_real_escape_string($_POST['patient_dateEnroll']) != "0000-00-00")
					{
						$patient_statusU='ERROR';
					}
					else if(mysql_real_escape_string($_POST['patient_firstAtt']) != "")
					{
						$patient_statusU='FOLLOWUP';
					}
					else
					{
						$patient_statusU='CONTACT';
					}
					
					if($_SESSION['user_level'] == 1)
					{
						$sql = "UPDATE 
									patients
								SET
									patient_dateContacted='" . mysql_real_escape_string($_POST['patient_dateContacted']) . "',
									patient_subjectNum='" . mysql_real_escape_string($_POST['patient_subjectNum']) . "',
									patient_initial='" . mysql_real_escape_string($_POST['patient_initial']) . "',
									patient_fName='" . mysql_real_escape_string($_POST['patient_fName']) . "',
									patient_lName='" . mysql_real_escape_string($_POST['patient_lName']) . "',
									patient_phone='" . mysql_real_escape_string($_POST['patient_phone']) . "',
									patient_firstAtt='" . mysql_real_escape_string($_POST['patient_firstAtt']) . "',
									patient_secondAtt='" . mysql_real_escape_string($_POST['patient_secondAtt']) . "',
									patient_thirdAtt='" . mysql_real_escape_string($_POST['patient_thirdAtt']) . "',
									patient_dateScreened='" . mysql_real_escape_string($_POST['patient_dateScreened']) . "',
									patient_show='" . mysql_real_escape_string($_POST['patient_show']) . "',
									patient_comment='" . mysql_real_escape_string($_POST['patient_comment']) . "',
									patient_dateEnroll='" . mysql_real_escape_string($_POST['patient_dateEnroll']) . "',
									patient_dateScreeFail='" . mysql_real_escape_string($_POST['patient_dateScreeFail']) . "',
									patient_failCriteria='" . mysql_real_escape_string($_POST['patient_failCriteria']) . "',
									patient_consent='" . mysql_real_escape_string($_POST['patient_consent']) . "',
									patient_status='" . $patient_statusU . "'
								WHERE 
									patient_id = " . mysql_real_escape_string($_GET['pat']);
									
					}
					else
					{
						$sql = "UPDATE 
									patients
								SET
									patient_firstAtt='" . mysql_real_escape_string($_POST['patient_firstAtt']) . "',
									patient_secondAtt='" . mysql_real_escape_string($_POST['patient_secondAtt']) . "',
									patient_thirdAtt='" . mysql_real_escape_string($_POST['patient_thirdAtt']) . "',
									patient_dateScreened='" . mysql_real_escape_string($_POST['patient_dateScreened']) . "',
									patient_show='" . mysql_real_escape_string($_POST['patient_show']) . "',
									patient_comment='" . mysql_real_escape_string($_POST['patient_comment']) . "',
									patient_dateEnroll='" . mysql_real_escape_string($_POST['patient_dateEnroll']) . "',
									patient_dateScreeFail='" . mysql_real_escape_string($_POST['patient_dateScreeFail']) . "',
									patient_failCriteria='" . mysql_real_escape_string($_POST['patient_failCriteria']) . "',
									patient_consent='" . mysql_real_escape_string($_POST['patient_consent']) . "',
									patient_status='" . $patient_statusU . "'
								WHERE 
									patient_id = " . mysql_real_escape_string($_GET['pat']);
						
					
					
					}
								
					$result = mysql_query($sql);
					if(!$result)
					{
						//something went wrong, display the error
						echo 'An error occured while inserting your data. Please try again later.<br /><br />' . mysql_error();
					}
					else
					{
						echo 'You have succesfully created a new patient</a>.';
						
						if($_POST['next_no'])
						{
							echo '<meta http-equiv="refresh" content="1; URL=site.php?id=', $_GET['site'], '">';
						}
						else if($_POST['next_yes'])
						{
							$sqlN = "SELECT 
										patient_id,
										patient_num,
										patient_site
									FROM
										patients
									WHERE 
										patient_site = " . mysql_real_escape_string($_GET['site']);
							
							$resultN = mysql_query($sqlN);
							if(!$resultN)
							{
								//something went wrong, display the error
								echo 'An error occured while inserting your data. Please try again later.<br /><br />' . mysql_error();
							}
							else
							{
								$num_rowsN = mysql_num_rows($resultN);
							
							
								while($rowN = mysql_fetch_assoc($resultN))
								{
									if($rowN['patient_id'] == $_GET['pat'])
									{
										
										//echo '<br>';
										//echo $num_rowsN;
										//echo '<br>';
										
										if($rowN['patient_num'] < $num_rowsN)
										{
											$nextPat = $rowN['patient_num'] + 1;
											
											$sqlNext = "SELECT 
															patient_id,
															patient_num,
															patient_site
														FROM
															patients
														WHERE 
															patients.patient_num  = " . $nextPat . "
															AND patients.patient_site = " . mysql_real_escape_string($_GET['site']);
															
															
											$resultNext = mysql_query($sqlNext);
											if(!$resultNext)
											{
												//something went wrong, display the error
												echo 'An error occured while inserting your data. Please try again later.<br /><br />' . mysql_error();
											}
											else
											{
												while($rowNext = mysql_fetch_assoc($resultNext))
												{
													$next = $rowNext['patient_id'];
													//echo $next;
												}
											
											}
										
										}
										else
										{
											echo 'This is the last Patient!';
										}
									}
								}
							}
							
							if($next != "")
							{
								echo '<meta http-equiv="refresh" content="1; URL=patient.php?pat=', $next;
								
								echo '&site=', $_GET['site'], '">';
							}
							else
							{
								echo '<meta http-equiv="refresh" content="1; URL=site.php?id=', $_GET['site'], '">';
							}
							
							
							
						}
							
						
					
					}
			
				}
			
			
			}
			
		}
		else
		{
		
			echo 'No Access';
			
		}
		
	}
	
}

include 'footer.php';
?>
