<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Assignment Group Locator">
	<meta name="author" content="Andy Foreman">

	<title>Assignment Group Locator</title>
	<link rel="icon" href="assets/favicon.ico" type="image/x-icon" />

	<!-- Bootstrap core CSS -->
	<link href="assets/css/bootstrap.css" rel="stylesheet">
	<!--external css-->
	<link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />

	<!-- Custom styles for this page-->
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
	<link href="assets/css/style.css" rel="stylesheet">
	<link href="assets/css/style-responsive.css" rel="stylesheet">
	<link href="assets/css/table-responsive.css" rel="stylesheet">
	<link href="assets/css/custom.css" rel="stylesheet">
	
	<!-- Modern styling to match index.html -->
	<style>
		/* SAS Blue Color Palette */
		:root {
			--sas-blue: #0074D9;
			--sas-blue-dark: #005bb5;
			--sas-blue-light: #4da3e0;
			--sas-gray-light: #f8f9fa;
			--sas-gray: #6c757d;
			--sas-border: #e9ecef;
		}

		/* Overall page styling */
		body {
			font-family: 'Roboto', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
			background-color: var(--sas-gray-light);
			color: #333;
		}

		/* Enhanced modern header styling */
		.navbar-default {
			background: linear-gradient(135deg, var(--sas-blue) 0%, var(--sas-blue-dark) 100%);
			border: none;
			box-shadow: 0 4px 20px rgba(0,116,217,0.2);
			margin-bottom: 0;
			padding: 8px 0;
			position: relative;
			overflow: hidden;
		}

		.navbar-default::before {
			content: '';
			position: absolute;
			top: -50%;
			right: -10%;
			width: 100px;
			height: 200%;
			background: rgba(255,255,255,0.05);
			transform: rotate(15deg);
		}

		.navbar-default::after {
			content: '';
			position: absolute;
			top: -50%;
			right: -5%;
			width: 60px;
			height: 200%;
			background: rgba(255,255,255,0.03);
			transform: rotate(15deg);
		}

		.navbar-brand {
			padding: 10px 20px;
			transition: all 0.3s ease;
			position: relative;
			z-index: 10;
		}

		.navbar-brand img {
			height: 60px;
			width: auto;
			max-width: 400px;
			transition: all 0.3s ease;
			transform: translateY(-15px);
		}

		.navbar-nav > li > a {
			color: rgba(255,255,255,0.9) !important;
			font-weight: 500;
			font-size: 16px;
			padding: 15px 20px !important;
			transition: all 0.3s ease;
			position: relative;
			z-index: 10;
		}

		.navbar-nav > li > a:hover,
		.navbar-nav > li > a:focus {
			color: white !important;
			background: rgba(255,255,255,0.15) !important;
			border-radius: 6px;
		}

		.navbar-nav > .active > a {
			background: rgba(255,255,255,0.2) !important;
			border-radius: 6px;
		}

		/* Main content area */
		#container {
			background: white;
			min-height: 100vh;
		}

		#main-content {
			padding: 40px 20px;
		}

		/* Content panel styling */
		.content-panel {
			background: white !important;
			padding: 30px;
			border-radius: 12px;
			box-shadow: 0 4px 20px rgba(0,0,0,0.08);
			border: 1px solid var(--sas-border);
		}

		/* Form styling */
		.content-panel h3, .content-panel h4, .content-panel h5 {
			color: var(--sas-blue-dark);
			margin-bottom: 15px;
		}

		.content-panel span {
			color: #555;
		}

		.content-panel input[type="text"], .content-panel textarea, .content-panel select {
			border: 2px solid var(--sas-border);
			border-radius: 6px;
			padding: 8px 12px;
			font-size: 14px;
			transition: all 0.3s ease;
		}

		.content-panel input[type="text"]:focus, .content-panel textarea:focus, .content-panel select:focus {
			border-color: var(--sas-blue);
			box-shadow: 0 0 0 3px rgba(0,116,217,0.1);
			outline: none;
		}

		.content-panel input[type="submit"] {
			background: var(--sas-blue) !important;
			color: white !important;
			border: none;
			padding: 12px 24px;
			border-radius: 8px;
			font-weight: 600;
			cursor: pointer;
			transition: all 0.3s ease;
			box-shadow: 0 4px 12px rgba(0,116,217,0.2);
		}

		.content-panel input[type="submit"]:hover {
			background: var(--sas-blue-dark) !important;
			transform: translateY(-2px);
			box-shadow: 0 6px 20px rgba(0,116,217,0.3);
		}

		.content-panel input[type="submit"]#delete-submit {
			background: #dc3545 !important;
		}

		.content-panel input[type="submit"]#delete-submit:hover {
			background: #c82333 !important;
		}

		/* Mobile responsive */
		@media (max-width: 768px) {
			.navbar-brand img {
				height: 40px;
				max-width: 250px;
			}

			#main-content {
				padding: 20px 15px;
			}

			.content-panel {
				padding: 20px;
			}
		}
	</style>

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>

<body onLoad="document.forms.search.part.focus()">

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">
        <img src="assets/orangeLOGO.png" alt="Assignment Group Locator" />
      </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="index.html">Search</a></li>
	<li><a href="updatecontent.html">Add New Entry</a></li>
        <li class="active"><a>Modifying Entry<span class="sr-only">(current)</span></a></li>
      </ul>
       <ul class="nav navbar-nav navbar-right">
        <li><a href="help.html">Help</a></li>
      </ul> 
   </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


		<section id="container" >

			<!--main content start-->
			<section id="main-content" style="margin-left: 0px;">
				<section class="wrapper">

					<div class="row mt">
						<div class="col-lg-12">

							<div class="content-panel" style="background-color:#e6e6e6;">

<?php
//require_once '/path/to/database/configfile/db.php';    //Refer to db.php-example
require_once 'php/db.php';

// Get the ID for the selected signature from the URL
$entryID = htmlspecialchars($_GET["id"]);

        // Query
        $query = "SELECT entry_keyword, entry_category, entry_subcategory, entry_special, assign_group, pri_consult, bak_consult, manager, notes, author_email FROM live_table WHERE id = '".$entryID."'";
        //echo $query;
        // Do the query, probably does more than necessary for the simple ID select, but it is safe
        $result = $test_db->query($query);
        while($results = $result->fetch_array()) {
                $result_array[] = $results;
        }

        // Check for and display results
        if (isset($result_array)) {
                foreach ($result_array as $result) {
                // Output strings and highlight the matches
		 $d_keyword = htmlspecialchars($result['entry_keyword']);
                 $d_category = htmlspecialchars($result['entry_category']);
                 $d_subcat = htmlspecialchars($result['entry_subcategory']);
                 $d_entspecial = htmlspecialchars($result['entry_special']);
                 $d_assigngroup = htmlspecialchars($result['assign_group']);
                 $d_notes = htmlspecialchars($result['notes']);
                 $d_priconsult = htmlspecialchars($result['pri_consult']);
                 $d_bakconsult = htmlspecialchars($result['bak_consult']);
                 $d_manager = htmlspecialchars($result['manager']);
		 $d_authoremail = htmlspecialchars($result['author_email']);

// Build page HTML line-by-line, header info becomes multiple "lines" in a single span due to CSS float handling
$html = '<h3 style="padding-top:10px;">Modifying Entry: <i><b>' . $d_keyword . '</b></i></h3>';
$html .= '<h4>Category: <i><b>' . $d_category . '</b></i></h4>';
$html .= '<h4 style=margin-bottom:-20px;">Subcategory: <i><b>' . $d_subcat . '</b></i></h4><br>';
$html .= '<h5 style="margin-left:10px;">by current author: <b>' . $d_authoremail . '</b></h5><br>';
$html .= '<form action="php/modify.php" method="post">';
$html .= '<span style="margin-left:10px; font-weight:bold;">Author Key:</span><br>';
$html .= '<input type="text" size="60" name="authorkey" style="margin-left:10px;" required>';
$html .= '<a href="requestkey.html" target="_blank" style="padding-left:8px;">Not sure? Click here to obtain your Author Key.</a><br>';
$html .= '<span style="margin-left:10px;">NOTE: Author Key is validated against current author email address.</span><br>';
$html .= '<span style="margin-left:10px;">Please ask current author to update, or see <a href="help.html" target="_blank">help page</a> for assistance.</a><br><br>';
$html .= '<span style="margin-left:10px; font-weight:bold;">Entry Keyword / Product:</span></br>';
$html .= '<input type="text" size="60" name="entry_keyword" value="' . $d_keyword . '" style="margin-left:10px;" required><br><br>';
$html .= '<span style="margin-left:10px; font-weight:bold;">Entry Category:</span></br>';
//$html .= '<input type="text" size="60" name="entry_category" value="' . $d_category . '" style="margin-left:10px;"><br>'; //modified to select dropdown
$html .= '<select name="entry_category" style="margin-left:10px;">
          <optgroup label="Keep existing:">
            <option value="' . $d_category . '" selected>' . $d_category . ' (keep current category)</option>
          </optgroup>
          <optgroup label="Change to:">
            <option value="">None</option>
            <option value="Installation">Installation</option>
            <option value="Configuration">Configuration</option>
            <option value="Performance">Performance</option>
            <option value="Documentation">Documentation</option>
            <option value="Security">Security</option>
          </optgroup>
          </select><br>';
$html .= '<span style="margin-left:10px; font-weight:bold;">Entry Subcategory:</span></br>';
//$html .= '<input type="text" size="60" name="entry_subcat" value="' . $d_subcat . '" style="margin-left:10px;"><br>'; //modified to select dropdown
$html .= '<select name="entry_subcat" style="margin-left:10px;">
          <optgroup label="Keep existing:">
            <option value="' . $d_subcat .'" selected>' . $d_subcat . ' (keep current subcategory)</option>
          <optgroup>
          <optgroup label="Change to:">
            <option value="">None (default)</option>
            <option value="Download">Download</option>
            <option value="Maintenance">Maintenance</option>
            <option value="Requirements">Requirements</option>
            <option value="Plan File">Plan File</option>
            <option value="License">License</option>
            <option value="Database">Database</option>
            <option value="Language">Language</option>
            <option value="Java">Java</option>
            <option value="Third Party">Third Party</option>
            <option value="Post-Install">Post-Install</option>
            <option value="Error">Error</option>
            <option value="Other">Other</option>
          </optgroup>
          </select><br><br>';
//$html .= '<span style="margin-left:10px; font-weight:bold;">Entry has Special Handling Procedures:</span></br>'; //hidden as not referenced to enduser
$html .= '<input type="hidden" name="entry_special" value="' . $d_entspecial . '" required>'; //hidden field to carry special-handling flag for entry. Was hidden so users do not update this value because it is not currently referenced by anything or visible to enduser.
$html .= '<span style="margin-left:10px; font-weight:bold;">Assignment Group:</span></br>';
$html .= '<input type="text" size="60" name="assign_group" value="' . $d_assigngroup . '" style="margin-left:10px;" required><br>';
$html .= '<span style="margin-left:10px; font-weight:bold;">Author Email Address:</span></br>';
$html .= '<input type="text" size="60" name="updated_authoremail" value="' . $d_authoremail . '" style="margin-left:10px;"><br>'; //will initially populate with current author email from database, on form POST will pass current value into update form as updated_authoremail. This provides method to update existing entry author email (though the updating user will need to know the author key of the original author).
$html .= '<span style="margin-left:10px; font-weight:bold;">Additional Notes:</span><br>';
$html .= '<textarea name="notes" style="width:96%;min-height:300px;margin-left:10px;" maxlength="4000">' . $d_notes . '</textarea><br>';
$html .= '<input type="hidden" name="id" value="' . $entryID . '" required>'; //pass the signature ID to the actual updater for its SQL update
$html .= '<input id="save-submit" name="submit" type="submit" value="Save Modified Entry" style="margin:10px; background-color:#04304b; color:#fff">';
$html .= '<input id="delete-submit" name="submit" type="submit" value="Delete Entry From Database" style="background-color:#800; color:#fff; float:right; margin-top:55px; margin-bottom:5px;" onclick="return confirm(\'Are you sure you want to permanently delete this signature?\');">';
$html .= '</form>';

echo $html; //output it
                        }
                }else{
echo '<br><p>An error has ocurred. Was an ID specified in the URL for the entry you wish to edit? This page should only be accessed from the "view entry" page, where the entry ID is automatically set in the reference URL.<p>';
echo '<p>If you have reached this page unexpectedly, please contact <a href="mailto:andy.foreman@sas.com" target="_blank">andy.foreman@sas.com</a></p><br>';
        }
//}
?>

							</div><!-- /content-panel -->
						</div><!-- /col-lg-4 -->
					</div><!-- /row -->
				</section>
				<! --/wrapper -->
			</section><!-- /MAIN CONTENT -->

			<!--main content end-->

		</section>

		<!-- place JS scripts at end of page for faster load times -->
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>

		<!--script for this page-->
		<script type="text/javascript" src="scripts/triggers.js"></script>

	</body>
</html>
