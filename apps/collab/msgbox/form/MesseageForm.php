<?php 
class MesseageForm extends EasyForm
{
	public function fetchDataSet()
    {
        $this->prepareQuery();
        
        return parent::fetchDataSet();
    }
    
    protected function prepareQuery()
    {
    	
		$profile = BizSystem::getUserProfile();
		$userId = $profile['Id'];
		if (isset($_GET['m'])) 
        {
        	if ($_GET['m'] == '0')
					$this->setFixSearchRule("[status]='0' and [from_userid]='$userId'");
			if ($_GET['m'] == '1')
        			$this->setFixSearchRule("[status]='1' and [from_userid]='$userId'");
			if ($_GET['m'] == '2')
        			$this->setFixSearchRule("[status]='2' and [to_userid]='$userId'");
			if ($_GET['m'] == '3')
        			$this->setFixSearchRule("[status]='3' and [from_userid]='$userId' or [to_userid]='$userId'");

        	
        }
    }
	
	public function sendItems()
    {
        $recArr = $this->readInputRecord();
        $this->setActiveRecord($recArr);
        if (count($recArr) == 0)
            return;

        try
        {
            $this->ValidateForm();
        }
        catch (ValidationException $e)
        {
            $this->processFormObjError($e->m_Errors);
            return;
        }
		
		$recArr[status]='1';
        if ($this->deleteRecord($recArr[Id])==false and $this->_doUpdate($recArr, $currentRec)==false)
            return;

        

        // in case of popup form, close it, then rerender the parent form
        if ($this->m_ParentFormName)
        {
            $this->close();

            $this->renderParent();
        }

        $this->processPostAction();
    }

	
}
?>
