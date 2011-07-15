<?PHP
/**
 * PHPOpenBiz Framework
 *
 * LICENSE
 *
 * This source file is subject to the BSD license that is bundled
 * with this package in the file LICENSE.txt.
 *
 * @package   openbiz.bin.easy.element
 * @copyright Copyright &copy; 2005-2009, Rocky Swen
 * @license   http://www.opensource.org/licenses/bsd-license.php
 * @link      http://www.phpopenbiz.org/
 * @version   $Id: CheckListbox.php 2553 2010-11-21 08:36:48Z mr_a_ton $
 */

include_once(OPENBIZ_BIN."/easy/element/OptionElement.php");

/**
 * Listbox class is element that show ListBox with data from Selection.xml
 *
 * @package openbiz.bin.easy.element
 * @author Rocky Swen
 * @copyright Copyright (c) 2005-2009
 * @access public
 */
class CheckListboxTree extends OptionElement
{
    protected function readMetaData(&$xmlArr)
    {
        parent::readMetaData($xmlArr);
        $this->m_SelectFromTree = isset($xmlArr["ATTRIBUTES"]["SELECTFROMTREE"]) ? $xmlArr["ATTRIBUTES"]["SELECTFROMTREE"] : null;        
    }
    /**
     * Render, draw the control according to the mode
     *
     * @return string HTML text
     */
    public function render()
    {
        $fromListTree = array();
        $this->getFromListTree($fromListTree);
        $style = $this->getStyle();
        $func = $this->getFunction();
        $valueList = array(); $valueArray = array();
        $this->getFromList($valueList, $this->getSelectedList());
        foreach ($valueList as $vl) {
            $valueArray[] = $vl['val'];
        }
        $sHTML = "<script>
        				var ".$this->m_Name."_optlist = new Array(); 
        				var ".$this->m_Name."_optlist_default = new Array();
        			</script>";
        $sHTML .= "<div name=\"" . $this->m_Name . "\" ID=\"" . $this->m_Name ."\" $this->m_HTMLAttr $style>";
		$sHTML .= "<ul>";
		$i = 0;
        foreach ($fromListTree as $treeNode)
        {

            //$sHTML .= "<input type=\"checkbox\" name=\"".$this->m_Name."[]\" VALUE=\"" . $option['val'] . "\" $selectedStr></input>" . $option['txt'] . "<br/>";
            $sHTML .= "<li style=\"padding-top:10px;\">".str_repeat("-&nbsp;-&nbsp;", $treeNode["level"])."<strong>".$treeNode['txt']."</strong>"."</li>";
            $sublist = array();
            $this->getDOFromList($sublist, $this->getSelectFrom().",[folder_id]='".$treeNode['id']."'");
            foreach($sublist as $option){
                $test = array_search($option['val'], $valueArray);
	            if ($test === false)
	            {
	                $selectedStr = '';
	            }
	            else
	            {
	                $selectedStr = "CHECKED";
	                $sHTML .= "<script>".$this->m_Name."_optlist_default.push('".$this->m_Name."_".$i."'); </script>";
	            }            	
            	$sHTML .= "<li><label style=\"float:none;color:#888888;display:inline;\">".str_repeat("-&nbsp;-&nbsp;", $treeNode["level"])."<input type=\"checkbox\" id=\"".$this->m_Name."_".$i."\" name=\"".$this->m_Name."[]\" VALUE=\"" . $option['val'] . "\" $selectedStr></input>" . $option['txt'] . "</label></li>";
            	$sHTML .= "<script>".$this->m_Name."_optlist.push('".$this->m_Name."_".$i."'); </script>";
            	$i++;
            }
            
        }
        $sHTML .= "</ul></div>";
        return $sHTML;
    }
    

     protected function getDOFromListTree(&$list, $selectFrom)
    {
        // from Database
        $pos0 = strpos($selectFrom, "[");
        $pos1 = strpos($selectFrom, "]");

        if ($pos0 > 0 && $pos1 > $pos0)
        {  // select from bizObj
            // support BizObjName[BizFieldName] or BizObjName[BizFieldName4Text:BizFieldName4Value]
            $bizObjName = substr($selectFrom, 0, $pos0);
            $pos3 = strpos($selectFrom, ":");
            if($pos3 > $pos0 && $pos3 < $pos1)
            {
                $fieldName = substr($selectFrom, $pos0 + 1, $pos3 - $pos0 - 1);
                $fieldName_v = substr($selectFrom, $pos3 + 1, $pos1 - $pos3 - 1);
            }
            else
            {
                $fieldName = substr($selectFrom, $pos0 + 1, $pos1 - $pos0 - 1);
                $fieldName_v = $fieldName;
            }
            $this->m_SelectFieldName = $fieldName; 
            $commaPos = strpos($selectFrom, ",", $pos1);
            $commaPos2 = strpos($selectFrom, ",", $commaPos+1);
            
            if ($commaPos > $pos1)
            {
				if($commaPos2){
            		$searchRule = trim(substr($selectFrom, $commaPos + 1, ($commaPos2-$commaPos-1)));
				}
				else
				{
					$searchRule = trim(substr($selectFrom, $commaPos + 1));
				}
            }

            if ($commaPos2 > $commaPos)
                $rootSearchRule = trim(substr($selectFrom, $commaPos2 + 1));
                
            $bizObj = BizSystem::getObject($bizObjName);
            if (!$bizObj)
                return;

            $recList = array();

            $oldAssoc = $bizObj->m_Association;
            $bizObj->m_Association = null;

            if ($searchRule)
            {
                $searchRule = Expression::evaluateExpression($searchRule, $this->getFormObj());
            }
			
            if($rootSearchRule)
            {
            	$rootSearchRule = Expression::evaluateExpression($rootSearchRule, $this->getFormObj());            	
            }else{
            	$rootSearchRule = "[PId]=0 OR [PId]='' OR [PId] is NULL";
            }
            $recListTree = $bizObj->fetchTree($rootSearchRule,100,$searchRule);
            
            $bizObj->m_Association = $oldAssoc;
            if (!$recListTree) return; // bugfix : error if data blank

            foreach($recListTree as $recListTreeNode)
            {
                $this->tree2array($recListTreeNode, $recList);
            }
			
            foreach ($recList as $rec)
            {
                $list[$i]['val'] = $rec[$fieldName_v];
                $list[$i]['txt'] = $rec[$fieldName];
                $list[$i]['level'] = $rec["Level"];
                $list[$i]['id'] = $rec["Id"];
                $i++;
            }
            return;
        }
    }

    private function tree2array($tree,&$array,$level=0)
    {
        if(!is_array($array))
        {
            $array=array();
        }

        $treeNodeArray = array(
                "Level" => $level,
                "Id" => $tree->m_Id,
                "PId" => $tree->m_PId,
        );
        foreach ($tree->m_Record as $key=>$value)
        {
            $treeNodeArray[$key] = $value;
        }
        $treeNodeArray[$this->m_SelectFieldName] = $treeNodeArray[$this->m_SelectFieldName];

        array_push($array, $treeNodeArray);
        $level++;
        if(is_array($tree->m_ChildNodes))
        {
            foreach($tree->m_ChildNodes as $treeNode)
            {
                $this->tree2array($treeNode, $array, $level);
            }
        }
        return $array;
    }

    public function getFromListTree(&$list, $selectFromTree=null)
    {
        if (!$selectFromTree) {
            $selectFromTree = $this->getSelectFromTree();
        }
        $this->getDOFromListTree($list, $selectFromTree);
        if ($list != null)
            return;        
        return;
    }

    protected function getSelectFromTree()
    {
        $formobj = $this->getFormObj();
        return Expression::evaluateExpression($this->m_SelectFromTree, $formobj);
    }       
}

?>