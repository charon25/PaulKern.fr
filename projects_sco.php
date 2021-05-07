<?php 

require('utils/bdd.php');
require('utils/markdown.php');
require('utils/constants.php');
require('utils/functions.php');

$projects_sco_data = get_db_data_from_key($bdd, 'sco', -1);

 ?>

<!DOCTYPE html>
<html>
<?php include('utils/head.php'); print_head(array('title' => "Projets scolaires")); ?>

<body>

<?php include('utils/header.php'); print_header(); ?>

<section id="presentation-first" class="first-section">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h1 class="margetop45 fw-bold titre-principal">Projets scolaires</h1>
				<div class="margebot45"></div>
			</div>
		</div>
	</div>
</section>

<?php

foreach ($projects_sco_data as $key => $project) {
	if ($key%2 == 0) {echo '<section class="even-section">';}
	else {echo '<section class="odd-section">';}

	echo '<div class="container"><div class="row"><div class="margetop25"></div>';
	echo '<div class="col-sm-3 text-center"><img src="' . $project[$PRO_MAIN_IMG] . '" class="img-thumbnail-mod-height margebot25 miniature" alt="Image ' . $project[$PRO_TITLE] . '"></div>';
	echo '<div class="col-sm-9">';
	echo '<p class="bleu-big">' . $project[$PRO_DATE_TXT] . '</p>';
	echo '<p class="fw-bold">' . $project[$PRO_TITLE] . '</p>';
	echo '<div class="gris">' . markdown_to_html($project[$PRO_DESC]);
	if ($project[$PRO_URL] != '') {
		echo '<a href="' . $project[$PRO_URL] . '" class="btn btn-primary bouton">Lien du projet</a>';
	}
	echo '</div></div><div class="margebot25"></div></div></div></section>';
}

 ?>

<!--
<section class="even-section">
	<div class="container">
		<div class="row">
			<div class="margetop25"></div>
			<div class="col-sm-3 text-center">
				<img src="img/img_spalt.png" class="img-thumbnail-mod-height margebot25 miniature" alt="Photo profil">
			</div>
			<div class="col-sm-9">
				<p class="bleu-big">Septembre 2020 - Février 2021</p>
				<p class="fw-bold">Station météo connectée</p>
				<p>Projet consistant à réaliser une station météo connectée par Internet (SigFox), SMS (07 55 63 03 20) et VHF.</p>
				<p>Elle récupère les données météo toutes les 10 minutes de 8h à 20h en moyenne et les envoie grâce à SigFox sur <a href="http://www.balisemeteo.com/balise.php?idBalise=6005">cette page</a> ainsi que <a href="https://www.charon25.fr/meteo/">celle-ci</a>.</p>
				<p>Elle fonctionne grâce à une Raspberry Pi programmée en Python et un microcontrôleur PIC programmé en C.</p>
				<a class="btn btn-primary bouton" href="#">Télécharger le rapport détaillé (en anglais)</a>
			</div>
			<div class="margebot25"></div>
		</div>
	</div>
</section>

<section class="odd-section">
	<div class="container">
		<div class="row">
			<div class="margetop25"></div>
			<div class="col-sm-3 text-center">
				<img src="img/img_spalt.png" class="img-thumbnail-mod-height margebot25 miniature" alt="Photo profil">
			</div>
			<div class="col-sm-9">
				<p class="bleu-big">Septembre 2020 - Janvier 2021</p>
				<p class="fw-bold">Bouée autonome</p>
				<p>Projet consistant à étudier la faisabilité et l'état de l'art sur la réalisation d'une bouée autonome pour aller checher les marins tombés en mer.</p>
				<p>Evaluation de l'état de l'art sur la localisation, la communication longue portée et la communication courte portée.</p>
				<p>Différentes mesures réalisées pour mesurer l'efficacité et la précision de modules GPS et xBee.</p>
			</div>
			<div class="margebot25"></div>
		</div>
	</div>
</section>
-->


<?php include('utils/footer.php'); print_footer()?>

</body>
</html>

<script type="text/javascript" src="js/no_js.js"></script>
