{php}
$js_url = $this->_tpl_vars['js_url'];
$theme_js_url = $this->_tpl_vars['theme_js_url'];
$css_url = $this->_tpl_vars['css_url'];

BizSystem::clientProxy()->includeColorPickerScripts();

BizSystem::clientProxy()->includeCalendarScripts(); 
$includedScripts = BizSystem::clientProxy()->getAppendedScripts();
$includedScripts .= "
<script>try{var \$j=jQuery.noConflict();}catch(e){}</script>
<script type=\"text/javascript\" src=\"$js_url/cookies.js\"></script>
<script type=\"text/javascript\" src=\"$theme_js_url/general_ui.js\"></script>
<script type='text/javascript' src='".Resource::getJsUrl()."/Openbiz.PackageForm.js'></script>
<script type='text/javascript' src='$js_url/uploadify/swfobject.js'></script>
<script type='text/javascript' src='$js_url/uploadify/jquery.uploadify.v2.1.4.js'></script>
<script type='text/javascript' src='$js_url/jquery-ui-1.8.12.custom.min.js'></script>
<style>
.action_panel{
width:292px;
}
.search_panel{
width:398px;
}
</style>
";
$this->_tpl_vars['scripts'] = $includedScripts;

$appendStyle = BizSystem::clientProxy()->getAppendedStyles();
$appendStyle .= "\n"."
<link rel=\"stylesheet\" href=\"$css_url/general.css\" type=\"text/css\" />
<link rel=\"stylesheet\" href=\"$css_url/system_backend.css\" type=\"text/css\" />
<link rel=\"stylesheet\" href=\"$css_url/system_menu_icons.css\" type=\"text/css\" />
";
$this->_tpl_vars['style_sheets'] = $appendStyle;

$this->assign('template_file', 'system_view.tpl.html');
{/php}
{include file=$template_file}