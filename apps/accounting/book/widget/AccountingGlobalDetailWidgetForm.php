<?php 
class AccountingGlobalDetailWidgetForm extends EasyForm
{
	public function fetchData()
	{
		$rec = $this->getDataObj()->fetch();
		$recArr = $rec->toArray();
		return $recArr[0];	
	}	
}
?>