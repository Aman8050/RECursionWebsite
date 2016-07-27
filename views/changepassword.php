<?php
	require_once("./includes/check_login_status.php");
	if($user_ok == false) header("location: ".WEB_URL."/login");
	if($admin_ok == true)
	{
		$class = $admin_class;
		$query = "SELECT * FROM admins WHERE class='{$class}'";
		$admins = $connection->query($query);
		foreach($admins as $admin);
		if(isset($_POST["current"]) && isset($_POST["new"]) && isset($_POST["confirm"]))
		{
			if($_POST["current"] != $admin['password'])
			{
				echo 'The current password is not correct.';
				exit();
			}
			if($_POST["new"] != $_POST["confirm"])
			{
				echo 'The new passwords didnot match.';
				exit();
			}
			$current = preg_replace('#[^a-z0-9_]#i', '', $_POST["current"]);
			$new = preg_replace('#[^a-z0-9_]#i', '', $_POST["new"]);
			$confirm = preg_replace('#[^a-z0-9_]#i', '', $_POST["confirm"]);
			if(strlen($new) < 8 ||strlen($new)>20)
			{
				echo 'Password must be between 8 and 20 characters long.';
				exit();
			}
			if($new != $_POST["new"])
			{
				echo 'Password can contain only alphanumeric characters and underscore.';
				exit();
			}
			$id = $admin['id'];
			$new = mres($new);
			$query = "UPDATE `cslab`.`admins` SET password = '{$new}' WHERE id = '{$id}';";
			$result = $connection->query($query);
			if($result == false)
			{
				echo 'Attempt failed. Please try again.';
				exit();
			}
			session_start();
			$_SESSION = array();
			if(isset($_COOKIE["id"]) && isset($_COOKIE["user"]) && isset($_COOKIE["pass"])) {
				setcookie("id", '', strtotime( '-5 days' ), '/');
				setcookie("user", '', strtotime( '-5 days' ), '/');
				setcookie("pass", '', strtotime( '-5 days' ), '/');
			}
			session_destroy();
			echo 'success';
			exit();
		}
	}
	else if($student_ok == true)
	{
		$username = $student_handle;
		$query = "SELECT * FROM students WHERE handle='{$username}'";
		$students = $connection->query($query);
		foreach($students as $student);
		if(isset($_POST["current"]) && isset($_POST["new"]) && isset($_POST["confirm"]))
		{
			if($_POST["current"] != $student['password'])
			{
				echo 'The current password is not correct.';
				exit();
			}
			if($_POST["new"] != $_POST["confirm"])
			{
				echo 'The new passwords didnot match.';
				exit();
			}
			$current = preg_replace('#[^a-z0-9_]#i', '', $_POST["current"]);
			$new = preg_replace('#[^a-z0-9_]#i', '', $_POST["new"]);
			$confirm = preg_replace('#[^a-z0-9_]#i', '', $_POST["confirm"]);
			if(strlen($new) < 8 ||strlen($new)>20)
			{
				echo 'Password must be between 8 and 20 characters long.';
				exit();
			}
			if($new != $_POST["new"])
			{
				echo 'Password can contain only alphanumeric characters and underscore.';
				exit();
			}
			$id = $student['id'];
			$new = mres($new);
			$query = "UPDATE `cslab`.`students` SET password = '{$new}' WHERE id = '{$id}';";
			$result = $connection->query($query);
			if($result == false)
			{
				echo 'Attempt failed. Please try again.';
				exit();
			}
			session_start();
			$_SESSION = array();
			if(isset($_COOKIE["id"]) && isset($_COOKIE["user"]) && isset($_COOKIE["pass"])) {
				setcookie("id", '', strtotime( '-5 days' ), '/');
				setcookie("user", '', strtotime( '-5 days' ), '/');
				setcookie("pass", '', strtotime( '-5 days' ), '/');
			}
			session_destroy();
			echo 'success';
			exit();
		}
	}
?>
<head>
	<title>Change Password | <?php if($student_ok) echo hsc($student['name']); else echo hsc($admin['name']); ?></title>
	<link rel="shortcut icon" href="<?= BASE_URL ?>/images/computer.png" type="image/png">
	<link href="<?= BASE_URL ?>/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="<?= BASE_URL ?>/css/header.css" rel="stylesheet" type="text/css">
	<link href="<?= BASE_URL ?>/css/changepassword.css" rel="stylesheet" type="text/css">
	<script src="<?= BASE_URL ?>/js/jquery.min.js"></script>
	<script src="<?= BASE_URL ?>/js/bootstrap.min.js"></script>
</head>
<body>
	<?php
	if($student_ok) render('../templates/header_student',array('student_name' => hsc($student['name'])));
	else render('../templates/header_admin',array('admin_name' => hsc($admin['name'])));
	?>
	<div class="body1">
		<div class="change_pass row">
			<div class="col-lg-12 wrong" id="wrong">
				<div class="heading">
					Change Password
				</div>
				<div class="table-responsive">
					<div id="cp_status">
					</div>
					<form class="cp_form row" onsubmit="changepass(); return false;">
						<div class="form-group">
							<div class="col-lg-3 col-md-3 col-sm-2"></div>
							<label for="current" class="control-label col-lg-2 col-md-2 col-sm-4">Current Password:</label>
							<div class="col-lg-4 col-md-4 col-sm-4">
								<input id="current" type="password" class="form-control" name="current" placeholder="Current Password"/>
							</div>
							<div class="col-lg-3 col-md-3 col-sm-2"></div>
						</div>
						<div class="form-group">
							<div class="col-lg-3 col-md-3 col-sm-2"></div>
							<label for="new" class="control-label col-lg-2 col-md-2 col-sm-4">New Password:</label>
							<div class="col-lg-4 col-md-4 col-sm-4">
								<input id="new" type="password" class="form-control" name="new" placeholder="New Password"/>
							</div>
							<div class="col-lg-3 col-md-3 col-sm-2"></div>
						</div>
						<div class="form-group">
							<div class="col-lg-3 col-md-3 col-sm-2"></div>
							<label for="confirm" class="control-label col-lg-2 col-md-2 col-sm-4">Confirm Password:</label>
							<div class="col-lg-4 col-md-4 col-sm-4">
								<input id="confirm" type="password" class="form-control" name="confirm" placeholder="Confirm Password"/>
							</div>
							<div class="col-lg-3 col-md-3 col-sm-2"></div>
						</div>
						<div class="form-group">
							<div class="col-lg-3 col-md-3 col-sm-2"></div>
							<div class="col-lg-6 col-md-6 col-sm-8">
								<button type="submit" id="save_button" class="btn btn-danger">Save Changes</button>
							</div>
							<div class="col-lg-3 col-md-3 col-sm-2"></div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<script>
function _(x)
{
	return document.getElementById(x);
}
function _focus(x)
{
	x.focus();
}
function emptyElement(x){
	_(x).innerHTML = "";
}
function remove_status()
{
	emptyElement('cp_status');
}
function verify(currentp, newp, confirmp)
{
	if(currentp == "" || newp == "" || confirmp == "")
	{
		_("cp_status").innerHTML = "Fill out all of the form data";
		return false;
	}
	var re = new RegExp("^[a-zA-Z0-9_]+$");
	if (!re.test(newp))
	{
		_("cp_status").innerHTML = "Password can contain only alphanumeric characters and underscore.";
		return false;
	}
	if(newp.length<8 || newp.length>20)
	{
		_("cp_status").innerHTML = "Password must be between 8 and 20 characters long.";
		return false;
	}
	if(newp != confirmp)
	{
		_("cp_status").innerHTML = "The new passwords didnot match.";
		return false;
	}
	return true;
}
function changepass(){
	var currentp = _("current").value;
	var newp = _("new").value;
	var confirmp = _("confirm").value;
	var check = verify(currentp, newp, confirmp);
	if(check)
	{
		_("save_button").disabled = true;
		_("cp_status").innerHTML = 'please wait ...';
		$.ajax({
					url: "./changepassword",
					data: { current : currentp , new : newp , confirm : confirmp},
					type: "POST",
					success: function (data,status,xhr) {
						if(data == 'success')
						{
							window.location = "./login";
						}
						else
						{
							_("cp_status").innerHTML = data;
							_("save_button").disabled = false;
						}
					},
					error: function(jqXHR, textStatus, errorThrown) {
						_("cp_status").innerHTML = "Failed to connect.";
						_("save_button").disabled = false;
					}
				});
	}
}
_('current').focus();
_('current').onfocus = function(){remove_status()};
_('new').onfocus = function(){remove_status()};
_('confirm').onfocus = function(){remove_status()};
</script>
</body>