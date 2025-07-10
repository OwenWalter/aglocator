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

		/* Entry details styling */
		.wrapper {
			background: white;
			padding: 30px;
			border-radius: 12px;
			box-shadow: 0 4px 20px rgba(0,0,0,0.08);
			margin: 20px 0;
		}

		.wrapper h3 {
			color: var(--sas-blue-dark);
			font-weight: 600;
			margin-bottom: 10px;
		}

		.wrapper h4 {
			color: var(--sas-blue);
			font-weight: 500;
			margin-bottom: 8px;
		}

		.wrapper p {
			color: #555;
			font-weight: 500;
			margin-bottom: 5px;
		}

		.wrapper pre {
			background: var(--sas-gray-light);
			border: 1px solid var(--sas-border);
			border-radius: 8px;
			padding: 20px;
			font-family: 'Roboto', monospace;
			color: #333;
			max-height: none !important;
			white-space: pre-wrap;
			word-wrap: break-word;
		}

		.wrapper a {
			color: var(--sas-blue);
			text-decoration: none;
			font-weight: 500;
			padding: 8px 16px;
			background: var(--sas-gray-light);
			border-radius: 6px;
			border: 1px solid var(--sas-border);
			display: inline-block;
			margin-top: 20px;
			transition: all 0.3s ease;
		}

		.wrapper a:hover {
			background: var(--sas-blue);
			color: white;
			text-decoration: none;
			transform: translateY(-1px);
			box-shadow: 0 4px 12px rgba(0,116,217,0.2);
		}

		/* Float styling */
		.goleftfloat {
			float: left;
			width: 70%;
		}

		.gorightfloat {
			float: right;
			width: 25%;
			text-align: right;
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

			.wrapper {
				padding: 20px;
			}

			.goleftfloat, .gorightfloat {
				float: none;
				width: 100%;
				text-align: left;
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

	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="index.html">Search</a></li>
        <li><a href="updatecontent.html">Add New Entry</a></li>
	<li class="active"><a>Viewing Details<span class="sr-only">(current)</span></a></li>
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

<!-- All the meat of the view entry page is in this embedded PHP for simplicity of passing input ID vars -->

<?php
//require_once '/path/to/database/configfile/db.php';    //Refer to db.php-example
require_once 'php/db.php';

// Get the ID for the selected entry
$entryID = htmlspecialchars($_GET["id"]);

// Output HTML line-by-line, header info becomes multiple "lines" in a single span due to CSS float handling
//$html = '<span class=goleftfloat><h3><b><i>keywordString</i></b></h3><h4><b><i>categoryString</b></i></h4><h4><b><i>subcatString</b></i></h4><br><br><p>Assignment Group:</p><h3><b><i>assigngroupString</b></i></h3><br><br><h5>Primary Consultant: <b>priconsultString</b></h5><h5>Backup Consultant: <b>bakconsultString</b></h5><h5>Team Manager: <b>managerString</b></h5></span>'; //display consultants and manager
$html = '<span class=goleftfloat><p>Entry Keyword / Product:</p><h3><b><i>keywordString</i></b></h3><p>Category:</p><h4><b><i>categoryString</b></i></h4><p>Subcategory:</p><h4><b><i>subcatString</b></i></h4><br><br><p>Assignment Group:</p><h3><b><i>assigngroupString</b></i></h3></span>'; //do not display consultants and manager
$html .= '<span class=gorightfloat><p>Entry Created: <b>smittimeString</b></p><p>Entry Modified: <b>updttimeString</b></p></span>';
$html .= '<div style="clear:both;"></div><br>';
$html .= '<p>Additional Notes:</p>';
$html .= '<pre>notesString</pre>';
$html .= '<p><a href="modifycontent.php?id=' . $entryID . '">Modify This Entry</a></p>';

        // Query
        $query = "SELECT * FROM live_table WHERE id = '".$entryID."'";

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
                 $d_assigngroup = htmlspecialchars($result['assign_group']);
                 $d_notes = htmlspecialchars($result['notes']);
                 $d_priconsult = htmlspecialchars($result['pri_consult']);
                 $d_bakconsult = htmlspecialchars($result['bak_consult']);
                 $d_manager = htmlspecialchars($result['manager']);
		 $d_smittime = htmlspecialchars($result['smit_time']);
		 $d_updttime = htmlspecialchars($result['updt_time']);
                 $d_id = htmlspecialchars($result['id']);                
		// Replace the items into above HTML
                $o = str_replace('keywordString', $d_keyword, $html);
                $o = str_replace('categoryString', $d_category, $o);
                $o = str_replace('subcatString', $d_subcat, $o);
                $o = str_replace('assigngroupString', $d_assigngroup, $o);
                $o = str_replace('notesString', $d_notes, $o);
                $o = str_replace('priconsultString', $d_priconsult, $o);
                $o = str_replace('bakconsultString', $d_bakconsult, $o);
                $o = str_replace('managerString', $d_manager, $o);
		$o = str_replace('smittimeString', $d_smittime, $o);
		$o = str_replace('updttimeString', $d_updttime, $o);
                $o = str_replace('idString', $d_id, $o);                
		// Output it
                echo($o);
                        }
                }else{
                // Replace for no results
                $o = str_replace('keywordString', '<span class="label label-danger">Error: Entry ID Not Found</span>', $html);
                $o = str_replace('categoryString', '', $o);
                $o = str_replace('subcatString', '', $o);
                $o = str_replace('assigngroupString', '', $o);
                $o = str_replace('notesString', '', $o);
                $o = str_replace('priconsultString', '', $o);
		$o = str_replace('bakconsultString', '', $o);
		$o = str_replace('managerString', '', $o);
		$o = str_replace('smittimeString', '', $o);
                $o = str_replace('updttimeString', '', $o);
		$o = str_replace('idString', '', $o);
                // Output
                echo($o);
        }
//}
?>

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
		<script type="text/javascript" src="scripts/votesystem.js"></script>

	</body>
</html>
