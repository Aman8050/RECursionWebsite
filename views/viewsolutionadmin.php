<?php
	require_once("./includes/check_login_status.php");
	if($admin_ok==false)
	{
		header("location: ".WEB_URL."/login");
		exit();
	}
	else
	{
		$class = $admin_class;
		if(isset($_GET['user']) && isset($_GET['problem']))
		{
			$problem_code = mres($_GET['problem']);
			$handle = mres($_GET['user']);
			$query = "SELECT * FROM problems WHERE code='{$problem_code}' AND class = '{$class}'";
			$problems = $connection->query($query);
			if($problems == NULL || $problems->num_rows == 0) header("location: ".BASE_URL);
			foreach($problems as $problem);
			$problem_name = $problem['name'];
			$problem_active = $problem['active'];
			$query = "SELECT * FROM students WHERE handle='{$handle}' AND class='{$class}'";
			$students = $connection->query($query);
			if($students == NULL || $students->num_rows == 0) header("location: ".BASE_URL);
			foreach($students as $student);
			$student_name = $student['name'];
			$roll = $student['roll'];
			$filename = './codes/'.$handle.' '.$problem_code.'.txt';
			if(file_exists ( $filename ))
			$solution = htmlentities(file_get_contents ( $filename ));
			else
			$solution = "No submissions made by user";
			$query = "SELECT * FROM submissions WHERE handle='{$handle}' AND problem='{$problem_code}'";
			$submissions = $connection->query($query);
			$lang = 0;
			if($submissions != NULL && $submissions->num_rows > 0)
			{
				foreach($submissions as $submission);
				$lang = $submission['language'];
			}
			$query = "SELECT * FROM admins WHERE class='{$admin_class}'";
			$admins = $connection->query($query);
			foreach($admins as $admin);
		}
		else
		{
			header("");
		}
	}
?>
<html>
<head>
	<title>Submission | <?php echo $problem_code;?></title>
	<link rel="shortcut icon" href="<?= BASE_URL ?>/images/computer.png" type="image/png">
	<link href="<?= BASE_URL ?>/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="<?= BASE_URL ?>/css/hljs.css" rel="stylesheet" type="text/css">
	<link href="<?= BASE_URL ?>/css/header.css" rel="stylesheet" type="text/css">
	<link href="<?= BASE_URL ?>/css/viewsolutionadmin.css" rel="stylesheet" type="text/css">
	<script src="<?= BASE_URL ?>/js/highlight.pack.js"></script>
	<script src="<?= BASE_URL ?>/js/clipboard.min.js"></script>
	<script src="<?= BASE_URL ?>/js/jquery.min.js"></script>
	<script src="<?= BASE_URL ?>/js/bootstrap.min.js"></script>
	<script>hljs.initHighlightingOnLoad();</script>
</head>
<body>
	<?php
	render('../templates/header_admin',array('admin_name' => hsc($admin['name'])));
	?>
	<div class="body1">
		<div class="row">
			<div class="heading">
				Submission for <?php echo hsc($problem_code).' by '.$handle; ?>
			</div>
			<div class="section">
				<div class="copybutton">
					<button class="btn btn-warning" data-clipboard-action="copy" data-clipboard-target="#code">Copy code to Clipboard</button>
				</div>
				<pre>
					<code class="<?php if($lang == 2) echo 'java'; else echo'cpp'; ?> hljs" id="code"><?php echo $solution;?></code>
				</pre>
			</div>
		</div>
	</div>
	<script>
		var clipboard = new Clipboard('.btn');

		clipboard.on('success', function(e) {
			console.log(e);
		});

		clipboard.on('error', function(e) {
			console.log(e);
		});
	</script>
</body>
</html>