<?php
	//инструкции получения баланса по счету для ajax
	require_once "connection_database.php";
	$currentconnect = connection_db($domain_name, $user, $password, $name_db);
	if (isset($_POST["moneyvalue"]))
	{
			$query = "SELECT  `idaccount` ,  `datetimeop` ,  `monebalance` 
					  FROM (
							SELECT * 
							FROM (
								SELECT * 
								FROM  `cashflows` 
								WHERE  `idaccount` =".$_POST["moneyvalue"]." AND  `%` IS NULL 
								ORDER BY  `datetimeop` DESC 
								LIMIT 1
							)A
					  )B
					  ORDER BY  `datetimeop` DESC 
					  LIMIT 1";
			$query_run = mysql_query($query);
			$row = mysql_fetch_array($query_run);						
			if ((mysql_num_rows($query_run) > 0) && (!is_null($row["monebalance"])))
			{
				echo $row["monebalance"];
			}
			else
				echo "Записи приема наличных не осуществлялись";
	}
?>