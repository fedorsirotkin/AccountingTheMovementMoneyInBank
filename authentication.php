<?php
	require_once "library/session.php";
	require_once "parts/header.php";
	// АУТЕНТИФИКАЦИЯ
	echo '<div id="article" class="center_screen">';
	echo '    <h3>Аутентификация</h3>';
	echo '    <p>Введите, пожалуйста, ваш логин и пароль:</p>';
	echo '    <div class="login-block">';
	echo '    <form name="auth" action="" method="post">';
	echo '        <table id="input_table">';
	echo '            <tr>';
	echo '                <td valign="baseline"><p>Логин: </p></td>';
	echo '                <td valign="baseline"><input required name="login" type="text" value="" placeholder="Введите логин"></td>';
	echo '            </tr>';
	echo '            <tr>';
	echo '                <td valign="baseline"><p>Пароль: </p></td>';
	echo '                <td valign="baseline"><input required name="password" type="password" value="" placeholder="Введите пароль"></td>';
	echo '            </tr>';
	echo '        </table>';
	echo '        <button name="send_auth">Войти в систему</button>';
	echo '    </form>';
	echo '</div>';
	if (isset($_POST["send_auth"]))
	{
		require_once "library/auth.php";
		if (($_POST["login"] == $loginadmin) && ((md5($_POST["password"])) === $passwordadmin))
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
	else
	{
		unset($_SESSION["login"]);
	}
	echo '</div>';
	require_once "parts/footer.php";
?>