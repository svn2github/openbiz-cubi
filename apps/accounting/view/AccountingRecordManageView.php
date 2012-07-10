<?php 
class AccountingRecordManageView extends EasyView
{
	public function render()
	{
		$accountbook_id = $_GET["fld:Id"];
		if(!$accountbook_id)
		{
			header("Location: ".APP_INDEX.'/accounting/accounting_book_manage');
			exit;
		}
		return parent::render();
	}
}
?>