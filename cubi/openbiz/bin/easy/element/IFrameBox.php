<?php 
include_once("Element.php");

class IFrameBox extends Element
{
	
    public $m_Link;
    public $m_Label;
    
    protected function readMetaData(&$xmlArr)
    {
        parent::readMetaData($xmlArr);
        $this->m_Link = isset($xmlArr["ATTRIBUTES"]["LINK"]) ? $xmlArr["ATTRIBUTES"]["LINK"] : null;
        $this->m_Label = isset($xmlArr["ATTRIBUTES"]["LABEL"]) ? $xmlArr["ATTRIBUTES"]["LABEL"] : null;                
    }    
    protected function getLink()
    {
        if ($this->m_Link == null)
            return null;
        $formobj = $this->getFormObj();
        return Expression::evaluateExpression($this->m_Link, $formobj);
    }
    public function renderLabel()
    {
        return $this->m_Label;
    }    	
	public function render(){	
		$link = $this->getLink();
		$text = $this->getText();	
		$height = $this->m_Height;
		$width = $this->m_Width;
		$sHTML = "<iframe  src=\"$link\" width=\"$width\" height=\"$height\" frameborder=\"0\" scrolling=\"auto\" >
					<p>$text</p></iframe>";        
        return $sHTML;
		
	}
}
?>