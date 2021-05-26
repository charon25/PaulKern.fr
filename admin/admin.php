<?php 

	require('check_connection.php');

 ?>

<?php 

require('../utils/bdd.php');

$FIRST_ID = 1;
$visits_request = $bdd->query('SELECT `id` FROM `pk_visits` ORDER BY `id` DESC LIMIT 1');
$last_id = $visits_request->fetch()['id'];
$visits_count = $last_id - $FIRST_ID + 1;

 ?>


<!DOCTYPE html>
<html>
<?php include('../utils/head.php');	print_head(array('title' => "Espace administrateur", 'start_dir' => "../")); ?>
<body>


<?php include('../utils/header.php'); print_header(array('start_dir' => "../")); ?>

<section id="presentation-first" class="first-section">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h1 class="margetop45 fw-bold titre-principal">Espace administrateur</h1>
				<form method="post" action="../index">
					<input type="submit" name="disconnect" class="btn btn-primary bouton margetop15" value="Déconnexion">
				</form>
				<div class="margebot25"></div>
			</div>
		</div>
	</div>
</section>

<section id="visits-counter">
	<div class="container text-center">
		<div class="row">
			<div class="col-sm-4"></div>
			<div class="col-sm-4 margetop15 admin-visites">
				<p>Nombre de visites du site : <span class="fw-bold"><?php echo $visits_count; ?></span></p>
			</div>
		</div>
	</div>
</section>

<section id="admin-menu">
	<div class="container admin-element-menu">
		<div class="row text-center">
			<div class="col-sm-3">
				<a href="general" class="admin-menu-item"><i class="fas fa-address-card fa-3x"></i><p class="admin-menu-item-text">Général</p></a>
			</div>
			<div class="col-sm-3">
				<a href="experiences?type=pro" class="admin-menu-item"><i class="fas fa-briefcase fa-3x"></i><p class="admin-menu-item-text">Expériences pro.</p></a>
			</div>
			<div class="col-sm-3">
				<a href="experiences?type=extra" class="admin-menu-item"><i class="fas fa-hands-helping fa-3x"></i><p class="admin-menu-item-text">Expériences extra</p></a>
			</div>
			<div class="col-sm-3">
				<a href="skills" class="admin-menu-item"><i class="fas fa-laptop fa-3x"></i><p class="admin-menu-item-text">Compétences</p></a>
			</div>
		</div>
		<div class="margebot45-big"></div>
		<div class="row text-center">
			<div class="col-sm-3">
				<a href="projects?type=perso" class="admin-menu-item"><i class="fas fa-tasks fa-3x"></i><p class="admin-menu-item-text">Projets persos</p></a>
			</div>
			<div class="col-sm-3">
				<a href="projects?type=sco" class="admin-menu-item"><i class="fas fa-graduation-cap fa-3x"></i><p class="admin-menu-item-text">Projets étudiants</p></a>
			</div>
			<div class="col-sm-3">
				<a href="contests" class="admin-menu-item"><i class="fas fa-trophy fa-3x"></i><p class="admin-menu-item-text">Compétitions</p></a>
			</div>
			<div class="col-sm-3">
				<a href="change_pwd" class="admin-menu-item"><i class="fas fa-key fa-3x"></i><p class="admin-menu-item-text">Changer le mot de passe</p></a>
			</div>
		</div>
	</div>
</section>

<?php include('../utils/footer.php'); print_footer(array('start_dir' => "../")); ?>
</body>
</html>


<script type="text/javascript" src="../js/no_js.js"></script>
