<?php

class ApiModel extends ForeVIEWS {

    public function __Public() {
        header('Content-type: application/json');
    }

//==========================================PC==============
    //返回分类列表	http://dailipingtai.dn160.com.cn/index.php?module=ApiModel&action=GetCalssList
    public function GetCalssList() {
        $ModelClass = new ModelClassModule();
        $ModelClassLists = $ModelClass->GetListsAll();
        $String = '';
        foreach ($ModelClassLists as $Value) {
            $String .= '  <sort>
			<id>' . $Value['ID'] . '</id>
			<sortname>' . $Value['CName'] . '</sortname>
			</sort>
			';
        }
        $String = '<?xml version="1.0" encoding="utf-8"?>
		<sorts>' . $String . '</sorts>';
        echo $String;
        exit;
    }

    //返回地区列表
    public function GetAreaList() {
        $area = new AreaModule;
        $areaList = $area->GetAllByWhere();
        foreach ($areaList as $v) {
            $String .= '<area>
                            <id>' . $v['ID'] . '</id>
                            <name>' . $v['AreaName'] . '</name>
                            <parent>' . $v['ParentID'] . '</parent>
                        </area>';
        }
        $String = '<?xml version="1.0" encoding="utf-8"?>
		<areas>' . $String . '</areas>';
        echo $String;
        exit;
    }

    //返回案例列表
    public function GetCasesList() {
        if ($this->_GET) {
            $Color = trim($this->_GET['Color']); //颜色
            $Cases = _intval($this->_GET['Cases']); //案例区域号
            $SortID = trim($this->_GET['SortGUID']); //类型标签
            $Page = _intval($this->_GET['Page']); //当前页数;
            $Number = _intval($this->_GET['Number']); //每页显示数量
            $Page = $Page == 0 ? 1 : $Page;
            $Number = $Number == 0 ? 1 : $Number;
            $start = ($Page - 1) * $Number;
            $limit = ' limit ' . $start . ',' . $Number;
            $DB = new DB();
            $where = $Cases ? ' where Cases like \'' . $Cases . '%\'' : ' where Cases > 0';
            $where .= $Color ? ' and CaseImage like \'%' . $Color . '%\'' : '';
            $where .= $SortID ? ' and CaseImage like \'%,' . $SortID . ',%\'' : '';
            $sql = 'select count(1) as Num from tb_customers_project' . $where;
            $num = $DB->Select($sql);
            $num = $num[0]['Num'];
            $sql = 'select a.PC_domain,a.CustomersID,a.CaseImage,b.CompanyName from tb_customers_project a inner join tb_customers b on a.CustomersID=b.CustomersID ';
            $sql = $sql . $where . $limit;
            $ModelList = $DB->Select($sql);
            $String = '';
            foreach ($ModelList as $Value) {
                $casedata = explode(',', $Value['CaseImage']);
                $count = count($casedata);
                $img = DAILI_DOMAIN . $casedata[$count - 2];
                $String .= '  <model>
				<id>' . $Value['CustomersID'] . '</id>
				<name>' . $Value['CompanyName'] . '</name>
				<url>' . $Value['PC_domain'] . '</url>
				<img>' . $img . '</img>
			  	</model>
				';
            }
            $String = '<?xml version="1.0" encoding="utf-8"?>
			<models>
			' . $String .
                    '  <page>
				<total>' . $num . '</total>
			</page>
			</models>';
            echo $String;
            exit;
        } else {
            echo '参数错误';
            exit();
        }
    }

    //返回案例列表
    public function GetCasesModel() {
        if ($this->_GET && _intval($this->_GET['ModelID'])) {
            $cusid = _intval($this->_GET['ModelID']); //客户ID
            $cuspro = new CustProModule;
            $cus = new CustomersModule;
            $pc = new ModelModule;
            $cuspromsg = $cuspro->GetOneByWhere(array('PC_domain', 'CaseImage', 'PC_model', 'CustomersProjectID'), 'where CustomersID=' . $cusid);
            if ($cuspromsg) {
                $cusmsg = $cus->GetOneByWhere(array('CompanyName'), 'where CustomersID=' . $cusid);
                $BackInfo = $cuspro->GetOneByWhere(array('CustomersID'), 'where CustomersProjectID>' . $cuspromsg['CustomersProjectID'] . ' and Cases > 0');
                $NextInfo = $cuspro->GetOneByWhere(array('CustomersID'), 'where CustomersProjectID<' . $cuspromsg['CustomersProjectID'] . ' and Cases > 0');
                $pcmsg = $pc->GetOneByWhere(array('ModelLan', 'Language', 'Price', 'Youhui'), 'where NO=\'' . $cuspromsg['PC_model'] . '\'');
                $casedata = explode(',', $cuspromsg['CaseImage']);
                for ($i = 0, $count = count($casedata), $type = 1; $i < $count; $i++) {
                    if ($casedata[$i]) {
                        /* type类型：1为颜色，2为行业标签号，3为图片 */
                        switch ($type) {
                            case 1:
                                if ($casedata[$i] != 'tag') {
                                    $case['color'][] = $casedata[$i];
                                } else {
                                    $type = 2;
                                }
                                break;
                            case 2:
                                if ($casedata[$i] != 'img') {
                                    $case['tag'][] = $casedata[$i];
                                } else {
                                    $type = 3;
                                }
                                break;
                            case 3:
                                $case['img'][] = $casedata[$i];
                                break;
                        }
                    }
                }
                $color = implode(',', $case['color']);
                $img = '<![CDATA[<div align="center"><img width="100%" src="' . DAILI_DOMAIN . $case['img'][1] . '" /></div>]]>';
                $String = '<?xml version="1.0" encoding="utf-8"?>
			<mian>
                            <model>
				<id>' . $cusid . '</id>
				<name>' . $cusmsg['CompanyName'] . '</name>
				<url>' . $cuspromsg['PC_domain'] . '</url>
				<img>' . $img . '</img>
				<color>' . $color . '</color>
				<lang>' . $pcmsg['Language'] . '</lang>
				<type>' . $pcmsg['ModelLan'] . '</type>
				<code>' . $cuspromsg['PC_model'] . '</code>
                                <prev>' . $BackInfo['CustomersID'] . '</prev>
                                <next>' . $NextInfo['CustomersID'] . '</next>
                            </model>
			</mian>';
                echo $String;
            } else {
                echo '参数错误';
            }
        } else {
            echo '参数错误';
        }
        exit();
    }

    //返回PC数据列表	http://dailipingtai.dn160.com.cn/index.php?module=ApiModel&action=GetPCModelList&SortGUID=&Color=blue&Keyword=&Page=1&Number=2
    public function GetPCModelList() {

        if ($this->_GET) {
            $SortGUID = trim($this->_GET['SortGUID']); //类别ID
            $Color = trim($this->_GET['Color']); //颜色
            $Sprice = trim($this->_GET['Sprice']);
            $Eprice = trim($this->_GET['Eprice']);
            $lang = trim($this->_GET['lang']);
            $Keyword = trim($this->_GET['Keyword']); //关键字
            $Page = _intval($this->_GET['Page']); //当前页数
            $Number = _intval($this->_GET['Number']); //每页显示数量
            $Page = $Page == 0 ? 1 : $Page;
            $Number = $Number == 0 ? 1 : $Number;
            $lang = ($lang == 'en') ? 'EN' : 'CN';
            $Where = ' where Type=\'PC\' and TuiJian>0';
            if ($SortGUID)
                $Where .= ' and ModelClassID like \'%,' . $SortGUID . ',%\'';
            if ($Color)
                $Where .= ' and Color like \'%' . $Color . '%\'';
            if ($Sprice)
                $Where .= ' and Youhui>' . $Sprice;
            if ($Eprice)
                $Where .= ' and Youhui<' . $Eprice;
            if ($Keyword)
                $Where .= ' and (Keyword = \'' . $Keyword . '\' or NO = \'' . $Keyword . '\')';
            if ($lang)
                $Where .= ' and ModelLan = \'' . $lang . '\'';
            $Model = new ModelModule();
            $Offset = ($Page - 1) * $Number;
            $ModelList = $Model->GetLists($Where, $Offset, $Number);
            $ModelListNun = $Model->GetListsNum($Where);

            $String = '';
            foreach ($ModelList as $Value) {
                if (!$Value['Url_status']) {
                    $Value['Url'] = '';
                }
                $Value['Pic'] = DAILI_DOMAIN . 'uploads/img_url/' . $Value['Pic'];
                $String .= '  <model>
				<id>' . $Value['ID'] . '</id>
				<no>' . $Value['NO'] . '</no>
				<title>' . $Value['Name'] . '</title>
				<color>' . $Value['Color'] . '</color>
				<star>' . $Value['BaiDuXingPing'] . '</star>
				<website>' . $Value['Url'] . '</website>
				<sort>' . $Value['CName'] . '</sort>
				<tone>' . $Value['ZhuSeDiao'] . '</tone>
				<pl>' . $Value['Language'] . '</pl>
				<price>' . $Value['Price'] . '</price>
				<youhui>' . $Value['Youhui'] . '</youhui>
				<time>' . $Value['AddTime'] . '</time>
				<picture>' . $Value['Pic'] . '</picture>
			  	</model>
				';
            }
            $String = '<?xml version="1.0" encoding="utf-8"?>
			<models>
			' . $String .
                    '  <page>
				<total>' . $ModelListNun['Num'] . '</total>
			  </page>
			</models>';
            echo $String;
            exit;
        } else {
            echo '参数错误';
            exit();
        }
    }

    //获取数据模型	http://dailipingtai.dn160.com.cn/index.php?module=ApiModel&action=GetPCModel&ModelID=2
    public function GetPCModel() {
        $ModelID = _intval($this->_GET['ModelID']); //当前页数
        $Model = new ModelModule();
        $ModelInfo = $Model->GetOneInfoByKeyID($ModelID);
        $ModelClassID = explode(',', $ModelInfo['ModelClassID']);
        $ModelClass = new ModelClassModule();
        $ModelClassInfo = '';
        foreach ($ModelClassID as $val) {
            if ($val) {
                $CName = $ModelClass->GetOneInfoByKeyID($val);
                $ModelClassInfo .= $CName['CName'];
            }
        }
        if (!$ModelClassInfo) {
            $ModelClassInfo = '其他';
        }
        if (!$ModelInfo['Content']) {
            $ModelInfo['Content'] = '<![CDATA[<div align="center"><img width="100%" src="' . DAILI_DOMAIN . 'uploads/img_url/' . $ModelInfo['Pic'] . '" /></div>]]>';
        }
        if (!$ModelInfo['Url_status']) {
            $ModelInfo['Url'] = '';
        }
        //上一篇
        $BackInfo = $Model->GetOneInfoByKeyIDBack($ModelID, ' and TuiJian>0 and Type=\'PC\'');
        //下一篇
        $NextInfo = $Model->GetOneInfoByKeyIDzNext($ModelID, ' and TuiJian>0 and Type=\'PC\'');
        $ModelInfo['Color'] = str_replace(',', ' ', $ModelInfo['Color']);
        $String .= '<?xml version="1.0" encoding="utf-8"?>
		<main>
		  <model>
			<id>' . $ModelInfo['ID'] . '</id>
			<no>' . $ModelInfo['NO'] . '</no>
			<title>' . $ModelInfo['Name'] . '</title>
			<color>' . $ModelInfo['Color'] . '</color>
			<star>' . $ModelInfo['BaiDuXingPing'] . '</star>
			<descript>' . $ModelInfo['Descript'] . '</descript>
			<price>' . $ModelInfo['Price'] . '</price>
			<youhui>' . $ModelInfo['Youhui'] . '</youhui>
			<sort>' . $ModelClassInfo . '</sort>
			<tone>' . $ModelInfo['ZhuSeDiao'] . '</tone>
			<pl>' . $ModelInfo['Language'] . '</pl>
			<website>' . $ModelInfo['Url'] . '</website>
			<time>' . $ModelInfo['AddTime'] . '</time>
			<prev>' . $BackInfo['ID'] . '</prev>
			<next>' . $NextInfo['ID'] . '</next>
			<content>' . $ModelInfo['Content'] . '</content>
		</model>
		</main>
		';
        echo $String;
        exit;
    }

    //获取推荐PC模版	http://dl.5067.org/index.php?module=ApiModel&action=GetPCModelRead&Number=5
    public function GetPCModelRead() {

        if ($this->_GET) {
            $Model = new ModelModule();
            $ModelID = _intval($this->_GET['ModelID']); //模板ID
            if (!$ModelID) {
                echo 'error';
                exit;
            }
            //读取模板信息
            $ModelInfo = $Model->GetOneInfoByKeyID($ModelID);
            $count = 0;  //用于计算获取的模板数量
            $cut = array();   //排除相同 的模板
            $Number = _intval($this->_GET['Number']); //每页显示数量
            if ($Number <= 0)
                $Number = 1;
            //$Offset = ($Page - 1) * $Number;
            //套餐模板推荐
            $Like_array = array();
            $ModelPack = $Model->GetListsAll('tb_model_packages', ' where PhoneNum = \'' . $ModelInfo['NO'] . '\' and TuiJian>0');
            if (count($ModelPack)) {
                $num = rand(1, count($ModelPack)) - 1;
                $ModelPack = $ModelPack[$num];
                $Like_array = $Model->GetListsAll('tb_model', ' where NO = \'' . $ModelPack['PCNum'] . '\' and Type=\'PC\' and TuiJian>0');
                if (count($Like_array)) {
                    $num = rand(1, count($Like_array)) - 1;
                    $cut[] = $Like_array[$num]['ID'];
                    $ModelList[$count] = $Like_array[$num];
                    $count +=1;
                }
            }
            //套餐推荐结束
            //颜色相同推荐
            $Color_array = array();
            if ($count < $Number) {
                $paichu = $cut ? implode(',', $cut) : '\'\'';
                $Color_array = $Model->GetListsAll('tb_model', ' where ID not in (' . $paichu . ') and Color like \'%' . $ModelInfo['Color'] . '%\' and Type=\'PC\' and TuiJian>0');
                if (count($Color_array)) {
                    $num = rand(1, count($Color_array)) - 1;
                    $cut[] = $Color_array[$num]['ID'];
                    $ModelList[$count] = $Color_array[$num];
                    $count +=1;
                }
            }
            //颜色推荐结束
            //类别模板推荐
            $Type_array = array();
            if ($count < $Number) {
                $ModelClassID = $ModelInfo['ModelClassID'];
                $ModelClassID = explode(',', $ModelClassID);
                foreach ($ModelClassID as $v) {
                    if ($v) {
                        $linshi = array();
                        $paichu = $cut ? implode(',', $cut) : '\'\'';
                        $linshi = $Model->GetListsAll('tb_model', ' where ID not in (' . $paichu . ') and Type=\'PC\' and TuiJian>0 and ModelClassID like \'%,' . $v . ',%\'');
                        for ($i = 0; $i < count($linshi); $i++) {
                            $cut[] = $linshi[$i]['ID'];
                            $count +=1;
                        }
                        $Type_array = array_merge($Type_array, $linshi);
                        if ($count >= $Number) {
                            break;
                        }
                    }
                }
            }
            //类别推荐结束
            //如果数量不够，进行补充
            $Add = array();
            if ($count < $Number) {
                $paichu = $cut ? implode(',', $cut) : '\'\'';
                $Add = $Model->GetListsAll('tb_model', ' where ID not in (' . $paichu . ') and Type=\'PC\' and TuiJian>0 order by rand() limit ' . ($Number - $count));
            }
            //补充结束

            $Type_array ? $ModelList = array_merge($ModelList, $Type_array) : NULL;
            $Add ? $ModelList = array_merge($ModelList, $Add) : NULL;
            $String = '';
            $count = 0;
            foreach ($ModelList as $Value) {
                if (!$Value['Url_status']) {
                    $Value['Url'] = '';
                }
                $Value['Pic'] = DAILI_DOMAIN . 'uploads/img_url/' . $Value['Pic'];
                $String .= '  <model>
				<id>' . $Value['ID'] . '</id>
				<no>' . $Value['NO'] . '</no>
				<title>' . $Value['Name'] . '</title>
				<color>' . $Value['Color'] . '</color>
				<sort>' . $Value['CName'] . '</sort>
				<tone>' . $Value['ZhuSeDiao'] . '</tone>
				<pl>' . $Value['Language'] . '</pl>
				<star>' . $Value['BaiDuXingPing'] . '</star>
				<website>' . $Value['Url'] . '</website>
				<price>' . $Value['Price'] . '</price>
				<youhui>' . $Value['Youhui'] . '</youhui>
				<time>' . $Value['AddTime'] . '</time>
				<picture>' . $Value['Pic'] . '</picture>
			  </model>
			';
                $count +=1;
                if ($count >= $Number) {
                    break;
                }
            }
            $String = '<?xml version="1.0" encoding="utf-8"?>
			<models>
			' . $String .
                    '  <page>
				<total>' . $count . '</total>
			  </page>
			</models>';
            echo $String;
            exit;
        } else {
            echo '参数错误';
            exit();
        }
    }

//==========================手机=============
//返回手机数据列表	http://dailipingtai.dn160.com.cn/index.php?module=ApiModel&action=GetMobileModelList&SortGUID=&Color=blue&Keyword=&Page=1&Number=2
    public function GetMobileModelList() {

        if ($this->_GET) {
            $SortGUID = trim($this->_GET['SortGUID']); //类别ID
            $Color = trim($this->_GET['Color']); //颜色
            $Sprice = trim($this->_GET['Sprice']);
            $Eprice = trim($this->_GET['Eprice']);
            $lang = trim($this->_GET['lang']);
            $lang = ($lang == 'en') ? 'EN' : 'CN';
            $Keyword = trim($this->_GET['Keyword']); //关键字
            $Page = _intval($this->_GET['Page']); //当前页数
            if ($Page == 0)
                $Page = 1;
            $Number = _intval($this->_GET['Number']); //每页显示数量
            if ($Number == 0)
                $Number = 1;
            $Where = ' where Type=\'手机\' and TuiJian>0';
            if ($SortGUID)
                $Where .= ' and ModelClassID like \'%,' . $SortGUID . ',%\'';
            if ($Color)
                $Where .= ' and Color like \'%' . $Color . '%\'';
            if ($Sprice)
                $Where .= ' and Youhui>' . $Sprice;
            if ($Eprice)
                $Where .= ' and Youhui<' . $Eprice;
            if ($Keyword)
                $Where .= ' and (Keyword=\'' . $Keyword . '\' or NO = \'' . $Keyword . '\')';
            if ($lang)
                $Where .= ' and ModelLan = \'' . $lang . '\'';

            $Model = new ModelModule();
            $Offset = ($Page - 1) * $Number;
            $ModelList = $Model->GetLists($Where, $Offset, $Number);
            $ModelListNun = $Model->GetListsNum($Where);

            $String = '';
            foreach ($ModelList as $Value) {
                if (!$Value['Url_status']) {
                    $Value['Url'] = '';
                    $Value['EWM'] = '';
                } else {
                    $tureUrl = trim($Value['Url'], 'http://');
                    $tureUrl = trim($tureUrl, 'G');
                    if ($tureUrl == trim($tureUrl, 'T')) {
                        if ($tureUrl == trim($tureUrl, 'P')) {
                            $Value['EWM'] = 'http://s.jiathis.com/qrcode.php?url=http://m.G' . $tureUrl;
                        } else {
                            $Value['EWM'] = 'http://s.jiathis.com/qrcode.php?url=http://G' . $tureUrl;
                        }
                    } else
                        $Value['EWM'] = 'http://s.jiathis.com/qrcode.php?url=http://G' . $tureUrl;
                }
                $Value['Pic'] = DAILI_DOMAIN . 'uploads/img_url/' . $Value['Pic'];
                $String .= '  <model>
				<id>' . $Value['ID'] . '</id>
				<no>' . $Value['NO'] . '</no>
				<title>' . $Value['Name'] . '</title>
				<color>' . $Value['Color'] . '</color>
				<star>' . $Value['BaiDuXingPing'] . '</star>
				<website>' . $Value['Url'] . '</website>
				<sort>' . $Value['CName'] . '</sort>
				<tone>' . $Value['ZhuSeDiao'] . '</tone>
				<pl>' . $Value['Language'] . '</pl>
				<price>' . $Value['Price'] . '</price>
				<youhui>' . $Value['Youhui'] . '</youhui>
				<ewm>' . $Value['EWM'] . '</ewm>
				<time>' . $Value['AddTime'] . '</time>
				<picture>' . $Value['Pic'] . '</picture>
			  </model>
			';
            }
            $String = '<?xml version="1.0" encoding="utf-8"?>
			<models>
			' . $String .
                    '  <page>
				<total>' . $ModelListNun['Num'] . '</total>
			  </page>
			</models>';
            echo $String;
            exit;
        } else {
            echo '参数错误';
            exit();
        }
    }

    //获取手机数据模型	http://dailipingtai.dn160.com.cn/index.php?module=ApiModel&action=GetMobileModel&ModelID=2
    public function GetMobileModel() {
        $ModelID = _intval($this->_GET['ModelID']); //当前ID
        $Model = new ModelModule();
        $ModelInfo = $Model->GetOneInfoByKeyID($ModelID);
        $ModelClassID = explode(',', $ModelInfo['ModelClassID']);
        $ModelClass = new ModelClassModule();
        $ModelClassInfo = '';
        foreach ($ModelClassID as $val) {
            if ($val) {
                $CName = $ModelClass->GetOneInfoByKeyID($val);
                $ModelClassInfo .= $CName['CName'];
            }
        }
        if (!$ModelClassInfo) {
            $ModelClassInfo = '其他';
        }
        if (!$ModelInfo['Url_status']) {
            $ModelInfo['Url'] = '';
            $ModelInfo['EWM'] = '';
        } else {
            $tureUrl = trim($ModelInfo['Url'], 'http://');
            $tureUrl = trim($tureUrl, 'G');
            if ($tureUrl == trim($tureUrl, 'T')) {
                if ($tureUrl == trim($tureUrl, 'P')) {
                    $ModelInfo['EWM'] = 'http://s.jiathis.com/qrcode.php?url=http://m.G' . $tureUrl;
                } else {
                    $ModelInfo['EWM'] = 'http://s.jiathis.com/qrcode.php?url=http://G' . $tureUrl;
                }
            } else
                $ModelInfo['EWM'] = 'http://s.jiathis.com/qrcode.php?url=http://G' . $tureUrl;
        }
        if (!$ModelInfo['Content']) {
            $ModelInfo['Content'] = '<![CDATA[<div align="center"><img width="50%" src="' . DAILI_DOMAIN . 'uploads/img_url/' . $ModelInfo['Pic'] . '" /></div>]]>';
        }
        //上一篇
        $BackInfo = $Model->GetOneInfoByKeyIDBack($ModelID, ' and TuiJian>0 and Type=\'手机\'');
        //下一篇
        $NextInfo = $Model->GetOneInfoByKeyIDzNext($ModelID, ' and TuiJian>0 and Type=\'手机\'');
        $ModelInfo['Color'] = str_replace(',', ' ', $ModelInfo['Color']);
        $String .= '<?xml version="1.0" encoding="utf-8"?>
		<main>
		  <model>
			<id>' . $ModelInfo['ID'] . '</id>
			<no>' . $ModelInfo['NO'] . '</no>
			<title>' . $ModelInfo['Name'] . '</title>
			<color>' . $ModelInfo['Color'] . '</color>
			<star>' . $ModelInfo['BaiDuXingPing'] . '</star>
			<descript>' . $ModelInfo['Descript'] . '</descript>
			<price>' . $ModelInfo['Price'] . '</price>
			<youhui>' . $ModelInfo['Youhui'] . '</youhui>
			<sort>' . $ModelClassInfo . '</sort>
			<tone>' . $ModelInfo['ZhuSeDiao'] . '</tone>
			<pl>' . $ModelInfo['Language'] . '</pl>
			<website>' . $ModelInfo['Url'] . '</website>
			<time>' . $ModelInfo['AddTime'] . '</time>
			<prev>' . $BackInfo['ID'] . '</prev>
			<next>' . $NextInfo['ID'] . '</next>
			<ewm>' . $ModelInfo['EWM'] . '</ewm>
			<content>' . $ModelInfo['Content'] . '</content>
		  </model>
		</main>
		';
        echo $String;
        exit;
    }

    //获取推荐手机模版	http://dailipingtai.dn160.com.cn/index.php?module=ApiModel&action=GetMobileModelRead&Number=5
    public function GetMobileModelRead() {

        if ($this->_GET) {
            $Model = new ModelModule();
            $ModelID = _intval($this->_GET['ModelID']); //模板ID
            if (!$ModelID) {
                echo 'error';
                exit;
            }
            //读取模板信息
            $ModelInfo = $Model->GetOneInfoByKeyID($ModelID);
            $count = 0;  //用于计算获取的模板数量
            $cut = array();   //排除相同 的模板
            $Number = _intval($this->_GET['Number']); //每页显示数量
            if ($Number <= 0)
                $Number = 1;
            //$Offset = ($Page - 1) * $Number;
            //套餐模板推荐
            $Like_array = array();
            $ModelPack = $Model->GetListsAll('tb_model_packages', ' where PCNum = \'' . $ModelInfo['NO'] . '\' and TuiJian>0');
            if (count($ModelPack)) {
                $num = rand(1, count($ModelPack)) - 1;
                $ModelPack = $ModelPack[$num];
                $Like_array = $Model->GetListsAll('tb_model', ' where NO = \'' . $ModelPack['PhoneNum'] . '\' and Type=\'手机\' and TuiJian>0');
                if (count($Like_array)) {
                    $num = rand(1, count($Like_array)) - 1;
                    $cut[] = $Like_array[$num]['ID'];
                    $ModelList[$count] = $Like_array[$num];
                    $count +=1;
                }
            }
            //套餐推荐结束
            //颜色相同推荐
            $Color_array = array();
            if ($count < $Number) {
                $paichu = $cut ? implode(',', $cut) : '\'\'';
                $Color_array = $Model->GetListsAll('tb_model', ' where ID not in (' . $paichu . ') and Color like \'%' . $ModelInfo['Color'] . '%\' and Type=\'手机\' and TuiJian>0');
                if (count($Color_array)) {
                    $num = rand(1, count($Color_array)) - 1;
                    $cut[] = $Color_array[$num]['ID'];
                    $ModelList[$count] = $Color_array[$num];
                    $count +=1;
                }
            }
            //颜色推荐结束
            //类别模板推荐
            $Type_array = array();
            if ($count < $Number) {
                $ModelClassID = $ModelInfo['ModelClassID'];
                $ModelClassID = explode(',', $ModelClassID);
                foreach ($ModelClassID as $v) {
                    if ($v) {
                        $linshi = array();
                        $paichu = $cut ? implode(',', $cut) : '\'\'';
                        $linshi = $Model->GetListsAll('tb_model', ' where ID not in (' . $paichu . ') and Type=\'手机\' and TuiJian>0 and ModelClassID like \'%,' . $v . ',%\'');
                        for ($i = 0; $i < count($linshi); $i++) {
                            $cut[] = $linshi[$i]['ID'];
                            $count +=1;
                        }
                        $Type_array = array_merge($Type_array, $linshi);
                        if ($count >= $Number) {
                            break;
                        }
                    }
                }
            }
            //类别推荐结束
            //如果数量不够，进行补充
            $Add = array();
            if ($count < $Number) {
                $paichu = $cut ? implode(',', $cut) : '\'\'';
                $Add = $Model->GetListsAll('tb_model', ' where ID not in (' . $paichu . ') and Type=\'手机\' and TuiJian>0 order by rand() limit ' . ($Number - $count));
            }
            //补充结束

            $Type_array ? $ModelList = array_merge($ModelList, $Type_array) : NULL;
            $Add ? $ModelList = array_merge($ModelList, $Add) : NULL;
            $String = '';
            $count = 0;
            foreach ($ModelList as $Value) {
                if (!$Value['Url_status']) {
                    $Value['Url'] = '';
                    $Value['EWM'] = '';
                } else {
                    $tureUrl = trim($Value['Url'], 'http://');
                    $tureUrl = trim($tureUrl, 'G');
                    if ($tureUrl == trim($tureUrl, 'T')) {
                        if ($tureUrl == trim($tureUrl, 'P')) {
                            $Value['EWM'] = 'http://s.jiathis.com/qrcode.php?url=http://m.G' . $tureUrl;
                        } else {
                            $Value['EWM'] = 'http://s.jiathis.com/qrcode.php?url=http://G' . $tureUrl;
                        }
                    } else
                        $Value['EWM'] = 'http://s.jiathis.com/qrcode.php?url=http://G' . $tureUrl;
                }
                $Value['Pic'] = DAILI_DOMAIN . 'uploads/img_url/' . $Value['Pic'];
                $String .= '  <model>
				<id>' . $Value['ID'] . '</id>
				<no>' . $Value['NO'] . '</no>
				<title>' . $Value['Name'] . '</title>
				<color>' . $Value['Color'] . '</color>
				<star>' . $Value['BaiDuXingPing'] . '</star>
				<website>' . $Value['Url'] . '</website>
				<ewm>' . $Value['EWM'] . '</ewm>
				<sort>' . $Value['CName'] . '</sort>
				<tone>' . $Value['ZhuSeDiao'] . '</tone>
				<pl>' . $Value['Language'] . '</pl>
				<price>' . $Value['Price'] . '</price>
				<youhui>' . $Value['Youhui'] . '</youhui>
				<picture>' . $Value['Pic'] . '</picture>
				<time>' . $Value['AddTime'] . '</time>
				</model>
				';
                $count +=1;
                if ($count >= $Number) {
                    break;
                }
            }
            $String = '<?xml version="1.0" encoding="utf-8"?>
			<models>
			' . $String .
                    '  <page>
				<total>' . $count . '</total>
			  </page>
			</models>';
            echo $String;
            exit;
        } else {
            echo '参数错误';
            exit();
        }
    }

    //获取双站模版
    public function GetDoubleStModelList() {
        if ($this->_GET) {
            $SortGUID = trim($this->_GET['SortGUID']); //类别ID
            $Color = trim($this->_GET['Color']); //颜色
            $Sprice = trim($this->_GET['Sprice']);
            $Eprice = trim($this->_GET['Eprice']);
            $Keyword = trim($this->_GET['Keyword']); //关键字
            $Page = _intval($this->_GET['Page']); //当前页数
            $lang = trim($this->_GET['lang']);
            $lang = ($lang == 'en') ? 'EN' : 'CN';
            if ($Page == 0)
                $Page = 1;
            $Number = _intval($this->_GET['Number']); //每页显示数量
            if ($Number == 0)
                $Number = 1;
            $Where = ' where TuiJian>0';
            if ($Color)
                $Where .= ' and Color like \'%' . $Color . '%\'';
            if ($Keyword)
                $Where .= ' and Keyword=\'' . $Keyword . '\' or PackagesNum = \'' . $Keyword . '\'';
            if ($Sprice)
                $Where .= ' and Youhui>' . $Sprice;
            if ($Eprice)
                $Where .= ' and Youhui<' . $Eprice;
            if ($lang)
                $Where .= ' and ModelLan = \'' . $lang . '\'';
            $Model = new ModelModule();
            $Offset = ($Page - 1) * $Number;
            $ModelList = $Model->GetPackagesLists($Where, $Offset, $Number);
            $ModelListNun = $Model->GetPackagesListsNum($Where);
            $String = '';
            foreach ($ModelList as $Value) {
                $ModelPC = $Model->GetOneInfoByKeyID('\'' . $Value['PCNum'] . '\'', 'NO');
                $ModelPhone = $Model->GetOneInfoByKeyID('\'' . $Value['PhoneNum'] . '\'', 'NO');
                if ($SortGUID) {
                    if (!strstr($ModelPC['ModelClassID'], ',' . $SortGUID . ',') or !strstr($ModelPhone['ModelClassID'], ',' . $SortGUID . ',')) {
                        $ModelListNun['Num'] --;
                        continue;
                    }
                }
                if (!$Value['Url_status']) {
                    $Value['PCUrl'] = '';
                    $Value['EWM'] = '';
                } else {
                    $Value['EWM'] = 'http://s.jiathis.com/qrcode.php?url=' . $Value['PhoneUrl'];
                }
                $ModelPC['Pic'] = DAILI_DOMAIN . 'uploads/img_url/' . $ModelPC['Pic'];
                $ModelPhone['Pic'] = DAILI_DOMAIN . 'uploads/img_url/' . $ModelPhone['Pic'];
                $String .= '  <model>
				    <id>' . $Value['ID'] . '</id>
    				<no>' . $Value['PackagesNum'] . '</no>
				    <title>' . $Value['PackagesName'] . '</title>
				    <price>' . $Value['Price'] . '</price>
    				<youhui>' . $Value['Youhui'] . '</youhui>
				    <website>' . $Value['PCUrl'] . '</website>
				    <pcpicture>' . $ModelPC['Pic'] . '</pcpicture>
				    <mobilepicture>' . $ModelPhone['Pic'] . '</mobilepicture>
				    <ewm>' . $Value['EWM'] . '</ewm>
    				<time>' . $Value['AddTime'] . '</time>
				  </model>
				';
            }
            $String = '<?xml version="1.0" encoding="utf-8"?>
				<models>
				' . $String .
                    '  <page>
					<total>' . $ModelListNun['Num'] . '</total>
				  </page>
				</models>';
            echo $String;
            exit;
        } else {
            echo '参数错误';
            exit();
        }
    }

    //获取双站数据模型
    public function GetDoubleStModel() {
        $ModelID = _intval($this->_GET['ModelID']);
        $Model = new ModelModule();
        $ModelInfo = $Model->GetOnePackagesInfoByKeyID($ModelID);
        $ModelPC = $Model->GetOneInfoByKeyID('\'' . $ModelInfo['PCNum'] . '\'', 'NO');
        $ModelPhone = $Model->GetOneInfoByKeyID('\'' . $ModelInfo['PhoneNum'] . '\'', 'NO');
        $ModelClassID = explode(',', $ModelInfo['ModelClassID']);
        $ModelClass = new ModelClassModule();
        $ModelClassInfo = '';
        foreach ($ModelClassID as $val) {
            if ($val) {
                $CName = $ModelClass->GetOneInfoByKeyID($val);
                $ModelClassInfo .= $CName['CName'];
            }
        }
        if (!$ModelClassInfo) {
            $ModelClassInfo = '其他';
        }
        //上一篇
        $BackInfo = $Model->GetOneInfoPackagesByKeyIDBack($ModelID, ' and TuiJian>0');
        //下一篇
        $NextInfo = $Model->GetOneInfoPackagesByKeyIDzNext($ModelID, ' and TuiJian>0');
        $ModelInfo['Color'] = str_replace(',', ' ', $ModelInfo['Color']);
        if (!$ModelInfo['Url_status']) {
            $ModelInfo['PCUrl'] = '';
            $ModelInfo['EWM'] = '';
        } else {
            $ModelInfo['EWM'] = 'http://s.jiathis.com/qrcode.php?url=' . $ModelInfo['PhoneUrl'];
        }
        if (!$ModelInfo['Content']) {
            $ModelInfo['Content'] = '<![CDATA[<div align="center"><img width="100%" src="' . DAILI_DOMAIN . 'uploads/img_url/' . $ModelPC['Pic'] . '" /></div>
									<div align="center"><img width="50%" src="' . DAILI_DOMAIN . 'uploads/img_url/' . $ModelPhone['Pic'] . '" /></div>]]>';
        }
        $String .= '<?xml version="1.0" encoding="utf-8"?>
		<main>
		  <model>
			<id>' . $ModelInfo['ID'] . '</id>
			<no>' . $ModelInfo['PackagesNum'] . '</no>
			<title>' . $ModelInfo['PackagesName'] . '</title>
			<color>' . $ModelInfo['Color'] . '</color>
			<star>' . $ModelInfo['BaiDuXingPing'] . '</star>
			<descript>' . $ModelInfo['Descript'] . '</descript>
			<price>' . $ModelInfo['Price'] . '</price>
			<youhui>' . $ModelInfo['Youhui'] . '</youhui>
			<sort>' . $ModelClassInfo . '</sort>
			<tone>' . $ModelInfo['ZhuSeDiao'] . '</tone>
			<pl>' . $ModelInfo['Language'] . '</pl>
			<website>' . $ModelInfo['PCUrl'] . '</website>
			<time>' . $ModelInfo['AddTime'] . '</time>
			<prev>' . $BackInfo['ID'] . '</prev>
			<next>' . $NextInfo['ID'] . '</next>
			<ewm>' . $ModelInfo['EWM'] . '</ewm>
			<content>' . $ModelInfo['Content'] . '</content>
			<time>' . $ModelInfo['AddTime'] . '</time>
		  </model>
		</main>
		';
        echo $String;
        exit;
    }

    //获取双站模版
    public function GetDoubleStModelRead() {

        if ($this->_GET) {
            $Number = _intval($this->_GET['Number']); //每页显示数量
            if ($Number == 0)
                $Number = 1;
            $Where = ' where TuiJian>1';
            $Model = new ModelModule();
            //$Offset = ($Page - 1) * $Number;
            $ModelList = $Model->GetPackagesLists($Where, 0, $Number);
            $ModelListNun = $Model->GetPackagesListsNum($Where);
            $String = '';
            foreach ($ModelList as $Value) {
                $ModelPC = $Model->GetOneInfoByKeyID('\'' . $Value['PCNum'] . '\'', 'NO');
                $ModelPhone = $Model->GetOneInfoByKeyID('\'' . $Value['PhoneNum'] . '\'', 'NO');
                $ModelPC['Pic'] = DAILI_DOMAIN . 'uploads/img_url/' . $ModelPC['Pic'];
                $ModelPhone['Pic'] = DAILI_DOMAIN . 'uploads/img_url/' . $ModelPhone['Pic'];
                if (!$Value['Url_status']) {
                    $Value['PCUrl'] = '';
                    $Value['EWM'] = '';
                } else {
                    $Value['EWM'] = 'http://s.jiathis.com/qrcode.php?url=' . $Value['PhoneUrl'];
                }
                $String .= '  <model>
			    <id>' . $Value['ID'] . '</id>
			    <title>' . $Value['PackagesName'] . '</title>
			    <price>' . $Value['Price'] . '</price>
    			<youhui>' . $Value['Youhui'] . '</youhui>
			    <website>' . $Value['PCUrl'] . '</website>
			    <pcpicture>' . $ModelPC['Pic'] . '</pcpicture>
				<mobilepicture>' . $ModelPhone['Pic'] . '</mobilepicture>
				<ewm>' . $Value['EWM'] . '</ewm>
   				<time>' . $Value['AddTime'] . '</time>
			  </model>
			';
            }
            $String = '<?xml version="1.0" encoding="utf-8"?>
			<models>
			' . $String .
                    '  <page>
				<total>' . $ModelListNun['Num'] . '</total>
			  </page>
			</models>';
            echo $String;
            exit;
        } else {
            echo '参数错误';
            exit();
        }
    }

    //获取一次性的验证文件
    public function GetHandShake() {
        if ($this->_GET['num']) {
            $String = file_get_contents('./token/' . $this->_GET['num'] . '.dll');
            unlink('./token/' . $this->_GET['num'] . '.dll');
            if ($String) {
                echo $String;
                exit;
            } else {
                echo 1003;
                exit;
            }
        } else {
            echo '参数错误';
            exit();
        }
    }

    //获取优惠价
    public function GetCoupons() {
        if ($this->_GET['code']) {
            $code = $this->_GET['code'];
            $code = 'code=' . $code;
            if ($this->_GET['use']) {
                $code .= '&use=1';
            }
            $url = 'http://xm.erp.xm12t.net/tools/gbp.ashx';
            $Coupons = request_by_other($url, $code);
            die($Coupons);
        }
    }

}
