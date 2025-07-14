<?php
header('Content-Type: application/json');

require_once 'db.php';

$response = ['success' => false, 'error' => 'Invalid request'];

if (isset($_POST['group_name']) && isset($_POST['description'])) {
    $group_name = $_POST['group_name'];
    $description = $_POST['description'];

    // Basic validation
    if (empty($group_name)) {
        $response['error'] = 'Group name cannot be empty.';
        echo json_encode($response);
        exit;
    }

    // Prepare statement to prevent SQL injection
    // The query uses ON DUPLICATE KEY UPDATE to either insert a new record
    // or update an existing one based on the primary key (group_name).
    $stmt = $test_db->prepare("
        INSERT INTO assignment_group_descriptions (group_name, description) 
        VALUES (?, ?)
        ON DUPLICATE KEY UPDATE description = ?
    ");

    if ($stmt) {
        // Bind parameters: sss for three string parameters
        $stmt->bind_param("sss", $group_name, $description, $description);

        if ($stmt->execute()) {
            $response['success'] = true;
            unset($response['error']);
        } else {
            $response['error'] = 'Database execute failed: ' . $stmt->error;
        }
        $stmt->close();
    } else {
        $response['error'] = 'Database prepare failed: ' . $test_db->error;
    }
}

$test_db->close();

echo json_encode($response);
?> 