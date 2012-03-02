<?php 
class FieldListbox extends Listbox
{
	public function getFromList(&$list, $selectFrom=null)
    {
    	parent::getFromList($list, $selectFrom);
		$usedFields = $this->getUsedFields();
		for($i=0;$i<count($list);$i++)
		{
			foreach($usedFields as $field)
			{
				if($list[$i]['val']==$field)
				{
					unset($list[$i]);
				}
			}
		}
    }
    
    protected function getUsedFields(){
    	$ds = $this->getFormObj()->getDataObj()->fetch();
    	$fields = array();
    	foreach($ds as $record)
    	{
    		$fields[] = $record['field'];
    	}
    	return $fields;    	
    }
}
?>