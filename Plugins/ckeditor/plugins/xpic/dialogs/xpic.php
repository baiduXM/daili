<?php
include '../../../../../ExpressPHP.Init.php';
require_once DocumentRoot . '/Modules/class.UsersModule.php';
require_once DocumentRoot . '/Modules/class.PicturesModule.php';

function _x_mkdir($path){
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

$Users = new UsersModule();
$UserID = $Users->Session('UserID');
$UploadSavePath = '/Data/Uploads';
$PicturesModule = new PicturesModule();
if ($system_config['timezone_set'] && function_exists('date_default_timezone_set')) date_default_timezone_set($system_config['timezone_set']);
$CurrentDate = date('Y-m-d', time());
if ($UserID) {
	if (! file_exists(DocumentRoot . $UploadSavePath . '/' . $CurrentDate)) {
		if (! _x_mkdir($UploadSavePath . '/' . $CurrentDate)) {
			$ResultMessage = '创建储存目录失败!';
		}
	}
	if (! $ResultMessage) {
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
					$newfile = $CurrentSavePath . '/' . $UserID . date("YmdHis") . ($usec * 1000000) . rand(9999, 99999) . '.' . strtolower($file_info['extension']);
					if (@copy($picture['tmp_name'], DocumentRoot . $newfile)) {
						$PicturesModule->Create($newfile, null, null, $UserID, 0);
						$ResultMessage = '图像文件已上传成功!';
					} else {
						$ResultMessage = '很抱歉,复制文件失败, 请尝试重新上传!';
					}
				} else {
					$ResultMessage = '很抱歉,只允许接受jpg/png/gif/jpeg格式文件上传!';
				
				}
			} else {
				$ResultMessage = '很抱歉, 文件上传失败, 请尝试重新上传!';
			}
		} // uploaded end.
		$PageSize = 20;
		$Page = _intval($_GET['Page'], true);
		$Page = max(1, $Page);
		$Data = $PicturesModule->Lists($UserID, $Page, $PageSize);
	}
} else {
	$ExitMessage = '很抱歉,您没有权限浏览该页面或进行该操作!';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>图像管理器</title>
<script type="text/javascript" src="/Javascripts/jquery.min.js"></script>
<script type="text/javascript">
var CurrentPath = '';
var SelectedPictureID='';
var CKEDITOR = window.parent.CKEDITOR;
var okListener = function(ev) {
	if(CurrentPath!=''){
   		this._.editor.insertHtml('<img src="'+CurrentPath+'">');
	}
   CKEDITOR.dialog.getCurrent().removeListener("ok", okListener);
};
CKEDITOR.dialog.getCurrent().on("ok", okListener);
function PictureSelected(pictureid){
	var obj = $('#pictures-'+pictureid);
	if(obj){
		if(obj.attr('class')=='picture-item'){
			obj.attr('class','picture-item-selected');
			CurrentPath = $('#picture-item-'+pictureid).attr('src');
			if(SelectedPictureID!='') $('#pictures-'+SelectedPictureID).attr('class','picture-item');
			SelectedPictureID = pictureid;
		}
		else {
			obj.attr('class','picture-item');
			CurrentPath = '';
		}
	}
}
</script>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
*{
	font-size:12px;
}
.picture-item {
	padding: 5px;
	float: left;
	background-color: #FFF;
	border: 1px solid #999;
	margin: 10px;
}
.picture-item-selected {
	padding: 5px;
	float: left;
	background-color: #FFE8FF;
	border: 1px solid #FC9;
	margin: 10px;
}
-->
</style></head>
<body>
<?php if($ExitMessage){ ?>
<?php echo $ExitMessage;?>
<?php } else {?>
<div>
<div>上传新的图像文件</div>
<div>
  <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
    <input type="file" name="picture" id="picture" />
    <input type="submit" name="button" id="button" value="上传" />
  </form>
</div>
</div>
<div>
<div><div style="float:left;">已上传图像列表</div><div style="font-size:12px; float:right;"><a href="?Page=<?php echo $Page-1;?>">上一页</a> <a href="?Page=<?php echo $Page+1;?>">下一页</a></div>
</div>
<div style="clear:both;">
<?php if($Data) {
foreach ($Data as $list){
	?>
<div class="picture-item" ID="pictures-<?php echo $list[PictureID];?>">
<div><img src="<?php echo $list['Path'];?>" width="120" height="90" border="0" id="picture-item-<?php echo $list[PictureID];?>" onclick="PictureSelected('<?php echo $list[PictureID];?>');"></div>
<?php if($list['Title']){?>
<div><?php echo $list['Title'];?></div>
<?php }?>
</div>
<?php }}?>
</div>
</div>
<?php }?>
</body>
</html>
