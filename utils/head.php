<?php 
	function print_head($args = array()) { 
		if (!isset($args['start_dir']))
			$args['start_dir'] = '';
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

	<link rel="icon" href="img/icon.ico">
	<meta content='maximum-scale=1.0, initial-scale=1.0, width=device-width' name='viewport'>

	<!-- Icônes -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
		integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

</head>

<?php } ?>