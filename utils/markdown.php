<?php 

function markdown_to_html($string) {
	$string = preg_replace('/\*([^*]*)\*/s', '<span class="md-bold">\1</span>', $string);
	$string = preg_replace('/_([^.]*)_/s', '<span class="md-italics">\1</span>', $string);
	$string = preg_replace('/\$([^$]*)\$/s', '<span class="md-highlight">\1</span>', $string);
	$string = preg_replace('/\[(.+)\]\((.+)\)/s', '<a href="\1">\2</a>', $string);
	$string = preg_replace('/\+\+ (.+)/', '<p class="justif">\1</p>', $string);
	$string = preg_replace('/\/\//', '<br>', $string);
	$string = preg_replace('/\n/', '<br>', $string);
	$string = preg_replace('/<R>(.*)<\/R>/', '<div class="row">\1</div>', $string);
	$string = preg_replace('/<C-(\d)>(.*)<\/C>/', '<div class="col-sm-\1">\2</div>', $string);

	return $string;
}






 ?>
