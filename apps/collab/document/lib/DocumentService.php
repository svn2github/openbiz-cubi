<?php
class DocumentService
{
	protected  $m_DocumentReversionDO = 'collab.document.do.DocumentReversionDO';
	
	public function saveReversion($data)
	{
		$data = $data->getActiveRecord();
		$reversionRec = array(
			"document_id"	=>	$data['Id'],
			"reversion"		=>	$this->getLastVersion($data['Id'])+1,
			"title"			=>	$data['title'],
			"description"	=>	$data['description'],
			"content"		=>	$data['content']
		);
		BizSystem::getObject($this->m_DocumentReversionDO)->insertRecord($reversionRec);
	}
	
	public function getLastVersion($document_id)
	{
		$lastVersions = BizSystem::getObject($this->m_DocumentReversionDO)->directFetch("[document_id]='$document_id'",-1,0,"[reversion] DESC");
		if($lastVersions)
		{
			$lastVersion = $lastVersions[0];
			return $lastVersion['document_id'];			
		}
		else
		{
			return 0;
		}		
	}
}
?>