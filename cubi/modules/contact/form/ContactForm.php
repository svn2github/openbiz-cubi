<?php 
class ContactForm extends EasyForm
{
	public function insertRecord()
    {
        $recArr = $this->readInputRecord();
        $this->setActiveRecord($recArr);
        if (count($recArr) == 0)
            return;

        //generate fast_index
        $svcobj=BizSystem::getService("service.chineseService");
        if($svcobj->isChinese($recArr['first_name'])){
        	$fast_index = $svcobj->Chinese2Pinyin($recArr['first_name']);
        }else{
        	$fast_index = $recArr['first_name'];
        }
        $recArr['fast_index'] = substr($fast_index,0,1); 
       
        try
        {
            $this->ValidateForm();
        }
        catch (ValidationException $e)
        {
            $this->processFormObjError($e->m_Errors);
            return;
        }

        $this->_doInsert($recArr);
        
        

        // in case of popup form, close it, then rerender the parent form
        if ($this->m_ParentFormName)
        {
            $this->close();

            $this->renderParent();
        }

        $this->processPostAction();
    }	
    
    public function quickSearch($querry)
    {
    	
		if($querry=='AI')
			$this->setFixSearchRule("'A'<=[fast_index] AND [fast_index]<='I'");
		if($querry=='JR')
			$this->setFixSearchRule("'J'<=[fast_index] AND [fast_index]<='R'");
		if($querry=='SZ')
			$this->setFixSearchRule("'S'<=[fast_index] AND [fast_index]<='Z'");
		$this->rerender();
		
    }
}
?>
