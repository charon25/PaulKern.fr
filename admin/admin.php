<?php 

	session_start();

 ?>

<?php 

	if (!isset($_SESSION['login']) || $_SESSION['login'] != 'true') {
		require('not_connected.php');
		exit();
	}

 ?>


<!DOCTYPE html>
<html>
<?php include('../utils/head.php');	print_head("Espace administrateur", "../"); ?>
<body>


<?php include('../utils/header.php'); print_header("../"); ?>

<section id="presentation-first" class="first-section">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h1 class="margetop45 fw-bold titre-principal">Espace administrateur</h1>
				<div class="margebot45"></div>
			</div>
		</div>
	</div>
</section>



<?php include('../utils/footer.php'); ?>
</body>
</html>


<script type="text/javascript" src="../js/no_js.js"></script>
<script type="text/javascript" src="../js/footer.js"></script>
