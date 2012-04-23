<?php 
class SummaryWidget extends EasyForm
{
   
	public function outputAttrs()
	{
		$result 				= parent::outputAttrs();
		$result['dbConn'] 		= $this->getViewObject()->getDBConnName();
		$result['tableName'] 	= $this->getViewObject()->getTableName();
		$result['tableFields'] 	= $this->getViewObject()->getFields();
		return $result;		
	}
}
?>