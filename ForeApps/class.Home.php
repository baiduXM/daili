<?php

class Home extends ForeVIEWS {

    public function Index() {
        /* 暂时作为代理商首页 */
        $lemma = './Data/Config/LoginLemma.ini';
        $this->ImageData = parse_ini_file($lemma, true);
    }

    /* 代理商登陆验证 */
    public function Login() {
        if ($this->_POST) {
            $Post ['UserName'] = trim($this->_POST ['UserName']);
            $PassWord = trim($this->_POST ['PassWord']);
            if (strlen($Post ['UserName']) < 3) {
                JsMessage('用户名错误!');
            } elseif (strlen($PassWord) < 6) {
                JsMessage('密码错误!');
            }
            $accountModule = new AccountModule ();
            $LogsFunction = new LogsFunction();
            $Post ['PassWord'] = md5($PassWord);
            $AgentInfo = $accountModule->GetOneInfoByArrayKeys($Post);
            if (empty($AgentInfo)) {
                $LogsFunction->LogsAgentRecord(100, 0);
                JsMessage('用户不存在或者用户名密码错误!');
            } else {
                $agentModule = new BalanceModule();
                $agent = $agentModule->GetListsOneByAgentID(array('Power'), $AgentInfo['AgentID']);
                $AgentInfo['Power'] = $agent['Power'];
                $time = date("Y-m-d H:i:s");
                $accountModule->UpdateArrayByKeyID(array('LastTime' => $AgentInfo['NowTime'], 'NowTime' => $time), $AgentInfo['AgentID']);
                $this->SetSession($AgentInfo);
                $LogsFunction->LogsAgentRecord();
                if ($AgentInfo['AgentID'] == 45)
                    JsMessage('登陆成功!', UrlRewriteSimple('Gbaopen', 'ToOne'));
                else
                    JsMessage('登陆成功!', UrlRewriteSimple('Agent', 'Customer'));
            }
        }
        exit();
    }

    /* 代理商安全退出登陆 */

    public function Quit() {
        $this->UnsetSession();
        JsMessage('安全退出!', UrlRewriteSimple('Home', 'Index', true));
    }

    /* 代理商登陆成功赋值SESSION */

    public function SetSession($AgentInfo = array()) {
        if (empty($AgentInfo)) {
            return FALSE;
        }
        $_SESSION ['AgentID'] = $AgentInfo ['AgentID'];
        $_SESSION ['UserName'] = $AgentInfo ['UserName'];
        $_SESSION ['Power'] = $AgentInfo ['Power'];
        $_SESSION ['Level'] = $AgentInfo ['Level'];
        return TRUE;
    }

    /* 代理商安全退出成功清除SESSION */

    public function UnsetSession() {
        $_SESSION ['AgentID'] = '';
        $_SESSION ['UserName'] = '';
        $_SESSION ['Power'] = '';
        $_SESSION ['Level'] = '';
        unset($_SESSION ['AgentID'], $_SESSION ['UserName'], $_SESSION ['Power'], $_SESSION ['Level']);
        session_destroy();
        return TRUE;
    }

}
