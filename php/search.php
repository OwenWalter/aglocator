<?php
//require_once '/path/to/database/configfile/db.php';    //Refer to db.php-example
require_once 'db.php';

// Log received parameters for debugging (only to error log, not output)
error_log("Search.php called with POST data: " . print_r($_POST, true));

// Output HTML formats
$html = '<tr>';
$html .= '<td class="small"><a href="viewentry.php?id=idString" target="_blank">keywordString</a></td>';
$html .= '<td class="small">categoryString</td>';
$html .= '<td class="small"><a href="viewgroup.php?name=groupNameString" target="_blank">assigngroupString</a></td>';
$html .= '<td class="small">notesString</td>';
$html .= '</tr>';

// Get the Search
$search_string = preg_replace("/[%]/", " ", $_POST['query']);
$search_string = $test_db->real_escape_string($search_string);

// Get the Category Filter
$category_filter = isset($_POST['category_filter']) ? $_POST['category_filter'] : '';
$category_filter = $test_db->real_escape_string($category_filter);

// Log the processed values
error_log("Processed search_string: '$search_string', category_filter: '$category_filter'");

// Check if length is more than 1 character
if (strlen($search_string) > 1 && $search_string !== ' ') {
	//Insert Time Stamp
	$time = "UPDATE query_data SET timestamp=now() WHERE signame='" .$search_string. "'";
	//Count how many times a query occurs
	$query_count = "UPDATE query_data SET querycount = querycount +1 WHERE signame='" .$search_string. "'";
	// Query
	if (substr($search_string,0,1) === '#') { //Tag (meta-search) mode. Tags start with #.


		// Show recent entries. #recent:days
		if (substr($search_string,1,6) === 'recent') { //php7 does not have str_contains so we must explicitly define metatag word as substring
			if (substr($search_string,7,1) === ':') { //if user is defining a lentth for recent (in days)
				$reclen = substr($search_string, strpos($search_string, ':') + 1); //get number of days specified
			}
			else { $reclen=30; } //default to 30 days
		$query = 'SELECT * FROM live_table WHERE updt_time BETWEEN DATE_SUB(NOW(), INTERVAL '.$reclen.' DAY) AND NOW()';
		
		// Add category filter if specified
		if (!empty($category_filter)) {
			$query .= ' AND entry_category = "'.$category_filter.'"';
		}
		
		$query .= ' ORDER BY updt_time DESC';
		}


		else {
		$query = 'SELECT * FROM live_table LIMIT 0'; //Failsafe, make a query to fill variables, but do nothing
		}
	}
	else { //Normal (keyword-search) mode
	
	// Build the base search query with parentheses for proper operator precedence
	$query = 'SELECT * FROM live_table WHERE (entry_keyword LIKE "%'.$search_string.'%" OR entry_category LIKE "%'.$search_string.'%" OR entry_subcategory LIKE "%'.$search_string.'%" OR assign_group LIKE "%'.$search_string.'%" OR notes LIKE "%'.$search_string.'%")';
	
	// Add category filter if specified - this will apply to ALL results from the search
	if (!empty($category_filter)) {
		$query .= ' AND entry_category = "'.$category_filter.'"';
	}
	
	$query .= ' ORDER BY orig_datasrc ASC, entry_keyword ASC, entry_category ASC';

	}

	// Log the final query for debugging
	error_log("Final SQL query: $query");
	
	//Timestamp entry of search for later display
	$time_entry = $test_db->query($time);
	//Count how many times a query occurs
	$query_count = $test_db->query($query_count);
	// Do the search
	$result = $test_db->query($query);
	
	if (!$result) {
		error_log("SQL query failed: " . $test_db->error);
		echo('<tr><td colspan="4" class="small"><span class="label label-danger">Database Error: ' . htmlspecialchars($test_db->error) . '</span></td></tr>');
		exit;
	}
	
	while($results = $result->fetch_array()) {
		$result_array[] = $results;
	}
	
	// Log result count
	$result_count = isset($result_array) ? count($result_array) : 0;
	error_log("Query returned $result_count results");
	
	// Check for results
	if (isset($result_array)) {
		foreach ($result_array as $result) {
		// Output strings and highlight the matches
		 $d_keyword = htmlspecialchars($result['entry_keyword']);
                 $d_category = htmlspecialchars($result['entry_category']);
                 $d_subcat = htmlspecialchars($result['entry_subcategory']);
		 $d_assigngroup = htmlspecialchars($result['assign_group']);
		 $d_assigngroup_url = urlencode(strtolower($result['assign_group']));
		 $d_notes = htmlspecialchars($result['notes']);
		 $d_id = htmlspecialchars($result['id']);
			//make url clickable
			$urlregex = '~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i'; //define what a URL looks like, too aggressive and non-URLs will become links
			$d_notes = preg_replace($urlregex,'<a href="$0" target="_blank" title="$0">$0</a>',$d_notes); //rewrite d_notes adding <a> tag hrefs where match
		// Replace the items into above HTML
		$o = str_replace('keywordString', $d_keyword, $html);
                $o = str_replace('categoryString', $d_category, $o);
                $o = str_replace('assigngroupString', $d_assigngroup, $o);
		$o = str_replace('groupNameString', $d_assigngroup_url, $o);
		$o = str_replace('notesString', $d_notes, $o);
		$o = str_replace('idString', $d_id, $o);
		// Output it
		echo($o);
			}
		}else{
		// Replace for no results
		$o = str_replace('keywordString', '<span class="label label-danger">No Matching Results Found</span>', $html);
		$o = str_replace('categoryString', '', $o);
		$o = str_replace('assigngroupString', '', $o);
		$o = str_replace('notesString', '', $o);
		$o = str_replace('idString', '', $o);
		// Output
		echo($o);
	}
}
?>
