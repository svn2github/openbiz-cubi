<?php 
include_once 'PdfForm.php';

class MyPdfForm extends PdfForm{
    public function updateRecord()
    {
        $currentRec = $this->fetchData();
        $recArr = $this->readInputRecord();
        
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
		
        // new save logic
        $user_id = BizSystem::getUserProfile("Id");
        $prefDo = $this->getDataObj();
        foreach ($this->m_DataPanel as $element)
        {
            $value = $recArr[$element->m_FieldName];
            if ($value === null){ 
            	continue;
            }   
            if(substr($element->m_FieldName,0,1)=='_'){
	            $name = substr($element->m_FieldName,1);
            	$recArrParam = array(
            		"user_id" => $user_id,
            		"name"	  => $name,
            		"value"   => $value,
            		"section" => "PDF",
	            	//"section" => $element->m_ElementSet,
	            	"type" 	  => $element->m_Class,	            
	            );
	            //check if its exsit
	            $record = $prefDo->fetchOne("[user_id]='$user_id' and [name]='$name'");
	            if($record){
	            	//update it
	            	$recArrParam["Id"] = $record->Id;
	            	$prefDo->updateRecord($recArrParam,$record->toArray());
	            }else{
	            	//insert it	            	
	            	$prefDo->insertRecord($recArrParam);
	            }
            }
        }
        
		//reload profile
		BizSystem::getService(PROFILE_SERVICE)->InitProfile(BizSystem::getUserProfile("username"));
        

        // in case of popup form, close it, then rerender the parent form
        if ($this->m_ParentFormName)
        {
            $this->close();

            $this->renderParent();
        }

        $this->processPostAction();

    }	
    
    public function fetchData(){
        if ($this->m_ActiveRecord != null)
            return $this->m_ActiveRecord;
            
        $dataObj = $this->getDataObj();
        if ($dataObj == null) return;
        	
    	QueryStringParam::setBindValues($this->m_SearchRuleBindValues);
        
        	
        if ($this->m_RefreshData)   $dataObj->resetRules();
        else $dataObj->clearSearchRule();

        if ($this->m_FixSearchRule)
        {
            if ($this->m_SearchRule)
                $searchRule = $this->m_SearchRule . " AND " . $this->m_FixSearchRule;
            else
                $searchRule = $this->m_FixSearchRule;
        }

        $dataObj->setSearchRule($searchRule);
        QueryStringParam::setBindValues($this->m_SearchRuleBindValues);        

        $resultRecords = $dataObj->fetch();
        $prefRecord = $this->fetchDefaultData();
        foreach($resultRecords as $record){
        	$prefRecord["_".$record['name']] = $record["value"];
        }
        
        $this->m_RecordId = $resultRecords[0]['Id'];
        $this->setActiveRecord($prefRecord);

        QueryStringParam::ReSet();

        return $prefRecord;    
    }    
    
    public function fetchDefaultData(){
      	$prefRecord=array();
		$dataObj = Bizsystem::getObject("pdf.do.PdfDO",1);
        $resultRecords = $dataObj->directfetch("[section]!=''");
        foreach($resultRecords as $record){
        	$prefRecord["_".$record['name']] = $record["value"];
        }        
        return $prefRecord;    
    }    
}
?>