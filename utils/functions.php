<?php 

function set_data(&$array, $key, $value) {
	if ($value != '') 
		$array[$key] = $value;
}

function set_data_post(&$array, $key) {
	set_data($array, $key, $_POST[$key]);
}

function save_file($userfile, $rel_directory, $img_directory) {
	$extension = pathinfo($_FILES[$userfile]['name'], PATHINFO_EXTENSION);
	$image_name = bin2hex(random_bytes(10)) . "." . $extension;

	$image_path = $img_directory . $image_name;

	copy($_FILES[$userfile]['tmp_name'], $rel_directory . $image_path);

	return $image_path;
}


 ?>