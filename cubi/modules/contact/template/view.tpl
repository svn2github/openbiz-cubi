{php}
BizSystem::clientProxy()->includeCKEditorScripts();
$includedScripts = BizSystem::clientProxy()->getAppendedScripts();
$this->_tpl_vars['scripts'] = $includedScripts;

$left_menu = "collaboration.widget.CollaborationLeftMenu";
$this->assign('left_menu', $left_menu);

$appendStyle = BizSystem::clientProxy()->getAppendedStyles();
$this->_tpl_vars['style_sheets'] = $appendStyle;
$this->assign('template_file', 'system_view.tpl.html');
{/php}
{include file=$template_file}
{literal}
<script>
function updatePreviewPic(){
	if(Prototype.Browser.IE){
		$('photo_placeholder').src=$('fld_photo').value;
	}else{		
		$('photo_placeholder').src="{/literal}{$image_url}{literal}/profile_photo_icon_ok.gif";		
	}
}
</script>
{/literal}