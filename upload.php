<?php
//leslie
define('DocumentRoot', dirname(__FILE__));
if ($_FILES) {
	$picture = $_FILES['picture'];
	if (! $picture['error'] && $picture['name']) {
		$filename = $picture['name'];
		$file_info = pathinfo($filename);
		if (in_array(strtolower($file_info['extension']), array (
			'jpg', 
			'png', 
			'gif', 
			'jpeg' 
		))) {
			list ( $usec, $sec ) = explode(" ", microtime());
			$savepath = '/Data/Uploads';
			$newfile = $savepath . '/' . date("YmdHis") . ($usec * 1000000) . rand(9999, 99999) . '.' . strtolower($file_info['extension']);
			if (@move_uploaded_file($picture['tmp_name'], DocumentRoot . $newfile)) {
				$arrData = array (
					'code' => 'success', 
					'message' => 'upload success!', 
					'savepath' => $newfile 
				);
			} else {
				$arrData = array (
					'code' => 'error', 
					'message' => 'upload error!', 
					'savepath' => '' 
				);
			}
		} else {
			$arrData = array (
				'code' => 'error', 
				'message' => 'upload error!', 
				'savepath' => '' 
			);
		}
	} else {
		$arrData = array (
			'code' => 'error', 
			'message' => 'upload error!', 
			'savepath' => '' 
		);
	}
} else {
	$arrData = array (
		'code' => 'error', 
		'message' => 'upload error!', 
		'savepath' => '' 
	);
}

echo json_encode($arrData);
?>