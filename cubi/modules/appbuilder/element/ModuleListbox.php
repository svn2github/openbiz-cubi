<?php 
include_once OPENBIZ_BIN."/easy/element/Listbox.php";
class ModuleListbox extends Listbox
{
	
    public function getFromList(&$list, $selectFrom=null)
    {
        if (!$selectFrom) {
            $selectFrom = $this->getSelectFrom();
        }
        $this->getSimpleFromList($list, $selectFrom);
        if ($list != null)
            return;
        
        return;
    }	       
    
    protected function getSimpleFromList(&$list, $selectFrom)
    {
		
    	$svc = BizSystem::getObject("appbuilder.lib.MetadataService");
    	$moduleList = $svc->listModules();
        foreach ($moduleList as $module)
        {            
            $list[$i]['val'] = $module;
            $list[$i]['txt'] = $module;
            $i++;        	
        }
    }   
}
?>