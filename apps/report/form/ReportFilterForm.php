<?php
include_once "ReportForm.php";
class ReportFilterForm extends ReportForm
{
    public $m_UsePivot = 0;
    public $m_PivotLimit = 1000;
    
    public function setAttributes($formRecord)
    {
        parent::setAttributes($formRecord);
        $attrArr = explode(";",$this->m_Attrs);
		foreach($attrArr as $value){
			$itemArr = explode("=",$value);
			$attrs[$itemArr[0]]=$itemArr[1];
		}
        //added for support pivot table
		if(isset($attrs['UsePivot']) && $attrs['UsePivot']==1){
			$this->m_UsePivot = 1;
            $this->getElement('btn_pivot')->m_Hidden = 'N';
		}
        
        if(isset($attrs['PivotLimit'])){
			$this->m_PivotLimit = $attrs['PivotLimit'];
		}
    }
    
    public function outputAttrs()
    {
        $output = parent::outputAttrs();
        $output['use_pivot'] = $this->m_UsePivot;
		return $output;
    }
 
	public function runSearch()
	{
		// get view object
		$viewObj = $this->getViewObject();
		$viewObj->reload();
		
   		include_once(OPENBIZ_BIN."/easy/SearchHelper.php");
		
		// support more advanced search like ">2000 AND <2003"
		$searchRule = "";
		$searchRuleList = array();
		foreach ($this->m_DataPanel as $element)
		{
			$searchStrs = array();
			if (!$element->m_FieldName) continue;
			$value = BizSystem::clientProxy()->getFormInputs($element->m_Name);
			// compose search rule like ([field1]='a' OR [field1]='b') AND ([field2]='c' OR [field2]='d') AND ...
			//if (!$value && $value !== 0 && $value!=='0') continue;
			//$valueArr = explode(",",$value);
			//foreach($valueArr as $value){
				if($element->m_FuzzySearch=="Y")
				{
					$value="*$value*";
				}
				if ($value)
				{
					//$searchStrs[] = inputValToRule($element->m_FieldName, $value, $this);
					$this->queryParams[$element->m_FieldName] = $value;
				}
			//}
			//$searchRuleList[] = "(".implode(' OR ',$searchStrs).")";
		}
		//$searchRule = implode(' AND ',$searchRuleList);
        //if (empty($searchRule)) 
        //    return;
		//$searchRuleBindValues = QueryStringParam::getBindValues();
		// redraw all forms other than this filter form
		foreach ($viewObj->m_FormRefs as $formRef)
        {
            $formName = $formRef->m_Name;
            if ($formName == $this->m_Name)
            	continue;
            $formObj = BizSystem::objectFactory()->getObject($formName);
            if ($formObj->m_DataObjName == $this->m_DataObjName)
            {
            	$formObj->setSearchRule($searchRule, $this->queryParams);
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
		$this->queryParams = array();
        
    	foreach ($viewObj->m_FormRefs as $formRef)
        {
            $formName = $formRef->m_Name;
            if ($formName == $this->m_Name)
            	continue;
            $formObj = BizSystem::objectFactory()->getObject($formName);
            if ($formObj->m_DataObjName == $this->m_DataObjName)
            {
            	$formObj->setSearchRule("", $this->queryParams);
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
			//$_xmlArr["ATTRIBUTES"]["SORTABLE"] = 'Y';
            $_xmlArr["ATTRIBUTES"]["ELEMENTSET"] = 'Filters';
		/*	
			if(count($elementRecords)){
				$_xmlArr["EVENTHANDLER"]["ATTRIBUTES"]["NAME"]=$elemRec['name']."_onchange";
				$_xmlArr["EVENTHANDLER"]["ATTRIBUTES"]["EVENT"]="onchange";
				$_xmlArr["EVENTHANDLER"]["ATTRIBUTES"]["FUNCTION"]="UpdateForm()";
				$_xmlArr["EVENTHANDLER"]["VALUE"]=null;
			}
		*/	
			$xmlArr[] = $_xmlArr;
        }
       
        $_dataPanel = new Panel($xmlArr,"",$this);
        $_dataPanel->merge($this->m_DataPanel);
        $this->m_DataPanel = $_dataPanel;
        /*foreach ($this->m_DataPanel as $elem) {
        	echo "<pre>";print_r($elem);echo "</pre>";
        }*/
    }    
}
?>
