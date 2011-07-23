<?php 
class DeviceForm extends EasyForm
{
	public function canDeleteRecord($dataRec)
	{
		if($dataRec['system']==1){
			return false;
		}else{
			return parent::canDeleteRecord($dataRec);
		}
	}
	
	public function canDisplayForm()
    {
    	switch(strtolower($this->m_FormType))
        {
       		case 'edit':
		        $dataRec = $this->fetchData();
		    	if($dataRec['system']==1){
					return false;
				}else{
					return parent::canDisplayForm();
				}
        		break;        		      		
        }
    	return parent::canDisplayForm();
        
    }
}
?>