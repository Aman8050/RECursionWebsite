<?php
	require_once("./includes/check_login_status.php");
	if($user_ok == false) header("location: ".WEB_URL."/login");
	if($admin_ok == true)
	{
		$class = mres($admin_class);
		if(isset($_POST['problem_list']))
		{
			$query = "UPDATE problems SET active = 0 WHERE class = '{$class}'";
			$result = $connection->query($query);
			foreach($_POST['problem_list'] as $check)
			{
				$check = mres($check);
				$query = "UPDATE problems SET active = 1 WHERE code = '{$check}' AND class = '{$class}'";
				$result = $connection->query($query);
			}
			header("location: ".WEB_URL);
		}
		$query = "SELECT * FROM problems WHERE class = '{$class}'";
		$allproblems = $connection->query($query);
		$query = "SELECT * FROM students WHERE class = '{$class}'";
		$allstudents = $connection->query($query);
		$query = "SELECT * FROM admins WHERE class='{$class}'";
		$admins = $connection->query($query);
		foreach($admins as $admin);
		render('admin',array('allproblems' => $allproblems, 'allstudents' => $allstudents, 'admin' => $admin));
	}
	else if($student_ok == true)
	{
		$username = mres($student_handle);
		$query = "SELECT * FROM students WHERE handle='{$username}'";
		$students = $connection->query($query);
		foreach($students as $student);
		$class = $student["class"];
		render('user',array('student' => $student));
	}
?>