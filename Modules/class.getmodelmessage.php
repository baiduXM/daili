<?php
//读取模板中的screenshot.jpg图片

	class getmodelmessage{
		private $dh;								//文件路径
		private $url;								//保存文件的路径
		public  function __construct($path='./',$url='./img_url'){
			if (!is_dir($path)){
				echo '目录不存在';
				exit();
			}else {
				$this->dh = $path;
			}
				$this->url=$url;
		}
		
		private function setfile(){
			if (!is_dir($this->url)) {
				$k=@mkdir($this->url, 0777, true);
				if (!$k){
					echo '文件创建失败';
				}
			}
		}
		
		public function getmessage(){
			$list=array();
			$i=0;
			$this->setfile();
			$k = opendir($this->dh);
			if (!$k){
				echo '目标文件打开失败';
			}
			while (( $file  =  readdir($k)) !==  false ){
				$imgname='';
				$config_arr='';
				if($file=='.' or $file=='..')
				{continue;}
				if (!is_dir($this->dh.'/'.$file) ){
					continue;
				}
				if (!file_exists($this->dh.'/'.$file.'/config.ini')){
					continue;
				}
				else{
					$config_arr=parse_ini_file($this->dh.'/'.$file.'/config.ini',true);
					if (file_exists($this->dh.'/'.$file.'/screenshot.jpg')) {
						$imgname=$file.'_screenshot.jpg';
						copy($this->dh.'/'.$file.'/screenshot.jpg',$this->url.'/'.$imgname);
					}
				}
				$list[$i]['name']=$file;
				$list[$i]['config']=$config_arr;
				$list[$i]['img_url']=$imgname;
				$i++;
			}
			return $list;
		}
	}
	
?>