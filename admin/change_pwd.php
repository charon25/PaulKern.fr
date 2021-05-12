<?php 

require('check_connection.php');

 ?>

<?php 

$COST = 11;

if (isset($_POST['change'])) {
	$hashed_password = file_get_contents('password.config');
	if (password_verify($_POST['old_password'], $hashed_password)) {
		if ($_POST['new_password'] != '' && $_POST['new_password'] == $_POST['new_password_confirm']) {
			$new_hash = password_hash($_POST['new_password'], PASSWORD_BCRYPT, ["cost" => $COST]);
			file_put_contents('password.config', $new_hash);
			$pos_result = "Mot de passe modifié avec succès !";
		} else {
			$neg_result = "Les mots de passe sont invalides ou ne correspondent pas.";
		}
	} else {
		$neg_result = "Le mot de passe actuel est incorrect.";
	}
}

 ?>

<!DOCTYPE html>
<html>
<?php include('../utils/head.php');	print_head(array('title' => "Espace administrateur - Changement le mot de passe", 'start_dir' => "../")); ?>
<body>


<?php include('../utils/header.php'); print_header(array('start_dir' => "../")); ?>

<section id="presentation-first" class="first-section">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h1 class="margetop45 fw-bold titre-principal">Espace administrateur - Changement de mot de passe</h1>
				<a href="admin" class="btn btn-primary margetop15 back-button-alone">← Retour</a>
				<div class="margebot25"></div>
			</div>
		</div>
	</div>
</section>

<section id="add-skill">
	<div class="container admin-element">
		<form method="post" action="#add-skill" class="form-group">
			<p class="admin-title bleu-big" id="experience_add_title">Changer le mot de passe</p>
			<div class="row">
				<div class="col-sm-3"></div>
				<div class="col-sm-6">
					<p class="fw-bold">Mot de passe actuel : <input type="password" name="old_password" class="form-control"></p>
					<p class="fw-bold">Nouveau mot de passe : <input type="password" name="new_password" class="form-control"></p>
					<p class="fw-bold">Confirmation : <input type="password" name="new_password_confirm" class="form-control"></p>
					<div class="margetop25"></div>
					<input type="submit" class="btn btn-primary bouton" name="change" value="Changer le mot de passe">
					<?php if (isset($pos_result)) echo "<p class=\"resultat-positif decay text-center\">$pos_result</p>"; ?>
					<?php if (isset($neg_result)) echo "<p class=\"resultat-negatif decay text-center\">$neg_result</p>"; ?>
				</div>
			</div>			
		</form>
	</div>
</section>

<?php include('../utils/footer.php'); print_footer(array('start_dir' => "../")); ?>
</body>
</html>


<script type="text/javascript" src="../js/no_js.js"></script>
<script type="text/javascript" src="../js/decay.js"></script>
