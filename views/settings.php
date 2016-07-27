<?php
	require_once("./includes/check_login_status.php");
	if($admin_ok == true)
	{
		$class = mres($admin_class);
		$query = "SELECT * FROM problems WHERE class = '{$class}'";
		$allproblems = $connection->query($query);
		$query = "SELECT * FROM students WHERE class = '{$class}'";
		$allstudents = $connection->query($query);
		$query = "SELECT * FROM admins WHERE class='{$class}'";
		$admins = $connection->query($query);
		foreach($admins as $admin);
	}
	else
	{
		header("location: ".WEB_URL."/login");
	}
?>
<html>
<head>
	<title>Settings | <?php echo hsc($admin['name']); ?></title>
	<link rel="shortcut icon" href="<?= BASE_URL ?>/images/computer.png" type="image/png">
	<link href="<?= BASE_URL ?>/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="<?= BASE_URL ?>/css/header.css" rel="stylesheet" type="text/css">
	<link href="<?= BASE_URL ?>/css/settings.css" rel="stylesheet" type="text/css">
	<script src="<?= BASE_URL ?>/js/jquery.min.js"></script>
	<script src="<?= BASE_URL ?>/js/bootstrap.min.js"></script>
</head>
<body>
	<?php
	render('../templates/header_admin',array('admin_name' => hsc($admin['name'])));
	?>
	<div class="body1">
		<div id="inform" class="row">
		</div>
		<div class="prob_list row" id="prob_list">
			<div class="col-lg-12 unattempted" id="unattempted">
				<form class="problems_form" onsubmit="remove_prob(); return false;">
					<div class="heading">
						List of Problems
					</div>
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<td class="text-center">Select</td>
									<td>Name</td>
									<td>Q.Code</td>
								</tr>
							</thead>
							<tbody>
							<?php
								foreach($allproblems as $problem)
								{
									echo'
									<tr>
										<td class="text-center">
											<label class="checkbox-inline">
											  <input type="checkbox" name="problem_list[]" class="problem" value="'.hsc($problem["code"]).'" >
											</label>
										</td>
										<td><a href="'.CC.'problems/'.hsc($problem["code"]).'/" target=_blank>'.hsc($problem["name"]).'</a></td>
										<td>'.hsc($problem["code"]).'</td>
									</tr>';
								}
							?>
							</tbody>
						</table>
					</div>
					<button id="update_problems" type="submit" class="btn btn-primary">Remove</button>
				</form>
			</div>
		</div>
	</div>
	<div class="body2">
		<div class="add_prob row">
			<div class="col-lg-12 wrong" id="wrong">
				<div class="heading">
					Add Problem
				</div>
				<div class="box_body">
					<form class="add_prob_form row" onsubmit="add_prob(); return false;">
						<div class="form-group">
							<label for="code" class="control-label">Problem Code:</label>
							<div class="">
								<input id="code" spellcheck="false" type="text" class="form-control" name="code" placeholder="problem code"/>
							</div>
						</div>
						<div class="form-group">
							<label for="name" class="control-label">Problem Name:</label>
							<div class="">
								<input id="name" spellcheck="false" type="text" class="form-control" name="name" placeholder="Problem Name"/>
							</div>
						</div>
						<button type="submit" class="btn btn-primary">Go!</button>
					</form>
					<div id="ap_status">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="body3">
		<div class="stud_list row" id="stud_list">
			<div class="col-lg-12 unattempted" id="unattempted">
				<form class="students_form" onsubmit="remove_stud(); return false;">
					<div class="heading">
						List of Students
					</div>
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<td class="text-center">Select</td>
									<td>Roll. No.</td>
									<td>Handle</td>
									<td>Name</td>
								</tr>
							</thead>
							<tbody>
							<?php
								foreach($allstudents as $student)
								{
									echo'
									<tr>
										<td class="text-center">
											<label class="checkbox-inline">
											  <input type="checkbox" name="student_list[]" class="student" value="'.hsc($student["handle"]).'">
											</label>
										</td>
										<td>'.hsc($student["roll"]).'</td>
										<td><a href="'.WEB_URL.'/student/'.hsc($student['handle']).'" target=_blank>'.hsc($student["handle"]).'</a></td>
										<td>'.hsc($student["name"]).'</td>
									</tr>';
								}
							?>
							</tbody>
						</table>
					</div>
					<button id="update_students" type="submit" class="btn btn-primary">Remove</button>
				</form>
			</div>
		</div>
	</div>
	<div class="body4">
		<div class="add_stud row">
			<div class="col-lg-12 wrong" id="wrong">
				<div class="heading">
					Add Student
				</div>
				<div class="box_body">
					<form class="add_stud_form row" onsubmit="add_stud(); return false;">
						<div class="form-group">
							<label for="roll" class="control-label">Roll. No:</label>
							<div class="">
								<input id="roll" spellcheck="false" type="text" class="form-control" name="roll" placeholder="Roll. No."/>
							</div>
						</div>
						<div class="form-group">
							<label for="st_name" class="control-label">Name:</label>
							<div class="">
								<input id="st_name" spellcheck="false" type="text" class="form-control" name="st_name" placeholder="Student Name"/>
							</div>
						</div>
						<div class="form-group">
							<label for="handle" class="control-label">Handle:</label>
							<div class="">
								<input id="handle" spellcheck="false" type="text" class="form-control" name="handle" placeholder="Student Handle"/>
							</div>
						</div>
						<div class="form-group">
							<label for="pass" class="control-label">Password:</label>
							<div class="">
								<input id="pass" spellcheck="false" type="text" class="form-control" name="pass" placeholder="Password"/>
							</div>
						</div>
						<button type="submit" class="btn btn-primary">Go!</button>
					</form>
					<div id="as_status">
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<script>

function _(x)
{
	return document.getElementById(x);
}
function section_name(x)
{
	if(x==0) return 'correct';
	else if(x==1) return 'unattempted';
}
function section_color(x)
{
	if(x==0) return 'green';
	else if(x==1) return 'blue';
}
function remove_noti()
{
	_('notification').style.top = '-30px';
	var t = setTimeout(function(){_('noti_text').innerHTML="";},500);
}

function show_noti()
{
	_('notification').style.top = '0px';
	var t = setTimeout(function(){remove_noti()},3000);
}
function remove_prob()
{
	var problem_list = [];
	var probs = document.getElementsByName('problem_list[]');
    var len = probs.length;
    for (var i=0; i<len; i++) {
		if(probs[i].checked)
        problem_list.push(probs[i].value);
    }
	console.log(problem_list);
	$.ajax({
		url: "./change",
		data: { class : '<?php echo hsc($class);  ?>', problem_list : problem_list},
		type: "POST",
		success: function (data,status,xhr) {
			window.location = "";
		}
	});
}
function add_prob()
{
	_('ap_status').innerHTML = "Adding problem...";
	var code = _('code').value;
	var name = _('name').value;
	$.ajax({
		url: "./change",
		data: { class : '<?php echo hsc($class);  ?>', code : code , name : name },
		type: "POST",
		success: function (data,status,xhr) {
			window.location = "";
		}
	});
}
function remove_stud()
{
	var student_list = [];
	var studs = document.getElementsByName('student_list[]');
    var len = studs.length;
    for (var i=0; i<len; i++) {
		if(studs[i].checked)
        student_list.push(studs[i].value);
    }
	console.log(student_list);
	$.ajax({
		url: "./change",
		data: { class : '<?php echo hsc($class);  ?>', student_list : student_list},
		type: "POST",
		success: function (data,status,xhr) {
			window.location = "";
		}
	});
}
function add_stud()
{
	_('as_status').innerHTML = "Adding student...";
	var roll = _('roll').value;
	var st_name = _('st_name').value;
	var handle = _('handle').value;
	var pass = _('pass').value;
	$.ajax({
		url: "./change",
		data: { class : '<?php echo hsc($class);  ?>', roll : roll , st_name : st_name , handle : handle , pass : pass },
		type: "POST",
		success: function (data,status,xhr) {
			window.location = "";
		}
	});
}
</script>