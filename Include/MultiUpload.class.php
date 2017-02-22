<?php
/*使用说明
 * include ('./Include/MultiUpload.class.php');
if ($_FILES ['FileField'] ['size'] [0] > 0) {
	$upload = new MultiUpload ( 'userfile' );
	$upload->savePath = './Data/Uploads/' . date ( "Y-m-d" ) . '/';
	$file = $upload->upload ();
	$ArticleInfo ['pic'] = $file [0] ? substr ( $upload->savePath, 1 ) . $file [0] : '';
}*/

class MultiUpload {
	public $maxSize = 524288; //Byte 512KB
	public $allowExts = array ('.jpg', '.jpeg', '.gif', '.png', '.bmp', '.rar', '.zip', '.pdf', '.swf' );
	public $error = array ();
	private $count = 0;
	public $savePath = "../uploads/";
	public $field = 'userfile';
	public $uploadReplace = 0;
	public $thumbFile = '';
	public $thumbMaxWidth = 100;
	public $thumbMaxHeight = 100;
	public $thumbPrefix = 's_';
	public $thumbSuffix = '';
	public $imageClassPath = '@.ORG.Image';
	public $thumbRemoveOrigin = 0;
	public $autoSub = 0;
	
	public $thumb = 0;
	public $savedName = array ();
	public $sourceFileName = 1;
	function __construct($fieldName) {
		if (! empty ( $fieldName )) {
			$this->field = $fieldName;
		}
		foreach ( $_FILES [$this->field] ['size'] as $filename ) {
			$this->count ++;
		}
	
		//    print_r($_FILES[$this->field]);
	//    echo $this->count;
	//    die();
	}
	public function upload() {
		$this->checkSavePath ();
		for($i = 0; $i < $this->count; $i ++) {
			$filename = $_FILES [$this->field] ["name"] [$i];
			$tmp_name = $_FILES [$this->field] ['tmp_name'] [$i];
			$file ['ext'] = $this->getExt ( $filename );
			$file ['size'] = $_FILES [$this->field] ['size'] [$i];
			$file ['tmp_name'] = $tmp_name;
			
			if ($this->check ( $file, $i )) {
				$saveName = $this->getSaveName ( $filename );
				$savedPath = $this->savePath . $saveName;
				if (! $this->uploadReplace && file_exists ( $savedPath )) {
					$this->error [] = 'File already exists!';
					return false;
				}
				if (empty ( $this->error [$i] )) {
					if (move_uploaded_file ( $tmp_name, $savedPath )) {
						$this->savedName [] = $saveName;
						$this->thumb ( $savedPath, $saveName );
					} else {
						$this->error [] = 'Can not move file into directory,Check if it is writeable!';
					}
				}
			} else {
				$this->savedName [] = '';
			
		//			return false;
			}
		}
		return $this->savedName;
	}
	private function thumb($filename, $saveName) {
		if ($this->thumb) {
			$image = getimagesize ( $filename );
			//var_dump($image);
			if (false !== $image) {
				//是图像文件生成缩略图
				$thumbWidth = explode ( ',', $this->thumbMaxWidth );
				$thumbHeight = explode ( ',', $this->thumbMaxHeight );
				$thumbPrefix = explode ( ',', $this->thumbPrefix );
				$thumbSuffix = explode ( ',', $this->thumbSuffix );
				$thumbFile = explode ( ',', $this->thumbFile );
				$thumbPath = $this->thumbPath ? $this->thumbPath : $this->savePath;
				// 生成图像缩略图
				include ($this->imageClassPath);
				$realFilename = $this->autoSub ? basename ( $saveName ) : $saveName;
				for($i = 0, $len = count ( $thumbWidth ); $i < $len; $i ++) {
					$thumbname = $thumbPath . $thumbPrefix [$i] . substr ( $realFilename, 0, strrpos ( $realFilename, '.' ) ) . $thumbSuffix [$i] . $this->getExt ( $saveName );
					Image::thumb ( $filename, $thumbname, '', $thumbWidth [$i], $thumbHeight [$i], true );
				}
				if ($this->thumbRemoveOrigin) {
					// 生成缩略图之后删除原图
					unlink ( $filename );
				}
			}
		}
		return true;
	}
	public function getUploadFileInfo() {
		return $this->savedName;
	}
	private function getSaveName($filename) {
		$preStr = '';
		if ($this->sourceFileName) {
			$array = array ();
			$array = explode ( '.', $filename );
			$preStr = $array [0];
		}
		//生成一个唯一的字符串。
		return $preStr . '_' . substr ( md5 ( $_SERVER ['HTTP_USER_AGENT'] . $_SERVER ['REMOTE_ADDR'] . uniqid () . mt_rand () ), 0, 24 ) . '.' . strtolower ( $array [1] );
	}
	private function check($file, $file_number) {
		//文件上传成功，进行自定义规则检查
		//检查文件大小
		if (! $this->checkSize ( $file ['size'] )) {
			$this->error [$file_number] = '上传文件大小不符！';
			return false;
		}
		//检查文件类型
		if (! $this->checkExt ( $file ['ext'] )) {
			$this->error [$file_number] = '上传文件类型不允许';
			return false;
		}
		
		//检查是否合法上传
		if (! $this->checkUpload ( $file ['tmp_name'] )) {
			$this->error [$file_number] = '非法上传文件！';
			return false;
		}
		$this->error [$file_number] = '';
		return true;
	}
	
	private function checkSize($size) {
		return $size < $this->maxSize ? true : false;
	}
	private function checkExt($ext) {
		if (! empty ( $this->allowExts ))
			return in_array ( strtolower ( $ext ), $this->allowExts, true );
		return true;
	}
	private function checkUpload($file_tmp_name) {
		return is_uploaded_file ( $file_tmp_name );
	}
	private function getExt($file_name) {
		$extend = explode ( ".", $file_name );
		$va = count ( $extend ) - 1;
		return '.' . strtolower ( $extend [$va] );
	}
	private function checkSavePath() {
		if (! is_dir ( $this->savePath )) {
			self::mkDir ( $this->savePath );
			return;
		}
	}
	private static function mkDir($dir) {
		mkdir ( $dir );
		chmod ( $dir, 0777 );
	}
	public function getErrorMsg() {
		return $this->error;
	}
}