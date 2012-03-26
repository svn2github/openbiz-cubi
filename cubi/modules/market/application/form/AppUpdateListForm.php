<?php 
require_once 'InstalledAppListForm.php';
class AppUpdateListForm extends InstalledAppListForm
{
	public function fetchDataSet()
	{
		$resultSet = parent::fetchDataSet();		
		
		return $resultSet;
	}		
}
?>