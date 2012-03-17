<?php 
class TaskMultiPickForm extends PickerForm
{
	public function fetchDataSet()
	{
		$svcObj = BizSystem::GetService(DATAPERM_SERVICE);
	    $dataPermSQLRule = $svcObj->buildSqlRule($this->getDataObj(),'update',true,true);
	    $this->m_FixSearchRule = $dataPermSQLRule;
		$resultSet = parent::fetchDataSet();		
		return $resultSet;
	}	
}
?>