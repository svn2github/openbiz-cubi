<?php 
include_once ('ColumnBar.php');
class LabelBar extends ColumnBar {
    public function render(){
    	$value = $this->m_Text ? $this->getText() : $this->m_Value;
    	if($this->m_Color)
    	{
    		$formObj = $this->getFormObj();
    		$color = Expression::evaluateExpression($this->m_Color, $formObj);    		
    		if(!$color){
    			$color = '33b5fb';
    		}
    		$bgcolor_str = "background-color: #".$color.";";    		    		
    	}else{
    		$bgcolor_str = "background-color: #33b5fb;";
    	}
    	
    	if($this->m_DisplayFormat)
        {
        	$value = sprintf($this->m_DisplayFormat,$value);
        }
    	if($this->m_Percent=='Y')
        {        	
        	$value = sprintf("%.2f",$value*100).'%';        
        }
        $style = $this->getStyle();
        $id = $this->m_Name;
        $func = $this->getFunction();
        $height = $this->m_Height;
        $width = $this->m_Width - 80;        
        $max_value = Expression::evaluateExpression($this->m_MaxValue, $this->getFormObj());
        
        $width_rate = ($value/$max_value);
        
        if($width_rate>1){
        	$width_rate=1;
        }
        $width_bar = (int)($width * $width_rate);
        
    	$sHTML = "
    	<span id=\"$id\" $func $style >
    		
    		<span class=\"bar_bg\" style=\"height:".$height."px;width:".$width."px;\">
    			
    			<span class=\"bar_data\" style=\"".$bgcolor_str."height:".$height."px;width:".$width_bar."px;\"></span>	
    			<span class=\"bar_data_bg\" style=\"".$bgcolor_str."height:".$height."px;width:".$width_bar."px;\"></span>	
    		</span>
    		
    		<span class=\"value\" style=\"text-align:left;text-indent:10px;\">$value".$this->m_DisplayUnit."</span>
    	</span>
    	";
    	return $sHTML;
    }
}
?>