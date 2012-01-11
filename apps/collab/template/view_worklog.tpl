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
<script type=\"text/javascript\" src=\"".RESOURCE_URL."/collab/js/DateRangePicker/daterangepicker.jQuery.js\"></script>
<link rel=\"stylesheet\" href=\"".RESOURCE_URL."/collab/js/DateRangePicker/css/ui.daterangepicker.css\" type=\"text/css\" />
<link rel=\"stylesheet\" href=\"".RESOURCE_URL."/collab/js/DateRangePicker/css/redmond/jquery-ui-1.7.1.custom.css\" type=\"text/css\" />

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
#main #right_panel .content table.input_row td .label_text {
width: 250px;
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