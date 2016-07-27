<html>
<head>
	<title>Problems to solve | <?php echo $user['name']; ?></title>
	<link rel="shortcut icon" href="<?= BASE_URL ?>/images/computer.png" type="image/png">
	<link href="<?= BASE_URL ?>/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="<?= BASE_URL ?>/css/user.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto" />
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Varela+Round" />
</head>
<body>
	<div class="header_back" id="header">
		<div class="header row">
			<div class="header_left">
				<div id="site_name"><a href="<?= WEB_URL ?>">CodeCracker</a></div>
				<div id="site_logo" style="display:none;"><img src="<?= BASE_URL ?>/images/computer.png"/></div>
			</div>
			<div class="header_right">
				<?php
					echo $user['name'];
				?>
			</div>
		</div>
	</div>
		<!--echo $user['name'].' | '.$user['handle'].' | '.$user['roll'];-->
	<div class="body1">
		<div class="prob_list">
			<div class="heading">
				Problems to be Solved
			</div>
			<div class="section">
				<table>
					<thead>
						<tr>
							<td>Name</td>
							<td>Q.Code</td>
							<td class="text-center">Status</td>
							<td class="text-center">Submit</td>
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
								<td><a title="Submit Solution on SPOJ" href="http://www.spoj.com/submit/'.$problem["code"].'/" target=_blank>'.$problem["code"].'</a></td>
								<td>';
									if($flag==1) echo '<img title="Correctly submitted on SPOJ" src="'.BASE_URL.'/images/tick.png" height=20px/>';
									else if($flag==-1) echo '<img title="Incorrect submission(s) on SPOJ" src="'.BASE_URL.'/images/cross.png" height=20px/>';
									else echo '<img title="Unattempted on SPOJ" src="'.BASE_URL.'/images/minus.png" height=20px/>';
								echo '</td>
								<td><a title="Submit/Update final solution" class="button" href="'.WEB_URL.'/submit/'.$problem["code"].'" target="_blank"><img src="'.BASE_URL.'/images/plane.png" height=20px/></a></td>
								<td><a title="View Solution" class="button" href="'.WEB_URL.'/viewsolution/'.$problem["code"].'" target="_blank"><img src="'.BASE_URL.'/images/code.png" height=20px/></a></td>
							</tr>';
						}
					?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</body>
</html>