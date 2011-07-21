{php}
BizSystem::clientProxy()->includeCKEditorScripts();
$includedScripts = BizSystem::clientProxy()->getAppendedScripts();
$this->_tpl_vars['scripts'] = $includedScripts;

$this->assign('template_file', 'system_view.tpl.html');
{/php}
{include file=$template_file}