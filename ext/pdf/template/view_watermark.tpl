{php}
$js_url = $this->_tpl_vars['js_url'];
$theme_js_url = $this->_tpl_vars['theme_js_url'];
$css_url = $this->_tpl_vars['css_url'];

$appendStyle = BizSystem::clientProxy()->getAppendedStyles();
$appendStyle .= "\n"."
<link rel=\"stylesheet\" href=\"".RESOURCE_PHP."?f=$css_url/general.css,$css_url/system_backend.css,$css_url/system_menu_icons.css\" type=\"text/css\" />
";
$this->_tpl_vars['style_sheets'] = $appendStyle;

BizSystem::clientProxy()->includeColorPickerScripts();
BizSystem::clientProxy()->includeCKEditorScripts();
$includedScripts = BizSystem::clientProxy()->getAppendedScripts();
$includedScripts .= "
<script type=\"text/javascript\" src=\"".RESOURCE_PHP."?f=$js_url/cookies.js,$theme_js_url/general_ui.js\"></script>
";
$includedScripts.="\n".
"
<script>var \$j = jQuery.noConflict();</script>
<style >
table.input_row label{
	width:120px;
}
table.input_row .label_text label{
	width:80px;
	color:#666666;
	margin-right:0px;
}
#main #right_panel .content table#fld_watermark_picture_container tr td span.label_text{
	width:450px;
}
#main #right_panel .content table#fld_watermark_size_container tr td span.label_text{
	width:450px;
}
table#fld_watermark_size_container .label_text label{
	width:380px;
	color:#666666;
	margin-right:0px;
	display:block;
}
#main #right_panel .content table#fld_watermark_position_container tr td span.label_text{
	width:450px;
}
table#fld_watermark_position_container .label_text label{
	width:380px;
	color:#666666;
	margin-right:0px;
	display:block;
}
</style>
<script>
function change_type(value){
	switch(value){
		case 'Text':			
			$('element_set_2').hide();
			$('element_set_1').show();
			break;
		case 'Picture':
			$('element_set_1').hide();
			$('element_set_2').show();
			break;  
	}
}
</script>
";
$this->_tpl_vars['scripts'] = $includedScripts;
$this->assign('template_file', 'system_view.tpl.html');
{/php}
{include file=$template_file}