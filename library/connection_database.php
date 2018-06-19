<?php
	//доменное имя 
	$domain_name = "localhost";
	//пользователь
	$user = "root";
	//пароль
	$password = "";
	//имя базы данных
	$name_db = "sberkassa";
	//функция получения соединения с базой данных
	function connection_db($domain_name, $user, $password, $name_db)
	{
		//открываем соединение с сервером MySQL
		if (mysql_connect($domain_name, $user, $password))
		{
			//выбираем для работы базу данных на сервере
			if (mysql_select_db($name_db))
			{
				return (1);
			}
			else
			{
				return (-2);
			}
		}
		else
		{
			return (-1);
		}
	}
?>