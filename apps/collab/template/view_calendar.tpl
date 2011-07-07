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
<script src=\"".JS_URL."/Openbiz.CalendarForm.js\"></script>
<script src=\"".RESOURCE_URL."/collab/js/fullcalendar/fullcalendar.js\"></script>
<script src=\"".JS_URL."/jquery.qtip-1.0.0-rc3.min.js\"></script>
<script src=\"".JS_URL."/jquery-ui-1.8.12.custom.min.js\"></script>
<link rel=\"stylesheet\" href=\"".RESOURCE_PHP."?f=collab/js/fullcalendar/fullcalendar.css\" type=\"text/css\" />
<style>

.action_panel{
width:292px;
}
.search_panel{
width:398px;
}
</style>
"."
<script>
	function closeAllTips()
	{
	for (i = 0; i < "."$"."j.fn.qtip.interfaces.length; i++) {
	var api = "."$"."j.fn.qtip.interfaces[i];
		if(api && api.status && api.status.rendered )
		{
		//hide all tip
		api.hide();
		}
	}}	

</script>

<link rel=\"stylesheet\" href=\"".RESOURCE_PHP."?f=collab/css/collaboration_menu_icons.css\" type=\"text/css\" />
"
;
$this->_tpl_vars['scripts'] = $includedScripts;


$left_menu = "collab.widget.CollaborationLeftMenu";
$this->assign('left_menu', $left_menu);

$appendStyle = BizSystem::clientProxy()->getAppendedStyles();
$this->_tpl_vars['style_sheets'] = $appendStyle;
$this->assign('template_file', 'system_view.tpl.html');
{/php}
{include file=$template_file}
