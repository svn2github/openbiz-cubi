<?php
class MessageDraftListForm extends EasyForm
{
	public function fetchDataSet()
	{
		$resultSet = parent::fetchDataSet();
		$recordSet = array();
		foreach ($resultSet as $record)
		{
			if($record['subject']=="")
			{
				$record['subject']="[no subject]";
			}
			array_push($recordSet,$record);
		}
		return $recordSet;
	}
}
?>