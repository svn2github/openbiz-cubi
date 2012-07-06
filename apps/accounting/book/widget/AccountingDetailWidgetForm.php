<?php 
class AccountingDetailWidgetForm extends EasyForm
{

	public function fetchData()
	{
		$accountbook_id = (int)$_GET['aid']?(int)$_GET['aid']:(int)$_POST['aid'];
		$rec = $this->getDataObj()->fetchOne("[Id]='$accountbook_id'");
		$rec = $rec->toArray();
		return $rec;	
	}	
}
?>