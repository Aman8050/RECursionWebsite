<?php
	require_once("./includes/check_admin_status.php");
	if($admin_ok == false)
	{
		echo 'You are not logged in.';
		exit();
	}
	if($admin_ok == true)
	{
		$class = $admin_class;
		$query = "SELECT * FROM admins WHERE class='{$class}'";
		$admins = $connection->query($query);
		foreach($admins as $admin);
		if(isset($_POST['problem_list']) && isset($_POST['class']))
		{
			If($admin_class == "superadmin")
			{
				$class = mres($_POST['class']);
			}
			foreach($_POST['problem_list'] as $check)
			{
				$check = mres($check);
				$query = "DELETE FROM problems WHERE code = '{$check}' AND class = '{$class}'";
				$result = $connection->query($query);
			}
			echo 'success';
			exit();
		}
		if(isset($_POST["code"]) && isset($_POST["name"]) && isset($_POST["class"]))
		{
			If($admin_class == "superadmin")
			{
				$class = mres($_POST['class']);
			}
			$code = mres($_POST['code']);
			$name = mres($_POST['name']);
			$query = "INSERT INTO problems (code, name, class) VALUES ('{$code}', '{$name}', '{$class}')";
			$result = $connection->query($query);
			echo 'success';
			exit();
		}
		if(isset($_POST['student_list']) && isset($_POST['class']))
		{
			If($admin_class == "superadmin")
			{
				$class = mres($_POST['class']);
			}
			foreach($_POST['student_list'] as $check)
			{
				$check = mres($check);
				$query = "DELETE FROM students WHERE handle = '{$check}' AND class = '{$class}'";
				$result = $connection->query($query);
			}
			echo 'success';
			exit();
		}
		if(isset($_POST["roll"]) && isset($_POST["st_name"]) && isset($_POST["handle"]) && isset($_POST["pass"]) && isset($_POST["class"]))
		{
			If($admin_class == "superadmin")
			{
				$class = mres($_POST['class']);
			}
			$roll = mres($_POST['roll']);
			$name = mres($_POST['st_name']);
			$handle = mres($_POST['handle']);
			$pass = mres($_POST['pass']);
			$query = "INSERT INTO students (roll, name, handle, class, password) VALUES ('{$roll}', '{$name}', '{$handle}', '{$class}', '{$pass}')";
			$result = $connection->query($query);
			echo 'success';
			exit();
		}
	}
?>