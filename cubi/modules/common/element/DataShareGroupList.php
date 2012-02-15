<?php 
include_once (OPENBIZ_BIN."/easy/element/Listbox.php");
class DataShareGroupList extends Listbox
{
    protected function getSelectFrom()
    {
        $formobj = $this->getFormObj();
    	if(!BizSystem::allowUserAccess("data_assign.assign_to_other")){
    		$groups=BizSystem::getUserProfile("groups");
    		$ids = implode(",", $groups);
    		
			$selectFrom = $this->m_SelectFrom . ",[Id] IN ($ids)";
		}else{
			$selectFrom = $this->m_SelectFrom;
		}
        return Expression::evaluateExpression($selectFrom, $formobj);
    }	
}
?>