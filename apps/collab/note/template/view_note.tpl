{php}
$header_background_image='/collaboration/images/top_logo_banner.gif';
$this->assign('header_background_image', $header_background_image);

BizSystem::clientProxy()->includeColorPickerScripts();
BizSystem::clientProxy()->includeCalendarScripts();
BizSystem::clientProxy()->includeCKEditorScripts();
$includedScripts = BizSystem::clientProxy()->getAppendedScripts();
$includedScripts.="\n"."
<script>var \$j = jQuery.noConflict();</script>
<script src=\"".JS_URL."/cookies.js\"></script>
<script src=\"".JS_URL."/grouping.js\"></script>
<script src=\"".JS_URL."/Openbiz.StickyForm.js\"></script>
<script src=\"".JS_URL."/StickyNotes/jquery.stickynotes.js\"></script>
<script src=\"".JS_URL."/jquery-ui-1.8.11.custom.min.js\"></script>
<link rel=\"stylesheet\" href=\"".JS_URL."/StickyNotes/css/jquery.stickynotes.css\" type=\"text/css\" />
<link rel=\"stylesheet\" href=\"".JS_URL."/jquery-ui/ui-lightness/jquery-ui-1.8.11.custom.css\" type=\"text/css\" />
<style>

.action_panel{
width:292px;
}
.search_panel{
width:398px;
}
</style>
".'
<link rel="stylesheet" href="'.$this->_tpl_vars['resource_url'].'/collaboration/css/collaboration_menu_icons.css" type="text/css" />
';
$this->_tpl_vars['scripts'] = $includedScripts;


$left_menu = "collab.widget.CollaborationLeftMenu";
$this->assign('left_menu', $left_menu);

$appendStyle = BizSystem::clientProxy()->getAppendedStyles();
$this->_tpl_vars['style_sheets'] = $appendStyle;
$this->assign('template_file', 'system_view.tpl.html');
{/php}
{include file=$template_file}