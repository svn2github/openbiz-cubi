<?PHP
/**
 * PHPOpenBiz Framework
 *
 * LICENSE
 *
 * This source file is subject to the BSD license that is bundled
 * with this package in the file LICENSE.txt.
 *
 * @package   openbiz.bin.data
 * @copyright Copyright (c) 2005-2011, Rocky Swen
 * @license   http://www.opensource.org/licenses/bsd-license.php
 * @link      http://www.phpopenbiz.org/
 * @version   $Id$
 */

include_once(OPENBIZ_BIN.'data/BizDataObj.php');
include_once('MenuRecord.php');

/**
 * BizDataTree class provide query for tree structured records
 *
 * @package openbiz.bin.data
 * @author Rocky Swen
 * @copyright Copyright (c) 2005-2009
 * @access public
 */
class MenuTreeDO extends BizDataObj
{
	protected $rootNodes;
	protected $depth;
	static protected $m_BreadCrumb = null; 

	public function fetchTree($rootSearchRule, $depth)
	{				
		$this->fetchTreeBySearchRule($rootSearchRule, $depth);
	}
	
	public function fetchTreeByName($menuName, $depth)
	{
		return $this->fetchTreeBySearchRule("[name]='$menuName'", $depth);
	}
	
	/**
     * Fetch records in tree structure
     *
     * @return <type>
     */
	public function fetchTreeBySearchRule($rootSearchRule, $depth, $globalSearchRule=null )
	{
		$url = $_SERVER['REQUEST_URI'];
		$this->depth = $depth;
		// query on given search rule
		if($globalSearchRule){
			$searchRule = $rootSearchRule." AND ".$globalSearchRule;
		}else{
			$searchRule = $rootSearchRule;
		}
        $recordList = $this->directFetch($searchRule);
        if (!$recordList)
        {
            $this->rootNodes = array();
            return;
        }
        $i = 0;
        foreach ($recordList as $rec)
        {
            $menuRec = new MenuRecord($rec);
            if ($menuRec->allowAccess()) {  // check access with role
                $this->rootNodes[$i] = $menuRec;
                if ($this->rootNodes[$i]->m_URL == $url)
                    $this->rootNodes[$i]->m_Current = 1;
                $i++;
            }
        }
        if ($this->depth <= 1)
            return $this->rootNodes;
        if (!$this->rootNodes) return array();
        foreach ($this->rootNodes as $node)
        {
            $this->_getChildrenNodes($node, 1, $globalSearchRule);
        }
        //print_r($this->rootNodes);
        return $this->rootNodes;
    }

    public function fetchNodePath($nodeSearchRule, &$pathArray)
    {
    	$recordList = $this->directFetch($nodeSearchRule);
    	if(count($recordList)>=1){
    		
    		if($recordList[0]['PId']!='' && $recordList[0]['PId']!='0'){
    			$searchRule = "[Id]='".$recordList[0]['PId']."'";
    			$this->fetchNodePath($searchRule, $pathArray);
    		}
    		$node = new MenuRecord($recordList[0]);
    		array_push ($pathArray,$node);
    		return $pathArray;
    	}
    }
    
	public function getBreadCrumb()
	{
    	if (self::$m_BreadCrumb != null)
    		return self::$m_BreadCrumb;
    	
    	self::$m_BreadCrumb = array();
		$uri = $_SERVER['REQUEST_URI'];
		if (empty($uri))
			return array();
    	$matchUri = $this->_getMatchUri($uri);
    	$uri = str_replace("//","/",str_replace(APP_INDEX,'',$uri));
    	
    	$pathArray = array();
    	//global $g_BizSystem;
    	//$currentView = $g_BizSystem->getCurrentViewName();
		//$this->fetchNodePath("[link]='$uri' OR [view]='$currentView'", $pathArray);

    	// first find the exact uri match
    	$this->fetchNodePath("[link]='$uri'", $pathArray);
    	if (count($pathArray)>0) {
    		self::$m_BreadCrumb = $pathArray;
    		return $pathArray;
    	}

    	// then find partial match uri
		$this->fetchNodePath("[url_match] LIKE '%$matchUri%'", $pathArray);	
		if (count($pathArray)>0) {	
			self::$m_BreadCrumb = $pathArray;
			return $pathArray;
		}
    	
    	// then find partial match uri
		$this->fetchNodePath("[link] LIKE '%$matchUri%'", $pathArray);		
		self::$m_BreadCrumb = $pathArray;
		return $pathArray;
    }
    
    private function _getMatchUri($uri)
    {
    	$matchUri = str_replace(APP_INDEX,'',$uri);
    	// only count first 2 parts
    	$_matchUris = explode('/',$matchUri);
    	if (count($_matchUris)>=2) {
    		if ($_matchUris[0]=='')
    			if (count($_matchUris)>=3)
    				$matchUri = '/'.$_matchUris[1].'/'.$_matchUris[2];
    		else
    			$matchUri = $_matchUris[0].'/'.$_matchUris[1];
    	}
    	return $matchUri;
    }
    
    /**
     * List all children records of a given record
     *
     * @return void
     */
    private function _getChildrenNodes(&$node, $depth, $globalSearchRule=null)
    {
        $url = $_SERVER['REQUEST_URI'];
    	$pid = $node->m_Id;
        //echo "<br>in _getChildrenNodes";
        if($globalSearchRule){
        	$searchRule = "[PId]='$pid' AND $globalSearchRule";
        }else{
    		$searchRule = "[PId]='$pid'";
        }
        $recordList = $this->directFetch($searchRule);
        $i = 0;
        foreach ($recordList as $rec)
        {
            // TODO: check access with role
            $menuRec = new MenuRecord($rec);
            if ($menuRec->allowAccess()) {
                $node->m_ChildNodes[$i] = $menuRec;
                $i++;
            }
        }
        //print_r($node->m_ChildNodes);
        // reach leave node
        if ($node->m_ChildNodes == null) {
            return;
        }
        $depth++;
        // reach given depth
        if ($depth >= $this->depth)
            return;
        else
        {
            foreach ($node->m_ChildNodes as $node_c)
            {
                $this->_getChildrenNodes($node_c, $depth, $globalSearchRule);
            }
        }
    }
}

?>