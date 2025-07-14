<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Assignment Group Locator">
	<meta name="author" content="Andy Foreman">

	<title>Assignment Group Details</title>
	<link rel="icon" href="assets/favicon.ico" type="image/x-icon" />

	<!-- Bootstrap core CSS -->
	<link href="assets/css/bootstrap.css" rel="stylesheet">
	<!--external css-->
	<link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />

	<!-- Custom styles for this page-->
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
	<link href="assets/css/style.css" rel="stylesheet">
	<link href="assets/css/style-responsive.css" rel="stylesheet">
	<link href="assets/css/custom.css" rel="stylesheet">
	
	<style>
		/* SAS Blue Color Palette */
		:root {
			--sas-blue: #0074D9;
			--sas-blue-dark: #005bb5;
			--sas-gray-light: #f8f9fa;
			--sas-gray: #6c757d;
			--sas-border: #e9ecef;
		}
		body {
			font-family: 'Roboto', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
			background-color: var(--sas-gray-light);
			color: #333;
		}
		/* Enhanced modern header styling from index.html */
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
		#main-content { padding: 30px 15px; }
		.group-wrapper {
			background: white;
			border-radius: 12px;
			box-shadow: 0 6px 24px rgba(0,0,0,0.07);
			border: 1px solid var(--sas-border);
		}
		.group-header {
			padding: 25px 30px;
			border-bottom: 1px solid var(--sas-border);
			display: flex;
			justify-content: space-between;
			align-items: center;
		}
		.group-name {
			font-size: 28px;
			font-weight: 700;
			color: var(--sas-blue-dark);
			margin: 0;
			text-transform: uppercase;
		}
		.group-body {
			padding: 30px;
		}
		.description-label {
			font-size: 16px;
			font-weight: 600;
			color: var(--sas-blue-dark);
			margin-bottom: 15px;
		}
		.description-content {
			background: var(--sas-gray-light);
			border: 1px solid var(--sas-border);
			border-radius: 8px;
			padding: 20px;
			font-size: 16px;
			line-height: 1.7;
			color: #333;
			min-height: 100px;
		}
		.no-description {
			font-style: italic;
			color: var(--sas-gray);
		}
        .btn-edit-group {
			background: white;
			border: 1px solid var(--sas-border);
			color: var(--sas-gray);
			padding: 8px 16px;
			border-radius: 8px;
			font-weight: 600;
			text-decoration: none !important;
			transition: all 0.3s ease;
		}
        .btn-edit-group:hover {
			background: var(--sas-gray-light);
            border-color: #ccc;
			color: #333;
		}
	</style>
</head>

<body>
<?php
// DB connection
require_once 'php/db.php';

// Get group name from URL and sanitize it
$group_name_from_url = isset($_GET['name']) ? $_GET['name'] : '';

// The name in the URL is lowercased and urlencoded. We need to decode it.
// We will query the database case-insensitively, so we don't need the original case.
$group_name = $test_db->real_escape_string(urldecode($group_name_from_url));

$description = "No description has been added for this group yet.";
$display_group_name = "Invalid Group";

if (!empty($group_name)) {
    // We need to get the correctly cased group name from the main data table (live_table)
    // and the description from the new table (assignment_group_descriptions)
    
    // Query to get the canonical group name
    $name_query = 'SELECT assign_group FROM live_table WHERE LOWER(assign_group) = "'.$group_name.'" LIMIT 1';
    $name_result = $test_db->query($name_query);
    
    if ($name_result && $name_result->num_rows > 0) {
        $name_row = $name_result->fetch_assoc();
        $display_group_name = htmlspecialchars($name_row['assign_group']);
        
        // Now query for the description using the canonical name
        $desc_query = 'SELECT description FROM assignment_group_descriptions WHERE group_name = "'.$test_db->real_escape_string($name_row['assign_group']).'"';
        $desc_result = $test_db->query($desc_query);

        if ($desc_result && $desc_result->num_rows > 0) {
            $desc_row = $desc_result->fetch_assoc();
            // Check if description is not empty
            if (!empty($desc_row['description'])) {
                $description = nl2br(htmlspecialchars($desc_row['description']));
            }
        }
    } else {
        // Fallback if the group name isn't in live_table for some reason
        $display_group_name = htmlspecialchars(strtoupper($group_name));
    }
} else {
    $display_group_name = "No Group Specified";
}

?>
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

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="index.html">Search</a></li>
        <li><a href="updatecontent.html">Add New Entry</a></li>
		<li class="active"><a>Group Details<span class="sr-only">(current)</span></a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="help.html">Help</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<section id="container">
	<section id="main-content" style="margin-left: 0px;">
		<section class="wrapper">
			<div class="row">
				<div class="col-xs-12 col-md-8 col-md-offset-2">
					<div class="group-wrapper">
						<div class="group-header">
							<h1 class="group-name"><?php echo $display_group_name; ?></h1>
                            <button class="btn btn-edit-group" data-toggle="modal" data-target="#editModal">Edit</button>
						</div>
						<div class="group-body">
							<p class="description-label">Description</p>
							<div class="description-content">
                                <?php 
                                    if ($description === "No description has been added for this group yet.") {
                                        echo '<span class="no-description">' . $description . '</span>';
                                    } else {
                                        echo $description;
                                    }
                                ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</section>
</section>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editModalLabel">Edit Group Description</h4>
      </div>
      <div class="modal-body">
        <!-- Step 1: Password Entry -->
        <div id="password-step">
            <p>Please enter the password to edit this description.</p>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Password">
            </div>
            <div id="password-error" class="alert alert-danger" style="display: none;"></div>
            <button type="button" class="btn btn-primary" id="submit-password">Submit</button>
        </div>

        <!-- Step 2: Edit Form -->
        <div id="edit-step" style="display: none;">
            <form id="edit-form">
                <input type="hidden" id="group-name-input" value="<?php echo $display_group_name; ?>">
                <div class="form-group">
                    <label for="description-editor">Description</label>
                    <textarea class="form-control" id="description-editor" rows="8"><?php echo htmlspecialchars_decode($description); ?></textarea>
                </div>
                <div id="update-status" style="margin-top: 15px;"></div>
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save-description" style="display: none;">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- js placed at the end of the document so the pages load faster -->
<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
    $('#submit-password').on('click', function() {
        var password = $('#password').val();
        // Simple password check. A real application should use a more secure method.
        if (password === 'SAS') {
            $('#password-step').hide();
            $('#edit-step').show();
            $('#save-description').show();
            $('#password-error').hide();
        } else {
            $('#password-error').text('Incorrect password. Please try again.').show();
        }
    });

    $('#save-description').on('click', function() {
        var groupName = $('#group-name-input').val();
        var newDescription = $('#description-editor').val();
        var statusDiv = $('#update-status');

        statusDiv.html('<span class="text-info">Saving...</span>').show();

        $.ajax({
            url: 'php/update_group_description.php',
            type: 'POST',
            data: {
                group_name: groupName,
                description: newDescription
            },
            dataType: 'json', // Expect a JSON response
            success: function(res) { // 'res' is now automatically a JavaScript object
                if (res.success) {
                    statusDiv.html('<span class="text-success">Description updated successfully!</span>');
                    // Refresh the page to show the new description after a short delay
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    statusDiv.html('<span class="text-danger">Error: ' + res.error + '</span>');
                }
            },
            error: function() {
                statusDiv.html('<span class="text-danger">An unexpected error occurred. Please try again.</span>');
            }
        });
    });

    // Reset modal on close
    $('#editModal').on('hidden.bs.modal', function () {
        $('#password-step').show();
        $('#edit-step').hide();
        $('#save-description').hide();
        $('#password').val('');
        $('#password-error').hide();
        $('#update-status').hide().empty();
    });
});
</script>

</body>
</html> 