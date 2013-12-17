<?php
include 'connect.php';

echo '
	<head>
		<link rel="stylesheet" href="stylePrint.css" type="text/css">
	</head>';

if($_SESSION['signed_in'] && $_SESSION['user_level'] == 1){
	$sql = "SELECT  site_user,
					site_name,
					site_study,
					site_user
			FROM sites
			WHERE site_id = " . mysql_real_escape_string($_GET['site']);
	
	$result = mysql_query($sql);

	while($row = mysql_fetch_array($result))
	{
		echo '<h3>Site: ' . $row['site_name'] . ' Study: ' . $row['site_study'] . '</h3>';
	
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
				echo 'You have not created any record in this Site.<br>';
				echo '<a href="create_patient.php">Create one now</a>';
				
			}
			else
			{		
			
				echo '<table border="1">
					  <tr>
						<th>PT #</th>
						<th>Date Contacted</th>
						<th>Subject #</th>
						<th>PT Initial</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Phone</th>
						<th>First Att</th>
						<th>Second Att</th>
						<th>Third Att</th>
						<th>Date Screened</th>
						<th>Showed</th>
						<th>Comment</th>
						<th>Date of Enrolled</th>
						<th>Date of Screen Fail</th>
						<th>Fail Criteria</th>
						<th>Have Consent</th>
					  </tr>';
					  
				while($rowP = mysql_fetch_assoc($resultP))
				{
					
					if($_GET['site'] == $rowP['patient_site'])
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
						echo '>';
						
						echo '<td><a href="patient.php?pat=' . $rowP['patient_id'] . '&site=' . $rowP['patient_site'] . '">' . $rowP['patient_num'] . '</td>';
						echo '<td>' . $rowP['patient_dateContacted'] . '</td>';
						echo '<td>' . $rowP['patient_subjectNum'] . '</td>';
						echo '<td>' . $rowP['patient_initial'] . '</td>';
						echo '<td>' . $rowP['patient_fName'] . '</td>';
						echo '<td>' . $rowP['patient_lName'] . '</td>';
						echo '<td>' . $rowP['patient_phone'] . '</td>';
						echo '<td>' . $rowP['patient_firstAtt'] . '</td>';
						echo '<td>' . $rowP['patient_secondAtt'] . '</td>';
						echo '<td>' . $rowP['patient_thirdAtt'] . '</td>';
						echo '<td>' . $rowP['patient_dateScreened'] . '</td>';
						//echo '<td>' . $rowP['patient_show'] . '</td>';
						if($rowP['patient_show'] == "on")
						{
							echo '<td>Yes</td>';
						}
						else
						{
							echo '<td></td>';
						}
						
						
						echo '<td>' . $rowP['patient_comment'] . '</td>';
						echo '<td>' . $rowP['patient_dateEnroll'] . '</td>';
						echo '<td>' . $rowP['patient_dateScreeFail'] . '</td>';
						echo '<td>' . $rowP['patient_failCriteria'] . '</td>';
						//echo '<td>' . $rowP['patient_consent'] . '</td>';
						if($rowP['patient_consent'] == "on")
						{
							echo '<td>Yes</td>';
						}
						else
						{
							echo '<td></td>';
						}
						echo '</tr>';
					}
				}
				
				echo '</table>';
				
			}
		}
	}

}
else{
	echo 'You must be signed in to view this page';
}

?>