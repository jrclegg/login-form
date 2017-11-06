<?php

$mysql_connection = new mysqli("localhost", "root", "root", "login_system");
// Opens a new connection to the MySQL server

if($mysql_connection -> connect_error) {
	die("Connection failed: " . $mysql_connection -> connect_error);
	// Check database connection 
}

if ($_GET){
	// Gets code data from activate URL on link

	$code = $_GET['code'];
	// Retrieves the code from the URL

	$query = "SELECT * FROM login_system WHERE activation_code = '$code'";
	// Check that we have a record with that activation code by reading from the database

	if ($result = mysqli_query($mysql_connection, $query)) {
		// run the query 

		if (mysqli_num_rows($result) == 1) {
			// Gets the number of rows inside the result
			
			$row = mysqli_fetch_assoc($result);
			// Fetches a result row as an associative array

			if ($row['account_activated'] == 1) {
				// Check the account isnt already activated
				echo "You have already activated your account<br><br>"; 

				echo '<a href="http://scotchbox/login-system-again/login.php">Click to go to the Login Page</a>';

			} else {
				// Now we activate the account
				$query = "UPDATE login_system SET account_activated = 1 WHERE id = ".$row['id'];
	    		// change the account activated field in the database to 1, for that user

	    		$result = mysqli_query($mysql_connection, $query);
	    		// run the query

	    		if($result) {
					// check that the query ran successfully
					//check query added a row
					if(mysqli_affected_rows($mysql_connection) == 1){
						// and we changed 1 or more rows of data

	    				echo '<h2>Success! Your account has been activated!<h2>';

	    				echo '<a href="http://scotchbox/login-system-again/login.php">Click to go to the Login Page</a>';

	    			} else {
	    				echo "Error";
	    			}
	    		}
	    		else{
	    			echo "The query did not run";

	    		}
			}
		} else {
			echo "No num rows";
		}
	} 
	 else {
		// query didn't run okay
		echo "Query did not run";
	}

}

?>