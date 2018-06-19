<?php
	require_once "library/session.php";
	if ($_SESSION["login"] == "admin")
	{
		require_once "parts/header.php";
		// ДВИЖЕНИЯ ДЕНЕЖНЫХ СРЕДСТВ
		echo '<div id="article" class="center_screen">';
		if (is_numeric($_GET["page"]))
		{
			$query     = "SELECT * 
							FROM  `cashflows` 
						INNER JOIN  `savingsaccount` ON  `savingsaccount`.`id` =  `cashflows`.`idaccount` 
						INNER JOIN  `clients` ON  `clients`.`id` =  `savingsaccount`.`idclient`
						WHERE `savingsaccount`.`id` =" . $_GET["page"] . "
						ORDER BY `cashflows`.`id` ASC";
			$query_run = mysql_query($query);
			$cont_row  = mysql_num_rows($query_run);
			if ($cont_row > 0)
			{
				echo '<h3>Информация по счету</h3>';
				echo '<table style="width: 100%" id="input_table">';
				echo '	<tr>';
				echo '		<td style="width: 50%; text-align: left;">';
				echo '			<p><a href="cashflows" class="knopka">Перейти к движениям денежных средств по всем счетам</a></p>';
				echo '		</td>';
				echo '		<td style="width: 50%; text-align: right;">';
				echo '			<form class="form-wrapper cf" name="searchform" action="cashflows" method="get">';
				echo '				<input name="line" type="text" placeholder="Введите запрос..." value="' . $_GET['line'] . '">';
				echo '				<button type="submit" value="">Найти!</button>';
				echo '			</form>';
				echo '		</td>';
				echo '	</tr>';
				echo '</table>';
				echo '<br>';
				echo '<table>';
				echo '<tr>';
				echo '	<th width="auto">Дата/Время</th>';
				echo '	<th width="auto">Номер счета</th>';
				echo '	<th width="auto">Тип вклада</th>';
				echo '	<th width="auto">Ф.И.О.</th>';
				echo '	<th width="auto">Принято/Выдано</th>';
				echo '	<th width="auto">Остаток по счету</th>';
				echo '	<th width="auto">Валюта</th>';
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
					echo '</tr>';
				}
				echo '</table>';
			}
			else
			{
				echo '<h3>Ошибка</h3>';
				echo '<p>Сберегательный счет с таким номером не найден или прием наличных не осуществлялся.</p>';
				echo '<br>';
				echo '<table style="width: 100%" id="input_table">';
				echo '	<tr>';
				echo '		<td style="width: 50%; text-align: left;">';
				echo '			<p><a href="cashflows" class="knopka">Перейти к движениям денежных средств по всем счетам</a></p>';
				echo '		</td>';
				echo '		<td style="width: 50%; text-align: right;">';
				echo '		</td>';
				echo '	</tr>';
				echo '</table>';
			}
		}
		elseif ($_GET["page"] == "add")
		{
			echo '<h3>Получение информации по счету</h3>';
			echo '<p>Заполните данные:</p>';
			echo '<div class="login-block">';
			echo '<form name="addclients" action="cashflows?page=' . $_POST["idaccount"] . '" method="post">';
			echo '	<table id="input_table">';
			echo '		<tr>';
			echo '			<td valign="baseline"><p>Ф.И.О.:</p></td>';
			echo '			<td valign="baseline"><select required id="somethingidclient" name="idclient" onchange="" type="text">';
			$query     = "SELECT * FROM  `clients` ORDER BY `surname` ASC";
			$query_run = mysql_query($query);
			$count_row = mysql_num_rows($query_run);
			if ($count_row > 0)
			{
				//получение имен клиентов с зарегистрированными сберегательными счетами
				echo '	<option selected disabled value=""></option>';
				for ($i = 0; $i < $count_row; $i++)
				{
					$row = mysql_fetch_array($query_run);
					echo ' <option value="' . $row["id"] . '">' . $row["surname"] . ' ' . $row["name"] . ' ' . $row["patronymic"] . '</option>';
				}
			}
			else
			{
				echo '	<option disabled class="placeholder" value=""><span class="temp_color">Клиенты не найдены</span></option>">';
			}
			echo '		</tr>';
			echo '		<tr>';
			echo '			<td valign="baseline"><p>Сбер. счета:</p></td>';
			echo '			<td valign="baseline">';
			echo '			<select required id="somethingidaccount" name="idaccount" onchange="" type="text">';
			echo '  			<option id="nextidaccount" disabled class="placeholder" value=""><span class="temp_color"></span></option>';
			echo '			</select>';
			echo '			</td>';
			echo '		</tr>';
			echo '		<tr>';
			echo '			<td valign="baseline"><p>Тип вклада: </p></td>';
			echo '			<td valign="baseline"><input id="somethingdeposittype" disabled required name="deposittype" type="text" value="" placeholder="Не выбрано"></td>';
			echo '		</tr>';
			echo '		<tr>';
			echo '			<td valign="baseline"><p>Вид валюты: </p></td>';
			echo '			<td valign="baseline"><input id="somethingmoneytype" disabled required name="moneytype" type="text" value="" placeholder="Не выбрано"></td>';
			echo '		</tr>';
			echo '		<tr>';
			echo '			<td valign="baseline"><p>Пол: </p></td>';
			echo '			<td valign="baseline"><input id="somethingfloor" disabled required name="floor" type="text" value="" placeholder="Не выбрано"></td>';
			echo '		</tr>';
			echo '		<tr>';
			echo '			<td valign="baseline"><p>Дата рождения: </p></td>';
			echo '			<td valign="baseline"><input id="somethingbirthdate" disabled required name="datepicker" id="datepicker" type="text" value="" placeholder="Не выбрано"></td>';
			echo '		</tr>';
			echo '		<tr>';
			echo '			<td valign="baseline"><p>Паспортные данные: </p></td>';
			echo '			<td valign="baseline"><textarea id="somethingpassportdata" disabled required name="passportdata" class="textarea-field" placeholder="Не выбрано"></textarea></td>';
			echo '		</tr>';
			echo '		<tr>';
			echo '			<td valign="baseline"><p>Адрес регистрации: </p></td>';
			echo '			<td valign="baseline"><textarea id="somethingaddressdata" disabled required name="addressdata" class="textarea-field" placeholder="Не выбрано"></textarea></td>';
			echo '		</tr>';
			echo '		<tr>';
			echo '			<td valign="baseline"><p>Контактный телефон: </p></td>';
			echo '			<td valign="baseline"><input id="somethingcontactphone" disabled required name="contactphone" type="text" value="" placeholder="Не выбрано"></td>';
			echo '		</tr>';
			echo '	</table>';
			echo '		<button name="sendonly">Получить информацию по сберегательному счету</button>';
			echo '</form>';
			echo '</div>';
		}
		else
		{
			if (isset($_POST["sendonly"]))
			{
				?>
					<script type="text/javascript">
						var idaccount = 0;
						idaccount = <?php echo $_POST["idaccount"]; ?>;
						location.href = "cashflows?page=" + idaccount;
					</script>
				<?php
			}
			if (isset($_GET["line"]) && empty($_GET["line"]))
			{
				?>
					<script type="text/javascript">
						location.href = "cashflows";
					</script>
				<?php
			}
			echo '<h3>Движения всех денежных средств</h3>';
			echo '<table style="width: 100%" id="input_table">';
			echo '	<tr>';
			echo '		<td style="width: 50%; text-align: left;">';
			echo '			<p><a href="cashflows?page=add" class="knopka">Получить информацию по счету</a></p>';
			echo '		</td>';
			echo '		<td style="width: 50%; text-align: right;">';
			echo '			<form class="form-wrapper cf" name="searchform" action="cashflows" method="get">';
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
					$moneybalance = getbalance($_POST['idaccount'], $_POST["moneyvalue"]);
					$query        = "INSERT INTO `sberkassa`.`cashflows`
										(`id`, `idaccount`, `datetimeop`, `accepted`, `monebalance`, `moneytype`)
								  VALUES (NULL, '" . $_POST['idaccount'] . "', '" . $date . " " . $time . "', '" . $_POST["moneyvalue"] . "', '" . $moneybalance . "', '" . $_POST["moneytype"] . "');";
					if ($_POST["moneyvalue"] > 0)
					{
						$query_run = mysql_query($query);
						if ($query_run)
						{
							echo '<br><p>Запись в таблице "Прием наличных" создана</p>';
						}
						else
						{
							echo '<br><p>Запись в таблице "Прием наличных" не создана</p>';
						}
					}
					else
					{
						echo '<br><p>Запрос не выполнен! Сумма вклада меньше или равна нулю!</p>';
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
											 OR DATE_FORMAT(`datetimeop`, '%Y %m') = DATE_FORMAT('" . $_GET['line'] . "', '%Y %m')
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
						echo '	<th width="auto">Принято/Выдано</th>';
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
						echo '	<th width="auto">Принято/Выдано</th>';
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
						echo '<br><p>Операции по приему наличных еще не были произведены</p><br>';
					}
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
						location.href = "cashflows";
					</script>
				<?php
			}
		}
	?>	
			</div>
			<script type="text/javascript"> 
				$(document).ready(function() {	
					$("#somethingidclient").bind("change", function(event) {				
						$.ajax({	
							url: "library/receivesideinformation.php",
							type: "POST",
							data: ("cntnumberclient=" + $("#somethingidclient").val()),
							dataType: "text",
							success: function(resultcnt) {
								$.ajax({	
									url: "library/receivesideinformation.php",
									type: "POST",
									data: ("numberaccount=" + $("#somethingidclient").val()),
									dataType: "text",
									success: function(resultidaccount) {
										$("#somethingidaccount").find("option").not("#nextidaccount").remove().end();
										$("#nextidaccount").after(resultidaccount);
										$.ajax({	
												url: "library/receivesideinformation.php",
												type: "POST",
												data: ("deposittype=" + $("#somethingidaccount").val()),
												dataType: "text",
												success: function(resultdeposittype) {
													document.getElementById("somethingdeposittype").value = resultdeposittype;
												}
										});
										$.ajax({	
												url: "library/receivesideinformation.php",
												type: "POST",
												data: ("moneytype=" + $("#somethingidaccount").val()),
												dataType: "text",
												success: function(resultmoneytype) {
													document.getElementById("somethingmoneytype").value = resultmoneytype;
												}
										});
										$.ajax({	
												url: "library/receivesideinformation.php",
												type: "POST",
												data: ("floor=" + $("#somethingidaccount").val()),
												dataType: "text",
												success: function(resultfloor) {
													document.getElementById("somethingfloor").value = resultfloor;
												}
										});	
										$.ajax({	
												url: "library/receivesideinformation.php",
												type: "POST",
												data: ("birthdate=" + $("#somethingidaccount").val()),
												dataType: "text",
												success: function(resultbirthdate) {
													document.getElementById("somethingbirthdate").value = resultbirthdate;
												}
										});	
										$.ajax({	
												url: "library/receivesideinformation.php",
												type: "POST",
												data: ("passportdata=" + $("#somethingidaccount").val()),
												dataType: "text",
												success: function(resultpassportdata) {
													document.getElementById("somethingpassportdata").value = resultpassportdata;
												}
										});
										$.ajax({	
												url: "library/receivesideinformation.php",
												type: "POST",
												data: ("addressdata=" + $("#somethingidaccount").val()),
												dataType: "text",
												success: function(resultaddressdata) {
													document.getElementById("somethingaddressdata").value = resultaddressdata;
												}
										});
										$.ajax({	
												url: "library/receivesideinformation.php",
												type: "POST",
												data: ("contactphone=" + $("#somethingidaccount").val()),
												dataType: "text",
												success: function(resultcontactphone) {
													document.getElementById("somethingcontactphone").value = resultcontactphone;									
												}
										});									
									}
								});								
							}
						});
					});
				});
				$(document).ready(function() {	
					$("#somethingidaccount").bind("change", function(event) {				
						$.ajax({	
							url: "library/receivesideinformation.php",
							type: "POST",
							data: ("deposittype=" + $("#somethingidaccount").val()),
							dataType: "text",
							success: function(resultdeposittype) {
									document.getElementById("somethingdeposittype").value = resultdeposittype;
							}
						});
					});
				});
				$(document).ready(function() {	
					$("#somethingidaccount").bind("change", function(event) {				
						$.ajax({	
								url: "library/receivesideinformation.php",
								type: "POST",
								data: ("moneytype=" + $("#somethingidaccount").val()),
								dataType: "text",
								success: function(resultmoneytype) {
									document.getElementById("somethingmoneytype").value = resultmoneytype;
								}
						});
					});
				});				
		</script>
		<?php
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