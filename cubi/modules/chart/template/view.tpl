{php}
BizSystem::clientProxy()->includeCalendarScripts();
BizSystem::clientProxy()->includeCKEditorScripts();
$includedScripts = BizSystem::clientProxy()->getAppendedScripts();
$includedScripts.="\n".'<script>var charts = new Array();</script>';
if(strtolower(FusionChartVersion)=="pro"){
	$includedScripts.="\n".'<script type="text/javascript" src="'.$this->_tpl_vars['js_url'].'/FusionChartsPro/FusionCharts.js"></script>';
	$includedScripts.="\n".'<script type="text/javascript" src="'.$this->_tpl_vars['js_url'].'/FusionChartsPro/FusionChartsExportComponent.js"></script>';
	$includedScripts.="\n".'<script type="text/javascript" src="'.$this->_tpl_vars['js_url'].'/FusionChartsPro/FusionChartsExport.js"></script>';
	$includedScripts.="\n".'<script>var redirectPDF = \'/bin/exportChartPDF.php?view='.str_replace("View","PdfView",$_GET['view']).'\';</script>';		
}else{
	$includedScripts.="\n".'
	<script type="text/javascript" src="'.$this->_tpl_vars['js_url'].'/FusionCharts/FusionCharts.js"></script>
	<script type="text/javascript" >forceSelectRecord=true;</script>
	';
}
$left_menu = "report.widget.ReportAdminMenu";
$this->assign('left_menu', $left_menu);
$this->_tpl_vars['scripts'] = $includedScripts;
$appendStyle = BizSystem::clientProxy()->getAppendedStyles();
$this->_tpl_vars['style_sheets'] = $appendStyle;
$this->assign('template_file', 'system_view.tpl.html');
{/php}
{include file=$template_file}