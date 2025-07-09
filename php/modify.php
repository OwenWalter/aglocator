<?php
//require_once '/path/to/database/configfile/db.php';    //Refer to db.php-example
require_once 'db.php';
//require_once '/path/to/file/containing/secrets/authorkey-salts.php';    //Refer to authorkey-salts.php-example
require_once 'authorkey-salts.php';

$submitbutton = mysqli_real_escape_string($test_db, $_POST['submit']); //will either be "Save Modified Entry" or "Delete Entry From Database"
$id = mysqli_real_escape_string($test_db, $_POST['id']);
$authorkey = mysqli_real_escape_string($test_db, $_POST['authorkey']);
$entry_keyword = mysqli_real_escape_string($test_db, $_POST['entry_keyword']);
$entry_category = mysqli_real_escape_string($test_db, $_POST['entry_category']);
$entry_subcat = mysqli_real_escape_string($test_db, $_POST['entry_subcat']);
$entry_special = mysqli_real_escape_string($test_db, $_POST['entry_special']);
$assign_group = mysqli_real_escape_string($test_db, $_POST['assign_group']);
$notes = mysqli_real_escape_string($test_db, $_POST['notes']);
$pri_consult = mysqli_real_escape_string($test_db, $_POST['pri_consult']);
$bak_consult = mysqli_real_escape_string($test_db, $_POST['bak_consult']);
$manager = mysqli_real_escape_string($test_db, $_POST['manager']);
$updated_authoremail = mysqli_real_escape_string($test_db, $_POST['updated_authoremail']);

if (strlen(trim($entry_keyword))<=0 || strlen(trim($entry_special))<=0 || strlen(trim($assign_group))<=0 || strlen(trim($updated_authoremail))<=0 || strlen(trim($authorkey))<=0 || strlen(trim($id))<=0 ) {//verify required user-input fields have more than just whitespace characters

echo "Error: Invalid input detected. <br><br> Keyword, Assignment Group, and Author Email address cannot be blank or contain only whitespace characters. The author key is always required. <br> Please press the back button and edit the entry to contain proper input.";

}

else {
	//Pull the author email for the selected entry ID from the database, didn't pass the version provided by user via HTML POST due to manual-edit/injection risk
	//Would be nice to not have to query the DB again but this seems like the most secure method
        $query = "SELECT author_email FROM live_table WHERE id = '".$id."';";
        //echo $query; //DEBUG
        $result = $test_db->query($query);
        while($results = $result->fetch_array()) {
                $result_array[] = $results;
        }
        // Check for and display results
        if (isset($result_array)) {
                foreach ($result_array as $result) {
                // Output strings and highlight the matches
                 $d_authoremail = htmlspecialchars($result['author_email']);
		}
	}

	//Determine the author's unique keycode based on their email.
        //Values for $Sugar, $Spice, and $EverythingNice come from authorkey-salts.php file (loaded at the top of this program)

        $parsley = $Sugar . $d_authoremail . $Spice;
        $sage = hash('sha256', $parsley);
        $rosemary = $sage . $EverythingNice;
        $thyme = hash('crc32', $rosemary);

	if ($authorkey == $thyme && "$submitbutton" == 'Save Modified Entry') {
		//do update
		$sql = "UPDATE live_table
			SET entry_keyword = '$entry_keyword', entry_category= '$entry_category', entry_subcategory= '$entry_subcat', entry_special= '$entry_special', assign_group = '$assign_group', notes = '$notes', pri_consult = '$pri_consult', bak_consult = '$bak_consult', manager = '$manager', author_email = '$updated_authoremail', updt_time = NOW()
			WHERE id = '$id'";
		if (mysqli_query($test_db, $sql)) {
		    header("Location: ../success-mod.html");
	}
	}
	elseif ($authorkey == $thyme && "$submitbutton" == 'Delete Entry From Database') {
		//do delete
               $sql = "DELETE FROM live_table
                        WHERE id = '$id'";
                if (mysqli_query($test_db, $sql)) {
                   header("Location: ../success-del.html");
	}
	}
	 else { //report userkey incorrect
		
		//echo "SQL Error: " . $sql . "<br>" . mysqli_error($test_db); //use to debug sql
		//echo "Entered Key: $authorkey"; //DEBUG ONLY
		//echo "Calculated Key: $thyme"; // DEBUG ONLY
		//echo $submitbutton; // DEBUG ONLY
	      echo "The provided author key is incorrect for this signature.";

	}

	} 

mysqli_close($test_db);

?>
