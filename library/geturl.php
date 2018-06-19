<?php
	//функция получения значения адресной строки
	function request_url()
	{
	  $result = ''; //пока результат пуст
	  $default_port = 80; //порт по-умолчанию
	 
	  //а не в защищенном-ли мы соединении?
	  if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=='on')) {
		//добавим протокол...
		$result .= 'https://';
		// ...и переназначим значение порта по-умолчанию
		$default_port = 443;
	  } else {
		//обычное соединение, обычный протокол
		$result .= 'http://';
	  }
	  //имя сервера, напр. site.com или www.site.com
	  $result .= $_SERVER['SERVER_NAME'];
	 
	  //а порт у нас по-умолчанию?
	  if ($_SERVER['SERVER_PORT'] != $default_port) {
		//если нет, то добавим порт в URL
		$result .= ':'.$_SERVER['SERVER_PORT'];
	  }
	  //последняя часть запроса (путь и GET-параметры).
	  $result .= $_SERVER['REQUEST_URI'];
	  //уфф, вроде получилось!
	  return $result;
	}
?>