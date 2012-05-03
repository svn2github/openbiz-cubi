<?php 
class MetaGeneratorService
{
	
	protected $m_DBName;
	protected $m_DBTable;
	protected $m_DBFields;
	protected $m_DBFieldsInfo;
	protected $m_ConfigModule;
	protected $m_BuildOptions;
	
	protected $m_MetaTempPath;
	protected $m_ACLArr;
	
	/**
	 * 
	 * This files will records generated files
	 * array - DataObjFiles
	 * array - FormObjFiles
	 * array - ViewObjFiles
	 * array - MessageFiles
	 * array - TemplateFiles
	 * string - ModXMLFile
	 * @var array Generated Files list
	 */
	protected $m_GeneratedFiles;
	
	public function setDBName($dbName)
	{
		$this->m_DBName	=	$dbName;
		return $this;
	}
	
	public function setDBTable($dbTable)
	{
		$this->m_DBTable	=	$dbTable;
		return $this;
	}
	
	public function setDBFields($dbFields)
	{
		$this->m_DBFields	=	$dbFields;
		return $this;
	}
	
	public function setConfigModule($configModule)
	{
		$this->m_ConfigModule	=	$configModule;
		return $this;
	}

	public function setBuildOptions($buildOptions)
	{
		$this->m_BuildOptions	=	$buildOptions;
		return $this;
	}	
	
	/**
	 * 	$svc->setDBName($dbName);
	 *  $svc->setDBTable($dbTable);
	 *  $svc->setDBFields($dbFields);
	 *  $svc->setConfigModule($configModule);
	 *  $svc->setBuildOptions($buildOptions);		
	 *  $svc->generate();
	 * Generate MetaObject Files
	 */
	public function generate()
	{
		$this->_genDataObj();
		$this->_genFormObj();
		$this->_genViewObj();
		$this->_genTemplateFiles();
		$this->_genMessageFiles();
		$this->_genModuleFile();
		return $this->m_GeneratedFiles;
	}
	
	protected function _genDataObj()
	{
		$templateFile = $this->__getMetaTempPath().'/do/DataObject.xml.tpl';
		$doName 	= $this->m_ConfigModule['object_name'];
		$doDesc 	= $this->m_ConfigModule['object_desc'];			
		$modName 	= $this->__getModuleName(); 				
		$uniqueness = $this->_getUniqueness();
		$sortField  = $this->_getSortField();
		$aclArr     = $this->_getACLArr();		
		$features	= $this->_getExtendFeatures();		
		$doFullName = $modName.'.do.'.$this->m_ConfigModule['object_name'];	
		
		if($this->m_ConfigModule['data_perm']=='0')
		{
			$doPermControl = "N";
		}
		else
		{
			$doPermControl = "Y";
		}
		
 		if(CLI){echo "Start generate dataobject $doName." . PHP_EOL;}
        $targetPath = $moduleDir = MODULE_PATH . "/" . str_replace(".", "/", $modName) . "/do";
        if (!file_exists($targetPath))
        {
            if(CLI){echo "Create directory $targetPath" . PHP_EOL;}
            mkdir($targetPath, 0777, true);
        }

	    if($features['extend']==1)
        {        	
        	$this->_genExtendTypeDO();
        }
        
        $smarty = BizSystem::getSmartyTemplate();
        
        $smarty->assign("do_full_name", $doFullName);
        $smarty->assign("do_name", $doName);        
        $smarty->assign("do_desc", $doDesc);
        $smarty->assign("db_name", $this->m_DBName);
        $smarty->assign("do_perm_control", $doPermControl);        
        $smarty->assign("table_name", $this->m_DBTable);
        $smarty->assign("fields", $this->m_DBFieldsInfo);        
        $smarty->assign("uniqueness", $uniqueness);        
        $smarty->assign("sort_field", $sortField);
        $smarty->assign("features", $features);
        $smarty->assign("acl", $aclArr);

        if($features['self_reference']==1)
        {
        	$smarty->assign("do_full_name_ref", 		str_replace("DO","RefDO",$doFullName));
        	$smarty->assign("do_full_name_related", 	str_replace("DO","RelatedDO",$doFullName));
        	$smarty->assign("table_name_related",	$this->m_DBTable."_releated");        	
        	$smarty->assign("table_ref_id", 			strtolower($this->m_DBTable)."_id");
        	$this->_genSelfReferenceDO();        
        }
        

        
        $content = $smarty->fetch($templateFile);
                
        $targetFile = $targetPath . "/" . $doName . ".xml";
        file_put_contents($targetFile, $content);                
        if(CLI){echo "\t".str_replace(MODULE_PATH,"",$targetFile)." is generated." . PHP_EOL;}

        var_dump($targetFile);exit;
        return $targetFile;		
	}
	
	protected function _genExtendTypeDO()
	{
		$extendTypeDO = $this->m_ConfigModule['extend_type_do'];
        $extendTypeDesc = $this->m_ConfigModule['extend_type_desc'];
        
        $db 	= BizSystem::dbConnection($this->m_DBName);
        
        //check type_id field existing
        $fieldName = "type_id";
        if(!$this->_isFieldExists($fieldName))
        {
        	$this->_addDOField($fieldName);
        }
        if(!in_array($fieldName, $this->m_DBFields))
        {
        	$this->m_DBFields[] = $fieldName;
        }
        
        //drop record type table if it exists
        $tableTypeName = $this->m_DBTable."_type";
        $sql="DROP TABLE IF EXISTS `$tableTypeName`;";
        $db->query($sql);
        
        if($this->m_ConfigModule['data_perm']=='1')
		{
	        $perm_fields = "
	        	  `group_id` int(11) DEFAULT '1',
				  `group_perm` int(11) DEFAULT '1',
				  `other_perm` int(11) DEFAULT '1', ";
		}
		
		//create record type table
        $sql="
			CREATE TABLE IF NOT EXISTS `$tableTypeName` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` varchar(255) NOT NULL,
			  `description` text NOT NULL,
			  `color` varchar(255) NOT NULL,
			  `sortorder` int(11) NOT NULL,
			  $perm_fields
			  `create_by` int(11) NOT NULL,
			  `create_time` datetime NOT NULL,
			  `update_by` int(11) NOT NULL,
			  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;        
        ";
        $db->query($sql);
        
        $doName 	= $extendTypeDO;
		$doDesc 	= $extendTypeDesc;			
		$modName 	= $this->__getModuleName(); 				
		$doFullName = $modName.'.do.'.$this->m_ConfigModule['object_name'];	
		
		if($this->m_ConfigModule['data_perm']=='0')
		{
			$doPermControl = "N";
		}
		else
		{
			$doPermControl = "Y";
		}
		
        $targetPath = $moduleDir = MODULE_PATH . "/" . str_replace(".", "/", $modName) . "/do";
        $templateFile = $this->__getMetaTempPath().'/do/DataObjectExtendTypeDO.xml.tpl';
        $smarty = BizSystem::getSmartyTemplate();
        
        $smarty->assign("record_do_full_name", $doFullName);
        $smarty->assign("do_name", $doName);        
        $smarty->assign("do_desc", $doDesc);
        $smarty->assign("db_name", $this->m_DBName);
        $smarty->assign("do_perm_control", $doPermControl);
        $smarty->assign("table_name", $this->m_DBTable);        
        $smarty->assign("table_type_name", $tableTypeName);
        
        $content = $smarty->fetch($templateFile);
                
        $targetFile = $targetPath . "/" . $doName . ".xml";
        file_put_contents($targetFile, $content);                
	}
	
	private function _addDOField($fieldName)
	{
		$tableName 	= $this->m_DBTable;
		$db 		= BizSystem::dbConnection($this->m_DBName);	
		$sql 		= "ALTER TABLE `$tableName` ADD `type_id` INT( 11 ) NOT NULL AFTER `id` , ADD INDEX ( `type_id` ) ;";
		$db->query($sql);		
	}
	
	private function _isFieldExists($fieldName)
	{
		$db 	= BizSystem::dbConnection($this->m_DBName);
		$tableName 	= $this->m_DBTable;
		$sql	= "SHOW FULL COLUMNS FROM `$tableName`";
		$fieldsInfo = $db->fetchAssoc($sql);
		foreach($fieldsInfo as $field=>$info)
		{
			if($field == $fieldName)
			{
				return true;
			}
		}
		return false;
	}
	
	protected function _genSelfReferenceDO()
	{				
		// Generate Reference DataObject
		$templateFile = $this->__getMetaTempPath().'/do/DataObjectRef.xml.tpl';
		$doName 	= $this->m_ConfigModule['object_name'];
		$doDescRef 	= $this->m_ConfigModule['object_desc'].' - Reference DO';
		$modName 	= $this->__getModuleName(); 				
		$uniqueness = $this->_getUniqueness();
		$sortField  = $this->_getSortField();
		$aclArr     = $this->_getACLArr();		
		$features	= $this->_getExtendFeatures();		
		$doFullName = $modName.'.do.'.$this->m_ConfigModule['object_name'];
		$doNameRef	= str_replace("DO","RefDO",$doName);
		$targetPath = $moduleDir = MODULE_PATH . "/" . str_replace(".", "/", $modName) . "/do";
		
		if($this->m_ConfigModule['data_perm']=='0')
		{
			$doPermControl = "N";
		}
		else
		{
			$doPermControl = "Y";
		}				
		
        $smarty = BizSystem::getSmartyTemplate();
        
        $smarty->assign("do_name", $doNameRef);        
        $smarty->assign("do_desc", $doDescRef);
        $smarty->assign("db_name", $this->m_DBName);
        $smarty->assign("do_perm_control", $doPermControl);        
        $smarty->assign("table_name", $this->m_DBTable);
        $smarty->assign("fields", $this->m_DBFieldsInfo);        
        $smarty->assign("uniqueness", $uniqueness);
        $smarty->assign("sort_field", $sortField);
        $smarty->assign("features", $features);
        $smarty->assign("acl", $aclArr);
        
		$content = $smarty->fetch($templateFile);                
        $targetFile = $targetPath . "/" . $doNameRef . ".xml";
        file_put_contents($targetFile, $content); 
		
        // Create a record_related table
        $tableNameRef = $this->m_DBTable.'_related';
        $tableRefId = strtolower($this->m_DBTable)."_id";
        $db 	= BizSystem::dbConnection($this->m_DBName);	
        $sql	= "DROP TABLE IF EXISTS `$tableNameRef`;";	
        $db->query($sql);
        		
		$sql 	= "
				CREATE TABLE `$tableNameRef` (
				  `id` int(10) unsigned NOT NULL auto_increment,
				  `$tableRefId` int(10) unsigned NOT NULL default '0',
				  `related_id` int(10) unsigned NOT NULL default '0',  
				  PRIMARY KEY  (`id`),
				  KEY `related_id` (`related_id`),
				  KEY `$tableRefId` (`$tableRefId`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
		$db->query($sql);
        
        
		// Generate Related DataObject        
		$templateFile = $this->__getMetaTempPath().'/do/DataObjectRelated.xml.tpl';
		
		$doNameRelated	= str_replace("DO","RelatedDO",$doName);
		$doDescRelated 	= $this->m_ConfigModule['object_desc'].' - Related DO';
		
		$smarty->assign("do_name", $doNameRelated);
		$smarty->assign("do_desc", $doDescRelated);		
		$smarty->assign("table_name", $tableNameRef);
		$smarty->assign("table_ref_id", $tableRefId);			
						
		$content = $smarty->fetch($templateFile);                
        $targetFile = $targetPath . "/" . $doNameRelated . ".xml";
        file_put_contents($targetFile, $content); 
	}
	
	protected function _getFieldsInfo()
	{
		if(is_array($this->m_DBFieldsInfo))
		{
			return $this->m_DBFieldsInfo;
		}
		else 
		{
			$fields = $this->m_DBFields;
			$tableName = $this->m_DBTable;
			
			$fieldStr = "'".implode("','", $fields)."'";		
			
			$db 	= BizSystem::dbConnection($this->m_DBName);				
			$sql 	= "SHOW FULL COLUMNS FROM `$tableName` WHERE `Field` IN ($fieldStr);";
			$resultSet = $db->fetchAssoc($sql);
			
			foreach($resultSet as $key=>$arr)
			{
				$arr['FieldName'] = ucwords($arr['Field']);
				$arr['FieldType'] = $this->__convertDataType($arr['Type']);
				$resultSet[$key] = $arr;
			}
			
			$this->m_DBFieldsInfo = $resultSet;			
			return $resultSet;
		}		
	}
	
	/**
	 * 
	 * Get uniqueness fields list for Data Object
	 * @return string fieldList - e.g.: name;sku 
	 */
	protected function _getUniqueness()
	{
		$fields = $this->_getFieldsInfo();
		$fieldstr = "";
		foreach($fields as $key=>$arr)
		{
			if($arr[$key]=='UNI')
			{
				$fieldstr.=$arr['Key'].";";
			}
		}
		if(substr($fieldstr,strlen($fieldstr)-1,1)==';')
		{
			$fieldstr = substr($fieldstr,0,strlen($fieldstr)-1);
		}
		return $fieldstr;
	}		
	
	/**
	 * 
	 * Get sort field name for Data Object
	 * @return string fieldName - sort_order
	 */
	protected function _getSortField()
	{
		$fields = $this->_getFieldsInfo();
		foreach($fields as $key=>$arr)
		{
			if($key=="sortorder")
			{
				return $key;
			}
			elseif($key=="sort_order")
			{
				return $key;
			}
		}
	}
	
	protected function _getExtendFeatures()
	{
		$features	=	array(
						"picture"			=>	$this->m_ConfigModule['picture_feature'],
						"location"			=>	$this->m_ConfigModule['location_feature'],
						"changelog"			=>	$this->m_ConfigModule['changelog_feature'],
						"attachment"		=>	$this->m_ConfigModule['attachment_feature'],
						"self_reference"	=>	$this->m_ConfigModule['selfref_feature'],
						"extend"			=>	$this->m_ConfigModule['extend_feature']						
						);	
		return $features;		
	}
	
	/**
	 * 
	 * Get Resource Name
	 * @return string resource - alias of resource
	 */
	protected function _getResourceName()
	{
		return $this->m_ConfigModule['resource_name'];
	}
	
	/**
	 * 
	 * Get array of ACL list
	 * @return array ACLArr
	 */
	protected function _getACLArr()
	{
		if(is_array($this->m_ACLArr))
		{
			return $this->m_ACLArr;
		}
		else
		{
	        $resource = $this->_getResourceName();
	        $acl = $this->m_ConfigModule['acl_type'];
	        switch ($acl) {
	            case 0: //0 - No Access Control 
	                $this->m_ACLArr	   = array( 'access'=>'', 
	                							'manage'=>'', 
	                							'create'=>'', 
	                							'update'=>'', 
	                							'delete'=>''); 
	                break;	        	
	            case 1: //1 - Access and Manage (Default)
	                $this->m_ACLArr	   = array( 'access'=>$resource.'.Access', 
	                							'manage'=>$resource.'.Manage', 
	                                            'create'=>$resource.'.Manage', 
	                                            'update'=>$resource.'.Manage',
	                							'delete'=>$resource.'.Manage'); 
	                break;
	            case 2: //2 - Access, Create, Update and Delete
	                $this->m_ACLArr	   = array( 'access'=>$resource.'.Access', 
	                							'manage'=>$resource.'.Manage', 
	                                            'create'=>$resource.'.Create', 
	                                            'update'=>$resource.'.Update', 
	                                            'delete'=>$resource.'.Delete'); 
	                break;
	        }
	        return $this->m_ACLArr;
		}
	}
	
	protected function _genFormObj()
	{
		
	}
	
	protected function _genViewObj()
	{
		
	}

	protected function _genTemplateFiles()
	{
		
	}	
	
	protected function _genMessageFiles()
	{
		
	}	
	
	protected function _genModuleFile()
	{
		
	}	

	

	protected function _enableExtendFieldsFeature()
	{
		
	}	
	
	private function __getMetaTempPath()
	{
		$this->m_MetaTempPath = MODULE_PATH.DIRECTORY_SEPARATOR.'appbuilder'.
											DIRECTORY_SEPARATOR.'resource'.
											DIRECTORY_SEPARATOR.'module_template';
		return $this->m_MetaTempPath; 
	}
	
	private function __getModuleName()
	{
		if($this->m_ConfigModule['module_type']==1)
		{
			return $this->m_ConfigModule['module_name_create'];
		}
		else
		{
			return $this->m_ConfigModule['module_name_exists'];
		}
	}
	
	private function __convertDataType($type)
	{
		if(strpos($type,"("))
		{
			$type = substr($type,0,strpos($type,"("));
		}		
		switch ($type)
        {
            case "date":
                $type = "Date";
                break;

            case "timestamp":
            case "datetime":
                $type = "Datetime";
                break;

            case "int":
            case "float":
            case "bigint":
            case "tinyint":
                $type = "Number";
                break;

            case "text":
            case "shorttext":
            case "longtext":
        	    default:
                $type = "Text";
                break;
       }
       return $type;
	}
}
?>