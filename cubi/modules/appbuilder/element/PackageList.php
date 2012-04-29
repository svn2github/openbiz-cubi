<?php 
include_once OPENBIZ_BIN."/easy/element/DropDownList.php";
class PackageList extends DropDownList
{
	
    public function getList()
    {
        $list = array();
        $this->getSimpleFromList($list);       
        return $list;
    }	       
    
    protected function getSimpleFromList(&$list)
    {
		
    	if($this->getFormObj()->getViewObject()->m_Name=='appbuilder.view.ModuleDetailView')
		{
			$module = BizSystem::getObject("appbuilder.metaedit.ModuleInfoForm")->m_RecordId;
		}
		else
		{
			$module = BizSystem::getObject("appbuilder.metaedit.ModuleFilterForm")->m_RecordId;
		}    		
    		
		$svc = BizSystem::getObject("appbuilder.lib.MetadataService");
    	$pkgList = $svc->listPackages($module);
        foreach ($pkgList as $package)
        {            
            $list[$i]['val'] = $package;
            $list[$i]['txt'] = $package;
            $i++;        	
        }
    }   
}
?>