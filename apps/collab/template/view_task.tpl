{php}
$header_background_image='/collab/images/top_logo_banner.gif';
$this->assign('header_background_image', $header_background_image);

BizSystem::clientProxy()->includeColorPickerScripts();
BizSystem::clientProxy()->includeCalendarScripts();
BizSystem::clientProxy()->includeCKEditorScripts();
$includedScripts = BizSystem::clientProxy()->getAppendedScripts();
$includedScripts.="\n"."
<script>var \$j = jQuery.noConflict();</script>
<script src=\"".JS_URL."/cookies.js\"></script>
<script src=\"".JS_URL."/grouping.js\"></script>
<script src=\"".RESOURCE_URL."/collab/js/jsgantt/dhtmlxcommon.js\"></script>
<script src=\"".RESOURCE_URL."/collab/js/jsgantt/dhtmlxgantt.js\"></script>
<link type=\"text/css\" rel=\"stylesheet\" href=\"".RESOURCE_URL."/collab/js/jsgantt/dhtmlxgantt.css\">
<script src=\"".RESOURCE_URL."/collab/task/js/task.js\"></script>
<script src=\"".JS_URL."/Openbiz.GanttForm.js\"></script>
<script src=\"".JS_URL."/uploadify/swfobject.js\"></script>
<script src=\"".JS_URL."/uploadify/jquery.uploadify.v2.1.4.js\"></script>
<style>

.action_panel{
width:292px;
}
.search_panel{
width:398px;
}
.form_table td span.column_bar{
padding-top:5px;
}
.form_table td span.column_bar .value{
width:auto;
padding-left:10px;
}
</style>
".'
<link rel="stylesheet" href="'.RESOURCE_PHP.'?f=collab/css/collaboration_menu_icons.css" type="text/css" />
';
$this->_tpl_vars['scripts'] = $includedScripts;


$left_menu = "collab.widget.CollaborationLeftMenu";
$this->assign('left_menu', $left_menu);

$appendStyle = BizSystem::clientProxy()->getAppendedStyles();
$this->_tpl_vars['style_sheets'] = $appendStyle;
$this->assign('template_file', 'system_view.tpl.html');
{/php}
{include file=$template_file}