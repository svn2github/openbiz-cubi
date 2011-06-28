<?php
class DashboardView extends EasyView
{
	private $m_UserWidgetDO = "myaccount.do.UserWidgetDO";	
	
	protected function readMetadata(&$xmlArr)
    {
        parent::readMetaData($xmlArr);
		$formRefXML = $this->getFormReferences();		
        $this->m_FormRefs = new MetaIterator($formRefXML,"FormReference",$this);
	}
	
	private function getFormReferences()
	{
		$user_id = BizSystem::GetUserProfile("Id");
		$searchRule="[user_id]='$user_id'";
		$do = BizSystem::GetObject($this->m_UserWidgetDO);
		$formRecs = $do->directfetch($searchRule);
		$formRefXML = array();
		foreach($formRecs as $form){
			$formRefXML[] = array(
				"ATTRIBUTES"=>array(
					"NAME"=>$form['widget']
					),
				"VALUE"=>null
			);
		}
		return $formRefXML;
	}
}
?>