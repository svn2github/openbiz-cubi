<?php 
/**
 * 
 * {php}
	
	$recArr=BizSystem::sessionContext()->getVar("_OauthLogin");
	if(!$recArr && BizSystem::getService('system.lib.ModuleService')->isModuleInstalled('oauth'))
		 {
		 
		 $do=BizSystem::getObject('oauth.do.OauthProviderDO');
		 $sql="SELECT `type` ,  `key` ,  `value`  FROM  `{$do->m_MainTable}` where status=1   LIMIT 0 , 15 ";
		 $db=$do->getDBConnection();
		 $recArr=$db->fetchAssoc($sql);
		 BizSystem::sessionContext()->setVar("_OAUTH_{$this->m_Type}",$recArr);
	  }
$this->assign('_OauthLogin', $recArr);
{/php}
		<p class="input_row">
			{foreach item=do from=$_OauthLogin}
	        <span><a title="{$do.type}"   href="{$app_url}/oauth_callback_handler.php?type={$do.type}&service=login" class="link_highlight" style="">{$do.type}</a> </span>
			{/foreach}
		
		</p>		
 * @author jixian
 *
 */
class OauthLogin extends InputElement
{
	public function render()
	{
		$sHTML = "";
		if(BizSystem::getService('system.lib.ModuleService')->isModuleInstalled('oauth'))
		{
			 $do=BizSystem::getObject('oauth.do.OauthProviderDO');
			 $recArr=$do->directFetch ("[status]=1",30);
			 $recArr=$recArr->toArray();

			 if(count($recArr))
			 {
				 $sHTML.= "<span class=\"oauth_bar\" $style>";
				 foreach($recArr as $oauthProvider)
				 {
					$sHTML.= "<a id=\"oauth_".$oauthProvider['type']."\" title=\"".$oauthProvider['type']."\"   href=\"".APP_URL."/oauth_callback_handler.php?type=".$oauthProvider['type']."&service=login\" style=\"\"></a>";
				 }
				 $sHTML.= "</span>";
			 }
		}	
		return $sHTML;
	}
}
?>