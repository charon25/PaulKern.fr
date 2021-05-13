<?php 
	function print_footer($args = array()) { 
		if (!isset($args['start_dir']))
			$args['start_dir'] = '';
?>

<footer id="footer">
	<p><a href="LICENSE">License MIT</a> : Copyright (c) 2021 Paul Kern (<a href="mailto:paul.kern.fr@gmail.com">paul.kern.fr@gmail.com</a>) — <a href="<?php echo $args['start_dir'] ?>admin/connection">Espace administrateur</a> - Hébergé par OVH</p>
</footer>
<?php } ?>
