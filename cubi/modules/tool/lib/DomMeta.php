<?php
class DomMeta {
    public $m_XmlFile;
    public $m_Doc;
    
    public function __construct($metaName) {
        if (strpos($metaName,".xml")>0)
            $this->m_XmlFile = $metaName;
        else
            $this->m_XmlFile = MODULE_PATH."/".str_replace(".","/",$metaName).".xml";
        //echo $this->m_XmlFile."\n";
    }
    
    public function GetDocDocument()
    {
        if ($this->m_Doc) 
            return $this->m_Doc;
        
        if (!file_exists($this->m_XmlFile)) 
            return null;
        $doc = new DomDocument();
        $ok = $doc->load($this->m_XmlFile);
        if (!$ok)
            return null;
        $this->m_Doc = $doc;
        return $doc;
    }
    
    public function AddElement($elemPath, $elemAttrs, $prtAttrName=null)
    {
        $doc = $this->GetDocDocument();
        if (!$doc) return false;
        $pathItems = explode("/",$elemPath);
        $counts = count($pathItems);
        $elemType = $pathItems[$counts-1];
        
        $elem = $doc->createElement($elemType);
        foreach ($elemAttrs as $name => $value) {
            $elem->setAttribute($name, $value);
        }
        
        // get the parent element
        $xpath = new DOMXPath($doc);
        $pos = strrpos($elemPath, "/$elemType");
        $xpathStr = "/".substr($elemPath, 0, $pos);
        if ($prtAttrName && $prtAttrName!=""){
            $xpathStr .= "[@Name='".$prtAttrName."']";
        }                   
        $prtElems = $xpath->query($xpathStr);       
        $prtElem = $prtElems->item(0);
        $prtElem->appendChild($elem);
        
        // save xml file
        $doc->formatOutput = true;
        $doc->preserveWhiteSpace = false;
        $doc->save($this->m_XmlFile);
        return true;
    }
    

    public function ReplaceElement($elemPath, $elemAttrs, $oldElemName , $prtAttrName=null)
    {
        $doc = $this->GetDocDocument();
        if (!$doc) return false;
        $pathItems = explode("/",$elemPath);
        $counts = count($pathItems);
        $elemType = $pathItems[$counts-1];
        
        $elem = $doc->createElement($elemType);
        foreach ($elemAttrs as $name => $value) {
            $elem->setAttribute($name, $value);
        }
                
        //get the old elemnt by name
        $xpath = new DOMXPath($doc);
 		$xpathStr = "/".$elemPath."[@Name='".$oldElemName."']";
                               
        $oldElems = $xpath->query($xpathStr);              
        $oldElem = $oldElems->item(0);

        // get the parent element
        $xpath = new DOMXPath($doc);
        $pos = strrpos($elemPath, "/$elemType");
        $xpathStr = "/".substr($elemPath, 0, $pos);
        if ($prtAttrName && $prtAttrName!=""){
            $xpathStr .= "[@Name='".$prtAttrName."']";
        }                                  
        $prtElems = $xpath->query($xpathStr);       
        $prtElem = $prtElems->item(0);
        $prtElem->replaceChild($elem,$oldElem);
        
        // save xml file
        $doc->formatOutput = true;
        $doc->preserveWhiteSpace = false;
        $doc->save($this->m_XmlFile);
        return true;
    }    
    
    public function RemoveElement($elemPath, $nameVal)
    {
        $doc = $this->GetDocDocument();
        if (!$doc) return false;
        
        $pathItems = explode("/",$elemPath);
        $counts = count($pathItems);
        $elemType = $pathItems[$counts-1];
        
        $xpath = new DOMXPath($doc);
        $xpathStr = "/".$elemPath.'[@Name="'.$nameVal.'"]';
        $elems = $xpath->query($xpathStr);
        if (!$elems) return;
        $elem = $elems->item(0);
            
        // get the parent element
        $prtElem = $elem->parentNode;
        if (!$prtElem) return;
        $prtElem->removeChild($elem);
        
        // save xml file
        $doc->formatOutput = true;
        $doc->preserveWhiteSpace = false;
        $doc->save($this->m_XmlFile);
        return true;
    }
    
    public function SaveElement($elemPath, $recArr)
    {
        $doc = $this->GetDocDocument();
        if (!$doc) return false;
        
        $xpath = new DOMXPath($doc);
        $xpathStr = '/'.$elemPath.'[@Name="'.$recArr['Name'].'"]';
        $elems = $xpath->query($xpathStr);
        if (!$elems) return;
        $elem = $elems->item(0);
        
        // clean all attributes
        foreach ($elem->attributes as $attrName => $attrNode)
            $attrs[] = $attrName;
        foreach ($attrs as $attr)
            $elem->removeAttribute($attr);

        // set input attributes
        foreach ($recArr as $name => $value)
        {
            if (in_array($recArr, $attrs) || $value!="") {
        		$elem->setAttribute($name, $value);
            }
        }
        
        // save xml file
        $doc->formatOutput = true;
        $doc->save($this->m_XmlFile);
    }
}
?>