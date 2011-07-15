<?php 
class ReportFormElementForm extends EasyForm
{
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
	    	if($value){
		        if(preg_match("/color/si",$key)){
	        		$newRecArr['attrs'].=$key.":#".$value.";";
	        	}else{
	        		$newRecArr['attrs'].=$key.":".$value.";";
	        	}        
	    	}
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
        	if($value){
	        	if(preg_match("/color/si",$key)){
	        		$newRecArr['attrs'].=$key.":#".$value.";";
	        	}else{
	        		$newRecArr['attrs'].=$key.":".$value.";";
	        	}
        	}
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
			$itemArr = explode(":",$value);
			if(substr($itemArr[1],0,1)=='#'){
				$result["_".$itemArr[0]]=substr($itemArr[1],1);
			}else{
				$result["_".$itemArr[0]]=$itemArr[1];
			}
		}
		return $result;
	}	
}
?>
