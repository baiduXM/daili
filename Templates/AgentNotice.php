<?php include 'AgentHead.php'; ?>
<body>
    <div id="dialog-overlay"></div>
    <div id="dialog-box">
        <div class="dialog-content">
            <div id="dialog-message"></div>
            <a href="#" class="button dia-ok">确定</a>
            <a href="#" class="button dia-no">关闭</a>
        </div>
    </div>
    <div class="wrap">
        <?php include 'AgentTop.php'; ?>
        <?php include 'Agentleft.php'; ?>
        <div class="cont-right">
            <div class="mainBox">
                <div id="tab" class="nytab">
                    <div class="tabList">
                        <ul>
                            <li id='list' class="cur">公告列表</li>
                            <li id='edit' class="">发布公告</li>
                        </ul>
                    </div>
                    <div class="tabCon">
                        <div id='notice-list' class='cur'>
                            <form action="" id="listform">
                                <table border="0" cellspacing="0" cellpadding="0" width="100%" class="showbox">
                                    <tbody>
                                    <tr>
                                        <th class="text-left">标题</th>
                                        <th>是否展示</th>
                                        <th>修改时间</th>
                                        <th class="text-right" width="25%">操作/管理</th>
                                    </tr>
                                    </tbody>
                                    <tbody id="listtbody">
                                    <?php foreach ($notice as $val) { ?>
                                        <tr>
                                            <td class="text-left"><?php echo $val['title'] ?></td>
                                            <td class="enfont"><?php echo $val['is_on']?'是':'否' ?></td>
                                            <td class="enfont"><?php echo $val['updatetime'] ?></td>
                                            <td class="text-right pop">
                                                <a href="javascript:;" class="modify">修改</a>
                                                <a href="javascript:;" class="delete">删除</a>
                                            </td>
                                            <input type="hidden" value="<?php echo $val['id']; ?>">
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </form>
                            <div class="pagebox">
                                <div class="paging">
                                    <a class="pageprev" href="javascript:;"></a>
                                    <?php for ($i = 1; $i <= ceil($nnum / 8); $i++) {
                                        if ($i == 1) echo '<a class="num pon" href="javascript:;">' . $i . '</a>';
                                        elseif ($i > 5) echo '<a class="num" href="javascript:;" style="display:none">' . $i . '</a>';
                                        else echo '<a class="num" href="javascript:;">' . $i . '</a>';
                                    } ?>
                                    <a class="pagenext" href="javascript:;"></a>
                                </div>
                            </div>
                        </div>
                        <div id='notice-edit' class="notice-edit">
                            <div class="shbox" style='margin-left: 100px;padding-bottom: 10px;'>
                                <div>
                                    <span>
                                        <input type="hidden" name='id' value=''>
                                        <input type="hidden" name='uid' value=''>
                                    </span>
                                </div>
                                <div style='padding-top: 15px;padding-bottom: 15px;'>
                                    <span style='font-size: 12pt;'>标题</span>
                                    <span>
                                        <input type="input" name="title" style='height: 20px;width: 400px;' value="">
                                    </span>
                                </div>
                                <div style='padding-top: 15px;padding-bottom: 15px;'>
                                    <span style='font-size: 12pt;'>是否展示</span>
                                    <span class="Input">
                                        <input type="radio" name="is_on" value="1" checked>是
                                        <input type="radio" name="is_on" value="0">否
                                    </span>
                                </div>                                
                                <!-- 编辑器 -->
                                <script id="editor" type="text/plain" style="width:1024px;height:500px;"></script>
                                <script type="text/javascript">
                                    //实例化编辑器
                                    var ue = UE.getEditor('editor');
                                </script>
                                <div style='position: absolute;right:550px;bottom: 156px;font-size: 12pt;color: red;'>*暂不支持上传图片到统一平台</div>
                            </div>
                            <div class="btnDD">
                                <input type="submit" class="Btn1" value="提交">
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

</body>
<?php include 'AgentFoot.php'; ?>