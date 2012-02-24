<?PHP
include_once("LabelText.php");

class LabelBack extends LabelText
{
    protected function getLink()
    {
        if ($this->m_Link == null)
            return null;
        $formobj = $this->getFormObj();
        $defaultLink= Expression::evaluateExpression($this->m_Link, $formobj);
        
        $viewRefferedPage = $this->getFormObj()->getViewObject()->m_RefferPage;
        
        if(isset($viewRefferedPage)){
        	return $viewRefferedPage;
        }else{        
        	return $defaultLink;
        }
    }

}

?>