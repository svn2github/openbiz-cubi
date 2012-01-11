<?php
class AnnouncementViewForm extends EasyForm
{
	private $m_counted = array();
	private $m_ReadLogDO = "collab.announcement.do.AnnouncementReadLogDO";
	
	public function fetchData()
	{
		$result = parent::fetchData();	
		$id = $result['Id'];	
		if(!$this->m_counted[$id]){ 			
			$this->MarkAsRead($id,false);
		}
		return $result;	
	}	
	
	
	public function fetchDataSet()
	{
		$resultSet = parent::fetchDataSet();
		$resultArr = $resultSet->toArray();
		foreach ($resultArr as $key=>$value)
		{
			$resultArr[$key]['read_status'] = $this->getReadStatus($resultArr[$key]['Id']);
		}
		return $resultArr;
	
	}
	
	public function getReadStatus($id)
	{
		$user_id = BizSystem::getUserProfile("Id");
		$do = BizSystem::getObject($this->m_ReadLogDO,1);
		$logRec = $do->fetchOne("[announcement_id]='$id' and [user_id]='$user_id'");
		if($logRec){
			return 1;
		}
		return 0;
	}
	
	public function MarkAsRead($id=null)
	{
        if ($id==null || $id=='')
            $id = BizSystem::clientProxy()->getFormInputs('_selectedId');

        $selIds = BizSystem::clientProxy()->getFormInputs('row_selections', false);
        if ($selIds == null)
            $selIds[] = $id;
        foreach ($selIds as $id)
        {      		
		
			if(!$id || $this->m_counted[$id]){
				return;
			}
			$user_id = BizSystem::getUserProfile("Id");
			$do = BizSystem::getObject($this->m_ReadLogDO,1);
			$logRec = $do->fetchOne("[announcement_id]='$id' and [user_id]='$user_id'");
			if(!$logRec){
				$recArr = array(
					"user_id"=>$user_id,
					"announcement_id" => $id,
					"view_count" => 1,
					"timestamp" => date('Y-m-d H:i:s')
				);
				$do->insertRecord($recArr);
			}
			else 
			{
				$logRec['view_count'] = (int)$logRec['view_count'] + 1;
				$logRec['timestamp'] = date('Y-m-d H:i:s');
				$logRec->save();
			}
			$this->m_counted[$id] = true;
			if($this->m_FormType=='LIST'){			
				$this->updateForm();		
			}
        }
	}
}