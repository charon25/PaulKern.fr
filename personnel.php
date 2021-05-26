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
	if ($project[$PRO_INC_DESC] == 1) {
		echo '<div class="gris">' . markdown_to_html($projet[$PRO_SHORT_DESC]) . '</div>';
	}
	echo '<div class="gris">' . markdown_to_html($project[$PRO_DESC]);
	if ($project[$PRO_URL] != '') {
		echo '<a href="' . $project[$PRO_URL] . '" class="btn btn-primary bouton">Lien du projet</a>';
	}
	echo '</div></div><div class="margebot25"></div></div></div></section>';
}

 ?>

<?php include('utils/footer.php'); print_footer(); ?>

</body>
</html>

<script type="text/javascript" src="js/no_js.js"></script>
