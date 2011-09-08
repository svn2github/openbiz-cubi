<?php 
require_once(OPENBIZ_BIN."easy/element/Listbox.php");
class ContinentSelector extends Listbox{
    function getFromList(&$list){
    	$list = array();
        if (!function_exists("timezone_identifiers_list")) return;
		$zones = timezone_identifiers_list();
		foreach ($zones as $zone) 
		{
		    $zone = explode('/', $zone); // 0 => Continent, 1 => City
		    
		    // Only use "friendly" continent names
		    if ($zone[0] == 'Africa' || $zone[0] == 'America' || $zone[0] == 'Antarctica' || $zone[0] == 'Arctic' || $zone[0] == 'Asia' || $zone[0] == 'Atlantic' || $zone[0] == 'Australia' || $zone[0] == 'Europe' || $zone[0] == 'Indian' || $zone[0] == 'Pacific')
		    {        
		        if (isset($zone[1]) != '')
		        {
		            $locations[$zone[0]][$zone[0]. '/' . $zone[1]] = str_replace('_', ' ', $zone[1]); // Creates array(DateTimeZone => 'Friendly name')
		        } 
		    }
		}		    	
		
    	foreach ($locations as $continent=>$timezone){   
    		array_push($list,array("val"=>$continent,
    								"txt"=>$continent,
    								"pic"=>""));
    		
    	}
    	//return $list;
    }
  
}
?>