<?php
//create_cat.php
include 'connect.php';
include 'header.php';

if(!$_SESSION['signed_in']){
	echo 'You must be Signed in to view posts';
}
else
{
	$sql = "SELECT 
				site_name, 
				site_study,
				site_user, 
				site_address, 
				site_phone, 
				site_fax, 
				site_id
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
			echo '<table border="1">
				  <tr>
					<th>Name</th>
					<th>Study</th>
					<th>Address</th>
					<th>Phone</th>
					<th>Fax</th>
				  </tr>';
				  
			while($row = mysql_fetch_assoc($result))
			{
				echo '<tr>';
				if($_SESSION['user_level'] == 1 || $row['site_user'] == $_SESSION['user_id'])
				{
					//Try with divs in roder to highlight the entire row
				
					echo '<td><a href="site.php?id=' . $row['site_id'] . '">' . $row['site_name'] . '</a></td>';
					echo '<td>' . $row['site_study'] . '</td>';
					echo '<td>' . $row['site_address'] . '</td>';
					echo '<td>' . $row['site_phone'] . '</td>';
					echo '<td>' . $row['site_fax'] . '</td>';
				}
				echo '</tr>';
			}
			echo '</table>';
			
			if($_SESSION['user_level'] == 1)
			{
				echo '<a href="printReport.php" >Print Report</a>';
			
			}
		}
	}
}

include 'footer.php';
?>
