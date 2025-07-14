<?php
require_once 'db.php';
require_once 'authorkey-salts.php';

// Stop execution with a generic error message.
function fail_with_error($message = 'An unexpected error occurred. Please contact an administrator.') {
    exit($message);
}

// Get and validate the email from the form post.
$author_email = isset($_POST['email']) ? trim($_POST['email']) : '';
if (!filter_var($author_email, FILTER_VALIDATE_EMAIL)) {
    fail_with_error('Invalid email address provided. Please go back and enter a valid email.');
}

// Check if the email exists in the database using a prepared statement.
$stmt = $test_db->prepare("SELECT author_email FROM live_table WHERE author_email = ? LIMIT 1");
$stmt->bind_param("s", $author_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Email exists, so calculate the key.
    // Values for $Sugar, $Spice, and $EverythingNice come from authorkey-salts.php
    $parsley = $Sugar . $author_email . $Spice;
    $sage = hash('sha256', $parsley);
    $rosemary = $sage . $EverythingNice;
    $author_key = hash('crc32', $rosemary);

    // Prepare and send the email.
    $email_subject = "Your AG Locator Author Key";
    $email_body = "
    <html>
    <body>
        <p>Your requested author key is below. Use this key to update any entries you've created.</p>
        <br>
        <h3 style='font-family: monospace; background: #f0f0f0; padding: 10px; border-radius: 5px; display: inline-block;'>{$author_key}</h3>
        <br>
        <p>Thank you for helping maintain the AG Locator data!</p>
    </body>
    </html>";
    
    $email_headers = "MIME-Version: 1.0" . "\r\n";
    $email_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $email_headers .= 'From: <AGLocator@noreply.com>' . "\r\n";

    if (mail($author_email, $email_subject, $email_body, $email_headers)) {
        header("Location: ../success-key.html");
    } else {
        fail_with_error('Could not send the author key email. Please contact an administrator.');
    }
} else {
    // Email not found in the database.
    fail_with_error('The provided email address was not found in our records. Only registered authors can receive a key.');
}

$stmt->close();
$test_db->close();
?>
