{php}
BizSystem::clientProxy()->includeCKEditorScripts();
$includedScripts = BizSystem::clientProxy()->getAppendedScripts();
$includedScripts.="\n".'<script type="text/javascript" src="'.$this->_tpl_vars['js_url'].'/FusionCharts/FusionCharts.js"></script>
<link rel="stylesheet" href="'.$this->_tpl_vars['css_url'].'/grm_dashboard_icons.css" type="text/css" />
<link rel="stylesheet" href="'.$this->_tpl_vars['css_url'].'/grm_menu_icons.css" type="text/css" />
';
$this->_tpl_vars['scripts'] = $includedScripts;
$left_menu = "myaccount.widget.MyAccountLeftMenu";
$this->assign('left_menu', $left_menu);
$this->assign('template_file', 'system_view.tpl.html');
{/php}
{include file=$template_file}