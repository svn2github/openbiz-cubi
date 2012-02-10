<?php
include_once (OPENBIZ_BIN."/easy/element/Listbox.php");
class DataStatusList extends Listbox
{
 protected function getXMLFromList(&$list, $selectFrom)
    {
        $pos0 = strpos($selectFrom, "(");
        $pos1 = strpos($selectFrom, ")");
        if ($pos0>0 && $pos1 > $pos0)
        {  // select from xml file
            $xmlFile = substr($selectFrom, 0, $pos0);
            $tag = substr($selectFrom, $pos0 + 1, $pos1 - $pos0-1);
            $tag = strtoupper($tag);
            $xmlFile = BizSystem::GetXmlFileWithPath ($xmlFile);
            if (!$xmlFile) return false;

            $xmlArr = &BizSystem::getXmlArray($xmlFile);
            if ($xmlArr)
            {
                $i = 0;
                if (!key_exists($tag, $xmlArr["SELECTION"]))
                    return false;
                if(!$xmlArr["SELECTION"][$tag][0]){
                	$array = $xmlArr["SELECTION"][$tag];
                	unset($xmlArr["SELECTION"][$tag]);
                	$xmlArr["SELECTION"][$tag][0]=$array;
                }
                foreach($xmlArr["SELECTION"][$tag] as $node)
                {
                    $list[$i]['val'] = $node["ATTRIBUTES"]["VALUE"];
                    $list[$i]['pic'] = $node["ATTRIBUTES"]["PICTURE"];
                    if ($node["ATTRIBUTES"]["TEXT"])
                    {
                        $list[$i]['txt'] = $node["ATTRIBUTES"]["TEXT"];                        
                    }
                    else
                    {
                        $list[$i]['txt'] = $list[$i]['val'];
                    }
                    $i++;
                    
                }
                $this->translateList($list, $tag);	// supprot multi-language
            }
            unset($list[0]);
            return true;
        }
        return false;
    }

}
?>