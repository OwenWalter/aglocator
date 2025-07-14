<?php
require_once 'db.php';

// --- Configuration ---
$limit = 20; // Number of results per page

// --- Input Processing ---
$search_string = isset($_POST['query']) ? trim($_POST['query']) : '';
$category_filter = isset($_POST['category_filter']) ? $_POST['category_filter'] : '';
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$offset = ($page - 1) * $limit;

$has_wildcards = preg_match('/[*?#]/', $search_string);

// --- Main Logic ---

// Check if there is a valid search string
if (strlen($search_string) > 1 && $search_string !== ' ') {

    $query = '';
    $params = [];
    $types = '';

    // Base query parts
    $select_clause = 'SELECT * FROM live_table';
    $where_conditions = [];
    $order_clause = 'ORDER BY orig_datasrc ASC, entry_keyword ASC, entry_category ASC';

    // Build the query based on the search mode
    if (substr($search_string, 0, 1) === '#') { // Tag (meta-search) mode
        if (strpos($search_string, '#recent') === 0) {
            $reclen = 30; // Default to 30 days
            if (strpos($search_string, ':') !== false) {
                $parts = explode(':', $search_string);
                $reclen = (int)end($parts);
            }
            $select_clause = 'SELECT * FROM live_table';
            $where_conditions[] = 'updt_time BETWEEN DATE_SUB(NOW(), INTERVAL ? DAY) AND NOW()';
            $types .= 'i';
            $params[] = $reclen;
            $order_clause = 'ORDER BY updt_time DESC';
        }
    } else if ($has_wildcards) { // Wildcard search mode
        $pattern = str_replace([' * ', '*', '?', '#'], ['\s+[a-zA-Z0-9_]+\s+', '.*', '.', '.?'], $search_string);
        $where_conditions[] = '(entry_keyword REGEXP ? OR entry_category REGEXP ? OR entry_subcategory REGEXP ? OR assign_group REGEXP ? OR notes REGEXP ?)';
        for ($i = 0; $i < 5; $i++) {
            $types .= 's';
            $params[] = $pattern;
        }
    } else { // Normal (keyword-search) mode
        $search_term_like = '%' . $search_string . '%';
        $where_conditions[] = '(entry_keyword LIKE ? OR entry_category LIKE ? OR entry_subcategory LIKE ? OR assign_group LIKE ? OR notes LIKE ?)';
        for ($i = 0; $i < 5; $i++) {
            $types .= 's';
            $params[] = $search_term_like;
        }
    }

    // Add category filter if specified
    if (!empty($category_filter)) {
        $where_conditions[] = 'entry_category = ?';
        $types .= 's';
        $params[] = $category_filter;
    }

    // --- Final Query Construction ---
    if (!empty($where_conditions)) {
        $query = $select_clause . ' WHERE ' . implode(' AND ', $where_conditions) . ' ' . $order_clause . ' LIMIT ? OFFSET ?';
        $types .= 'ii';
        $params[] = $limit;
        $params[] = $offset;
    }

    // --- Database Execution ---
    if (!empty($query)) {
        $stmt = $test_db->prepare($query);

        if (!$stmt) {
            // It's better to log the actual DB error for admins, and show a generic message to users.
            echo('<tr><td colspan="4" class="small"><span class="label label-danger">Query Error. Please contact an administrator.</span></td></tr>');
            exit;
        }
        
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Sanitize output and prepare data for display
                $d_keyword = htmlspecialchars($row['entry_keyword']);
                $d_category = htmlspecialchars($row['entry_category']);
                $d_assigngroup = htmlspecialchars($row['assign_group']);
                $d_assigngroup_url = urlencode(strtolower($row['assign_group']));
                $d_notes = htmlspecialchars($row['notes']);
                $d_id = htmlspecialchars($row['id']);
                
                // Make URLs in notes clickable
                $urlregex = '~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i';
                $d_notes = preg_replace($urlregex, '<a href="$0" target="_blank" title="$0">$0</a>', $d_notes);

                // Build HTML row
                echo "<tr>";
                echo "<td class=\"small\"><a href=\"viewentry.php?id={$d_id}\" target=\"_blank\">{$d_keyword}</a></td>";
                echo "<td class=\"small\">{$d_category}</td>";
                echo "<td class=\"small\"><a href=\"viewgroup.php?name={$d_assigngroup_url}\" target=\"_blank\">{$d_assigngroup}</a></td>";
                echo "<td class=\"small\">{$d_notes}</td>";
                echo "</tr>";
            }
        } else if ($page === 1) { // Only show "No results" on the first page
            echo '<tr><td colspan="4"><span class="label label-danger">No Matching Results Found</span></td></tr>';
        }
        // If it's not page 1 and there are no results, we just return nothing, signaling the end of the data.

        $stmt->close();
    } else if ($page === 1) { // Failsafe for invalid queries on first page
        echo '<tr><td colspan="4"><span class="label label-info">Invalid search query.</span></td></tr>';
    }
}
$test_db->close();
?>
