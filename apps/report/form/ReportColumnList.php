<?php 
include_once (OPENBIZ_BIN."/easy/element/Listbox.php");
class ReportColumnList extends Listbox {

    public function getFromList(&$list, $selectFrom=null)
    {
        // find the table type report form
        $thisForm = $this->getFormObj();
        // get view object
		$viewObj = $thisForm->getViewObject();
		$viewObj->reload();
    	foreach ($viewObj->m_FormRefs as $formRef)
        {
            $formName = $formRef->m_Name;
            //echo "$formName, ".$thisForm->m_Name."<br/>";
            if ($formName == $thisForm->m_Name)
            	continue;
            $formObj = BizSystem::objectFactory()->getObject($formName);
            if ($formObj->m_Type=='table') // ($formObj->m_DataObjName == $thisForm->m_DataObjName && $formObj->m_Type=='table')
            {
                break;
            }
        }
        $viewObj->m_FormRefs->rewind();
        
        // get form elements
        $i = 0;
        foreach ($formObj->m_DataPanel as $element) {
            $list[$i]['val'] = $element->m_Name;
            $list[$i]['txt'] = $element->m_Label;
            $i++;
        }
        
        return;
    }

}
?>
