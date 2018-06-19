<?php
	require_once "library/session.php";
	if ($_SESSION["login"] == "admin")
	{
		require_once "parts/header.php";
		if ($_GET["query"] == "createdb")
		{
			$query = "CREATE DATABASE sberkassa CHARACTER SET utf8 COLLATE utf8_general_ci;";
			$query_run = mysql_query($query);
			?>
				<script type="text/javascript">
					location.href = "index";
				</script>
			<?php
		}
		if ($_GET["query"] == "deletedb")
		{
			$query = "DROP DATABASE sberkassa";
			$query_run = mysql_query($query);
			?>
				<script type="text/javascript">
					location.href = "index";
				</script>
			<?php
		}
?>
			<!-- ГЛАВНАЯ -->
			<div id="article" class="center_screen">
				<p>Текущий URL: <strong><?php echo request_url();?></strong></p>
				<p>Состояние подключения к СУБД:
					<?php
						if ($currentconnect == -1)
							echo "<strong>MySQL не подключен</strong>";
						else
							echo "<strong>MySQL успешно подключен</strong>";
						?>
				</p>
				<p>Состояние подключения к БД:
					<?php
						if ($currentconnect == -2)
						{
							echo "<strong>База данных данных с именем \"sberkassa\" не найдена</strong>";
							echo '<p><a href="index?query=createdb" class="knopka">Создать БД с именем "sberkassa"</a></p>';
						}
						else
						{
							echo "<strong>База данных с именем \"sberkassa\" найдена и успешно подключена</strong>";
							echo '<p><a href="index?query=deletedb" class="knopka">Удалить БД с именем "sberkassa"</a></p>';
						}
							
					?>
				</p>
			</div>
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