<?php 

require('utils/visits.php');

require('utils/bdd.php');
require('utils/markdown.php');
require('utils/constants.php');
require_once('utils/functions.php');

$projects_perso_data = get_db_data_from_key($bdd, 'perso', -1);

 ?>

<!DOCTYPE html>
<html>
<?php include('utils/head.php'); print_head(array('title' => "Projets personnels", "indexing" => TRUE)); ?>

<body>

<?php include('utils/header.php'); print_header(); ?>

<section id="presentation-first" class="first-section">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h1 class="margetop45 fw-bold titre-principal">Projets personnels</h1>
				<div class="margebot45"></div>
			</div>
		</div>
	</div>
</section>

<?php 

foreach ($projects_perso_data as $key => $project) {
	if ($key%2 == 0) {echo '<section class="even-section" id="pro-' . $key . '">';}
	else {echo '<section class="odd-section" id="pro-' . $key . '">';}

	echo '<div class="container"><div class="row"><div class="margetop25"></div>';
	echo '<div class="col-sm-3 text-center"><img src="' . $project[$PRO_MAIN_IMG] . '" class="img-thumbnail-mod-height margebot25 miniature" alt="Image ' . $project[$PRO_TITLE] . '"></div>';
	echo '<div class="col-sm-9">';
	echo '<p class="bleu-big">' . $project[$PRO_DATE_TXT] . '</p>';
	echo '<p class="fw-bold">' . $project[$PRO_TITLE] . '</p>';
	if ($experience[$EXP_INC_DESC] == 1) {
		echo '<div class="gris">' . markdown_to_html($experience[$EXP_SHORT_DESC]) . '</div>';
	}
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
				<p class="bleu-big">Mars 2021</p>
				<p class="fw-bold">Spalt - MiniJam 76</p>
				<p class="gris">Jeu réalisé en une quinzaine d'heures de A à Z en Python avec PyGame.</p>
				<p class="gris">Le thème de la jam était <span class="bleu">Radiation</span>, avec la contrainte <span class="bleu">Onde Handed Controls</span>.</p>
				<p class="gris">Il a terminé <span class="bleu">27<sup>e</sup>/130</span> dans le classement général, et <span class="bleu">18<sup>e</sup></span> dans la catégorie <span class="italique">Concept</span>.</p>
				<p class="gris">Code source : <a href="https://github.com/charon25/Spalt">github/spalt</a> – Page du jeu : <a href="https://charon25.itch.io/spalt">itch.io/spalt</a></p>
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
				<p class="bleu-big">Novembre 2021</p>
				<p class="fw-bold">TIFA - MiniJam 66</p>
				<p>Jeu réalisé en une quinzaine d'heures de A à Z en VB.NET sans moteur de jeu.</p>
				<p>Le thème de la jam était <span class="bleu">Sweets</span>, avec la contrainte <span class="bleu">Only Two Inputs</span>.</p>
				<p>Il a terminé <span class="bleu">23<sup>e</sup>/103</span> dans le classement général, et <span class="bleu">1<sup>er</sup></span> dans la catégorie <span class="italique">Utilisation de la contrainte</span>.</p>
				<p>Code source : <a href="https://github.com/charon25/TIFA">github/TIFA</a> – Page du jeu : <a href="https://charon25.itch.io/tifa">itch.io/TIFA</a></p>
			</div>
			<div class="margebot25"></div>
		</div>
	</div>
</section>
-->


<?php include('utils/footer.php'); print_footer(); ?>

</body>
</html>

<script type="text/javascript" src="js/no_js.js"></script>
