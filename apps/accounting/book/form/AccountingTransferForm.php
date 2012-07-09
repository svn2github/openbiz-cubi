<?php 
class AccountingTransferForm extends EasyForm
{
	public function CommitTrans()
	{
		$recArr = $this->readInputRecord();
        $this->setActiveRecord($recArr);
        if (count($recArr) != 0){
            	
	        try
	        {
	            $this->ValidateForm();
	        }
	        catch (ValidationException $e)
	        {
	            $this->processFormObjError($e->m_Errors);
	            return;
	        }
	
	        $transDO = BizSystem::getObject("accounting.record.do.AccountingRecordDO");	 
	        //credit from source
	        $transRec = array(
	        	"accountbook_id" => (int)$recArr['source_accountbook_id'],
	        	"type_id" => (int)$recArr['type_id'],
	        	"name" => (string)$recArr['name'],
	        	"credit" => floatval($recArr['amount']),
	        	"trans_date" => date("Y-m-d"),
	        	"trans_type" => 'Credit',
	        	"trans_proof" => 'Other',	        
	        );
	        $transDO->insertRecord($transRec);
	        
	        //debit to desc
	        $transRec = array(
	        	"accountbook_id" => (int)$recArr['dest_accountbook_id'],
	        	"type_id" => (int)$recArr['type_id'],
	        	"name" => (string)$recArr['name'],
	        	"debit" => floatval($recArr['amount']),
	        	"trans_date" => date("Y-m-d"),
	        	"trans_type" => 'Debit',
	        	"trans_proof" => 'Other',	        
	        );
	        $transDO->insertRecord($transRec);
	        
        }
        $this->processPostAction();
	}
}
?>