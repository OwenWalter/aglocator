<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Assignment Group Locator">
	<meta name="author" content="Andy Foreman">

	<title>Assignment Group Locator - Modify Entry</title>
	<link rel="icon" href="assets/favicon.ico" type="image/x-icon" />

	<link href="assets/css/bootstrap.css" rel="stylesheet">
	<link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="assets/css/style.css" rel="stylesheet">
	<link href="assets/css/style-responsive.css" rel="stylesheet">

	<style>
		:root {
			--sas-blue: #0074d9;
			--sas-blue-dark: #005bb5;
			--sas-gray: #6c757d;
			--sas-border: #e0e7ee;
			--sas-bg: #f8f9fa;
		}
		body {
			background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
			font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
		}
		.navbar-default {
			background: linear-gradient(135deg, var(--sas-blue) 0%, var(--sas-blue-dark) 100%);
			border: none;
			box-shadow: 0 4px 20px rgba(0,116,217,0.2);
			margin-bottom: 0;
			padding: 8px 0;
			position: relative;
			overflow: hidden;
		}
		.navbar-brand img {
			height: 60px;
			transform: translateY(-15px);
		}
		.navbar-nav > li > a {
			color: rgba(255,255,255,0.9) !important;
			font-weight: 500;
		}
		.navbar-nav > .active > a {
			background: rgba(255,255,255,0.2) !important;
			border-radius: 6px;
		}
		#main-content {
			padding: 15px;
		}
		.page-header {
			background: transparent;
			padding: 0;
			margin: 0 0 20px 0;
			text-align: left;
		}
		.page-title {
			font-size: 24px;
			font-weight: 600;
			color: var(--sas-blue-dark);
		}
		.page-subtitle {
			font-size: 15px;
			color: var(--sas-gray);
		}
		.form-section {
			background: white;
			border-radius: 16px;
			box-shadow: 0 8px 32px rgba(0,0,0,0.08);
			padding: 40px;
			margin: 0 auto;
			max-width: 800px;
		}
		.form-group { margin-bottom: 25px; }
		.form-label { font-weight: 600; font-size: 15px; color: #333; margin-bottom: 8px; display: block; }
		.form-input, .form-select, .form-textarea { width: 100%; padding: 12px 16px; border: 2px solid var(--sas-border); border-radius: 8px; font-size: 15px; transition: all 0.3s ease; }
		.form-input:focus, .form-select:focus, .form-textarea:focus { outline: none; border-color: var(--sas-blue); box-shadow: 0 0 0 3px rgba(0,116,217,0.1); }
		.form-textarea { min-height: 150px; resize: vertical; }
		.form-note { font-size: 13px; color: var(--sas-gray); margin-top: 5px; }
		.btn-submit { background: linear-gradient(135deg, var(--sas-blue) 0%, var(--sas-blue-dark) 100%); border: none; color: white; padding: 15px 30px; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 16px rgba(0,116,217,0.25); }
		.btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,116,217,0.35); }
		.btn-delete { background: #dc3545; }
		.btn-delete:hover { background: #c82333 !important; }
	</style>
</head>

<body>
<?php
require_once 'php/db.php';
$entry_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$entry_data = null;

if ($entry_id > 0) {
    $stmt = $test_db->prepare("SELECT * FROM live_table WHERE id = ?");
    $stmt->bind_param("i", $entry_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $entry_data = $result->fetch_assoc();
    }
    $stmt->close();
}

// Helper function to check and echo form values
function echo_value($field, $default = '') {
    global $entry_data;
    echo $entry_data && isset($entry_data[$field]) ? htmlspecialchars($entry_data[$field]) : $default;
}
?>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.html"><img src="assets/orangeLOGO.png" alt="Assignment Group Locator" /></a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="index.html">Search</a></li>
        <li><a href="updatecontent.html">Add New Entry</a></li>
        <li class="active"><a>Modifying Entry<span class="sr-only">(current)</span></a></li>
      </ul>
       <ul class="nav navbar-nav navbar-right">
        <li><a href="help.html">Help</a></li>
      </ul>
   </div>
  </div>
</nav>

<section id="container">
	<section id="main-content" style="margin-left: 0px;">
		<section class="wrapper">
            <?php if ($entry_data): ?>
			<div class="page-header">
				<h1 class="page-title">Modify Database Entry</h1>
				<p class="page-subtitle">Use this form to modify an existing entry in the AG Locator database.</p>
			</div>
			
			<div class="form-section">
				<form name="modify" action="php/modify.php" method="post" style="display:inline;">
                    <input type="hidden" name="entry_id" value="<?php echo_value('id'); ?>">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="form-label">Entry Keyword / Product:</label>
								<input type="text" name="entry_keyword" class="form-input" value="<?php echo_value('entry_keyword'); ?>" required>
							</div>

							<div class="form-group">
								<label class="form-label" for="entry_category">Support Category</label>
								<select name="entry_category" id="entry_category" class="form-select">
									<option value="">None (default)</option>
                                    <?php $categories = ['Installation', 'Configuration', 'Performance', 'Usage']; ?>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?php echo $cat; ?>" <?php if ($entry_data['entry_category'] == $cat) echo 'selected'; ?>><?php echo $cat; ?></option>
                                    <?php endforeach; ?>
								</select>
							</div>

							<div class="form-group">
								<label class="form-label">Assignment Group:</label>
								<input type="text" name="assign_group" class="form-input" value="<?php echo_value('assign_group'); ?>" required>
							</div>
						</div>
                        <div class="col-md-6">
                            <div class="form-group">
								<label class="form-label">Author Email Address:</label>
								<input type="email" name="author_email" class="form-input" value="<?php echo_value('author_email'); ?>" required>
								<div class="form-note">Must match the original author's email.</div>
							</div>
							<div class="form-group">
								<label class="form-label">Author Key:</label>
								<input type="text" name="author_key" class="form-input" required>
								<div class="form-note">A valid key is required to update or delete. <a href="requestkey.html" target="_blank">Request a key here.</a></div>
							</div>
                        </div>
					</div>

					<div class="form-group">
						<label class="form-label" for="notes">Additional Notes</label>
						<textarea class="form-textarea" name="notes" id="notes" maxlength="4000" placeholder="Include any extra details, links, or context here..."><?php echo_value('notes'); ?></textarea>
					</div>

					<div style="text-align: center; margin-top: 30px; display: flex; justify-content: center; gap: 20px;">
						<button type="submit" name="update" class="btn-submit">Update Entry</button>
				</form>
				<form name="delete" action="php/modify.php" method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this entry? This cannot be undone.');">
					<input type="hidden" name="entry_id" value="<?php echo_value('id'); ?>">
					<input type="hidden" name="author_email" value="<?php echo_value('author_email'); ?>">
					<button type="submit" name="delete" class="btn-submit btn-delete">Delete Entry</button>
				</form>
					</div>
			</div>
            <?php else: ?>
                <div class="alert alert-danger">Error: Could not load entry data. The entry may not exist.</div>
            <?php endif; ?>
		</section>
	</section>
</section>

<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

</body>
</html>
