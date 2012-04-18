<?php 
require_once dirname(dirname(__FILE__)).'/ConfDataTableWizardForm.php';
class TableWidgetForm extends ConfDataTableWizardForm
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
		$result = $this->fetchTableInfo($name);
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

       $engine 		= $recArr['Engine'];
       $tableName 	= $recArr['Name'];
       $comment 	= $recArr['Comment'];

       if(strtoupper($recArr['_field_common'])=='Y')
       {
       		$sql_fields_common = "
			    `name` varchar(255) NOT NULL,
  				`description` text NOT NULL,        		
       		";
       		$sql_key_common = ",KEY `name` (`name`)";
       }

	   if(strtoupper($recArr['_field_sort'])=='Y')
       {
       		$sql_fields_sort = "
			    `sortorder` int(11) NOT NULL,       		
       		";
       }

	   if(strtoupper($recArr['_field_status'])=='Y')
       {
       		$sql_fields_sort = "
			    `status` int(2) NOT NULL,      		
       		";
       }       
      
       if(strtoupper($recArr['_field_creator'])=='Y')
       {
       		$sql_fields_creator = "
			  `create_by` int(11) NOT NULL,
			  `create_time` datetime NOT NULL,       		
       		";
       }
       
	   if(strtoupper($recArr['_field_updator'])=='Y')
       {
       		$sql_fields_updator = "
			    `update_by` int(11) NOT NULL,
  				`update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,      		
       		";
       }   

       if($recArr['_field_data_share'])
       if(strtoupper($recArr['_field_data_share'])=='Y')
       {
       		$sql_fields_share = "
			    `owner_id` int(11) default 0,
  				`group_id` INT(11) default '1',
  				`group_perm` INT(11) default '1',
  				`other_perm` INT(11) default '1' ,      		
       		";
       }       
       
       $sql = "
       CREATE TABLE IF NOT EXISTS `$tableName` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		    $sql_fields_common
			$sql_fields_share
		    $sql_fields_sort
		    $sql_fields_status		  
			$sql_fields_updator
			$sql_fields_creator
		  PRIMARY KEY (`id`)
		  $sql_key_common
		) ENGINE=$engine  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 COMMENT = '$comment' ;       
       ";

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