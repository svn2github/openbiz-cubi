<?php
class DocumentReversionForm extends EasyForm
{
	protected $m_DocuemntDO = "collab.document.do.DocumentDO";
	protected $m_DocuemntService = "collab.document.lib.DocumentService";
	 
	public function RevertDocument()
	{
		$revRec = $this->fetchData();
		//save current record to a reversion		
		$documentId = $revRec['document_id'];
		$documentRec = BizSystem::getObject($this->m_DocuemntDO,1)->fetchById($documentId);
		$lastData = BizSystem::getService($this->m_DocuemntService)->getLastVersion($documentId);	
		$recArr = array(
				"document_id"	=>	$documentRec['Id'],
				"reversion"		=>	(int)$lastData['reversion']+1,
				"title"			=>	$documentRec['title'],
				"description"	=>	$documentRec['description'],
				"content"		=>	$documentRec['content']		
		);
		$this->getDataObj()->insertRecord($recArr);
		
		//restore selected reversion to record
		$documentRec['title'] = $revRec['title'];
		$documentRec['description'] = $revRec['description'];
		$documentRec['content'] = $revRec['content'];
		$documentRec->save();
		
		
		if ($this->m_ParentFormName)
        {            
            $this->renderParent();
            $this->close();
            BizSystem::getObject("collab.document.form.DocumentDetailForm")->rerender();
        }
		
	}
}
?>