<?php 
require_once dirname(dirname(__FILE__)).'/ConfDataFieldWizardForm.php';
class FieldWidgetForm extends ConfDataFieldWizardForm
{
	public function fetchData()
	{
		if (strtoupper($this->m_FormType) == "NEW")
		{
			$recArr= $this->getNewRecord();
			$this->setActiveRecord($recArr);
            return $recArr;
		}
		preg_match("/\[(.*?)\]=\'(.*?)\'/si",$this->m_FixSearchRule,$match);
		$name = $match[2];
		if(!$name){
			$name=BizSystem::getObject($this->m_ParentFormName)->m_RecordId;
		}
		
		$tableName = $this->getViewObject()->getTableName();
		$result = $this->fetchFieldInfo($tableName,$name);
		return $result;
	}
	
	public function insertRecord()
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

       

	  $db = $this->_getDBConn();
	  $db->query($sql);

        // in case of popup form, close it, then rerender the parent form
        if ($this->m_ParentFormName)
        {
            $this->close();

            $this->renderParent();
        }

        $this->processPostAction();		
	}
	
	public function UpdateRecord()
	{

		$currentRec = $this->fetchData();
        $recArr = $this->readInputRecord();
        $this->setActiveRecord($recArr);
        if (count($recArr) != 0){            	
	        try
	        {
	            $this->ValidateForm();
	        }
	        catch (ValidationException $e)
	        {
	            $this->processFormObjError($e->m_Errors);
	            return;
	        }
	
	        //actions rename table
	        $db = $this->_getDBConn();
	        if($recArr['Name'] != $currentRec['Name'])
	        {
	        	$sql = "RENAME TABLE `". $currentRec['Name']."` TO `".$recArr['Name']."` ;";
	        	$db->query($sql);	
	        }
	        
	        //actions alter table engine
	        if($recArr['Engine'] != $currentRec['Engine'])
	        {
	        	$sql = "ALTER TABLE `".$recArr['Name']."` ENGINE = ".$recArr['Engine'].";";
	        	$db->query($sql);	
	        }
	        
       		//actions alter table comment
	        if($recArr['Comment'] != $currentRec['Comment'])
	        {
	        	$sql = "ALTER TABLE `".$recArr['Name']."` COMMENT = '".$recArr['Comment']."';";
	        	$db->query($sql);	
	        }
        }
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