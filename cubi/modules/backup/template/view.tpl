{php}
BizSystem::clientProxy()->includeCalendarScripts();
BizSystem::clientProxy()->includeCKEditorScripts();
$includedScripts = BizSystem::clientProxy()->getAppendedScripts();
$includedScripts.="
<style>
#main #right_panel .content table.input_row td span.label_text{ width:290px;}
</style>

<script>
function update_import(){
	if($('fld_import').checked){
		$('element_set_1').show();
	}else{
		$('element_set_1').hide();
	}
}
function update_db_restore_opt()
{
	if($('fld_mode').value=='db_only' || $('fld_mode').value=='db' || $('fld_mode').value=='db_files')
	{
		$('fld_db_container').show();
		$('fld_charset_container').show();
	}else{
		$('fld_db_container').hide();
		$('fld_charset_container').hide();
	}
}

</script>
";
$this->_tpl_vars['scripts'] = $includedScripts;
$appendStyle = BizSystem::clientProxy()->getAppendedStyles();
$this->_tpl_vars['style_sheets'] = $appendStyle;
$this->assign('template_file', 'system_view.tpl.html');
{/php}
{include file=$template_file}