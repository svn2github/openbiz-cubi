{php}
$header_background_image='/collab/images/top_logo_banner.gif';
$this->assign('header_background_image', $header_background_image);

$js_url = $this->_tpl_vars['js_url'];
$theme_js_url = $this->_tpl_vars['theme_js_url'];
$css_url = $this->_tpl_vars['css_url'];

$includedScripts = BizSystem::clientProxy()->getAppendedScripts();
$includedScripts .= "
<script type='text/javascript' src='$js_url/cookies.js'></script>
<script type='text/javascript' src='$js_url/general_ui.js'></script>
";
$this->_tpl_vars['scripts'] = $includedScripts;

$left_menu = "contact_mob.widget.ContactLeftMenu";
$this->assign('left_menu', $left_menu);

$appendStyle = BizSystem::clientProxy()->getAppendedStyles();
$appendStyle .= "
<link rel=\"stylesheet\" href=\"$css_url/general.css\" type=\"text/css\" />
<link rel=\"stylesheet\" href=\"$css_url/system_backend.css\" type=\"text/css\" />
";
$this->_tpl_vars['style_sheets'] = $appendStyle;
$this->assign('template_file', 'system_view.tpl.html');
{/php}
{include file=$template_file}