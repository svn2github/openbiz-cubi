<?php

class ReportView extends EasyView
{
    protected $m_ViewId;
    protected $m_ViewDO = "report.do.ReportViewDO";
    //protected $m_ViewDO = "report.do.ReportUserDO";
    //protected $m_ReportAclDO = "report.do.ReportAclDO";
    protected $m_CheckACL = true;
    /**
     * Get/Retrieve Session data of this object
     *
     * @param SessionContext $sessionContext
     * @return void
     */
    public function getSessionVars($sessionContext)
    {
    	$sessionContext->getObjVar($this->m_Name, "ViewId", $this->m_ViewId);

    }
    
    /**
     * Save Session data of this object
     *
     * @param SessionContext $sessionContext
     * @return void
     */
    public function setSessionVars($sessionContext)
    {
    	$sessionContext->setObjVar($this->m_Name, "ViewId", $this->m_ViewId);

    }
    
    public function reload()
    {
    	$this->initAllForms();
    }
    
	protected function initAllForms()
    {
        //QueryStringParam::ReSet();
        
    	$viewDO = $this->m_ViewDO;
    	//$ReportAclDO = $this->m_ReportAclDO;
        $formDO = "report.do.ReportFormDO";
    	
		// get the view id from the user request
        $this->m_ViewId = isset($_REQUEST['__view']) ? $_REQUEST['__view'] : $this->m_ViewId;
		
    	// check report id
        $reportId = isset($_GET['fld:Id']) ? $_GET['fld:Id'] : $this->m_ViewId;
        $this->m_ViewId = $reportId; 
        
        if(!(int)$this->m_ViewId){
        	$view = "report.view.DefaultView";
        	BizSystem::getObject($view)->render();
        	exit;
        }
        
        $viewDO = BizSystem::getObject($viewDO);
        $viewRecord = $viewDO->fetchById($reportId);
        if (empty($viewRecord)) {
            $viewObj = BizSystem::getObject(ACCESS_DENIED_VIEW);
            $viewObj->render();
            exit;
        }
        
        if ($this->m_CheckACL) {
            $group_id = $viewRecord['group_id'];
            // if the report has empty group id, everyone can access the report
            if ($group_id and $group_id > 0) {
                $userProfile = BizSystem::getUserProfile();
                $userGroups = $userProfile['groups'];
                // match the user groups with report group
                if (!in_array($group_id, $userGroups)) {
                    $viewObj = BizSystem::getObject(ACCESS_DENIED_VIEW);
                    $viewObj->render();
                    exit;
                }
            }
        }
        
        if($viewRecord['name']){
        	$this->m_Name .= '--'. $viewRecord['name'];
        }
        $this->m_Title = $viewRecord['title'];        
        
        // fetch view form records
        $formDO = BizSystem::getObject($formDO);
        $formRecords = $formDO->directFetch("[view_id]=$reportId");
        
        // create form objects. need to create list or chart form
        $this->initFormObjects($formRecords);
    }
    
    protected function initFormObjects($formRecords)
    {
    	if($this->m_StaticOutput==true){
    		$reportFM = "report.form.ReportListStaticForm";
	        $chartFM = "report.form.ReportChartStaticForm";
	        $filterFM = "report.form.ReportFilterStaticForm";
    	}else{
	        $reportFM = "report.form.ReportListForm";
	        $chartFM = "report.form.ReportChartForm";
	        $filterFM = "report.form.ReportFilterForm";
    	}
        //print_r($formRecords); exit;
    	foreach ($formRecords as $formRec)
        {
	        // create form object
	        switch ($formRec['type'])
	        {
	            case 'table':
	            	$formObj = BizSystem::getObject($reportFM,1);
	            	break;
	            case 'chart':
	            	$formObj = BizSystem::getObject($chartFM,1);
	            	break;
	            case 'filter':
	            	$formObj = BizSystem::getObject($filterFM,1);
	            	break;
	        }
	        if($this->m_StaticOutput==true){
	        	$formObj->m_StaticOutput=true;
	        }
	        $formObj->setAttributes($formRec);
	        BizSystem::objectFactory()->setObject($formObj->m_Name, $formObj);
	        
	        $xmlArr["ATTRIBUTES"]["NAME"] = $formObj->m_Name;
            $formRef = new FormReference($xmlArr);
            $this->m_FormRefs->set($formObj->m_Name, $formRef);
        }
        //print_r($this->m_FormRefs); exit;
    }
}

?>
