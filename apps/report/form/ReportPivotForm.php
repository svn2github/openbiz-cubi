<?php
//include_once "ReportForm.php";

class ReportPivotForm extends EasyForm
{
    public $m_PivotLimit = 1000;
   
    public function renderPivot()
    {
        // compose pivotConfig object
        include_once ("PivotConfig.php");
        $pivotCfg = new PivotConfig();
        $pivotCfg->queryLimit = $this->m_PivotLimit;
        $pivotCfg->addColumnField(BizSystem::clientProxy()->getFormInputs("fld_colfld1"));
        $pivotCfg->addColumnField(BizSystem::clientProxy()->getFormInputs("fld_colfld2"));
        $pivotCfg->addRowField(BizSystem::clientProxy()->getFormInputs("fld_rowfld1"));
        $pivotCfg->addRowField(BizSystem::clientProxy()->getFormInputs("fld_rowfld2"));
        $pivotCfg->addRowField(BizSystem::clientProxy()->getFormInputs("fld_rowfld3"));
        $pivotCfg->addDataField(BizSystem::clientProxy()->getFormInputs("fld_datafld1"),
                                 BizSystem::clientProxy()->getFormInputs("fld_datafld1func"));
        // TODO: add filter field ...

        $viewObj = $this->getViewObject();
        $viewObj->reload();
    	foreach ($viewObj->m_FormRefs as $formRef)
        {
            $formName = $formRef->m_Name;
            //echo "$formName, ".$thisForm->m_Name."<br/>";
            if ($formName == $this->m_Name)
            	continue;
            $formObj = BizSystem::objectFactory()->getObject($formName);
            if ($formObj->m_Type=='table') // ($formObj->m_DataObjName == $this->m_DataObjName && $formObj->m_Type=='table')
            {
                break;
            }
        }
        $viewObj->m_FormRefs->rewind();
        
        $pivotViewName = "report.view.PivotView";
        $pivotFormName = "report.form.ReportPivotTable";
        $pivotView = BizSystem::getObject($pivotViewName);
        $pivotForm = BizSystem::getObject($pivotFormName);
        $pivotForm->initPivot($formObj, $pivotCfg);
        $pivotView->render();
    }

	public function showFilterForm()
	{
		$viewObj = $this->getViewObject();
			$viewObj->reload();
		foreach ($viewObj->m_FormRefs as $formRef)
		{
			$formName = $formRef->m_Name;
			//echo "$formName, ".$thisForm->m_Name."<br/>";
			if ($formName == $this->m_Name)
				continue;
			$formObj = BizSystem::objectFactory()->getObject($formName);
			if ($formObj->m_Type=='filter') // ($formObj->m_DataObjName == $this->m_DataObjName && $formObj->m_Type=='table')
			{
				break;
			}
		}
		BizSystem::clientProxy()->redrawForm($this->m_Name, $formObj->render());
	}
}
?>
