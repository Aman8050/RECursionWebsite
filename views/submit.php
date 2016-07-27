<?php
	require_once("./includes/check_login_status.php");
	if($user_ok==false)
	{
		header("location: ".WEB_URL."/login");
		exit();
	}
	else
	{
	$submitted = false;
	$handle = $student_handle;
	if(isset($_GET['problem']))
	{
		$problem_code = mres($_GET['problem']);
		$query = "SELECT * FROM problems WHERE code='{$problem_code}'";
		$problems = $connection->query($query);
		if ($problems == false) exit();
		$numrows = $problems->num_rows;
		if($numrows <= 0){
			exit();
		}
		foreach($problems as $problem);
		$problem_name = hsc($problem['name']);
		$problem_active = $problem['active'];
		$query = "SELECT * FROM students WHERE handle='{$handle}'";
		$students = $connection->query($query);
		foreach($students as $student);
		$student_name = hsc($student['name']);
		$student_roll = $student['roll'];
	}
	else
	{
		exit();
	}
	if(isset($_POST['language'])&&isset($_POST['solution']))
	{
		$soln_lang = mres($_POST['language']);
		$filename = $handle.' '.$problem_code.'.txt';
		$query = "DELETE FROM submissions WHERE handle='{$handle}' AND problem='{$problem_code}'";
		$x = $connection->query($query);
		$query = "INSERT INTO `cslab`.`submissions` (`id`, `handle`, `problem`, `language`) VALUES (NULL, '{$handle}', '{$problem_code}', '{$soln_lang}');";
		$students = $connection->query($query);
		$file_dir = './codes/'.$filename;
		file_put_contents ( $file_dir , $_POST['solution']);
		$submitted = true;
		header("location: ".WEB_URL."/viewsolution/".$problem_code);
		exit();
	}
	}
?>
<html>
<head>
	<title>Submit | <?php echo $problem_code; ?></title>
	<link rel="shortcut icon" href="<?= BASE_URL ?>/images/computer.png" type="image/png">
	<link href="<?= BASE_URL ?>/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="<?= BASE_URL ?>/css/header.css" rel="stylesheet" type="text/css">
	<link href="<?= BASE_URL ?>/css/submit.css" rel="stylesheet" type="text/css">
	<script src="<?= BASE_URL ?>/js/jquery.min.js"></script>
	<script src="<?= BASE_URL ?>/js/bootstrap.min.js"></script>
</head>
<body>
	<?php
	render('../templates/header_student',array('student_name' => $student_name));
	?>
	<div class="body1">
		<div class="row">
			<div class="heading">
				Submit solution for <?php echo hsc($problem_code).' | '.$problem_name;?>
			</div>
			<div class="section">
				<form class="submit_form" method="post">
					<label class="code_label">Enter code here:
					</label>
					<div class="textbox">
						<textarea spellcheck="false" name="solution" rows="20"></textarea>
					</div>
					<div class="form-group">
						<label for="language" class="control-label">Language:</label>
						<div class="">
							<select name="language" class="form-control">
								<option value="0">C</option>
								<option value="1">C++</option>
								<option value="2">Java</option>
							</select>
						</div>
					</div>
					<button type="submit" class="btn">Submit</button>
				</form>
			</div>
		</div>
	</div>
</body>
<?php
if($submitted == true)
echo'
<script>
window.location="'.WEB_URL.'/viewsolution/'.hsc($problem_code).'";
</script>';
?>
</html>