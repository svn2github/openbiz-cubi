<?php
class ProjectSinglePickForm extends PickerForm
{
	public function fetchDataSet()
	{
		$svcObj = BizSystem::GetService(DATAPERM_SERVICE);
	    $dataPermSQLRule = $svcObj->buildSqlRule('update',true);
	    $this->m_FixSearchRule = $dataPermSQLRule;
		$resultSet = parent::fetchDataSet();		
		return $resultSet;
	}
}
?>