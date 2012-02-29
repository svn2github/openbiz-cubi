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
<script type='text/javascript' src='//maps.googleapis.com/maps/api/js?sensor=false'></script>
<script type='text/javascript' src='$js_url/cookies.js'></script>
<script type='text/javascript' src='$js_url/grouping.js'></script>
<script type='text/javascript' src='$theme_js_url/general_ui.js'></script>
<script type='text/javascript' src='$js_url/jquery-ui-1.8.11.custom.min.js'></script>
<script type='text/javascript' src='".RESOURCE_URL."/collab/task/js/task.js'></script>
<link rel='stylesheet' src='$js_url/jquery-ui/ui-lightness/jquery-ui-1.8.11.custom.css' type='text/css' />
<script>try{var \$j=jQuery.noConflict();}catch(e){}</script>
<script type='text/javascript' src='$js_url/Openbiz.StickyForm.js'></script>
<script type='text/javascript' src='".RESOURCE_URL."/collab/js/StickyNotes/jquery.stickynotes.js'></script>
<link rel='stylesheet' href='".RESOURCE_URL."/collab/js/StickyNotes/css/jquery.stickynotes.css' type='text/css' />
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


$left_menu = "collab.widget.CollaborationLeftMenu";
$this->assign('left_menu', $left_menu);

$appendStyle = BizSystem::clientProxy()->getAppendedStyles();
$appendStyle .= "
<link rel=\"stylesheet\" href=\"$css_url/general.css\" type=\"text/css\" />
<link rel=\"stylesheet\" href=\"$css_url/system_backend.css\" type=\"text/css\" />
<link rel=\"stylesheet\" href=\"".RESOURCE_URL."/collab/css/collaboration_menu_icons.css\" type=\"text/css\" />
";
$this->_tpl_vars['style_sheets'] = $appendStyle;
$this->assign('template_file', 'system_view.tpl.html');
{/php}
{include file=$template_file}