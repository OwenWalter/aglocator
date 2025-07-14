<?php
require_once 'db.php';
require_once 'authorkey-salts.php';

// Fetches the original author's email for a given entry ID.
function get_original_author_email($db, $entry_id) {
    $stmt = $db->prepare("SELECT author_email FROM live_table WHERE id = ?");
    $stmt->bind_param("i", $entry_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        return $result->fetch_assoc()['author_email'];
    }
    return null;
}

// Validates the provided author key against the original author's email.
function is_author_key_valid($original_email, $provided_key) {
    global $Sugar, $Spice, $EverythingNice;
    $parsley = $Sugar . $original_email . $Spice;
    $sage = hash('sha256', $parsley);
    $rosemary = $sage . $EverythingNice;
    $thyme = hash('crc32', $rosemary);
    return $provided_key === $thyme;
}

// Stop execution with an error message.
function fail_with_error($message) {
    exit("Error: " . $message);
}

// --- Main Logic ---

$entry_id = isset($_POST['entry_id']) ? (int)$_POST['entry_id'] : 0;
$author_email = isset($_POST['author_email']) ? trim($_POST['author_email']) : '';

if ($entry_id <= 0 || empty($author_email)) {
    fail_with_error("Invalid entry data provided.");
}

// For both update and delete, we need the original author's email to validate the key.
// Note: The form on modifycontent.php should ask for the key, not the email again.
// This example assumes a key is passed. If not, the is_author_key_valid needs the user-entered key.
// Let's assume the key is passed from a field named 'author_key'.
$author_key = isset($_POST['author_key']) ? trim($_POST['author_key']) : '';
if (empty($author_key)) {
	// This part needs a form field in modifycontent.php named 'author_key'
    fail_with_error("Author key is required to modify or delete an entry.");
}


$original_author_email = get_original_author_email($test_db, $entry_id);

if (!$original_author_email || !is_author_key_valid($original_author_email, $author_key)) {
    fail_with_error("The provided author key is incorrect for this entry.");
}

// Handle DELETE request
if (isset($_POST['delete'])) {
    $stmt = $test_db->prepare("DELETE FROM live_table WHERE id = ?");
    $stmt->bind_param("i", $entry_id);
    if ($stmt->execute()) {
        header("Location: ../success-del.html");
    } else {
        fail_with_error("Could not delete the entry.");
    }
    $stmt->close();
    $test_db->close();
    exit();
}

// Handle UPDATE request
if (isset($_POST['update'])) {
    $entry_keyword = isset($_POST['entry_keyword']) ? trim($_POST['entry_keyword']) : '';
    $assign_group = isset($_POST['assign_group']) ? trim($_POST['assign_group']) : '';

    if (empty($entry_keyword) || empty($assign_group)) {
        fail_with_error("Keyword and Assignment Group fields cannot be blank.");
    }

    $sql = "UPDATE live_table SET 
                entry_keyword = ?, entry_category = ?, assign_group = ?, 
                notes = ?, author_email = ?, updt_time = NOW()
            WHERE id = ?";
    
    $stmt = $test_db->prepare($sql);
    $stmt->bind_param(
        "sssssi",
        $entry_keyword,
        $_POST['entry_category'] ?? '',
        $assign_group,
        $_POST['notes'] ?? '',
        $author_email, // The email can be updated
        $entry_id
    );

    if ($stmt->execute()) {
        header("Location: ../success-mod.html");
    } else {
        fail_with_error("Could not update the entry: " . $stmt->error);
    }
    $stmt->close();
}

$test_db->close();
?>
