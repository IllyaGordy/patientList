<?php
//signup.php
include 'connect.php';
include 'header.php';

echo '<script>
		function validateFormOnSubmit(theForm) {
			var reason = "";
			
				reason += validateUsername(theForm.user_name);
				reason += validatePassword(theForm.user_pass);
				reason += validatePassword(theForm.user_pass_check);
				reason += validateEmail(theForm.user_email); 
				
				if (reason != "") {
					alert("Some fields need correction:\n" + reason);
					return false;
				}
				
				return true;
		}

		function trim(s)
		{
		  return s.replace(/^\s+|\s+$/, \'\');
		} 
		
		function validateEmail(fld) {
			var error="";
			var tfld = trim(fld.value);                        // value of field with whitespace trimmed off
			var emailFilter = /^[^@]+@[^@.]+\.[^@]*\w\w$/ ;
			var illegalChars= /[\(\)\<\>\,\;\:\\\"\[\]]/ ;
			
			if (fld.value == "") {
				fld.style.background = "Yellow";
				error = "You didn\'t enter an email address.\n";
			} else if (!emailFilter.test(tfld)) {              //test email for illegal characters
				fld.style.background = "Yellow";
				error = "Please enter a valid email address.\n";
			} else if (fld.value.match(illegalChars)) {
				fld.style.background = "Yellow";
				error = "The email address contains illegal characters.\n";
			} else {
				fld.style.background = "White";
			}
			return error;
		}

		function validateUsername(fld) {
			var error = "";
			var illegalChars = /\W/; // allow letters, numbers, and underscores
		 
			if (fld.value == "") {
				fld.style.background = "Yellow"; 
				error = "You didn\'t enter a username.\n";
			} else if ((fld.value.length < 5) || (fld.value.length > 15)) {
				fld.style.background = "Yellow"; 
				error = "The username is the wrong length.\n";
			} else if (illegalChars.test(fld.value)) {
				fld.style.background = "Yellow"; 
				error = "The username contains illegal characters.\n";
			} else {
				fld.style.background = "White";
			} 
			return error;
		}
		
		function validatePassword(fld) {
			var error = "";
			var illegalChars = /[\W_]/; // allow only letters and numbers 
		 
			if (fld.value == "") {
				fld.style.background = "Yellow";
				error = "You didn\'t enter a password.\n";
			} else if ((fld.value.length < 7) || (fld.value.length > 15)) {
				error = "The password is the wrong length. \n";
				fld.style.background = "Yellow";
			} else if (illegalChars.test(fld.value)) {
				error = "The password contains illegal characters.\n";
				fld.style.background = "Yellow";
			} else if (!((fld.value.search(/(a-z)+/)) && (fld.value.search(/(0-9)+/)))) {
				error = "The password must contain at least one numeral.\n";
				fld.style.background = "Yellow";
			} else {
				fld.style.background = "White";
			}
		   return error;
		}
</script>';




echo '<h3>Sign up</h3><br />';

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    /*the form hasn't been posted yet, display it
	  note that the action="" will cause the form to post to the same page it is on */
    echo '<form method="post" action="" onsubmit="return validateFormOnSubmit(this)" >
		<table style="width:300px" >
			<tr >
				<td>Username:</td>
				<td><input type="text" name="user_name" /></td>
			</tr>
			<tr >
				<td>Password:</td>
				<td><input type="password" name="user_pass"></td>
			</tr>
			<tr >
				<td>Password again:</td>
				<td><input type="password" name="user_pass_check"></td>
			</tr>
			<tr >
				<td>E-mail:</td>
				<td><input type="email" name="user_email"></td>
			</tr>
			<tr>
				<td><input type="submit" value="Add user" /></td>
			</tr>
		</table>
 	 </form>';
}
else
{
    /* so, the form has been posted, we'll process the data in three steps:
		1.	Check the data
		2.	Let the user refill the wrong fields (if necessary)
		3.	Save the data 
	*/
	$errors = array(); /* declare the array for later use */
	
	if(isset($_POST['user_name']))
	{
		//the user name exists
		if(!ctype_alnum($_POST['user_name']))
		{
			$errors[] = 'The username can only contain letters and digits.';
		}
		if(strlen($_POST['user_name']) > 30)
		{
			$errors[] = 'The username cannot be longer than 30 characters.';
		}
	}
	else
	{
		$errors[] = 'The username field must not be empty.';
	}
	
	
	if(isset($_POST['user_pass']))
	{
		if($_POST['user_pass'] != $_POST['user_pass_check'])
		{
			$errors[] = 'The two passwords did not match.';
		}
	}
	else
	{
		$errors[] = 'The password field cannot be empty.';
	}
	
	if(!empty($errors)) /*check for an empty array, if there are errors, they're in this array (note the ! operator)*/
	{
		echo 'Uh-oh.. a couple of fields are not filled in correctly..<br /><br />';
		echo '<ul>';
		foreach($errors as $key => $value) /* walk through the array so all the errors get displayed */
		{
			echo '<li>' . $value . '</li>'; /* this generates a nice error list */
		}
		echo '</ul>';
	}
	else
	{
		//the form has been posted without, so save it
		//notice the use of mysql_real_escape_string, keep everything safe!
		//also notice the sha1 function which hashes the password
		$sql = "INSERT INTO
					usersL(usersL_name, usersL_pass, usersL_email ,usersL_date, usersL_level)
				VALUES('" . mysql_real_escape_string($_POST['user_name']) . "',
					   '" . sha1($_POST['user_pass']) . "',
					   '" . mysql_real_escape_string($_POST['user_email']) . "',
						NOW(),
						0)";
						
		$result = mysql_query($sql);
		if(!$result)
		{
			//something went wrong, display the error
			echo 'Something went wrong while registering. Please try again later.';
			//echo mysql_error(); //debugging purposes, uncomment when needed
		}
		else
		{
			echo 'Succesfully registered a user. :-)';
			echo '<meta http-equiv="refresh" content="1; URL=index.php">';
		}
	}
}

include 'footer.php';
?>
