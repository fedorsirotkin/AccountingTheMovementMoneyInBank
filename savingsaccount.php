<?php
	require_once "library/session.php";
	if ($_SESSION["login"] == "admin")
	{
		require_once "parts/header.php";
		// СБЕРЕГАТЕЛЬНЫЕ СЧЕТА
		echo '<div id="article" class="center_screen">';
		if (is_numeric($_GET["page"]))
		{
			echo '<h3>Редактирование сберегательного счета</h3>';
			$query     = "SELECT * FROM `savingsaccount` WHERE `id` =" . $_GET["page"];
			$query_run = mysql_query($query);
			$cont_rows = mysql_num_rows($query_run);
			if ($cont_rows > 0)
			{
				$rows = mysql_fetch_array($query_run);
				echo '<div class="spoiler">';
				echo '	<div class="title"><h3 class="title_h3"><p>Виды банковских вкладов:</p></div>';
				echo '	<div class="contents">';
				echo '		<p><strong>Вклад до востребования.</strong> По такому договору кредитная организация обязуется вернуть вложенные денежные средства в любое время по первому требованию клиента. Поскольку банк не принимает вклад на определенный период, то ставка по такому депозиту минимальная – в среднем не более 0,1-1%.</p>';
				echo '		<p><strong>Срочный вклад.</strong> Такие вклады размещаются на определенный срок, указанный в договоре. Чаще всего встречаются депозиты на один, три, шесть месяцев или один год. Для того чтобы получить полную процентную ставку необходимо продержать деньги в депозите в течение всего срока действия соглашения. В ином случае банк вернет вклад, но с существенно сниженным процентом – как правило, на уровне ставки по вкладам до востребования.</p>';
				echo '		<p><strong>Кредит</strong> — это система экономических отношений в связи с передачей от одного собственника другому во временное пользование ценностей в любой форме (товарной, денежной, нематериальной) на условиях возвратности, срочности, платности.</p>';
				echo '  </div>';
				echo ' </div>';
				echo '<div class="login-block">';
				echo '<form name="addclients" action="savingsaccount" method="post">';
				echo '	<table id="input_table">';
				echo '		<tr>';
				echo '			<td valign="baseline"><input required name="id" type="hidden" value="' . $rows['id'] . '" placeholder=""></td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td valign="baseline"><input required name="idclient" type="hidden" value="' . $rows['idclient'] . '" placeholder=""></td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td valign="baseline"><p>Клиент: </p></td>';
				echo '			<td valign="baseline"><select id="getit" onchange="checkit();" required name="idclient" type="text">';
				$query = "SELECT
									`clients`.`id`,
									`clients`.`surname`,
									`clients`.`name`,
									`clients`.`patronymic`,
									`savingsaccount`.`id`,
									`savingsaccount`.`idclient`,
									`savingsaccount`.`deposittype`,
									`savingsaccount`.`moneytype` 
						FROM  `clients` 
						INNER JOIN  `savingsaccount` ON  `clients`.`id` =  `savingsaccount`.`idclient`
						WHERE  `savingsaccount`.`idclient` =" . $rows["idclient"] . " AND `savingsaccount`.`id` =" . $_GET["page"];
				$query_run = mysql_query($query);
				$count_row = mysql_num_rows($query_run);
				if ($count_row <= 0)
				{
					echo '<option class="placeholder" disabled value=""><span class="temp_color">Сберегательные счета не найдены</span></option>';
				}
				else
				{
					?>
						<script type="text/javascript">
							var arrclientsid = [];
							var arrclientssurname = [];
							var arrclientsname = [];
							var arrclientspatronymic = [];
							var arrclientsfloor = [];
							var arrclientsbirthdate = [];
							var arrclientspassportdata = [];
							var arrclientsaddressdata = [];
							var arrclientscontactphone = [];
						</script>	
					<?php
					for ($i = 0; $i < $count_row; $i++)
					{
						$row = mysql_fetch_array($query_run);
						?>
							<script type="text/javascript">
								arrclientsid.push(<?php           echo $row["id"];           ?>);
								arrclientssurname.push(<?php      echo $row["surnam"];       ?>);
								arrclientsname.push(<?php         echo $row["name"];         ?>);
								arrclientspatronymic.push(<?php   echo $row["patronymic"];   ?>);
								arrclientsfloor.push(<?php        echo $row["floor"];        ?>);
								arrclientsbirthdate.push(<?php    echo $row["birthdate"];    ?>);
								arrclientspassportdata.push(<?php echo $row["passportdata"]; ?>);
								arrclientsaddressdata.push(<?php  echo $row["addressdata"];  ?>);
								arrclientscontactphone.push(<?php echo $row["contactphone"];?>);									
							</script>
						<?php
						echo '<option name = "idclient" value="' . $row["id"] . '">' . $row["surname"] . ' ' . $row["name"] . ' ' . $row["patronymic"] . '</option>';
					}
				}
				echo '	</select></td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td valign="baseline"><p>Тип вклада: </p></td>';
				if ($rows["deposittype"] == "До востребования")
					echo '		<td valign="baseline"><select required name="deposittype" type="text"><option class="placeholder" disabled value=""><span class="temp_color">Выберите тип вклада</span></option><option selected>До востребования</option><option>Срочный</option><option>Простой кредит</option></select></td>';
				if ($rows["deposittype"] == "Срочный")
					echo '		<td valign="baseline"><select required name="deposittype" type="text"><option class="placeholder" disabled value=""><span class="temp_color">Выберите тип вклада</span></option><option>До востребования</option><option selected>Срочный</option><option>Простой кредит</option></select></td>';
				if ($rows["deposittype"] == "Простой кредит")
					echo '		<td valign="baseline"><select required name="deposittype" type="text"><option class="placeholder" disabled value=""><span class="temp_color">Выберите тип вклада</span></option><option>До востребования</option><option>Срочный</option><option selected>Простой кредит</option></select></td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td valign="baseline"><p>Вид валюты: </p></td>';
				if ($rows["moneytype"] == "RUB")
					echo '		<td valign="baseline"><select required name="moneytype" type="text"><option class="placeholder" disabled value="' . $rows["moneytype"] . '"><span class="temp_color">Выберите вид валюты</span></option><option selected>RUB</option><option>EUR</option><option>USD</option></select></td>';
				if ($rows["moneytype"] == "EUR")
					echo '		<td valign="baseline"><select required name="moneytype" type="text"><option class="placeholder" disabled value="' . $rows["moneytype"] . '"><span class="temp_color">Выберите вид валюты</span></option><option>RUB</option><option selected>EUR</option><option>USD</option></select></td>';
				if ($rows["moneytype"] == "USD")
					echo '		<td valign="baseline"><select required name="moneytype" type="text"><option class="placeholder" disabled value="' . $rows["moneytype"] . '"><span class="temp_color">Выберите вид валюты</span></option><option>RUB</option><option>EUR</option><option selected>USD</option></select></td>';
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
				echo '			<td valign="baseline"><textarea id="somethingaddressdata" disabled required  name="addressdata" class="textarea-field" placeholder="Не выбрано"></textarea></td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td valign="baseline"><p>Контактный телефон: </p></td>';
				echo '			<td valign="baseline"><input id="somethingcontactphone" disabled required name="contactphone" type="text" value="" placeholder="Не выбрано"></td>';
				echo '		</tr>';
				echo '	</table>';
				echo '		<button name="send_update">Сохранить изменения</button>';
				echo '</form>';
				echo '</div>';
				$query     = "SELECT * FROM `clients` WHERE `id` =" . $row["idclient"];
				$query_run = mysql_query($query);
				$row       = mysql_fetch_array($query_run);
				?>
					<script type="text/javascript">
						strUser = '<?php                   echo $row["id"];           ?>';
						arrclientsfloor[0] = '<?php        echo $row["floor"];        ?>';
						arrclientsbirthdate[0] = '<?php    echo $row["birthdate"];    ?>';
						arrclientspassportdata[0] = '<?php echo $row["passportdata"]; ?>';
						arrclientsaddressdata[0] = '<?php  echo $row["addressdata"];  ?>';
						arrclientscontactphone[0] = '<?php echo $row["contactphone"]; ?>';								
						var input = document.getElementById('somethingfloor');
						input.value = arrclientsfloor[0];
						var input = document.getElementById('somethingbirthdate');
						input.value = arrclientsbirthdate[0];
						var input = document.getElementById('somethingpassportdata');
						input.value = arrclientspassportdata[0];	
						var input = document.getElementById('somethingaddressdata');
						input.value = arrclientsaddressdata[0];
						var input = document.getElementById('somethingcontactphone');
						input.value = arrclientscontactphone[0];								
					</script>	
				<?php
			}
			else
			{
				echo '<h3>Ошибка</h3>';
				echo '<p>Сберегательный счет с таким номером не найден</p>';
			}
		}
		elseif ($_GET["page"] == "add")
		{
			echo '<h3>Регистрация нового сберегательного счета</h3>';
			echo '<div class="spoiler">';
			echo '	<div class="title"><h3 class="title_h3"><p>Виды банковских вкладов:</p></div>';
			echo '	<div class="contents">';
			echo '		<p><strong>Вклад до востребования.</strong> По такому договору кредитная организация обязуется вернуть вложенные денежные средства в любое время по первому требованию клиента. Поскольку банк не принимает вклад на определенный период, то ставка по такому депозиту минимальная – в среднем не более 0,1-1%.</p>';
			echo '		<p><strong>Срочный вклад.</strong> Такие вклады размещаются на определенный срок, указанный в договоре. Чаще всего встречаются депозиты на один, три, шесть месяцев или один год. Для того чтобы получить полную процентную ставку необходимо продержать деньги в депозите в течение всего срока действия соглашения. В ином случае банк вернет вклад, но с существенно сниженным процентом – как правило, на уровне ставки по вкладам до востребования.</p>';
			echo '		<p><strong>Кредит</strong> — это система экономических отношений в связи с передачей от одного собственника другому во временное пользование ценностей в любой форме (товарной, денежной, нематериальной) на условиях возвратности, срочности, платности.</p>';
			echo '  </div>';
			echo ' </div>';
			echo '<div class="login-block">';
			echo '<form name="addclients" action="savingsaccount" method="post">';
			echo '	<table id="input_table">';
			echo '		<tr>';
			echo '			<td valign="baseline"><p>Клиент: </p></td>';
			echo '			<td valign="baseline"><select id="getit" onchange="checkit();" required name="idclient" type="text">';
			$query     = "SELECT * FROM `clients` ORDER BY `surname` ASC";
			$query_run = mysql_query($query);
			$count_row = mysql_num_rows($query_run);
			if ($count_row <= 0)
			{
				echo '<option class="placeholder" disabled value=""><span class="temp_color">Клиенты не найдены</span></option>';
			}
			else
			{
				echo '<option selected disabled value=""></option>';
				?>
					<script type="text/javascript">
						var arrclientsid = [];
						var arrclientssurname = [];
						var arrclientsname = [];
						var arrclientspatronymic = [];
						var arrclientsfloor = [];
						var arrclientsbirthdate = [];
						var arrclientspassportdata = [];
						var arrclientsaddressdata = [];
						var arrclientscontactphone = [];							
					</script>
				<?php
				for ($i = 0; $i < $count_row; $i++)
				{
					$row = mysql_fetch_array($query_run);
					?>
						<script type="text/javascript">
							arrclientsid.push(<?php           echo $row["id"]; ?>);
							arrclientssurnam.push(<?php       echo $row["surnam"]; ?>);
							arrclientsname.push(<?php         echo $row["name"]; ?>);
							arrclientspatronymic.push(<?php   echo $row["patronymic"];   ?>);
							arrclientsfloor.push(<?php        echo $row["floor"];        ?>);
							arrclientsbirthdate.push(<?php    echo $row["birthdate"];    ?>);
							arrclientspassportdata.push(<?php echo $row["passportdata"]; ?>);
							arrclientsaddressdata.push(<?php  echo $row["addressdata"];  ?>);
							arrclientscontactphone.push(<?php echo $row["contactphone"]; ?>);								
						</script>
					<?php
					echo '<option name = "idclient" value="' . $row["id"] . '">' . $row["surname"] . ' ' . $row["name"] . ' ' . $row["patronymic"] . '</option>';
				}
			}
			echo '	</select></td>';
			echo '		</tr>';
			echo '		<tr>';
			echo '			<td valign="baseline"><p>Тип вклада: </p></td>';
			echo '			<td valign="baseline"><select required name="deposittype" type="text"><option class="placeholder" disabled value=""><span class="temp_color">Выберите тип вклада</span></option><option>До востребования</option><option>Срочный</option><option>Простой кредит</option></select></td>';
			echo '		</tr>';
			echo '		<tr>';
			echo '			<td valign="baseline"><p>Вид валюты: </p></td>';
			echo '			<td valign="baseline"><select required name="moneytype" type="text"><option class="placeholder" disabled value=""><span class="temp_color">Выберите вид валюты</span></option><option>RUB</option><option>EUR</option><option>USD</option></select></td>';
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
			echo '		<button name="send">Записать новый сберегательный счет в БД</button>';
			echo '</form>';
			echo '</div>';
			$query     = "SELECT * FROM `clients`";
			$query_run = mysql_query($query);
			$row       = mysql_fetch_array($query_run);
		}
		else
		{
			echo '<h3>База счетов сберегательной кассы</h3>';
			// существует ли таблица
			$val = mysql_query("SELECT 1 FROM `savingsaccount` LIMIT 1");
			if ($val !== FALSE)
			{
				echo '<table style="width: 100%" id="input_table">';
				echo '	<tr>';
				echo '		<td style="width: 50%; text-align: left;">';
				echo '			<p><a href="savingsaccount?page=add" class="knopka">Зарегистрировать новый сберегательный счет</a></p>';
				echo '		</td>';
				echo '		<td style="width: 50%; text-align: right;">';
				echo '			<form class="form-wrapper cf" name="searchform" action="savingsaccount" method="get">';
				echo '				<input name="line" type="text" placeholder="Введите запрос..." value="' . $_GET['line'] . '">';
				echo '				<button type="submit" value="">Найти!</button>';
				echo '			</form>';
				echo '		</td>';
				echo '	</tr>';
				echo '</table>';
				if (isset($_POST["send"]))
				{
					$query     = "SELECT * FROM `clients` 
										WHERE id = " . $_POST['idclient'];
					$query_run = mysql_query($query);
					$cont_rows = mysql_num_rows($query_run);
					if ($cont_rows > 0)
					{
						$row   = mysql_fetch_array($query_run);
						$query = "INSERT INTO `sberkassa`.`savingsaccount`
											(`id`, `idclient`, `deposittype`, `moneytype`)
										   VALUES (NULL, '" . $_POST['idclient'] . "', '" . $_POST['deposittype'] . "', '" . $_POST['moneytype'] . "');";
						echo '<br><p>Сберегательный счет был успешно занесен в базу данных.</p>';
						$query_run = mysql_query($query);
					}
					else
					{
						echo '<br><p>Ошибка! Сберегательный счет не был занесен в базу данных.</p>';
					}
				}
				if (isset($_POST["send_update"]))
				{
					$query = "UPDATE  `sberkassa`.`savingsaccount` SET
										`deposittype` =  '" . $_POST['deposittype'] . "',
										`moneytype` =  '" . $_POST['moneytype'] . "'
									  WHERE  `savingsaccount`.`id` =" . $_POST['id'];
					echo '<br><p>Сберегательный счет был успешно изменен.</p>';
					$query_run = mysql_query($query);
				}
				$query     = "SELECT * FROM  `savingsaccount`";
				$query_run = mysql_query($query);
				$count_row = mysql_num_rows($query_run);
				if ($count_row <= 0)
				{
					echo '<br><p>В системе не зарегистрировано ни одного сберегательного счета.</p>';
				}
				else
				{
					//поиск сберегательных счетов
					if (isset($_GET["line"]) && !empty($_GET["line"]))
					{
						echo '<br>';
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
													WHERE 
														 CONCAT(`surname`, ' ', `name`, ' ', `patronymic`) LIKE '%" . $_GET['line'] . "%'
														 OR CONCAT(`surname`, ' ', `patronymic`, ' ', `name`) LIKE '%" . $_GET['line'] . "%'
														 OR CONCAT(`name`, ' ', `surname`, ' ', `patronymic`) LIKE '%" . $_GET['line'] . "%'
														 OR CONCAT(`name`, ' ', `patronymic`, ' ', `surname`) LIKE '%" . $_GET['line'] . "%'
														 OR CONCAT(`patronymic`, ' ', `surname`, ' ', `name`) LIKE '%" . $_GET['line'] . "%'
														 OR CONCAT(`patronymic`, ' ', `name`, ' ', `surname`) LIKE '%" . $_GET['line'] . "%'
														 OR `idclient` LIKE '%" . $_GET['line'] . "%'
														 OR `deposittype` LIKE '%" . $_GET['line'] . "%'
														 OR `moneytype` LIKE '%" . $_GET['line'] . "%'
														";
						$query_run = mysql_query($query);
						$count_row = mysql_num_rows($query_run);
						if ($count_row > 0)
						{
							echo '<table>';
							echo '<tr>';
							echo '	<th width="4%">Номер счета</th>';
							echo '	<th width="15%">Тип вклада</th>';
							echo '	<th width="4%">Вид валюты</th>';
							echo '	<th>Фамилия</th>';
							echo '	<th>Имя</th>';
							echo '	<th>Отчество</th>';
							echo '	<th width="4%">Номер клиента</th>';
							echo '	<th width="10%">Ред.</th>';
							echo '</tr>';
							for ($i = 0; $i < $count_row; $i++)
							{
								$row = mysql_fetch_array($query_run);
								echo '<tr>';
								echo '	<td>' . str_pad($row["id"], 10, "0", STR_PAD_LEFT) . '</td>';
								echo '	<td>' . $row["deposittype"] . '</td>';
								echo '	<td>' . $row["moneytype"] . '</td>';
								echo '	<td>' . $row["surname"] . '</td>';
								echo '	<td>' . $row["name"] . '</td>';
								echo '	<td>' . $row["patronymic"] . '</td>';
								echo '	<td>' . $row["idclient"] . '</td>';
								echo '	<td><a href="savingsaccount?page=' . $row["id"] . '"><img src="images/edit.png" alt="" style="width:20px;height:20px;"></a></td>';
								echo '</tr>';
							}
						}
						else
						{
							echo '<p>По вашему запросу ничего не найдено</p>';
						}
						echo '</table>';
					}
					else
					{
						if (isset($_GET["line"]) && empty($_GET["line"]))
						{
							?>
								<script type="text/javascript">
									location.href = "savingsaccount";
								</script>
							<?php
						}
						echo '<br>';
						echo '<table>';
						echo '<tr>';
						echo '<th width="4%">Номер счета</th>';
						echo '<th width="15%">Тип вклада</th>';
						echo '<th width="4%">Вид валюты</th>';
						echo '<th>Фамилия</th>';
						echo '<th>Имя</th>';
						echo '<th>Отчество</th>';
						echo '<th width="4%">Номер клиента</th>';
						echo '<th width="10%">Ред.</th>';
						echo '</tr>';
						$query     = "SELECT * FROM  `savingsaccount`";
						$query_run = mysql_query($query);
						$count_row = mysql_num_rows($query_run);
						for ($i = 0; $i < $count_row; $i++)
						{
							$row               = mysql_fetch_array($query_run);
							$query             = "SELECT * FROM  `clients` WHERE `id` = " . $row["idclient"];
							$query_run_clients = mysql_query($query);
							$row_clients       = mysql_fetch_array($query_run_clients);
							echo '<tr>';
							echo '	<td>' . str_pad($row["id"], 10, "0", STR_PAD_LEFT) . '</td>';
							echo '	<td>' . $row["deposittype"] . '</td>';
							echo '	<td>' . $row["moneytype"] . '</td>';
							echo '	<td>' . $row_clients["surname"] . '</td>';
							echo '	<td>' . $row_clients["name"] . '</td>';
							echo '	<td>' . $row_clients["patronymic"] . '</td>';
							echo '	<td>' . $row["idclient"] . '</td>';
							echo '	<td><a href="savingsaccount?page=' . $row["id"] . '"><img src="images/edit.png" alt="" style="width:20px;height:20px;"></a></td>';
							echo '</tr>';
						}
						echo '</table>';
					}
				}
			}
			else
			{
				echo '<br><p>Таблица "Сберегательные счета" не была создана</p>';
				$query     = "CREATE TABLE IF NOT EXISTS `savingsaccount` (
									  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
									  `idclient` int(11) NOT NULL,
									  `deposittype` varchar(255) NOT NULL,	  
									  `moneytype` varchar(255) NOT NULL,
									  PRIMARY KEY (`id`)
									) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
				$query_run = mysql_query($query);
				?>
					<script type="text/javascript">
						location.href = "savingsaccount";
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