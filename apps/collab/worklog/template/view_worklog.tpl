{php}
$header_background_image='/collaboration/images/top_logo_banner.gif';
$this->assign('header_background_image', $header_background_image);

BizSystem::clientProxy()->includeColorPickerScripts();
BizSystem::clientProxy()->includeCalendarScripts();
BizSystem::clientProxy()->includeCKEditorScripts();
$includedScripts = BizSystem::clientProxy()->getAppendedScripts();
$includedScripts.="\n"."
<script src=\"".JS_URL."/cookies.js\"></script>
<script src=\"".JS_URL."/grouping.js\"></script>

<script type=\"text/javascript\" src=\"".JS_URL."/DateRangePicker/daterangepicker.jQuery.js\"></script>
<link rel=\"stylesheet\" href=\"".JS_URL."/DateRangePicker/css/ui.daterangepicker.css\" type=\"text/css\" />
<link rel=\"stylesheet\" href=\"".JS_URL."/DateRangePicker/css/redmond/jquery-ui-1.7.1.custom.css\" type=\"text/css\" />

<style>

.action_panel{
width:460px;
}
.search_panel{
width:200px;
}
.form_table td span.column_bar{
padding-top:5px;
}
.form_table td span.column_bar .value{
width:45px;
}
#main #right_panel .detail_form_panel_padding
{
	padding-left:15px;
}
table.input_row label{
width:85px;
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