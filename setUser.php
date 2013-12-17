<?php
//create_topic.php
include 'connect.php';
include 'header.php';

echo '<h2>Set Users to Sites</h2>';
if($_SESSION['signed_in'] == false | $_SESSION['user_level'] != 1 )
{
	//the user is not an admin
	echo 'Sorry, you do not have sufficient rights to access this page.';
}
else
{

	//the user is signed in
	if($_SERVER['REQUEST_METHOD'] != 'POST')
	{
		
		//Set up the Site
		$sql = "SELECT
					site_id,
					site_name,
					site_study
				FROM
					sites";
		
		$result = mysql_query($sql);
		
		//Set us the User
		$sql1 = "SELECT
					usersL_id,
					usersL_name,
					usersL_level
				FROM
					usersL";
		
		$result1 = mysql_query($sql1);
		
		
		if(!$result && !$result1)
		{
			//the query failed, uh-oh :-(
			echo 'Error while selecting from database. Please try again later.';
		}
		
		else
		{
			if(mysql_num_rows($result) == 0)
			{
				//There are no Sites Yet
				echo 'You have not created any sites yet.';
			}
			else if(mysql_num_rows($result1) == 0)
			{
				//There are no User Yet
				echo 'There are no Users';
			
			}
			else
			{
				echo '<form method="post" action="">';
				echo '
					<table style="width:300px" >
						<tr >
							<td>Site:</td>';
		
				echo '<td><select name="site_val">';
					while($row = mysql_fetch_assoc($result))
					{
						echo '<option value="' . $row['site_id'] . '">Site: '  . $row['site_name'] . ' Study: ' . $row['site_study'] .'</option>';
					}
				echo '</select></td></tr>
					<tr >
						<td>User: </td>';	
					
				echo '<td><select name="usersL_val">';
					while($row = mysql_fetch_assoc($result1))
					{
						if($row['usersL_level'] != 1)
						{
							echo '<option value="' . $row['usersL_id'] . '">'  . $row['usersL_name'] . '</option>';
						}
							
					}
				echo '</select></td></tr>';
					
				echo '<tr ><td><input type="submit" value="Set User" /></tr></td>
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
		else{
		
		
		
			//the form has been posted, so save it
			//insert the topic into the topics table first, then we'll save the post into the posts table
			$sql = "UPDATE sites
						SET site_user='" . mysql_real_escape_string($_POST['usersL_val']) . "'
						WHERE site_id='" . mysql_real_escape_string($_POST['site_val']) . "'";
					 
			$result = mysql_query($sql);
			if(!$result)
			{
				//something went wrong, display the error
				echo 'An error occured';
			}
			
			else
			{
				$sql = "COMMIT;";
				$result = mysql_query($sql);
				echo 'User has been Set';
				echo '<meta http-equiv="refresh" content="1; URL=index.php">';
			}
		
		}
		
		
		
	}
		
		
}

include 'footer.php';
?>
