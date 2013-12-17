<?php
//category.php
include 'connect.php';
include 'header.php';

if($_SESSION['signed_in']){
	$sql = "SELECT  site_user
			FROM sites
			WHERE site_id = " . mysql_real_escape_string($_GET['id']);
	
	$result = mysql_query($sql);

	while($row = mysql_fetch_array($result))
	{
		if($_SESSION['user_level'] == 1 || $row['site_user'] == $_SESSION['user_id']){
			
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
						patient_site
					FROM
						patients";
		
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
				
					echo '<table border="1">
						  <tr>
						  	<th>Patient Number</th>
							<th>Date Contacted</th>
							<th>Subject Number</th>
							<th>Patient Initial</th>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Phone</th>
							<th>Latest Attempt</th>
							<th>Date Screened</th>
							<th>Showed</th>
							<th>Have Consent</th>
							<th>Date of Pass/Fail</th>
						  </tr>';
						  
					while($rowP = mysql_fetch_assoc($resultP))
					{
						
						if($_GET['id'] == $rowP['patient_site'])
						{
							echo '<tr';
							
							if($_SESSION['user_level'] == 1)
							{
								if($rowP['patient_status'] == "FOLLOWUP"){
									echo ' bgcolor="#FFFFFF" ';
								}
								else if($rowP['patient_status'] == "CONTACT"){
									echo ' bgcolor="#FFFB85" ';
								}
								else if($rowP['patient_status'] == "ENROLLED"){
									echo ' bgcolor="#32E352" ';
								}
								else if($rowP['patient_status'] == "FAILED"){
									echo ' bgcolor="#FFA6AF" ';
								}
								else
								{
									echo ' bgcolor="#FFFFFF" ';
								}
							}
							else{
								if($rowP['patient_status'] == "FOLLOWUP"){
									echo ' bgcolor="#0099FF" ';
								}
								else if($rowP['patient_status'] == "CONTACT"){
									echo ' bgcolor="#FFFB85" ';
								}
								else 
								{
									echo ' bgcolor="#FFFFFF" ';
								}
							}
							
							echo '>';
							
							echo '<td><a href="patient.php?pat=' . $rowP['patient_id'] . '&site=' . $rowP['patient_site'] . '">' . $rowP['patient_num'] . '</td>';
							echo '<td>' . $rowP['patient_dateContacted'] . '</td>';
							echo '<td>' . $rowP['patient_subjectNum'] . '</td>';
							echo '<td>' . $rowP['patient_initial'] . '</td>';
							echo '<td>' . $rowP['patient_fName'] . '</td>';
							echo '<td>' . $rowP['patient_lName'] . '</td>';
							echo '<td>' . $rowP['patient_phone'] . '</td>';
							
							if(($rowP['patient_firstAtt'] == "") && ($rowP['patient_secondAtt'] == "") && ($rowP['patient_thirdAtt'] == ""))
							{
								echo '<td>' . $rowP['patient_firstAtt'] . '</td>';
							}
							else if(!($rowP['patient_firstAtt'] == "") && ($rowP['patient_secondAtt'] == "") && ($rowP['patient_thirdAtt'] == ""))
							{
								echo '<td>First - ' . $rowP['patient_firstAtt'] . '</td>';
							}
							else if(!($rowP['patient_firstAtt'] == "") && !($rowP['patient_secondAtt'] == "") && ($rowP['patient_thirdAtt'] == ""))
							{
								echo '<td>Second - ' . $rowP['patient_secondAtt'] . '</td>';
							}
							else if(!($rowP['patient_firstAtt'] == "") && !($rowP['patient_secondAtt'] == "") && !($rowP['patient_thirdAtt'] == ""))
							{
								echo '<td>Third - ' . $rowP['patient_thirdAtt'] . '</td>';
							}
							else
							{
								echo '<td>Error</td>';
							}
							
							 
							
							//echo '<td>' . $rowP['patient_firstAtt'] . '</td>';
							//echo '<td>' . $rowP['patient_secondAtt'] . '</td>';
							//echo '<td>' . $rowP['patient_thirdAtt'] . '</td>';
							echo '<td>' . $rowP['patient_dateScreened'] . '</td>';
							echo '<td>' . $rowP['patient_show'] . '</td>';
							//echo '<td>' . $rowP['patient_comment'] . '</td>';
							//echo '<td>' . $rowP['patient_dateEnroll'] . '</td>';
							//echo '<td>' . $rowP['patient_dateScreeFail'] . '</td>';
							//echo '<td>' . $rowP['patient_failCriteria'] . '</td>';
							echo '<td>' . $rowP['patient_consent'] . '</td>';
							echo '<td>';
							if($rowP['patient_dateEnroll'] == "0000-00-00" && $rowP['patient_dateScreeFail'] == "0000-00-00")
							{
								echo '</td>';
							}
							else if($rowP['patient_dateEnroll'] != "0000-00-00" && $rowP['patient_dateScreeFail'] == "0000-00-00")
							{
								echo $rowP['patient_dateEnroll'] . '</td>';
							}
							else if($rowP['patient_dateEnroll'] == "0000-00-00" && $rowP['patient_dateScreeFail'] != "0000-00-00")
							{
								echo $rowP['patient_dateScreeFail'] . '</td>';
							}
							
							echo '</tr>';
						}
					}
					
					echo '</table>';
					
					if($_SESSION['user_level'] == 1)
					{
						echo '<a href="sitePrint.php?site=' . $_GET['id']. '" >Print Report</a>';
					
					}
					
				
				}
			}
			
			//echo 'Access Granted';
		}
		else
			echo 'Access to this page is denied';
	}

}
else{
	echo 'You must be signed in to view this page';
}

include 'footer.php';
?>