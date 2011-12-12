<?php 
class MessageChangeTypeForm extends EasyForm
{
	protected $m_Type = "collab.msgbox.do.MessageTypeDO";
	protected $m_RecipientDO = "collab.msgbox.do.MessageRecipientDO";
	
	public function fetchData()
	{
		$result = array();
		$input = $this->readInputRecord();
		if($input['type_id'])
		{
			$typeId = $input['type_id'];
			$typeDo = BizSystem::getObject($this->m_Type,1);
			$typeRec = $typeDo->fetchById($typeId);
			$result['name'] = $typeRec['name'];
			$result['description'] = $typeRec['description'];
		}
		return $result;
	}
	
	public function ChangeMessageType(){
		$selIds = $this->m_RecordId;
		$recipientDo = BizSystem::getObject($this->m_RecipientDO,1);
		$input = $this->readInputRecord();
		$typeId = $input['type_id'];
		foreach($selIds as $id)
		{
			$recipientDo->updateRecords("[type_id]='$typeId'","[Id]='$id'");
		}
		$this->processPostAction();
	}
}
?>