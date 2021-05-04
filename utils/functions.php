<?php 

function set_data(&$array, $key, $value) {
	if ($value != '') 
		$array[$key] = $value;
}

function set_data_post(&$array, $key) {
	set_data($array, $key, $_POST[$key]);
}

function save_file($userfile, $rel_directory, $img_directory, $filename) {
	$extension = pathinfo($_FILES[$userfile]['name'], PATHINFO_EXTENSION);
	$image_name = $filename . "." . $extension;

	$image_path = $img_directory . $image_name;

	copy($_FILES[$userfile]['tmp_name'], $rel_directory . $image_path);

	return $image_path;
}

function save_file_random_name($userfile, $rel_directory, $img_directory) {
	return save_file($userfile, $rel_directory, $img_directory, bin2hex(random_bytes(10)));
}

function save_multiple_files_random_name($userfile, $rel_directory, $img_directory) {
	$image_count = count($_FILES[$userfile]['size']);
	$output_paths = array();

	for ($i = 0 ; $i < $image_count ; $i++) {
		$extension = pathinfo($_FILES[$userfile]['name'][$i], PATHINFO_EXTENSION);
		$image_name = bin2hex(random_bytes(10)) . "." . $extension;
		$image_path = $img_directory . $image_name;
		copy($_FILES[$userfile]['tmp_name'][$i], $rel_directory . $image_path);
		$output_paths[] = $image_path;
	}

	return $output_paths;
}

function get_db_data_from_key($bdd, $key, $max_count) {
	$request = $bdd->prepare('SELECT * FROM `pk_data` WHERE `type`=? ORDER BY `sorter` DESC');
	$request->execute(array($key));

	$output = [];
	$index = 0;
	while ($row = $request->fetch()) {
		$output[] = json_decode($row['data'], TRUE);
		$index++;
		if ($index == $max_count) break;
	}

	return $output;
}


 ?>
