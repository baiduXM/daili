<?php
class Model extends InterfaceVIEWS {

    public function __Public() {
        IsLogin();
    }

    public function ModelInit() {
        $result = array('err' => 0, 'data' => '', 'msg' => '');
        //获取所有模板分类样式
        $modelclass = new ModelClassModule;
        $typeclass = $modelclass->GetListsByWhere(array('ID', 'CName'));
        foreach ($typeclass as $v) {
            $data['tag'][$v['ID']] = $v['CName'];
        }
        $result['data'] = $data;
        return $result;
    }

    public function GetModelNum() {
        $level = $_SESSION ['Level'];
        $result = array('err' => 0, 'data' => '', 'msg' => '');
        if ($level == 1) {
            $type = $this->_GET['type'];
            $result['data'] = $this->GetModelNumByType($type);
        } else {
            $result['err'] = 1000;
            $result['msg'] = '非法请求';
        }
        return $result;
    }

    public function PkCreate() {
        $level = $_SESSION ['Level'];
        $result = array('err' => 0, 'data' => '', 'msg' => '');
        if ($level == 1) {
            $post = $this->_POST['modelInfo'];
            $ModelModule = new ModelModule();
            $PackModule = new ModelPackageModule();
            $Data['PackagesName'] = trim($post['name']);
            $Data['PackagesNum'] = trim($post['id']);
            $Data['PCNum'] = trim($post['pc']);
            $Data['PCUrl'] = trim($post['pc_url']);
            $Data['PhoneNum'] = trim($post['mobile']);
            $Data['PhoneUrl'] = trim($post['mobile_url']);
            $Data['Price'] = trim($post['price']);
            $Data['Youhui'] = trim($post['youhui']);
            $PCModel = $ModelModule->GetOneByWhere('where NO="' . $Data['PCNum'] . '"');
            $PhoneModel = $ModelModule->GetOneByWhere('where NO="' . $Data['PhoneNum'] . '"');
            if(!$PCModel || !$PhoneModel){
                $result['err'] = 1000;
                $result['msg'] = $PCMsg ? '手机模板不存在' : 'PC模板不存在';
                return $result;
            }
            if($PackModule->GetOneByWhere('where PackagesNum="' . $Data['PackagesNum'] . '"')){
                $result['err'] = 1000;
                $result['msg'] = '当前套餐模板已存在，请输入其他模板名';
                return $result;
            }
            $Data['PCUrl'] = $Data['PCUrl'] ? $Data['PCUrl'] : 'http://m.' . $Data['PackagesNum'] . '.n01.5067.org';
            $Data['PhoneUrl'] = $Data['PhoneUrl'] ? $Data['PhoneUrl'] : 'http://m.' . $Data['PackagesNum'] . '.n01.5067.org';
            $Data['TuiJian'] = $post['tuijian'];
            $Data['ModelLan'] = $post['lang'];
            if (!empty($Data['PackagesNum'])) {
                if (!preg_match('/GT\d{4}/', $Data['PackagesNum']) or preg_match('/GT\d{5}/', $Data['PackagesNum'])) {
                    $result['err'] = 1001;
                    $result['msg'] = '错误的双站模板名';
                    return $result;
                }
            }else{
                $result['err'] = 1001;
                $result['msg'] = '请填写双站模板名';
                return $result;
            }
            if ((!preg_match('/GM\d{4}/', $Data['PCNum']) and !preg_match('/GP\d{4}/', $Data['PCNum'])) or preg_match('/GM\d{5}/', $Data['PCNum']) or preg_match('/GP\d{5}/', $Data['PCNum'])) {
                $result['err'] = 1001;
                $result['msg'] = '错误的PC模板名';
                return $result;
            }
            if ((!preg_match('/GM\d{4}/', $Data['PhoneNum']) and !preg_match('/GP\d{4}/', $Data['PhoneNum'])) or preg_match('/GM\d{5}/', $Data['PhoneNum']) or preg_match('/GP\d{5}/', $Data['PhoneNum'])) {
                $result['err'] = 1001;
                $result['msg'] = '错误的手机模板名';
                return $result;
            }
            preg_match('/[A-Z]{2}[0]*(\d*)/', $Data['PackagesNum'], $have);
            $Data['Num'] = $have[1];
            $Data['Color'] = $PCModel['Color'] . ',' . $PhoneModel['Color'];
            $Data['Keyword'] = $PCModel['Keyword'];
            $Data['ZhuSeDiao'] = $PCModel['Color'];
            $Data['DesignerScore'] = ceil(($PCModel['DesignerScore'] + $PhoneModel['DesignerScore']) / 2);
            $Data['DeveloperScore'] = ceil(($PCModel['DeveloperScore'] + $PhoneModel['DeveloperScore']) / 2);
            $Data['TesterScore'] = ceil(($PCModel['TesterScore'] + $PhoneModel['TesterScore']) / 2);
            $Data['Language'] = 'PHP';
            $Data['ModelClassID'] = trim($PCModel['ModelClassID'], ',') . ',' . trim($PhoneModel['ModelClassID'], ',');
            $Data['AddTime'] = date("Y-m-d H:i:s", time());
            if ($PackModule->InsertArray($Data, true)) {
                $this->updateModel(array("PackagesNum"=>$Data['PackagesNum']), "model_packages");
                $result['err'] = 0;
                $result['msg'] = '添加双站模板成功';
            } else {
                $result['err'] = 1002;
                $result['msg'] = '添加双站模板失败,请再一次尝试!，(~>__<~) ';
            }
        } else {
            $result['err'] = 1000;
            $result['msg'] = '非法请求';
        }
        return $result;
    }

    public function Process() {
        $level = $_SESSION ['Level'];
        $modelID = $this->_POST['num'];
        if ($level == 1 && $modelID) {
            if ($this->_POST['type'] == 3) {
                $Model = new ModelPackageModule();
                $Data['PCUrl'] = $this->_POST['pc_url'];
                $Data['PhoneUrl'] = $this->_POST['mobile_url'];
            } else {
                $Model = new ModelModule();
                $Data['Url'] = $this->_POST['url'];
            }
            $Data['Price'] = $this->_POST['mPrice'];
            $Data['Youhui'] = $this->_POST['yPrice'];
            $Data['ModelClassID'] = ',' . trim($this->_POST['typetage']) . ',';
            $Data['Color'] = $this->_POST['colortag'];
            $Model->UpdateArrayByKeyID($Data, $modelID);
            $this->updateModel(array("ID"=>$modelID), $this->_POST['type'] == 3?"model_package":"model");
            $result['err'] = 0;
            $result['msg'] = '模板信息修改成功';
        } else {
            $result['err'] = 1000;
            $result['msg'] = '非法请求';
        }
        return $result;
    }

    public function Operation() {
        $level = $_SESSION ['Level'];
        $modelID = $this->_GET['num'];
        $cmd = $this->_GET['cmd'];
        $type = $this->_GET['type'];
        if ($level == 1 && $modelID) {
            switch ($cmd) {
                case 'process':
                    if ($type == 3) {
                        $Model = new ModelPackageModule();
                        $modelMsg = $Model->GetOneByWhere(array('PackagesNum', 'Price', 'Youhui', 'PCUrl', 'PhoneUrl', 'Color', 'ModelClassID'), 'where ID=' . $modelID);
                        if ($modelMsg) {
                            $data['name'] = $modelMsg['PackagesNum'];
                            $data['price'] = $modelMsg['Price'];
                            $data['youhui'] = $modelMsg['Youhui'];
                            $data['pc_url'] = $modelMsg['PCUrl'];
                            $data['mobile_url'] = $modelMsg['PhoneUrl'];
                            $data['color'] = $modelMsg['Color'];
                            $data['tag'] = $modelMsg['ModelClassID'];
                        } else {
                            $data = false;
                        }
                    } else {
                        $Model = new ModelModule();
                        $modelMsg = $Model->GetOneByWhere(array('NO', 'Price', 'Youhui', 'Url', 'BaiDuXingPing', 'Color', 'ModelClassID'), 'where ID=' . $modelID);
                        if ($modelMsg) {
                            $data['name'] = $modelMsg['NO'];
                            $data['price'] = $modelMsg['Price'];
                            $data['youhui'] = $modelMsg['Youhui'];
                            $data['star'] = $modelMsg['BaiDuXingPing'];
                            $data['color'] = $modelMsg['Color'];
                            $data['tag'] = $modelMsg['ModelClassID'];
                            $data['url'] = $modelMsg['Url'];
                        } else {
                            $data = false;
                        }
                    }
                    break;
                default :
                    $data = false;
                    break;
            }
            $result['err'] = 0;
            $result['data'] = $data;
            $result['msg'] = '';
        } else {
            $result['err'] = 1000;
            $result['msg'] = '非法请求';
        }
        return $result;
    }

    //模板状态改变
    public function StatusChange() {
        $level = $_SESSION ['Level'];
        $modelID = $this->_POST['num'];
        if ($level == 1 && $modelID) {
            $type = $this->_POST['type'];
            $Data['TuiJian'] = $this->_POST['tuijian'] ? $this->_POST['tuijian'] : 0;
            if ($type == 3) {
                $Model = new ModelPackageModule();
                $Model->UpdateArrayByKeyID($Data, $modelID);
            } else {
                $Model = new ModelModule();
                $Model->UpdateArrayByKeyID($Data, $modelID);
            }
            $this->updateModel(array("ID"=>$modelID), $this->_POST['type'] == 3?"model_package":"model");
            $result['err'] = 0;
            $result['msg'] = '状态修改成功';
        } else {
            $result['err'] = 1000;
            $result['msg'] = '非法请求';
        }
        return $result;
    }

    //模板列表
    public function GetModelList() {
        $level = $_SESSION ['Level'];
        if ($level == 1) {
            $type = $this->_GET['type'];
            $result = array('err' => 0, 'data' => '', 'msg' => '');
            $data['list'] = $this->GetModelByType($type, floor($this->_GET['page']), floor($this->_GET['num']));
            $result['data'] = $data;
        } else {
            $result['err'] = 1000;
            $result['msg'] = '非法请求';
        }
        return $result;
    }

    protected function GetModelByType($type, $page = 1, $num = 5) {
        $search = '';
        $search_model = $search_package = array();
        if ($this->_GET['name'] != '' || $this->_GET['url'] != '' || $this->_GET['priceL'] != '' || $this->_GET['priceT'] != '') {
            $this->_GET['name'] ? $search_model[] = 'NO LIKE \'%' . $this->_GET['name'] . '%\'' : '';
            $this->_GET['name'] ? $search_package[] = 'PackagesNum LIKE \'%' . $this->_GET['name'] . '%\'' : '';
            $this->_GET['url'] ? $search_model[] = 'Url LIKE \'%' . $this->_GET['url'] . '%\'' : '';
            $this->_GET['url'] ? $search_package[] = '(PCUrl LIKE \'%' . $this->_GET['url'] . '%\' or PhoneUrl LIKE \'%' . $this->_GET['url'] . '%\')' : '';
            $this->_GET['priceL'] ? $search_model[] = 'Youhui>' . $this->_GET['priceL'] : '';
            $this->_GET['priceL'] ? $search_package[] = 'Youhui>' . $this->_GET['priceL'] : '';
            $this->_GET['priceT'] ? $search_model[] = 'Youhui<' . $this->_GET['priceT'] : '';
            $this->_GET['priceT'] ? $search_package[] = 'Youhui<' . $this->_GET['priceT'] : '';
        }
        $page = $page > 0 ? $page : 1;
        $num = $num > 0 ? $num : 5;
        $start = ($page - 1) * $num;
        $limit = ' limit ' . $start . ',' . $num;
        $order = ' order by ID desc';
        switch ($type) {
            case 1:
                //pc模板
                $Model = new ModelModule();
                $search = $search_model ? implode(' and ', $search_model) : '';
                $select = 'where Type=\'PC\'';
                $select .= $search ? ' and ' . $search : '';
                $select .= $order . $limit;
                $modelList = $Model->GetListByWhere($select);
                break;
            case 2:
                //手机模板
                $Model = new ModelModule();
                $search = $search_model ? implode(' and ', $search_model) : '';
                $select = 'where Type=\'手机\'';
                $select .= $search ? ' and ' . $search : '';
                $select .= $order . $limit;
                $modelList = $Model->GetListByWhere($select);
                break;
            case 3:
                //套餐模板
                $search = $search_package ? implode(' and ', $search_package) : '';
                $Model = new ModelPackageModule();
                $select = $search ? 'where ' . $search : '';
                $select .= $order . $limit;
                $modelList = $Model->GetListByWhere($select);
                break;
            default:
                $data = false;
                break;
        }
        foreach ($modelList as $k => $v) {
            $data[$k]['name'] = $v['NO'] ? $v['NO'] : $v['PackagesNum'];
            if ($type != 3) {
                $data[$k]['url'][] = $v['Url'];
                $data[$k]['url'][] = false;
            } else {
                $data[$k]['url'][] = $v['PCUrl'] ? $v['PCUrl'] : '--';
                $data[$k]['url'][] = $v['PhoneUrl'] ? $v['PhoneUrl'] : '--';
            }
            $data[$k]['youhui'] = $v['Youhui'];
            $data[$k]['price'] = $v['Price'];
            $data[$k]['tuijian'] = $v['TuiJian'];
            $data[$k]['id'] = $v['ID'];
//            if(($v['DeveloperName']==null||$v['DeveloperName']=="")&&$type != 3){
//                $TuUrl=GBAOPEN_DOMAIN."getTplDevUser";
//                $ToString = 'tplname=' . $data[$k]['name'];
//                $ReturnString = request_by_other($TuUrl, $ToString);
//                $ReturnArray = json_decode($ReturnString, true);
//                if($ReturnArray["err"]=="1000"&&$ReturnArray["msg"]!=null){
//                    $v['DeveloperName']=$ReturnArray["msg"];
//                }
//            }
            $data[$k]['devname'] = $v['DeveloperName'];
        }
        return $data;
    }

    protected function GetModelNumByType($type) {
        $search = '';
        $search_model = $search_package = array();
        if ($this->_GET['name'] != '' || $this->_GET['url'] != '' || $this->_GET['priceL'] != '' || $this->_GET['priceT'] != '') {
            $this->_GET['name'] ? $search_model[] = 'NO LIKE \'%' . $this->_GET['name'] . '%\'' : '';
            $this->_GET['name'] ? $search_package[] = 'PackagesNum LIKE \'%' . $this->_GET['name'] . '%\'' : '';
            $this->_GET['url'] ? $search_model[] = 'Url LIKE \'%' . $this->_GET['url'] . '%\'' : '';
            $this->_GET['url'] ? $search_package[] = '(PCUrl LIKE \'%' . $this->_GET['url'] . '%\' or PhoneUrl LIKE \'%' . $this->_GET['url'] . '%\')' : '';
            $this->_GET['priceL'] ? $search_model[] = 'Youhui>' . $this->_GET['priceL'] : '';
            $this->_GET['priceL'] ? $search_package[] = 'Youhui>' . $this->_GET['priceL'] : '';
            $this->_GET['priceT'] ? $search_model[] = 'Youhui<' . $this->_GET['priceT'] : '';
            $this->_GET['priceT'] ? $search_package[] = 'Youhui<' . $this->_GET['priceT'] : '';
        }
        switch ($type) {
            case 1:
                //pc模板
                $Model = new ModelModule();
                $search = $search_model ? implode(' and ', $search_model) : '';
                $select = 'where Type=\'PC\'';
                $select .= $search ? ' and ' . $search : '';
                $data = $Model->GetListsNum($select);
                break;
            case 2:
                //手机模板
                $Model = new ModelModule();
                $search = $search_model ? implode(' and ', $search_model) : '';
                $select = 'where Type=\'手机\'';
                $select .= $search ? ' and ' . $search : '';
                $data = $Model->GetListsNum($select);
                break;
            case 3:
                //套餐模板
                $search = $search_model ? implode(' and ', $search_package) : '';
                $Model = new ModelPackageModule();
                $select = $search ? 'where ' . $search : '';
                $data = $Model->GetListsNum($select);
                break;
            default:
                $data['Num'] = false;
                break;
        }
        return $data['Num'];
    }

    //获取模板信息
    public function GetModel() {
        $level = $_SESSION ['Level'];
        if ($level == 1) {
            $modelName = $this->_GET['name'];
            $result = array('err' => 0, 'msg' => '获取成功', 'data' => array());
            if (preg_match('/[A-Z]{2}[0]*(\d*)/', $modelName)) {
                $Model = new ModelModule();
                $modelMsg = $Model->GetOneByWhere(array('Price', 'Youhui', 'Url', 'TuiJian', 'BaiDuXingPing', 'ModelLan', 'Color', 'ModelClassID'), 'where NO="' . $modelName . '"');
                if ($modelMsg) {
                    $Data['price'] = $modelMsg['Price'];
                    $Data['youhui'] = $modelMsg['Youhui'];
                    $Data['url'] = $modelMsg['Url'];
                    $Data['tuijian'] = $modelMsg['TuiJian'];
                    $Data['star'] = $modelMsg['BaiDuXingPing'];
                    $Data['lang'] = $modelMsg['ModelLan'];
                    $Data['target'] = trim($modelMsg['ModelClassID'], ',');
                    $Data['color'] = trim($modelMsg['Color'], ',');
                    $result['data'] = $Data;
                } else {
                    $result['err'] = 1001;
                    $result['msg'] = '错误的模板编号,不存在此模板';
                }
            } else {
                $result['err'] = 1000;
                $result['msg'] = '错误的模板编号格式';
            }
        } else {
            $result['err'] = 1002;
            $result['msg'] = '非法请求';
        }
        return $result;
    }

    //文件接收，流文件或单文件上传
    public function FileUpload() {
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        //权限判断
        $level = $_SESSION ['Level'];
        if ($level == 1) {
            // 过滤其他的请求
            if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
                return NULL;
            }
            if (!empty($this->_REQUEST['debug'])) {
                $random = rand(0, intval($this->_REQUEST['debug']));
                if ($random === 0) {
                    header("HTTP/1.0 500 Internal Server Error");
                    return NULL;
                }
            }
            // 5分钟的响应时长
            @set_time_limit(5 * 60);
            // 设置临时目录和保存目录
            $targetDir = 'uploads/temp/upload_tmp';
            $uploadDir = 'uploads';
            $imgLoad = 'img_url/';
            $configLoad = 'uploads/temp/config_temp';
            //接收的文件类型
            $filetype_arr = array('zip', 'csv');
            $cleanupTargetDir = true; // 移除旧的临时文件
            $maxFileAge = 5 * 3600; // 临时文件允许存在的最大时长
            // 创建保存文件夹
            if (!file_exists($uploadDir)) {
                @mkdir($uploadDir);
            }
            // 创建临时文件夹
            if (!file_exists($targetDir)) {
                @mkdir($targetDir);
            }
            //创建临时config文件目录
            if (!file_exists($configLoad)) {
                @mkdir($configLoad);
            }

            // 获取文件名
            if (isset($this->_REQUEST["name"])) {
                $fileName = $this->_REQUEST["name"];
            } elseif (!empty($this->_FILES)) {
                $fileName = $this->_FILES["file"]["name"];
            } else {
                $fileName = false;
                //$fileName = uniqid("file_");  //生成随机文件名
            }

            //配置信息
            $msg = isset($_REQUEST["data"]) ? json_decode($_REQUEST["data"], true) : array();
            $lang = strtoupper($this->_REQUEST["lang"]) == 'EN' ? 'EN' : 'CN';

            if (!$fileName) {
                header("HTTP/1.0 500 Internal Server Error");
                return NULL;
            }

            //中文名转码
            $fileName = iconv("UTF-8", "GBK", $fileName);

            $filetype = explode('.', $fileName);
            $filetype = $filetype[count($filetype) - 1];
            if (!in_array($filetype, $filetype_arr)) {
                $result = array('err' => 1000, 'data' => '', 'msg' => '错误的文件类型');
                return $result;
            }
            $filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
            $uploadPath = $uploadDir . DIRECTORY_SEPARATOR . $fileName;
            // 文件分块启用
            $chunk = isset($this->_REQUEST["chunk"]) ? intval($this->_REQUEST["chunk"]) : 0;
            $chunks = isset($this->_REQUEST["chunks"]) ? intval($this->_REQUEST["chunks"]) : 1;
            // 移除旧的临时文件
            if ($cleanupTargetDir) {
                if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
                    $result = array('err' => 1001, 'data' => '', 'msg' => '打开临时文件失败');
                    return $result;
                }
                while (($file = readdir($dir)) !== false) {
                    $tmpfilePath = $targetDir . '/' . $file;
                    // 如果临时文件是当前文件就跳过
                    if ($tmpfilePath == "{$filePath}_{$chunk}.part" || $tmpfilePath == "{$filePath}_{$chunk}.parttmp") {
                        continue;
                    }
                    // 移除临时文件中非当前文件和过期文件
                    if (preg_match('/\.(part|parttmp)$/', $file) && (@filemtime($tmpfilePath) < time() - $maxFileAge)) {
                        @unlink($tmpfilePath);
                    }
                }
                closedir($dir);
            }
            // 打开临时文件
            if (!$out = @fopen("{$filePath}_{$chunk}.parttmp", "wb")) {
                $result = array('err' => 1001, 'data' => '', 'msg' => '打开流文件失败');
                return $result;
            }
            // 读取二进制输入流并将其追加到临时文件中
            if (!empty($this->_FILES)) {
                if ($this->_FILES["file"]["error"] || !is_uploaded_file(str_replace('\\\\', '\\', $this->_FILES["file"]["tmp_name"]))) {
                    $result = array('err' => 1002, 'data' => '', 'msg' => '上传文件移动失败');
                    return $result;
                }
                if (!$in = @fopen($this->_FILES["file"]["tmp_name"], "rb")) {
                    $result = array('err' => 1001, 'data' => '', 'msg' => '二进制流文件打开失败-1');
                    return $result;
                }
            } else {
                if (!$in = @fopen("php://input", "rb")) {
                    $result = array('err' => 1001, 'data' => '', 'msg' => '二进制流文件打开失败-2');
                    return $result;
                }
            }
            while ($buff = fread($in, 4096)) {
                fwrite($out, $buff);
            }
            @fclose($out);
            @fclose($in);
            rename("{$filePath}_{$chunk}.parttmp", "{$filePath}_{$chunk}.part");
            $index = 0;
            $done = true;
            for ($index = 0; $index < $chunks; $index++) {
                if (!file_exists("{$filePath}_{$index}.part")) {
                    $done = false;
                    break;
                }
            }
            if ($done) {
                if (!$out = @fopen($uploadPath, "wb")) {
                    $result = array('err' => 1001, 'data' => '', 'msg' => '输出流打开失败');
                    return $result;
                }
                if (flock($out, LOCK_EX)) {
                    for ($index = 0; $index < $chunks; $index++) {
                        if (!$in = @fopen("{$filePath}_{$index}.part", "rb")) {
                            break;
                        }
                        while ($buff = fread($in, 4096)) {
                            fwrite($out, $buff);
                        }
                        @fclose($in);
                        @unlink("{$filePath}_{$index}.part");
                    }
                    flock($out, LOCK_UN);
                }
                @fclose($out);
            }
            //获取所有模板
            $ModelModule = new ModelModule();
            $ret = $ModelModule->GetOneListForAll();
            $ModelList = array();
            foreach ($ret as $val) {
                $ModelList[] = $val['NO'];
            }
            switch ($filetype) {
                case 'zip':
                    $zip = new ZipArchive;
                    if ($zip->open($uploadPath) === TRUE) {
                        if ($zip->locateName('config.ini', ZIPARCHIVE::FL_NOCASE) !== false) {
                            $config = $zip->getFromName('config.ini');
                            $img = $zip->locateName('screenshot.jpg', ZIPARCHIVE::FL_NOCASE) !== false ? $zip->getFromName('screenshot.jpg') : false;
                            $configLoad = $configLoad . DIRECTORY_SEPARATOR . uniqid("file_") . '.ini';
                            file_put_contents($configLoad, $config);
                            $zip->close();
                            //获取信息
                            $ModelClass = new ModelClassModule();
                            $ModelClassLists = $ModelClass->GetListsByWhere();
                            $config_arr = parse_ini_file($configLoad, true);
                            $Data = array();
                            $Data['Name'] = $config_arr['Template']['Name'] ? $config_arr['Template']['Name'] : '';
                            $Data['Descript'] = $config_arr['Template']['Description'] ? $config_arr['Template']['Description'] : '';
                            $Data['Url'] = $config_arr['Template']['URL'] ? $config_arr['Template']['URL'] : '';
                            $Data['Version'] = $config_arr['Template']['Version'] ? $config_arr['Template']['Version'] : '';
                            $Data['Type'] = $config_arr['Config']['Type'] ? $config_arr['Config']['Type'] : '';
                            $Data['Keyword'] = $config_arr['Config']['Tags'] ? $config_arr['Config']['Tags'] : '';
                            $Data['Color'] = $config_arr['Config']['StyleColors'] ? str_replace(' ', '', $config_arr['Config']['StyleColors']) : '';
                            $Data['DeveloperSN'] = $config_arr['Developer']['SN'] ? $config_arr['Developer']['SN'] : '';
                            $Data['DeveloperName'] = $config_arr['Developer']['Name'] ? $config_arr['Developer']['Name'] : '';
                            $Data['DeveloperHi'] = $config_arr['Developer']['Hi'] ? $config_arr['Developer']['Hi'] : '';
                            $Data['DeveloperEmail'] = $config_arr['Developer']['Email'] ? $config_arr['Developer']['Email'] : '';
                            $Data['DeveloperQQ'] = $config_arr['Developer']['QQ'] ? $config_arr['Developer']['QQ'] : '';
                            $Data['DeveloperURL'] = $config_arr['Developer']['URL'] ? $config_arr['Developer']['URL'] : '';
                            $Data['DesignerSN'] = $config_arr['Designer']['SN'] ? $config_arr['Designer']['SN'] : '';
                            $Data['DesignerName'] = $config_arr['Designer']['Name'] ? $config_arr['Designer']['Name'] : '';
                            $Data['DesignerHi'] = $config_arr['Designer']['Hi'] ? $config_arr['Designer']['Hi'] : '';
                            $Data['DesignerEmail'] = $config_arr['Designer']['Email'] ? $config_arr['Designer']['Email'] : '';
                            $Data['DesignerQQ'] = $config_arr['Designer']['QQ'] ? $config_arr['Designer']['QQ'] : '';
                            $Data['DesignerURL'] = $config_arr['Designer']['URL'] ? $config_arr['Designer']['URL'] : '';
                            $Data['TesterName'] = $config_arr['Tester']['Name'] ? $config_arr['Tester']['Name'] : '';
                            $Data['TesterHi'] = $config_arr['Tester']['Hi'] ? $config_arr['Tester']['Hi'] : '';
                            $Data['TesterEmail'] = $config_arr['Tester']['Email'] ? $config_arr['Tester']['Email'] : '';
                            $Data['TesterQQ'] = $config_arr['Tester']['QQ'] ? $config_arr['Tester']['QQ'] : '';
                            $Data['TesterURL'] = $config_arr['Tester']['URL'] ? $config_arr['Tester']['URL'] : '';
                            $Data['ModelLan'] = $lang;
                            if ($msg['typetag']) {
                                $Data['ModelClassID'] = trim($msg['typetag'], ',');
                                $Data['ModelClassID'] = ',' . $Data['ModelClassID'] . ',';
                            } else {
                                $Data['ModelClassID'] = $config_arr['Config']['Category'] ? $config_arr['Config']['Category'] : '';
                                if ($Data['ModelClassID']) {
                                    preg_match_all('/[\x{4e00}-\x{9fa5}]+/u', $Data['ModelClassID'], $ModelClassID);
                                    if ($ModelClassID[0]) {
                                        $Data['ModelClassID'] = ',';
                                        foreach ($ModelClassID[0] as $key) {
                                            foreach ($ModelClassLists as $val) {
                                                if (strstr($val['CName'], $key)) {
                                                    if (!strstr($Data['ModelClassID'], ',' . $val[ID] . ','))
                                                        $Data['ModelClassID'] .=$val[ID] . ',';
                                                }
                                            }
                                        }
                                        if (!$Data['ModelClassID']) {
                                            $Data['ModelClassID'] = ',24' . ',';
                                        }
                                    } else {
                                        $Data['ModelClassID'] = ',24' . ',';
                                    }
                                } else {
                                    $Data['ModelClassID'] = ',24' . ',';
                                }
                            }
                            if ($msg['colortag']) {
                                $Data['Color'] = $msg['colortag'];
                                $have = implode(',', $msg['colortag']);
                                $Data['ZhuSeDiao'] = $have[0];
                            } else {
                                if ($Data['Color']) {
                                    preg_match_all('/\b\w[a-z]*\b/', $Data['Color'], $have);
                                    foreach ($have[0] as $val) {
                                        $Color .= $val . ',';
                                    }
                                    $Data['Color'] = $Color;
                                    $Data['ZhuSeDiao'] = $have[0][0];
                                } else {
                                    $Data['ZhuSeDiao'] = '';
                                }
                            }
                            if ($Data['Type']) {
                                $Data['Type'] = preg_match('/[A-Za-z]/', str_replace(' ', '', $Data['Type'])) ? 'PC' : '手机';
                            } else {
                                //unlink($configLoad);
                                //unlink($uploadPath);
                                $result = array('err' => 1003, 'data' => '', 'msg' => '模板文件中config.ini里配置出错，请填写Type类型！');
                                return $result;
                            }
                            $Data['BaiDuXingPing'] = $msg['star'] ? $msg['star'] : 3;
                            $msg['mPrice'] ? $Data['Price'] = $msg['mPrice'] : '';
                            $msg['yPrice'] ? $Data['Youhui'] = $msg['yPrice'] : '';
                            $Data['ModelTese'] = $msg['ModelTese'] ? $msg['ModelTese'] : '';
                            $Data['TuiJian'] = $msg['tuijian'];
                            $Data['Language'] = 'PHP';
                            $Data['AddTime'] = date('Y-n-j H:i:s', time());
                            $Data['Content'] = $msg['ModelContent'] ? $msg['ModelContent'] : '';
                            // 获取文件指定名称
                            $Modelname = $this->_REQUEST['msg'] ? $this->_REQUEST['msg'] : false;
                            if ($Modelname) {
                                if (preg_match('/GM\d{4}/', $Modelname) or preg_match('/GP\d{4}/', $Modelname)) {
                                    if (preg_match('/GM\d{5}/', $Modelname) or preg_match('/GP\d{5}/', $Modelname)) {
                                        unlink($configLoad);
                                        unlink($uploadPath);
                                        $result = array('err' => 1003, 'data' => '', 'msg' => '模板文件中config.ini里配置出错，请填写Type类型！');
                                        return $result;
                                    }
                                } else {
                                    unlink($configLoad);
                                    unlink($uploadPath);
                                    $result = array('err' => 1003, 'data' => '', 'msg' => '错误的模板名，请重新上传！');
                                    return $result;
                                }
                            } else {
                                $Modelname = '';
                            }
                            //压缩包重命名
                            if (empty($Modelname)) {
                                if ($Data['Type'] == 'PC') {
                                    $NewName = $ModelModule->GetOneForNew('PC', $lang);
                                    $NewName = (int) $NewName['Num'] + 1;
                                    $Data['Num'] = $NewName;
                                    $geshu = strlen((string) $NewName);
                                    $geshu = 4 - $geshu;
                                    $Modelname = 'GP';
                                    for ($i = 0; $i < $geshu; $i++) {
                                        $Modelname .='0';
                                    }
                                    $Modelname .= $Data['Num'];
                                    $Data['NO'] = $Modelname;
                                    $filename = $Modelname . '.zip';
                                } else {
                                    $NewName = $ModelModule->GetOneForNew('手机', $lang);
                                    $NewName = (int) $NewName['Num'] + 1;
                                    $Data['Num'] = $NewName;
                                    $geshu = strlen((string) $NewName);
                                    $geshu = 4 - $geshu;
                                    $Modelname = 'GM';
                                    for ($i = 0; $i < $geshu; $i++) {
                                        $Modelname .='0';
                                    }
                                    $Modelname .= $Data['Num'];
                                    $Data['NO'] = $Modelname;
                                    $filename = $Modelname . '.zip';
                                }
                                $uploadZip = $uploadDir . DIRECTORY_SEPARATOR . $filename;
                                rename($uploadPath, $uploadZip);
                            } else {
                                $Data['NO'] = $Modelname;
                                $filename = $Modelname . '.zip';
                                preg_match('/[A-Z]{2}[0]*(\d*)/', $Modelname, $have);
                                $Data['Num'] = $have[1];
                                if (!$Data['Num']) {
                                    unlink($configLoad);
                                    unlink($uploadPath);
                                    $result = array('err' => 1003, 'data' => '', 'msg' => '错误的模板编号！请核对后填写！');
                                    return $result;
                                }
                                $uploadZip = $uploadDir . DIRECTORY_SEPARATOR . $filename;
                                rename($uploadPath, $uploadZip);
                            }

                            $uploadImg = IMG_PICPUT . $imgLoad . $Modelname . '_screenshot.jpg';
                            $img ? file_put_contents($uploadImg, $img) : '';
                            $Data['Pic'] = $imgLoad . $Modelname . '_screenshot.jpg';

                            //生成二维码图片
                            $Data['Url'] = $msg['url'] ? $msg['url'] : $Data['Url'];
                            if (empty($Data['Url'])) {
                                if ($Data['Type'] == 'PC') {
                                    $Data['Url'] = 'http://' . $Data['NO'] . '.n01.5067.org';
                                } else {
                                    $Data['Url'] = 'http://' . $Data['NO'] . '.n01.5067.org';
                                }
                            }

                            //判断文件是否是插入或者更新
                            $InsertOrUp = 0;
                            if (in_array($Modelname, $ModelList)) {
                                $InsertOrUp = 1;
                            }
                            //向统一平台发送文件
                            $ToUrl = GBAOPEN_DOMAIN . 'upload_template';
                            $ReturnString = sendStreamFile($ToUrl, $uploadZip);
                            $ret = json_decode($ReturnString, true);
                            if ($ret['err'] != 1000) {
                                unlink($uploadImg);
                                unlink($configLoad);
                                unlink($uploadZip);
                                $result = array('err' => 1004, 'data' => $ret, 'msg' => '向统一平台数据同步失败,请再一次尝试！');
                                return $result;
                            } else {
                                if ($InsertOrUp) {
                                    $Modelever = $ModelModule->GetOneInfoByKeyID('\'' . $Modelname . '\'', 'NO');
                                    $ModelModule->UpdateArrayByNO($Data, $Modelname);
                                } else {
                                    $ModelModule->InsertArray($Data);
                                }
                            }
                            //将模板备份存储	
                            copy($uploadZip,"tpl/".$filename);
                            $this->updateModel(array("NO"=>$Modelname), "model");

                            unlink($configLoad);
                            unlink($uploadZip);
                            $result = array('err' => 0, 'data' => '', 'msg' => '上传成功！');
                            return $result;
                        } elseif ($fileName) {
                            $addColor = explode('_', $fileName);
                            if (count($addColor) == 2) {
                                $Modelname = $addColor[0];
                                $addColor = explode('.', $addColor[1]);
                                if (count($addColor) == 2) {
                                    $addColor = $addColor[0];
                                    if ((preg_match('/GM\d{4}/', $Modelname) or preg_match('/GP\d{4}/', $Modelname)) && !(preg_match('/GM\d{5}/', $Modelname) or preg_match('/GP\d{5}/', $Modelname))) {
                                        $Modelmsg = $ModelModule->GetOneInfoByKeyID('\'' . $Modelname . '\'', 'NO');
                                        if ($Modelmsg)
                                            $Modelmsg = in_array($addColor, explode(',', $Modelmsg['Color'])) ? false : $Modelmsg['Color'] . $addColor . ',';
                                        else
                                            $addColor = false;
                                    } else
                                        $addColor = false;
                                } else
                                    $addColor = false;
                            } else
                                $addColor = false;
                            $zip->close();
                            if ($addColor) {
                                if ($Modelmsg) {
                                    $ModelModule->UpdateArrayByNO(array('Color' => $Modelmsg), $Modelname);
                                }
                                unlink($uploadPath);
                                $result = array('err' => 0, 'data' => '', 'msg' => '颜色包上传成功!');
                                return $result;
                            } else {
                                unlink($uploadPath);
                                $result = array('err' => 1000, 'data' => '', 'msg' => '上传失败,无效文件!');
                                return $result;
                            }
                        } else {
                            unlink($uploadPath);
                            $result = array('err' => 1000, 'data' => '', 'msg' => '上传失败,无效文件，请核对再上传!');
                            return $result;
                        }
                    } else {
                        unlink($uploadPath);
                        $result = array('err' => 1000, 'data' => '', 'msg' => '上传失败,压缩文件打不开!');
                        return $result;
                    }
                    break;
                case 'csv':
                    //报价信息格式验证
                    $ModulePriceToken = array(
                        0 => '模板编号',
                        1 => '美观度得分',
                        2 => '交互体验得分',
                        3 => '功能得分',
                        4 => '设计经理评分',
                        5 => '产品经理评分',
                        6 => '总评分',
                        7 => '市场价',
                        8 => '优惠价',
                        9 => 'BUG扣分',
                        10 => '设计师积分累计',
                        11 => '开发者积分累计',
                        12 => '测试积分累计',
                        13 => '模板特色'
                    );
                    $i = 1;
                    //模板上传出现读取不了中文时，开启下面这句
                    setlocale(LC_ALL, NULL);

                    $file = fopen($uploadPath, 'r');
                    while ($data = fgetcsv($file)) {
                        if ($i) {
                            $jieguo = $data;
                            unset($i);
                        }
                        if (preg_match("/^[0-9a-zA-Z]{3,}$/", $data['0'])) {
                            $bj_list[$data[0]] = $data;
                            $bj_model[] = $data[0];
                        } else
                            continue;
                    }
                    foreach ($bj_list as &$arr) {
                        foreach ($arr as &$v) {
                            $v = trim(str_replace('?', '', $v));
                            $v = trim(str_replace(',', '', $v));
                        }
                    }
                    fclose($file);

                    //判断模板文件格式是否正确
                    $i = 0;
                    foreach ($jieguo as $k => &$val) {
                        $encode = mb_detect_encoding($val, array('ASCII', 'GB2312', 'GBK', 'UTF-8'));
                        if ($encode != 'UTF-8') {
                            $val = iconv($encode, "UTF-8", $val);
                        }
                        if ($ModulePriceToken[$k] != $val) {
                            $i = 1;
                        }
                    }
                    if ($i) {
                        unlink($uploadPath);
                        $result = array('err' => 1001, 'data' => '', 'msg' => 'csv文件非法错误，请检查!');
                        return $result;
                    }

                    //取得要更新报价的模板名
                    $Updata_model = array_intersect($bj_model, $ModelList);
                    $Data = array();
                    $err = array();
                    $success = 0;
                    for ($i = 0; $i < count($Updata_model); $i++) {
                        $Data['Aesthetics'] = $bj_list[$Updata_model[$i]][1] ? $bj_list[$Updata_model[$i]][1] : '';
                        $Data['Interaction'] = $bj_list[$Updata_model[$i]][2] ? $bj_list[$Updata_model[$i]][2] : '';
                        $Data['Features'] = $bj_list[$Updata_model[$i]][3] ? $bj_list[$Updata_model[$i]][3] : '';
                        if ($bj_list[$Updata_model[$i]][7]) {
                            $Data['Price'] = $bj_list[$Updata_model[$i]][7];
                            ;
                        }
                        if ($bj_list[$Updata_model[$i]][8]) {
                            $Data['Youhui'] = $bj_list[$Updata_model[$i]][8];
                            ;
                        }
                        $Data['DesignerScore'] = $bj_list[$Updata_model[$i]][10] ? $bj_list[$Updata_model[$i]][10] : '';
                        $Data['DeveloperScore'] = $bj_list[$Updata_model[$i]][11] ? $bj_list[$Updata_model[$i]][11] : '';
                        $Data['TesterScore'] = $bj_list[$Updata_model[$i]][12] ? $bj_list[$Updata_model[$i]][12] : '';
                        if ($bj_list[$Updata_model[$i]][13]) {
                            $Data['ModelTese'] = $bj_list[$Updata_model[$i]][13];
                            ;
                        }
                        if ($ModelModule->UpdateArray($Data, array('NO' => $Updata_model[$i]))) {
                            $success++;
                        } else {
                            $err[] = $Updata_model[$i];
                        }
                    }
                    unlink($uploadPath);
                    if (count($err)) {
                        $result = array('err' => 1000, 'data' => '失败的报价模板分别为：' . implode(',', $err) . '。请对这些模板的报价重新上传或手动修改', 'msg' => '成功修改' . $success . '个，失败' . count($err) . '个!');
                        return $result;
                    } else {
                        $result = array('err' => 0, 'data' => '', 'msg' => '成功修改' . $success . '个');
                        return $result;
                    }
                    break;
                default :
                    $result = array('err' => 1002, 'data' => '', 'msg' => '');
                    return $result;
            }
            exit;
        } else {
            $result = array('err' => 1001, 'data' => '', 'msg' => '非法请求!');
            return $result;
        }
    }

    public function updateModel($where,$table){
        $result=array();
        $str =" where 1 ";
        foreach ($where as $key => $value) {
            $str .="and {$key} = '{$value}'";
        }
        if($table=="model"){
            $Model=new ModelModule();
            $data=$Model->GetOneByWhere(array(),$str);
            if (!$data['Url_status']) {
                $data['EWM'] = '';
            } else {
                if($data["Type"]=="PC"){
                    $data['EWM'] = 'http://s.jiathis.com/qrcode.php?url=' . $data['Url'];
                }else{
                    if(strpos($data["Url"], 'http://GM')===false){
                        $data['EWM'] = 'http://s.jiathis.com/qrcode.php?url=' . $data['Url'];
                    }else{
                        $data['Url']=str_replace('http://GM', 'http://m.GM', $data['Url']);
                        $data['EWM'] = 'http://s.jiathis.com/qrcode.php?url=' . $data['Url'];
                    }
                }
            }
            $data["PCNum"]="";
            $data["PhoneNum"]="";
//            $result["no"]=$data["NO"];
//            $result["title"]=$data["Name"];
//            $result["pic"]=$data["Pic"];
        }else{
            $modelpack=new ModelPackageModule();
            $data=$modelpack->GetOneByWhere(array(),$str);
            
            $data["Type"]="双站";
            if (!$data['Url_status']) {
                $data['Url'] = '';
                $data['EWM'] = '';
            } else {
                 $data['Url'] = $data['PCUrl'];
                $data['EWM'] = 'http://s.jiathis.com/qrcode.php?url=' . $data['PhoneUrl'];
            }
            $data['NO']=$data["PackagesNum"];
            $data['Name']=$data["PackagesName"];
//            $result["no"]=$data["PackagesNum"];
//            $result["title"]=$data["PackagesName"];
//            $result["pcnum"]=$data["PCNum"];
//            $result["mobilenum"]=$data["PhoneNum"];
        }
        $ModelClassInfo="";
        $ModelClass=new ModelClassModule();
        $ModelClassID = explode(',', $data['ModelClassID']);
        foreach ($ModelClassID as $val) {
            if ($val) {
                $CName = $ModelClass->GetOneInfoByKeyID($val);
                $ModelClassInfo .= $CName['CName'];
            }
        }
//        $result["id"]=$data["ID"];
//        $result["tuijian"]=$data["Tuijian"];
//        $result["color"]=$data["Color"];
//        $result["star"]=$data["BaiDuXingPing"];
//        $result["descript"]=$data["Descript"];
//        $result["price"]=$data["Price"];
//        $result["youhui"]=$data["Youhui"];
//        $result["sort"]=$data["Num"];
//        $result["tone"]=$data["ZhuSeDiao"];
//        $result["pl"]=$data["Language"];
//        $result["website"]=$data["Url"];
//        $result["time"]=$data["AddTime"];
//        $result["ewm"]=$data["EWM"];
//        $result["content"]=$data["Content"];
//        $result["modelclassid"]=$data["ModelClassID"];
//        $result["type"]=$data["Type"];
        $String .= '<?xml version="1.0" encoding="utf-8"?>
            <main>
              <model>
                <id>' . $data['ID'] . '</id>
                <no>' . $data['NO'] . '</no>
                <title>' . $data['Name'] . '</title>
                <color>' . $data['Color'] . '</color>
                <tuijian>'. $data['TuiJian'] .'</tuijian>
                <star>' . $data['BaiDuXingPing'] . '</star>
                <descript>' . $data['Descript'] . '</descript>
                <price>' . $data['Price'] . '</price>
                <pcnum>' . $data['PCNum'] . '</pcnum>
                <mobilenum>' . $data['PhoneNum'] . '</mobilenum>
                <youhui>' . $data['Youhui'] . '</youhui>
                <sort>' . $ModelClassInfo . '</sort>
                <tone>' . $data['ZhuSeDiao'] . '</tone>
                <pl>' . $data['Language'] . '</pl>
                <website>' . $data['Url'] . '</website>
                <time>' . $data['AddTime'] . '</time>
                <ewm>' . $data['EWM'] . '</ewm>
                <modellan>' . $data['ModelLan'] . '</modellan>
                <content>' . $data['Content'] . '</content>
                <modelclassid>' . $data['ModelClassID'] . '</modelclassid>
                <type>' . $data["Type"] . '</type>
                <pic>' . ($data["Pic"]?$data["Pic"]:"") . '</pic>
              </model>
            </main>
            ';
        $code="data=".  $String;
        $url = GUANWANG_DOMAIN.'UpdateData.aspx';
        $Coupons = request_by_other($url, $code);
        return $Coupons;
    }
}