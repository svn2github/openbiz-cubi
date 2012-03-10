<?php
include_once (OPENBIZ_BIN."/easy/element/DropDownList.php");
class TypeSelector extends DropDownList
{
protected function renderList(){
    	
    	if($this->m_FormPrefix){
    		$formNameStr = str_replace(".","_", $this->getFormObj()->m_Name)."_";
    	} 
    	$onchange_func = $this->getOnChangeFunction();
    	$list = $this->getList();
    	
        if ($this->m_BlankOption) // ADD a blank option
        {
            $entry = explode(",",$this->m_BlankOption);
            $text = $entry[0];
            $value = ($entry[1]!= "") ? $entry[1] : null;
            $entryList = array(array("val" => $value, "txt" => $text ));
            $list = array_merge($entryList, $list);
        }    	
    	
    	$value = $this->m_Value ? $this->m_Value : $this->getText();
    	$sHTML = "<ul style=\"display:none;z-index:50\" id=\"".$formNameStr.$this->m_Name."_list\" class=\"dropdownlist\">";
    	$theme = Resource::getCurrentTheme();
    	$image_url = THEME_URL . "/" . $theme . "/images";
    	
    	foreach($list as $item){
    		$val = $item['val'];
    		$txt = $item['txt'];
    		$pic = $item['pic'];
    		if($pic!=""){
    			$str_pic="<img src='".$image_url."/spacer.gif' style='background-color:#$pic;width:12px;height:12px;padding-top:0px;margin-top:3px;' />";
    		}else{
    			$str_pic = "";
    		}    		
    	    if(!preg_match("/</si",$txt)){
        		$display_value = $txt;
    	    }else{
    	    	$display_value = $val;
    	    }    
    	    if($str_pic){
    	    	$li_option_value =  $str_pic."<span>".$txt."</span>";
    	    }
    	    else{
    	    	$li_option_value =$txt ;
    	    }
    	    
    	    if($val==$value)
    	    {    	    	
    	    	$option_item_style=" class='selected' ";
    	    }else{
    	    	$option_item_style=" onmouseover=\"this.className='hover'\" onmouseout=\"this.className=''\" ";
    	    }
    	        	    
    		$sHTML .= "<li $option_item_style
				onclick=\"$('".$formNameStr.$this->m_Name."_list').hide();
							$('".$formNameStr.$this->m_Name."').setValue('".addslashes($display_value)."');
							$('".$formNameStr.$this->m_Name."_hidden').setValue('".addslashes($val)."');
							$('span_".$formNameStr.$this->m_Name."').innerHTML = this.innerHTML;							
							$onchange_func ;
							$('".$formNameStr.$this->m_Name."').className='".$this->m_cssClass."'
							\"					
				>$li_option_value</li>";
    		
    		if($val == $value){
    			$this->m_DefaultDisplayValue="".$str_pic."<span>".$txt."</span>";
    		}		
    	}
    	$sHTML .= "</ul>";
    	return $sHTML;
    }	
}