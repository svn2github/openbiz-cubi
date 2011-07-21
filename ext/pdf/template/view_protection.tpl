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
	width:130px;
}
table.input_row .label_text label{
	width:80px;
	color:#666666;
	margin-right:0px;
}
</style>
";
$this->_tpl_vars['scripts'] = $includedScripts;
$this->assign('template_file', 'system_view.tpl.html');
{/php}
{include file=$template_file}