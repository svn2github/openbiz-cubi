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

       
	  var_dump($recArr);exit;
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
			$tableName = $this->getViewObject()->getTableName();

	        
	        //ALTER TABLE `email_log` CHANGE `result` `result` VARCHAR( 255 ) CHARACTER SET NULL COMMENT 'jixian'

			//actions rename table
	        $db = $this->_getDBConn();	        
	        $sql = "ALTER TABLE `$tableName` CHANGE `". $currentRec['Field']."`  `".$recArr['Field']."` ";	        
	        
	        //actions alter field type
        	$sql .= " ".$recArr['Type']." CHARACTER SET utf8 COLLATE utf8_general_ci ";
	       
	        
        	//actions alter field setnull
	        if($recArr['SetNull']=='0')
	        {
	        	$sql .= " NOT NULL  ";
	        }
	        else 
	        {
	        	$sql .= " NULL  ";
	        }
	        
       		//actions alter table comment
	        $sql .= " COMMENT '".$recArr['Comment']."'  ";
	        
	        $db->query($sql);
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