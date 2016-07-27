<?php
	include_once("./includes/check_login_status.php");
	require('./includes/connection.php');
	if($admin_ok == false)
	{
		header("location: ".WEB_URL."/login");
	}
	else
	{
		$username = $handle;
		$query = "SELECT * FROM users WHERE handle='{$username}'";
		$users = $connection->query($query);
		foreach($users as $user);
		if($user['class'] != $log_username)
		{
			header("location: ".BASE_URL);
		}
		else
		{
			$query = "SELECT * FROM problems WHERE class='{$log_username}'";
			$allproblems = $connection->query($query);
			$json = file_get_contents('http://localhost:8080/?user='.$username);
			$solved_probs = json_decode($json);
			$correct_probs = $solved_probs->solved;
			$wrong_probs = $solved_probs->todo;
		}
	}
?>
<html>
<head>
	<title><?php echo $username;?> | Submissions</title>
	<link rel="shortcut icon" href="<?= BASE_URL ?>/images/computer.png" type="image/png">
	<link href="<?= BASE_URL ?>/css/student.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto" />
</head>
<body>
	<div class="header">
		CS-101 | Admin
	</div>
	<div class="page_details">
	<?php
		echo $user['name'].' | '.$user['handle'].' | '.$user['roll'];
	?>
	</div>
	<div class="prob_list">
		<div class="heading">
			Problems solved
		</div>
		<div class="section">
			<table>
				<thead>
					<tr>
						<td>Name</td>
						<td>Q.Code</td>
						<td class="text-center">Status</td>
						<td class="text-center">Submission</td>
					</tr>
				</thead>
				<tbody>
				<?php
					$prob_count = 0;
					foreach($allproblems as $problem)
					{
						$flag=0;
						foreach($correct_probs as $this_prob)
						{
							if($problem['code']==$this_prob)
							{
								$flag=1;
								break;
							}
						}
						if($flag==0)
						foreach($wrong_probs as $this_prob)
						{
							if($problem['code']==$this_prob)
							{
								$flag=-1;
								break;
							}
						}
						$prob_count += 1;
						if($flag==1) echo '<tr class="green_text">';
						else if($flag==-1) echo '<tr class="red_text">';
						else echo '<tr class="orange_text">';
						echo'
							<td><a href="http://www.spoj.com/problems/'.$problem["code"].'/" target=_blank>'.$problem["name"].'</a></td>
							<td><a title="View submission history on SPOJ" href="http://www.spoj.com/status/'.$problem["code"].','.$user['handle'].'/" target=_blank>'.$problem["code"].'</a></td>
							<td>';
								if($flag==1) echo '<img title="Correctly submitted on SPOJ" src="'.BASE_URL.'/images/tick.png" height=20px/>';
								else if($flag==-1) echo '<img title="Incorrect submission(s) on SPOJ" src="'.BASE_URL.'/images/cross.png" height=20px/>';
								else echo '<img title="Unattempted on SPOJ" src="'.BASE_URL.'/images/minus.png" height=20px/>';
							echo '</td>
							<td><a title="View final solution" class="button" href="'.WEB_URL.'/viewsolution/'.$user['handle'].'/'.$problem["code"].'" target="_blank"><img src="'.BASE_URL.'/images/code.png" height=20px/></a></td>
						</tr>';
					}
				?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>