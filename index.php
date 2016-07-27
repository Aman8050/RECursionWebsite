<?php
	$domain = $_SERVER['HTTP_HOST'];
	define('BASE_URL', 'http://'.$domain.'/html');
	define('WEB_URL', 'http://'.$domain);
	define('CC', 'https://www.codechef.com/SEPT14/');
	require_once('./includes/helpers.php');
	if (isset($_GET['page']))
		$page= htmlspecialchars($_GET['page']);
	else
		$page='index';
	switch($page)
	{
		case 'index' :
			require('./includes/connection.php');
			render('index');
			break;
		
		case 'student' :
			require('./includes/connection.php');
			$handle = $_GET['handle'];
			render('student',array('handle' => $handle));
			break;
		
		case 'submit' :
			require('./includes/connection.php');
			$problem = $_GET['problem'];
			render('submit',array('problem' => $problem));
			break;
			
		case 'viewsolution' :
			require('./includes/connection.php');
			$problem = $_GET['problem'];
			render('viewsolution',array('problem' => $problem));
			break;
			
		case 'viewsolutionadmin' :
			require('./includes/connection.php');
			$handle = $_GET['user'];
			$problem = $_GET['problem'];
			render('viewsolutionadmin',array('problem' => $problem, 'handle' => $handle));
			break;
			
		case 'login' :
			require('./includes/connection.php');
			if(isset($_GET['n']))
			{
				$noti = $_GET['n'];
				render('log',array('noti' => $noti));
			}
			else
			{
				render('log',array('noti' => 0));
			}
			break;
		
		case 'logout' :
			require('./includes/connection.php');
			render('logout');
			break;
			
		case 'codechef' :
			require('./includes/connection.php');
			if(isset($_GET['user']))
			{
				$reqd_user = $_GET['user'];
			}
			else
			{
				$reqd_user = "";
			}
			render('codechef',array('reqd_user' => $reqd_user));
			break;
		case 'cc' :
			require('./includes/connection.php');
			require('./includes/simple_html_dom.php');
			render('cc');
			break;
			
		case 'changepassword' :
			require('./includes/connection.php');
			render('changepassword');
			break;
			
		case 'settings' :
			require('./includes/connection.php');
			render('settings');
			break;
			
		case 'change' :
			require('./includes/connection.php');
			render('change');
			break;
	}

?>