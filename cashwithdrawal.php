<?php
	require_once "library/session.php";
	if ($_SESSION["login"] == "admin")
	{
		require_once "parts/header.php";
		// ВЫДАЧА НАЛИЧНЫХ
		echo '<div id="article" class="center_screen">';
		if ($_GET["page"] == "add")
		{
			echo '<h3>Создание операции по выдаче наличных</h3>';
			echo '<p>Заполните данные:</p>';
			echo '<div class="login-block">';
			echo '<form name="addclients" action="cashwithdrawal" method="post">';
			echo '	<table id="input_table">';
			echo '		<tr>';
			echo '			<td valign="baseline"><input required id="idaccount" name="idaccount" type="hidden" value="" placeholder=""></td>';
			echo '		</tr>';
			echo '		<tr>';
			echo '			<td valign="baseline"><input required id="deposittype" name="deposittype" type="hidden" value="" placeholder=""></td>';
			echo '		</tr>';				
			echo '		<tr>';
			echo '			<td valign="baseline"><p>Ф.И.О. - Номер счета - Тип вклада: </p></td>';
			echo '		</tr>';
			echo '		<tr>';
			echo '			<td valign="baseline"><select required name="idsavingsaccount" id="idsavingsaccount" onchange="getsavingsaccount();" type="text">';
			$query     = "SELECT
								`clients`.`surname`,
								`clients`.`name`,
								`clients`.`patronymic`,
								`savingsaccount`.`id`,
								`savingsaccount`.`idclient`,
								`savingsaccount`.`deposittype`,
								`savingsaccount`.`moneytype` 
							  FROM  `clients` 
							  INNER JOIN  `savingsaccount`
								ON  `clients`.`id` =  `savingsaccount`.`idclient`
							  ORDER BY `clients`.`surname` ASC";
			$query_run = mysql_query($query);
			$count_row = mysql_num_rows($query_run);
			if ($count_row > 0)
			{
				echo '	<option selected disabled value=""></option>';
				for ($i = 0; $i < $count_row; $i++)
				{
					$row = mysql_fetch_array($query_run);
					echo ' <option value="' . $row["id"] . '">' . $row["surname"] . ' ' . $row["name"] . ' ' . $row["patronymic"] . ' - ' . $row["id"] . ' - (' . $row["deposittype"] . ')</option>';
				}
			}
			else
			{
				echo '	<option disabled class="placeholder" value=""><span class="temp_color">Сберегательные счета не найдены</span></option>">';
			}
			echo '</select></td>';
			echo '		</tr>';
			echo '		<tr>';
			echo '			<td valign="baseline"><input required id="somethinidaccount" name="idaccount" value="" placeholder="" readonly="readonly" type="hidden"></td>';
			echo '		</tr>';
			echo '		<tr>';
			echo '			<td valign="baseline"><p>Остаток на счету: </p></td>';
			echo '		</tr>';
			echo '		<tr>';
			echo '			<td valign="baseline"><input id="somethingbalance" required name="balance" type="text" value="" placeholder="Не выбран номер счета" readonly="readonly"></td>';
			echo '		</tr>';
			echo '		<tr>';
			echo '			<td valign="baseline"><p>Валюта: </p></td>';
			echo '		</tr>';
			echo '		<tr>';
			echo '			<td valign="baseline"><input id="somethingmoneytype" required name="moneytype" type="text" value="" placeholder="Не выбран номер счета" readonly="readonly"></td>';
			echo '		</tr>';
			echo '		<tr>';
			echo '			<td valign="baseline"><p>Сумма: </p></td>';
			echo '		</tr>';
			echo '		<tr>';
			echo '			<td valign="baseline"><input id="somethingmoneyvalue" required name="moneyvalue" type="number" value="" placeholder="Введите необходимую сумму"></td>';
			echo '		</tr>';
			echo '	</table>';
			echo '		<button name="send">Выполнить операцию</button>';
			echo '</form>';
			echo '</div>';
		}
		else
		{
			if (isset($_GET["line"]) && empty($_GET["line"]))
			{
				?>
					<script type="text/javascript">
						location.href = "cashwithdrawal";
					</script>
				<?php
			}
			echo '<h3>Список операций по выдаче наличных</h3>';
			echo '<table style="width: 100%" id="input_table">';
			echo '	<tr>';
			echo '		<td style="width: 50%; text-align: left;">';
			echo '			<p><a href="cashwithdrawal?page=add" class="knopka">Выполнить операцию по выдаче наличных</a></p>';
			echo '		</td>';
			echo '		<td style="width: 50%; text-align: right;">';
			echo '			<form class="form-wrapper cf" name="searchform" action="cashwithdrawal" method="get">';
			echo '				<input name="line" type="text" placeholder="Введите запрос..." value="' . $_GET['line'] . '">';
			echo '				<button type="submit" value="">Найти!</button>';
			echo '			</form>';
			echo '		</td>';
			echo '	</tr>';
			echo '</table>';
			// существует ли таблица
			$val = mysql_query("SELECT 1 FROM `cashflows` LIMIT 1");
			if ($val !== FALSE)
			{
				if (isset($_POST["send"]))
				{					
					if ($_POST["moneyvalue"] > 0)
					{
						if (($_POST["moneyvalue"] <= $_POST["balance"]) && (is_numeric($_POST["balance"])))
						{						
							require_once "library/interestcharge.php";
							switch ($_POST["deposittype"])
							{
								case "До востребования":
									echo '<p>Проверка начисления процента на этот счет (До востребования)...</p>';									
									$total = demanddeposits($_POST['idaccount'], $_POST["balance"], $_POST["moneytype"], $_POST['idaccount'], $_POST["moneyvalue"], $date, $time);
									$total = round($total, 2);
									if ($total == 0)
									{
										echo '<p>Процент не был начислен</p>';
									}
									break;
								case "Срочный":
									echo '<p>Проверка начисления процента на этот счет (Срочный)...</p>';
									$total = termdeposits($_POST['idaccount'], $_POST["balance"], $_POST["moneytype"], $_POST['idaccount'], $_POST["moneyvalue"], $date, $time);
									$total = round($total, 2);
									if ($total == 0)
									{
										echo '<p>Процент не был начислен</p>';
									}								
									break;
								default:
									echo '<p>Процент на этот счет не был начислен</p>';
							}
							$moneybalance = getbalance($_POST['idaccount'], -$_POST["moneyvalue"]);
							$query        = "INSERT INTO `sberkassa`.`cashflows`
												(`id`, `idaccount`, `datetimeop`, `accepted`, `monebalance`, `moneytype`)
										  VALUES (NULL, '" . $_POST['idaccount'] . "', '" . $date . " " . $time . "', '" . -$_POST["moneyvalue"] . "', '" . $moneybalance . "', '" . $_POST["moneytype"] . "');";
							$query_run = mysql_query($query);
							if ($query_run)
							{
								echo '<br><p>Запись в таблице "Выдача наличных" создана</p>';
							}
							else
							{
								echo '<br><p>Запись в таблице "Выдача наличных" не создана</p>';
							}								
						}
						else
						{
							echo '<br><p>Недостаточно средств на счете!</p>';
						}
					}
					else
					{
						echo '<br><p>Запрос не выполнен! Сумма выдачи меньше или равна нулю!</p>';
					}
				}
				if (isset($_GET["line"]) && !empty($_GET["line"]))
				{
					echo '	<br>';
					$query     = "SELECT * 
												FROM  `cashflows` 
											INNER JOIN  `savingsaccount` ON  `savingsaccount`.`id` =  `cashflows`.`idaccount` 
											INNER JOIN  `clients` ON  `clients`.`id` =  `savingsaccount`.`idclient`							  
										WHERE
											 `cashflows`.`accepted` < 0
											 AND (
											 CONCAT(`surname`, ' ', `name`, ' ', `patronymic`) LIKE '%" . $_GET['line'] . "%'								
											 OR CONCAT(`surname`, ' ', `patronymic`, ' ', `name`) LIKE '%" . $_GET['line'] . "%'								
											 OR CONCAT(`name`, ' ', `surname`, ' ', `patronymic`) LIKE '%" . $_GET['line'] . "%'						
											 OR CONCAT(`name`, ' ', `patronymic`, ' ', `surname`) LIKE '%" . $_GET['line'] . "%'							
											 OR CONCAT(`patronymic`, ' ', `surname`, ' ', `name`) LIKE '%" . $_GET['line'] . "%'							
											 OR CONCAT(`patronymic`, ' ', `name`, ' ', `surname`) LIKE '%" . $_GET['line'] . "%'
											 OR `savingsaccount`.`moneytype` LIKE '%" . $_GET['line'] . "%'
											 OR `savingsaccount`.`deposittype` LIKE '%" . $_GET['line'] . "%'
											 OR `cashflows`.`accepted` LIKE '%" . $_GET['line'] . "%'
											 OR `cashflows`.`monebalance` LIKE '%" . $_GET['line'] . "%'
											 OR `cashflows`.`idaccount` LIKE '%" . $_GET['line'] . "%'
											 OR DATE_FORMAT(`datetimeop`, '%Y %m') = DATE_FORMAT('" . $_GET['line'] . "', '%Y %m'))
										ORDER BY `cashflows`.`id` ASC													 
										 ";
					$query_run = mysql_query($query);
					$count_row = mysql_num_rows($query_run);
					if ($count_row > 0)
					{
						echo '<table>';
						echo '<tr>';
						echo '	<th width="auto">Дата/Время</th>';
						echo '	<th width="auto">Номер счета</th>';
						echo '	<th width="auto">Тип вклада</th>';
						echo '	<th width="auto">Ф.И.О.</th>';
						echo '	<th width="auto">Выдано</th>';
						echo '	<th width="auto">Остаток по счету</th>';
						echo '	<th width="auto">Валюта</th>';
						echo '	<th width="auto">%</th>';
						echo '</tr>';
						for ($i = 0; $i < $count_row; $i++)
						{
							$row = mysql_fetch_array($query_run);
							echo '<tr>';
							echo '	<td>' . $row["datetimeop"] . '</td>';
							echo '	<td>' . str_pad($row["idaccount"], 10, "0", STR_PAD_LEFT) . '</td>';
							echo '	<td>' . $row["deposittype"] . '</td>';
							echo '	<td>' . $row["surname"] . ' ' . $row["name"] . ' ' . $row["patronymic"] . '</td>';
							echo '	<td>' . $row["accepted"] . '</td>';
							echo '	<td>' . $row["monebalance"] . '</td>';
							echo '	<td>' . $row["moneytype"] . '</td>';
							echo '	<td>' . str_replace("1", "%", $row["%"]) . '</td>';
							echo '</tr>';
						}
						echo '</table>';
					}
					else
					{
						echo '<p>По вашему запросу ничего не найдено</p>';
					}					
					echo '</table>';	
				}
				else
				{
					$query     = "SELECT * 
									FROM  `cashflows` 
								INNER JOIN  `savingsaccount` ON  `savingsaccount`.`id` =  `cashflows`.`idaccount` 
								INNER JOIN  `clients` ON  `clients`.`id` =  `savingsaccount`.`idclient`
								WHERE `accepted` < 0
								ORDER BY `cashflows`.`id` ASC";
					$query_run = mysql_query($query);
					$cont_row  = mysql_num_rows($query_run);
					if ($cont_row > 0)
					{
						echo '<br>';
						echo '<table>';
						echo '<tr>';
						echo '	<th width="auto">Дата/Время</th>';
						echo '	<th width="auto">Номер счета</th>';
						echo '	<th width="auto">Тип вклада</th>';
						echo '	<th width="auto">Ф.И.О.</th>';
						echo '	<th width="auto">Выдано</th>';
						echo '	<th width="auto">Остаток по счету</th>';
						echo '	<th width="auto">Валюта</th>';
						echo '	<th width="auto">%</th>';
						echo '</tr>';
						for ($i = 0; $i < $cont_row; $i++)
						{
							$row = mysql_fetch_array($query_run);
							echo '<tr>';
							echo '	<td>' . $row["datetimeop"] . '</td>';
							echo '	<td>' . str_pad($row["idaccount"], 10, "0", STR_PAD_LEFT) . '</td>';
							echo '	<td>' . $row["deposittype"] . '</td>';
							echo '	<td>' . $row["surname"] . ' ' . $row["name"] . ' ' . $row["patronymic"] . '</td>';
							echo '	<td>' . $row["accepted"] . '</td>';
							echo '	<td>' . $row["monebalance"] . '</td>';
							echo '	<td>' . $row["moneytype"] . '</td>';
							echo '	<td>' . str_replace("1", "%", $row["%"]) . '</td>';
							echo '</tr>';
						}
						echo '</table>';
					}
					else
					{
						echo '<br><p>Операции по выдаче наличных еще не были произведены</p><br>';
					}
					echo '</table>';
				}
			}
			else
			{
				echo '<br><p>Таблица "Прием наличных" не была создана</p>';
				$query     = "CREATE TABLE IF NOT EXISTS `cashflows` (
								  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
								  `idaccount` int(10) unsigned NOT NULL,
								  `datetimeop` datetime NOT NULL,
								  `accepted` decimal(10,2) NOT NULL,
								  `monebalance` decimal(10,2) NOT NULL,
								  `moneytype` varchar(255) NOT NULL,
								  `%` tinyint(1) DEFAULT NULL,
								  PRIMARY KEY (`id`)
								) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
				$query_run = mysql_query($query);
				?>
					<script type="text/javascript">
						location.href = "cashwithdrawal";
					</script>
				<?php
			}
		}
		echo '</div>';
		require_once "parts/footer.php";
	}
	else
	{
		?>
			<script type="text/javascript">
				location.href = "authentication";
			</script>
		<?php
	}
?>
<script type="text/javascript">
	$(document).ready(function() {	
		$("#idsavingsaccount").bind("change", function(event) {	
				$.ajax({	
					url: "library/receivesideinformation.php",
					type: "POST",
					data: ("deposittype=" + $("#idsavingsaccount").val()),
					dataType: "text",
					success: function(resultdeposittype) {
						document.getElementById("deposittype").value = resultdeposittype;					
					}
				});
			});
		});
</script>