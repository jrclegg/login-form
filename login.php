<link rel="stylesheet" type="text/css" href="style.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

<?php

session_start();

// Create database connection

$mysql_connection = new mysqli("localhost", "root", "root", "login_system");

// Create database connection 

if($mysql_connection -> connect_error) {
	die("Connection failed: " . $mysql_connection -> connect_error);
}

if ($_POST) {
	//check form submitted
	// if yes then start processing form data

	// populate variables from post data
	$Email = $_POST['Email'];
	$Password = $_POST['Password'];

	if (($Email) AND ($Password)) {
		//check to see if they have provided an email and password
			// check to see if email exists in the database
			$query = "SELECT * FROM login_system WHERE Email = '$Email' AND Password = '$Password'";

			$result = mysqli_query($mysql_connection, $query);

			if($result) {

				//check that the query ran successfully
				if(mysqli_num_rows($result) == 1) { // check what the function requires ($result)
					//check that query added a row and that we changed 1 or more rows of data
					$row = mysqli_fetch_assoc($result); 
						if ($row['account_activated'] == 1) {
							// the account has been activated
							if ($_POST['Password'] == $row['password']) {						
								echo "You have successfully logged in";
								// start session 

								$_SESSION['logged_in'] = 'YES';

								// send to account page

								header("Location: http://scotchbox/login-system-again/account.php");

								exit;
							} 
							else {
								echo "Password not activated";								
							}
						} else {
							echo "You have already activated your account";
						}
				} elseif(mysqli_num_rows($result) == 0) {
					echo "No rows found";
				} else {
					echo "More than one row found";
				}
			} else {
				echo "Query did not run";
			} 
	} else{
		echo "You need to provide a valid email address and password";
	}
} 

?>

<div class="container-fluid col-xs-4 col-md-6">
	<h1>Login</h1>

	<form action = "login.php" method="post">
		<p>Email:*</p><input type="text" name="Email">
		<p>Password:*</p><input type="password" name="Password">
		<br><br><button class="login-button btn btn-default" type="submit" >Login</button> <a class="forgot-link" href="http://scotchbox/login-system-again/forgot-password.php">Forgot Password?</a>
	</form>
	
</div>