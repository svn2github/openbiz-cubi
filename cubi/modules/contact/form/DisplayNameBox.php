<?php 
require_once OPENBIZ_BIN.'/easy/element/Listbox.php';
class DisplayNameBox extends Listbox
{
	public function getValue(){
		$value = parent::getValue();
		$firstname 	= BizSystem::clientProxy()->getFormInputs("fld_first_name");
		$lastname 	= BizSystem::clientProxy()->getFormInputs("fld_last_name");
		$company 	= BizSystem::clientProxy()->getFormInputs("fld_company");		
		$value = str_replace("@@Firstname@@",$firstname,$value);
		$value = str_replace("@@Lastname@@", $lastname, $value);
		$value = str_replace("@@Company@@",  $company,  $value);
		return $value;
	}	
	
	public function translateValue($value){
		$rec = $this->getFormObj()->getActiveRecord();
		$firstname 	= $rec['first_name'];
		$lastname 	= $rec['last_name'];
		$company 	= $rec['company'];
		$value = str_replace("@@Firstname@@",$firstname,$value);
		$value = str_replace("@@Lastname@@", $lastname, $value);
		$value = str_replace("@@Company@@",  $company,  $value);
		return $value;
	}
	
   public function render()
    {
        $fromList = array();
        $this->getFromList($fromList);
        $value = $this->m_Value?$this->m_Value:$this->getDefaultValue();        
        $disabledStr = ($this->getEnabled() == "N") ? "DISABLED=\"true\"" : "";
        $style = $this->getStyle();
        $func = $this->getFunction();

        //$sHTML = "<SELECT NAME=\"" . $this->m_Name . "[]\" ID=\"" . $this->m_Name ."\" $disabledStr $this->m_HTMLAttr $style $func>";
        $sHTML = "<SELECT NAME=\"" . $this->m_Name . "\" ID=\"" . $this->m_Name ."\" $disabledStr $this->m_HTMLAttr $style $func>";

        if ($this->m_BlankOption) // ADD a blank option
        {
            $entry = explode(",",$this->m_BlankOption);
            $text = $entry[0];
            $value = ($entry[1]!= "") ? $entry[1] : null;
            $entryList = array(array("val" => $value, "txt" => $text ));
            $fromList = array_merge($entryList, $fromList);
        }

        $defaultValue = null;                
        foreach ($fromList as $option)
        {
        	$optionTranslated = $this->translateValue($option['val']);            
            if ($optionTranslated != $value)
            {
                $selectedStr = '';
            }
            else
            {
                $selectedStr = "SELECTED";
                $defaultValue = $option['val'];                 
            }
            $sHTML .= "<OPTION VALUE=\"" . $option['val'] . "\" $selectedStr>" . $option['txt'] . "</OPTION>";
        }
        if($defaultValue == null){
        	$defaultOpt = array_shift($fromList);
        	$defaultValue = $defaultOpt['val'];
        	array_unshift($fromList,$defaultOpt);
        }
     
        
        $this->setValue($defaultValue);
        $sHTML .= "</SELECT>";
        return $sHTML;
    }	
}
?>