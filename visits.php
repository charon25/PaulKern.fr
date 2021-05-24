<?php 

require_once('bdd.php');
require_once('bot/bot.php');

// Si c'est un bot
if (!empty($_SERVER['HTTP_USER_AGENT']) and preg_match('~(bot|crawl)~i', $_SERVER['HTTP_USER_AGENT'])) {
	if (!preg_match('Discord', $_SERVER['HTTP_USER_AGENT']))
		send_visits_count_discord('BOT - ' . print_r($_SERVER, TRUE));
} else { // Sinon
	send_visits_count_discord('PAS BOT - ' . print_r($_SERVER, TRUE));
	if (!isset($_COOKIE['visited'])) {
		$value = rand(-1000000000, 1000000000);
		setcookie('visited', $value, time() + 3600, null, null, false, true);
		$visit_request = $bdd->prepare('INSERT INTO `pk_visits`(`time`, `value`) VALUES (?, ?)');
		$visit_request->execute(array(time(), $value));


		$FIRST_ID = 1;
		$visits_request = $bdd->query('SELECT `id` FROM `pk_visits` ORDER BY `id` DESC LIMIT 1');
		$last_id = $visits_request->fetch()['id'];
		$visits_count = $last_id - $FIRST_ID + 1;
		if ($visits_count > 0 && $visits_count % 10 == 0) {
			require('bot/bot.php');
			send_visits_count_discord($visits_count);
		}
	}
}

 ?>