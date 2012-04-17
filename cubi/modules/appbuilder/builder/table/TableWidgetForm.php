<?php 
require_once dirname(dirname(__FILE__)).'/ConfDataTableWizardForm.php';
class TableWidgetForm extends ConfDataTableWizardForm
{
	public function fetchData()
	{
		preg_match("/\[(.*?)\]=\'(.*?)\'/si",$this->m_FixSearchRule,$match);
		$name = $match[2];
		$result = $this->fetchTableInfo($name);
		return $result;
	}
}
?>