<link rel="stylesheet" type="text/css" href="style.css">
<!-- Link to stylesheet -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
<!-- Link to Bootstrap -->

<?php

$mysql_connection = new mysqli("localhost", "root", "root", "login_system");
// Opens a new connection to the MySQL server, server = localhost, username = root, password = root, database = login_system
// $mysql_connection is the variable that represents the connection

if ($mysql_connection -> connect_error) {
	die("Connection failed: " . $mysql_connection -> connect_error);
	//If database connection fails show an error message
}

if ($_POST) {
	// Post is used to submit the user entered information to register an account
	// If the form has been submitted process form data

	$Email = $_POST['Email'];
	$Password =$_POST['Password'];
	// Store Email and Password user inputted data in variables

	if (($Email) AND ($Password)) {
		// Check to see if the user has provided an Email and a Password

		if (filter_var($Email, FILTER_VALIDATE_EMAIL)) {
			// Use filter var to check if the email is valid
			
			if (password_strong($Password)) {
				// Use the function "password_strong" to evaluate if the password matches strength parameters

				$code = rand(5000, 200);
				// Create a unique activation code as we will put it in the database AND put it in the email

				$sql = "INSERT INTO login_system (email, password, activation_code) 
				VALUES ('$Email', '$Password', '$code');";
				// create an INSERT SQL query that populates the login_system rows with the user entered values stored inside the variables

				$result = mysqli_query($mysql_connection, $sql);
				// performs a query against the MySQL database

				if ($result) {
					//Check that the result ran successfully
					if (mysqli_affected_rows($mysql_connection) > 0) {
						// Checks that we affected at least one row of data. 0 would indicate no rows were updated

						$headers = "From: Dev Me <team@example.com\r\n";
						$headers.= "Reply-To: Help <help@example.com\>r/n";
						$headers.= "MIME-Version: 1.0\r\n";
						$headers.= "Content-Type: text/html;\r\n";

						$link = "http://scotchbox/login-system-again/activate.php?code=". $code;
			
						$subject = "Registration Confirmation";

						$message = '<p>You\'ve just created an account, please click on the link below to activate your account</p>';
						$message .= "<a href=" .$link. "> click here to activate account</a>";

						// create $headers, $link, $subject and $message variables (in html) to be used in the mail()function below

						if (mail($Email, $subject, $message, $headers)){
							// check that the email sent
							// use the mail() function to send the email
							
							echo "Success! You have created an account!";

							header("Location: http://scotchbox/login-system-again/login.php");

						} else {
							echo "Unsuccessful, please try again!";
						}

					} else if (mysqli_affected_rows($mysql_connection) < 0) {
						echo "Query returned an error";
					}

				} else {
					echo "Error! Query did not run";
				}
			} 
		} 
		  else {
			echo "You need to provide a valid email address";
		}	
	} 
	else {
		echo "You need to provide a valid Email address and a Password";
	}

}

?>


<div class="container-fluid col-xs-4 col-md-6">
	<h1 class="register-title">Register</h1>

	<form class="register-form" action="register.php" method="post">
		<p>Email:*</p><input type="text" name="Email">
		<p>Password:*</p><input type="password" name="Password">
		<br><br><button class="register-button btn btn-default" type="submit" >Create Account</button>
	</form>
</div>
<?php
function password_strong($Password) {
	if ( (preg_match("/[A-Z]/", $Password) == 1) AND 
		 (preg_match("/[a-z]/", $Password) == 1) AND
		 (preg_match("/[0-9]/", $Password) == 1) AND
		 (strlen($Password) > 7)) {
		// pregmatch performs a regular expression match
		// strlen returns the length of the given string

		return true;
	} else {  
		echo "Password must be at least 7 characters long and contain at least one lowercase letter, one uppercase letter and one number";	
	}
}
?>
