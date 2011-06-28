<?PHP


include_once("LabelText.php");


class LabelImage extends LabelText
{

	private $m_Prefix ;

    protected function readMetaData(&$xmlArr)
    {
        parent::readMetaData($xmlArr);
        $this->m_Prefix = isset($xmlArr["ATTRIBUTES"]["URLPREFIX"]) ? $xmlArr["ATTRIBUTES"]["URLPREFIX"] : null;
    }
	
    /**
     * Render, draw the control according to the mode
     *
     * @return string HTML text
     */
    public function render()
    {
    	$this->m_Prefix = Expression::evaluateExpression($this->m_Prefix, $formobj);
    	
    	if($this->m_Width){
    		$width_str = " width=\"".$this->m_Width."\" ";
    	}
        if($this->m_Height){
    		$height_str = " height=\"".$this->m_Height."\" ";
    	}    	
    	if($this->m_Value){
        	$sHTML = "<img src=\"".$this->m_Prefix.$this->m_Value."\" $width_str $height_str />";
    	}
        return $sHTML;
    }

}

?>