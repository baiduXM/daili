<?php
//生成缩略图
function makethumb($srcfile, $thumb_width, $thumb_height){
	//判断文件是否存在
	if (! file_exists(DocumentRoot . $srcfile)) {return '';}
	$srcfile_pathinfo = pathinfo($srcfile);
	if ($srcfile_pathinfo['dirname'] == '/' || $srcfile_pathinfo['dirname'] == "\\")
		$dstfile = '/' . $srcfile_pathinfo['filename'] . '.thumb.';
	else
		$dstfile = $srcfile_pathinfo['dirname'] . '/' . $srcfile_pathinfo['filename'] . '.thumb.';
		//缩略图大小
	$tow = $thumb_width;
	$toh = $thumb_height;
	//获取图片信息
	$im = '';
	if ($data = getimagesize(DocumentRoot . $srcfile)) {
		if ($data[2] == 1) {
			if (function_exists("imagecreatefromgif")) {
				$im = imagecreatefromgif(DocumentRoot . $srcfile);
			}
		} elseif ($data[2] == 2) {
			if (function_exists("imagecreatefromjpeg")) {
				$im = imagecreatefromjpeg(DocumentRoot . $srcfile);
			}
		} elseif ($data[2] == 3) {
			if (function_exists("imagecreatefrompng")) {
				$im = imagecreatefrompng(DocumentRoot . $srcfile);
			}
		}
	}
	if (! $im) {return '';}
	$srcw = imagesx($im);
	$srch = imagesy($im);
	//得到缩图大小比例 : 宽/高
	$towh = $tow / $toh;
	//缩放比例 
	// 90/450 = 0.2
	$miniature_width_scale = $srcw/$tow;
	// 90/360 = 0.25
	$miniature_height_scale = $srch/$toh;
	
	$thumb_scale = $tow/$toh;
	$src_scale = $srcw/$srch;
	if($src_scale == $thumb_scale){
		$src_x = 0;
		$src_y = 0;
		$src_width = $srcw;
		$src_height = $srch;
	}
	else {
		//0.225
		if($miniature_width_scale>$miniature_height_scale){
			//echo '1,';
			$src_width = intval($tow * $miniature_height_scale);
			$src_height = intval($toh * $miniature_height_scale);
			$src_x = intval(($srcw - $src_width)/2);
			$src_y = intval(($srch - $src_height)/2);
		}
		else {
			//echo '2,';
			$src_width = intval($tow * $miniature_width_scale);
			$src_height = intval($toh * $miniature_width_scale);
			$src_x = intval(($srcw - $src_width)/2);
			$src_y = intval(($srch - $src_height)/2);
		}
	}
	//echo "$src_x,$src_y,$src_width,$src_height";
	//exit;
	if ($src_x + $src_width > $srcw) {
		$src_width = $srcw - $src_x;
	}
	if ($src_y + $src_height > $srch) {
		$src_height = $srch - $src_y;
	}
	if ($srcw > $tow || $srch > $toh) {
		if (! @$ni = imagecreatetruecolor($tow, $toh))
			return '';
		if (! imagecopyresampled($ni, $im, 0, 0, $src_x, $src_y, $tow, $toh, $src_width, $src_height))
			return '';
		if (function_exists('imagejpeg')) {
			$dst = $dstfile . 'jpg';
			imagejpeg($ni, DocumentRoot . $dst);
		} elseif (function_exists('imagepng')) {
			$dst = $dstfile . 'png';
			imagepng($ni, DocumentRoot . $dst);
		}
		imagedestroy($ni);
	}
	imagedestroy($im);
	if (! file_exists(DocumentRoot . $dst)) {
		return '';
	} else {
		return $dst;
	}
}
?>