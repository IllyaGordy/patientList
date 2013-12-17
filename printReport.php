<?php
include 'connect.php';
//include 'header.php';

echo '
	<head>
		<link rel="stylesheet" href="stylePrint.css" type="text/css">
	</head>';

if(!$_SESSION['signed_in'] || $_SESSION['user_level'] != 1)
{
	echo 'You must be an admin in to view this page';
}
else
{
	if($_SERVER['REQUEST_METHOD'] != 'POST')
	{


		$sql = "SELECT 
					site_id,
					site_name, 
					site_study
				FROM 
					sites";
		
		$result = mysql_query($sql);
		
		if(!$result)
		{
			echo 'The categories could not be displayed, please try again later.';
		}
		else
		{
			if(mysql_num_rows($result) == 0)
			{
				echo 'No categories defined yet.';
			}
			else
			{
				echo '<form method="post" action="">';
				echo '<table style="width:400px;">';
				
				while($row = mysql_fetch_assoc($result))
				{
					echo '<tr>';
					echo '<td><input type="checkbox" name="' . $row['site_id'] . '" value="Selected" /></td>';
					echo '<td>Site: ' . $row['site_name'] . ' Study: ' . $row['site_study'] . '.</td>';
					echo '</tr>';
				}
				echo '
				<tr><td colspan="2" style="border:none;" ><input type="submit" value="View Report" align="left" /></td></tr>
				</table>';
			
			
			
			}
		}
	}
	else
	{
		$sql = "SELECT  
					site_id,
					site_user,
					site_name,
					site_study,
					site_user
			FROM sites";
	
		$result = mysql_query($sql);
	
		while($row = mysql_fetch_array($result))
		{
			$site = $row['site_id'];
			if($_POST[$site] == "Selected")
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
					patients
				WHERE 
					patient_site = " . $row['site_id'];
	
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
							
							if($row['site_id'] == $rowP['patient_site'])
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
	
	
	}

}



//include 'footer.php';
?>