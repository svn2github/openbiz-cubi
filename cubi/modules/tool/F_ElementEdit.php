<?php
class F_ElementEdit extends EasyForm 
{ 
    protected $m_MetaFile;
    protected $m_ElemPath;
    protected $m_AttrName;
    protected $m_XmlFile;
    protected $m_Doc;
        
    public function getSessionVars($sessCtxt) 
    {
        parent::getSessionVars($sessCtxt);
        
        if (!$_GET['metaName']) 
            $sessCtxt->getObjVar($this->m_Name, "MetaFile", $this->m_MetaFile);
        else {
        	$metaFile = MODULE_PATH."/".str_replace(".","/",$_GET['metaName']).".xml";
        	$this->m_MetaFile = $metaFile;
        }
        if (!$_GET['elemPath']) 
            $sessCtxt->getObjVar($this->m_Name, "ElemPath", $this->m_ElemPath);
        else
            $this->m_ElemPath = $this->adjustElemPath($_GET['elemPath']);
        //echo $_GET['elemPath'].','.$this->m_ElemPath; exit;
        if (!$_GET['attrName']) 
            $sessCtxt->getObjVar($this->m_Name, "AttrName", $this->m_AttrName);
        else
            $this->m_AttrName = $_GET['attrName'];
    }
    
    // replace [@abc] with [@Name='abc']
    private function adjustElemPath($path)
    {
        $list = explode('/',$path);
        foreach ($list as $elem) 
        {
            $pattern = "/([a-zA-Z_0-9]+)\[@([a-zA-Z_0-9\-]+)\]/i";
            $replace = "$1[@Name='$2']";
            $list2[] = preg_replace($pattern, $replace, $elem);
        }
        return implode('/',$list2);
    }
    
    public function setSessionVars($sessCtxt) 
    {
        parent::setSessionVars($sessCtxt);
        $sessCtxt->setObjVar($this->m_Name, "MetaFile", $this->m_MetaFile);
        $sessCtxt->setObjVar($this->m_Name, "ElemPath", $this->m_ElemPath);
        $sessCtxt->setObjVar($this->m_Name, "AttrName", $this->m_AttrName);
    }
    
    public function getCurrentElement()
    {
        $xpath = '/'.$this->m_ElemPath;
        $elem = $this->QueryXpath($xpath);
        return $elem;
    }
    
    public function GetMetaFileInfo()
    {
    	$pos = strrpos($this->m_MetaFile, "modules/");
        if ($pos > 0)
        {
            $modulesPath = substr($this->m_MetaFile, 0, $pos+8);
            $pos = strrpos($this->m_MetaFile, "/");
            $fileName = substr($this->m_MetaFile, $pos+1);
            $package = str_replace("/",".",str_replace(array($modulesPath, "/".$fileName),"",$this->m_MetaFile));
            return array('modules_path'=>$modulesPath, 'package'=>$package, 'fileName'=>$fileName);
        }
        return null;
    }
    
    public function QueryXpath($xpathStr, $returnSingle=true)
    {
        $doc = $this->GetDocDocument();
        if (!$doc) return false;
        
        $xpath = new DOMXPath($doc);
        $elems = $xpath->query($xpathStr);
        if ($returnSingle)
        {
            $elem = $elems->item(0);
            return $elem;
        }
        return $elems;
    }
    
    public function fetchData()
    {
        // if has valid active record, return it, otherwise do a query
	    if ($this->m_ActiveRecord != null)
	        return $this->m_ActiveRecord;

        // complete the pending action first
        $pendingAction = $_GET['pending_action'];
        list($action, $elemPath, $attrName, $prtAttrName) = explode(",",$pendingAction);
        
        $elemPath = $this->adjustElemPath($elemPath);
        
        if ($action == "CREATE")
            $this->AddElement($elemPath, $attrName, $prtAttrName);
        if ($action == "REMOVE")
            $this->RemoveElement($elemPath, $attrName);
        if (strpos($action, "MOVE") === 0)
        {
            list($action, $insertMode) = explode("_", $action);
            list($nameVal1, $nameVal2) = explode(":", $attrName);
            $this->MoveElement($elemPath, $nameVal1, $nameVal2, $insertMode);
        }
                    
        // get the xml element with xpath xpath('//element[@Name="fld_Id"]')
        //$this->m_XmlFile = MODULE_PATH."/".str_replace(".","/",$this->m_MetaName).".xml";
        $this->m_XmlFile = $this->m_MetaFile;
        if (!file_exists($this->m_XmlFile)) 
            return null;
        $rootElem = simplexml_load_file($this->m_XmlFile);
        //print_r($rootElem);
        $xpathStr = '/'.$this->m_ElemPath.'[@Name="'.$this->m_AttrName.'"]';   // TODO: fix it by full path
        $elems = $rootElem->xpath($xpathStr);
        if (!$elems || count($elems)==0)
            return null;
        // give warning if find >1 matching elements
        if (count($elems) > 1)
        {
            echo "<div class='error'>WARNING: More than 1 '$this->m_ElemPath' elements are found with Name as '".$this->m_AttrName."'. Please change these elements with unique names!</div>";
        }
        // get the attributes of the element
        $elem = $elems[0];
        $attrs = $elem->attributes();
        foreach ($attrs as $k=>$v)
            $attrList[$k] = $v."";
        //print_r($attrList);
        // return the array
        return $attrList;
    }
    
    public function saveRecord()
    {
    	try
        {
            $this->ValidateForm();
        }
        catch (ValidationException $e)
        {
        	$this->processFormObjError($e->m_Errors);
            return;
        }
        $recArr = $this->readInputRecord();

        if (count($recArr) == 0)
            return;
        
        if (!$this->saveElement($recArr))
            return;
        
        //BizSystem::clientProxy()->showClientAlert ("Changes of ".$this->m_MetaName." are saved");
        BizSystem::clientProxy()->updateClientElement("html_msg", "Changes of ".$this->m_ElemPath.": ".$this->m_AttrName." are saved");
    }
    
    protected function GetDocDocument()
    {
        if ($this->m_Doc) 
            return $this->m_Doc;
        //$this->m_XmlFile = MODULE_PATH."/".str_replace(".","/",$this->m_MetaName).".xml";
        $this->m_XmlFile = $this->m_MetaFile;
        
        if (!file_exists($this->m_XmlFile)) 
            return null;
        $doc = new DomDocument();
        $ok = $doc->load($this->m_XmlFile);
        if (!$ok)
            return null;
        $this->m_Doc = $doc;
        //$rootElem = $doc->documentElement;
        return $doc;
    }
    
    protected function AddElement($elemPath, $nameVal, $prtAttrName)
    {
        $doc = $this->GetDocDocument();
        if (!$doc) return false;
        $pathItems = explode("/",$elemPath);
        $counts = count($pathItems);
        $elemType = $pathItems[$counts-1];
        $pos=strpos($elemType,'[');
        if ($pos>0) $elemType = substr($elemType, 0, $pos);

        $elem = $doc->createElement($elemType);
        $elem->setAttribute('Name', $nameVal);
        
        // get the parent element
        $xpath = new DOMXPath($doc);
        $pos = strrpos($elemPath, "/$elemType");
        $xpathStr = "/".substr($elemPath, 0, $pos);
        if ($prtAttrName && $prtAttrName!="")
            $xpathStr .= "[@Name='".$prtAttrName."']";
        $prtElems = $xpath->query($xpathStr);
        $prtElem = $prtElems->item(0);
        $prtElem->appendChild($elem);
        
        // save xml file
        $doc->formatOutput = true;
        $doc->save($this->m_XmlFile);
        return true;
    }
    
    protected function RemoveElement($elemPath, $nameVal)
    {
        $doc = $this->GetDocDocument();
        if (!$doc) return false;
        
        $pathItems = explode("/",$elemPath);
        $counts = count($pathItems);
        $elemType = $pathItems[$counts-1];
        
        $xpath = new DOMXPath($doc);
        $xpathStr = "/".$elemPath.'[@Name="'.$nameVal.'"]';
        
        $elems = $xpath->query($xpathStr);
        $elem = $elems->item(0);
            
        // get the parent element
        $prtElem = $elem->parentNode;
        $prtElem->removeChild($elem);
        
        // save xml file
        $doc->formatOutput = true;
        $doc->save($this->m_XmlFile);
        return true;
    }
    
    protected function MoveElement($elemPath, $nameVal1, $nameVal2, $insertMode)
    {
        $doc = $this->GetDocDocument();
        if (!$doc) return false;
        
        $pos0=strrpos($elemPath,'[');
        $pos1=strrpos($elemPath,']');
        if ($pos1 == strlen($elemPath)-1) $elemPath = substr($elemPath, 0, $pos0);
        
        //echo "$elemPath, $nameVal1, $nameVal2, $insertMode";
        
        $xpath = new DOMXPath($doc);
        $xpathStr = "/".$elemPath.'[@Name="'.$nameVal1.'"]'; 
        $elems = $xpath->query($xpathStr);
        $elem = $elems->item(0);
        
        $xpathStr = "/".$elemPath.'[@Name="'.$nameVal2.'"]';
        $elems = $xpath->query($xpathStr);
        $elemRef = $elems->item(0);
        
        if($insertMode == "before") 
        {
            $elemRef->parentNode->insertBefore($elem, $elemRef);
        } 
        else if($insertMode == "after") 
        {   
            if($elemRef->nextSibling) 
                $elemRef->parentNode->insertBefore($elem, $elemRef->nextSibling);
            else 
                $elemRef->parentNode->appendChild($elem);
        }
        
        // save xml file
        $doc->formatOutput = true;
        $doc->save($this->m_XmlFile);
        return true;
    }
    
    protected function saveElement($recArr)
    {
        $doc = $this->GetDocDocument();
        if (!$doc) { 
        	echo "Cannot get xml doc. Please reload the page in your browser";
        	return false; 
        }
        
        $xpath = new DOMXPath($doc);
        $xpathStr = '/'.$this->m_ElemPath.'[@Name="'.$this->m_AttrName.'"]';
        $elems = $xpath->query($xpathStr);
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
        
        // if name is changed, refresh the left tree node name
        if ($recArr['Name'] != $this->m_AttrName)
        {
            $script = "<script>";
            $script .= "window.parent.changeElementName('".$this->m_AttrName."','".$recArr['Name']."');";
            $script .= "</script>";
            BizSystem::clientProxy()->runClientScript($script);
        }
        
        return true;
    }
}
?>