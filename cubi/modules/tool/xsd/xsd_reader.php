<?php

$elementXsdFile = "Listbox.xsd";

readElement($elementXsdFile);

function readElement($elementXsdFile)
{
    if (!file_exists($elementXsdFile)) 
        return null;
    $rootElem = simplexml_load_file($elementXsdFile);
    /*$doc = new DomDocument();
    $ok = $doc->load($elementXsdFile);
    if (!$ok)
        return null;
    $this->m_Doc = $doc;
    $rootElem = $doc->documentElement;*/
    print_r($rootElem);
}

?>