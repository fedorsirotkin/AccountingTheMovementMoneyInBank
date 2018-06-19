<?php
	//инструкции по начислению процентов
	//процент начисляется каждый месяц
	//формула - Fv = Sv * ( 1 + R * (Td / Ty) ), где
	//Fv = Sv * ( 1 + R * (Td / Ty) ), где
	//Fv — итоговая сумма;
	//Sv — начальная сумма;
	//R — годовая процентная ставка;
	//Td — срок вклада в днях;
	//Ty — количество дней в году.
	
	//депозит до востребования (процент - 1%)
	function demanddeposits($idaccount, $Sv, $moneytype, $idaccount, $moneyvalue, $date, $time)
	{
		//дата последнего начисления процентов
		$query = "SELECT  `idaccount` ,  `datetimeop` ,  `monebalance` 
				  FROM (
						SELECT * 
						FROM (
							SELECT * 
							FROM  `cashflows` 
							WHERE  `idaccount` =" . $idaccount . " AND `%`=1
							ORDER BY  `datetimeop` DESC 
							LIMIT 1
						)A
				  )B
				  ORDER BY  `datetimeop` DESC 
				  LIMIT 1";
		$query_run = mysql_query($query);
		$row = mysql_fetch_array($query_run);						
		if ((mysql_num_rows($query_run) > 0) && (!is_null($row["datetimeop"])))
		{
			$firstdate = $row["datetimeop"];	
		}
		else
		{
			//дата первого вклада
			$query = "SELECT  `idaccount` ,  `datetimeop` ,  `monebalance` 
					  FROM (
							SELECT * 
							FROM (
								SELECT * 
								FROM  `cashflows` 
								WHERE  `idaccount` =" . $idaccount . "
								ORDER BY  `datetimeop` ASC 
								LIMIT 1
							)A
					  )B
					  ORDER BY  `datetimeop` ASC 
					  LIMIT 1";
			$query_run = mysql_query($query);
			$row = mysql_fetch_array($query_run);						
			if ((mysql_num_rows($query_run) > 0) && (!is_null($row["datetimeop"])))
			{
				$firstdate = $row["datetimeop"];
			}
			else
			{
				echo "<p>Ошибка! Дата первого вклада не найдена!</p>";	
			}
		}
		//дата последнего вклада
		$query = "SELECT  `idaccount` ,  `datetimeop` ,  `monebalance` 
				  FROM (
						SELECT * 
						FROM (
							SELECT * 
							FROM  `cashflows` 
							WHERE  `idaccount` =" . $idaccount . "
							ORDER BY  `datetimeop` DESC 
							LIMIT 1
						)A
				  )B
				  ORDER BY  `datetimeop` DESC 
				  LIMIT 1";
		$query_run = mysql_query($query);
		$row = mysql_fetch_array($query_run);						
		if ((mysql_num_rows($query_run) > 0) && (!is_null($row["datetimeop"])))
		{
			$lastdate = $row["datetimeop"];								
		}
		else
		{
			echo "<p>Ошибка! Дата последнего вклада не найдена!</p>";	
		}							
		$firstdate = substr($firstdate, 0, 10);
		$lastdate = substr($lastdate, 0, 10);
		$interval = date_diff(date_create($firstdate), date_create($lastdate));
		$intervalday = $interval -> format("%r%a");		
		$intervalmonth = ($interval -> format('%y') * 12) + $interval -> format('%m');			
		//прошло ли три месяца				
		if ($intervalmonth >= 1)
		{
			$Td = $intervalday;
			$Ty = date('L', $timestamp = strtotime("$lastdate-01-01"))?366:365;					
			$R = 0.01;
			$Fv = 0;
			echo '<p>Процент начислен</p>';	
			echo '<p>Баланс до начисления ' . $Sv. ' ' . $moneytype . '</p>';	
			$Fv = $Sv * ( 1 + $R * ($Td / $Ty) );
			$differencetemp = $Fv - $Sv;
			$differencetemp = round($differencetemp, 2);
			echo '<p>Начисленные проценты ' . $differencetemp . ' ' . $moneytype . '</p>';
			$Fv = round($Fv, 2);
			echo '<p>Сумма после начисления процентов: ' . $Fv . ' ' . $moneytype . '</p>';	
			$query     = "INSERT INTO `sberkassa`.`cashflows`
										(`id`, `idaccount`, `datetimeop`, `accepted`, `monebalance`, `moneytype`, `%`)
								  VALUES (NULL, '" . $idaccount . "', '" . $date . " " . $time . "', '" . $differencetemp . "', '" . $Fv . "', '" . $moneytype . "', 1);";
			$query_run = mysql_query($query);	
		}
		else
		{
			echo '<p>Процент не был начислен, так как не прошло месяца</p>';	
		}
		echo '<p>Первая дата: ' . $firstdate . '</p>';				
		echo '<p>Последняя дата: ' . $lastdate . '</p>';			
		echo '<p>Разница в днях: ' . $intervalday . '</p>';			
		echo '<p>Разница в месяцах: ' . $intervalmonth . '</p>';		
		return ($Fv);
	}
	
	//срочный депозит(процент - 5%, должны пролежать - три месяца)
	function termdeposits($idaccount, $Sv, $moneytype, $idaccount, $moneyvalue, $date, $time)
	{
		//дата последнего начисления процентов
		$query = "SELECT  `idaccount` ,  `datetimeop` ,  `monebalance` 
				  FROM (
						SELECT * 
						FROM (
							SELECT * 
							FROM  `cashflows` 
							WHERE  `idaccount` =" . $idaccount . " AND `%`=1
							ORDER BY  `datetimeop` DESC 
							LIMIT 1
						)A
				  )B
				  ORDER BY  `datetimeop` DESC 
				  LIMIT 1";
		$query_run = mysql_query($query);
		$row = mysql_fetch_array($query_run);						
		if ((mysql_num_rows($query_run) > 0) && (!is_null($row["datetimeop"])))
		{
			$firstdate = $row["datetimeop"];	
		}
		else
		{
			//дата первого вклада
			$query = "SELECT  `idaccount` ,  `datetimeop` ,  `monebalance` 
					  FROM (
							SELECT * 
							FROM (
								SELECT * 
								FROM  `cashflows` 
								WHERE  `idaccount` =" . $idaccount . "
								ORDER BY  `datetimeop` ASC 
								LIMIT 1
							)A
					  )B
					  ORDER BY  `datetimeop` ASC 
					  LIMIT 1";
			$query_run = mysql_query($query);
			$row = mysql_fetch_array($query_run);						
			if ((mysql_num_rows($query_run) > 0) && (!is_null($row["datetimeop"])))
			{
				$firstdate = $row["datetimeop"];
			}
			else
			{
				echo "<p>Ошибка! Дата первого вклада не найдена!</p>";	
			}
		}
		//дата последнего вклада
		$query = "SELECT  `idaccount` ,  `datetimeop` ,  `monebalance` 
				  FROM (
						SELECT * 
						FROM (
							SELECT * 
							FROM  `cashflows` 
							WHERE  `idaccount` =" . $idaccount . "
							ORDER BY  `datetimeop` DESC 
							LIMIT 1
						)A
				  )B
				  ORDER BY  `datetimeop` DESC 
				  LIMIT 1";
		$query_run = mysql_query($query);
		$row = mysql_fetch_array($query_run);						
		if ((mysql_num_rows($query_run) > 0) && (!is_null($row["datetimeop"])))
		{
			$lastdate = $row["datetimeop"];								
		}
		else
		{
			echo "<p>Ошибка! Дата последнего вклада не найдена!</p>";	
		}							
		//были ли выдачи наличных
		$query = "SELECT  `idaccount` ,  `datetimeop` ,  `monebalance` , `accepted`
				  FROM (
						SELECT * 
						FROM (
							SELECT * 
							FROM  `cashflows` 
							WHERE  `idaccount` =" . $idaccount . " AND `accepted`<0
							ORDER BY  `datetimeop` DESC 
							LIMIT 1
						)A
				  )B
				  ORDER BY  `datetimeop` DESC 
				  LIMIT 1";
		$query_run = mysql_query($query);
		$row = mysql_fetch_array($query_run);						
		if ((mysql_num_rows($query_run) > 0) && (!is_null($row["datetimeop"])))
		{
			echo '<p>Вычеты были!</p>';
			$firstdate = $row["datetimeop"];
		}
		else
		{
			echo '<p>Вычетов не было!</p>';
		}
		$firstdate = substr($firstdate, 0, 10);
		$lastdate = substr($lastdate, 0, 10);
		$interval = date_diff(date_create($firstdate), date_create($lastdate));
		$intervalday = $interval -> format("%r%a");		
		$intervalmonth = ($interval -> format('%y') * 12) + $interval -> format('%m');			
		//прошло ли три месяца				
		if ($intervalmonth >= 3)
		{
			$Td = $intervalday;
			$Ty = date('L', $timestamp = strtotime("$lastdate-01-01"))?366:365;					
			$R = 0.05;
			$Fv = 0;
			echo '<p>Процент начислен</p>';	
			echo '<p>Баланс до начисления ' . $Sv. ' ' . $moneytype . '</p>';	
			$Fv = $Sv * ( 1 + $R * ($Td / $Ty) );
			$differencetemp = $Fv - $Sv;
			$differencetemp = round($differencetemp, 2);
			echo '<p>Начисленные проценты ' . $differencetemp . ' ' . $moneytype . '</p>';
			$Fv = round($Fv, 2);
			echo '<p>Сумма после начисления процентов: ' . $Fv . ' ' . $moneytype . '</p>';	
			$query     = "INSERT INTO `sberkassa`.`cashflows`
										(`id`, `idaccount`, `datetimeop`, `accepted`, `monebalance`, `moneytype`, `%`)
								  VALUES (NULL, '" . $idaccount . "', '" . $date . " " . $time . "', '" . $differencetemp . "', '" . $Fv . "', '" . $moneytype . "', 1);";
			$query_run = mysql_query($query);	
		}
		else
		{
			echo '<p>Процент не был начислен, так как не прошло трех месяцев</p>';	
		}
		echo '<p>Первая дата: ' . $firstdate . '</p>';				
		echo '<p>Последняя дата: ' . $lastdate . '</p>';			
		echo '<p>Разница в днях: ' . $intervalday . '</p>';			
		echo '<p>Разница в месяцах: ' . $intervalmonth . '</p>';		
		return ($Fv);		
	}
?>