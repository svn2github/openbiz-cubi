<?php 
class AccountingTransferFinishedForm extends EasyForm
{
	public $m_CreditId = 6;
	public $m_DebitId = 7;
	
	
 public function getSessionVars($sessionContext)
    {
        $sessionContext->getObjVar($this->m_Name, "CreditId", $this->m_CreditId);
        $sessionContext->getObjVar($this->m_Name, "DebitId", $this->m_DebitId);
        parent::getSessionVars($sessionContext);
    }

    /**
     * Save object variable to session context
     *
     * @param SessionContext $sessionContext
     * @return void
     */
    public function setSessionVars($sessionContext)
    {
        $sessionContext->setObjVar($this->m_Name, "CreditId", $this->m_CreditId);
        $sessionContext->setObjVar($this->m_Name, "DebitId", $this->m_DebitId);
        parent::setSessionVars($sessionContext);    
    }	
	
	public function setCreditRecordId($id)
	{
		$this->m_CreditId = $id;
		return $this;
	}
	
	public function setDebitRecordId($id)
	{
		$this->m_DebitId = $id;
		return $this;
	}	
	
	
	
	public function fetchData()
	{
		$do = $this->getDataObj();
		$creditRec = $do->fetchById($this->m_CreditId);
		$debitRec = $do->fetchById($this->m_DebitId);
		
		$result['source_id'] 	= $this->m_CreditId;
		$result['source_trans_id'] 	= $creditRec['trans_id'];
		$result['source_name'] 	= $creditRec['name'];
		$result['source_amount'] = $creditRec['credit'];
		$result['source_accountbook'] = $creditRec['account_book_name'];
		$result['source_accountbook_balance'] = $this->getAccountBalance($creditRec['accountbook_id']);
		
		
		$result['dest_id'] 	= $this->m_DebitId;
		$result['dest_trans_id'] 	= $debitRec['trans_id'];
		$result['dest_name'] 	= $debitRec['name'];
		$result['dest_amount'] 	= $debitRec['debit'];
		$result['dest_accountbook'] = $debitRec['account_book_name'];
		$result['dest_accountbook_balance'] = $this->getAccountBalance($debitRec['accountbook_id']);
		
		return $result;
	}
	
	protected function getAccountBalance($accountbook_id)
	{		
		$do = BizSystem::getObject("accounting.book.do.AccountingBookDO");
		$rec = $do->fetchById($accountbook_id);
		return $rec['total_balance'];
	}
}
?>