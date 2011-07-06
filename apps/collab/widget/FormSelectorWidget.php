<?php
class FormSelectorWidget extends EasyForm
{
	public $viewMode;
	public $lastViewMode;
	
	private $_DefaultViewMode;
	
	protected function readMetadata(&$xmlArr)
    {
        parent::readMetaData($xmlArr);
        $this->_DefaultViewMode = isset($xmlArr["EASYFORM"]["ATTRIBUTES"]["DEFAULTSELECTEDFORM"]) ? $xmlArr["EASYFORM"]["ATTRIBUTES"]["DEFAULTSELECTEDFORM"] : null;
    }
	
	public function getViewMode()
	{
		if($this->viewMode){
			$data = $this->viewMode;
		}else{
			$data = $this->_DefaultViewMode;
		}
		return $data;
	}
	
	public function fetchData(){
		$data = array();
		if($this->viewMode){
			$data['viewmode'] = $this->viewMode;
		}else{
			$data['viewmode'] = $this->_DefaultViewMode;
		} 
		return $data;
	}
	
	public function switchViewMode()
	{
		if(!$this->lastViewMode)
		{
			$this->lastViewMode = $this->getViewMode();
		}
		$viewObj = $this->getViewObject();
		//$viewObj = $this->getView();
		if($viewObj->m_LastRenderedForm && 
			$viewObj->m_LastRenderedForm!='help.form.HelpWidgetListForm'){
			$this->lastViewMode = $viewObj->m_LastRenderedForm;
		}
		$recArr = $this->readInputRecord();
		$this->viewMode = $recArr['viewmode'];
		$targetForm = $recArr['viewmode'];		
		$formObj = BizSystem::GetObject($targetForm);
		$formHTML = $formObj->render();
		BizSystem::clientProxy()->redrawForm($this->lastViewMode, $formHTML);
		$this->lastViewMode = $this->viewMode;
	}
	
    public function getSessionVars($sessionContext)
    {
        $sessionContext->getObjVar($this->m_Name, "ViewMode", $this->viewMode);
        parent::getSessionVars($sessionContext);
    }

    public function setSessionVars($sessionContext)
    {
        $sessionContext->setObjVar($this->m_Name, "ViewMode", $this->viewMode);
        parent::setSessionVars($sessionContext);
    }	
}
?>