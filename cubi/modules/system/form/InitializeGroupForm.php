<?php 
class InitializeGroupForm extends EasyForm
{

	protected $m_GroupDO = "system.do.GroupDO";
	
	public function Initialize()
	{
	    $currentRec = $this->fetchData();
        $recArr = $this->readInputRecord();
        $this->setActiveRecord($recArr);
        if (count($recArr) != 0){
            	
	        try
	        {
	            $this->ValidateForm();
	        }
	        catch (ValidationException $e)
	        {
	            $this->processFormObjError($e->m_Errors);
	            return;
	        }
	
	        $groupDO = BizSystem::getObject($this->m_GroupDO);
	        //rename default group
	        if((int)$recArr['rename_default_group']==1)
	        {
	        	$defaultGroupRec = $groupDO->fetchOne("","[Id] ASC");
	        	$defaultGroupRec['name'] = $recArr['rename_default_group_name'];
	        	$defaultGroupRec->save();
	        }
	        
	        //add new groups	        
	        foreach (array(
	        	"add_group_1",
	        	"add_group_2",
	        	"add_group_3",
	        	"add_group_4",
	        	"add_group_5"
	        		) as $addGroup){
		        if((int)$recArr[$addGroup]==1)
		        {
		        	$groupRec = array(
		        		"name" => $recArr[$addGroup.'_name'],
		        		"status" => 1,
		        	);
		        	$groupDO->insertRecord($groupRec);
		        }
	        }
	        
	        //default data sharing setting
	        
	        
	        //put init lock
	        $group_init_lock = APP_FILE_PATH.DIRECTORY_SEPARATOR.'initialize_group.lock';
	        file_put_contents($group_init_lock, '1');
	        
			//redirect back to last view
	        
        }		
	}
}
?>