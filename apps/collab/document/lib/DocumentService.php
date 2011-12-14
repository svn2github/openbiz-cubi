<?php
class DocumentService
{
	protected  $m_DocumentReversionDO = 'collab.document.do.DocumentReversionDO';
	
	public function saveReversion($data)
	{
		$data = $data->getActiveRecord();
		$lastData = $this->getLastVersion($data['Id']);
		if($this->isDiff($data,$lastData))
		{
			$reversionRec = array(
				"document_id"	=>	$data['Id'],
				"reversion"		=>	(int)$lastData['reversion']+1,
				"title"			=>	$data['title'],
				"description"	=>	$data['description'],
				"content"		=>	$data['content'],
				"create_by"		=>  BizSystem::getUserProfile('Id')
			);
			BizSystem::getObject($this->m_DocumentReversionDO)->insertRecord($reversionRec);
		}
	}
	
	public function isDiff($data1,$data2)
	{
		if($data1['title']==$data2['title'] &&
			$data1['description']==$data2['description'] &&
			$data1['content']==$data2['content'] 
			)
			{
				return false;
			}else{
				return true;
			}
	}
	
	public function getLastVersion($document_id)
	{
		$lastVersions = BizSystem::getObject($this->m_DocumentReversionDO)->directFetch("[document_id]='$document_id'",-1,0,"[reversion] DESC");
		if($lastVersions)
		{
			$lastVersion = $lastVersions[0];
			return $lastVersion;			
		}
		else
		{
			return null;
		}		
	}
}
?>