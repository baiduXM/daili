<div class="cont-left">
    <ul class="left-menu main">
        <li <?PHP if ($MyModule == 'Agent' && $MyAction == 'Customer') { ?>class="on"<?php } ?>>
            <a href="<?php echo UrlRewriteSimple('Agent', 'Customer', true); ?>">
                <i class="fa fa-all"></i>
                <span>首页</span>
            </a>
        </li>
        <!--<li id="child">
          <a>
            <i class="iconfont">&#xe669;</i>
            <span>客户管理</span>
          </a>
        </li>-->
        <li <?PHP if ($MyModule == 'Gbaopen' && $MyAction == 'Customer') { ?>class="on"<?php } ?>>
            <a href="<?php echo UrlRewriteSimple('Gbaopen', 'Customer', true); ?>">
                <i class="fa fa-similarproduct"></i>
                <span>客户管理</span>
            </a>
        </li>

        <li <?PHP if ($MyModule == 'Agent' && $MyAction == 'UserInfo') { ?>class="on"<?php } ?>>
            <a href="<?php echo UrlRewriteSimple('Agent', 'UserInfo', true); ?>">
                <i class="fa fa-supplierfeatures"></i>
                <span>用户中心</span>
            </a>
        </li>
        <?PHP if ($_SESSION['Level'] == 1) { ?>
            <li class="nav <?PHP if ($MyModule == 'Model') { ?>on<?php } ?>" action="model">
                <a href="javascript:;">
                    <i class="fa fa-rfq"></i>
                    <span>模板管理</span>
                </a>
            </li>
            <li <?PHP if ($MyModule == 'Agent' && $MyAction == 'Process') { ?>class="on"<?php } ?>>
                <a href="<?php echo UrlRewriteSimple('Agent', 'Process', true); ?>">
                    <i class="fa fa-process"></i>
                    <span>代理商管理</span>
                </a>
            </li>
        <?PHP } elseif ($_SESSION['Level'] == 2) { ?>
            <li <?PHP if ($MyModule == 'Agent' && $MyAction == 'Process') { ?>class="on"<?php } ?>>
                <a href="<?php echo UrlRewriteSimple('Agent', 'Process', true); ?>">
                    <i class="fa fa-onepage48"></i>
                    <span>客服管理</span>
                </a>
            </li>
            <li <?PHP if ($MyModule == 'Gbaopen' && $MyAction == 'Create') { ?>class="on"<?php } ?>>
                <a href="<?php echo UrlRewriteSimple('Gbaopen', 'Create', true); ?>">
                    <i class="fa fa-atm"></i>
                    <span>创建G宝盆客户</span>
                </a>
            </li>
        <?PHP } elseif ($_SESSION['Level'] == 3) { ?>
            <li <?PHP if ($MyModule == 'Gbaopen' && $MyAction == 'Create') { ?>class="on"<?php } ?>>
                <a href="<?php echo UrlRewriteSimple('Gbaopen', 'Create', true); ?>">
                    <i class="fa fa-atm"></i>
                    <span>创建G宝盆客户</span>
                </a>
            </li>
        <?PHP } ?>
        <li class="nav <?PHP if ($MyModule == 'Report') { ?>on<?php } ?>" action="report">
            <a href="javascript:;">
                <i class="fa fa-data"></i>
                <span>数据统计</span>
            </a>
        </li>
        <?PHP if ($_SESSION['Level'] == 2) { ?>
            <li <?PHP if ($MyModule == 'Gbaopen' && $MyAction == 'LogCost') { ?>class="on"<?php } ?>>
                <a href="<?php echo UrlRewriteSimple('Gbaopen', 'LogCost', true); ?>">
                    <i class="fa fa-calendar"></i>
                    <span>消费日志</span>
                </a>
            </li>
        <?PHP } ?>
    </ul>
    <div class="second-menu transition1">
        <p><i class="fa fa-close" style="cursor: pointer;"></i></p>
        <?PHP if ($_SESSION['Level'] == 1) { ?>
            <div class="model">
                <h1>模板服务</h1>
                <ul class="left-menu">
                    <li <?PHP if ($MyAction == 'Upload') { ?>class="on"<?php } ?>>
                        <a href="<?php echo UrlRewriteSimple('Model', 'Upload', true); ?>">
                            <span>上传模板</span>
                        </a>
                    </li>
                    <li <?PHP if ($MyAction == 'Operation') { ?>class="on"<?php } ?>>
                        <a href="<?php echo UrlRewriteSimple('Model', 'Operation', true); ?>">
                            <span>模板管理</span>
                        </a>
                    </li>
                    <li <?PHP if ($MyAction == 'CrePack') { ?>class="on"<?php } ?>>
                        <a href="<?php echo UrlRewriteSimple('Model', 'CrePack', true); ?>">
                            <span>添加双站</span>
                        </a>
                    </li>
                </ul>
            </div>
        <?PHP } ?>
        <div class="report">
            <h1>统计处理</h1>
            <ul class="left-menu">
                <li <?PHP if ($MyAction == 'CusStatistics') { ?>class="on"<?php } ?>>
                    <a href="<?php echo UrlRewriteSimple('Report', 'CusStatistics', true); ?>">
                        <span>客户统计</span>
                    </a>
                </li>
                <?PHP if ($_SESSION['Level'] == 1) { ?>
                <li <?PHP if ($MyAction == 'ModelStatistics') { ?>class="on"<?php } ?>>
                    <a href="<?php echo UrlRewriteSimple('Report', 'ModelStatistics', true); ?>">
                        <span>模板热度</span>
                    </a>
                </li>
                <?PHP } ?> 
                <?PHP if ($_SESSION['Level'] == 1||$_SESSION['Level'] == 2) { ?>
                <li <?PHP if ($MyAction == 'CostStatistics') { ?>class="on"<?php } ?>>
                    <a href="<?php echo UrlRewriteSimple('Report', 'CostStatistics', true); ?>">
                        <span>消费统计</span>
                    </a>
                </li>
                <?PHP } ?> 
                <li <?PHP if ($MyAction == 'ProStatistics') { ?>class="on"<?php } ?>>
                    <a href="<?php echo UrlRewriteSimple('Report', 'ProStatistics', true); ?>">
                        <span>行业热度</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>