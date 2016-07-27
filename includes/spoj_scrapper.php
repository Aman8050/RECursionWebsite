<?php
$SPOJ_URL = "http://spoj.com/users/".$spoj_user;
$html = @file_get_html($SPOJ_URL); //get the html returned from the following url
$fetched = FALSE;
if($html == FALSE)
{
}
else{
if(!empty($html)) //if any html is actually returned
{
	$solved_q = [];
	$wrong_q = [];
	$tables = $html->find('table[class=table table-condensed]');
	if(count($tables)==1)
	{
		$table = $tables[0];
		foreach($table->find('a') as $link)
		{
			if($link->plaintext != "")
			{
				$solved_q[] = $link->plaintext;
			}
		}
	}
	$tables = $table = $html->find('table[class=table]');
	if(count($tables) > 0)
	{
		$flag_table = 0;
		if(count($tables) == 2)
		{
			$table = $html->find('table[class=table]')[1];
			$flag_table = 1;
		}
		else if(count($tables) == 1)
		{
			$table = $html->find('table[class=table]')[0];
			if($table->getAttribute('class') == "table") $flag_table = 1;
			
		}
		if($flag_table == 1)
		foreach($table->find('a') as $link)
		{
			if($link->plaintext != "")
			{
				$wrong_q[] = $link->plaintext;
			}
		}
	}
	$fetched = TRUE;
}
}
?>