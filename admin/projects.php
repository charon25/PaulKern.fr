<?php 

require('check_connection.php');
require('../utils/bdd.php');
require('../utils/constants.php');
require('../utils/functions.php');

 ?>

<?php 

$last_modified = -1;
if (isset($_POST[$PRO_SUBMIT])) {
	$project_data = array(
		$PRO_DATE_TXT => $_POST[$PRO_DATE_TXT],
		$PRO_URL => $_POST[$PRO_URL],
		$PRO_TITLE => $_POST[$PRO_TITLE],
		$PRO_SHORT_DESC => $_POST[$PRO_SHORT_DESC],
		$PRO_DESC => $_POST[$PRO_DESC]
	);

	if (!empty($_FILES) && $_FILES[$PRO_MAIN_IMG]['size'] > 0) {
		$photo_path = save_file_random_name($PRO_MAIN_IMG, "../", "img/projects/");
		$project_data[$PRO_MAIN_IMG] = $photo_path;

		$insert_request = $bdd->prepare('INSERT INTO `pk_data`(`type`, `sorter`, `data`) VALUES (?, ?, ?)');
		$insert_request->execute(array(
			$_POST[$PRO_TYPE],
			$_POST[$PRO_ORDER],
			json_encode($project_data)
		));

		$pos_result = 'Projet correctement créé !';
	} else {
		$neg_result = 'Aucune image principale fournie !';
	}
} elseif (isset($_POST[$PRO_MODIFY])) {
	$project_id = $_POST[$PRO_ACTION];
	$request_project = $bdd->prepare('SELECT * FROM `pk_data` WHERE id=?');
	$request_project->execute(array($project_id));
	$project_data = json_decode($request_project->fetch()['data'], TRUE);

	set_data_post($project_data, $PRO_DATE_TXT);
	set_data_post($project_data, $PRO_URL);
	set_data_post($project_data, $PRO_TITLE);
	set_data_post($project_data, $PRO_DESC);
	set_data_post($project_data, $PRO_SHORT_DESC);

	if (!empty($_FILES) && $_FILES[$PRO_MAIN_IMG]['size'] > 0) {
		$previous_image_path = $project_data[$PRO_MAIN_IMG];
		unlink("../" . $previous_image_path);
		$photo_path = save_file_random_name($PRO_MAIN_IMG, "../", "img/projects/");
		$project_data[$PRO_MAIN_IMG] = $photo_path;
	}


	$insert_request = $bdd->prepare('UPDATE `pk_data` SET `data`=? WHERE `id`=?');
	$insert_request->execute(array(json_encode($project_data), $project_id));
	$pos_result = "Projet correctement modifié !";
	$last_modified = $project_id;
} elseif (isset($_POST[$PRO_DELETE])) {
	$project_id = $_POST[$PRO_ACTION];

	$delete_request = $bdd->prepare('DELETE FROM `pk_data` WHERE id=?');
	$delete_request->execute(array($project_id));
	
	$pos_result = "Projet correctement supprimé !";
}

 ?>

<?php 

$projects_request = $bdd->query('SELECT * FROM `pk_data` WHERE `type`="perso" OR `type`="sco" ORDER BY `sorter` DESC');
$projects_data = array();
while ($project = $projects_request->fetch()) {
	$projects_data[] = $project;
}

 ?>

<!DOCTYPE html>
<html>
<?php include('../utils/head.php');	print_head(array('title' => "Espace administrateur - Projets", 'start_dir' => "../")); ?>
<body>


<?php //include('../utils/header.php'); print_header(array('start_dir' => "../")); ?>

<section id="presentation-first" class="first-section">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h1 class="margetop45 fw-bold titre-principal">Espace administrateur - Projets</h1>
				<a target="_blank" rel="noopener noreferrer" href="cheatsheet.pdf" class="btn btn-primary margetop15">Mardown cheatsheet</a>
				<div class="margebot25"></div>
			</div>
		</div>
	</div>
</section>

<section id="add-project">
	<div class="container admin-element">
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-sm-6">
				<p class="admin-categorie">Action</p>
				<form enctype="multipart/form-data" method="post" action="#add-project" class="form-group">
				<p><select class="form-control" id="<?php echo $PRO_ACTION; ?>" name="<?php echo $PRO_ACTION; ?>" onchange="on_action_changed();">
					<option value="X" <?php if ($last_modified < 0) echo 'selected="true"' ?>>---</option>
					<?php 
						foreach ($projects_data as $key => $project) {
							$pro_json = json_decode($project['data'], TRUE);
							echo '<option value="' . $project['id'] . '" ' . ($last_modified == $project['id'] ? 'selected="true"' : '') . '>' . $pro_json[$PRO_TITLE] . ' - ' . $pro_json[$PRO_DATE_TXT] . '</option>';
						}
					 ?>
				</select></p>
				<?php 
					foreach ($projects_data as $key => $project) {
						echo '<div class="hidden" id="' . $PRO_DATA . '-' . $project['id'] . '">' . $project['data'] . '</div>';
					}
				 ?>
			</div>
		</div>
		<p class="admin-title bleu-big" id="project_add_title">Ajouter un Projet</p>
			<div class="row">
				<p class="admin-categorie">Informations générales</p>
				<div class="col-sm-6 bordure-right-no-padding">
					<p class="fw-bold">Date textuelle : <input type="text" name="<?php echo $PRO_DATE_TXT; ?>" class="form-control"></p>
					<p class="fw-bold">Importance : <input type="number" name="<?php echo $PRO_ORDER; ?>" id="<?php echo $PRO_ORDER; ?>" class="form-control" onchange="on_change();"></p>
				</div>
				<div class="col-sm-6">
					<p class="fw-bold">Intitulé : <input type="text" name="<?php echo $PRO_TITLE; ?>" class="form-control"></p>
					<p class="fw-bold">Lien : <input type="text" name="<?php echo $PRO_URL; ?>" class="form-control"></p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6 bordure-right-no-padding">
					<p class="admin-categorie">Description longue</p>
					<textarea class="form-control" rows="12" name="<?php echo $PRO_DESC; ?>"></textarea>
				</div>
				<div class="col-sm-6">
					<p class="admin-categorie">Description courte</p>
					<p><textarea class="form-control" rows="3" name="<?php echo $PRO_SHORT_DESC; ?>"></textarea></p>
					<p class="admin-categorie">Type</p>
					<p><select class="form-control" id="<?php echo $PRO_TYPE; ?>" name="<?php echo $PRO_TYPE; ?>" onchange="on_change();">
						<option>---</option>
						<option <?php if (isset($_GET['type']) && $_GET['type'] == 'perso') echo 'selected="true"'; ?> value="perso">Projet personnel</option>
						<option <?php if (isset($_GET['type']) && $_GET['type'] == 'sco') echo 'selected="true"'; ?> value="sco">Projet scolaire</option>
					</select></p>
					<p class="admin-categorie">Images</p>
					<p class="fw-bold">Image principale : <input type="file" name="<?php echo $PRO_MAIN_IMG; ?>" class="form-control" accept="image/*"></p>
				</div>
			</div>
			<p class="text-center margetop15 margebot0">
				<input type="submit" name="<?php echo $PRO_SUBMIT; ?>" id="<?php echo $PRO_SUBMIT; ?>" class="btn btn-primary btn-vert" value="Ajouter" disabled>
				<input type="submit" name="<?php echo $PRO_MODIFY; ?>" id="<?php echo $PRO_MODIFY; ?>" class="btn btn-primary" value="Modifier">
				<input type="submit" name="<?php echo $PRO_DELETE; ?>" id="<?php echo $PRO_DELETE; ?>" class="btn btn-primary btn-rouge" value="Supprimer" style="margin-left: 25px;" onclick="return confirm('Voulez-vous réellement supprimer ce projet ?');"></p>
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
		var add_type_selector = document.getElementById('<?php echo $PRO_TYPE; ?>');
		var add_submit_button = document.getElementById('<?php echo $PRO_SUBMIT; ?>');
		var order_date_selected = document.getElementById('<?php echo $PRO_ORDER; ?>');
		add_submit_button.disabled = (add_type_selector.selectedIndex == 0) || (order_date_selected.value == "");
	}
	on_change();

	function change_buttons(add, modify_delete) {
		document.getElementById('<?php echo $PRO_SUBMIT; ?>').style.display = add;
		document.getElementById('<?php echo $PRO_MODIFY; ?>').style.display = modify_delete;
		document.getElementById('<?php echo $PRO_DELETE; ?>').style.display = modify_delete;
	}

	function empty_fields() {
		document.getElementsByName('<?php echo $PRO_DATE_TXT; ?>')[0].value = "";
		document.getElementsByName('<?php echo $PRO_URL; ?>')[0].value = "";
		document.getElementsByName('<?php echo $PRO_TITLE; ?>')[0].value = "";
		document.getElementsByName('<?php echo $PRO_DESC; ?>')[0].value = "";
		document.getElementsByName('<?php echo $PRO_SHORT_DESC; ?>')[0].value = "";
	}

	function set_fields(id) {
		var data = JSON.parse(document.getElementById('<?php echo $PRO_DATA; ?>-' + id).innerText);
		document.getElementsByName('<?php echo $PRO_DATE_TXT; ?>')[0].value = data['<?php echo $PRO_DATE_TXT; ?>'];
		document.getElementsByName('<?php echo $PRO_URL; ?>')[0].value = data['<?php echo $PRO_URL; ?>'];
		document.getElementsByName('<?php echo $PRO_TITLE; ?>')[0].value = data['<?php echo $PRO_TITLE; ?>'];
		document.getElementsByName('<?php echo $PRO_DESC; ?>')[0].value = data['<?php echo $PRO_DESC; ?>'];
		document.getElementsByName('<?php echo $PRO_SHORT_DESC; ?>')[0].value = data['<?php echo $PRO_SHORT_DESC; ?>'];
	}

	function on_action_changed() {
		var action_selector = document.getElementById('<?php echo $PRO_ACTION ?>');
		var id = action_selector.selectedOptions[0].value;
		if (id == "X") {
			change_buttons('inline', 'none');
			empty_fields();
		} else {
			change_buttons('none', 'inline');
			set_fields(id);
		}
	}
	on_action_changed();
</script>
<script type="text/javascript" src="../js/no_js.js"></script>
<script type="text/javascript" src="../js/decay.js"></script>
