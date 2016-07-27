<?php
include_once("./includes/check_login_status.php");
// If user is already logged in, header that weenis away
if($user_ok == true){
	header("location: ".WEB_URL);
    exit();
}
else if($admin_ok == true){
	header("location: ".WEB_URL);
    exit();
}
?><?php
// AJAX CALLS THIS LOGIN CODE TO EXECUTE
if(isset($_POST["h"])){
	// CONNECT TO THE DATABASE
	include_once("../includes/connection.php");
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES AND SANITIZE
	$h = mysqli_real_escape_string($connection, $_POST['h']);
	$p = $_POST['p'];
	// GET USER IP ADDRESS
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
	// FORM DATA ERROR HANDLING
	if($h == "" || $p == ""){
		echo "login_failed";
        exit();
	} else {
	// END FORM DATA ERROR HANDLING
		$sql = "SELECT id, handle, password FROM users WHERE handle='$h' LIMIT 1";
        $query = $connection->query($sql);
        $row = mysqli_fetch_row($query);
		$db_id = $row[0];
		$db_username = $row[1];
        $db_pass_str = $row[2];
		if($p != $db_pass_str){
			echo "login_failed";
            exit();
		} else {
			// CREATE THEIR SESSIONS AND COOKIES
			$_SESSION['userid'] = $db_id;
			$_SESSION['username'] = $db_username;
			$_SESSION['password'] = $db_pass_str;
			setcookie("id", $db_id, strtotime( '+30 days' ), "/", "", "", TRUE);
			setcookie("user", $db_username, strtotime( '+30 days' ), "/", "", "", TRUE);
    		setcookie("pass", $db_pass_str, strtotime( '+30 days' ), "/", "", "", TRUE); 
			// UPDATE THEIR "IP" AND "LASTLOGIN" FIELDS
			//$sql = "UPDATE users SET ip='$ip', lastlogin=now() WHERE username='$db_username' LIMIT 1";
            //$query = $connection->query($sql);
			echo $db_username;
		    exit();
		}
	}
	exit();
}

else if(isset($_POST["c"])){
	// CONNECT TO THE DATABASE
	include_once("../includes/connection.php");
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES AND SANITIZE
	$c = mysqli_real_escape_string($connection, $_POST['c']);
	$p = $_POST['p'];
	// GET USER IP ADDRESS
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
	// FORM DATA ERROR HANDLING
	if($c == "" || $p == ""){
		echo "login_failed";
        exit();
	} else {
	// END FORM DATA ERROR HANDLING
		$sql = "SELECT id, class, password FROM admins WHERE class='$c' LIMIT 1";
        $query = $connection->query($sql);
        $row = mysqli_fetch_row($query);
		$db_id = $row[0];
		$db_username = $row[1];
        $db_pass_str = $row[2];
		if($p != $db_pass_str){
			echo "login_failed";
            exit();
		}
		else {
			// CREATE THEIR SESSIONS AND COOKIES
			$_SESSION['userid'] = $db_id;
			$_SESSION['username'] = $db_username;
			$_SESSION['password'] = $db_pass_str;
			setcookie("id", $db_id, strtotime( '+30 days' ), "/", "", "", TRUE);
			setcookie("user", $db_username, strtotime( '+30 days' ), "/", "", "", TRUE);
    		setcookie("pass", $db_pass_str, strtotime( '+30 days' ), "/", "", "", TRUE); 
			// UPDATE THEIR "IP" AND "LASTLOGIN" FIELDS
			//$sql = "UPDATE users SET ip='$ip', lastlogin=now() WHERE username='$db_username' LIMIT 1";
            //$query = $connection->query($sql);
			echo $db_username;
		    exit();
		}
	}
	exit();
}
$info = "";
if($noti==1)
{
	$info = "You are not logged in.";
}
?>
<html>
<head>
	<title>Login | CS Lab</title>
	<link rel="shortcut icon" href="<?= BASE_URL ?>/images/computer.png" type="image/png">
	<link href="<?= BASE_URL ?>/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto" />
	<link href="<?= BASE_URL ?>/css/login.css" rel="stylesheet" type="text/css">
	<script src="<?= BASE_URL ?>/js/jquery.min.js"></script>
</head>
<script>
function _(x)
{
	return document.getElementById(x);
}
function emptyElement(x){
	_(x).innerHTML = "";
}
function student_enter(){
	var h = _("handle").value;
	var p = _("password1").value;
	if(h == "" || p == "")
	{
		_("student_status").innerHTML = "Fill out all of the form data";
	}
	else
	{
		_("button_student").style.display = "none";
		_("student_status").innerHTML = 'please wait ...';
		$.ajax({
					url: "./login",
					data: { h : h , p : p},
					type: "POST",
					success: function (data,status,xhr) {
						if(data == 'login_failed')
						{
							_("student_status").innerHTML = "Login unsuccessful, please try again.";
							_("button_student").style.display = "block";
						}
						else
						{
							window.location = "";
						}
					}
				});
	}
}
function admin_enter(){
	var c = _("class").value;
	var p = _("password2").value;
	if(c == "" || p == "")
	{
		_("admin_status").innerHTML = "Fill out all of the form data";
	}
	else
	{
		_("button_admin").style.display = "none";
		_("admin_status").innerHTML = 'please wait ...';
		$.ajax({
					url: "./login",
					data: { c : c , p : p},
					type: "POST",
					success: function (data,status,xhr) {
						if(data == 'login_failed')
						{
							_("admin_status").innerHTML = "Login unsuccessful, please try again.";
							_("button_admin").style.display = "block";
						}
						else
						{
							window.location = "";
						}
					}
				});
	}
}
</script>
<body>
<div class="black_layer">
	<div class="header_back">
		<div class="header">
			<div class="header_left">
				CS LAB
			</div>
			<div class="header_right">
				SIGN UP
			</div>
		</div>
	</div>
	<div class="body1">
		<div class="info_bar">
			<div id="info" onclick="emptyElement('info')">
				<?= $info ?>
			</div>
		</div>
		<h1 class="body_header">RECursion</h1>
		<div id="login_panel">
			<h3 class="body_subheader">An environment to Code and Learn in Labs</h3>
			<h3 class="fat_header">Sign In as</h3>
			<div class="signin_as">
				<div class="btn-left">
					<div class="btn btn-orange" onclick=toggle('login_panel','student_login');>Student</div>
				</div>
				<div class="btn-right">
					<div class="btn btn-orange" onclick=toggle('login_panel','admin_login');>Admin</div>
				</div>
			</div>
		</div>
		<div id="student_login" style="display:none;">
			<h3 class="fat_header">Student Sign In
				<div class="back_img" onclick="toggle('student_login','login_panel');"><img src="<?= BASE_URL ?>/images/back.png"/></div>
			</h3>
			<form class="form-horizontal" role="form" onsubmit="student_enter(); return false;">
				<div class="form-group">
					<input type="text" class="form-control" id="handle" placeholder="Username" onfocus="emptyElement('student_status')">
				</div>
				<div class="form-group">
					<input type="password" class="form-control" id="password1" placeholder="Password" onfocus="emptyElement('student_status')">
				</div>
				<div id="student_status">
				</div>
				<div id="button_student">
					<button type="submit" class="btn btn-primary">Enter</button>
				</div>
			</form>
		</div>
		<div id="admin_login" style="display:none;">
			<h3 class="fat_header">Admin Sign In
				<div class="back_img" onclick="toggle('admin_login','login_panel');"><img src="<?= BASE_URL ?>/images/back.png"/></div>
			</h3>
			<form class="form-horizontal" role="form" onsubmit="admin_enter(); return false;">
				<div class="form-group">
					<input type="text" class="form-control" id="class" placeholder="Class" onfocus="emptyElement('admin_status')">
				</div>
				<div class="form-group">
					<input type="password" class="form-control" id="password2" placeholder="Password" onfocus="emptyElement('admin_status')">
				</div>
				<div id="admin_status">
				</div>
				<div id="button_admin">
					<button type="submit" class="btn btn-primary">Enter</button>
				</div>
			</form>
		</div>
		<div class="row boxes">
			<div class="featurebox col-lg-3 col-md-6 col-sm-6">
				<div class="centering">
					<div style="opacity:1">
						<div class="circular">
							<span class="glyphicon glyphicon-user gly" aria-hidden="true"></span>
						</div>
					<h4>Maintain a profile</h4>
					<p>Maintain a rich profile of yours...</p>
					</div>
				</div>
			</div>
			<div class="featurebox col-lg-3 col-md-6 col-sm-6">
				<div class="centering">
					<div class="circular">
						<span class="glyphicon glyphicon-question-sign gly" aria-hidden="true"></span>
					</div>
					<h4>Synced with SPOJ</h4>
					<p>Stay connected with various startups and investors.</p>
				</div>
			</div>
			<div class="featurebox col-lg-3 col-md-6 col-sm-6">
				<div class="centering">
					<div class="circular">
						<span class="glyphicon glyphicon-comment gly" aria-hidden="true"></span>
					</div>
					<h4>Submit your solutions</h4>
					<p>A forum for discussing everything under the sun.</p>
				</div>
			</div>
			<div class="featurebox col-lg-3 col-md-6 col-sm-6">
				<div class="centering">
					<div class="circular">
						<span class="glyphicon glyphicon-info-sign gly" aria-hidden="true"></span>
					</div>
					<h4>Maintains your marks</h4>
					<p>Contact other startups and investors.</p>
				</div>
			</div>
		</div>
	</div>
</body>
<script>
function toggle(obj1, obj2)
{
	document.getElementById(obj1).style.display="none";
	document.getElementById(obj2).style.display="block";
}
</script>
</html>