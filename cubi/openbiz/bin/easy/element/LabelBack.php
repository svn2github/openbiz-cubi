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
        
        if(isset($_SERVER['HTTP_REFERER'])){
        	return $_SERVER['HTTP_REFERER'];
        }else{        
        	return $defaultLink;
        }
    }

}

?>