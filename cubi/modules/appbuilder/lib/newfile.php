<?php
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
		
		$formListName 	= $this->__getObjectName().'ListForm';
		$formListFullName = $modName.'.form.'.$formListName;				
		$formDetailName  	= $this->__getObjectName().'DetailForm';
		$formDetailFullName  = $modName.'.form.'.$formDetailName;
		$formCopyName  	= $this->__getObjectName().'CopyForm';
		$formCopyFullName  = $modName.'.form.'.$formCopyName;		
		$formEditName  	= $this->__getObjectName().'EditForm';
		$formEditFullName  = $modName.'.form.'.$formEditName;		
		$formNewName  	= $this->__getObjectName().'NewForm';
		$formNewFullName  = $modName.'.form.'.$formNewName;
		
		
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

	    if($features['extend']==1)
        {        	        	
        	$this->_genExtendTypeForm();    
        	$typeDoFullName = $this->m_TypeDOFullName;  
        	  	
        }
        
        if( $features['extend']==1 || $doPermControl=='Y' )
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
				
	 	if( $features['extend']==1  )
        {
        	$formTemplate = "form_detail_adv.tpl.html";
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
		