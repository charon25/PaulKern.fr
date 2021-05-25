<?php 

require('check_connection.php');
require('../utils/bdd.php');
require('../utils/constants.php');
require_once('../utils/functions.php');

 ?>

<?php 

$last_modified = -1;

if (isset($_POST[$SKI_SUBMIT])) {
	$skill_data = array(
		$SKI_NAME => $_POST[$SKI_NAME],
		$SKI_TYPE => $_POST[$SKI_TYPE],
		$SKI_LEVEL => $_POST[$SKI_LEVEL]
	);

	if (!empty($_FILES) && $_FILES[$SKI_IMG]['size'] > 0) {
		$photo_path = save_file_random_name($SKI_IMG, "../", "img/skills/");
		$skill_data[$SKI_IMG] = $photo_path;

		$insert_request = $bdd->prepare('INSERT INTO `pk_data`(`type`, `sorter`, `data`) VALUES (?, ?, ?);');
		$insert_request->execute(array(
			'skill',
			$_POST[$SKI_ORDER],
			json_encode($skill_data)
		));
		$pos_result = "La compétence a bien été créée !";
	} else {
		$neg_result = "Pas d'image fournie !";
	}
} elseif (isset($_POST[$SKI_DELETE])) {
	$skill_id = $_POST[$SKI_ACTION];

	$image_request = $bdd->prepare('SELECT `data` FROM `pk_data` WHERE `id`=?');
	$image_request->execute(array($skill_id));
	$image_path = json_decode($image_request->fetch()['data'], TRUE)[$SKI_IMG];
	unlink('../' . $image_path);

	$delete_request = $bdd->prepare('DELETE FROM `pk_data` WHERE `id`=?');
	$delete_request->execute(array($skill_id));

	$pos_result = 'Compétence correctement supprimée !';
}


 ?>

<?php 

$skills_request = $bdd->query('SELECT * FROM `pk_data` WHERE `type`="skill" ORDER BY `id` ASC');
$skills_data = array();
while ($skill = $skills_request->fetch()) {
	$skills_data[] = $skill;
}

 ?>

<!DOCTYPE html>
<html>
<?php include('../utils/head.php');	print_head(array('title' => "Espace administrateur - Compétences", 'start_dir' => "../")); ?>
<body>


<?php include('../utils/header.php'); print_header(array('start_dir' => "../")); ?>

<section id="presentation-first" class="first-section">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h1 class="margetop45 fw-bold titre-principal">Espace administrateur - Compétences</h1>
				<a href="admin" class="btn btn-primary margetop15 back-button">← Retour</a>
				<a target="_blank" rel="noopener noreferrer" href="cheatsheet.pdf" class="btn btn-primary margetop15">Mardown cheatsheet</a>
				<div class="margebot25"></div>
			</div>
		</div>
	</div>
</section>

<section id="add-skill">
	<div class="container admin-element">
		<form enctype="multipart/form-data" method="post" action="#add-skill" class="form-group">
			<div class="row">
				<div class="col-sm-3"></div>
				<div class="col-sm-6">
					<p class="admin-categorie">Action</p>
					<p><select class="form-control" id="<?php echo $SKI_ACTION; ?>" name="<?php echo $SKI_ACTION; ?>" onchange="on_action_changed();">
						<option value="X" selected="true">---</option>
						<?php 
							foreach ($skills_data as $key => $skill) {
								$ski_json = json_decode($skill['data'], TRUE);
								echo '<option value="' . $skill['id'] . '">' . $ski_json[$SKI_NAME] . '</option>';
							}
						 ?>
					</select></p>
				</div>
			</div>
			<p class="admin-title bleu-big" id="skills_add_title">Ajouter une compétence</p>
			<div class="row">
				<p class="admin-categorie">Informations générales</p>
				<div class="col-sm-6 bordure-right-no-padding">
					<p class="fw-bold">Nom : <input type="text" name="<?php echo $SKI_NAME; ?>" class="form-control"></p>
					<p class="fw-bold">Importance : <input type="number" name="<?php echo $SKI_ORDER; ?>" id="<?php echo $SKI_ORDER; ?>" class="form-control" onchange="on_change();"></p>
					<p class="fw-bold">Image : <input type="file" name="<?php echo $SKI_IMG; ?>" class="form-control" accept="image/*"></p>
				</div>
				<div class="col-sm-6">
					<p class="fw-bold">Type :
						<select name="<?php echo $SKI_TYPE; ?>" id="<?php echo $SKI_TYPE; ?>" class="form-control" onchange="on_change();">
						<option selected="True">---</option>
						<option value="general">Générales</option>
						<option value="programming">Langage de programmation</option>
						<option value="software">Logiciels & OS</option>
						<option value="human">Humaines</option>
					</select></p>
					<p class="fw-bold">Niveau :
					<select name="<?php echo $SKI_LEVEL; ?>" id="<?php echo $SKI_LEVEL; ?>" class="form-control" onchange="on_change();">
						<option selected="True">---</option>
						<option value="master">Maîtrisé</option>
						<option value="inter">Niveau intermédiaire</option>
					</select></p>
				</div>
			</div>
			<p class="text-center margetop15 margebot0">
				<input type="submit" name="<?php echo $SKI_SUBMIT; ?>" id="<?php echo $SKI_SUBMIT; ?>" class="btn btn-primary btn-vert" value="Ajouter" disabled>
				<input type="submit" name="<?php echo $SKI_DELETE; ?>" id="<?php echo $SKI_DELETE; ?>" class="btn btn-primary btn-rouge" value="Supprimer" style="margin-left: 25px;" onclick="return confirm('Voulez-vous réellement supprimer cette compétence ?');"></p>
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
		var type_selector = document.getElementById('<?php echo $SKI_TYPE; ?>');
		var level_selector = document.getElementById('<?php echo $SKI_LEVEL; ?>');
		var order_date_selected = document.getElementById('<?php echo $SKI_ORDER; ?>');
		var add_submit_button = document.getElementById('<?php echo $SKI_SUBMIT; ?>');
		add_submit_button.disabled = (type_selector.selectedIndex == 0) || (level_selector.selectedIndex == 0) || (order_date_selected.value == "");
	}
	on_change();

	function change_buttons(add, modify_delete) {
		document.getElementById('<?php echo $SKI_SUBMIT; ?>').style.display = add;
		document.getElementById('<?php echo $SKI_DELETE; ?>').style.display = modify_delete;
	}

	function on_action_changed() {
		var action_selector = document.getElementById('<?php echo $SKI_ACTION ?>');
		var id = action_selector.selectedOptions[0].value;
		if (id == "X") {
			change_buttons('inline', 'none');
			document.getElementById('skills_add_title').innerText = 'Ajouter une compétence';
			empty_fields();
		} else {
			change_buttons('none', 'inline');
			document.getElementById('skills_add_title').innerText = 'Supprimer une compétence';
			set_fields(id);
		}
	}
	on_action_changed();
</script>
<script type="text/javascript" src="../js/no_js.js"></script>
<script type="text/javascript" src="../js/decay.js"></script>
