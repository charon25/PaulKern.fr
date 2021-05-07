<?php 

function markdown_to_html($string) {
	// Bold
	$string = preg_replace('/\*([^*]*)\*/s', '<span class="md-bold">\1</span>', $string);
	// Italics
	$string = preg_replace('/_([^.]*)_/s', '<span class="md-italics">\1</span>', $string);
	// Highlighted
	$string = preg_replace('/\$([^$]*)\$/s', '<span class="md-highlight">\1</span>', $string);
	// Hyperlink
	$string = preg_replace('/\[(.+)\]\((.+)\)/s', '<a href="\1">\2</a>', $string);
	// Paragraphs
	$string = preg_replace('/\+\+J (.+)/', '<p class="justif">\1</p>', $string);
	$string = preg_replace('/\+\+G (.+)/', '<p class="txt-gauche">\1</p>', $string);
	$string = preg_replace('/\+\+D (.+)/', '<p class="txt-droite">\1</p>', $string);
	$string = preg_replace('/\+\+ (.+)/', '<p>\1</p>', $string);
	// Line break
	$string = preg_replace('/\/\//', '<br>', $string);
	$string = preg_replace('/(\r?\n){2}/', '<br>', $string);
	// Rows and columns
	$string = preg_replace('/<R>/s', '<div class="row">', $string);
	$string = preg_replace('/<\/R>/s', '</div>', $string);
	$string = preg_replace('/<C-(\d)>/', '<div class="col-sm-\1">', $string);
	$string = preg_replace('/<\/C>/s', '</div>', $string);
	// Exposant
	$string = preg_replace('/\^(\w+)/', '<sup>\1</sup>', $string);

	return $string;
}

 ?>
