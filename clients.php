<?php
	require_once "library/session.php";
	if ($_SESSION["login"] == "admin")
	{
		require_once "parts/header.php";
		// КЛИЕНТЫ
		echo '<div id="article" class="center_screen">';
		if (is_numeric($_GET["page"]))
		{
			$query     = "SELECT * FROM `clients` WHERE `id`=" . $_GET["page"];
			$query_run = mysql_query($query);
			$cont_rows = mysql_num_rows($query_run);
			if ($cont_rows > 0)
			{
				$rows = mysql_fetch_array($query_run);
				echo '<h3>Редактирование клиента</h3>';
				echo '<p>Заполните данные:</p>';
				echo '<div class="login-block">';
				echo '<form name="addclients" action="clients" method="post">';
				echo '	<table id="input_table">';
				echo '		<tr >';
				echo '			<td valign="baseline"><input required name="id" type="hidden" value="' . $rows['id'] . '" placeholder=""></td>';
				echo '		</tr>';
				echo '		<tr >';
				echo '			<td valign="baseline"><p>Фамилия: </p></td>';
				echo '			<td valign="baseline"><input required name="surname" type="text" value="' . $rows['surname'] . '" placeholder="Введите фамилию"></td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td valign="baseline"><p>Имя: </p></td>';
				echo '			<td valign="baseline"><input required name="name" type="text" value="' . $rows['name'] . '" placeholder="Введите имя"></td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td valign="baseline"><p>Отчество: </p></td>';
				echo '			<td valign="baseline"><input required name="patronymic" type="text" value="' . $rows['patronymic'] . '" placeholder="Введите отчество"></td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td valign="baseline"><p>Пол: </p></td>';
				if ($rows['floor'] == "Муж.")
					echo '			<td valign="baseline"><select required name="floor" type="text"><option class="placeholder" disabled value=""><span class="temp_color">Выберите пол</span></option>"><option selected>Муж.</option><option>Жен.</option></select></td>';
				if ($rows['floor'] == "Жен.")
					echo '			<td valign="baseline"><select required name="floor" type="text"><option class="placeholder" disabled value=""><span class="temp_color">Выберите пол</span></option>"><option>Муж.</option><option selected>Жен.</option></select></td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td valign="baseline"><p>Дата рождения: </p></td>';
				echo '			<td valign="baseline"><input required name="datepicker" id="datepicker" type="text" value="' . $rows['birthdate'] . '" placeholder="Выберите дату"></td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td valign="baseline"><p>Паспортные данные: </p></td>';
				echo '			<td valign="baseline"><textarea required name="passportdata" class="textarea-field" placeholder="Заполните паспортные данные">' . $rows['passportdata'] . '</textarea></td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td valign="baseline"><p>Адрес регистрации: </p></td>';
				echo '			<td valign="baseline"><textarea required name="addressdata" class="textarea-field" placeholder="Заполните адресные данные">' . $rows['addressdata'] . '</textarea></td>';
				echo '		</tr>';
				echo '		<tr>';
				echo '			<td valign="baseline"><p>Контактный телефон: </p></td>';
				echo '			<td valign="baseline"><input required id="contactphone" name="contactphone" type="text" value="' . $rows['contactphone'] . '" placeholder="Введите контактный телефонный номер"></td>';
				echo '		</tr>';
				echo '	</table>';
				echo '		<button name="send_update">Сохранить изменения</button>';
				echo '</form>';
				echo '</div>';
			}
			else
			{
				echo '<h3>Ошибка</h3>';
				echo '<p>Клиент с таким номером не найден</p>';
			}
		}
		elseif ($_GET["page"] == "add")
		{
			echo '<h3>Регистрация нового клиента</h3>';
			echo '<p>Заполните данные:</p>';
			echo '<div class="login-block">';
			echo '<form name="addclients" action="clients" method="post">';
			echo '	<table id="input_table">';
			echo '		<tr >';
			echo '			<td valign="baseline"><p>Фамилия: </p></td>';
			echo '			<td valign="baseline"><input required name="surname" type="text" value="" placeholder="Введите фамилию"></td>';
			echo '		</tr>';
			echo '		<tr>';
			echo '			<td valign="baseline"><p>Имя: </p></td>';
			echo '			<td valign="baseline"><input required name="name" type="text" value="" placeholder="Введите имя"></td>';
			echo '		</tr>';
			echo '		<tr>';
			echo '			<td valign="baseline"><p>Отчество: </p></td>';
			echo '			<td valign="baseline"><input required name="patronymic" type="text" value="" placeholder="Введите отчество"></td>';
			echo '		</tr>';
			echo '		<tr>';
			echo '			<td valign="baseline"><p>Пол: </p></td>';
			echo '			<td valign="baseline"><select required name="floor" type="text"><option class="placeholder" disabled value=""><span class="temp_color">Выберите пол</span></option><option>Муж.</option><option>Жен.</option></select></td>';
			echo '		</tr>';
			echo '		<tr>';
			echo '			<td valign="baseline"><p>Дата рождения: </p></td>';
			echo '			<td valign="baseline"><input required name="datepicker" id="datepicker" type="text" value="" placeholder="Выберите дату"></td>';
			echo '		</tr>';
			echo '		<tr>';
			echo '			<td valign="baseline"><p>Паспортные данные: </p></td>';
			echo '			<td valign="baseline"><textarea required name="passportdata" class="textarea-field" placeholder="Заполните паспортные данные"></textarea></td>';
			echo '		</tr>';
			echo '		<tr>';
			echo '			<td valign="baseline"><p>Адрес регистрации: </p></td>';
			echo '			<td valign="baseline"><textarea required name="addressdata" class="textarea-field" placeholder="Заполните адресные данные"></textarea></td>';
			echo '		</tr>';
			echo '		<tr>';
			echo '			<td valign="baseline"><p>Контактный телефон: </p></td>';
			echo '			<td valign="baseline"><input required id="contactphone" name="contactphone" type="text" value="" placeholder="Введите контактный телефонный номер"></td>';
			echo '		</tr>';
			echo '	</table>';
			echo '		<button name="send">Записать нового клиента в БД</button>';
			echo '</form>';
			echo '</div>';
		}
		else
		{
			echo '<h3>База клиентов сберегательной кассы</h3>';
			// существует ли таблица
			$val = mysql_query("SELECT 1 FROM `clients` LIMIT 1");
			if ($val !== FALSE)
			{
				echo '<table style="width: 100%" id="input_table">';
				echo '	<tr>';
				echo '		<td style="width: 50%; text-align: left;">';
				echo '			<p><a href="clients?page=add" class="knopka">Зарегистрировать нового клиента</a></p>';
				echo '		</td>';
				echo '		<td style="width: 50%; text-align: right;">';
				echo '			<form class="form-wrapper cf" name="searchform" action="clients" method="get">';
				echo '				<input name="line" type="text" placeholder="Введите запрос..." value="' . $_GET['line'] . '">';
				echo '				<button type="submit" value="">Найти!</button>';
				echo '			</form>';
				echo '		</td>';
				echo '	</tr>';
				echo '</table>';
				if (isset($_POST["send"]))
				{
					$query = "INSERT INTO `sberkassa`.`clients`
										(`id`, `surname`, `name`, `patronymic`, `floor`, `birthdate`, `passportdata`, `addressdata`, `contactphone`)
									   VALUES (NULL, '" . $_POST['surname'] . "', '" . $_POST['name'] . "', '" . $_POST['patronymic'] . "', '" . $_POST['floor'] . "', '" . $_POST['datepicker'] . "', '" . $_POST['passportdata'] . "', '" . $_POST['addressdata'] . "', '" . $_POST['contactphone'] . "');";
					echo '<br><p>Клиент был успешно занесен в базу данных.</p>';
					$query_run = mysql_query($query);
				}
				if (isset($_POST["send_update"]))
				{
					$query = "UPDATE  `sberkassa`.`clients` SET
										`surname` =  '" . $_POST['surname'] . "',
										`name` =  '" . $_POST['name'] . "',
										`patronymic` =  '" . $_POST['patronymic'] . "',
										`floor` =  '" . $_POST['floor'] . "',
										`birthdate` =  '" . $_POST['datepicker'] . "',
										`passportdata` =  '" . $_POST['passportdata'] . "',
										`addressdata` =  '" . $_POST['addressdata'] . "',
										`contactphone` =  '" . $_POST['contactphone'] . "'
									  WHERE  `clients`.`id` =" . $_POST['id'] . ";";
					echo '<br><p>Клиент был успешно изменен.</p>';					
					$query_run = mysql_query($query);
				}
				$query     = "SELECT * FROM  `clients`";
				$query_run = mysql_query($query);
				$count_row = mysql_num_rows($query_run);
				if ($count_row <= 0)
				{
					echo '<br><p>В системе не зарегистрировано ни одного клиента.</p>';
				}
				else
				{
					if (isset($_GET["line"]) && !empty($_GET["line"]))
					{
						echo '		<br>';
						$query     = "SELECT * FROM  `clients` WHERE `id` LIKE '%" . $_GET['line'] . "%'
																			  OR CONCAT(`surname`, ' ', `name`, ' ', `patronymic`) LIKE '%" . $_GET['line'] . "%'
																			  OR CONCAT(`surname`, ' ', `patronymic`, ' ', `name`) LIKE '%" . $_GET['line'] . "%'
																			  OR CONCAT(`name`, ' ', `surname`, ' ', `patronymic`) LIKE '%" . $_GET['line'] . "%'
																			  OR CONCAT(`name`, ' ', `patronymic`, ' ', `surname`) LIKE '%" . $_GET['line'] . "%'
																			  OR CONCAT(`patronymic`, ' ', `surname`, ' ', `name`) LIKE '%" . $_GET['line'] . "%'
																			  OR CONCAT(`patronymic`, ' ', `name`, ' ', `surname`) LIKE '%" . $_GET['line'] . "%'
																			  OR `floor` LIKE '%" . $_GET['line'] . "%'
																			  OR DATE_FORMAT(`birthdate`, '%Y %m') = DATE_FORMAT('" . $_GET['line'] . "', '%Y %m')
																			  OR `passportdata` LIKE '%" . $_GET['line'] . "%'
																			  OR `addressdata` LIKE '%" . $_GET['line'] . "%'
																			  OR `contactphone` LIKE '%" . $_GET['line'] . "%'
																			  ";
						$query_run = mysql_query($query);
						$count_row = mysql_num_rows($query_run);
						if ($count_row > 0)
						{
							echo '<table>';
							echo '	<tr>';
							echo '		<th>Номер клиента</th>';
							echo '		<th>Фамилия</th>';
							echo '		<th>Имя</th>';
							echo '		<th>Отчество</th>';
							echo '		<th>Пол</th>';
							echo '		<th>Дата рождения</th>';
							echo '		<th>Паспортные данные</th>';
							echo '		<th>Адрес регистрации</th>';
							echo '		<th>Контактный телефон</th>';
							echo '		<th>Ред.</th>';
							echo '	</tr>';
							for ($i = 0; $i < $count_row; $i++)
							{
								$row = mysql_fetch_array($query_run);
								echo '<tr>';
								echo '	<td>' . $row["id"] . '</td>';
								echo '	<td>' . $row["surname"] . '</td>';
								echo '	<td>' . $row["name"] . '</td>';
								echo '	<td>' . $row["patronymic"] . '</td>';
								echo '	<td>' . $row["floor"] . '</td>';
								echo '	<td>' . $row["birthdate"] . '</td>';
								echo '	<td>' . $row["passportdata"] . '</td>';
								echo '	<td>' . $row["addressdata"] . '</td>';
								echo '	<td>' . $row["contactphone"] . '</td>';
								echo '	<td><a href="clients?page=' . $row["id"] . '"><img src="images/edit.png" alt="" style="width:20px;height:20px;"></a></td>';
								echo '</tr>';
							}
						}
						else
						{
							echo '<p>По вашему запросу ничего не найдено</p>';
						}					
						echo'		</table>';	
					}
					else
					{
						if (isset($_GET["line"]) && empty($_GET["line"]))
						{
							?>
								<script type="text/javascript">
									location.href = "clients";
								</script>
							<?php
						}
						echo '		<br>';
						echo '		<table>';
						echo '			<tr>';
						echo '				<th>Номер клиента</th>';
						echo '				<th>Фамилия</th>';
						echo '				<th>Имя</th>';
						echo '				<th>Отчество</th>';
						echo '				<th>Пол</th>';
						echo '				<th>Дата рождения</th>';
						echo '				<th>Паспортные данные</th>';
						echo '				<th>Адрес регистрации</th>';
						echo '				<th>Контактный телефон</th>';
						echo '				<th>Ред.</th>				';					
						echo '			</tr>';
						$query     = "SELECT * FROM  `clients`";
						$query_run = mysql_query($query);
						$count_row = mysql_num_rows($query_run);
						for ($i = 0; $i < $count_row; $i++)
						{
							$row = mysql_fetch_array($query_run);
							echo '<tr>';
							echo '	<td>' . $row["id"] . '</td>';
							echo '	<td>' . $row["surname"] . '</td>';
							echo '	<td>' . $row["name"] . '</td>';
							echo '	<td>' . $row["patronymic"] . '</td>';
							echo '	<td>' . $row["floor"] . '</td>';
							echo '	<td>' . $row["birthdate"] . '</td>';
							echo '	<td>' . $row["passportdata"] . '</td>';
							echo '	<td>' . $row["addressdata"] . '</td>';
							echo '	<td>' . $row["contactphone"] . '</td>';
							echo '	<td><a href="clients?page=' . $row["id"] . '"><img src="images/edit.png" alt="" style="width:20px;height:20px;"></a></td>';
							echo '</tr>';
						}						
						echo '		</table>';	
					}
				}
			}
			else
			{
				echo '<br><p>Таблица "Клиенты" не была создана</p>';
				$query     = "CREATE TABLE IF NOT EXISTS `clients` (
									  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
									  `surname` varchar(255) NOT NULL,
									  `name` varchar(255) NOT NULL,
									  `patronymic` varchar(255) NOT NULL,
									  `floor` varchar(255) NOT NULL,
									  `birthdate` date NOT NULL,
									  `passportdata` text NOT NULL,
									  `addressdata` text NOT NULL,
									  `contactphone` varchar(255) NOT NULL,
									  PRIMARY KEY (`id`)
									) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
				$query_run = mysql_query($query);
				?>
					<script type="text/javascript">
						location.href = "clients";
					</script>
				<?php
			}
		}
		echo '	</div>';
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