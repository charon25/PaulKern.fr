<?php 

	session_start();

	$is_not_logged_in = !isset($_SESSION['login']) || $_SESSION['login'] != 'true';
	$is_session_expired = !isset($_SESSION['activity_time']) || (time() - $_SESSION['activity_time']) > 10 * 60;

	if ($is_not_logged_in || $is_session_expired) {
		require('not_connected.php');
		$is_authentified = FALSE;
		$_SESSION['login'] = 'false';
		$_SESSION['activity_time'] = 0;
		exit();
	} else {
		$_SESSION['activity_time'] = time();
		$is_authentified = TRUE;
	}

 ?>
