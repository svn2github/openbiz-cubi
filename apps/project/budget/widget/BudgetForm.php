<?php 
class BudgetForm extends PickerForm
{
    public function addToParent($recIds=null)
    {
    	if(!is_array($recIds))
    	{    		
    		$recIdArr = array();
    		$recIdArr[] = $recIds;
    	}else{
    		$recIdArr = $recIds;
    	}
    	
    	/* @var $parentForm EasyForm */
    	$parentForm = BizSystem::objectFactory()->getObject($this->m_ParentFormName);
    	foreach($recIdArr as $recId)
    	{
	        $rec = $this->getDataObj()->fetchById($recId);		        	        	
	        //clear parent form search rules
	        $this->m_SearchRule="";
	        $parentForm->getDataObj()->clearSearchRule();
	        
	        // add record to parent form's dataObj who is M-M or M-1/1-1 to its parent dataobj
	        $ok = $parentForm->getDataObj()->addRecord($rec, $bPrtObjUpdated);
	        if (!$ok)
	            return $parentForm->processDataObjError($ok);
	            
	        $rec = $this->getDataObj()->fetchById($recId);
	        if($rec['type'] == 'task')
	        {
	        	$svcobj = BizSystem::getService("task.lib.TaskService");
	        	$svcobj->updateTaskFinancial($rec,'add');
	        }
    	}   
        
        $this->close();

        if($parentForm->m_ParentFormName)
        {
        	$parentParentForm = BizSystem::objectFactory()->getObject($parentForm->m_ParentFormName);
        	$parentParentForm->rerender();
        }else{
        	$parentForm->rerender();
        }

        // just keep it simple, don't refresh parent's parent form :)
    }
    
    
	public function deleteRecord($id=null)
    {


        if ($id==null || $id=='')
            $id = BizSystem::clientProxy()->getFormInputs('_selectedId');

        $selIds = BizSystem::clientProxy()->getFormInputs('row_selections', false);
        if ($selIds == null)
            $selIds[] = $id;
        foreach ($selIds as $id)
        {        	
            $dataRec = $this->getDataObj()->fetchById($id);
            
            if(!$this->canDeleteRecord($dataRec))
            {
            	$this->m_ErrorMessage = $this->getMessage("FORM_OPEATION_NOT_PERMITTED",$this->m_Name);         
        		if (strtoupper($this->m_FormType) == "LIST"){
        			BizSystem::log(LOG_ERR, "DATAOBJ", "DataObj error = ".$errorMsg);
        			BizSystem::clientProxy()->showClientAlert($this->m_ErrorMessage);
        		}else{
        			$this->processFormObjError(array($this->m_ErrorMessage));	
        		}	
        		return;
            }
            
        	if($dataRec['type'] == 'task')
	        {
	        	$svcobj = BizSystem::getService("project.task.lib.TaskService");
	        	$svcobj->updateTaskFinancial($dataRec,'sub');
	        }
            
	        // take care of exception
            try
            {
                $dataRec->delete();
            } catch (BDOException $e)
            {
                // call $this->processBDOException($e);
                $this->processBDOException($e);
                return;
            }
        }
        if (strtoupper($this->m_FormType) == "LIST")
            $this->rerender();

        $this->runEventLog();
        if($this->m_ParentFormName)
        {
        	$parentForm = BizSystem::objectFactory()->getObject($this->m_ParentFormName);
        	$parentForm->rerender();
        }
        else
        {
        	$this->processPostAction();
        }
    }    
}
?>