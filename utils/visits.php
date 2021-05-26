<?php 

require_once('bdd.php');

$is_bot = !empty($_SERVER['HTTP_USER_AGENT']) && preg_match('~(bot|crawl)~i', $_SERVER['HTTP_USER_AGENT']);

if (!$is_bot) {
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
			require_once('bot/bot.php');
			send_visits_count_discord($visits_count);
		}
	}
}

 ?>
