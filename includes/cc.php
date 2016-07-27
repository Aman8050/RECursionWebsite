<?php
$fetched = FALSE;
$solved_q = [];
$comment = "";
$CC_URL = "http://www.codechef.com/api/rankings/SEPT14?search=".$cc_user;
$html = @file_get_html($CC_URL); //get the html returned from the following url
if($html == "" || $html == FALSE)
{
	$comment = "Couldnot connect";
}
else
{
	$flag = 0;
	$data = json_decode($html, True);
	$persons = $data["list"];
	foreach($persons as $person)
	{
		if($person["user_handle"] == $cc_user)
		{
			$flag = 1;
			$problems_status = $person["problems_status"];
			$names = array_keys($problems_status);
			$solved_q = $names;
			break;
		}
	}
	if($flag == 0)
	{
		$comment = "User not found";
	}
	else
	{
		$comment = "Success";
	}
	$fetched = true;
}
?>