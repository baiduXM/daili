<?php
include '../ExpressPHP.Init.php';
require_once DocumentRoot . '/Modules/class.UsersModule.php';
require_once DocumentRoot . '/Modules/class.PicturesModule.php';
if (! function_exists('__ArrJsonMessage')) {
	function __ArrJsonMessage($Code, $Message, $Data = null){
		$tmp['Code'] = $Code;
		$tmp['Message'] = $Message;
		$tmp['Data'] = $Data;
		return $tmp;
	}
}
if (! function_exists('_mkdir')) {
	function _mkdir($path){
		if (! defined('DocumentRoot')) return false;
		$arrPath = explode('/', $path);
		foreach ( $arrPath as $dirname ) {
			if ($dirname && $dirname != '.' && $dirname != '..') {
				$newPath .= '/' . $dirname;
				if (! file_exists(DocumentRoot . $newPath) || ! is_dir(DocumentRoot . $newPath)) {
					if (! @mkdir(DocumentRoot . $newPath, 0777)) return false;
				}
			}
		}
		return $newPath;
	}
}
$Users = new UsersModule();
$UserID = $Users->Session('UserID');
$UploadSavePath = '/Data/Uploads';
$PicturesModule = new PicturesModule();
if ($system_config['timezone_set'] && function_exists('date_default_timezone_set')) date_default_timezone_set($system_config['timezone_set']);
$CurrentDate = date('Y-m-d', time());
if ($UserID) {
	if (! file_exists(DocumentRoot . $UploadSavePath . '/' . $CurrentDate)) {
		_mkdir($UploadSavePath . '/' . $CurrentDate);
	}
	$CurrentSavePath = $UploadSavePath . '/' . $CurrentDate;
	//upload file.
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
				$newfile = $CurrentSavePath . '/' . date("YmdHis") . ($usec * 1000000) . rand(9999, 99999) . '.' . strtolower($file_info['extension']);
				if (@copy($picture['tmp_name'], DocumentRoot . $newfile)) {
					$PicturesModule->Create($newfile, null, null, $UserID, 0);
					$TmpMessage = '图像文件已上传成功!';
				} else {
					$arrData = array (
						'Code' => 'error', 
						'Message' => '很抱歉,复制文件失败, 请尝试重新上传!' 
					);
					echo json_encode($arrData);
					exit();
				}
			} else {
				$arrData = array (
					'Code' => 'error', 
					'Message' => '很抱歉,只允许接受jpg/png/gif/jpeg格式文件上传!' 
				);
				echo json_encode($arrData);
				exit();
			}
		} else {
			$arrData = array (
				'Code' => 'error', 
				'Message' => '很抱歉, 文件上传失败, 请尝试重新上传!' 
			);
			echo json_encode($arrData);
			exit();
		}
	} // uploaded end.
	$PageSize = 20;
	$Page = _intval($_GET['Page'], true);
	$Page = max(1, $Page);
	$Data = $PicturesModule->Lists($UserID, $Page, $PageSize);
	$arrData = array (
		'Code' => 'success', 
		'Message' => $TmpMessage?$TmpMessage:'操作成功!', 
		'Data' => $Data 
	);
	echo json_encode($arrData);
} else {
	echo json_encode(__ArrJsonMessage('error', '很抱歉,您没有权限浏览该页面或进行该操作!'));
}
exit();
?>