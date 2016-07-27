<html>
<head>
	<title>Dashboard | Admin</title>
	<link rel="shortcut icon" href="<?= BASE_URL ?>/images/computer.png" type="image/png">
	<link href="<?= BASE_URL ?>/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="<?= BASE_URL ?>/css/awesomplete.css" rel="stylesheet" type="text/css">
	<link href="<?= BASE_URL ?>/css/header.css" rel="stylesheet" type="text/css">
	<link href="<?= BASE_URL ?>/css/home.css" rel="stylesheet" type="text/css">
	<script src="<?= BASE_URL ?>/js/jquery.min.js"></script>
	<script src="<?= BASE_URL ?>/js/bootstrap.min.js"></script>
	<script src="<?= BASE_URL ?>/js/awesomplete.js"></script>
</head>
<body>
	<?php
		render('../templates/header_admin',array('admin_name' => hsc($admin['name'])));
	?>
	<div class="body1">
		<div class="prob_list row" id="prob_list">
			<div class="col-lg-12 unattempted" id="unattempted">
				<form class="problems_form" method="post">
					<div class="heading">
						Problems To Be Solved
					</div>
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<td class="text-center">Active</td>
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
											  <input type="checkbox" name="problem_list[]" id="problem" value="'.hsc($problem["code"]).'" '; if($problem["active"]==1) echo 'checked'; echo'>
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
					<button id="update_problems" type="submit" class="btn btn-primary">Update</button>
				</form>
			</div>
		</div>
	</div>
	<div class="body2">
		<div class="student_vs row">
			<div class="col-lg-12 wrong" id="wrong">
				<div class="heading">
					Check Submission
				</div>
				<div class="box_body">
					<form class="user_prob_form row" onsubmit="opennewtab(); return false;">
						<div class="form-group">
							<label for="problem" class="control-label">Problem:</label>
							<div class="">
								<select id="problem_code" name="problem" class="form-control">
								<?php
								$ind=1;
								foreach($allproblems as $problem)
								{
									if($ind==1)
										echo '<option value="'.hsc($problem["code"]).'" selected="selected">'.hsc($problem["code"]).'</option>';
									else
										echo '<option value="'.hsc($problem["code"]).'">'.hsc($problem["code"]).'</option>';
									$ind = $ind + 1;
								}
								?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="user" class="control-label">User:</label>
							<div class="">
								<input id="handle" spellcheck="false" type="text" class="form-control" name="handle" placeholder="user handle"/>
							</div>
						</div>
						<button type="submit" class="btn btn-primary">Go!</button>
					</form>
					<div id="vs_status">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="body3">
		<div class="students row">
			<div class="col-lg-12 correct" id="correct">
				<div class="heading">
					Students List
				</div>
				<div class="student_list table-responsive">
					<table class="table">
						<thead>
							<tr>
								<td class="text-center">Roll.No.</td>
								<td>Name</td>
								<td>Handle</td>
							</tr>
						</thead>
						<tbody>
							<?php
								$students_list = [];
								$handles_list = [];
								foreach($allstudents as $student)
								{
									$student_name = hsc($student["name"]);
									$student_handle = hsc($student["handle"]);
									$stud = [$student_name." (".$student_handle.")",$student_handle];
									$students_list[] = $stud;
									$handles_list[] = $student_handle;
									echo'
									<tr>
										<td class="text-center">'.hsc($student["roll"]).'</td>
										<td>'.hsc($student_name).'</td>
										<td><a href="'.WEB_URL.'/student/'.hsc($student_handle).'" target="_blank">'.hsc($student_handle).'</a></td>
									</tr>';
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>
<script>
function _(x)
{
	return document.getElementById(x);
}
_('handle').onfocus = function(){ _('vs_status').innerHTML = ""; };
<?php
$js_students = json_encode($students_list);
$js_handles = json_encode($handles_list);
?>
var input = document.getElementById("handle");
var awesomplete = new Awesomplete(input);
<?php
echo "awesomplete.list = ". $js_students . ";\n";
echo "var handles = ". $js_handles . ";\n";
?>
awesomplete.maxItems = 5;
function opennewtab() {
	var handle = document.getElementById("handle").value;
	var dropdown = document.getElementById("problem_code");
	var problem = dropdown.options[dropdown.selectedIndex].value;
	if(handle == "")
	{
		_('vs_status').innerHTML = "Fill in the user handle.";
		return;
	}
	if(handles.indexOf(handle)==-1)
	{
		_('vs_status').innerHTML = "Invalid user handle.";
		return;
	}
	_('vs_status').innerHTML = "";
	var url = "<?=WEB_URL?>/viewsolution/";
	url = url + handle + "/" + problem;
	var win = window.open(url, "_blank");
	win.focus();
}
</script>
</html>