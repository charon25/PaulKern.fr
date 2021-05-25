<?php 

require('check_connection.php');
require('../utils/bdd.php');
require('../utils/constants.php');
require_once('../utils/functions.php');

 ?>

<?php 

$last_modified = -1;
if (isset($_POST[$EXP_SUBMIT])) {
	$experience_data = array(
		$EXP_DATE_TXT => $_POST[$EXP_DATE_TXT],
		$EXP_NAME => $_POST[$EXP_NAME],
		$EXP_TITLE => $_POST[$EXP_TITLE],
		$EXP_PLACE => $_POST[$EXP_PLACE],
		$EXP_SHORT_DESC => $_POST[$EXP_SHORT_DESC],
		$EXP_DESC => $_POST[$EXP_DESC],
		$EXP_INC_DESC => (isset($_POST[$EXP_INC_DESC]) ? 1 : 0)
	);

	if (!empty($_FILES) && $_FILES[$EXP_MAIN_IMG]['size'] > 0) {
		$photo_path = save_file_random_name($EXP_MAIN_IMG, "../", "img/experiences/");
		$experience_data[$EXP_MAIN_IMG] = $photo_path;

		$insert_request = $bdd->prepare('INSERT INTO `pk_data`(`type`, `sorter`, `data`) VALUES (?, ?, ?)');
		$insert_request->execute(array(
			$_POST[$EXP_TYPE],
			strtotime($_POST[$EXP_DATE_ORDER]),
			json_encode($experience_data)
		));

		$pos_result = "Expérience correctement créée !";
	} else {
		$neg_result = "Pas d'image fournie !";
	}
} elseif (isset($_POST[$EXP_MODIFY])) {
	$experience_id = $_POST[$EXP_ACTION];
	$request_experience = $bdd->prepare('SELECT * FROM `pk_data` WHERE id=?');
	$request_experience->execute(array($experience_id));
	$experience_data = json_decode($request_experience->fetch()['data'], TRUE);

	set_data_post($experience_data, $EXP_DATE_TXT);
	set_data_post($experience_data, $EXP_NAME);
	set_data_post($experience_data, $EXP_TITLE);
	set_data_post($experience_data, $EXP_PLACE);
	set_data_post($experience_data, $EXP_DESC);
	set_data_post($experience_data, $EXP_SHORT_DESC);

	if (!empty($_FILES) && $_FILES[$EXP_MAIN_IMG]['size'] > 0) {
		$previous_image_path = $experience_data[$EXP_MAIN_IMG];
		unlink("../" . $previous_image_path);
		$photo_path = save_file_random_name($EXP_MAIN_IMG, "../", "img/experiences/");
		$experience_data[$EXP_MAIN_IMG] = $photo_path;
	}


	$insert_request = $bdd->prepare('UPDATE `pk_data` SET `data`=? WHERE `id`=?');
	$insert_request->execute(array(json_encode($experience_data), $experience_id));
	$pos_result = "Expérience correctement modifiée !";
	$last_modified = $experience_id;
} elseif (isset($_POST[$EXP_DELETE])) {
	$experience_id = $_POST[$EXP_ACTION];

	$image_request = $bdd->prepare('SELECT `data` FROM `pk_data` WHERE `id`=?');
	$image_request->execute(array($experience_id));
	$image_path = json_decode($image_request->fetch()['data'], TRUE)[$EXP_MAIN_IMG];
	unlink('../' . $image_path);

	$delete_request = $bdd->prepare('DELETE FROM `pk_data` WHERE id=?');
	$delete_request->execute(array($experience_id));
	
	$pos_result = "Expérience correctement supprimée !";
}

 ?>

<?php 

$experiences_request = $bdd->query('SELECT * FROM `pk_data` WHERE `type`="pro" OR `type`="extra" ORDER BY `sorter` DESC');
$experiences_data = array();
while ($experience = $experiences_request->fetch()) {
	$experiences_data[] = $experience;
}

 ?>

<!DOCTYPE html>
<html>
<?php include('../utils/head.php');	print_head(array('title' => "Espace administrateur - Expériences", 'start_dir' => "../")); ?>
<body>


<?php include('../utils/header.php'); print_header(array('start_dir' => "../")); ?>

<section id="presentation-first" class="first-section">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h1 class="margetop45 fw-bold titre-principal">Espace administrateur - Expériences</h1>
				<a href="admin" class="btn btn-primary margetop15 back-button">← Retour</a>
				<a target="_blank" rel="noopener noreferrer" href="cheatsheet.pdf" class="btn btn-primary margetop15">Mardown cheatsheet</a>
				<div class="margebot25"></div>
			</div>
		</div>
	</div>
</section>

<section id="add-experience">
	<div class="container admin-element">
		<form enctype="multipart/form-data" method="post" action="#add-experience" class="form-group">
			<div class="row">
				<div class="col-sm-3"></div>
				<div class="col-sm-6">
					<p class="admin-categorie">Action</p>
					<p><select class="form-control" id="<?php echo $EXP_ACTION; ?>" name="<?php echo $EXP_ACTION; ?>" onchange="on_action_changed();">
						<option value="X" <?php if ($last_modified < 0) echo 'selected="true"' ?>>---</option>
						<?php 
							foreach ($experiences_data as $key => $experience) {
								$exp_json = json_decode($experience['data'], TRUE);
								echo '<option value="' . $experience['id'] . '" ' . ($last_modified == $experience['id'] ? 'selected="true"' : '') . '>' . $exp_json[$EXP_NAME] . ' - ' . $exp_json[$EXP_TITLE] . '</option>';
							}
						 ?>
					</select></p>
					<?php 
						foreach ($experiences_data as $key => $experience) {
							echo '<div class="hidden" id="' . $EXP_DATA . '-' . $experience['id'] . '">' . $experience['data'] . '</div>';
						}
					 ?>
				</div>
			</div>
			<p class="admin-title bleu-big" id="experience_add_title">Ajouter une expérience</p>
			<div class="row">
				<p class="admin-categorie">Informations générales</p>
				<div class="col-sm-6 bordure-right-no-padding">
					<p class="fw-bold">Date textuelle : <input type="text" name="<?php echo $EXP_DATE_TXT; ?>" class="form-control"></p>
					<p class="fw-bold">Date d'ordre : <input type="date" name="<?php echo $EXP_DATE_ORDER; ?>" id="<?php echo $EXP_DATE_ORDER; ?>" class="form-control" onchange="on_change();"></p>
				</div>
				<div class="col-sm-6">
					<p class="fw-bold">Nom de l'organisme : <input type="text" name="<?php echo $EXP_NAME; ?>" class="form-control"></p>
					<p class="fw-bold">Intitulé : <input type="text" name="<?php echo $EXP_TITLE; ?>" class="form-control"></p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6 bordure-right-no-padding">
					<p class="admin-categorie">Description longue</p>
					<textarea class="form-control margebot15" rows="13" name="<?php echo $EXP_DESC; ?>"></textarea>
					<p><input type="checkbox" name="<?php echo $EXP_INC_DESC; ?>" id="<?php echo $EXP_INC_DESC; ?>" style="margin-right: 10px;" checked><label for="<?php echo $EXP_INC_DESC; ?>">Inclure la description courte dans la longue</label></p>
				</div>
				<div class="col-sm-6">
					<p class="fw-bold">Lieu : <input type="text" name="<?php echo $EXP_PLACE; ?>" class="form-control"></p>
					<p class="admin-categorie">Description courte</p>
					<p><textarea class="form-control" rows="3" name="<?php echo $EXP_SHORT_DESC; ?>"></textarea></p>
					<p class="admin-categorie">Type</p>
					<p><select class="form-control" id="<?php echo $EXP_TYPE; ?>" name="<?php echo $EXP_TYPE; ?>" onchange="on_change();">
						<option>---</option>
						<option <?php if (isset($_GET['type']) && $_GET['type'] == 'pro') echo 'selected="true"'; ?> value="pro">Expérience professionnelle</option>
						<option <?php if (isset($_GET['type']) && $_GET['type'] == 'extra') echo 'selected="true"'; ?> value="extra">Expérience extra-professionnelle</option>
					</select></p>
					<p class="admin-categorie">Images</p>
					<p class="fw-bold">Image principale : <input type="file" name="<?php echo $EXP_MAIN_IMG; ?>" class="form-control" accept="image/*"></p>
				</div>
			</div>
			<p class="text-center margetop15 margebot0">
				<input type="submit" name="<?php echo $EXP_SUBMIT; ?>" id="<?php echo $EXP_SUBMIT; ?>" class="btn btn-primary btn-vert" value="Ajouter" disabled>
				<input type="submit" name="<?php echo $EXP_MODIFY; ?>" id="<?php echo $EXP_MODIFY; ?>" class="btn btn-primary" value="Modifier">
				<input type="submit" name="<?php echo $EXP_DELETE; ?>" id="<?php echo $EXP_DELETE; ?>" class="btn btn-primary btn-rouge" value="Supprimer" style="margin-left: 25px;" onclick="return confirm('Voulez-vous réellement supprimer cette expérience ?');"></p>
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
		var add_type_selector = document.getElementById('<?php echo $EXP_TYPE; ?>');
		var add_submit_button = document.getElementById('<?php echo $EXP_SUBMIT; ?>');
		var order_date_selected = document.getElementById('<?php echo $EXP_DATE_ORDER; ?>');
		add_submit_button.disabled = (add_type_selector.selectedIndex == 0) || (order_date_selected.value == "");
	}
	on_change();

	function change_buttons(add, modify_delete) {
		document.getElementById('<?php echo $EXP_SUBMIT; ?>').style.display = add;
		document.getElementById('<?php echo $EXP_MODIFY; ?>').style.display = modify_delete;
		document.getElementById('<?php echo $EXP_DELETE; ?>').style.display = modify_delete;
	}

	function empty_fields() {
		document.getElementsByName('<?php echo $EXP_DATE_TXT; ?>')[0].value = "";
		document.getElementsByName('<?php echo $EXP_NAME; ?>')[0].value = "";
		document.getElementsByName('<?php echo $EXP_TITLE; ?>')[0].value = "";
		document.getElementsByName('<?php echo $EXP_PLACE; ?>')[0].value = "";
		document.getElementsByName('<?php echo $EXP_DESC; ?>')[0].value = "";
		document.getElementsByName('<?php echo $EXP_SHORT_DESC; ?>')[0].value = "";
	}

	function set_fields(id) {
		var data = JSON.parse(document.getElementById('<?php echo $EXP_DATA; ?>-' + id).innerText);
		document.getElementsByName('<?php echo $EXP_DATE_TXT; ?>')[0].value = data['<?php echo $EXP_DATE_TXT; ?>'];
		document.getElementsByName('<?php echo $EXP_NAME; ?>')[0].value = data['<?php echo $EXP_NAME; ?>'];
		document.getElementsByName('<?php echo $EXP_TITLE; ?>')[0].value = data['<?php echo $EXP_TITLE; ?>'];
		document.getElementsByName('<?php echo $EXP_PLACE; ?>')[0].value = data['<?php echo $EXP_PLACE; ?>'];
		document.getElementsByName('<?php echo $EXP_DESC; ?>')[0].value = data['<?php echo $EXP_DESC; ?>'];
		document.getElementsByName('<?php echo $EXP_SHORT_DESC; ?>')[0].value = data['<?php echo $EXP_SHORT_DESC; ?>'];
	}

	function on_action_changed() {
		var action_selector = document.getElementById('<?php echo $EXP_ACTION ?>');
		var id = action_selector.selectedOptions[0].value;
		if (id == "X") {
			change_buttons('inline', 'none');
			document.getElementById('experience_add_title').innerText = 'Ajouter une expérience';
			empty_fields();
		} else {
			change_buttons('none', 'inline');
			document.getElementById('experience_add_title').innerText = "Modifier ou supprimer l'expérience";
			set_fields(id);
		}
	}
	on_action_changed();
</script>
<script type="text/javascript" src="../js/no_js.js"></script>
<script type="text/javascript" src="../js/decay.js"></script>
