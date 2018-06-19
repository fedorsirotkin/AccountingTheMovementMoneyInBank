<?php
	//инструкции получения вспомогательной информации при помощи ajax
	require_once "connection_database.php";
	$currentconnect = connection_db($domain_name, $user, $password, $name_db);
	
	//получение количества сберегательных счетов по номеру клиента
	if (isset($_POST["cntnumberclient"]))
	{
			$query = "SELECT * FROM  `savingsaccount` WHERE `idclient`=".$_POST["cntnumberclient"];
			$query_run = mysql_query($query);
			$row = mysql_fetch_array($query_run);						
			if ((mysql_num_rows($query_run) > 0) && (!is_null($row["id"])))
			{
				echo mysql_num_rows($query_run);
			}
			else
				echo "0";
	}
	
	//получение номеров сберегательных счетов по номеру клиента
	if (isset($_POST["numberaccount"]))
	{
			$query = "SELECT * FROM  `savingsaccount` WHERE `idclient`=".$_POST["numberaccount"];
			$query_run = mysql_query($query);
			$counterrow = mysql_num_rows($query_run);
			if ($counterrow  > 0)
			{
				for ($i = 0; $i < $counterrow; $i++)
				{
					$row = mysql_fetch_array($query_run);
					$answer .= "<option selected id=\"nextidaccountcreate\" value=\"".$row["id"]."\">".$row["id"]."</option>";
				}	
				echo $answer;
			}
			else
				echo "<option selected id=\"nextidaccountcreate\" value=\"0\">Не найдено сберегательного счета</option>";
	}
	
	//получение deposittype сберегательных счетов по номеру клиента
	if (isset($_POST["deposittype"]))
	{
			$query = "SELECT * FROM  `savingsaccount` WHERE `id`=".$_POST["deposittype"];
			$query_run = mysql_query($query);
			$row = mysql_fetch_array($query_run);						
			if ((mysql_num_rows($query_run) > 0) && (!is_null($row["id"])))
			{
				echo $row["deposittype"];
			}
			else
				echo "Не найдено сберегательного счета";
	}
	
	//получение moneytype сберегательных счетов по номеру клиента
	if (isset($_POST["moneytype"]))
	{
			$query = "SELECT * FROM  `savingsaccount` WHERE `id`=".$_POST["moneytype"];
			$query_run = mysql_query($query);
			$row = mysql_fetch_array($query_run);						
			if ((mysql_num_rows($query_run) > 0) && (!is_null($row["id"])))
			{
				echo $row["moneytype"];
			}
			else
				echo "Не найдено сберегательного счета";
	}
	
	//получение floor сберегательных счетов по номеру клиента
	if (isset($_POST["floor"]))
	{
			$query = "SELECT
							* 
						  FROM  `clients` 
						  INNER JOIN  `savingsaccount`
							ON  `clients`.`id` =  `savingsaccount`.`idclient`
						WHERE `savingsaccount`.`id`=".$_POST["floor"];
			$query_run = mysql_query($query);
			$row = mysql_fetch_array($query_run);						
			if ((mysql_num_rows($query_run) > 0) && (!is_null($row["id"])))
			{
				echo $row["floor"];
			}
			else
				echo "Не найдено сберегательного счета";
	}

	//получение birthdate сберегательных счетов по номеру клиента
	if (isset($_POST["birthdate"]))
	{
			$query = "SELECT
							* 
						  FROM  `clients` 
						  INNER JOIN  `savingsaccount`
							ON  `clients`.`id` =  `savingsaccount`.`idclient`
						WHERE `savingsaccount`.`id`=".$_POST["birthdate"];
			$query_run = mysql_query($query);
			$row = mysql_fetch_array($query_run);						
			if ((mysql_num_rows($query_run) > 0) && (!is_null($row["id"])))
			{
				echo $row["birthdate"];
			}
			else
				echo "Не найдено сберегательного счета";
	}	

	//получение passportdata сберегательных счетов по номеру клиента
	if (isset($_POST["passportdata"]))
	{
			$query = "SELECT
							* 
						  FROM  `clients` 
						  INNER JOIN  `savingsaccount`
							ON  `clients`.`id` =  `savingsaccount`.`idclient`
						WHERE `savingsaccount`.`id`=".$_POST["passportdata"];
			$query_run = mysql_query($query);
			$row = mysql_fetch_array($query_run);						
			if ((mysql_num_rows($query_run) > 0) && (!is_null($row["id"])))
			{
				echo $row["passportdata"];
			}
			else
				echo "Не найдено сберегательного счета";
	}	

	//получение addressdata сберегательных счетов по номеру клиента
	if (isset($_POST["addressdata"]))
	{
			$query = "SELECT
							* 
						  FROM  `clients` 
						  INNER JOIN  `savingsaccount`
							ON  `clients`.`id` =  `savingsaccount`.`idclient`
						WHERE `savingsaccount`.`id`=".$_POST["addressdata"];
			$query_run = mysql_query($query);
			$row = mysql_fetch_array($query_run);						
			if ((mysql_num_rows($query_run) > 0) && (!is_null($row["id"])))
			{
				echo $row["addressdata"];
			}
			else
				echo "Не найдено сберегательного счета";
	}	

	//получение contactphone сберегательных счетов по номеру клиента
	if (isset($_POST["contactphone"]))
	{
			$query = "SELECT
							* 
						  FROM  `clients` 
						  INNER JOIN  `savingsaccount`
							ON  `clients`.`id` =  `savingsaccount`.`idclient`
						WHERE `savingsaccount`.`id`=".$_POST["contactphone"];
			$query_run = mysql_query($query);
			$counterrow = mysql_num_rows($query_run);
			if ($counterrow  > 0)
			{
				$row = mysql_fetch_array($query_run);
				echo $row["contactphone"];
			}
			else
				echo "Не найдено сберегательного счета";
	}		

?>