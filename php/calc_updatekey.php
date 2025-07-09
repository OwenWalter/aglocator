<?php
//require_once '/path/to/database/configfile/db.php';    //Refer to db.php-example
require_once 'db.php';
//require_once '/path/to/file/containing/secrets/authorkey-salts.php';    //Refer to authorkey-salts.php-example
require_once 'authorkey-salts.php';

$authoremail = $_POST['author_email'];

if (!empty($authoremail)) {

$sql = "SELECT author_email FROM live_table
WHERE author_email = '$authoremail'";

if (mysqli_query($test_db, $sql)) { //check database for user email, and only if it exists (returns a result), calculate the keycode
	$result = (mysqli_query($test_db, $sql));
        //echo $result; //DEBUG
	if (mysqli_num_rows($result) > 0) {
		//Make the user's unique update keycode based on their email.
                //Values for $Sugar, $Spice, and $EverythingNice come from authorkey-salts.php file (loaded at the top of this program)
	        $parsley = $Sugar . $authoremail . $Spice;
	        $sage = hash('sha256', $parsley);
	        $rosemary = $sage . $EverythingNice;
	        $thyme = hash('crc32', $rosemary);
        	
		//echo "Update Keycode: " . $thyme;	//DEBUG USE ONLY, DO NOT UNCOMMENT
		
		//Pass the sugar
		$email_subject = "AG Locator Author Key Request";
		$email_message = "
		<html>
		<head>
		<title>AG Locator on Toothless - Author Key Request</title>
		</head>
		<body>
		<p>The following author key can be used to update any entries on the AG Locator tool created by the author (email address) where this message was sent:<p>
		<br>
		<b><h3>$thyme</h3></b>
		<br>
		<p>Thanks for helping maintain the AG Locator data!</p>
		<br>
		<br>
		<p align=\"right\"><small><i>Questions? Please <a href=\"http://toothless.unx.sas.com/cheatsheet/help.html\" target=\"_blank\">contact the AG Locator team</a>.</i></small></p>
		</body>
		</html>
		";
		$email_headers = "MIME-Version: 1.0" . "\r\n";
		$email_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$email_headers .= 'From: <replies-disabled@toothless.unx.sas.com>' . "\r\n";
		mail($authoremail,$email_subject,$email_message,$email_headers); //sends email using PHP internal mail function
		header("Location: ../success-key.html");
	} else {
		echo "Provided email address was not found. Please contact andy.foreman@sas.com for assistance.";
		mysqli_close($test_db);
		exit(1);
	}
} else {
    	echo "Error: " . $sql . "<br>" . mysqli_error($test_db);
}

mysqli_close($test_db);
}

else {
echo 'An error has ocurred. Please contact andy.foreman@sas.com for assistance.';
}

?>
