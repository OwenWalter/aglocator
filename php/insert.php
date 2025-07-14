<?php
session_start();
require_once 'db.php';

// Retrieve and trim required fields
$entry_keyword = isset($_POST['entry_keyword']) ? trim($_POST['entry_keyword']) : '';
$assign_group = isset($_POST['assign_group']) ? trim($_POST['assign_group']) : '';
$author_email = isset($_POST['new_authoremail']) ? trim($_POST['new_authoremail']) : '';

// Validate required fields
if (empty($entry_keyword) || empty($assign_group) || empty($author_email)) {
    exit("Error: Keyword, Assignment Group, and Author Email fields cannot be blank. Please go back and complete the form.");
}

// Prepare the SQL statement to prevent SQL injection
$sql = "INSERT INTO live_table (
            entry_keyword, entry_category, entry_subcategory, entry_special, 
            assign_group, pri_consult, bak_consult, manager, notes, 
            orig_datasrc, author_email
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'appuser', ?)";

$stmt = $test_db->prepare($sql);

if ($stmt === false) {
    exit("SQL Error: " . $test_db->error);
}

// Bind parameters from the POST data, providing defaults for optional fields
$stmt->bind_param(
    "ssssssssss",
    $entry_keyword,
    $_POST['entry_category'] ?? '',
    $_POST['entry_subcat'] ?? '',
    $_POST['entry_special'] ?? 'No',
    $assign_group,
    $_POST['pri_consult'] ?? '',
    $_POST['bak_consult'] ?? '',
    $_POST['manager'] ?? '',
    $_POST['notes'] ?? '',
    $author_email
);

// Execute the statement and redirect
if ($stmt->execute()) {
    header("Location: ../success-add.html");
} else {
    echo "Execution Error: " . $stmt->error;
}

$stmt->close();
$test_db->close();
?>
