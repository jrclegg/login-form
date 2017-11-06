<?php

session_start();

if ($_SESSION['logged_in'] = 'YES') {
	
	echo "Welcome to your account!";
} else {

	echo "Session could not be started";

}

?>