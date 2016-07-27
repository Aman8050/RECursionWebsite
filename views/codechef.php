<?php
	require_once("./includes/check_login_status.php");
	if($user_ok == false) exit();
	if($student_ok == true)
	{
		$cc_user = $student_handle;
		$query = "SELECT * FROM students WHERE handle='{$cc_user}'";
		$students = $connection->query($query);
		foreach($students as $student);
	}
	else
	{
		$cc_user = $reqd_user;
		if($cc_user == "") exit();
		$query = "SELECT * FROM students WHERE handle='{$cc_user}'";
		$students = $connection->query($query);
		foreach($students as $student);
		if($student['class'] != $admin_class)
		{
			exit();
		}
	}
	date_default_timezone_set("Asia/Kolkata");
	$present_time = time();
	$p_t = date('Y-m-d H:i:s', $present_time);
	if($present_time - strtotime($student['lastfetch']) < 30)
	{
		$cc_data = $student['ccdata'];
		$cc_data = json_decode($cc_data);
		$cc_data[0] = "db";
		$json = json_encode($cc_data);
		echo $json;
	}
	else
	{
		require('./includes/simple_html_dom.php');
		require('./includes/cc.php');
		if($fetched == TRUE)
		{
			$class = mres($student["class"]);
			$query = "SELECT * FROM problems WHERE active=1 AND class='{$class}'";
			$allproblems = $connection->query($query);
			$reqd_array = [];
			$correct = [];
			$unattempted = [];
			foreach($allproblems as $problem)
			{
				$flag = 0;
				foreach($solved_q as $this_prob)
				{
					if($problem['code']==$this_prob)
					{
						$flag = 1;
						$problem_det = [];
						$problem_det[] = hsc($problem['code']);
						$problem_det[] = hsc($problem['name']);
						$correct[] = $problem_det;
						break;
					}
				}
				if($flag==0)
				{
					$problem_det = [];
					$problem_det[] = hsc($problem['code']);
					$problem_det[] = hsc($problem['name']);
					$unattempted[] = $problem_det;
				}
			}
			$reqd_array[] = $correct;
			$reqd_array[] = $unattempted;
			$data = [];
			$data[] = "success";
			$data[] = $reqd_array;
			$json = json_encode($data);
			echo $json;
			$json = mres($json);
			$query = "UPDATE students SET lastfetch='{$p_t}', ccdata='{$json}' WHERE handle='{$cc_user}'";
			$result = $connection->query($query);
		}
		else
		{
			if($student['ccdata']!="")
			{
				$cc_data = $student['ccdata'];
				$cc_data = json_decode($cc_data);
				$cc_data[0] = "old";
				$json = json_encode($cc_data);
				echo $json;
			}
			else
			{
				$str = "fail";
				$cc_data = [];
				$cc_data[] = $str;
				$json = json_encode($cc_data);
				echo $json;
			}
		}
	}
?>