<?php
require_once('DataSharingForm.php');
class DataACLForm extends DataSharingForm
{
	public function fetchDataSet()
	{
		$prtRecord = $this->fetchData();
		$this->m_Editable = $prtRecord['editable'];
		$result =  parent::fetchDataSet();
		return $result;
	}
}
?>