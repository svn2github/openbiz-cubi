<?PHP
include_once("Element.php");

class FormElement extends InputElement
{
    protected $m_FormReference;
    protected function readMetaData(&$xmlArr)
    {
        parent::readMetaData($xmlArr);
        $this->m_FormReference = isset($xmlArr["ATTRIBUTES"]["FORMREFERENCE"]) ? $xmlArr["ATTRIBUTES"]["FORMREFERENCE"] : null;
    }

    /**
     * Draw the element according to the mode
     *
     * @return string HTML text
     */
    public function render()
    {
        if(!$this->m_FormReference)
        {
        	return null;
        }
        $formObj = $this->getFormObj();   
        $formElementObj = BizSystem::GetObject($this->m_FormReference);
        $formElementObj->m_ParentFormName = $formObj->m_Name;
        if (method_exists($formObj,"SetSubForms"))
        {
                $formObj->setSubForms($this->m_FormReference);                
                $formDataObj = BizSystem::getObject($formObj->m_DataObjName);
                $dataObj = $formDataObj->getRefObject($formElementObj->m_DataObjName);
                
                if ($dataObj)
                    $formObj->setDataObj($dataObj);                
        }
    	$sHTML = $formElementObj->render();
    	$formObj->setDataObj($formDataObj);
        return $sHTML;
    }

}

?>
