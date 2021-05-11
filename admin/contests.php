<?php 

require('check_connection.php');
require('../utils/bdd.php');
require('../utils/constants.php');
require('../utils/functions.php');

 ?>

<?php 

if (isset($_POST[$CON_SUBMIT])) {
	$contest_data = array(
		$CON_DATE_TXT => $_POST[$CON_DATE_TXT],
		$CON_NAME => $_POST[$CON_NAME],
		$CON_DESC => $_POST[$CON_DESC]
	);


	$insert_request = $bdd->prepare('INSERT INTO `pk_data`(`type`, `sorter`, `data`) VALUES (?, ?, ?);');
	$insert_request->execute(array(
		'contest',
		strtotime($_POST[$CON_ORDER]),
		json_encode($contest_data)
	));

	$pos_result = "La compétition a bien été créée !";
} elseif (isset($_POST[$CON_DELETE])) {
	$contest_id = $_POST[$CON_ACTION];

	$delete_request = $bdd->prepare('DELETE FROM `pk_data` WHERE `id`=?');
	$delete_request->execute(array($contest_id));

	$pos_result = 'Compétition correctement supprimée !';
}


 ?>

<?php 

$contests_request = $bdd->query('SELECT * FROM `pk_data` WHERE `type`="contest" ORDER BY `sorter` DESC');
$contests_data = array();
while ($contest = $contests_request->fetch()) {
	$contests_data[] = $contest;
}

 ?>

<!DOCTYPE html>
<html>
<?php include('../utils/head.php');	print_head(array('title' => "Espace administrateur - Compétitions", 'start_dir' => "../")); ?>
<body>


<?php //include('../utils/header.php'); print_header(array('start_dir' => "../")); ?>

<section id="presentation-first" class="first-section">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h1 class="margetop45 fw-bold titre-principal">Espace administrateur - Compétitions</h1>
				<a target="_blank" rel="noopener noreferrer" href="cheatsheet.pdf" class="btn btn-primary margetop15">Mardown cheatsheet</a>
				<div class="margebot25"></div>
			</div>
		</div>
	</div>
</section>

<section id="add-contest">
	<div class="container admin-element">
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-sm-6">
				<p class="admin-categorie">Action</p>
				<form enctype="multipart/form-data" method="post" action="#add-contest" class="form-group">
				<p><select class="form-control" id="<?php echo $CON_ACTION; ?>" name="<?php echo $CON_ACTION; ?>" onchange="on_action_changed();">
					<option value="X" selected="true">---</option>
					<?php 
						foreach ($contests_data as $key => $contest) {
							$con_json = json_decode($contest['data'], TRUE);
							echo '<option value="' . $contest['id'] . '">' . $con_json[$CON_NAME] . '</option>';
						}
					 ?>
				</select></p>
			</div>
		</div>
		<p class="admin-title bleu-big" id="contests_add_title">Ajouter une compétition</p>
			<div class="row">
				<p class="admin-categorie">Informations générales</p>
				<div class="col-sm-6 bordure-right-no-padding">
					<p class="fw-bold">Date textuelle : <input type="text" name="<?php echo $CON_DATE_TXT; ?>" class="form-control"></p>
					<p class="fw-bold">Date d'ordre : <input type="date" name="<?php echo $CON_ORDER; ?>" id="<?php echo $CON_ORDER; ?>" class="form-control" onchange="on_change();"></p>
				</div>
				<div class="col-sm-6">
					<p class="fw-bold">Nom : <input type="text" name="<?php echo $CON_NAME; ?>" class="form-control"></p>
					<p class="fw-bold">Description : <input type="text" name="<?php echo $CON_DESC; ?>" class="form-control"></p>
				</div>
			</div>
			<p class="text-center margetop15 margebot0">
				<input type="submit" name="<?php echo $CON_SUBMIT; ?>" id="<?php echo $CON_SUBMIT; ?>" class="btn btn-primary btn-vert" value="Ajouter" disabled>
				<input type="submit" name="<?php echo $CON_DELETE; ?>" id="<?php echo $CON_DELETE; ?>" class="btn btn-primary btn-rouge" value="Supprimer" style="margin-left: 25px;" onclick="return confirm('Voulez-vous réellement supprimer cette compétence ?');"></p>
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
		var order_date_selected = document.getElementById('<?php echo $CON_ORDER; ?>');
		var add_submit_button = document.getElementById('<?php echo $CON_SUBMIT; ?>');
		add_submit_button.disabled = (order_date_selected.value == "");
	}
	on_change();

	function change_buttons(add, modify_delete) {
		document.getElementById('<?php echo $CON_SUBMIT; ?>').style.display = add;
		document.getElementById('<?php echo $CON_DELETE; ?>').style.display = modify_delete;
	}

	function on_action_changed() {
		var action_selector = document.getElementById('<?php echo $CON_ACTION ?>');
		var id = action_selector.selectedOptions[0].value;
		if (id == "X") {
			change_buttons('inline', 'none');
			document.getElementById('contests_add_title').innerText = 'Ajouter une compétition';
			empty_fields();
		} else {
			change_buttons('none', 'inline');
			document.getElementById('contests_add_title').innerText = 'Supprimer une compétition';
			set_fields(id);
		}
	}
	on_action_changed();
</script>
<script type="text/javascript" src="../js/no_js.js"></script>
<script type="text/javascript" src="../js/decay.js"></script>
