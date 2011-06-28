<?php 
include_once (MODULE_PATH.'/common/form/DataSharingForm.php');
class DataPublishingForm extends  DataSharingForm
{
	public function ShareRecord()
	{
		$prtForm = $this->m_ParentFormName;
		$prtFormObj = BizSystem::GetObject($prtForm);
		$recId = $this->m_RecordId;
		$dataObj = $prtFormObj->getDataObj();
		$dataRec = $dataObj->fetchById($recId);
		
		$recArr = $this->readInputRecord();
		$DataRec = $dataRec;
		if(isset($recArr['group_perm']))
		{
			$DataRec['group_perm'] = $recArr['group_perm'];
		}
		
		if(isset($recArr['other_perm']))
		{
			$DataRec['other_perm'] = $recArr['other_perm'];
		}
		
		if(isset($recArr['group_id']))
		{
			$DataRec['group_id']	= $recArr['group_id'];	
		}		
		
		if(isset($recArr['owner_id'])){
			$DataRec['owner_id']	= $recArr['owner_id'];
		}
		
		if($DataRec['group_perm']=='0'){
			$DataRec['other_perm']='0';
		}
		
		$DataRec->save();
		//$prtFormObj->getDataObj()->updateRecord($newDataRec,$dataRec);
		
		
		
		if($recArr['update_ref_data']){
			if($dataObj->m_ObjReferences->count()){
				$this->_casacadeUpdate($dataObj, $recArr);
			}			
		}
		
		if ($this->m_ParentFormName)
        {
            $this->close();
            $this->renderParent();
        }
        $this->processPostAction();
	}	
}
?>