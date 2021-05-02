<?php 

	session_start();

	if (!isset($_SESSION['login']) || $_SESSION['login'] != 'true') {
		require('not_connected.php');
		$is_authentified = FALSE;
		exit();
	} else {
		$is_authentified = TRUE;
	}

 ?>