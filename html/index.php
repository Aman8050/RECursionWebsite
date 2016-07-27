<?php
	define('BASE_URL', 'http://localhost/cs/html');
	require_once('../includes/helpers.php');
	if (isset($_GET['page']))
		$page= htmlspecialchars($_GET['page']);
	else
		$page='index';
	switch($page)
	{
		case 'index' :
			require('../includes/connection.php');
			render('index');
			break;
		
		case 'student' :
			$handle = $_GET['handle'];
			render('student',array('handle' => $handle));
			break;
		
		case 'submit' :
			$problem = $_GET['problem'];
			render('submit',array('problem' => $problem));
			break;
			
		case 'viewsolution' :
			require('../includes/connection.php');
			$problem = $_GET['problem'];
			render('viewsolution',array('problem' => $problem));
			break;
			
		case 'viewsolutionadmin' :
			require('../includes/connection.php');
			$handle = $_GET['user'];
			$problem = $_GET['problem'];
			render('viewsolutionadmin',array('problem' => $problem, 'handle' => $handle));
			break;
			
		case 'login' :
			require('../includes/connection.php');
			if(isset($_GET['n']))
			{
				$noti = $_GET['n'];
				render('login',array('noti' => $noti));
			}
			else
			{
				render('login',array('noti' => 0));
			}
			break;
		
		case 'logout' :
			require('../includes/connection.php');
			render('logout');
			break;
	}

?>