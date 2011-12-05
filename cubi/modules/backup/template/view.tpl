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
$js_url = $this->_tpl_vars['js_url'];
$theme_js_url = $this->_tpl_vars['theme_js_url'];
$css_url = $this->_tpl_vars['css_url'];

$includedScripts .= "
<script type=\"text/javascript\" src=\"$js_url/cookies.js\"></script>
<script type=\"text/javascript\" src=\"$theme_js_url/general_ui.js\"></script>
";
$this->_tpl_vars['scripts'] = $includedScripts;
$appendStyle = BizSystem::clientProxy()->getAppendedStyles();
$appendStyle .= "\n"."
<link rel=\"stylesheet\" <link rel=\"stylesheet\" href=\"$css_url/general.css\" type=\"text/css\" />
<link rel=\"stylesheet\" href=\"$css_url/system_backend.css\" type=\"text/css\" />
<link rel=\"stylesheet\" href=\"$css_url/system_menu_icons.css\" type=\"text/css\" />
";
$this->_tpl_vars['style_sheets'] = $appendStyle;

$this->_tpl_vars['style_sheets'] = $appendStyle;
$this->assign('template_file', 'system_view.tpl.html');
{/php}
{include file=$template_file}