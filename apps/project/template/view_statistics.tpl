{php}
$header_background_image='/project/images/top_logo_banner.gif';
$this->assign('header_background_image', $header_background_image);

$js_url = $this->_tpl_vars['js_url'];
$theme_js_url = $this->_tpl_vars['theme_js_url'];
$css_url = $this->_tpl_vars['css_url'];

//BizSystem::clientProxy()->includeColorPickerScripts();
//BizSystem::clientProxy()->includeCalendarScripts();
//BizSystem::clientProxy()->includeCKEditorScripts();
$includedScripts = BizSystem::clientProxy()->getAppendedScripts();
$includedScripts.="
<script type='text/javascript' src='$js_url/jquery.js'></script>
<script>try{var \$j=jQuery.noConflict();}catch(e){}</script>
<script type='text/javascript' src='$js_url/cookies.js'></script>
<script type='text/javascript' src='$js_url/grouping.js'></script>
<script type='text/javascript' src='$js_url/general_ui.js'></script>
<script type='text/javascript' src='".RESOURCE_URL."/project/js/jsgantt/dhtmlxcommon.js'></script>
<script type='text/javascript' src='".RESOURCE_URL."/project/js/jsgantt/dhtmlxgantt.js'></script>
<link type='text/css' rel='stylesheet' href='".RESOURCE_URL."/project/js/jsgantt/dhtmlxgantt.css'/>
<script type='text/javascript' src='$js_url/Openbiz.GanttForm.js'></script>
<script type='text/javascript' src='$js_url/uploadify/swfobject.js'></script>
<script type='text/javascript' src='$js_url/uploadify/jquery.uploadify.v2.1.4.js'></script>
<script type='text/javascript' src='$js_url/jquery-ui-1.8.12.custom.min.js'></script>
<script type='text/javascript' >var charts = new Array();</script>
<script type=\"text/javascript\" src=\"".JS_URL."/DateRangePicker/daterangepicker.jQuery.js\"></script>
<link rel=\"stylesheet\" href=\"".JS_URL."/DateRangePicker/css/ui.daterangepicker.css\" type=\"text/css\" />
<style>

.action_panel{
width:292px;
}
.search_panel{
width:398px;
}
.form_table td span.column_bar{
padding-top:5px;
height:auto;
}
.label_textarea .form_table td span.column_bar {
padding-top:0px;
}
.form_table td span.column_bar .value{
width:auto;
padding-left:10px;
}
</style>
";
if (JSLIB_BASE!='JQUERY') :
$includedScripts.="
<script type='text/javascript' src='$js_url/jquery-ui-1.8.12.custom.min.js'></script>
<script>try{var \$j=jQuery.noConflict();}catch(e){}</script>
";
endif;
if(strtolower(FusionChartVersion)=="pro"){
	$includedScripts.="\n".'<script type="text/javascript" src="'.$this->_tpl_vars['resource_url'].'/chart/js/FusionChartsPro/FusionCharts.js"></script>';
	$includedScripts.="\n".'<script type="text/javascript" src="'.$this->_tpl_vars['resource_url'].'/chart/js/FusionChartsPro/FusionChartsExportComponent.js"></script>';
	$includedScripts.="\n".'<script type="text/javascript" src="'.$this->_tpl_vars['resource_url'].'/chart/js/FusionChartsPro/FusionChartsExport.js"></script>';
}else{
	$includedScripts.="\n".'
	<script type="text/javascript" src="'.$this->_tpl_vars['resource_url'].'/chart/js/FusionCharts/FusionCharts.js"></script>
	<script type="text/javascript" >forceSelectRecord=true;</script>
	';
}
$this->_tpl_vars['scripts'] = $includedScripts;


$left_menu = "project.widget.ProjectLeftMenu";
$this->assign('left_menu', $left_menu);

$appendStyle = BizSystem::clientProxy()->getAppendedStyles();
$appendStyle .= "
<link rel=\"stylesheet\" href=\"$css_url/general.css\" type=\"text/css\" />
<link rel=\"stylesheet\" href=\"$css_url/system_backend.css\" type=\"text/css\" />
<link rel=\"stylesheet\" href=\"".RESOURCE_URL."/project/css/project_menu_icons.css\" type=\"text/css\" />
";
$this->_tpl_vars['style_sheets'] = $appendStyle;
$this->assign('template_file', 'system_view.tpl.html');
{/php}
{include file=$template_file}