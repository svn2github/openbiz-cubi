{php}
$header_background_image='/collab/images/top_logo_banner.gif';
$this->assign('header_background_image', $header_background_image);

$js_url = $this->_tpl_vars['js_url'];
$theme_js_url = $this->_tpl_vars['theme_js_url'];
$css_url = $this->_tpl_vars['css_url'];

BizSystem::clientProxy()->includeColorPickerScripts();
BizSystem::clientProxy()->includeCalendarScripts();
BizSystem::clientProxy()->includeCKEditorScripts();
$includedScripts = BizSystem::clientProxy()->getAppendedScripts();
$includedScripts.="
<script type='text/javascript' src='$js_url/cookies.js'></script>
<script type='text/javascript' src='$js_url/grouping.js'></script>
<script type='text/javascript' src='$theme_js_url/general_ui.js'></script>
<script>try{var \$j=jQuery.noConflict();}catch(e){}</script>
<script type='text/javascript' src='$js_url/jquery-ui-1.8.12.custom.min.js'></script>
";
$this->_tpl_vars['scripts'] = $includedScripts;

$appendStyle = BizSystem::clientProxy()->getAppendedStyles();
$appendStyle .= "
<link rel=\"stylesheet\" href=\"".RESOURCE_PHP."?f=$css_url/general.css,$css_url/system_backend.css,$css_url/system_menu_icons.css,collab/css/collaboration_menu_icons.css\" type=\"text/css\" />
<style>

.action_panel{
width:292px;
}
.search_panel{
width:398px;
}
</style>
";
$this->_tpl_vars['style_sheets'] = $appendStyle;

$left_menu = "collab.widget.CollaborationLeftMenu";
$this->assign('left_menu', $left_menu);

$this->assign('template_file', 'system_view.tpl.html');
{/php}
{include file=$template_file}