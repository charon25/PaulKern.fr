<?php 

function md_to_html($string) {
	$string = preg_replace('/\*(.*)\*/s', '<span class="md-bold">\1</span>', $string);
	$string = preg_replace('/_(.*)_/s', '<span class="md-italics">\1</span>', $string);
	$string = preg_replace('/\$(.*)\$/s', '<span class="md-highlight">\1</span>', $string);

	return $string;
}






 ?>
