<?php
//create_topic.php
include 'connect.php';
include 'header.php';
include 'randomNum.php';

echo '<h2>Patient PDF Pre-Screen Form</h2>';

if($_SESSION['signed_in'])
{
	if($_SESSION['user_level'] == 1)
	{
	/*
	*
	* ADMIN page
	*
	*/
		if($_SERVER['REQUEST_METHOD'] != 'POST')
		{
			$sqlP = "SELECT 
						patient_id,
						patient_PDFform
					FROM 
						patients
					WHERE
						patient_id = " . mysql_real_escape_string($_GET['patient']);
						
			$resultP = mysql_query($sqlP);
					
			if(!$resultP)
			{
				//the query failed, uh-oh :-(
				echo 'Error while selecting from database. Please try again later.';
			}
			else
			{
				while($rowP = mysql_fetch_assoc($resultP))
				{
					echo 'Upload New PDF Pre-Screen Form<br />
						<form enctype="multipart/form-data" action="upload.php" method="POST">
						 Please choose a file: <input name="uploaded" type="file" /><br />
						 <input type="hidden" name="patient" value="' . $_GET['patient'] . '" />
						 <input type="submit" value="Upload" />
						 </form>
						 ';
				
					if($rowP['patient_PDFform'] == "")
					{
						echo 'There is no pre-screen form for this user';
						
					}
					else
					{
						echo '<br />
						 <br />
						 <iframe src="uploadFiles/' . $rowP['patient_PDFform'] . '.pdf" width="800px" height="1100px">
						  <p>Your browser does not support iframes.</p>
						</iframe>';
					
					}
				
				}
			}
		}
		else
		{
			$pnum = $_REQUEST["patient"];
			
			$URLrandom = get_rand_id(10);
			
			$target = "uploadFiles/"; 
			$target = $target . $URLrandom . '.pdf' ; 
			
			if (!($uploaded_type === "application/pdf")) {
				echo "You may only upload PDF files.<br>";
				$ok=0;
			} 
			else{
				$ok=1;
			}
			if($ok==1 && move_uploaded_file($_FILES['uploaded']['tmp_name'], $target)) 
			{
				echo "The file has been uploaded <br />";
				echo 'You can view the file <a href="' . $target . '">here</a>';
				
				
				$sql = "UPDATE 
							patients
						SET
							patient_PDFform='" . $URLrandom . "'
						WHERE 
							patient_id='" . $pnum . "'";
							
							
							
				$resultN = mysql_query($sql);
				if(!$resultN)
				{
					//something went wrong, display the error
					echo 'An error occured while inserting your data. Please try again later.<br /><br />' . mysql_error();
				}
				else
				{
					echo '<meta http-equiv="refresh" content="2; URL=upload.php?patient=' . $pnum . '" >';					
				}
				
				
				
				
			} 
			else {
				echo "Sorry, there was a problem uploading your file.";
			} 
		}
	}
	else
	{
	/*
	*
	* USER page
	*
	*/
		$sqlP = "SELECT 
					patient_id,
					patient_PDFform
				FROM 
					patients
				WHERE
					patient_id = " . mysql_real_escape_string($_GET['patient']);
					
		$resultP = mysql_query($sqlP);
				
		if(!$resultP)
		{
			//the query failed, uh-oh :-(
			echo 'Error while selecting from database. Please try again later.';
		}
		else
		{
			while($rowP = mysql_fetch_assoc($resultP))
			{
				if($rowP['patient_PDFform'] == "")
				{
					echo 'There is no pre-screen form for this user';
				}
				else
				{
					echo '<iframe src="uploadFiles/' . $rowP['patient_PDFform'] . '.pdf" width="800px" height="1100px">
					  <p>Your browser does not support iframes.</p>
					</iframe>';
				
				}
			}
		}
	}
}
else
{
	echo 'Sorry you must be signed into view this page';
}





include 'footer.php';
?>