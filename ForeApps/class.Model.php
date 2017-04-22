<?PHP

class Model extends ForeVIEWS {

    public function __Public() {
        IsLogin();
        //当前模块
        $this->MyModule = 'Model';
		if ($_SESSION['Level'] != 1) {
            exit();
        }
    }

    //模板上传页面
    public function Upload() {
        $this->MyAction = 'Upload';
    }

    //模板修改和套餐页面
    public function Operation() {
        $this->MyAction = 'Operation';
    }

    //创建套餐
    public function CrePack() {
        $this->MyAction = 'CrePack';
    }

    //下载模板
    public function LoadTpl() {
        $filename = $_GET["name"];
        if (file_exists("tpl/" . $filename . ".zip")) {
            header('Content-type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.$filename.'.zip"');
            readfile("tpl/" . $filename . ".zip");
        } else {
            //===未找到压缩包，则根据该模板名去数据库搜索旧模板名，再去判断压缩包是否存在===
            $ModelModule = new ModelModule();
            $Model_bak = $ModelModule->GetOneByWhere(array('NO_bak'),'where NO="' . $filename . '"');
            if(file_exists("tpl/" . $Model_bak . ".zip")){
                header('Content-type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.$Model_bak.'.zip"');
                readfile("tpl/" . $Model_bak . ".zip");   
            }else{
                $TuUrl=GBAOPEN_DOMAIN."api/downloadtemplate";
                $ToString = 'name=' . $filename."&token=".md5("linshimingma");
                $ReturnString = request_by_other($TuUrl, $ToString);
                $ReturnArray = json_decode($ReturnString, true);
                if($ReturnArray["err"]==0){
                    header('Content-type: application/octet-stream');
                    header('Content-Disposition: attachment; filename="'.$filename.'_统一平台下载.zip"');
                    echo file_get_contents($ReturnArray["msg"]);
                }else{
                    echo '<meta charset="UTF-8"><script language="javascript">alert("'.$ReturnArray["msg"].'");window.history.back(-1);</script> ';
                }
            }
            //===end=== 

            //原判断
            // $TuUrl=GBAOPEN_DOMAIN."api/downloadtemplate";
            // $ToString = 'name=' . $filename."&token=".md5("linshimingma");
            // $ReturnString = request_by_other($TuUrl, $ToString);
            // $ReturnArray = json_decode($ReturnString, true);
            // if($ReturnArray["err"]==0){
            //     header('Content-type: application/octet-stream');
            //     header('Content-Disposition: attachment; filename="'.$filename.'_统一平台下载.zip"');
            //     echo file_get_contents($ReturnArray["msg"]);
            // }else{
            //     echo '<meta charset="UTF-8"><script language="javascript">alert("'.$ReturnArray["msg"].'");window.history.back(-1);</script> ';
            // }
        }
        exit();
    }

}

?>