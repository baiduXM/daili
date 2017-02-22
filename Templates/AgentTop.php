<div class="messagebox">
	<div class="info message">
		 <h3>提示</h3>
		 <p></p>
	</div>
	<div class="error message">
		 <h3>错误</h3>
		 <p></p>
	</div>
	<div class="warning message">
		 <h3>警告</h3>
		 <p></p>
	</div>
	<div class="success message">
		 <h3>成功</h3>
		 <p></p>
	</div>
</div>
<div class="mainTop">
    <div class="logo">
        <a href="" title="返回首页">
            <img src="Images/logo.png" alt=""></a>
    </div>
    <div class="topright" style="width: 1267px;">
        <div class="mini-menu fl"><i class="fa fa-back"></i>
        </div>
        <div class="top-box">
            <?php if($_SESSION['Level'] == 2){?>
            <div class="balance" style="display: inline;color: #fff;padding: 15px;">
                <i class="fa fa-dollar"></i>余额 : <span class="money">0</span>
            </div>
            <?php }?>
            <div class="toppublic login">
                <span><?php echo $Data['user']['contactemail'];?></span> <i class="fa fa-account"></i>
            </div>
            <div class="toppublic mag">
                <span>工单管理</span>
                <i class="fa fa-bussinesscard"></i>
            </div>
            <div class="toppublic msg">
                <i class="fa fa-comments"></i>
                消息（0）
            </div>
        </div>
    </div>
</div>
<div class='mainTip'>
    <div class="topTip">
        <span class="loginOut">退出</span>
    </div>
    <div class="mag-down">
        <a href="">问题管理</a>
        <a href="">在线提问问题管理</a>
    </div>
</div>