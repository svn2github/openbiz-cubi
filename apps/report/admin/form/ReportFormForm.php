<?php 
class ReportFormForm extends EasyForm
{
	private $m_ReportElementDO = "report.admin.do.ReportFormElementDO";
	private $m_ReportDoFieldDO = "report.admin.do.ReportDoFieldDO";
	
	public function insertRecord(){
		$recArr = $this->readInputRecord();
        $this->setActiveRecord($recArr);
        if (count($recArr) == 0)
            return;

		$newRecArr = array();
        $newParameterArr = array();
        foreach($recArr as $key=>$value){
        	if(substr($key,0,1)!='_'){
        		$newRecArr[$key]=$value;
        	}else{
        		$key = substr($key,1);
        		$newParameterArr[$key]=$value;
        	}
        }            
        $newRecArr['attrs']="";
	    foreach($newParameterArr as $key=>$value){
        	$newRecArr['attrs'].=$key."=".$value.";";
        }
            
        try
        {
            $this->ValidateForm();
        }
        catch (ValidationException $e)
        {
            $this->processFormObjError($e->m_Errors);
            return;
        }

        $this->_doInsert($newRecArr);
        
        

        // in case of popup form, close it, then rerender the parent form
        if ($this->m_ParentFormName)
        {
            $this->close();

            $this->renderParent();
        }
		
        //$this->LoadElement();
        $this->processPostAction();
		
		return $result;
	}

	public function updateRecord()
    {
        $currentRec = $this->fetchData();
        $recArr = $this->readInputRecord();
        //$this->setActiveRecord($recArr);
        if (count($recArr) == 0)
            return;
                    
		$newRecArr = array();
        $newParameterArr = array();
        foreach($recArr as $key=>$value){
        	if(substr($key,0,1)!='_'){
        		$newRecArr[$key]=$value;
        	}else{
        		$key = substr($key,1);
        		$newParameterArr[$key]=$value;
        	}
        }
        $newRecArr['attrs']="";
        foreach($newParameterArr as $key=>$value){
        	$newRecArr['attrs'].=$key."=".$value.";";
        }
        
        try
        {
            $this->ValidateForm();
        }
        catch (ValidationException $e)
        {
            $this->processFormObjError($e->m_Errors);
            return;
        }

        $this->_doUpdate($newRecArr, $currentRec);

        // in case of popup form, close it, then rerender the parent form
        if ($this->m_ParentFormName)
        {
            $this->close();

            $this->renderParent();
        }

        $this->processPostAction();

    }	
    
	public function fetchData(){
		$result = parent::fetchData();
		$attr_str = $result['attrs'];
		$attrArr = explode(";",$attr_str);
		foreach($attrArr as $value){
			$itemArr = explode("=",$value);
			$result["_".$itemArr[0]]=$itemArr[1];
		}
		return $result;
	}
	
	public function LoadElement($recId){
		$rec	= $this->getActiveRecord($recId);		
    	$id		= $rec['Id'];
    	$do_id	= $rec['do_id'];
    	$form_type = $rec['type'];
    	
    	$dataobj =  BizSystem::GetObject($this->m_ReportDoFieldDO,1);	
    	$elemobj =  BizSystem::GetObject($this->m_ReportElementDO,1);
		$dataobj->clearSearchRule();    	
    	$dataobj->setSearchRule("[do_id]='$do_id' ");    	
    	$dataobj->setSortRule("[column]='id' DESC,[type]='Number' ASC,[type]='Text' ASC");
    	$records = $dataobj->Fetch();
    	$sortorder = 10;
    	$data_colum_count =0;
    	foreach($records as $record){   
	    	if(!$this->_checkDupElement($record['Id'],$id)){			 		
		    	$elem_array =array(
	        				"form_id"=>$id,
	        				"field_id"=>$record['Id'],
	        				"label"=>ucwords(str_replace("_"," ",$record['name'])),
		    				"sortorder"=>$sortorder,
	        				);
	    		switch($form_type){
		    		case "chart":
		    			
		    			if($record['name']=='Id'){
		    				break;
		    			}
		    			if($sortorder==10){
		    				$elem_array["class"]="report.lib.ChartCategory";
		    			}else{
		    				$elem_array["class"]="report.lib.ChartData";
		    				$data_colum_count ++;
		    			}
		    			if(substr(strtoupper($rec['subtype']),0,2)=="MS"){
			    			$elemobj->insertRecord($elem_array);
		    			}else{
		    				if($data_colum_count<2){
		    					$elemobj->insertRecord($elem_array);
		    				}
		    			}
		    			$sortorder+=10;
		    			break;
		    		case "table":
	    				if($record['name']=='Id'){
		    				break;
		    			}
		    			$elem_array["class"]="ColumnText";
		    			$elemobj->insertRecord($elem_array);
		    			$sortorder+=10;
		    			break;
		    	}	        				
		    	
	    	} 	    	   		
    	}
		$this->rerenderSubForms();	
	}
	
    protected function _checkDupElement($field_id,$form_id)
    {        
        // query UserDO by the username
        $dataobj =  BizSystem::GetObject($this->m_ReportElementDO,1);	
        $records = $dataobj->directFetch("[field_id]='$field_id' AND [form_id]='$form_id'",1);
        if (count($records)>=1)
            return true;
        return false;
    }	
}
?>
