<?php 
class MetaGeneratorService
{
	
	protected $m_DBName;
	protected $m_DBTable;
	protected $m_DBFields;
	protected $m_DBFieldsInfo;
	protected $m_DBSearchField;
	protected $m_ConfigModule;
	protected $m_BuildOptions;
	
	protected $m_RefDOName;
	protected $m_RefDOFullName;
	protected $m_PickDOName;
	protected $m_PickDOFullName;
	
	protected $m_MetaTempPath;
	protected $m_ACLArr;
	protected $m_TypeDOFullName;
	
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
		$this->_genMessageFiles();
		$this->_genDataObj();
		$this->_genFormObj();
		$this->_genViewObj();
		$this->_genTemplateFiles();
		$this->_genResourceFiles();
		$this->_genDashboardFiles();
		$this->_genModuleFile();
		$this->_loadModule();
		var_dump($this->m_GeneratedFiles);
		exit;
		return $this->m_GeneratedFiles;
	}
	
	protected function _loadModule()
	{
		$modName = $this->__getModuleName(false);		
		include_once MODULE_PATH.DIRECTORY_SEPARATOR.'system'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'ModuleLoader.php';
		$loader = new ModuleLoader($modName);
		return $loader->loadModule();		
	}
	
	protected function _genDataObj()
	{
		if($this->m_BuildOptions["gen_data_object"]!='1')
		{
			return false;
		}
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

	    if($features['data_type']==1)
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
        	$this->m_RefDOName 		= str_replace("DO","RefDO",$doName);
        	$this->m_RefDOFullName 	= str_replace("DO","RefDO",$doFullName);
        	$smarty->assign("do_full_name_ref", 		$this->m_RefDOName);
        	$smarty->assign("do_full_name_related", 	str_replace("DO","RelatedDO",$doFullName));
        	$smarty->assign("table_name_related",		$this->m_DBTable."_related");        	
        	$smarty->assign("table_ref_id", 			strtolower($this->m_DBTable)."_id");
        	$this->_genSelfReferenceDO();        
        }
        
        $content = $smarty->fetch($templateFile);
                
        $targetFile = $targetPath . "/" . $doName . ".xml";
        file_put_contents($targetFile, $content);        

        $this->m_GeneratedFiles['DataObjFiles']['MainDO']=str_replace(MODULE_PATH,"",$targetFile);        
        if(CLI){echo "\t".str_replace(MODULE_PATH,"",$targetFile)." is generated." . PHP_EOL;}

        if($features['widget']==1)
        {
        	$doName = str_replace("DO","PickDO",$doName);
        	$this->m_PickDOName  = $doName;
        	$this->m_PickDOFullName  = str_replace("DO","PickDO",$doFullName);;
        	$smarty->assign("do_name", $doName);
        	$smarty->assign("do_full_name_pick", 		$doName);
        	$templateFile = $this->__getMetaTempPath().'/do/DataObjectPick.xml.tpl';
        	$content = $smarty->fetch($templateFile);
                
	        $targetFile = $targetPath . "/" . $doName . ".xml";
	        file_put_contents($targetFile, $content);        
	
	        $this->m_GeneratedFiles['DataObjFiles']['PickDO']=str_replace(MODULE_PATH,"",$targetFile);        
	        if(CLI){echo "\t".str_replace(MODULE_PATH,"",$targetFile)." is generated." . PHP_EOL;}
	        	
        }
        return $targetFile;		
	}
	
	/**
	 * 
	 * Generate Data Objects for Extend Data Fields Feature
	 * if data_type table doesn't exists then create it.
	 */
	protected function _genExtendTypeDO()
	{
		if($this->m_BuildOptions["gen_data_object"]!='1')
		{
			return false;
		}
		$extendTypeDO = $this->m_ConfigModule['extend_type_do'];
        $extendTypeDesc = $this->m_ConfigModule['extend_type_desc'];
        $features		= $this->_getExtendFeatures();
        
        $db 	= BizSystem::dbConnection($this->m_DBName);
        
        //check type_id field existing
        $fieldName = "type_id";
        if(!$this->__isFieldExists($fieldName))
        {
        	$this->__addDOField($fieldName);
        }
        if(!in_array($fieldName, $this->m_DBFields))
        {
        	$this->m_DBFields[] = $fieldName;
        }
        
        //drop record type table if it exists        
        $tableTypeName = $this->m_DBTable."_type";
        
	    if($this->m_ConfigModule['data_perm']=='1')
		{
	        $perm_fields = "
	        	  `group_id` int(11) DEFAULT '1',
				  `group_perm` int(11) DEFAULT '1',
				  `other_perm` int(11) DEFAULT '1', ";
		}
		
        if(!$this->__isTableExists($tableTypeName)) 
        {
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
        }
        
        $doName 	= $extendTypeDO;
		$doDesc 	= $extendTypeDesc;			
		$modName 	= $this->__getModuleName(); 				
		$doFullName = $modName.'.do.'.$this->m_ConfigModule['object_name'];	
		$this->m_TypeDOFullName = $modName.'.do.'.$extendTypeDO;
		
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
        $smarty->assign("features", $features);
        
        $content = $smarty->fetch($templateFile);
                
        $targetFile = $targetPath . "/" . $doName . ".xml";
        file_put_contents($targetFile, $content);        
        $this->m_GeneratedFiles['DataObjFiles']['TypeDO']=str_replace(MODULE_PATH,"",$targetFile);                
	}
	
	/**
	 * Generate Form Objects for Extend Type Feature
	 */
	protected function _genExtendTypeForm()
	{
		if($this->m_BuildOptions["gen_form_object"]!='1')
		{
			return false;
		}
		
		//generate list form metadata
		//shared variables
		$templateFile = $this->__getMetaTempPath().'/form/TypeListForm.xml.tpl';
		$doName 	= $this->m_ConfigModule['extend_type_do'];
		$doDesc 	= $this->m_ConfigModule['object_desc'];					
		$modName 	= $this->__getModuleName(); 	
		$modShortName 	= $this->__getModuleName(false); 			
		$uniqueness = $this->_getUniqueness();
		$sortField  = $this->_getSortField();
		$aclArr     = $this->_getACLArr();		
		$features	= $this->_getExtendFeatures();		
		$doFullName = $modName.'.do.'.$this->m_ConfigModule['extend_type_do'];
		$extendFeature = $features['extend'];
		$formClass  = "EasyForm";				
		$typeViewURL = $modShortName.'/'.$this->__getViewName().'_type';
		
		$formListName 	= $this->__getObjectName().'TypeListForm';
		$formListFullName = $modName.'.form.'.$formListName;				
		$formDetailName  	= $this->__getObjectName().'TypeDetailForm';
		$formDetailFullName  = $modName.'.form.'.$formDetailName;
		$formCopyName  	= $this->__getObjectName().'TypeCopyForm';
		$formCopyFullName  = $modName.'.form.'.$formCopyName;		
		$formEditName  	= $this->__getObjectName().'TypeEditForm';
		$formEditFullName  = $modName.'.form.'.$formEditName;		
		$formNewName  	= $this->__getObjectName().'TypeNewForm';
		$formNewFullName  = $modName.'.form.'.$formNewName;
		$formCustomName  	= $this->__getObjectName().'TypeCustomForm';
		$formCustomFullName  = $modName.'.form.'.$formCustomName;
		
		$messageFile = "";
		if($this->m_GeneratedFiles['MessageFiles']['MessageFile']!='')
		{
			$messageFile = basename($this->m_GeneratedFiles['MessageFiles']['MessageFile']);
		}		
		
		if($this->m_ConfigModule['data_perm']=='0')
		{
			$doPermControl = "N";
		}
		else
		{
			$doPermControl = "Y";
		}		
		
		if(CLI){echo "Start generate form metadata $formName." . PHP_EOL;}
        $targetPath = $moduleDir = MODULE_PATH . "/" . str_replace(".", "/", $modName) . "/form";
        if (!file_exists($targetPath))
        {
            if(CLI){echo "Create directory $targetPath" . PHP_EOL;}
            mkdir($targetPath, 0777, true);
        }
		
        if( $features['data_type']==1 || $doPermControl=='Y' )
        {
        	$formTemplate = "form_grid_adv.tpl.html";
        }
        else
        {
        	$formTemplate = "form_grid.tpl.html";  
        }

        $smarty = BizSystem::getSmartyTemplate();
        
        $smarty->assign("do_full_name", $doFullName);
        $smarty->assign("do_name", $doName);                   
        $smarty->assign("fields", $this->m_DBFieldsInfo);
        $smarty->assign("search_field", $this->m_DBSearchField);      
        $smarty->assign("do_perm_control", $doPermControl);                               
        $smarty->assign("features", $features);
        $smarty->assign("acl", $aclArr);     
        $smarty->assign("detail_view_url", $detailViewURL);
        $smarty->assign("list_view_url", $listViewURL);		
       	
		$smarty->assign("new_form_full_name", 	$formNewFullName);  
		$smarty->assign("new_form_name", 		$formNewName);  
        $smarty->assign("copy_form_full_name", 	$formCopyFullName);  
		$smarty->assign("copy_form_name", 		$formCopyName);
		$smarty->assign("edit_form_full_name", 	$formEditFullName);  
		$smarty->assign("edit_form_name", 		$formEditName);
		$smarty->assign("detail_form_full_name",$formDetailFullName);  
		$smarty->assign("detail_form_name", 	$formDetailName);
		$smarty->assign("list_form_full_name", 	$formListFullName);  
		$smarty->assign("list_form_name", 		$formListName);
		$smarty->assign("custom_form_full_name",$formCustomFullName);  
		$smarty->assign("custom_form_name", 	$formCustomName);
		
		//form specified variables		
		$formTitle  = $this->__getFormName()." Type Management";
        $eventName = $this->__getObjectName();		
		$formIcon = "{RESOURCE_URL}/$modShortName/images/icon_mod_".$this->__getObjectFileName().'_type_list.png';
		$shareIcons = array(
			"icon_type_private"					=>	'{RESOURCE_URL}/'.$modShortName.'/images/icon_data_type_private.gif',
			"icon_type_shared"					=>	'{RESOURCE_URL}/'.$modShortName.'/images/icon_data_type_shared.gif',
			"icon_type_shared_group"			=>	'{RESOURCE_URL}/'.$modShortName.'/images/icon_data_type_shared_group.gif',
			"icon_type_shared_other"			=>	'{RESOURCE_URL}/'.$modShortName.'/images/icon_data_type_shared_other.gif'
		);
		
        $smarty->assign("form_name", 		$formListName);
        $smarty->assign("form_class",		$formClass);
        $smarty->assign("form_icon", 		$formIcon);
        $smarty->assign("form_title", 		$formTitle);
        $smarty->assign("form_description", $formDescription);
        $smarty->assign("form_template",	$formTemplate);
		$smarty->assign("form_do", 			$doFullName);
		$smarty->assign("form_type_do", 	$typeDoFullName);		
		$smarty->assign("event_name",		$eventName);
		$smarty->assign("message_file",		$messageFile);
		$smarty->assign("share_icons", 		$shareIcons);
		$smarty->assign("record_default_value", 	"New ".ucfirst($modShortName)." Type");
		
        
		$content = $smarty->fetch($templateFile);
                
        $targetFile = $targetPath . "/" . $formListName . ".xml";
        file_put_contents($targetFile, $content);            
		$this->m_GeneratedFiles['TypeListForm']=str_replace(MODULE_PATH,"",$targetFile);

		//generate detail type form 
		$templateFile = $this->__getMetaTempPath().'/form/TypeDetailForm.xml.tpl';
		$formTitle  = $this->__getFormName()." Type Detail";
        $eventName = $this->__getObjectName();		
		$formIcon = "{RESOURCE_URL}/$modShortName/images/icon_mod_".$this->__getObjectFileName().'_type_detail.png';
		$formTemplate = "form_detail_elementset.tpl.html";
		
        $smarty->assign("form_name", 		$formDetailName);
        $smarty->assign("form_class",		$formClass);
        $smarty->assign("form_icon", 		$formIcon);
        $smarty->assign("form_title", 		$formTitle);
        $smarty->assign("form_description", $formDescription);
        $smarty->assign("form_template",	$formTemplate);
		$smarty->assign("form_do", 			$doFullName);
		$smarty->assign("form_type_do", 	$typeDoFullName);		
		$smarty->assign("event_name",		$eventName);
		$smarty->assign("message_file",		$messageFile);
		$smarty->assign("share_icons", 		$shareIcons);
		
		$content = $smarty->fetch($templateFile);
        $targetFile = $targetPath . "/" . $formDetailName . ".xml";
        file_put_contents($targetFile, $content);    
		$this->m_GeneratedFiles['TypeDetailForm']=str_replace(MODULE_PATH,"",$targetFile);		
		
		
		//generate custom type form 
		$templateFile = $this->__getMetaTempPath().'/form/TypeCustomForm.xml.tpl';
		$formTitle  = "Custom ".$this->__getFormName()." Type";
        $eventName = $this->__getObjectName();		
		$formIcon = "{RESOURCE_URL}/$modShortName/images/icon_mod_".$this->__getObjectFileName().'_type_edit.png';
		$formTemplate = "form_detail_adv.tpl.html";
		
        $smarty->assign("form_name", 		$formCustomName);
        $smarty->assign("form_class",		$formClass);
        $smarty->assign("form_icon", 		$formIcon);
        $smarty->assign("form_title", 		$formTitle);
        $smarty->assign("form_description", $formDescription);
        $smarty->assign("form_template",	$formTemplate);
		$smarty->assign("form_do", 			$doFullName);
		$smarty->assign("form_type_do", 	$typeDoFullName);		
		$smarty->assign("event_name",		$eventName);
		$smarty->assign("message_file",		$messageFile);
		$smarty->assign("share_icons", 		$shareIcons);
		
		$content = $smarty->fetch($templateFile);
        $targetFile = $targetPath . "/" . $formCustomName . ".xml";
        file_put_contents($targetFile, $content);    
		$this->m_GeneratedFiles['TypeCustomForm']=str_replace(MODULE_PATH,"",$targetFile);		
		
		
		
		//generate new type form 
		$templateFile = $this->__getMetaTempPath().'/form/TypeNewForm.xml.tpl';
		$formTitle  = "New ".$this->__getFormName()." Type";
        $eventName = $this->__getObjectName();		
		$formIcon = "{RESOURCE_URL}/$modShortName/images/icon_mod_".$this->__getObjectFileName().'_type_add.png';
		$formTemplate = "form_edit.tpl.html";
		
        $smarty->assign("form_name", 		$formNewName);
        $smarty->assign("form_class",		$formClass);
        $smarty->assign("form_icon", 		$formIcon);
        $smarty->assign("form_title", 		$formTitle);
        $smarty->assign("form_description", $formDescription);
        $smarty->assign("form_template",	$formTemplate);
		$smarty->assign("form_do", 			$doFullName);
		$smarty->assign("form_type_do", 	$typeDoFullName);		
		$smarty->assign("event_name",		$eventName);
		$smarty->assign("message_file",		$messageFile);
		$smarty->assign("share_icons", 		$shareIcons);
		
		$content = $smarty->fetch($templateFile);
        $targetFile = $targetPath . "/" . $formNewName . ".xml";
        file_put_contents($targetFile, $content);    
		$this->m_GeneratedFiles['TypeNewForm']=str_replace(MODULE_PATH,"",$targetFile);
		
		
		
		//generate copy type form 
		$templateFile = $this->__getMetaTempPath().'/form/TypeCopyForm.xml.tpl';
		$formTitle  = "Copy ".$this->__getFormName()." Type";
        $eventName = $this->__getObjectName();		
		$formIcon = "{RESOURCE_URL}/$modShortName/images/icon_mod_".$this->__getObjectFileName().'_type_copy.png';
		$formTemplate = "form_edit.tpl.html";
		
        $smarty->assign("form_name", 		$formCopyName);
        $smarty->assign("form_class",		$formClass);
        $smarty->assign("form_icon", 		$formIcon);
        $smarty->assign("form_title", 		$formTitle);
        $smarty->assign("form_description", $formDescription);
        $smarty->assign("form_template",	$formTemplate);
		$smarty->assign("form_do", 			$doFullName);
		$smarty->assign("form_type_do", 	$typeDoFullName);		
		$smarty->assign("event_name",		$eventName);
		$smarty->assign("message_file",		$messageFile);
		$smarty->assign("share_icons", 		$shareIcons);
		
		$content = $smarty->fetch($templateFile);
        $targetFile = $targetPath . "/" . $formCopyName . ".xml";
        file_put_contents($targetFile, $content);  
		$this->m_GeneratedFiles['TypeCopyForm']=str_replace(MODULE_PATH,"",$targetFile);
		
		//generate edit type form 
		$templateFile = $this->__getMetaTempPath().'/form/TypeEditForm.xml.tpl';
		$formTitle  = "Edit ".$this->__getFormName()." Type";
        $eventName = $this->__getObjectName();		
		$formIcon = "{RESOURCE_URL}/$modShortName/images/icon_mod_".$this->__getObjectFileName().'_type_edit.png';
		$formTemplate = "form_edit.tpl.html";
		
        $smarty->assign("form_name", 		$formEditName);
        $smarty->assign("form_class",		$formClass);
        $smarty->assign("form_icon", 		$formIcon);
        $smarty->assign("form_title", 		$formTitle);
        $smarty->assign("form_description", $formDescription);
        $smarty->assign("form_template",	$formTemplate);
		$smarty->assign("form_do", 			$doFullName);
		$smarty->assign("form_type_do", 	$typeDoFullName);		
		$smarty->assign("event_name",		$eventName);
		$smarty->assign("message_file",		$messageFile);
		$smarty->assign("share_icons", 		$shareIcons);
		
		$content = $smarty->fetch($templateFile);
        $targetFile = $targetPath . "/" . $formEditName . ".xml";
        file_put_contents($targetFile, $content);  
		$this->m_GeneratedFiles['TypeEditForm']=str_replace(MODULE_PATH,"",$targetFile);
	}
	
	/**
	 * Generate Form Objects for Extend Type Feature
	 */
	protected function _genExtendTypeView()
	{
		if($this->m_BuildOptions["gen_view_object"]!='1')
		{
			return false;
		}
		$templateFile = $this->__getMetaTempPath().'/view/TypeView.xml.tpl';
		$viewName 	= $this->__getObjectName()."TypeView";
		$viewDesc 	= "Type of ".$this->m_ConfigModule['object_desc'];			
		$modName 	= $this->__getModuleName(); 	
		$modBaseName= $this->__getModuleName(false);
		$aclArr     = $this->_getACLArr();				
		$defaultFormName = $modName.'.form.'.$this->__getObjectName().'TypeListForm';
		
        $smarty = BizSystem::getSmartyTemplate();
        $smarty->assign("type_view_name", $viewName);
        $smarty->assign("type_view_desc", $viewDesc);        
        $smarty->assign("default_form_name", $defaultFormName);
        $smarty->assign("acl", $aclArr);
        $content = $smarty->fetch($templateFile);
                
        $targetPath = $moduleDir = MODULE_PATH . "/" . str_replace(".", "/", $modBaseName) . "/view";
        $targetFile = $targetPath . "/" . $viewName . ".xml";
        file_put_contents($targetFile, $content);      
		$this->m_GeneratedFiles['ViewObjFiles']['TypeManageView']=str_replace(MODULE_PATH,"",$targetFile);
	}
	
	private function __addDOField($fieldName)
	{
		$tableName 	= $this->m_DBTable;
		$db 		= BizSystem::dbConnection($this->m_DBName);	
		$sql 		= "ALTER TABLE `$tableName` ADD `type_id` INT( 11 ) NOT NULL AFTER `id` , ADD INDEX ( `type_id` ) ;";
		$db->query($sql);		
	}
	
	private function __isFieldExists($fieldName)
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
	
	private function __isTableExists($tableName)
	{
		$db 	= BizSystem::dbConnection($this->m_DBName);
		$sql	= "SHOW TABLES";
		$fieldsInfo = $db->fetchAssoc($sql);
		foreach($fieldsInfo as $listTableName=>$listTableInfo)
		{
			if($listTableName == $tableName)
			{						
				return true;
			}
		}
		return false;		
	}
	
	protected function _genSelfReferenceDO()
	{				
		if($this->m_BuildOptions["gen_data_object"]!='1')
		{
			return false;
		}
		
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
		$this->m_GeneratedFiles['DataObjFiles']['MainRefDO']=str_replace(MODULE_PATH,"",$targetFile);
		
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
        $this->m_GeneratedFiles['DataObjFiles']['MainRelatedDO']=str_replace(MODULE_PATH,"",$targetFile);
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
				$arr['FieldName'] 	= ucwords($arr['Field']);
				$arr['FieldType'] 	= $this->__convertDataType($arr['Type']);
				$arr['Description'] = $this->__getFieldDesc($arr);
				$arr['FieldLabel'] 	= $arr['Description'];
				$resultSet[$key] 	= $arr;
				
				if($arr['Key']=='MUL')
				{
					$this->m_DBSearchField = $arr; 
				}
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
	
	protected function _genInstallSQL()
	{
		if($this->m_BuildOptions["gen_mod"]!='1')
		{
			return false;
		}
		$modBaseName= $this->__getModuleName(false);
		
        $targetPath = $moduleDir = MODULE_PATH . "/" . str_replace(".", "/", $modBaseName) ;       
        $targetFile = $targetPath . "/mod.install.sql";
        
		if(is_file($targetFile)){
			$content = file_get_contents($targetFile);
		}
        
		$dbInfo = BizSystem::instance()->getConfiguration()->getDatabaseInfo($this->m_DBName);
		$host 	= $dbInfo["Server"];
        $user	= $dbInfo["User"];
        $pass	= $dbInfo["Password"];
        $db		= $dbInfo["DBName"];
        $port	= $dbInfo["Port"];
        $charset= $dbInfo["Charset"];
		$host   = $host.':'.$port;
		
		$svc = BizSystem::getObject("appbuilder.lib.MySQLDumpService");
		$svc->connect($host,$user,$pass,$db,$charset);
		$svc->droptableifexists=true;
		$svc->get_table_structure($this->m_DBTable);		
		$SQLStr = trim($svc->output)."\n\n";
				
		$content = str_replace($SQLStr, "", $content);
		$content .= $SQLStr;
        file_put_contents($targetFile, $content); 
	}
	
	protected function _genUninstallSQL()
	{
		if($this->m_BuildOptions["gen_mod"]!='1')
		{
			return false;
		}
		$modBaseName= $this->__getModuleName(false);
		
        $targetPath = $moduleDir = MODULE_PATH . "/" . str_replace(".", "/", $modBaseName) ;       
        $targetFile = $targetPath . "/mod.uninstall.sql";
        
		if(is_file($targetFile)){
			$content = file_get_contents($targetFile);
		}
        
		$SQLStr = "DROP TABLE IF EXISTS `$this->m_DBTable`;\n";
		$content = str_replace($SQLStr, "", $content);
		$content .= $SQLStr;
        file_put_contents($targetFile, $content);   
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
						"picture"			=>	(int) $this->m_ConfigModule['picture_feature'],
						"location"			=>	(int) $this->m_ConfigModule['location_feature'],
						"changelog"			=>	(int) $this->m_ConfigModule['changelog_feature'],
						"attachment"		=>	(int) $this->m_ConfigModule['attachment_feature'],
						"widget"			=>	(int) $this->m_ConfigModule['widget_feature'],
						"self_reference"	=>	(int) $this->m_ConfigModule['selfref_feature'],
						"extend"			=>	(int) $this->m_ConfigModule['extend_feature'],
						"data_type"			=>	(int) $this->m_ConfigModule['data_type_feature'],															
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
	
	protected function _getResourceACL()
	{
		if(is_array($this->m_ResourceACL))
		{
			return $this->m_ResourceACL;
		}
		else
		{
	        $resource = $this->_getResourceName();
	        $acl = $this->m_ConfigModule['acl_type'];
	        switch ($acl) {
	            case 0: //0 - No Access Control 
	                $this->m_ResourceACL[$resource]	= array(); 
	                break;	        	
	            case 1: //1 - Access and Manage (Default)
	                $this->m_ResourceACL[$resource]	= array( "Access"=>"Data access permission of $resource",
	                										 "Manage"=>"Data manage permission of $resource"
	                										); 
	                break;
	            case 2: //2 - Access, Create, Update and Delete
	                $this->m_ResourceACL[$resource]	= array( 'Access'=>"Data access permission of $resource", 					                							
					                                         'Create'=>"Data create permission of $resource", 
					                                         'Update'=>"Data update permission of $resource", 
					                                         'Delete'=>"Data delete permission of $resource"); 
	                break;
	        }
	        return $this->m_ResourceACL;
		}
	}
	
	protected function _getMenuSet()
	{
		$acl		= $this->_getACLArr();
		$resource 	= $this->_getResourceName();
		$features	= $this->_getExtendFeatures();
		$modName	= $this->__getModuleName();
		$modBaseName= $this->__getModuleName(false);
		
		//if it has a sub module name use that, or use table name
		if($this->m_ConfigModule['sub_module_name'])
		{
			$menuName = $this->m_ConfigModule['sub_module_name'];	
			$menuName = ucwords($menuName);
		}
		else
		{
			$tableName = $this->m_DBTable;
			$menuName = str_replace("_", " ", $tableName);
			$menuName = str_replace("-", " ", $menuName);	
			$menuName = ucwords($menuName);	
			$menuName = str_replace(" ", "_", $menuName);
		}
		
		$menu		= array();
		$menu[$resource] = array(
									"name" => $modBaseName.'_'.strtolower($menuName),
									"title" => str_replace("_", " ", $menuName),
									"description" => '',
									"uri" => '',
									"icon_css" => 'icon_'.$resource,
									"acl" => $acl['access'],		
								);
								
		$viewName = $this->__getViewName();
		$menuManageItem = array(
									"name" => $modBaseName.'_'.strtolower($menuName)."_manage",
									"title" => str_replace("_", " ", $menuName).' Manage',
									"description" => 'Manage of '.str_replace("_", " ", $menuName),
									"uri" => '{APP_INDEX}/'.$modBaseName.'/'.$viewName.'_manage',
									"icon_css" => '',
									"acl" => $acl['access'],
								);
		$menuDetailItem = array(
									"name" => $modBaseName.'_'.strtolower($menuName)."_detail",
									"title" => str_replace("_", " ", $menuName).' Detail',
									"description" => 'Detail of '.str_replace("_", " ", $menuName),
									"uri" => '{APP_INDEX}/'.$modBaseName.'/'.$viewName.'_detail',
									"icon_css" => '',
									"acl" => $acl['access'],
								);								
		$menuManageItem['child']['detail'] = $menuDetailItem;
		$menu[$resource]['child']['manage'] = $menuManageItem;
		
		if($features['data_type']==1)
        {  
			$menuTypeItem = array(
									"name" => $modBaseName.'_'.strtolower($menuName)."_type",
									"title" => str_replace("_", " ", $menuName).' Type',
									"description" => 'Type of '.str_replace("_", " ", $menuName),
									"uri" => '{APP_INDEX}/'.$modBaseName.'/'.$viewName.'_type',
									"icon_css" => '',
									"acl" => $acl['access'],
									);
			$menu[$resource]['child']['type'] = $menuTypeItem;
        }
		return $menu;
	}
	
	protected function _genFormObj()
	{
		if($this->m_BuildOptions["gen_form_object"]!='1')
		{
			return false;
		}

		//generate list form metadata
		//shared variables
		$templateFile = $this->__getMetaTempPath().'/form/ListForm.xml.tpl';
		$doName 	= $this->m_ConfigModule['object_name'];
		$doDesc 	= $this->m_ConfigModule['object_desc'];					
		$modName 	= $this->__getModuleName(); 	
		$modShortName 	= $this->__getModuleName(false); 			
		$uniqueness = $this->_getUniqueness();
		$sortField  = $this->_getSortField();
		$aclArr     = $this->_getACLArr();		
		$features	= $this->_getExtendFeatures();		
		$doFullName = $modName.'.do.'.$this->m_ConfigModule['object_name'];
		$extendFeature = $features['extend'];
		$formClass  = "EasyForm";				
		$detailViewURL = $modShortName.'/'.$this->__getViewName().'_detail';
		$listViewURL = $modShortName.'/'.$this->__getViewName().'_manage';
		
		$formListName 				= $this->__getObjectName().'ListForm';
		$formListFullName 			= $modName.'.form.'.$formListName;				
		$formDetailName  			= $this->__getObjectName().'DetailForm';
		$formDetailFullName  		= $modName.'.form.'.$formDetailName;
		$formCopyName  				= $this->__getObjectName().'CopyForm';
		$formCopyFullName  			= $modName.'.form.'.$formCopyName;		
		$formEditName  				= $this->__getObjectName().'EditForm';
		$formEditFullName  			= $modName.'.form.'.$formEditName;		
		$formNewName  				= $this->__getObjectName().'NewForm';
		$formNewFullName 			= $modName.'.form.'.$formNewName;
		$formEditExtendName			= $this->__getObjectName().'EditExtendForm';
		$formEditExtendFullName 	= $modName.'.form.'.$formEditExtendName;
		$formEditAttachmentName 	= $this->__getObjectName().'EditAttachmentForm';
		$formEditAttachmentFullName = $modName.'.form.'.$formEditAttachmentName;
		$formEditPictureName 		= $this->__getObjectName().'EditPictureForm';
		$formEditPictureFullName 	= $modName.'.form.'.$formEditPictureName;
		$formEditLocationName 		= $this->__getObjectName().'EditLocationForm';
		$formEditLocationFullName 	= $modName.'.form.'.$formEditLocationName;
		
		$messageFile = "";
		if($this->m_GeneratedFiles['MessageFiles']['MessageFile']!='')
		{
			$messageFile = basename($this->m_GeneratedFiles['MessageFiles']['MessageFile']);
		}		
		
		if($this->m_ConfigModule['data_perm']=='0')
		{
			$doPermControl = "N";
		}
		else
		{
			$doPermControl = "Y";
		}		
		
		if(CLI){echo "Start generate form metadata $formName." . PHP_EOL;}
        $targetPath = $moduleDir = MODULE_PATH . "/" . str_replace(".", "/", $modName) . "/form";
        if (!file_exists($targetPath))
        {
            if(CLI){echo "Create directory $targetPath" . PHP_EOL;}
            mkdir($targetPath, 0777, true);
        }

	    if($features['data_type']==1)
        {        	        	
        	$this->_genExtendTypeForm();    
        	$typeDoFullName = $this->m_TypeDOFullName;  
        	  	
        }
        
        if( $features['data_type']==1 || $doPermControl=='Y' )
        {
        	$formTemplate = "form_grid_adv.tpl.html";
        }
        else
        {
        	$formTemplate = "form_grid.tpl.html";  
        }

        $smarty = BizSystem::getSmartyTemplate();
        
        $smarty->assign("do_full_name", $doFullName);
        $smarty->assign("do_name", $doName);                   
        $smarty->assign("fields", $this->m_DBFieldsInfo);
        $smarty->assign("search_field", $this->m_DBSearchField);      
        $smarty->assign("do_perm_control", $doPermControl);                               
        $smarty->assign("features", $features);
        $smarty->assign("acl", $aclArr);     
        $smarty->assign("detail_view_url", $detailViewURL);
        $smarty->assign("list_view_url", $listViewURL);		
       	
		$smarty->assign("new_form_full_name", 	$formNewFullName);  
		$smarty->assign("new_form_name", 		$formNewName);  
        $smarty->assign("copy_form_full_name", 	$formCopyFullName);  
		$smarty->assign("copy_form_name", 		$formCopyName);
		$smarty->assign("edit_form_full_name", 	$formEditFullName);  
		$smarty->assign("edit_form_name", 		$formEditName);
		$smarty->assign("detail_form_full_name",$formDetailFullName);  
		$smarty->assign("detail_form_name", 	$formDetailName);
		$smarty->assign("list_form_full_name", 	$formListFullName);  
		$smarty->assign("list_form_name", 		$formListName);
		$smarty->assign("extend_form_full_name", $formEditExtendFullName);  
		$smarty->assign("extend_form_name", 	 $formEditExtendName);
		$smarty->assign("attachment_form_full_name", $formEditAttachmentFullName);  
		$smarty->assign("attachment_form_name", 	 $formEditAttachmentName);
		$smarty->assign("picture_form_full_name", $formEditPictureFullName);  
		$smarty->assign("picture_form_name", 	 $formEditPictureName);
		$smarty->assign("location_form_full_name", $formEditLocationFullName);  
		$smarty->assign("location_form_name", 	 $formEditLocationName);
		
		
	
		if($features['widget']==1)
		{
			
			$listWidgetFormName					= $this->__getObjectName().'ListWidgetForm';
			$listWidgetFormFullName 			= $modName.'.widget.'.$listWidgetFormName;			
			$listEditableWidgetFormName			= $this->__getObjectName().'ListEditableWidgetForm';
			$listEditableWidgetFormFullName 	= $modName.'.widget.'.$listEditableWidgetFormName;
			$pickWidgetFormName					= $this->__getObjectName().'PickWidgetForm';
			$pickWidgetFormFullName 			= $modName.'.widget.'.$pickWidgetFormName;
			$quickAddWidgetFormName				= $this->__getObjectName().'QuickAddWidgetForm';
			$quickAddWidgetFormFullName 		= $modName.'.widget.'.$quickAddWidgetFormName;
			
			$smarty->assign("list_widget_name", 				$listWidgetFormName);
			$smarty->assign("list_widget_full_name", 			$listWidgetFormFullName); 
			$smarty->assign("list_editable_widget_name", 		$listEditableWidgetFormName);
			$smarty->assign("list_editable_widget_full_name", 	$listEditableWidgetFormFullName); 
			$smarty->assign("pick_widget_name", 				$pickWidgetFormName);
			$smarty->assign("pick_widget_full_name", 			$pickWidgetFormFullName); 
			$smarty->assign("quick_add_widget_name", 			$quickAddWidgetFormName);
			$smarty->assign("quick_add_widget_full_name", 		$quickAddWidgetFormFullName); 			
		}
		
		if($features['self_reference']==1)
		{
			$listRelatedWidgetFormName					= $this->__getObjectName().'ListRelatedWidgetForm';
			$listRelatedWidgetFormFullName 				= $modName.'.widget.'.$listRelatedWidgetFormName;	
			$listRelatedEditableWidgetFormName			= $this->__getObjectName().'ListRelatedEditableWidgetForm';
			$listRelatedEditableWidgetFormFullName 		= $modName.'.widget.'.$listRelatedEditableWidgetFormName;				
			$formEditRelatedName						= $this->__getObjectName().'EditRelatedForm';
			$formEditRelatedFullName					= $modName.'.form.'.$formEditRelatedName;
			
			$smarty->assign("list_related_widget_name", 				$listRelatedWidgetFormName);
			$smarty->assign("list_related_widget_full_name", 			$listRelatedWidgetFormFullName); 
			$smarty->assign("list_related_editable_widget_name", 		$listRelatedEditableWidgetFormName);
			$smarty->assign("list_related_editable_widget_full_name", 	$listRelatedEditableWidgetFormFullName);
			$smarty->assign("related_form_name", 						$formEditRelatedName);
			$smarty->assign("related_form_full_name", 					$formEditRelatedFullName); 			
		}
		
		//form specified variables
		$formTitle  = $this->__getFormName()." Management";
		$formDescription = $this->m_ConfigModule['object_desc'];
		
		
		
		
		$eventName = $this->__getObjectName();		
		$formIcon = "{RESOURCE_URL}/$modShortName/images/icon_mod_".$this->__getObjectFileName().'_list.png';
		$shareIcons = array(
			"icon_private"				=>	'{RESOURCE_URL}/'.$modShortName.'/images/icon_'.$modShortName.'_private.gif',
			"icon_shared"				=>	'{RESOURCE_URL}/'.$modShortName.'/images/icon_'.$modShortName.'_shared.gif',
			"icon_assigned"				=>	'{RESOURCE_URL}/'.$modShortName.'/images/icon_'.$modShortName.'_assigned.gif',
			"icon_shared_distributed"	=>	'{RESOURCE_URL}/'.$modShortName.'/images/icon_'.$modShortName.'_distributed.gif',
			"icon_shared_group"			=>	'{RESOURCE_URL}/'.$modShortName.'/images/icon_'.$modShortName.'_shared_group.gif',
			"icon_shared_other"			=>	'{RESOURCE_URL}/'.$modShortName.'/images/icon_'.$modShortName.'_shared_other.gif'
		);
		
        $smarty->assign("form_name", 		$formListName);
        $smarty->assign("form_class",		$formClass);
        $smarty->assign("form_icon", 		$formIcon);
        $smarty->assign("form_title", 		$formTitle);
        $smarty->assign("form_description", $formDescription);
        $smarty->assign("form_template",	$formTemplate);
		$smarty->assign("form_do", 			$doFullName);
		$smarty->assign("form_type_do", 	$typeDoFullName);		
		$smarty->assign("event_name",		$eventName);
		$smarty->assign("message_file",		$messageFile);
		$smarty->assign("share_icons", 		$shareIcons);
        
		$content = $smarty->fetch($templateFile);
                
        $targetFile = $targetPath . "/" . $formListName . ".xml";
        file_put_contents($targetFile, $content);       
		$this->m_GeneratedFiles['FormObjFiles']['ListForm']=str_replace(MODULE_PATH,"",$targetFile);				
		
		
		
		//generate Detail form metadata		
		$formTitle  = $this->__getFormName()." Detail";	
		$formIcon = "{RESOURCE_URL}/$modShortName/images/icon_mod_".$this->__getObjectFileName().'_detail.png';
				
	 	if( $features['data_type']==1  )
        {
        	if( $features['extend']==1  )
        	{
        		$formTemplate = "form_detail_adv_custom.tpl.html";
        	}
        	else
        	{
        		$formTemplate = "form_detail_adv.tpl.html";
        	}
        }
        else
        {
        	$formTemplate = "form_detail.tpl.html";  
        }
		
		$templateFile = $this->__getMetaTempPath().'/form/DetailForm.xml.tpl';
		$smarty->assign("form_name", 		$formDetailName);
        $smarty->assign("form_class",		$formClass);
        $smarty->assign("form_icon", 		$formIcon);
        $smarty->assign("form_title", 		$formTitle);
        $smarty->assign("form_description", $formDescription);
        $smarty->assign("form_template",	$formTemplate);
		$smarty->assign("form_do", 			$doFullName);
		$smarty->assign("form_type_do", 	$typeDoFullName);		
		$smarty->assign("event_name",		$eventName);
		$smarty->assign("message_file",		$messageFile);        
		$content = $smarty->fetch($templateFile);
        $targetFile = $targetPath . "/" . $formDetailName . ".xml";
        file_put_contents($targetFile, $content);     
		$this->m_GeneratedFiles['FormObjFiles']['DetailForm']=str_replace(MODULE_PATH,"",$targetFile);

		
		//generate New form metadata	
		$formTitle  = "New ".$this->__getFormName();	
		$formIcon = "{RESOURCE_URL}/$modShortName/images/icon_mod_".$this->__getObjectFileName().'_add.png';						
		$formTemplate = "form_edit.tpl.html";  	 	
		
		$templateFile = $this->__getMetaTempPath().'/form/NewForm.xml.tpl';
		$smarty->assign("form_name", 		$formNewName);
        $smarty->assign("form_class",		$formClass);
        $smarty->assign("form_icon", 		$formIcon);
        $smarty->assign("form_title", 		$formTitle);
        $smarty->assign("form_description", $formDescription);
        $smarty->assign("form_template",	$formTemplate);
		$smarty->assign("form_do", 			$doFullName);
		$smarty->assign("form_type_do", 	$typeDoFullName);		
		$smarty->assign("event_name",		$eventName);
		$smarty->assign("message_file",		$messageFile);        
		$content = $smarty->fetch($templateFile);
        $targetFile = $targetPath . "/" . $formNewName . ".xml";
        file_put_contents($targetFile, $content);     	
		$this->m_GeneratedFiles['FormObjFiles']['NewForm']=str_replace(MODULE_PATH,"",$targetFile);
		
		//generate Edit form metadata	
		$formTitle  = "Edit ".$this->__getFormName();	
		$formIcon = "{RESOURCE_URL}/$modShortName/images/icon_mod_".$this->__getObjectFileName().'_edit.png';						
		$formTemplate = "form_edit.tpl.html";  	 	
				
		if($features['changelog']==1)
		{
			$formClass = "changelog.form.ChangeLogForm";
		}
		
		$templateFile = $this->__getMetaTempPath().'/form/EditForm.xml.tpl';
		$smarty->assign("form_name", 		$formEditName);
        $smarty->assign("form_class",		$formClass);
        $smarty->assign("form_icon", 		$formIcon);
        $smarty->assign("form_title", 		$formTitle);
        $smarty->assign("form_description", $formDescription);
        $smarty->assign("form_template",	$formTemplate);
		$smarty->assign("form_do", 			$doFullName);
		$smarty->assign("form_type_do", 	$typeDoFullName);		
		$smarty->assign("event_name",		$eventName);
		$smarty->assign("message_file",		$messageFile);        
		$content = $smarty->fetch($templateFile);
        $targetFile = $targetPath . "/" . $formEditName . ".xml";
        file_put_contents($targetFile, $content);   
		$this->m_GeneratedFiles['FormObjFiles']['EditForm']=str_replace(MODULE_PATH,"",$targetFile);
		
		
		//generate Copy form metadata	
		$formClass  = "EasyForm";
		$formTitle  = "Copy ".$this->__getFormName();	
		$formIcon = "{RESOURCE_URL}/$modShortName/images/icon_mod_".$this->__getObjectFileName().'_copy.png';						
		$formTemplate = "form_edit.tpl.html";  	 	
		
		$templateFile = $this->__getMetaTempPath().'/form/CopyForm.xml.tpl';
		$smarty->assign("form_name", 		$formCopyName);
        $smarty->assign("form_class",		$formClass);
        $smarty->assign("form_icon", 		$formIcon);
        $smarty->assign("form_title", 		$formTitle);
        $smarty->assign("form_description", $formDescription);
        $smarty->assign("form_template",	$formTemplate);
		$smarty->assign("form_do", 			$doFullName);
		$smarty->assign("form_type_do", 	$typeDoFullName);		
		$smarty->assign("event_name",		$eventName);
		$smarty->assign("message_file",		$messageFile);        
		$content = $smarty->fetch($templateFile);
        $targetFile = $targetPath . "/" . $formCopyName . ".xml";
        file_put_contents($targetFile, $content);   
		$this->m_GeneratedFiles['FormObjFiles']['CopyForm']=str_replace(MODULE_PATH,"",$targetFile);

		if($features['extend']==1)
		{
			//generate edit extend form metadata		
			$formTitle  = "Edit ".$this->__getFormName()." Extend Fields";	
			$formIcon = "{RESOURCE_URL}/$modShortName/images/icon_mod_".$this->__getObjectFileName().'_extend.png';
			
			$formTemplate = "form_edit_extend.tpl.html";
			
			$templateFile = $this->__getMetaTempPath().'/form/EditExtendForm.xml.tpl';
			$smarty->assign("form_name", 		$formEditExtendName);
	        $smarty->assign("form_class",		$formClass);
	        $smarty->assign("form_icon", 		$formIcon);
	        $smarty->assign("form_title", 		$formTitle);
	        $smarty->assign("form_description", $formDescription);
	        $smarty->assign("form_template",	$formTemplate);
			$smarty->assign("form_do", 			$doFullName);
			$smarty->assign("form_type_do", 	$typeDoFullName);		
			$smarty->assign("event_name",		$eventName);
			$smarty->assign("message_file",		$messageFile);        
			$content = $smarty->fetch($templateFile);
	        $targetFile = $targetPath . "/" . $formEditExtendName . ".xml";
	        file_put_contents($targetFile, $content);     
			$this->m_GeneratedFiles['FormObjFiles']['EditExtendForm']=str_replace(MODULE_PATH,"",$targetFile);
		}
		
		if($features['attachment']==1)
		{
			//generate edit attachment form metadata		
			$formTitle  = "Edit ".$this->__getFormName()." Attachments";	
			$formIcon = "{RESOURCE_URL}/$modShortName/images/icon_mod_".$this->__getObjectFileName().'_attachment.png';
			$formDescription = "This form could help you manage ".$this->__getObjectFileName()." attachments.";
			$formTemplate = "form_detail_adv.tpl.html";
			
			$templateFile = $this->__getMetaTempPath().'/form/EditAttachmentForm.xml.tpl';
			$smarty->assign("form_name", 		$formEditAttachmentName);
	        $smarty->assign("form_class",		$formClass);
	        $smarty->assign("form_icon", 		$formIcon);
	        $smarty->assign("form_title", 		$formTitle);
	        $smarty->assign("form_description", $formDescription);
	        $smarty->assign("form_template",	$formTemplate);
			$smarty->assign("form_do", 			$doFullName);
			$smarty->assign("form_type_do", 	$typeDoFullName);		
			$smarty->assign("event_name",		$eventName);
			$smarty->assign("message_file",		$messageFile);        
			$content = $smarty->fetch($templateFile);
	        $targetFile = $targetPath . "/" . $formEditAttachmentName . ".xml";
	        file_put_contents($targetFile, $content);     
			$this->m_GeneratedFiles['FormObjFiles']['EditAttachmentForm']=str_replace(MODULE_PATH,"",$targetFile);
		}

		if($features['picture']==1)
		{
			//generate edit attachment form metadata		
			$formTitle  = "Edit ".$this->__getFormName()." Pictures";	
			$formIcon = "{RESOURCE_URL}/$modShortName/images/icon_mod_".$this->__getObjectFileName().'_picture.png';
			$formDescription = "This form could help you manage ".$this->__getObjectFileName()." pictures.";
			$formTemplate = "form_detail_adv.tpl.html";
			
			$templateFile = $this->__getMetaTempPath().'/form/EditPictureForm.xml.tpl';
			$smarty->assign("form_name", 		$formEditPictureName);
	        $smarty->assign("form_class",		$formClass);
	        $smarty->assign("form_icon", 		$formIcon);
	        $smarty->assign("form_title", 		$formTitle);
	        $smarty->assign("form_description", $formDescription);
	        $smarty->assign("form_template",	$formTemplate);
			$smarty->assign("form_do", 			$doFullName);
			$smarty->assign("form_type_do", 	$typeDoFullName);		
			$smarty->assign("event_name",		$eventName);
			$smarty->assign("message_file",		$messageFile);        
			$content = $smarty->fetch($templateFile);
	        $targetFile = $targetPath . "/" . $formEditPictureName . ".xml";
	        file_put_contents($targetFile, $content);     
			$this->m_GeneratedFiles['FormObjFiles']['EditPictureForm']=str_replace(MODULE_PATH,"",$targetFile);
		}	

		if($features['location']==1)
		{
			//generate edit location form metadata		
			$formTitle  = "Edit ".$this->__getFormName()." Geographic Locations";	
			$formIcon = "{RESOURCE_URL}/$modShortName/images/icon_mod_".$this->__getObjectFileName().'_picture.png';
			$formDescription = "This form could help you manage ".$this->__getObjectFileName()." geographic locations.";
			$formTemplate = "form_detail_adv.tpl.html";
			
			$templateFile = $this->__getMetaTempPath().'/form/EditLocationForm.xml.tpl';
			$smarty->assign("form_name", 		$formEditLocationName);
	        $smarty->assign("form_class",		$formClass);
	        $smarty->assign("form_icon", 		$formIcon);
	        $smarty->assign("form_title", 		$formTitle);
	        $smarty->assign("form_description", $formDescription);
	        $smarty->assign("form_template",	$formTemplate);
			$smarty->assign("form_do", 			$doFullName);
			$smarty->assign("form_type_do", 	$typeDoFullName);		
			$smarty->assign("event_name",		$eventName);
			$smarty->assign("message_file",		$messageFile);        
			$content = $smarty->fetch($templateFile);
	        $targetFile = $targetPath . "/" . $formEditLocationName . ".xml";
	        file_put_contents($targetFile, $content);     
			$this->m_GeneratedFiles['FormObjFiles']['EditLocationForm']=str_replace(MODULE_PATH,"",$targetFile);
		}		
		
		if($features['widget']==1)
		{
			/*
			$smarty->assign("list_widget_name", 				$listWidgetFormName);
			$smarty->assign("list_widget_full_name", 			$listWidgetFormFullName); 
			$smarty->assign("list_editable_widget_name", 		$listEditableWidgetFormName);
			$smarty->assign("list_editable_widget_full_name", 	$listEditableWidgetFormFullName); 
			$smarty->assign("pick_widget_name", 				$pickWidgetFormName);
			$smarty->assign("pick_widget_full_name", 			$pickWidgetFormFullName); 
			$smarty->assign("quick_add_widget_name", 			$quickAddWidgetFormName);
			$smarty->assign("quick_add_widget_full_name", 		$quickAddWidgetFormFullName); 
			*/
			$targetPath = $moduleDir = MODULE_PATH . "/" . str_replace(".", "/", $modName) . "/widget";
			if(!is_dir($targetPath))
			{
				@mkdir($targetPath,0777,true);
			}
			
			//generate list widget				
			$formTemplate = "element_listform_lite.tpl.html";			
			$templateFile = $this->__getMetaTempPath().'/widget/ListWidgetForm.xml.tpl';
			
			$smarty->assign("form_name", 		$listWidgetFormName);
	        $smarty->assign("form_class",		$formClass);
	        $smarty->assign("form_template",	$formTemplate);
			$smarty->assign("form_do", 			$this->m_RefDOFullName);
			$smarty->assign("form_type_do", 	$typeDoFullName);		
			$smarty->assign("event_name",		$eventName);
			$smarty->assign("message_file",		$messageFile);        
			$content = $smarty->fetch($templateFile);
	        $targetFile = $targetPath . "/" . $listWidgetFormName . ".xml";
	        file_put_contents($targetFile, $content);     
			$this->m_GeneratedFiles['FormObjFiles']['ListWidgetForm']=str_replace(MODULE_PATH,"",$targetFile);
			
			//generate list editable widget
			$formTemplate = "element_listform_in_tab.tpl.html";			
			$templateFile = $this->__getMetaTempPath().'/widget/ListEditableWidgetForm.xml.tpl';
			$recordName = $this->__getFormName();
			
			$smarty->assign("form_name", 		$listEditableWidgetFormName);
	        $smarty->assign("form_class",		$formClass);
	        $smarty->assign("form_template",	$formTemplate);
			$smarty->assign("form_do", 			$this->m_RefDOFullName);
			$smarty->assign("form_type_do", 	$typeDoFullName);		
			$smarty->assign("event_name",		$eventName);
			$smarty->assign("message_file",		$messageFile);
			$smarty->assign("record_name",		$recordName);
			
			$smarty->assign("pick_widget_form_full_name",		$pickWidgetFormFullName);    
			$smarty->assign("quick_add_widget_form_full_name",		$quickAddWidgetFormFullName);            
			$content = $smarty->fetch($templateFile);
	        $targetFile = $targetPath . "/" . $listEditableWidgetFormName . ".xml";
	        file_put_contents($targetFile, $content); 
			$this->m_GeneratedFiles['FormObjFiles']['ListEditableWidgetForm']=str_replace(MODULE_PATH,"",$targetFile);
			
			//generate data pick widget		
			$formIcon = "{RESOURCE_URL}/$modShortName/images/icon_mod_".$this->__getObjectFileName().'_list.png';	
			$formDescription = "To select a ".strtolower($this->__getFormName())." click on a row and click to Select button";
			$formTitle  = "Please select a ".$this->__getFormName();			
			$formClass	= "PickerForm";
			$formTemplate = "form_data_picker.tpl.html";			
			$templateFile = $this->__getMetaTempPath().'/widget/PickWidgetForm.xml.tpl';
			
			$smarty->assign("form_icon", 		$formIcon);
			$smarty->assign("form_name", 		$pickWidgetFormName);
			$smarty->assign("form_title", 		$formTitle);
	        $smarty->assign("form_description", $formDescription);
	        $smarty->assign("form_class",		$formClass);
	        $smarty->assign("form_template",	$formTemplate);
			$smarty->assign("form_do", 			$this->m_PickDOFullName);
			$smarty->assign("form_type_do", 	$typeDoFullName);		
			$smarty->assign("event_name",		$eventName);
			$smarty->assign("message_file",		$messageFile);        
			$content = $smarty->fetch($templateFile);
	        $targetFile = $targetPath . "/" . $pickWidgetFormName . ".xml";
	        file_put_contents($targetFile, $content); 
			$this->m_GeneratedFiles['FormObjFiles']['PickWidgetForm']=str_replace(MODULE_PATH,"",$targetFile);
			
			
			//generate quick add widget
			
			$formIcon = "{RESOURCE_URL}/$modShortName/images/icon_mod_".$this->__getObjectFileName().'_add.png';
			$formTitle  = "Quick Add ".$this->__getFormName();
			$formDescription = "Create a new ".strtolower($this->__getFormName())." and edit its content later.";			
			$formClass	= "PickerForm";
			$formTemplate = "form_data_quick_add.tpl.html";			
			$templateFile = $this->__getMetaTempPath().'/widget/NewWidgetForm.xml.tpl';
			
			$smarty->assign("form_icon", 		$formIcon);
			$smarty->assign("form_name", 		$quickAddWidgetFormName);
			$smarty->assign("form_title", 		$formTitle);
	        $smarty->assign("form_description", $formDescription);
	        $smarty->assign("form_class",		$formClass);
	        $smarty->assign("form_template",	$formTemplate);
			$smarty->assign("form_do", 			$this->m_PickDOFullName);
			$smarty->assign("form_type_do", 	$typeDoFullName);		
			$smarty->assign("event_name",		$eventName);
			$smarty->assign("message_file",		$messageFile);        
			$content = $smarty->fetch($templateFile);
	        $targetFile = $targetPath . "/" . $quickAddWidgetFormName . ".xml";
	        file_put_contents($targetFile, $content); 
			$this->m_GeneratedFiles['FormObjFiles']['QuickAddWidgetForm']=str_replace(MODULE_PATH,"",$targetFile);
			
			
		}
		
		if($features['self_reference']==1)
		{
			/*
			$smarty->assign("list_related_widget_name", 				$listRelatedWidgetFormName);
			$smarty->assign("list_related_widget_full_name", 			$listRelatedWidgetFormFullName); 
			$smarty->assign("list_related_editable_widget_name", 		$listRelatedEditableWidgetFormName);
			$smarty->assign("list_related_editable_widget_full_name", 	$listRelatedEditableWidgetFormFullName); 
			*/			
			$targetPath = $moduleDir = MODULE_PATH . "/" . str_replace(".", "/", $modName) . "/widget";
			if(!is_dir($targetPath))
			{
				@mkdir($targetPath,0777,true);
			}
			
			//generate list related ro widget
			$templateFile = $this->__getMetaTempPath().'/widget/ListRelatedWidgetForm.xml.tpl';
			
			$smarty->assign("form_name", 		$listRelatedWidgetFormName);
	        $smarty->assign("form_class",		$formClass);
	        $smarty->assign("form_do", 			$this->m_RefDOFullName);
			$smarty->assign("form_type_do", 	$typeDoFullName);		
			$smarty->assign("event_name",		$eventName);
			$smarty->assign("message_file",		$messageFile);
			$smarty->assign("list_widget_form_full_name",	$listWidgetFormFullName);
			        
			$content = $smarty->fetch($templateFile);
	        $targetFile = $targetPath . "/" . $listRelatedWidgetFormName . ".xml";
	        file_put_contents($targetFile, $content); 
			$this->m_GeneratedFiles['FormObjFiles']['ListRelatedWidgetForm']=str_replace(MODULE_PATH,"",$targetFile);
			
			
			//generate list related rw widget
			$templateFile = $this->__getMetaTempPath().'/widget/ListRelatedEditableWidgetForm.xml.tpl';
			
			$smarty->assign("form_name", 		$listRelatedEditableWidgetFormName);
	        $smarty->assign("form_class",		$formClass);
	        $smarty->assign("form_do", 			$this->m_RefDOFullName);
			$smarty->assign("form_type_do", 	$typeDoFullName);		
			$smarty->assign("event_name",		$eventName);
			$smarty->assign("message_file",		$messageFile);  
			$smarty->assign("list_editable_widget_form_full_name",	$listEditableWidgetFormFullName);      
			$content = $smarty->fetch($templateFile);
	        $targetFile = $targetPath . "/" . $listRelatedEditableWidgetFormName . ".xml";
	        file_put_contents($targetFile, $content); 
			$this->m_GeneratedFiles['FormObjFiles']['ListRelatedEditableWidgetForm']=str_replace(MODULE_PATH,"",$targetFile);
			
			
			//generate edit self reference form
			$targetPath = $moduleDir = MODULE_PATH . "/" . str_replace(".", "/", $modName) . "/form";
			$formTitle  = "Edit ".$this->__getFormName()." Related Record";	
			$formIcon = "{RESOURCE_URL}/$modShortName/images/icon_mod_".$this->__getObjectFileName().'_related.png';
			$formDescription = "This form could help you manage ".$this->__getObjectFileName()." related data record.";
			$formTemplate = "form_detail_adv.tpl.html";
			
			$templateFile = $this->__getMetaTempPath().'/form/EditRelatedForm.xml.tpl';
			$smarty->assign("form_name", 		$formEditRelatedName);
	        $smarty->assign("form_class",		$formClass);
	        $smarty->assign("form_icon", 		$formIcon);
	        $smarty->assign("form_title", 		$formTitle);
	        $smarty->assign("form_description", $formDescription);
	        $smarty->assign("form_template",	$formTemplate);
			$smarty->assign("form_do", 			$doFullName);
			$smarty->assign("form_type_do", 	$typeDoFullName);		
			$smarty->assign("event_name",		$eventName);
			$smarty->assign("message_file",		$messageFile);        
			$content = $smarty->fetch($templateFile);
	        $targetFile = $targetPath . "/" . $formEditRelatedName . ".xml";
	        file_put_contents($targetFile, $content);     
			$this->m_GeneratedFiles['FormObjFiles']['EditRelatedForm']=str_replace(MODULE_PATH,"",$targetFile);
			
		}
	}
	
	protected function _genViewObj()
	{
		if($this->m_BuildOptions["gen_view_object"]!='1')
		{
			return false;
		}
		
		$modName 	= $this->__getModuleName(); 	
		$modBaseName= $this->__getModuleName(false);
		$features	= $this->_getExtendFeatures();	
		$aclArr     = $this->_getACLArr();
		
        $targetPath = $moduleDir = MODULE_PATH . "/" . str_replace(".", "/", $modBaseName) . "/view";
        if (!file_exists($targetPath))
        {
            if(CLI){echo "Create directory $targetPath" . PHP_EOL;}
            mkdir($targetPath, 0777, true);
        }
        
		//generate detail view
		$templateFile = $this->__getMetaTempPath().'/view/DetailView.xml.tpl';
		$viewName 	= $this->__getObjectName().'DetailView';
		$viewDesc 	= "Detail View of ".$this->m_ConfigModule['object_desc'];		
		$defaultFormName = $modName.'.form.'.$this->__getObjectName().'DetailForm';
		
		if(CLI){echo "Start generate view object $viewName." . PHP_EOL;}
        $smarty = BizSystem::getSmartyTemplate();
        $smarty->assign("view_name", $viewName);
        $smarty->assign("view_desc", $viewDesc);        
        $smarty->assign("default_form_name", $defaultFormName);
        $smarty->assign("acl", $aclArr);
        $content = $smarty->fetch($templateFile);
                        
        $targetFile = $targetPath . "/" . $viewName . ".xml";
        file_put_contents($targetFile, $content);      
		$this->m_GeneratedFiles['ViewObjFiles']['DetailView']=str_replace(MODULE_PATH,"",$targetFile);	 	
		
		//generate list view
		$templateFile = $this->__getMetaTempPath().'/view/ManageView.xml.tpl';
		$viewName 	= $this->__getObjectName().'ManageView';
		$viewDesc 	= $this->m_ConfigModule['object_desc']." Management";
		$defaultFormName = $modName.'.form.'.$this->__getObjectName().'ListForm';
		
		if(CLI){echo "Start generate view object $viewName." . PHP_EOL;}
		$smarty = BizSystem::getSmartyTemplate();
        $smarty->assign("view_name", $viewName);
        $smarty->assign("view_desc", $viewDesc);        
        $smarty->assign("default_form_name", $defaultFormName);
        $smarty->assign("acl", $aclArr);
        $content = $smarty->fetch($templateFile);
                        
        $targetFile = $targetPath . "/" . $viewName . ".xml";
        file_put_contents($targetFile, $content);      
		$this->m_GeneratedFiles['ViewObjFiles']['ManageView']=str_replace(MODULE_PATH,"",$targetFile);
		
		//generate type manager view
		if($features['data_type']==1)
        {        	
        	$this->_genExtendTypeView();
        }
		
	}

	protected function _genTemplateFiles()
	{
		if($this->m_BuildOptions["gen_template_files"]!='1')
		{
			return false;
		}
		$modName 	= $this->__getModuleName(false);
		$templateFiles = $this->__getMetaTempPath().'/template/';
		$targetPath = MODULE_PATH . "/" . str_replace(".", "/", $modName) . "/template";
		if(!is_dir($targetPath))
		{
			@mkdir($targetPath,0777,true);
		}										
		
		//copy module view level tempaltes
		
		foreach(glob($templateFiles.DIRECTORY_SEPARATOR."*" ) as $src_file)
		{
			if(!preg_match("/^form_/si", basename($src_file)))
			{
				@copy($src_file,$targetPath.DIRECTORY_SEPARATOR.basename($src_file));
			}
		}						
		//copy sub module level templates
		$targetPath = MODULE_PATH . "/" . str_replace(".", "/", $this->__getModuleName()) . "/template";
		if(!is_dir($targetPath))
		{
			@mkdir($targetPath,0777,true);
		}
		foreach(glob($templateFiles.DIRECTORY_SEPARATOR."*" ) as $src_file)
		{
			if(preg_match("/^form_/si", basename($src_file)))
			{
				@copy($src_file,$targetPath.DIRECTORY_SEPARATOR.basename($src_file));
			}
		}
		
		//generate view file
		$modName 	= $this->__getModuleName(false);
		$templateFiles = $this->__getMetaTempPath().'/template/';
		$targetPath = MODULE_PATH . "/" . str_replace(".", "/", $modName) . "/template";
		
		$left_menu_widget = $modName.".widget.".$modName.'LeftMenu';
		$menu_icon_css = $modName."/css/".$modName."_menu_icons.css";
		$source = $templateFiles.DIRECTORY_SEPARATOR.'view.tpl';
		$dest = $targetPath.DIRECTORY_SEPARATOR.'view.tpl';
		$data = file_get_contents($source);
		$data = str_replace("@@LEFT_MENU_WIDGET@@", $left_menu_widget, $data);
		$data = str_replace("@@MENU_ICON_CSS@@", $menu_icon_css, $data);		
		file_put_contents($dest, $data);
		
		//generate left menu file
		$dashbaard_view_url = $modName."/dashboard";
		$source = $templateFiles.DIRECTORY_SEPARATOR.'left_menu.tpl';
		$dest = $targetPath.DIRECTORY_SEPARATOR.'left_menu.tpl';
		$data = file_get_contents($source);
		$data = str_replace("@@DASHBOARD_VIEW@@", $dashbaard_view_url, $data);
		file_put_contents($dest, $data);		
		return;
	}	
	
	protected function _genResourceFiles()
	{
		if($this->m_BuildOptions["gen_template_files"]!='1')
		{
			return false;
		}
		$modName 	= $this->__getModuleName(false);
		$modShortName = $this->__getModuleName(false);
		$templateFiles = $this->__getMetaTempPath().'/resource/';
		$targetPath = MODULE_PATH . "/" . str_replace(".", "/", $modName) . "/resource";
		$this->__recursiveCopy($templateFiles, $targetPath);
		
		//copy images
		$icons = array(
			"icon_mod_list.png"						=> 	"images/icon_mod_".$this->__getObjectFileName().'_list.png',
			"icon_mod_add.png"						=> 	"images/icon_mod_".$this->__getObjectFileName().'_add.png',
			"icon_mod_edit.png"						=> 	"images/icon_mod_".$this->__getObjectFileName().'_edit.png',
			"icon_mod_copy.png"						=> 	"images/icon_mod_".$this->__getObjectFileName().'_copy.png',
			"icon_mod_detail.png"					=> 	"images/icon_mod_".$this->__getObjectFileName().'_detail.png',
		
			"icon_mod_picture.png"					=> 	"images/icon_mod_".$this->__getObjectFileName().'_picture.png',
			"icon_mod_attachment.png"				=> 	"images/icon_mod_".$this->__getObjectFileName().'_attachment.png',
			"icon_mod_location.png"					=> 	"images/icon_mod_".$this->__getObjectFileName().'_location.png',
			"icon_mod_related.png"					=> 	"images/icon_mod_".$this->__getObjectFileName().'_related.png',
			
			"icon_mod_type_list.png"				=> 	"images/icon_mod_".$this->__getObjectFileName().'_type_list.png',
			"icon_mod_type_add.png"					=> 	"images/icon_mod_".$this->__getObjectFileName().'_type_add.png',
			"icon_mod_type_edit.png"				=> 	"images/icon_mod_".$this->__getObjectFileName().'_type_edit.png',
			"icon_mod_type_copy.png"				=> 	"images/icon_mod_".$this->__getObjectFileName().'_type_copy.png',
			"icon_mod_type_detail.png"				=> 	"images/icon_mod_".$this->__getObjectFileName().'_type_detail.png',
			
			"icon_data_private.gif"				=>	'images/icon_'.$modShortName.'_private.gif',
			"icon_data_sharing.gif"				=>	'images/icon_'.$modShortName.'_shared.gif',
			"icon_data_assigned.gif"			=>	'images/icon_'.$modShortName.'_assigned.gif',
			"icon_data_shared_distributed.gif"	=>	'images/icon_'.$modShortName.'_distributed.gif',
			"icon_data_shared_group.gif"		=>	'images/icon_'.$modShortName.'_shared_group.gif',
			"icon_data_shared_other.gif"		=>	'images/icon_'.$modShortName.'_shared_other.gif'
		);		
		foreach($icons as $key=>$value)
		{
			@copy($templateFiles.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.$key, 
					$targetPath.DIRECTORY_SEPARATOR.$value);
		}
		
		//copy css
		@copy($templateFiles.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR."menu_icons.css", 
					$targetPath.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.$modShortName."_menu_icons.css");
		@unlink($targetPath.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR."menu_icons.css");
		return ;
	}		
	
	protected function _genDashboardFiles()
	{
		if($this->m_BuildOptions["gen_dashboard"]!='1')
		{
			return false;
		}

		//Genereate Dashboard Form
		$modName 	  = $this->__getModuleName();
		$modBaseName  = $this->__getModuleName(false);
		
		$targetPath = MODULE_PATH . "/" . str_replace(".", "/", $modBaseName) . "/widget";
        if (!file_exists($targetPath))
        {
            if(CLI){echo "Create directory $targetPath" . PHP_EOL;}
            mkdir($targetPath, 0777, true);
        }
		
		$templateFile = $this->__getMetaTempPath().'/widget/DashboardWidget.xml.tpl';
		$formName 	= 'DashboardForm';
		$formTitle	= ucfirst($modBaseName).' Dashboard';

		//generate detail view
		if(CLI){echo "Start generate form object $formName." . PHP_EOL;}
        $smarty = BizSystem::getSmartyTemplate();
        $smarty->assign("form_name", 	$formName);
        $smarty->assign("form_title", 	$formTitle);
        $smarty->assign("form_css", 	strtolower($modBaseName));        
        $smarty->assign("mod_name", 	$modBaseName);        
        $content = $smarty->fetch($templateFile);
                        
        $targetFile = $targetPath . "/" . $formName . ".xml";
        file_put_contents($targetFile, $content);      
		$this->m_GeneratedFiles['FormObjFiles']['DashboardForm']=str_replace(MODULE_PATH,"",$targetFile);	
		
		
		//Generate Left Menu Widget
		$templateFile = $this->__getMetaTempPath().'/widget/LeftMenuWidget.xml.tpl';
		$formName 	= $modBaseName.'LeftMenu';
		$formTitle	= ucfirst($modBaseName);

		//generate detail view
		if(CLI){echo "Start generate form object $formName." . PHP_EOL;}
        $smarty = BizSystem::getSmartyTemplate();
        $smarty->assign("form_name", 	$formName);
        $smarty->assign("form_title", 	$formTitle);
        $smarty->assign("form_css", 	strtolower($modBaseName));        
        $smarty->assign("mod_name", 	$modBaseName);        
        $content = $smarty->fetch($templateFile);
                        
        $targetFile = $targetPath . "/" . $formName . ".xml";
        file_put_contents($targetFile, $content);      
		$this->m_GeneratedFiles['FormObjFiles']['LeftMenuForm']=str_replace(MODULE_PATH,"",$targetFile);	
		
		
		//Genereate Dashboard View				
        $targetPath = $moduleDir = MODULE_PATH . "/" . str_replace(".", "/", $modBaseName) . "/view";
        if (!file_exists($targetPath))
        {
            if(CLI){echo "Create directory $targetPath" . PHP_EOL;}
            mkdir($targetPath, 0777, true);
        }
        
		//generate detail view
		$templateFile = $this->__getMetaTempPath().'/view/DashboardView.xml.tpl';
		$viewName 	= 'DashboardView';
		$viewDesc 	= "Dashboard View of ".$this->m_ConfigModule['object_desc'];		
		$defaultFormName = $modBaseName.'.widget.DashboardForm';
		
		if(CLI){echo "Start generate view object $viewName." . PHP_EOL;}
        $smarty = BizSystem::getSmartyTemplate();
        $smarty->assign("view_name", $viewName);
        $smarty->assign("view_desc", $viewDesc);        
        $smarty->assign("default_form_name", $defaultFormName);
        $smarty->assign("acl", $aclArr);
        $content = $smarty->fetch($templateFile);
                        
        $targetFile = $targetPath . "/" . $viewName . ".xml";
        file_put_contents($targetFile, $content);      
		$this->m_GeneratedFiles['ViewObjFiles']['DashboardView']=str_replace(MODULE_PATH,"",$targetFile);	 	
				
	}
	
	private function __recursiveCopy($path, $dest){
	   if( is_dir($path) )
       {
            @mkdir( $dest );
            $objects = scandir($path);
            if( sizeof($objects) > 0 )
            {
                foreach( $objects as $file )
                {
                    if( $file == "." || $file == ".." || substr($file,0,1)=='.' )
                        continue;
                    // go on
                    if( is_dir( $path.DIRECTORY_SEPARATOR.$file ) )
                    {
                        $this->__recursiveCopy( $path.DIRECTORY_SEPARATOR.$file, $dest.DIRECTORY_SEPARATOR.$file );
                    }
                    else
                    {
                        copy( $path.DIRECTORY_SEPARATOR.$file, $dest.DIRECTORY_SEPARATOR.$file );
                    }
                }
            }
            return true;
        }
        elseif( is_file($path) )
        {
            return copy($path, $dest);
        }
        else
        {
            return false;
        }
	} 	
	
	protected function _genMessageFiles()
	{
		if($this->m_BuildOptions["gen_message_file"]!='1')
		{
			return false;
		}
		$modName 	= $this->__getModuleName(); 	
		$modBaseName= $this->__getModuleName(false);
		$objName	=  $this->__getObjectName();
		
        $targetPath = $moduleDir = MODULE_PATH . "/" . str_replace(".", "/", $modBaseName) . "/message";
        if (!file_exists($targetPath))
        {
            if(CLI){echo "Create directory $targetPath" . PHP_EOL;}
            mkdir($targetPath, 0777, true);
        }
        
        $templateFile = $this->__getMetaTempPath().'/message/Messages.ini.tpl';
        $content = file_get_contents($templateFile);
        
        $targetFile = $targetPath . "/" . $objName . ".ini";
        file_put_contents($targetFile, $content);      
		$this->m_GeneratedFiles['MessageFiles']['MessageFile']=str_replace(MODULE_PATH,"",$targetFile);
		if(CLI){echo "Start generate message file $objName.ini ." . PHP_EOL;}
	}	
	
	protected function _genModuleFile()
	{
		if($this->m_BuildOptions["gen_mod"]!='1')
		{
			return false;
		}		
		
		//generate mod loader
		$modName 	= $this->__getModuleName(false);
        $targetPath = MODULE_PATH . "/" . str_replace(".", "/", $modName) . "/lib";
        if (!file_exists($targetPath))
        {
            if(CLI){echo "Create directory $targetPath" . PHP_EOL;}
            mkdir($targetPath, 0777, true);
        }

        
        $smarty = BizSystem::getSmartyTemplate();                
        $smarty->assign("mod_name", ucfirst($modName));
		$templateFile = $this->__getMetaTempPath().'/lib/ModLoadHandler.php.tpl';
		
        $content = $smarty->fetch($templateFile);                
        $targetFile = $targetPath . "/" . ucfirst($modName) . "LoadHandler.php";
        file_put_contents($targetFile, $content);        

        $resourceACL = $this->_getResourceACL();
        $menu		 = $this->_getMenuSet();
        $modules	 = array("system"	=>	"system",
        					 "menu"		=>	"menu");
        $changeLogs	 = array();
        
        //load XML file if it exists
        $targetFile = MODULE_PATH . "/" . str_replace(".", "/", $modName) . "/mod.xml";
        if(is_file($targetFile))
        {
        	$metadata = file_get_contents($targetFile);
			$xmldata = new SimpleXMLElement($metadata);		
			foreach ($xmldata as $key=>$value){
				switch(strtoupper($key)){
					case "ACL":
						foreach($value as $resource)
						{
							$resourceName = (string) $resource['Name'];
							$acls = array();
							foreach($resource as $item)
							{
								$name 		 = (string) $item['Name'];
								$description = (string) $item['Description'];
								$acls[$name] = $description;
							}
							$resourceACL[$resourceName] = $acls;
						}
						break;
						
					case "DEPENDENCY":
						foreach($value as $resource)
						{
							$name 		 = (string) $resource['Name'];
							$modules[$name] = $name;							
						}
						break;	
						
					case "MENU":
						foreach($value as $menuLevel1)
						{
							$menuName1 = (string) $menuLevel1['Name'];
							$menuItem1 = array();
							foreach($menuLevel1 as $menuLevel2)
							{		
								$menuName2 = (string) $menuLevel2['Name'];
								$menuItem1[$menuName1] = array(
									'name' 		 => (string) $menuLevel2['Name'],
									'title' 		 => (string) $menuLevel2['Title'],
									'description' => (string) $menuLevel2['Description'],
									'url' 		 => (string) $menuLevel2['URL'],									
									'icon_css'	 => (string) $menuLevel2['IconCssClass'],
									'access' 	 => (string) $menuLevel2['Access'],
								);
								foreach($menuLevel2 as $menuLevel3)
								{	
									$menuName2 = (string) $menuLevel3['Name'];
									$menuItem2 = array(
										'name' 		 => (string) $menuLevel3['Name'],
										'title' 		 => (string) $menuLevel3['Title'],
										'description' => (string) $menuLevel3['Description'],
										'url' 		 => (string) $menuLevel3['URL'],										
										'icon_css' => (string) $menuLevel3['IconCssClass'],
										'access' 	 => (string) $menuLevel3['Access'],
									);
									foreach($menuLevel3 as $menuLevel4)
									{	
										$menuName3 = (string) $menuLevel4['Name'];
										$menuItem3 = array(
											'name' 		 => (string) $menuLevel4['Name'],
											'title' 		 => (string) $menuLevel4['Title'],
											'description' => (string) $menuLevel4['Description'],
											'url' 		 => (string) $menuLevel4['URL'],										
											'icon_css' => (string) $menuLevel4['IconCssClass'],
											'access' 	 => (string) $menuLevel4['Access'],
										);
										$menuItem2['child'][$menuName3] = 	$menuItem3;
									}								
									$menuItem1[$menuName1]['child'][$menuName2] = $menuItem2;
								}
							}
							$menu = $menuItem1;
						}
						break;
						
					case "CHANGELOG":
						foreach($value as $version)
						{
							$versionNumber = (string) $version['Name'];
							$logs = array();
							foreach($version as $logItem)
							{
								$name 		 = (string) $logItem['Name'];
								$type		 = (string) $logItem['Type'];
								$status		 = (string) $logItem['Status'];
								$publishDate = (string) $logItem['PublishDate'];
								$description = (string) $logItem['Description'];	    											
								$logs[$name] = array(
									"name"			=> $name,
									"type"			=> $type,
									"status"		=> $status,
									"publish_date"	=> $publishDate,
									"description"	=> $description,
								);
							}
							$changeLogs[$versionNumber] = $logs;
						}
						break;
				}
			}
        }
        //generate mod xml file
        $smarty = BizSystem::getSmartyTemplate();
        $templateFile = $this->__getMetaTempPath().'/mod.xml.tpl';
        $targetPath = MODULE_PATH . "/" . str_replace(".", "/", $modName) ;
        $modDescription	=	$this->m_BuildOptions['mod_desc'];
        $modAuthor		=	$this->m_BuildOptions['mod_author'];
        $modVersion		=	$this->m_BuildOptions['mod_version'];
        $modLoader		=	$this->m_BuildOptions['mod_author'];
        $modLabel		=	ucfirst($modName);
        
        //gen_dashboard
        $modRootURI		=	"{APP_INDEX}/$modName/dashboard";
        
        $smarty->assign("mod_name", 		$modName);
        $smarty->assign("mod_label", 		$modLabel);
        $smarty->assign("mod_description", 	$modDescription);
        $smarty->assign("mod_author", 		$modAuthor);
        $smarty->assign("mod_version", 		$modVersion);
        $smarty->assign("mod_loader", 		ucfirst($modName) . "LoadHandler.php");
        $smarty->assign("mod_root_uri", 	$modRootURI);
        $smarty->assign("resource_acl",		$resourceACL);
        $smarty->assign("menu",				$menu);
        $smarty->assign("modules",			$modules);
        $smarty->assign("change_logs",		$changeLogs);
        
        
        
        $content = $smarty->fetch($templateFile);        
        $targetFile = $targetPath . "/mod.xml";
        file_put_contents($targetFile, $content);    
        
        $this->m_GeneratedFiles['ModXMLFile']=str_replace(MODULE_PATH,"",$targetFile);
        
        //generate mod.install.sql
        $this->_genInstallSQL();
        
        //generate mod.uninstall.sql
        $this->_genUninstallSQL();
	}	
	
	private function __getObjectName()
	{
		$tableName = $this->m_DBTable;
		$name = str_replace("_", " ", $tableName);
		$name = str_replace("-", " ", $name);
		$name = ucwords($name);
		$name = str_replace(" ", "", $name);
		return $name;
	}
	
	private function __getObjectFileName()
	{
		$tableName = $this->m_DBTable;
		$name = str_replace("_", " ", $tableName);
		$name = str_replace("-", " ", $name);		
		$name = str_replace(" ", "_", $name);
		$name = strtolower($name);
		return $name;
	}
		
	private function __getViewName()
	{
		$tableName = $this->m_DBTable;
		$name = str_replace("_", " ", $tableName);
		$name = str_replace("-", " ", $name);
		$name = ucwords($name);
		$name = str_replace(" View", "", $name);
		$name = str_replace(" ", "_", $name);
		$name = strtolower($name);
		return $name;
	}	
	
	private function __getFormName()
	{
		switch($this->m_BuildOptions['naming_convention'])
		{
			case "name":
				$tableName = $this->m_DBTable;
				$name = str_replace("_", " ", $tableName);
				$name = str_replace("-", " ", $name);
				$name = ucwords($name);
				break;				
			case "comment":
				$tableName = $this->m_DBTable;
				$db 	= BizSystem::dbConnection($this->m_DBName);
				$tableInfos = $db->fetchAssoc("SHOW TABLE STATUS WHERE Name='$tableName'");
				$name = $tableInfos[$tableName]['Comment'];
				if(!$name)
				{
					$tableName = $this->m_DBTable;
					$name = str_replace("_", " ", $tableName);
					$name = str_replace("-", " ", $name);
					$name = ucwords($name);
				}
				break;
		}		
		return $name;
	}	
	
	private function __getMetaTempPath()
	{
		$this->m_MetaTempPath = MODULE_PATH.DIRECTORY_SEPARATOR.'appbuilder'.
											DIRECTORY_SEPARATOR.'resource'.
											DIRECTORY_SEPARATOR.'module_template';
		return $this->m_MetaTempPath; 
	}
	
	private function __getModuleName($processSubModule = true)
	{
		if($this->m_ConfigModule['module_type']==1)
		{
			$result = $this->m_ConfigModule['module_name_create'];
		}
		else
		{
			$result = $this->m_ConfigModule['module_name_exists'];
		}
		if( $processSubModule == true )
		{
			$result .= '.'.$this->m_ConfigModule['sub_module_name'];
		}
		return $result;
	}
	
	private function __getFieldDesc($fieldArr)
	{		
		switch($this->m_BuildOptions['naming_convention'])
		{
			case "name":
				$result = str_replace("-",	" ",	$fieldArr['Field']);
				$result = str_replace("_",	" ",	$result);
				$result = ucwords($result);
				break;				
			case "comment":
				$result = $fieldArr['Comment'];
				if(!$result)
				{
					$result = str_replace("-",	" ",	$fieldArr['Field']);
					$result = str_replace("_",	" ",	$result);
					$result = ucwords($result);
				}
				break;
		}
		return $result;
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
	
	private function __convertDataElement($type)
	{
		$typeOrg = $type;
		if(strpos($type,"("))
		{
			$type = substr($type,0,strpos($type,"("));
		}		
		switch ($type)
        {
            case "date":
                $elements = array(	"ReadControl"=>"LabelText",
                					"WriteControl"=>"InputDate",
                					"ListControl"=>"ColumnText");                
                break;

            case "timestamp":
            case "datetime":
                $elements = array(	"ReadControl"=>"LabelText",
                					"WriteControl"=>"InputDatetime",
                					"ListControl"=>"ColumnText");
                break;

            case "int":
            case "float":
            case "bigint":
            case "tinyint":
                $elements = array(	"ReadControl" =>"LabelText",
                					"WriteControl"=>"InputText",
                					"ListControl"=>"ColumnText");
                break;

            case "text":
            case "shorttext":
            case "longtext":
				$elements = array(	"ReadControl" =>"LabelTextarea",
                					"WriteControl"=>"Textarea",
									"ListControl"=>"ColumnText");
            	break;
            	
        	default:
               $elements = array(	"ReadControl" =>"LabelText",
                					"WriteControl"=>"InputText",
               						"ListControl"=>"ColumnText");
                break;
       }
       return $elements;
	}	
}
?>