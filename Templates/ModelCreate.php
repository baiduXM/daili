<?php include 'AgentHead.php';?>
<body>
    <style>
        .record{
            width:400px;
            height:200px;
            margin:auto;
            border: 2px solid #1B9DD9;
            overflow: hidden;
            -webkit-box-shadow: 10px 10px 25px #9CC;
            -moz-box-shadow: 10px 10px 25px #9CC;
            box-shadow: 10px 10px 25px #9CC;
            -moz-border-radius:0 0 7px 7px;
            -webkit-border-radius:7px 7px 7px 7px;
            border-radius:7px 7px 7px 7px;
        }
        .con{
            margin-left: 20px;
            margin-top: 10px;
            color:red;
            font-size: 17px;
            line-height: 20px;
        }
    </style>
    <script src="Javascripts/ajaxfileupload.js"></script>
        <script type="text/javascript">
        $(function () {
            $("#upload").click(function () {
                ajaxFileUpload();
            })
        })
        function ajaxFileUpload() {
            $.ajaxFileUpload
            (
                {
                    url: './?module=Agent&action=FileUpload&r=705708977', //用于文件上传的服务器端请求地址
                    secureuri: false, //是否需要安全协议，一般设置为false
                    fileElementId: 'file1', //文件上传域的ID
                    success: function (data, status)  //服务器成功响应处理函数
                    {
                        $("#img1").attr("src", data.imgurl);
                        if (typeof (data.error) != 'undefined') {
                            if (data.error != '') {
                                alert(data.error);
                            } else {
                                alert(data.msg);
                            }
                        }
                    },
                    error: function (data, status, e)//服务器响应失败处理函数
                    {
                        console.log(e);
                    }
                }
            )
            return false;
        }
    </script>
<div id="dialog-overlay"></div>
<div id="dialog-box">
 <div class="dialog-content">
  <div id="dialog-message"></div>
  <a href="#" class="button dia-ok">确定</a>
  <a href="#" class="button dia-no">关闭</a>
 </div>
</div>
<div class="wrap">
   <?php include 'AgentTop.php';?>
   <?php include 'Agentleft.php';?>
   <div class="cont-right">
      <div class="mainBox">
           <div class="crelist">
                <div class="userdata-content">
                     <p>
                        <span class="content-l">选择客户</span>
                        <span>
                            <input type="file" id="file1" name="file" /></p>
    <input type="button" id="upload" value="上传" />
                        </span>
                    </p>
                </div>
               <div class="record">
                   <p class="con">正在压缩HTML文件....<p>
                   <p class="con">正在压缩HTML文件....<p>
                   <p class="con">正在压缩图片文件....<p>
               </div>
               <div style="height:20px;"></div>
       </div>
   </div>
</div>
</div>
</body>
<?php include 'AgentFoot.php';?>