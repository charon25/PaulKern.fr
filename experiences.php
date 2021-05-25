<?php 

require('utils/visits.php');

require('utils/bdd.php');
require('utils/markdown.php');
require('utils/constants.php');
require_once('utils/functions.php');


$experiences_pro_data = get_db_data_from_key($bdd, 'pro', -1);

 ?>

<!DOCTYPE html>
<html>
<?php include('utils/head.php'); print_head(array('title' => "Expériences professionnelles", "indexing" => TRUE)); ?>

<body>

<?php include('utils/header.php'); print_header(); ?>

<section id="presentation-first" class="first-section">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h1 class="margetop45 fw-bold titre-principal">Expériences professionnelles</h1>
				<div class="margebot45"></div>
			</div>
		</div>
	</div>
</section>

<?php 

foreach ($experiences_pro_data as $key => $experience) {
	if ($key%2 == 0) {echo '<section class="even-section" id="exp-' . $key . '">';}
	else {echo '<section class="odd-section" id="exp-' . $key . '">';}

	echo '<div class="container"><div class="row"><div class="margetop25"></div>';
	echo '<div class="col-sm-3 text-center"><img src="' . $experience[$EXP_MAIN_IMG] . '" class="img-thumbnail-mod-height margebot25 miniature" alt="Image ' . $experience[$EXP_NAME] . '"></div>';
	echo '<div class="col-sm-9">';
	echo '<p><span class="bleu-big">' . $experience[$EXP_DATE_TXT] . '</span><br>';
	echo '<span class="fw-bold">' . $experience[$EXP_NAME] . ' — ' . $experience[$EXP_PLACE] . '</span><br>';
	echo $experience[$EXP_TITLE] . '</p>';
	if ($experience[$EXP_INC_DESC] == 1) {
		echo '<div class="gris">' . markdown_to_html($experience[$EXP_SHORT_DESC]) . '</div>';
	}
	echo '<div class="gris">' . markdown_to_html($experience[$EXP_DESC]) . '</div>';
	echo '</div><div class="margebot25"></div></div></div></section>';

}

 ?>

<?php include('utils/footer.php'); print_footer();?>

</body>
</html>

<script type="text/javascript" src="js/no_js.js"></script>
