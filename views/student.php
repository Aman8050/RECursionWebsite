<?php
	require_once("./includes/check_login_status.php");
	if($admin_ok == false)
	{
		header("location: ".WEB_URL."/login");
	}
	else
	{
		$username = mres($handle);
		$query = "SELECT * FROM students WHERE handle='{$username}'";
		$students = $connection->query($query);
		foreach($students as $student);
		if($student['class'] != $admin_class)
		{
			header("location: ".BASE_URL);
		}
		$query = "SELECT * FROM admins WHERE class='{$admin_class}'";
		$admins = $connection->query($query);
		foreach($admins as $admin);
	}
?><html>
<head>
	<title>Problems to solve | <?php echo hsc($admin['name']); ?></title>
	<link rel="shortcut icon" href="<?= BASE_URL ?>/images/computer.png" type="image/png">
	<link href="<?= BASE_URL ?>/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="<?= BASE_URL ?>/css/header.css" rel="stylesheet" type="text/css">
	<link href="<?= BASE_URL ?>/css/user.css" rel="stylesheet" type="text/css">
	<script src="<?= BASE_URL ?>/js/jquery.min.js"></script>
	<script src="<?= BASE_URL ?>/js/bootstrap.min.js"></script>
</head>
<body>
	<?php
	render('../templates/header_admin',array('admin_name' => hsc($admin['name'])));
	?>
	<div class="body1">
		<div id="notification" onclick="remove_noti()">
			<span id="noti_text"></span>
			<span id="noti_cross">X</span>
		</div>
		<div id="inform" class="row">
		</div>
		<div class="prob_list row" id="prob_list" style="display:none;">
			<div class="col-lg-6 col-md-6 correct" id="correct">
				<div class="heading">
					Problems Correctly Solved
					<span class="table_head_icon">
						<img src="/html/images/checkmark.png" />
					</span>
				</div>
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<td>Name</td>
								<td>Q.Code</td>
								<td class="text-center">Submission</td>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-lg-6 col-md-6 unattempted" id="unattempted">
				<div class="heading">
					Unattempted Problems
					<span class="table_head_icon">
						<img src="/html/images/questionmark.png" />
					</span>
				</div>
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<td>Name</td>
								<td>Q.Code</td>
								<td class="text-center">Submission</td>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<script>

function _(x)
{
	return document.getElementById(x);
}
function section_name(x)
{
	if(x==0) return 'correct';
	else if(x==1) return 'unattempted';
}
function section_color(x)
{
	if(x==0) return 'green';
	else if(x==1) return 'blue';
}
function remove_noti()
{
	_('notification').style.top = '-30px';
	var t = setTimeout(function(){_('noti_text').innerHTML="";},500);
}

function show_noti()
{
	_('notification').style.top = '0px';
	var t = setTimeout(function(){remove_noti()},3000);
}
function place_data(data)
{
	for(j=0;j<=1;j++)
	{
		if(data[j].length == 0)
		{
			_(section_name(j)).style.display = "none";
		}
		else
		{
			for(i=0;i<data[j].length;i++)
			{
				var tr = document.createElement('tr');
				tr.innerHTML ='<td><a href="" target=_blank></a></td><td><a title="Submit Solution on SPOJ" href="" target=_blank></a></td><td class="text-center"><a title="View Solution" href="" target="_blank"><img src="" height=20px/></a></td>';
				var prob = data[j][i];
				var tbody = _(section_name(j)).getElementsByTagName('TBODY')[0];
				tbody.appendChild(tr);
				this_tr = tbody.lastChild;
				var links = this_tr.getElementsByTagName('A');
				links[0].setAttribute("href", "<?php echo CC ?>problems/" + prob[0]);
				links[1].setAttribute("href", "<?php echo CC ?>status/" + prob[0] + "?handle=<?php echo $username;?>");
				links[2].setAttribute("href", "/viewsolution/" + "<?php echo $username;  ?>" + "/" + prob[0]);
				var table_cell = this_tr.firstChild;
				table_cell.firstChild.textContent = prob[1];
				table_cell = table_cell.nextSibling;
				table_cell.firstChild.textContent = prob[0];
				table_cell = table_cell.nextSibling;
				table_cell.getElementsByTagName('IMG')[0].setAttribute("src","../html/images/code-"+ section_color(j) +".png");
			}
		}
	}
	_('inform').style.display = "none";
	_('prob_list').style.display = "block";
	
}
function get_content()
{
	_('inform').innerHTML = "Fetching data...";
	$.ajax({
		url: "../codechef",
		data: { user : '<?php echo hsc($username);  ?>'},
		type: "GET",
		success: function (data,status,xhr) {
			if(data == '')
			{
				_('inform').innerHTML = "No data found!";
			}
			else
			{
				_('inform').innerHTML = data;
				data = JSON.parse(data);
				if(data[0]=="success")
				{
					_('noti_text').innerHTML = "Data successfully fetched.";
					show_noti();
					place_data(data[1]);
				}
				else if(data[0]=="old")
				{
					_('noti_text').innerHTML = "Could not connect now. Previous data displayed.";
					show_noti();
					place_data(data[1]);
				}
				else if(data[0]=="db")
				{
					_('noti_text').innerHTML = "Data fetched from database.";
					show_noti();
					place_data(data[1]);
				}
				else if(data[0]=="fail")
				{
					_('inform').innerHTML = "Couldnot connect. Please try again.";
				}
			}
		}
	});
}
get_content();
</script>