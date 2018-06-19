<?php
	//функция получения значения баланса по номеру счета
	function getbalance($account_number, $moneyvalue)
	{
		$value = 0;
		$q = "SELECT  `idaccount` ,  `datetimeop` ,  `monebalance` 
				  FROM (
						SELECT * 
						FROM (
							SELECT * 
							FROM  `cashflows` 
							WHERE  `idaccount` =" . $account_number . "
							ORDER BY  `datetimeop` DESC 
							LIMIT 1
						)A
				  )B
				  ORDER BY  `datetimeop` DESC 
				  LIMIT 1";
		$q_run = mysql_query($q);
		$c = mysql_num_rows($q_run);
		if ($c > 0)
		{
			$r = mysql_fetch_array($q_run);
			$value = $moneyvalue + $r["monebalance"];	
		}
		else
		{
			$value = $moneyvalue;
		}	
		return $value ;	
	}
?>