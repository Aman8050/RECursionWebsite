<?php
$CC_URL = "https://www.codechef.com/api/rankings/SEPT14?search=".$spoj_user;
$html = @file_get_html($CC_URL); //get the html returned from the following url
$fetched = FALSE;
if($html == "")
{
}
else
{
	$data = json_decode($html);
	
	$solved_q = [];
	$wrong_q = [];
	if(!empty($html)) //if any html is actually returned
	{
		$td = $html->find('td[valign=top]')[0];
		if($td->plaintext == 'Problems Successfully Solved:')
		{
			$contests = $td->next_sibling()->children();
			foreach($contests as $contest)
			{
				if($contest->children(0)->plaintext == "SEPT14")
				{
					$links = $contest->children(1)->find('a');
					foreach($links as $link)
					{
						if($link->plaintext != "")
						{
							$solved_q[] = $link->plaintext;
						}
					}
				}
			}
		}
		$fetched = TRUE;
	}
}
?>