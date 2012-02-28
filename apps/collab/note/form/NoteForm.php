<?php 
class NoteForm extends EasyForm
{
    public function outputAttrs()
    {
    	$result = parent::outputAttrs();    	
    	$result['notes'] = $this->renderNotes();
    	return $result;
    }
        
    public function renderNotes()
    {
    	$output = "";
    	$noteRecs = $this->fetchDataSet();
    	$noteCount = $noteRecs->count();
    	$i=0;
    	foreach($noteRecs as $noteRec)
    	{
    		$output.= $this->renderSingleNote($noteRec);   
    		if($i!=$noteCount-1){
    			$output.=",\n";
    		}
    		$i++;     		
    	}
    	return $output;
    }
    
    protected function renderSingleNote($noteRec)
    {

    	if($noteRec['position']){
    		$positionArr = unserialize($noteRec['position']);
    	}else{
    		$positionArr = array(
    		'pos_x' => 50,
        	'pos_y' => 50,
        	'width'	=> 200,
        	'height'=> 200
    		);
    	}
    	if($noteRec['type_color'])
    	{
    		$bgColor="bgcolor:'#".$noteRec['type_color']."', ";
    	}
    	else 
    	{
    		$bgColor = "";
    	}
    	
    	$datePanelRec = $this->m_DataPanel->renderRecord($noteRec);
    	$elemShare = $datePanelRec['fld_share']['element'];    	
    	
    	
    	$author = BizSystem::getObject("system.do.UserDO")->fetchById($noteRec['create_by'])->get('username');
    	$output =  "
    		{
				id: ".$noteRec['Id'].",
				text: '".addslashes(str_replace("\n","<br />",$noteRec['title']))."',
				description: '".addslashes(str_replace("\n","<br />",$noteRec['description']))."',	
				$bgColor			
				elemShare: ".json_encode($elemShare).",
				author: '".$author."',
				create_time: '".date('m/d H:i',strtotime($noteRec['create_time']))."',
				pos_x: ".(int)$positionArr['pos_x'].",
				pos_y: ".(int)$positionArr['pos_y'].",
				width: ".(int)$positionArr['width'].",			
				height: ".(int)$positionArr['height']."	,
				zindex: ".(int)(100-$noteRec['sortorder'])."			
			}";
    	return $output;
    }
    
    public function UpdateRecord()
    {
    	$id = BizSystem::clientProxy()->getFormInputs('_selectedId');
    	$title 	= BizSystem::clientProxy()->getFormInputs('text');
    	$pos_x 	= BizSystem::clientProxy()->getFormInputs('pos_x');
    	$pos_y 	= BizSystem::clientProxy()->getFormInputs('pos_y');
    	$width 	= BizSystem::clientProxy()->getFormInputs('width');
    	$height	= BizSystem::clientProxy()->getFormInputs('height');
        
    	$currentRec = $this->getDataObj()->FetchById($id);
    	$recArr = array();
	        
        $positionArr = array(
        	'pos_x' => $pos_x,
        	'pos_y' => $pos_y,
        	'width'	=> $width,
        	'height'=> $height
        );
        
        $recArr['title'] = $title;
        $recArr['position'] = serialize($positionArr);
        
    	if($currentRec){
	        $currentRec = $currentRec->toArray();	        	        
	        if ($this->_doUpdate($recArr, $currentRec) == false)
	            return;
    	}
    	else
    	{
    		$this->_doInsert($recArr);
    		$this->updateForm();
    	}

        // in case of popup form, close it, then rerender the parent form
        if ($this->m_ParentFormName)
        {
            $this->close();
            $this->renderParent();
        }

       //$this->updateForm();
    }
    
    public function processBDOException($e)
    {
        $errorMsg = $e->getMessage();
        BizSystem::log(LOG_ERR, "DATAOBJ", "DataObj error = ".$errorMsg);
        BizSystem::clientProxy()->showClientAlert($errorMsg).$this->rerender();;   //showErrorMessage($errorMsg);
    }
    
    public function DeleteNote()
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
        			BizSystem::clientProxy()->showClientAlert($this->m_ErrorMessage).$this->rerender();
        		}else{
        			$this->processFormObjError(array($this->m_ErrorMessage));	
        		}	
        		return;
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
        $this->UpdateForm();
    }    
}
?>
