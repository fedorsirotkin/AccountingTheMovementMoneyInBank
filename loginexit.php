<?php
	require_once "library/session.php";
	unset($_SESSION["login"]);
?>
<script type="text/javascript">
	location.href = "authentication";
</script>