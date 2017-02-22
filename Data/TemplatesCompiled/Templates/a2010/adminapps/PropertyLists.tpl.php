<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from PropertyLists.htm at 2016-01-12 15:05:06 Asia/Shanghai
*/
?><br style="display:none"/>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><?php $this->Display("header"); ?><style type="text/css">
<!--
@import url("/Templates/a2010/adminapps/images/style.css");
-->
</style>
<script type="text/javascript" src="ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="ueditor/ueditor.all.min.js"></script>
<script type="text/javascript">  
var editor = new UE.ui.Editor();  
textarea:'ModelContent'; //与textarea的name值保持一致  
editor.render('ModelContent');
</script>
</head>

<body><?php if($Model) { ?><form action="<?php echo UrlRewriteSimple('Property','Add',true); ?>"
	method="post" enctype="multipart/form-data" name="form1" id="form1">
<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">修改属性</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
   <table width="100%" border="0" cellspacing="1" cellpadding="5" class="DataGird">
  <tbody>
  <tr>
    <td colspan="2">&nbsp;&nbsp; &nbsp;&nbsp; 产品名称：<input name="ProjectName" type="text" class="input-style"
			id="ProjectName" maxlength="64" readonly="readonly" value="<?php echo $ProjectInfo[ProjectName];?>" />
            <input type="hidden" name="ProjectID" id="ProjectID" value="<?php echo $ProjectInfo[ProjectID];?>" />
    </td>
    <td width="67%"> 上级属性：
      <select name="ProjectPropertyParentID" id="ProjectPropertyParentID">
        <option value="0" <?php if($ProjectPropertyInfo[ProjectPropertyParentID]==0) { ?>selected<?php } ?>>聚宝盆</option>
      </select></td>
    </tr>
  
    
      <?php if($Model[NO]) { ?><tr><td colspan="2">&nbsp;&nbsp; &nbsp;&nbsp; 属性编码：<input name="NO" type="text" class="input-style" readonly="readonly"  id="NO" value="<?php echo $Model[NO];?>"/></td>
      </tr><tr><td colspan="4">&nbsp;&nbsp; &nbsp;&nbsp; 模板名称：<input name="Name" type="text" class="input-style" id="Name" value="<?php echo $Model[Name];?>"/>
      &nbsp;&nbsp; &nbsp;&nbsp; 模板描述：<input name="Descript" type="text" class="input-style" id="Descript" value="<?php echo $Model[Descript];?>"/>
      &nbsp;&nbsp; &nbsp;&nbsp; 关键字：<input name="Keyword" type="text" class="input-style" id="Keyword" value="<?php echo $Model[Keyword];?>"/></td>
      </tr>
      <tr><td colspan="4">&nbsp;&nbsp; &nbsp;&nbsp; 
  推荐其他可组合的模板:
  <input type="text" name="Model_Array" class="input-style" id="Model_Array" value="<?php echo $Model['TJArray'];?>" />
  <label style="color:red;" >&nbsp;&nbsp; &nbsp;&nbsp; （格式示例：GM0001,GM0002,GM0003,...）</label>
  </td></tr>
      <tr><td colspan="2">&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;模板网址：
	  <label><input name="URL_status" type="checkbox" value="1" <?php if($Model[Url_status]) { ?>checked<?php } ?> />实例启用</label>
<input name="URL" type="text" class="input-style" value="<?php echo $Model[Url];?>"/>
</td></tr>
      <tr>  <td colspan="4">&nbsp;&nbsp; &nbsp;&nbsp;百度星评： &nbsp;&nbsp;<input <?php if($Model['BaiDuXingPing']) { ?>value="<?php echo $Model['BaiDuXingPing'];?>"<?php } else { ?>value="3"<?php } ?> name="ModelStar" type="number" min=0 max=5 step=0.5 >
    &nbsp;&nbsp; &nbsp;&nbsp;模板设置:<select name="TuiJian" class="input-style">
  <option value ="0" <?php if($Model[TuiJian]==0) { ?>selected<?php } ?>>不启用</option>
  <option value ="1" <?php if($Model[TuiJian]==1) { ?>selected<?php } ?>>启用</option>
  <option value ="2" <?php if($Model[TuiJian]==2) { ?>selected<?php } ?>>推荐到首页</option>
</select></td>
    </tr>
      <?php } else { ?>      <tr><td colspan="3">&nbsp;&nbsp; &nbsp;&nbsp; 属性名称：<input name="PackagesNum" type="text" class="input-style" readonly="readonly"  id="PackagesNum" value="<?php echo $Model[PackagesNum];?>"/>&nbsp; &nbsp; =&nbsp; &nbsp; 
      <input name="PCNum" type="text" class="input-style" readonly="readonly"  id="PCNum" value="<?php echo $Model[PCNum];?>"/>&nbsp; &nbsp;+&nbsp; &nbsp;
      <input name="PhoneNum" type="text" class="input-style" readonly="readonly"  id="PhoneNum" value="<?php echo $Model[PhoneNum];?>"/>
      &nbsp;&nbsp; &nbsp;&nbsp;推荐:<select name="TuiJian" class="input-style">
  <option value ="0" <?php if($Model[TuiJian]==0) { ?>selected<?php } ?>>不启用</option>
  <option value ="1" <?php if($Model[TuiJian]==1) { ?>selected<?php } ?>>启用</option>
  <option value ="2" <?php if($Model[TuiJian]==2) { ?>selected<?php } ?>>推荐到首页</option>
</select>
      </td></tr>
	  <tr><td>&nbsp;&nbsp; &nbsp;&nbsp; 套餐描述：<input name="Descript" type="text" class="input-style" value="<?php echo $Model[Descript];?>"/></td></tr> 
	  <tr><td>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;PC网址：
<input name="PCURL" type="text" class="input-style" value="<?php echo $Model[PCUrl];?>"/>
&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;手机网址：
<input name="PhoneURL" type="text" class="input-style" value="<?php echo $Model[PhoneUrl];?>"/>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
<label><input name="URL_status" type="checkbox" value="1" <?php if($Model[Url_status]) { ?>checked<?php } ?> />实例启用</label>
</td></tr>
      <?php } ?>      <tr><td colspan="4">&nbsp;&nbsp; &nbsp;&nbsp; 
  模板类别:&nbsp;&nbsp;
  
<?php $__view__data__0__=$ModelClassLists;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $type) { ?>
  <input name="ModelType[]" class="input-style" type="checkbox" value ="<?php echo $type['ID'];?>" <?php if(strstr($Model['ModelClassID'],','.$type['ID'].',')) { ?>checked <?php } ?>><?php echo $type['CName'];?>  
<?php } } ?>
 </td></tr>
      <tr>
    <td>&nbsp;&nbsp; &nbsp;&nbsp; 市场价格：
      <input name="MarketPrice" type="text" class="input-style" id="MarketPrice" value="<?php echo $Model[Price];?>"/>
		 &nbsp;&nbsp; &nbsp;&nbsp;优惠价：
      <input name="YouhuiPrice" type="text" class="input-style" id="YouhuiPrice" value="<?php echo $Model[Youhui];?>"/>
      &nbsp;&nbsp;（市场价、优惠价和代理价都单位都是人民币：元）</td>
  </tr>
  <tr><td>&nbsp;&nbsp; &nbsp;&nbsp; 模板特色：<textarea name="ModelTese" cols="100" rows="5" class="input-style" id="ModelTese"><?php echo $Model[ModelTese];?></textarea></td></tr>
  <tr><td>&nbsp;&nbsp; &nbsp;&nbsp; 展示内容：<textarea name="ModelContent" id="ModelContent"><?php echo $Model[Content];?></textarea></td></tr>
  <tr>
    <td colspan="2">&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; <input
	name="button" type="submit" class="btn" id="button" value=" 修 改 " />&nbsp;&nbsp;
      <input
	name="button2" type="reset" class="btn" id="button2" value=" 重 置 " /></td>
    <td>&nbsp;</td>
  </tr>
  </tbody>
</table>
        </div>
      </div>
    </div>
  </div>
  <div class="panel-footer">
    <div class="panel-footer-left"></div>
    <div class="panel-footer-right"></div>
  </div>
</div>
 <div style="line-height:50px;" class="font-12px">
 </div>   
</form><?php } if($State==1) { ?><form action="<?php echo UrlRewriteSimple('Property','Uploadfile',true); ?>"
	method="post" enctype="multipart/form-data" name="form1" id="form1">
<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">添加模板</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
   <table width="100%" border="0" cellspacing="1" cellpadding="5" class="DataGird">
  <tbody>
  <tr>
  <td colspan="2">
  要覆盖的模板编号:
  <input type="text" name="Modelname" class="input-style" id="Modelname" />
  </td>
  </tr>
 <tr>
  <td colspan="4">
  推荐其他可组合的模板:
  <input type="text" name="Model_Array" class="input-style" id="Model_Array" />
  <label style="color:red;" >&nbsp;&nbsp; &nbsp;&nbsp; （格式示例：GM0001,GM0002,GM0003,...）</label>
  </td>
  </tr>
  <tr>
  <td colspan="2">
 模板上传:
<input type="file" name="file[]"/> &nbsp;&nbsp;<label style="color:red;" >（模板请压缩成zip压缩包）</label>
</td>
</tr>
<tr><td>市场价：
<input name="Price" type="text" class="input-style"/>
&nbsp;&nbsp; &nbsp;&nbsp;优惠价：
<input name="Youhui" type="text" class="input-style"/>
</td></tr>
<tr><td colspan="4">&nbsp;&nbsp;
  模板类别:&nbsp;&nbsp;
  
<?php $__view__data__0__=$ModelClassLists;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $type) { ?>
  <input name="ModelType[]" class="input-style" type="checkbox" value ="<?php echo $type['ID'];?>" <?php if(strstr($Model['ModelClassID'],','.$type['ID'].',')) { ?>checked <?php } ?>><?php echo $type['CName'];?>  
<?php } } ?>
 </td></tr>
<tr>
  <td colspan="4">&nbsp;&nbsp;百度星评： &nbsp;&nbsp;<input value="3" name="ModelStar" type="number" min=0 max=5 step=0.5 >
  &nbsp;&nbsp; &nbsp;&nbsp;推荐:<select name="TuiJian" class="input-style">
  <option value ="0">不启用</option>
  <option value ="1" selected>启用</option>
  <option value ="2">推荐到首页</option>
</select>
  </td>
  </tr>
<tr><td>模板特色：<textarea name="ModelTese" cols="100" rows="5" class="input-style"></textarea></td></tr>
<tr><td><label style="color:red;" ><strong>注意：模板批量报价和 模板上传必须有一个不为空！！！</strong></label></td>
</tr>
  <tr><td>模板批量报价
<input type="file" name="file[]"/> &nbsp;&nbsp;<label style="color:red;" >（上传后缀为.csv的文件）</label>
</td></tr>
<tr><td>展示内容：<textarea name="ModelContent" id="ModelContent"></textarea></td></tr>
<tr><td>
<input type="submit" name="submit2" value="提交" />
  </td>
  </tr>
  </tbody>
  </table>
  </div>
  </div>
  </div>
  </div>
  </div>
  </form><?php } if($State==2) { ?><form action="<?php echo UrlRewriteSimple('Property','Uploadfile',true); ?>"
	method="post" enctype="multipart/form-data" name="form1" id="form1">
<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">添加套餐</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
   <table width="100%" border="0" cellspacing="1" cellpadding="5" class="DataGird">
  <tbody>
    <tr>
<td colspan="3">&nbsp;&nbsp; &nbsp;&nbsp; 套餐命名：
	  <input name="PackagesName" type="text" class="input-style"  id="PackagesNum"/>
	  &nbsp;&nbsp; &nbsp;&nbsp;推荐:<select name="TuiJian" class="input-style">
  <option value ="0">不启用</option>
  <option value ="1" selected>启用</option>
  <option value ="2">推荐到首页</option>
</select>
&nbsp;&nbsp; &nbsp;&nbsp; 套餐描述：<input name="Descript" type="text" class="input-style" value="<?php echo $Model[Descript];?>"/></td>
  </tr>
  <tr>
<td colspan="4">&nbsp;&nbsp; &nbsp;&nbsp; 属性名称：
	  <input name="PackagesNum" type="text" class="input-style"  id="PackagesNum"/>&nbsp; &nbsp; =&nbsp; &nbsp; 
      <input name="PCNum" type="text" class="input-style"  id="PCNum"/>&nbsp; &nbsp;+&nbsp; &nbsp;
      <input name="PhoneNum" type="text" class="input-style"  id="PhoneNum"/>
  	  <label style="color:red;" >&nbsp;&nbsp; &nbsp;&nbsp; （示例:GT0001=GP0001+GM0001 ）</label>
</td>
  </tr>
  <tr><td>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;PC网址：
<input name="PCURL" type="text" class="input-style" value="<?php echo $Model[PCUrl];?>"/>
&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;手机网址：
<input name="PhoneURL" type="text" class="input-style" value="<?php echo $Model[PhoneUrl];?>"/>
</td></tr>
  <tr>
  <td>
  </td>
  </tr>
  <tr>
    <td>市场价格：
      <input name="MarketPrice" type="text" class="input-style" id="MarketPrice"/>
		 &nbsp;&nbsp; &nbsp;&nbsp;优惠价：
      <input name="YouhuiPrice" type="text" class="input-style" id="YouhuiPrice"/>
      &nbsp;&nbsp;（市场价、优惠价和代理价都单位都是人民币：元）</td>
  </tr>
  <tr><td>模板特色：<textarea name="ModelTese" cols="100" rows="5" class="input-style" id="ModelTese"></textarea></td></tr>
<tr><td>展示内容：<textarea name="ModelContent" id="ModelContent"></textarea></td></tr>
<tr><td>
<input type="submit" name="submit3" value="提交" />
  </td>
  </tr>
  </tbody>
  </table>
  </div>
  </div>
  </div>
  </div>
  </div>
  </form><?php } ?><div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">属性管理</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
   <table width="100%" border="0" cellspacing="1" cellpadding="5" class="DataGird">
  <tr>
    <th width="217"  align="left" class="vertical-line">属性名称</th>
    <th width="139"  align="left" class="vertical-line">产品名称</th>
	<th width="128" class="vertical-line">开启状态</th>
	<th width="128" class="vertical-line">实例预览</th>
    <th width="120" class="vertical-line">市场价</th>
    <?php if($ProjectID==1) { ?><th width="120" class="vertical-line">优惠价</th><?php } ?>    <th width="182" class="vertical-line">代理价</th>
<th width="120">操作</th>
  </tr>
  <tbody>
  <?php if($ProjectID==1) { ?>  <tr>
  	<td><span>&nbsp;聚宝盆模板</span></td>
  	<td>&nbsp;<?php echo $ProjectInfo[ProjectName];?></td>
  	<td align="center">&nbsp;--</td>
  	<td align="center">&nbsp;--</td>
  	<td align="center">&nbsp;--</td>
  	<td align="center">&nbsp;--</td>
  	<td align="center">&nbsp;--</td>
  	<td align="center"><a href="<?php echo UrlRewriteSimple($MyModule,'Lists',true); ?>&ProjectID=1&State=1">添加模板</a> / <a href="<?php echo UrlRewriteSimple($MyModule,'Lists',true); ?>&ProjectID=1&State=2}">添加套餐</a></td>
  </tr>
	  
<?php $__view__data__0__=$Data;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
	  <tr>
	  <td><span <?php if($list[Pic]) { ?>data-img="uploads/img_url/<?php echo $list[Pic];?>"<?php } ?>>&nbsp;
	  <?php if($list[NO]) { echo $list[NO];?><?php } else { echo $list[PackagesNum];?>&emsp;&emsp;&emsp;<?php echo $list[PCNum];?>+<?php echo $list[PhoneNum];?><?php } ?></span></td>
	  <td>&nbsp;<?php echo $ProjectInfo[ProjectName];?></td>
	  <td align="center">&nbsp;<?php if($list[TuiJian] == 0) { ?>不启用<?php } elseif($list[TuiJian] == 1) { ?>启用<?php } else { ?>推荐到首页<?php } ?></td>
	  <td align="center">&nbsp;<?php if($list[Url_status]) { ?>开启<?php } else { ?>关闭<?php } ?></td>
	  <td align="center">&nbsp;<?php echo $list[Price];?></td>
	  <td align="center">&nbsp;<?php echo $list[Youhui];?></td>
	  <td align="center">&nbsp;市场价*用户所代理级别的折扣</td>
	  <td align="center"><a href="<?php echo UrlRewriteSimple($MyModule,'Lists',true); ?>&ProjectID=<?php echo $ProjectID;?>&NO=<?php if($list[NO]) { echo $list[NO];?><?php } else { echo $list[PackagesNum];?><?php } ?>">修改</a></td>
	  </tr>
	   
<?php } } ?>
  <?php } else { ?>  
<?php $__view__data__0__=$Data;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $list) { ?>
  <tr>
    <td><span>&nbsp;<?php echo $list[ProjectPropertyName];?></span></td>
    <td>&nbsp;<?php echo $ProjectInfo[ProjectName];?></td>
    <td align="center">&nbsp;--</td>
    <td align="center">&nbsp;--</td>
    <td align="center" ><a href="<?php echo UrlRewriteSimple($MyModule,'Lists',true); ?>&ProjectID=<?php echo $list[ProjectID];?>&ProjectPropertyID=<?php echo $list[ProjectPropertyID];?>">编辑</a>&nbsp;&nbsp;
      <!--<a href="<?php echo UrlRewriteSimple($MyModule,'Delete',true); ?>&ProjectPropertyID=<?php echo $list[ProjectPropertyID];?>&ProjectID=<?php echo $ProjectInfo['ProjectID'];?>">删除</a>&nbsp;&nbsp;-->    </td>
  </tr>
          
<?php $__view__data__1__=$list[Two];if(is_array($__view__data__1__)) { foreach($__view__data__1__ as $ListTwo) { ?>
          <tr style="color:#777777;">
            <td>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $ListTwo[ProjectPropertyName];?></td>
            <td>&nbsp;<?php echo $ProjectInfo[ProjectName];?></td>
            <td align="center">&nbsp;<?php echo $ListTwo[MarketPrice];?></td>
            <td align="center">&nbsp;市场价*用户所代理级别的折扣</td>
            <td align="center" >&nbsp;<a href="<?php echo UrlRewriteSimple($MyModule,'Lists',true); ?>&ProjectID=<?php echo $ListTwo[ProjectID];?>&ProjectPropertyID=<?php echo $ListTwo[ProjectPropertyID];?>">编辑</a>&nbsp;&nbsp;
              <!--<a href="<?php echo UrlRewriteSimple($MyModule,'Delete',true); ?>&ProjectPropertyID=<?php echo $ListTwo[ProjectPropertyID];?>&ProjectID=<?php echo $ProjectInfo['ProjectID'];?>">删除</a>&nbsp;&nbsp;--></td>
          </tr>
          
<?php } } ?>
  
<?php } } ?>
  </tbody>
  <?php } ?></table>
        </div>
      </div>
    </div>
  </div>
  <div class="panel-footer">
    <div class="panel-footer-left"></div>
    <div class="panel-footer-right"></div>
  </div>
</div>
 <div style="line-height:50px;" class="font-12px">

 </div>   <?php if($ProjectID!=1) { ?><form action="<?php echo UrlRewriteSimple('Property','Add',true); ?>"
	method="post" enctype="multipart/form-data" name="form1" id="form1">
<div class="panel">
  <div class="panel-header">
    <div class="panel-header-left"></div>
    <div class="panel-header-content">添加属性</div>
    <div class="panel-header-right"></div>
  </div>
  <div class="panel-body">
    <div class="panel-body-left">
      <div class="panel-body-right">
        <div class="panel-body-content">
   <table width="100%" border="0" cellspacing="1" cellpadding="5" class="DataGird">
  <tbody>
  <tr>
    <td colspan="2">&nbsp;&nbsp; &nbsp;&nbsp; 产品名称：<input name="ProjectName" type="text" class="input-style"
			id="ProjectName" maxlength="64" readonly="readonly" value="<?php echo $ProjectInfo[ProjectName];?>" />
            <input type="hidden" name="ProjectID" id="ProjectID" value="<?php echo $ProjectInfo[ProjectID];?>" />
            <input type="hidden" name="ProjectPropertyID" id="ProjectPropertyID" value="<?php echo $ProjectPropertyInfo[ProjectPropertyID];?>" /></td>
    <td width="67%"> 上级属性：
      <select name="ProjectPropertyParentID" id="ProjectPropertyParentID">
        <option value="0" <?php if($ProjectPropertyInfo[ProjectPropertyParentID]==0) { ?>selected<?php } ?>>顶级属性</option>
        
<?php $__view__data__0__=$ParentData;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $ParenList) { ?>
        <option value="<?php echo $ParenList[ProjectPropertyID];?>" <?php if($ProjectPropertyInfo[ProjectPropertyParentID]==$ParenList[ProjectPropertyID]) { ?>selected<?php } ?>><?php echo $ParenList[ProjectPropertyName];?></option>
        
<?php } } ?>
      </select></td>
    </tr>
  <tr>
    <td colspan="2">&nbsp;&nbsp; &nbsp;&nbsp; 属性名称：
      <input name="ProjectPropertyName" type="text" class="input-style" id="ProjectPropertyName" value="<?php echo $ProjectPropertyInfo[ProjectPropertyName];?>"/></td>
    <td>市场价格：
      <input name="MarketPrice" type="text" class="input-style" id="MarketPrice" value="<?php echo $ProjectPropertyInfo[MarketPrice];?>"/>
      &nbsp;&nbsp;（市场价和代理价都单位都是人民币：元）</td>
  </tr>
  <?php if($ProjectID==7) { ?>  <tr>
    <td width="9%">&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;固定服务：
      </td>
    <td colspan="2">
<?php $__view__data__0__=$FuWuList;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $FuWuL) { ?>
      <input name="MyFuWu[]" type="checkbox" id="checkbox2" value="<?php echo $FuWuL[FuWuID];?>" <?php if(strstr($MyFuWuString,','.$FuWuL[FuWuID].',')) { ?>checked<?php } ?>>
      <?php echo $FuWuL[FuWuName];?> 
<?php } } ?>
</td>
    </tr>
  <tr>
    <td>&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;可选服务：
    </td>
    <td colspan="2">
<?php $__view__data__0__=$FuWuList;if(is_array($__view__data__0__)) { foreach($__view__data__0__ as $FuWuL) { ?>
      <input name="OtherFuWu[]" type="checkbox" id="checkbox" value="<?php echo $FuWuL[FuWuID];?>" <?php if(strstr($OtherFuWuString,','.$FuWuL[FuWuID].',')) { ?>checked<?php } ?>><?php echo $FuWuL[FuWuName];?>
<?php } } ?>
</td>
    </tr>
  <?php } ?>  <tr>
    <td colspan="2">&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; <input
	name="button" type="submit" class="btn" id="button" value=" <?php if($ProjectPropertyInfo[ProjectPropertyID]>0) { ?>修 改<?php } else { ?>添 加<?php } ?>" />&nbsp;&nbsp; 
      <input
	name="button2" type="reset" class="btn" id="button2" value=" 重 置 " /></td>
    <td>&nbsp;</td>
  </tr>
  </tbody>
</table>
        </div>
      </div>
    </div>
  </div>
  <div class="panel-footer">
    <div class="panel-footer-left"></div>
    <div class="panel-footer-right"></div>
  </div>
</div>
 <div style="line-height:50px;" class="font-12px">
 </div>   
</form><?php } ?></body>
</html>