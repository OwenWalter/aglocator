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
	
	<!-- Modern styling for this page -->
	<style>
		/* SAS Blue Color Palette */
		:root {
			--sas-blue: #0074D9;
			--sas-blue-dark: #005bb5;
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

		.navbar-default::before, .navbar-default::after {
			content: '';
			position: absolute;
			top: -50%;
			background: rgba(255,255,255,0.05);
			transform: rotate(15deg);
			height: 200%;
		}
		.navbar-default::before { right: -10%; width: 100px; }
		.navbar-default::after { right: -5%; width: 60px; background: rgba(255,255,255,0.03); }

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
		.navbar-nav > li > a:focus,
		.navbar-nav > .active > a {
			color: white !important;
			background: rgba(255,255,255,0.15) !important;
			border-radius: 6px;
		}

		/* Main content area */
		#container { background: white; }
		#main-content { padding: 15px; }

		/* Entry details styling */
		.entry-wrapper {
			background: white;
			border-radius: 12px;
			box-shadow: 0 6px 24px rgba(0,0,0,0.07);
			border: 1px solid var(--sas-border);
		}

		.entry-header {
			padding: 20px 25px;
			border-bottom: 1px solid var(--sas-border);
		}
		
		.entry-keyword {
			font-size: 24px;
			font-weight: 600;
			color: var(--sas-blue-dark);
			margin: 0 0 5px 0;
		}

		.entry-category {
			font-size: 16px;
			font-weight: 500;
			color: var(--sas-gray);
		}

		.entry-body {
			padding: 25px;
		}

		.assignment-group-section {
			text-align: center;
			background: linear-gradient(135deg, var(--sas-blue) 0%, var(--sas-blue-dark) 100%);
			color: white;
			padding: 25px;
			border-radius: 8px;
			margin-bottom: 25px;
		}

		.assignment-group-section .label {
			font-size: 14px;
			font-weight: 500;
			opacity: 0.8;
			margin-bottom: 8px;
			display: block;
		}
		
		.assignment-group-section .group-name {
			font-size: 28px;
			font-weight: 700;
			letter-spacing: 0.5px;
		}

		.notes-section .label {
			font-size: 16px;
			font-weight: 600;
			color: var(--sas-blue-dark);
			margin-bottom: 10px;
		}

		.notes-section pre {
			background: var(--sas-gray-light);
			border: 1px solid var(--sas-border);
			border-radius: 8px;
			padding: 20px;
			font-size: 15px;
			line-height: 1.7;
			color: #333;
			white-space: pre-wrap;
			word-wrap: break-word;
			max-height: none !important;
		}
		
		.entry-footer {
			padding: 20px 25px;
			background: var(--sas-gray-light);
			border-top: 1px solid var(--sas-border);
			display: flex;
			justify-content: space-between;
			align-items: center;
			border-bottom-left-radius: 12px;
			border-bottom-right-radius: 12px;
		}

		.entry-meta {
			font-size: 13px;
			color: var(--sas-gray);
		}

		.btn-modify-entry {
			background: var(--sas-blue);
			color: white;
			border: none;
			padding: 10px 20px;
			border-radius: 8px;
			font-weight: 600;
			text-decoration: none !important;
			transition: all 0.3s ease;
		}

		.btn-modify-entry:hover {
			background: var(--sas-blue-dark);
			transform: translateY(-2px);
			box-shadow: 0 4px 12px rgba(0,116,217,0.2);
			color: white;
		}
	</style>

</head>

<body>

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
      <a class="navbar-brand" href="index.html">
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
	<section id="main-content" style="margin-left: 0px;">
		<section class="wrapper">
			<div class="row">
				<div class="col-xs-12 col-md-8 col-md-offset-2">
					<?php
					//require_once '/path/to/database/configfile/db.php';    //Refer to db.php-example
					require_once 'php/db.php';

					$id = isset($_GET['id']) ? $_GET['id'] : '';

					if (!empty($id) && is_numeric($id)) {
						// Use prepared statements to prevent SQL injection
						$stmt = $test_db->prepare("SELECT * FROM live_table WHERE id = ?");
						$stmt->bind_param("i", $id);
						$stmt->execute();
						$result = $stmt->get_result();

						if ($result->num_rows > 0) {
							$row = $result->fetch_assoc();

							// Sanitize output
							$entry_keyword = htmlspecialchars($row['entry_keyword']);
							$entry_category = htmlspecialchars($row['entry_category']);
							$assign_group = htmlspecialchars($row['assign_group']);
							$notes = nl2br(htmlspecialchars($row['notes']));
							$entry_id = htmlspecialchars($row['id']);
							$updt_time = htmlspecialchars($row['updt_time']);
							
							// Make URLs in notes clickable
							$urlregex = '~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i';
							$notes = preg_replace($urlregex, '<a href="$0" target="_blank" title="$0">$0</a>', $notes);
					?>
							<div class="entry-wrapper">
								<div class="entry-header">
									<h1 class="entry-keyword"><?php echo $entry_keyword; ?></h1>
									<p class="entry-category"><?php echo $entry_category; ?></p>
								</div>
								<div class="entry-body">
									<div class="assignment-group-section">
										<span class="label">ASSIGNMENT GROUP</span>
										<div class="group-name"><?php echo $assign_group; ?></div>
									</div>
									<div class="notes-section">
										<span class="label">NOTES</span>
										<pre><?php echo $notes; ?></pre>
									</div>
								</div>
								<div class="entry-footer">
									<div class="entry-meta">
										Last Updated: <?php echo $updt_time; ?>
									</div>
									<a href="modifycontent.php?id=<?php echo $entry_id; ?>" class="btn-modify-entry">Modify Entry</a>
								</div>
							</div>
					<?php
						} else {
							echo "<div class='alert alert-danger'>Entry not found.</div>";
						}
						$stmt->close();
					} else {
						echo "<div class='alert alert-warning'>No entry ID specified.</div>";
					}
					$test_db->close();
					?>
				</div>
			</div>
		</section>
	</section>
</section>

<!-- js placed at the end of the document so the pages load faster -->
<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>

<!--script for this page-->
<script type="text/javascript" src="scripts/votesystem.js"></script>

</body>
</html>
