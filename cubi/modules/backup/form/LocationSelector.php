<?php 
include_once OPENBIZ_BIN.'/easy/element/DropDownList.php';

class  LocationSelector extends DropDownList
{
	protected function getList()
    {    	
    	$list = parent::getList();
    	
     	foreach($list as $key=>$value)
    	{
    		switch($list[$key]['pic'])
    		{
    			default:
    			case "0":
    				$list[$key]['pic'] = RESOURCE_URL.'/backup/images/icon_type_user.png';
    				break;
    			case "1":
    				$list[$key]['pic'] = RESOURCE_URL.'/backup/images/icon_type_system.png';
    				break;    				
    		}
    	}
    	
    	return $list;
    }
}
?>