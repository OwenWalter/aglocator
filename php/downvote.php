<?php
//require_once '/path/to/database/configfile/db.php';    //Refer to db.php-example
require_once 'db.php';

$sigid = $_POST['sigid'];

if (!empty($sigid)) {

$sql = "UPDATE live_table
SET uservote = uservote - 1
WHERE id = $sigid";

if (mysqli_query($test_db, $sql)) {
    echo "Downvoted Signature";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($test_db);
}

mysqli_close($test_db);
}

else {
echo 'No Signature Selected';
}

?>
