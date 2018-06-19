<?php
	require_once "library/session.php";
	if ($_SESSION["login"] == "admin")
	{
		require_once "parts/header.php";
		// ИЗМЕНЕНИЕ ДАТЫ
		echo '<div id="article" class="center_screen">';
		echo '<h3>Изменение даты</h3>';
		if (isset($_POST['senddate']) == true)
		{
			$lastdate = intval(strtotime($date));
			$newdate  = $_POST['newdate'];
			$newdate  = intval(strtotime($newdate));
			if ($lastdate <= $newdate)
			{
				echo "<p>Дата изменена</p>";
				$date    = $_POST['newdate'];
				$file    = 'date.txt';
				$current = file_get_contents($file);
				$current = $date;
				file_put_contents($file, $current);
			}
			else
			{
				echo "<p>Введена некорректная дата!</p>";
			}
		}
		if (isset($_POST['senddatdatedefault']) == true)
		{
			$date    = date('Y-m-d', time());
			$file    = 'date.txt';
			$current = file_get_contents($file);
			$current = $date;
			file_put_contents($file, $current);
			echo "<p>Дата/время с сервера выставлены</p>";
		}
		echo '<div class="login-block">';
		echo '<form name="selectdate" action="selectdate" method="post">';
		echo '    <table id="input_table">';
		echo '        <tr>';
		echo '            <td valign="baseline"><p>Текущая дата: </p></td>';
		echo '            <td valign="baseline"><input required id="idcurrentdate" name="currentdate" type="text" value="' . $date . '" placeholder="Дата не найдена" readonly="readonly"></td>';
		echo '        </tr>';
		echo '        <tr>';
		echo '            <td valign="baseline"><p>Новая дата: </p></td>';
		echo '            <td valign="baseline"><input required id="datepickertwo" name="newdate" type="text" value="" placeholder="Введите дату"></td>';
		echo '        </tr>';
		echo '    </table>';
		echo '        <button name="senddate">Изменить дату</button>';
		echo '</form>';
		echo '</div>';
		echo '<div align="center">';
		echo '<form name="datedefault" action="selectdate" method="post">';
		echo '     <br><button class="btn btn-secondary btn-sm" name="senddatdatedefault">Выставить дату/время сервера</button>';
		echo '</form>';
		echo '</div>';
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