<?php
require_once('DataSharingForm.php');
class DataACLForm extends DataSharingForm
{
	public $m_AclDO = "common.do.DataACLDO";
	
	public function fetchDataSet()
	{
		$prtRecord = $this->fetchData();
		$this->m_Editable = $prtRecord['editable'];
		$result =  parent::fetchDataSet();
		return $result;
	}
	
	
	public function addAcl()
	{
		$inputs = $this->readInputs();
		$acl_user = $inputs['fld_acl_uid'];
		$acl_perm = $inputs['fld_acl_perm'];
		
		//get UserID
		$userRec = BizSystem::getObject("system.do.UserDO",1)->fetchOne("[username]='$acl_user'");
		$acl_user_id = $userRec['Id'];
		
		$parent_record_id = $this->m_ParentRecordId;
		
		//get parent do table
		$prtForm = $this->m_ParentFormName;
		$prtFormObj = BizSystem::GetObject($prtForm);
		$dataObj = $prtFormObj->getDataObj();
		$parent_record_table = $dataObj->m_MainTable;
		
		$aclDO = BizSystem::getObject("common.do.DataACLDO");
		$sql = "
			[record_table]='$parent_record_table' AND 
			[record_id]='$parent_record_id' AND
			[user_id]='$acl_user_id' 
		";
		$rec = $aclDO->fetchOne($sql);
		
		if(!$rec){		
			$aclRecord = array(
				"record_table" => $parent_record_table,
				"record_id" => $parent_record_id,
				"user_id"	=> $acl_user_id,
				"user_perm"	=> $acl_perm
			);
			$aclDO->insertRecord($aclRecord);
		}
		
		$this->rerender();
	}
	
	
}
?>