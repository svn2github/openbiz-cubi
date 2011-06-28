<?php 
class HelpCategoryForm extends EasyFormTree
{
	protected $m_CategoryMappingDO 	= "help.do.HelpCategoryMappingDO";
	
	public function UpdateRecord(){
		$result = parent::UpdateRecord();
		$mappingObj  =  BizSystem::GetObject($this->m_CategoryMappingDO,1);
		$Id = $this->m_RecordId;
		$mappingObj->deleteRecords("[cat_id]='$Id'");
		return $result;
	}
	
 
}
?>