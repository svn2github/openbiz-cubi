<?php 
require_once dirname(dirname(__FILE__)).'/ConfDataTableWizardForm.php';
class TableWidgetForm extends ConfDataTableWizardForm
{
	public function fetchData()
	{
		preg_match("/\[(.*?)\]=\'(.*?)\'/si",$this->m_FixSearchRule,$match);
		$name = $match[2];
		if(!$name){
			$name=BizSystem::getObject($this->m_ParentFormName)->m_RecordId;
		}
		$result = $this->fetchTableInfo($name);
		return $result;
	}
}
?>