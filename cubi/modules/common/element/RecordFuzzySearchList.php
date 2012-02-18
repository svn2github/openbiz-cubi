<?php 
class RecordFuzzySearchList extends AutoSuggest
{
	public $m_SearchFields;
	
    public function readMetaData (&$xmlArr)
    {
        parent::readMetaData($xmlArr);
        $this->m_SearchFields = isset($xmlArr["ATTRIBUTES"]["SEARCHFIELDS"]) ? $xmlArr["ATTRIBUTES"]["SEARCHFIELDS"] : null;
    }

    public function getSearchRule()
    {
    	$value = BizSystem::clientProxy()->getFormInputs($this->m_Name); 
    	$value = addslashes($value); //escape sql strings          
	    
	    if ($value!='')
	    {
	        $searchStr = " [$this->m_FieldName] LIKE '%$value%' ";	               
	    }else{
	    	return "";
	    }
	    

	    if($this->m_SearchFields) //process other search fields
	    {
	    	$fields = $lovService = BizSystem::getService(LOV_SERVICE)->getList($this->m_SearchFields);
	    	foreach($fields as $opt)
	    	{
	    		$field = $opt['val'];
	    		$searchStr.= " OR [$field] LIKE '%$value%' ";
	    	}
	    }
	    
	    $searchStr = "( $searchStr )";
	    return $searchStr;
    }
}
?>