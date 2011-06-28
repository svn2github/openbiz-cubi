{php}
$includedScripts = BizSystem::clientProxy()->getAppendedScripts();
$includedScripts.="\n".'
<style>
#main #right_panel .content table.input_row td .label_text{
width:350px;
}
#main #right_panel .content table.input_row td label{
width:150px;
}
</style>
';
$this->_tpl_vars['scripts'] = $includedScripts;
$this->assign('template_file', 'system_view.tpl.html');
{/php}
{include file=$template_file}
