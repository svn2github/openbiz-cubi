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
	protected $m_RedirectURL;
	protected $m_AssocURL;
	
	public function readMetaData($xmlArr)
	{
		$result = parent::readMetaData($xmlArr);
		$this->m_RedirectURL = isset($xmlArr["ATTRIBUTES"]["REDIRECTURL"]) ? $xmlArr["ATTRIBUTES"]["REDIRECTURL"] : null;
		$this->m_AssocURL 	= isset($xmlArr["ATTRIBUTES"]["ASSOCURL"]) ? $xmlArr["ATTRIBUTES"]["ASSOCURL"] : null;
		return $result;
	}
	
	public function render()
	{
		$sHTML = "";
		if(BizSystem::getService('system.lib.ModuleService')->isModuleInstalled('oauth'))
		{
			 $do=BizSystem::getObject('oauth.do.OauthProviderDO');
			 $recArr=$do->directFetch ("[status]=1",30);
			 $recArr=$recArr->toArray();

			 if($this->m_RedirectURL)
			 {
			 	$this->m_RedirectURL = Expression::evaluateExpression($this->m_RedirectURL, $this);
			 	$url_append.="redirect_url=".urlencode($this->m_RedirectURL)."&";
			 }
			 if($this->m_AssocURL)
			 {
			 	$this->m_AssocURL = Expression::evaluateExpression($this->m_AssocURL, $this);
			 	$url_append.="assoc_url=".urlencode($this->m_AssocURL)."&";
			 }
			 if(count($recArr))
			 {
				 $sHTML.= "<span class=\"oauth_bar\" $style>";
				 foreach($recArr as $oauthProvider)
				 {
				 	$url = APP_URL."/ws.php/oauth/callback/login/type_".$oauthProvider['type'].'/';
				 	if($url_append){
				 		$url.= '?'.$url_append;
				 	}
					$sHTML.= "<a id=\"oauth_".$oauthProvider['type']."\" title=\"".$oauthProvider['type']."\"   href=\"$url\" style=\"\"></a>";
				 }
				 $sHTML.= "</span>";
			 }
		}	
		return $sHTML;
	}
}
?>