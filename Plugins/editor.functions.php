<?php
function HtmlEditor($FieldName, $Value, $Width = '100%', $Height = '300px'){
	global $__CKEDITOR_JS_LOAD_Status__;
	if(!$__CKEDITOR_JS_LOAD_Status__){
		$html_js='<script type="text/javascript" src="/Plugins/ckeditor/ckeditor.js"></script><script type="text/javascript" src="/Javascripts/editor.functions.js"></script>';
		$__CKEDITOR_JS_LOAD_Status__ = true;
	}
	$html = '<textarea name="' . $FieldName . '"  cols="45" rows="5" style="width:' . $Width . ';height:' . $Height . ';">' . htmlencode($Value) . '</textarea>';
	if($html_js)
		$html.=$html_js;
	$html.='<script language="javascript" type="text/javascript">HtmlEditor(\''.$FieldName.'\');</script>';
	return $html;
}
?>