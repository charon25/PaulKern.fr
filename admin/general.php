<?php 

require('check_connection.php');
require('../utils/bdd.php');
require('../utils/markdown.php');

// Constantes
	$PREFIX = 'general';
	$PRES_TEXT = $PREFIX . '_presentation-text';
	$LINK_MAIL = $PREFIX . '_mail';
	$LINK_LINKEDIN = $PREFIX . '_linkedin';
	$LINK_GITHUB = $PREFIX . '_github';
	$LINK_ITCHIO = $PREFIX . '_itchio';
	$PHOTO = $PREFIX . '_photo';
	$SUBMIT = $PREFIX . '_ok';
//

function set_data(&$array, $key, $value) {
	if ($_POST[$key] != '') 
		$array[$key] = $value;
}

function set_data_post(&$array, $key) {
	set_data($array, $key, $_POST[$key]);
}

 ?>

<?php 

	$request = $bdd->query('SELECT * FROM `pk_data` WHERE `type`="general"');
	$general_data = json_decode($request->fetch()['data'], TRUE);

	if (isset($_POST[$SUBMIT])) {
		set_data_post($general_data, $PRES_TEXT);
		set_data_post($general_data, $LINK_MAIL);
		set_data_post($general_data, $LINK_LINKEDIN);
		set_data_post($general_data, $LINK_GITHUB);
		set_data_post($general_data, $LINK_ITCHIO);

		$insert_request = $bdd->prepare('UPDATE `pk_data` SET `data`=? WHERE `type`="general"');
		$insert_request->execute(array(json_encode($general_data)));
	}

 ?>

<!DOCTYPE html>
<html>
<?php include('../utils/head.php');	print_head(array('title' => "Espace administrateur - Général", 'start_dir' => "../")); ?>
<body>


<?php include('../utils/header.php'); print_header(array('start_dir' => "../")); ?>

<section id="presentation-first" class="first-section">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h1 class="margetop45 fw-bold titre-principal">Espace administrateur - Général</h1>
				<div class="margebot45"></div>
			</div>
		</div>
	</div>
</section>

<section id="general-infos">
	<div class="container admin-element">
		<p class="admin-title bleu-big">Informations générales</p>
		<form method="post" action="#general-infos" class="form-group">
			<div class="row">
				<div class="col-sm-6 bordure-right-no-padding">
					<p class="admin-categorie">Texte de présentation</p>
					<p><textarea name="<?php echo $PRES_TEXT; ?>" class="form-control" rows="8" spellcheck="false"><?php echo $general_data[$PRES_TEXT] ?></textarea></p>
				</div>
				<div class="col-sm-6">
					<p class="admin-categorie">Liens</p>
					<p><div class="row">
						<div class="col-sm-6 fw-bold">
							Adresse mail : <input type="text" name="<?php echo $LINK_MAIL; ?>" value="<?php echo $general_data[$LINK_MAIL] ?>" class="form-control">
						</div>
						<div class="col-sm-6 fw-bold">
							LinkedIn : <input type="text" name="<?php echo $LINK_LINKEDIN; ?>" value="<?php echo $general_data[$LINK_LINKEDIN] ?>" class="form-control">
						</div>
						<div class="col-sm-6 fw-bold">
							Github : <input type="text" name="<?php echo $LINK_GITHUB; ?>" value="<?php echo $general_data[$LINK_GITHUB] ?>" class="form-control">
						</div>
						<div class="col-sm-6 fw-bold">
							itch.io : <input type="text" name="<?php echo $LINK_ITCHIO; ?>" value="<?php echo $general_data[$LINK_ITCHIO] ?>" class="form-control">
						</div>
					</div></p>
					<p class="admin-categorie">Photo (carrée)</p><input type="file" name="<?php echo $PHOTO; ?>" class="form-control-file">
				</div>
			</div>
			<p class="text-center margetop15 margebot0"><input type="submit" name="<?php echo $SUBMIT; ?>" class="btn btn-primary" value="Enregistrer"></p>
		</form>
	</div>
</section>

<?php include('../utils/footer.php'); print_footer(array('start_dir' => "../")); ?>
</body>
</html>


<script type="text/javascript" src="../js/no_js.js"></script>
