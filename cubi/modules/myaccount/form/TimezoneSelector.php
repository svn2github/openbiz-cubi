<?php 
require_once(OPENBIZ_BIN."easy/element/Listbox.php");
class TimezoneSelector extends Listbox{
	public $m_continent;
	
	protected function readMetaData(&$xmlArr){
		parent::readMetaData($xmlArr);
		$this->m_continent = isset($xmlArr["ATTRIBUTES"]["CONTINENT"]) ? $xmlArr["ATTRIBUTES"]["CONTINENT"] : "";		
	}
	
	public function getContinent()
	{
		$formobj = $this->getFormObj();
        return Expression::evaluateExpression($this->m_continent, $formobj);
	}
	
    //public function getList(){
    public function getFromList(&$list) 
    {
    	//$list = array();
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
		
		$continent = $this->getContinent();
		if($continent){
			$continent_list = $locations[$continent];
		}else{
			$continent_list = $locations['Africa'];
		}
    	foreach ($continent_list as $name=>$value){   
    		array_push($list,array("val"=>$name,
    								"txt"=>$name,
    								"pic"=>""));
    		
    	}
        
    	//return $list;
    }
  
}
?>