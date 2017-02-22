<?php
/*
 ExpressPHP Template Compiler 3.0.0 beta
 compiled from extframe-js.htm at 2010-01-07 01:47:01 Asia/Shanghai
*/
?><script type="text/javascript">
function ExtFrame(){
	var obj = $(window.top.document).find('frameset[id=frameset]');
	if(obj)
		obj.attr('rows','60%,*');
}
function ExtFrameClose(){
	var obj = $(window.top.document).find('frameset[id=frameset]');
	var SubFrame = $(window.top.document).find('frame[id=SubFrame]');
	if(obj)
		obj.attr('rows','*,0');
	if(SubFrame)
		SubFrame.attr('src','about:blank');
	
}
function MainFrameReload(){
	window.top.frames['mainFrame'].location.reload();
}
</script>