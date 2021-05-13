<?php 
	function print_head($args = array()) { 
		if (!isset($args['start_dir']))
			$args['start_dir'] = '';
		if (!isset($args['indexing']))
			$args['indexing'] = FALSE;
		if (!isset($args['meta_description'])) {
			require('bdd.php');
			require_once('functions.php');
			require('constants.php');
			$args['meta_description'] = get_db_data_from_key($bdd, 'general', 1)[0][$GEN_META];
		}
?>

<head>
	<title>Paul Kern | <?php echo $args['title']; ?></title>

	<!-- Bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

	<!-- Polices -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,400i" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Mono:400,400i" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Lora:400,400i" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="<?php echo $args['start_dir']; ?>css/style.css">

	<link rel="icon" href="<?php echo $args['start_dir']; ?>img/icon.ico">
	<meta content='maximum-scale=1.0, initial-scale=1.0, width=device-width' name='viewport'>

	<!-- Icônes -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

	<!-- Balises meta -->
	<?php
		if (!$args['indexing'])
			echo '<meta name="robots" content="noindex">';
	 ?>

	<meta content="Paul Kern - Etudiant en Génie Electrique à l'INSA Strasbourg" property="og:title">
	<meta content="<?php echo $args['meta_description']; ?>" property="og:description">
	<meta content="https://paulkern.fr" property="og:url">
	<meta content="img/general/photo.jpg" property="og:image">
	<meta content="#49cde9b" data-react-helmet="true" name="theme-color">

</head>

<?php } ?>