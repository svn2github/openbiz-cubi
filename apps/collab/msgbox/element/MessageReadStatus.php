<?php 
class MessageReadStatus extends ColumnImage
{
	protected $m_ReadImg;
	protected $m_UnreadImg;
	protected $m_RepliedImg;
	
    protected function readMetaData(&$xmlArr)
    {
        parent::readMetaData($xmlArr);
        $this->m_ReadImg = isset($xmlArr["ATTRIBUTES"]["READIMG"]) ? $xmlArr["ATTRIBUTES"]["READIMG"] : null;
        $this->m_UnreadImg = isset($xmlArr["ATTRIBUTES"]["UNREADIMG"]) ? $xmlArr["ATTRIBUTES"]["UNREADIMG"] : null;
        $this->m_RepliedImg = isset($xmlArr["ATTRIBUTES"]["REPLIEDIMG"]) ? $xmlArr["ATTRIBUTES"]["REPLIEDIMG"] : null;
    }
    
    public function render()
    {
    	switch(strtolower($this->m_Value)){
    		case "unread":
    			$this->m_Value = $this->m_UnreadImg;
    			break;
    		case "read":
    			$this->m_Value = $this->m_ReadImg;
    			break;
    		case "replied":
    			$this->m_Value = $this->m_RepliedImg;
    			break;
    	}
    	$formObj = $this->getFormObj();
    	$this->m_Value = Expression::evaluateExpression($this->m_Value, $formObj);
    	return parent::render();
    }
}
?>