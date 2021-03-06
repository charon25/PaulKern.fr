<?php 

require('check_connection.php');
require('../utils/bdd.php');
require('../utils/constants.php');
require_once('../utils/functions.php');

 ?>

<?php 

	$request = $bdd->query('SELECT * FROM `pk_data` WHERE `type`="general"');
	$general_data = json_decode($request->fetch()['data'], TRUE);

	if (isset($_POST[$GEN_SUBMIT])) {
		set_data_post($general_data, $GEN_PRES_TEXT);
		set_data_post($general_data, $GEN_LINK_MAIL);
		set_data_post($general_data, $GEN_LINK_LINKEDIN);
		set_data_post($general_data, $GEN_LINK_GITHUB);
		set_data_post($general_data, $GEN_LINK_ITCHIO);
		set_data_post($general_data, $GEN_TITLE);
		set_data_post($general_data, $GEN_META);

		if (!empty($_FILES) && $_FILES[$GEN_PHOTO]['size'] > 0) {
			$photo_path = save_file($GEN_PHOTO, "../", "img/general/", "photo");
			set_data($general_data, $GEN_PHOTO, $photo_path);
		}

		if (!empty($_FILES) && $_FILES[$GEN_CV]['size'] > 0) {
			$photo_path = save_file($GEN_CV, "../", "files/general/", "cv");
			set_data($general_data, $GEN_CV, $photo_path);
		}

		$insert_request = $bdd->prepare('UPDATE `pk_data` SET `data`=? WHERE `type`="general"');
		$insert_request->execute(array(json_encode($general_data)));
		$result = "Informations correctement enregistrées !";
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
				<a href="admin" class="btn btn-primary margetop15 back-button">← Retour</a>
				<a target="_blank" rel="noopener noreferrer" href="cheatsheet.pdf" class="btn btn-primary margetop15">Mardown cheatsheet</a>
				<div class="margebot25"></div>
			</div>
		</div>
	</div>
</section>

<section id="general-infos">
	<div class="container admin-element">
		<p class="admin-title bleu-big">Informations générales</p>
		<form enctype="multipart/form-data" method="post" action="#general-infos" class="form-group">
			<div class="row">
				<div class="col-sm-5 bordure-right-no-padding">
					<p class="admin-categorie">Texte de présentation</p>
					<p><textarea name="<?php echo $GEN_PRES_TEXT; ?>" class="form-control" spellcheck="false" style="height: 219px;"><?php echo $general_data[$GEN_PRES_TEXT] ?></textarea></p>
					<p class="admin-categorie">Titre principal</p>
					<p><input type="text" name="<?php echo $GEN_TITLE; ?>" class="form-control" value="<?php echo $general_data[$GEN_TITLE]; ?>"></p>
				</div>
				<div class="col-sm-7">
					<p class="admin-categorie">Liens</p>
					<p><div class="row">
						<div class="col-sm-6 fw-bold">
							Adresse mail : <input type="text" name="<?php echo $GEN_LINK_MAIL; ?>" value="<?php echo $general_data[$GEN_LINK_MAIL] ?>" class="form-control">
						</div>
						<div class="col-sm-6 fw-bold">
							LinkedIn : <input type="text" name="<?php echo $GEN_LINK_LINKEDIN; ?>" value="<?php echo $general_data[$GEN_LINK_LINKEDIN] ?>" class="form-control">
						</div>
						<div class="col-sm-6 fw-bold">
							Github : <input type="text" name="<?php echo $GEN_LINK_GITHUB; ?>" value="<?php echo $general_data[$GEN_LINK_GITHUB] ?>" class="form-control">
						</div>
						<div class="col-sm-6 fw-bold">
							itch.io : <input type="text" name="<?php echo $GEN_LINK_ITCHIO; ?>" value="<?php echo $general_data[$GEN_LINK_ITCHIO] ?>" class="form-control">
						</div>
					</div></p>
					<p><div class="row">
						<div class="col-sm-6">
							<p class="admin-categorie">Photo (carrée)</p><input type="file" name="<?php echo $GEN_PHOTO; ?>" class="form-control" accept="image/*">
						</div>
						<div class="col-sm-6">
							<p class="admin-categorie">CV</p><input type="file" name="<?php echo $GEN_CV; ?>" class="form-control" accept="application/pdf">
						</div>
					</div></p>
					<p class="admin-categorie">Meta description</p>
					<p><input type="text" name="<?php echo $GEN_META; ?>" class="form-control" value="<?php echo $general_data[$GEN_META]; ?>"></p>
				</div>
			</div>
			<p class="text-center margetop15 margebot0"><input type="submit" name="<?php echo $GEN_SUBMIT; ?>" class="btn btn-primary" value="Enregistrer"></p>
			<?php if (isset($result)) echo "<p class=\"resultat-positif decay\">$result</p>"; ?>
		</form>
	</div>
</section>

<?php include('../utils/footer.php'); print_footer(array('start_dir' => "../")); ?>
</body>
</html>

<script type="text/javascript" src="../js/decay.js"></script>
<script type="text/javascript" src="../js/no_js.js"></script>
