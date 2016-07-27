<?php
require_once("./includes/check_login_status.php");
// If user is already logged in, header that weenis away
if($user_ok == true){
	header("location: ".WEB_URL);
    exit();
}
?><?php
// AJAX CALLS THIS LOGIN CODE TO EXECUTE
if(isset($_POST["h"])){
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES AND SANITIZE
	$h = mres($_POST['h']);
	$p = mres($_POST['p']);
	// GET USER IP ADDRESS
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
	// FORM DATA ERROR HANDLING
	if($h == "" || $p == ""){
		echo "login_failed";
        exit();
	} else {
	// END FORM DATA ERROR HANDLING
		$sql = "SELECT id, handle, password FROM students WHERE handle='$h' LIMIT 1";
        $query = $connection->query($sql);
        $row = mysqli_fetch_row($query);
		$db_id = mres($row[0]);
		$db_username = mres($row[1]);
        $db_pass_str = mres($row[2]);
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
			$sql = "UPDATE students SET ip='$ip', lastlogin=now() WHERE handle='$db_username' LIMIT 1";
            $query = $connection->query($sql);
			echo hsc($db_username);
		    exit();
		}
	}
	exit();
}

else if(isset($_POST["c"])){
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES AND SANITIZE
	$c = mres($_POST['c']);
	$p = mres($_POST['p']);
	// GET USER IP ADDRESS
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
	// FORM DATA ERROR HANDLING
	if($c == "" || $p == ""){
		echo "login_failed";
        exit();
	}
	else {
	// END FORM DATA ERROR HANDLING
		$sql = "SELECT id, class, password FROM admins WHERE class='$c' LIMIT 1";
        $query = $connection->query($sql);
        $row = mysqli_fetch_row($query);
		$db_id = mres($row[0]);
		$db_username = mres($row[1]);
        $db_pass_str = mres($row[2]);
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
			$sql = "UPDATE admins SET ip='$ip', lastlogin=now() WHERE class='$db_username' LIMIT 1";
            $query = $connection->query($sql);
			echo hsc($db_username);
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
	<link href="<?= BASE_URL ?>/css/log.css" rel="stylesheet" type="text/css">
	<script src="<?= BASE_URL ?>/js/jquery.min.js"></script>
</head>
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
function student_enter(){
	var h = _("handle").value;
	var p = _("password1").value;
	if(h == "" || p == "")
	{
		_("student_status").innerHTML = "Fill out all of the form data";
	}
	else
	{
		_("button_student").disabled = true;
		_("student_status").innerHTML = 'please wait ...';
		$.ajax({
					url: "./login",
					data: { h : h , p : p},
					type: "POST",
					success: function (data,status,xhr) {
						if(data == 'login_failed')
						{
							_("student_status").innerHTML = "Login unsuccessful, please try again.";
							_("button_student").disabled = false;
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
		_("button_admin").disabled = true;
		_("admin_status").innerHTML = 'please wait ...';
		$.ajax({
					url: "./login",
					data: { c : c , p : p},
					type: "POST",
					success: function (data,status,xhr) {
						if(data == 'login_failed')
						{
							_("admin_status").innerHTML = "Login unsuccessful, please try again.";
							_("button_admin").disabled = false;
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
<body id="body">
<div class="black_layer">
	<div class="header_back" id="header">
		<div class="header row">
			<div class="header_left">
				<div id="site_name"><a href="<?= WEB_URL ?>">CodeCracker</a></div>
				<div id="site_logo" style="display:none;"><img src="<?= BASE_URL ?>/images/computer.png"/></div>
			</div>
			<div class="header_right">
				SIGN UP
			</div>
		</div>
	</div>
	<div class="body1" id="body1">
	<div class="row">
		<div class="info_bar">
			<div id="info" onclick="emptyElement('info')">
				<?= $info ?>
			</div>
		</div>
		<div class="left_body1 col-lg-6 col-md-6">
			<div class="welcome_text">
				<div class="body_header">
					<h1>Practice and Learn<br>to Code in Labs.</h1>
					<h2>A platform by RECursion.</h2>
				</div>
			</div>
		</div>
		<div class="right_body1 col-lg-6 col-md-6" id="right_body1">
			<div class="login_box" id="login_box">
				<ul id="login_wrapper">
				<li id="student_login">
					<h3 class="fat_header">Student Sign In</h3>
					<form class="form-horizontal login_form" role="form" onsubmit="student_enter(); return false;">
						<div id="student_status">
						</div>
						<div class="form-group">
							<input type="text" class="form-control" id="handle" placeholder="Username" onfocus="emptyElement('student_status')">
						</div>
						<div class="form-group">
							<input type="password" class="form-control" id="password1" placeholder="Password" onfocus="emptyElement('student_status')">
						</div>
						<div>
							<button id="button_student" type="submit" class="btn">Enter</button>
						</div>
						<div class="signinas" id="signinasadmin">
							<a onclick="admin_signin()">Sign In as admin</a>
						</div>
					</form>
				</li>
				<li id="admin_login">
					<h3 class="fat_header">Admin Sign In</h3>
					<form class="form-horizontal login_form" role="form" onsubmit="admin_enter(); return false;">
						<div id="admin_status">
						</div>
						<div class="form-group">
							<input type="text" class="form-control" id="class" placeholder="Class" onfocus="emptyElement('admin_status')">
						</div>
						<div class="form-group">
							<input type="password" class="form-control" id="password2" placeholder="Password" onfocus="emptyElement('admin_status')">
						</div>
						<div>
							<button id="button_admin" type="submit" class="btn">Enter</button>
						</div>
						<div class="signinas" id="signinasstudent">
							<a onclick="student_signin()">Sign In as student</a>
						</div>
					</form>
				</li>
				</ul>
			</div>
		</div>
	</div>
	</div>
	<div class="body2 row" id="body2">
		<h2>Features of CodeCracker</h2>
		<div class="col-lg-6 col-md-6 feature">
			<div class="feature_image">
				<img src="<?= BASE_URL ?>/images/q.png"/>
			</div>
			<div class="feature_text">
				<div class="feature_head">
					Question Set
				</div>
				<div class="feature_desc">
					Solve from a prescribed set of questions tailored according to your learning requirements.
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 feature">
			<div class="feature_image">
				<img src="<?= BASE_URL ?>/images/spoj.png"/>
			</div>
			<div class="feature_text">
				<div class="feature_head">
					Synced with CodeChef
				</div>
				<div class="feature_desc">
					Have your solutions verified by the CodeChef Judge before you make a final submission.
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 feature">
			<div class="feature_image">
				<img src="<?= BASE_URL ?>/images/code2.png"/>
			</div>
			<div class="feature_text">
				<div class="feature_head">
					Code Manager
				</div>
				<div class="feature_desc">
					Submit and manage your class assignments which can then be reviewed by the teacher.
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 feature">
			<div class="feature_image">
				<img src="<?= BASE_URL ?>/images/user.png"/>
			</div>
			<div class="feature_text">
				<div class="feature_head">
					Admin Panel
				</div>
				<div class="feature_desc">
					An interface for the faculty to maintain the problem list and review the assignments of the students.
				</div>
			</div>
		</div>
	</div>
	<footer>
		<div class="row">
			<div class="footer">
				Developed and maintained by RECursion.
			</div>
		</div>
	</footer>
</body>
<script>
function toggle(obj1, obj2)
{
	document.getElementById(obj1).style.display="none";
	document.getElementById(obj2).style.display="block";
}
function admin_signin()
{
	_('login_wrapper').style.left = '-' + parseInt(Math.min(_('right_body1').offsetWidth - 30, 500)) + 'px';
	var to = setTimeout(function(){_focus(_('class'))},500);
}
function student_signin()
{
	_('login_wrapper').style.left = '0px';
	var to = setTimeout(function(){_focus(_('handle'))},500);
}
_('handle').focus();
function myFunction()
{
	if(window.scrollY > _('body1').offsetHeight - 80)
	{
		_('site_name').style.display='none';
		_('site_logo').style.display='block';
	}
	else
	{
		_('site_logo').style.display='none';
		_('site_name').style.display='block';
	}
}
function resize_func()
{
	var reqd_width = Math.min(_('right_body1').offsetWidth - 30,_('header').offsetWidth - 30);
	reqd_width = Math.min(reqd_width,500);
	_('login_wrapper').style.width=parseInt(reqd_width*2) + 'px';
	_('login_box').style.width = reqd_width + 'px';
	_('student_login').style.width = reqd_width + 'px';
	_('admin_login').style.width = reqd_width + 'px';
}
window.onscroll = function() {myFunction()};
resize_func();
window.onresize = function() {resize_func()};
</script>
</html>