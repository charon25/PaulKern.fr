<?php 

	session_start();

 ?>

<?php 

	$connected = FALSE;
	$bad_password = FALSE;
	if (isset($_POST['connect'])) {
		$hashed_password = file_get_contents('password.config'); # "motdepasse"
		if (hash('sha256', $_POST['password']) == $hashed_password) {
			$_SESSION['login'] = 'true';
			$connected = TRUE;
		} else {
			$bad_password = TRUE;
			$_SESSION['login'] = 'false';
		}
	}

	if (isset($_SESSION['login']) and $_SESSION['login'] == 'true') {
		$connected = TRUE;
	}

 ?>


<!DOCTYPE html>
<html>
<?php 
	if ($connected) {
		echo '<meta http-equiv = "refresh" content = "2; url = admin.php" />';
	}
	include('../utils/head.php');
	print_head("Connexion à l'espace administrateur", "../");
?>
<body>


<?php include('../utils/header.php'); ?>

<section id="presentation-first" class="first-section">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h1 class="margetop45 fw-bold titre-principal">Connexion à l'espace administrateur</h1>
				<div class="margebot45"></div>
			</div>
		</div>
	</div>
</section>

<section id="connection">
	<div class="container">
		<div class="row text-center">
			<div class="margetop45"></div>
			<div class="col-sm-3"></div>
			<div class="col-sm-6">
				<form method="post" action="#" class="form-connexion">
					<p class="fw-bold">Mot de passe : <input type="password" name="password"></p>
					<?php 
						if ($bad_password) {
							echo '<p class="fw-bold" style="color: #f00;">Mauvais mot de passe.</p>';
						} elseif ($connected) {
							echo '<p class="fw-bold" style="color: #0ea800;">Connexion réussie, redirection en cours...<br>Si la redirection ne fonctionne pas, cliquez <a href="admin">ici</a>.</p>';
						}
					 ?>
					<div class="margetop25"></div>
					<input type="submit" class="btn btn-primary bouton" name="connect" value="Connexion">
				</form>
			</div>
		</div>
	</div>
</section>

<?php include('../utils/footer.php'); ?>
</body>
</html>


<script type="text/javascript">
	// Remove every element with class "no-js"
	Array.from(document.getElementsByClassName("no-js")).forEach(element => element.remove());
	// Fix footer at bottom of page
	var footer = document.getElementById("footer");
	if (screen.width >= 764) {
		footer.style.position = "fixed";
		footer.style.bottom = 0;
		footer.style.left = 0;
		footer.style.right = 0;
	} else {
		footer.remove();
	}
</script>