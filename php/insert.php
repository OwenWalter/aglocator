<html>
<body>
<?php
//require_once '/path/to/database/configfile/db.php';    //Refer to db.php-example
session_start();

require_once 'db.php';

$entry_keyword = mysqli_real_escape_string($test_db, $_POST['entry_keyword']);
$entry_category = mysqli_real_escape_string($test_db, $_POST['entry_category']);
$entry_subcat = mysqli_real_escape_string($test_db, $_POST['entry_subcat']);
$entry_special = mysqli_real_escape_string($test_db, $_POST['entry_special']);
$assigngroup = mysqli_real_escape_string($test_db, $_POST['assign_group']);
$priconsult = mysqli_real_escape_string($test_db, $_POST['pri_consult']);
$bakconsult = mysqli_real_escape_string($test_db, $_POST['bak_consult']);
$manager = mysqli_real_escape_string($test_db, $_POST['manager']);
$notes = mysqli_real_escape_string($test_db, $_POST['notes']);
$new_authoremail = mysqli_real_escape_string($test_db, $_POST['new_authoremail']);

if (strlen(trim($entry_keyword))<=0 || strlen(trim($assigngroup))<=0 || strlen(trim($new_authoremail))<=0 ) {	//verify required fields have input other than just whitespace characters

echo "Error: Invalid input detected. <br><br> Keyword and Assignment Group fields cannot be blank or contain only whitespace characters. An author email address must be provided. <br> Please press the back button and edit the entry to contain proper input.";

}

else {

//insert fields from escaped strings of form POST
//orig_datasrc is hard-coded to 'appuser' because this is the form that is used by application users to make NEW entries. Any entries created this way are originally sourced from an app user.
$sql = "INSERT INTO live_table (entry_keyword, entry_category, entry_subcategory, entry_special, assign_group, pri_consult, bak_consult, manager, notes, orig_datasrc, author_email)
VALUES ('$entry_keyword', '$entry_category', '$entry_subcat', '$entry_special', '$assigngroup', '$priconsult', '$bakconsult', '$manager', '$notes', 'appuser', '$new_authoremail')";

if (mysqli_query($test_db, $sql)) {
    header("Location: ../success-add.html");
} else {
    echo "SQL Error: " . $sql . "<br>" . mysqli_error($test_db);
}

}

mysqli_close($test_db);

?>
</body>
</html>
