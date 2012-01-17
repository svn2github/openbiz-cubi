<?php 
class ProjectForm extends EasyForm
{
	public function UpdateProjectStatus($id, $fld_name, $value)
	{
		if($value == 1){
    		$value_xor = 2;  		
    	}else{
    		$value_xor = 1;
    	}    	
		return $this->updateFieldValue($id,$fld_name,$value_xor);		
	}
}
?>
