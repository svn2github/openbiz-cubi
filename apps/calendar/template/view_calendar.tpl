{php}
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
<script type='text/javascript' src='$js_url/general_ui.js'></script>
";
if (JSLIB_BASE!='JQUERY') :
$includedScripts.="
<script type='text/javascript' src='$js_url/jquery-ui-1.8.12.custom.min.js'></script>
<script>try{var \$j=jQuery.noConflict();}catch(e){}</script>
";
endif;
$includedScripts.="
<script type='text/javascript' src='$js_url/jquery.qtip-1.0.0-rc3.min.js'></script>
<script type='text/javascript' src='$js_url/Openbiz.CalendarForm.js'></script>
<script type='text/javascript' src='".RESOURCE_URL."/calendar/js/fullcalendar/fullcalendar.js'></script>
<link rel='stylesheet' href='".RESOURCE_URL."/calendar/js/fullcalendar/fullcalendar.css' type='text/css' />
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
";
$this->_tpl_vars['scripts'] = $includedScripts;


$left_menu = "calendar.widget.CalendarLeftMenu";
$this->assign('left_menu', $left_menu);

$appendStyle = BizSystem::clientProxy()->getAppendedStyles();
$appendStyle .= "
<link rel=\"stylesheet\" href=\"$css_url/general.css\" type=\"text/css\" />
<link rel=\"stylesheet\" href=\"$css_url/system_backend.css\" type=\"text/css\" />
<link rel=\"stylesheet\" href=\"".RESOURCE_URL."/calendar/css/collaboration_menu_icons.css\" type=\"text/css\" />
";
$this->_tpl_vars['style_sheets'] = $appendStyle;
$this->assign('template_file', 'system_view.tpl.html');
{/php}
{include file=$template_file}
