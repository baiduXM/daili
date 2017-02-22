CKEDITOR.plugins.add('xpic',{
    requires: ['iframedialog'],
    init:function(a){
        CKEDITOR.dialog.addIframe('xpic_dialog', '图像管理器',this.path+'dialogs/xpic.php','650','300',function(){/*oniframeload*/})
        var cmd = a.addCommand('xpic', {exec:xpic_onclick})
        cmd.modes={wysiwyg:1,source:1}
        cmd.canUndo=false
        a.ui.addButton('xpic',{ label:'插入图像', command:'xpic', icon:this.path+'images/icon.png' })
    }
})

function xpic_onclick(e)
{
    // run when custom button is clicked
    e.openDialog('xpic_dialog')
}