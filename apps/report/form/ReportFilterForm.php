<?php
include_once "ReportForm.php";
class ReportFilterForm extends ReportForm
{
	public function runSearch()
	{
		// get view object
		$viewObj = $this->getViewObject();
		$viewObj->reload();
		
   		include_once(OPENBIZ_BIN."/easy/SearchHelper.php");
        $searchRule = "";
        foreach ($this->m_DataPanel as $element)
        {
            if (!$element->m_FieldName)
                continue;

            $value = BizSystem::clientProxy()->getFormInputs($element->m_Name);
            $valueArr = explode(",",$value);
            $searchBaseRule.="(";
            foreach($valueArr as $value){              	          	
	            if($element->m_FuzzySearch=="Y")
	            {
	                $value="*$value*";
	            }
	            if ($value)
	            {
	                $searchStr = inputValToRule($element->m_FieldName, $value, $this);
	                if ($searchRule == "")
	                    $searchRule .= $searchStr;
	                else
	                    $searchRule .= " OR " . $searchStr;
	            }
            }     
//            if ($searchBaseRule == "("){
//            	$searchBaseRule.=$searchRule .") ";
//            }else{
            	$searchBaseRule.=$searchRule.") AND ";
            	$searchRule = "";
//            }       
        }
        if (empty($searchRule)) 
            return;
        $searchRule = $searchBaseRule."true";
		$searchRuleBindValues = QueryStringParam::getBindValues();
		// redraw all forms other than this filter form
		foreach ($viewObj->m_FormRefs as $formRef)
        {
            $formName = $formRef->m_Name;
            if ($formName == $this->m_Name)
            	continue;
            $formObj = BizSystem::objectFactory()->getObject($formName);
            if ($formObj->m_DataObjName == $this->m_DataObjName)
            {
            	$formObj->setSearchRule($searchRule, $searchRuleBindValues);
   				$formObj->rerender();
            }
        }
	}

    public function resetSearch()
    {
    	        // get view object
		$viewObj = $this->getViewObject();
		$viewObj->reload();
		
        $this->m_SearchRule = "";
        $this->m_RefreshData = true;
        $this->m_CurrentPage = 1;
        
        
    	foreach ($viewObj->m_FormRefs as $formRef)
        {
            $formName = $formRef->m_Name;
            if ($formName == $this->m_Name)
            	continue;
            $formObj = BizSystem::objectFactory()->getObject($formName);
            if ($formObj->m_DataObjName == $this->m_DataObjName)
            {
            	$formObj->setSearchRule("");
   				$formObj->rerender();
            }
        }        
    }	

    protected function initElementObjects($elementRecords)
    {
    	foreach ($elementRecords as $elemRec)
        {
			if (empty($elemRec['name']))
				$elemRec['name'] = $elemRec['Id'];
        	$_xmlArr["ATTRIBUTES"]["NAME"] = $elemRec['name'];
			$_xmlArr["ATTRIBUTES"]["CLASS"] = $elemRec['class'];
			$_xmlArr["ATTRIBUTES"]["LABEL"] = $elemRec['label'];
			$_xmlArr["ATTRIBUTES"]["FIELDNAME"] = $elemRec['field_name'];
			//$_xmlArr["ATTRIBUTES"]["ATTRS"] = $elemRec['attrs'];
			$_xmlArr["ATTRIBUTES"]["SELECTFROMSQL"] = $elemRec['select_from'];
			$_xmlArr["ATTRIBUTES"]["SORTABLE"] = 'Y';
			
			if(count($elementRecords)){
				$_xmlArr["EVENTHANDLER"]["ATTRIBUTES"]["NAME"]=$elemRec['name']."_onchange";
				$_xmlArr["EVENTHANDLER"]["ATTRIBUTES"]["EVENT"]="onchange";
				$_xmlArr["EVENTHANDLER"]["ATTRIBUTES"]["FUNCTION"]="UpdateForm()";
				$_xmlArr["EVENTHANDLER"]["VALUE"]=null;
			}
			
			$xmlArr[] = $_xmlArr;
        }
       
        $this->m_DataPanel = new Panel($xmlArr,"",$this);
        /*foreach ($this->m_DataPanel as $elem) {
        	echo "<pre>";print_r($elem);echo "</pre>";
        }*/
    }    
}
?>