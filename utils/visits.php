<?php 

require('bdd.php');

if (!isset($_COOKIE['visited'])) {
	setcookie('visited', 'true', time() + 3600, null, null, false, true);
	$visit_request = $bdd->prepare('INSERT INTO `pk_visits`(`time`) VALUES (?)');
	$visit_request->execute(array(time()));
}

 ?>