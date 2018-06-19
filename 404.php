<?php
	require_once "library/session.php";
	require_once "library/connection_database.php";
	$currentconnect = connection_db($domain_name, $user, $password, $name_db);
	require_once "library/geturl.php";
	require_once "library/getfinalbalance.php";
	$currenturl = request_url();
	$pages      = array(
		'404'            => '404',
		'index'          => 'Главная',
		'authentication' => 'Аутентификация',
		'selectdate'     => 'Изменение даты',
		'clients'        => 'Клиенты',
		'savingsaccount' => 'Сберегательные счета',
		'cashwithdrawal' => 'Выдача наличных',
		'cashreceiving'  => 'Прием наличных',
		'cashflows     ' => 'Движения денежных средств'
	);
	//текущая дата/время
	date_default_timezone_set('Europe/Moscow');
	$date = file_get_contents('date.txt', true);
	if (checkdate(substr($date, 5, 2), substr($date, 8, 2), substr($date, 0, 4)))
	{
		$lastdate = intval(strtotime($date));
		$newdate  = intval(strtotime(date('Y-m-d', time())));
		if ($lastdate <= $newdate)
		{
			$date    = date('Y-m-d', time());
			$file    = 'date.txt';
			$current = file_get_contents($file);
			$current = $date;
			file_put_contents($file, $current);
		}
	}
	else
	{
		echo '<p>Файл содержит некорректную дату</p>';
		$date    = date('Y-m-d', time());
		$file    = 'date.txt';
		$current = file_get_contents($file);
		$current = $date;
		file_put_contents($file, $current);
	}
	$time = date('H:i:s', time());
?>
	<!DOCTYPE html>
	<html lang="ru">
		<head>
			<!-- определение метатегов -->
			<meta charset="utf-8">
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
			<meta name="description" content="Учет движения денег в сберкассе">
			<meta name="author" content="Сироткин Фёдор Алексеевич, группа 12-8 ПОк">
			<meta name="keywords" content="Сберкасса, Сберегательный банк, Сбербанк">
			<meta name="robots" content="all">
			
			<!-- библиотеки jQuery -->
			<script src="js/jquery-2.1.4.min.js"></script>
			<script src="js/jquery.inputmask.js" type="text/javascript"></script>
			<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
			<script src="js/jquery.inputmask.extensions.js" type="text/javascript"></script>
			<script src="js/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
			<script src="js/jquery.inputmask.numeric.extensions.js" type="text/javascript"></script>
			<script src="js/jquery.inputmask.custom.extensions.js" type="text/javascript"></script>		
			
			<!-- получить текущее время клиента -->
			<script src="js/moment.js"></script>
			
			<title>Учет движения денег в сберкассе</title>
			
			<!-- CSS/HTML-фреймворк Bootstrap -->
			<link rel="stylesheet" href="styles/bootstrap.min.css">
			
			<!-- настраиваемые CSS  -->
			<link rel="stylesheet" href="styles/main.css">
			
			<!-- иконка на вкладке браузера -->
			<link rel="shortcut icon" href="images/favicon.ico">
			
			<!-- datepicker -->		
			<link rel="stylesheet" href="styles/pikaday.css">
	
			</head>
	<body>
		<div class="container">
			<div style="padding-top: 10px;";>
				<?php
					echo '<p align="right">';
					echo 'Вход в систему не выполнен &nbsp';
					echo '<img src="images/logoutcb.png" alt="" style="width:35px;height:35px;">';
					echo '</p>';
				?>
			</div>
			<div id="head" class="center_screen">
				<p><img src="images/logo.png" alt="">Учет движения денег в сберегательной кассе</p>
			</div>
			<div id="cssmenu" class="center_screen">
				<ul>
				<?php
					echo "<li class='active'><a href='authentication'><span>Ошибка 404</span></a></li>";
				?>
				</ul>
			</div>
	<?php	
	// 404
	echo '<div id="article" class="center_screen">';
	echo '    <h3>Такой страницы не существует</h3>';
	echo '    <p>В процессе обработки вашего запроса произошла ошибка.</p>';
	echo '    <p>Вы не можете посетить текущую страницу по причине:';
	echo '    <ul>';
	echo '    	<li>просроченная закладка/избранное;</li>';
	echo '    	<li>пропущен адрес;</li>';
	echo '    	<li>поисковый механизм, у которого просрочен список для этого сайта;</li>';
	echo '    	<li>у вас нет права доступа на эту страницу.</li>';
	echo '    </ul>';
	echo '    <div class="login-block">';
	echo '		<p><img src="images/404.png" alt="" style="align:center;width:505px;height:217px;"><p>';
	echo '	  </div>';
	if (isset($_POST["send_auth"]))
	{
		if (($_POST["login"] == "admin") && ($_POST["password"] == "admin"))
		{
			$_SESSION["login"] = "admin";
			?>
				<script type="text/javascript">
					location.href = "clients";
				</script>
			<?php
		}
		else
		{
			echo '<br><p>Логин или пароль введены неверно!</p>';
		}
	}
	echo '</div>';
	unset($_SESSION["login"]);
	require_once "parts/footer.php";
?>