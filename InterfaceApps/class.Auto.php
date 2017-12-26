<?php

/**
 * Date: 2017/12/07
 * Function: 任务计划，自动执行
 * 循环调用接口 或 全部数据一次性发送给接口 ？
 */


class Auto extends InterfaceVIEWS {
	public function AutoTest() {
		$date = date('Y-m-d H:i:s' , time());
		file_put_contents('auto.txt' , $date.PHP_EOL , FILE_APPEND);
		return 'hello world';
	}

	//用户过期处理
	public function AutoDelete() {
        set_time_limit(0);
		//返回
		$result = array('err' => 0, 'data' => '', 'msg' => '');
		//获取过期用户
		$cuspro = new CustProModule();
        $cusinfo = new CustomersModule ();
		//搜索列：账号名，客户id，套餐类型，PC过期时间，手机过期时间
		$lists = array('G_name' , 'CustomersID' , 'CPhone' , 'PC_EndTime' , 'Mobile_EndTime' , 'PC_domain' , 'Mobile_domain');
		//当前时间
		$now = date('Y-m-d H:i:s' , time());

		$where = ' where (PC_EndTime<"' . $now . '" or Mobile_EndTime<"' . $now . '")  and status=1 ';
		$data = $cuspro->GetListsByWhere($lists , $where);

        foreach ($data as $k => $v) {
        	if($v['CPhone'] == 1) {//PC站
        		if($v['PC_EndTime'] < $now){//是否是PC过期
        			$site[$k]['name'] = $v['G_name'];
        			$site[$k]['type'] = 0;
        		} else {
                    //退出本次循环，进入下一次，避免空数据调用接口
                    continue;
                }        		
        	} elseif ($v['CPhone'] == 2) {//手机站
        		if($v['Mobile_EndTime'] < $now) {//是否是手机过期
        			$site[$k]['name'] = $v['G_name'];
        			$site[$k]['type'] = 0;
        		}  else {
                    continue;
                }        		
        	} elseif($v['CPhone'] == 3 or $v['CPhone'] == 4) {//双站
        		if($v['PC_EndTime'] < $now and $v['Mobile_EndTime'] < $now) {//都过期
        			$site[$k]['name'] = $v['G_name'];
        			$site[$k]['type'] = 0;
        		} elseif ($v['PC_EndTime'] < $now and ($v['Mobile_EndTime'] >= $now or !$v['Mobile_EndTime'])) {//PC过期
        			$site[$k]['name'] = $v['G_name'];
        			$site[$k]['type'] = 1;
        		} elseif(($v['PC_EndTime'] >= $now or !$v['PC_EndTime']) and $v['Mobile_EndTime'] < $now) {//手机过期
        			$site[$k]['name'] = $v['G_name'];
        			$site[$k]['type'] = 2;
        		} else {
                    continue;
                }
        	}

            $res = $this->delApi($site[$k]);
            if($res['err'] == 1000) {
                //修改数据库数据
                switch ($site[$k]['type']) {
                    case 0:
                        $arr['status'] = 0;
                        $res1 = $cuspro->UpdateArray($arr, array("CustomersID" => $v['CustomersID']));
                        $res2 = $cusinfo->UpdateArray($arr, array("CustomersID" => $v['CustomersID']));
                        break;
                    case 1:
                        $arr['CPhone'] = 2;
                        $arr['pc_out_domain'] = $v['PC_domain'];
                        $arr['PC_domain'] = '';
                        $res1 = $cuspro->UpdateArray($arr, array("CustomersID" => $v['CustomersID']));
                        break;
                    case 2:
                        $arr['CPhone'] = 1;
                        $arr['mobile_out_domain'] = $v['Mobile_domain'];
                        $arr['Mobile_domain'] = '';
                        $res1 = $cuspro->UpdateArray($arr, array("CustomersID" => $v['CustomersID']));
                        break;
                }
            }
            $root = DocumentRoot.'/../';
            if (!is_dir($root.'dl-log'))
                mkdir($root.'dl-log/');
            if (!is_dir($root.'dl-log/delete'))
                mkdir($root.'dl-log/delete');
            //日志记录
            $str = "[". $site[$k]['name'] ."]\r\n";
            $str .= "删除类型：". $site[$k]['type'] .";\r\n";
            $str .= "返回码：" . $res['err'] . ";\r\n";
            $str .= "返回信息：" . $res['msg'] . ";\r\n";
            $str .= "cuspro表执行：" . $res1 . ";\r\n";
            if(isset($res2)) {
                $str .= "customer表执行：" . $res2 . ";\r\n";
            }
            $str .= "时间：" . date('H:i:s' , time()) . ";\r\n";
            
            @file_put_contents($root.'dl-log/delete/'.date('Y-m-d').'.txt', $str.PHP_EOL,FILE_APPEND);
        }        
	}

    //自动删除接口
    public function delApi($site) {
        //统一平台自动删除接口
        $TuUrl = GBAOPEN_DOMAIN . 'api/deleteAuto';

        //随机文件名开始生成
        $randomLock = getstr();
        $password = md5($randomLock);
        $password = md5($password);

        //生成握手密钥
        $text = getstr();

        //生成dll文件
        $myfile = @fopen('./token/' . $password . '.dll', "w+");
        if (!$myfile) {
            return 0;
        }
        fwrite($myfile, $text);
        fclose($myfile); 
        
        //发送数据
        $post_data = array(
            'name' => $site['name'],
            'type' => $site['type'],
            'timemap' => $randomLock,
            'taget' => md5($text . $password)
        );

        $ReturnString = curl_post($TuUrl, $post_data, 0);

        $ReturnArray = json_decode($ReturnString, true);

        return $ReturnArray;
    }
}