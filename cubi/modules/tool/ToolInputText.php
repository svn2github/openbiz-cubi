<?PHP

/**
 * FieldControl - class FieldControl is the base class of field control who binds with a bizfield
 *
 * @package BizView
 * @author rocky swen
 * @copyright Copyright (c) 2005
 * @version 1.2
 * @access public
 */
class ToolInputText extends InputText
{
    public function render()
    {
        $text = $this->getText();
        list($func,$body) = explode("(",$text);
        $body = str_replace(")","",$body);
        if (strpos($body,",")>0)
            $args = explode(",",$body);
        else
            $args[0] = $body;

        if (method_exists($this, $func))
            $val = call_user_func_array(array($this, $func),$args);
        else
            $val = "";
        
        $this->m_Value = $val;
        
        $disabledStr = ($this->getEnabled() == "N") ? "DISABLED=\"true\"" : "";
        $style = $this->getStyle();
        $func = $this->getFunction();
        $sHTML = "<INPUT NAME=\"" . $this->m_Name . "\" ID=\"" . $this->m_Name ."\" VALUE=\"" . $val . "\" $disabledStr $this->m_HTMLAttr $style $func>";
        
        return $sHTML;
    }

    protected function table($doName)
    {
        $doName = substr($doName, 1);
        $doName = $this->getFormObj()->getElement($doName)->m_Value;

        // get the dataobj file
        $metaFileInfo = $this->getFormObj()->GetMetaFileInfo();
        if (!$metaFileInfo)
            return "";
        //echo "meta file info:"; print_r($metaFileInfo);
        if ($doName && !strpos($doName, ".") && ($metaFileInfo['package'])) // no package prefix as package.object, add it
            $doName = $metaFileInfo['package'].".".$doName;
        $doFile = $metaFileInfo['modules_path'].str_replace(".","/",$doName).'.xml';
        
        // get the fields of the dataobj
        $xpathStr = "/BizDataObj/@Table";
        if (!file_exists($doFile)) 
            return "";
        $doc = new DomDocument();
        $ok = $doc->load($doFile);
        if (!$ok)
            return "";
        $xpath = new DOMXPath($doc);
        $elems = $xpath->query($xpathStr);
        $tableAttr = $elems->item(0);
        $table = $tableAttr->value;
        
        return $table;
    }
}

?>
