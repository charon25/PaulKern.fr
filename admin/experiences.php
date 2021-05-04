<?php 

require('check_connection.php');
require('../utils/bdd.php');
require('../utils/constants.php');
require('../utils/functions.php');

 ?>

<?php 

	if (isset($_POST[$EXP_A_SUBMIT])) {
		$experience_data = array(
			$EXP_A_DATE_TXT => $_POST[$EXP_A_DATE_TXT],
			$EXP_A_NAME => $_POST[$EXP_A_NAME],
			$EXP_A_TITLE => $_POST[$EXP_A_TITLE],
			$EXP_A_SHORT_DESC => $_POST[$EXP_A_SHORT_DESC],
			$EXP_A_DESC => $_POST[$EXP_A_DESC]
		);

		if (!empty($_FILES) && $_FILES[$EXP_A_MAIN_IMG]['size'] > 0) {
			$photo_path = save_file_random_name($EXP_A_MAIN_IMG, "../", "img/experiences/");
			$experience_data[$EXP_A_MAIN_IMG] = $photo_path;

			if (count($_FILES[$EXP_A_SEC_IMG]['size']) > 0 && $_FILES[$EXP_A_SEC_IMG]['size'][0] > 0) {
				$photo_paths = save_multiple_files_random_name($EXP_A_SEC_IMG, "../", "img/experiences/");
				$experience_data[$EXP_A_SEC_IMG] = $photo_paths;
			}

			$insert_request = $bdd->prepare('INSERT INTO `pk_data`(`type`, `sorter`, `data`) VALUES (?, ?, ?)');
			$insert_request->execute(array(
				$_POST[$EXP_A_TYPE],
				strtotime($_POST[$EXP_A_DATE_ORDER]),
				json_encode($experience_data)
			));

			$pos_result = 'Expérience correctement créée !';
		} else {
			$neg_result = 'Aucune image principale fournie !';
		}

	}

 ?>

<!DOCTYPE html>
<html>
<?php include('../utils/head.php');	print_head(array('title' => "Espace administrateur - Général", 'start_dir' => "../")); ?>
<body>


<?php //include('../utils/header.php'); print_header(array('start_dir' => "../")); ?>

<section id="presentation-first" class="first-section">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h1 class="margetop45 fw-bold titre-principal">Espace administrateur - Expériences</h1>
				<div class="margebot45"></div>
			</div>
		</div>
	</div>
</section>

<section id="add-experience">
	<div class="container admin-element">
		<p class="admin-title bleu-big">Ajouter une expérience</p>
		<form enctype="multipart/form-data" method="post" action="#add-experience" class="form-group">
			<div class="row">
				<p class="admin-categorie">Informations générales</p>
				<div class="col-sm-6 bordure-right-no-padding">
					<p class="fw-bold">Date textuelle : <input type="text" name="<?php echo $EXP_A_DATE_TXT; ?>" class="form-control"></p>
					<p class="fw-bold">Date d'ordre : <input type="date" name="<?php echo $EXP_A_DATE_ORDER; ?>" id="<?php echo $EXP_A_DATE_ORDER; ?>" class="form-control" onchange="on_change();"></p>
				</div>
				<div class="col-sm-6">
					<p class="fw-bold">Nom de l'organisme : <input type="text" name="<?php echo $EXP_A_NAME; ?>" class="form-control"></p>
					<p class="fw-bold">Intitulé : <input type="text" name="<?php echo $EXP_A_TITLE; ?>" class="form-control"></p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6 bordure-right-no-padding">
					<p class="admin-categorie">Description longue</p>
					<textarea class="form-control" rows="15" name="<?php echo $EXP_A_DESC; ?>"></textarea>
				</div>
				<div class="col-sm-6">
					<p class="admin-categorie">Description courte</p>
					<p><textarea class="form-control" rows="3" name="<?php echo $EXP_A_SHORT_DESC; ?>"></textarea></p>
					<p class="admin-categorie">Type</p>
					<p><select class="form-control" id="<?php echo $EXP_A_TYPE; ?>" name="<?php echo $EXP_A_TYPE; ?>" onchange="on_change();">
						<option>---</option>
						<option <?php if (isset($_GET['type']) && $_GET['type'] == 'pro') echo 'selected="true"'; ?> value="pro">Expérience professionnelle</option>
						<option <?php if (isset($_GET['type']) && $_GET['type'] == 'extra') echo 'selected="true"'; ?> value="extra">Expérience extra-professionnelle</option>
					</select></p>
					<p class="admin-categorie">Images</p>
					<p class="fw-bold">Image principale : <input type="file" name="<?php echo $EXP_A_MAIN_IMG; ?>" class="form-control" accept="image/*"></p>
					<p class="fw-bold">Images secondaires : <input type="file" name="<?php echo $EXP_A_SEC_IMG . '[]'; ?>" class="form-control" accept="image/*" multiple></p>
				</div>
			</div>
			<!--<p class="admin-categorie margetop15">Type</p>-->
			<p class="text-center margetop15 margebot0"><input type="submit" name="<?php echo $EXP_A_SUBMIT; ?>" id="<?php echo $EXP_A_SUBMIT; ?>" class="btn btn-primary" value="Ajouter" disabled></p>
			<?php if (isset($pos_result)) echo "<p class=\"resultat-positif decay\">$pos_result</p>"; ?>
			<?php if (isset($neg_result)) echo "<p class=\"resultat-negatif decay\">$neg_result</p>"; ?>
		</form>
	</div>
</section>

<?php include('../utils/footer.php'); print_footer(array('start_dir' => "../")); ?>
</body>
</html>

<script type="text/javascript">
	function on_change() {
		var add_type_selector = document.getElementById('<?php echo $EXP_A_TYPE; ?>');
		var add_submit_button = document.getElementById('<?php echo $EXP_A_SUBMIT; ?>');
		var order_date_selected = document.getElementById('<?php echo $EXP_A_DATE_ORDER; ?>');
		add_submit_button.disabled = (add_type_selector.selectedIndex == 0) || (order_date_selected.value == "");
	}
	on_change();
</script>
<script type="text/javascript" src="../js/no_js.js"></script>
<script type="text/javascript" src="../js/decay.js"></script>
