<?PHP
/**
 * PHPOpenBiz Framework
 *
 * LICENSE
 *
 * This source file is subject to the BSD license that is bundled
 * with this package in the file LICENSE.txt.
 *
 * @package   openbiz.bin.easy
 * @copyright Copyright &copy; 2005-2009, Rocky Swen
 * @license   http://www.opensource.org/licenses/bsd-license.php
 * @link      http://www.phpopenbiz.org/
 * @version   $Id$
 */

/**
 * FolderTree class - contains formtree object metadata functions
 *
 * @package openbiz.bin.easy
 * @author Rocky Swen
 * @copyright Copyright (c) 2005-2009
 * @since 1.2
 * @access public
 */
class ReportMapTree extends EasyForm
{
    // special metadata
    // root node search rule
    // depth

    public $m_RootSearchRule;
    public $m_Depth = 2;
    
    public $m_ReportDataObjName = "report.do.ReportViewDO";
    public $m_ReportDataObj;

    protected $m_RootNodes = null;
    protected $m_Selected = null;
    protected $m_RecordSet = array();
    

    /**
     * Read array meta data, and store to meta object
     *
     * @param array $xmlArr
     * @return void
     */
    protected function readMetadata(&$xmlArr)
    {
        parent::readMetaData($xmlArr);
        $this->m_RootSearchRule = isset($xmlArr["EASYFORM"]["ATTRIBUTES"]["ROOTSEARCHRULE"]) ? $xmlArr["EASYFORM"]["ATTRIBUTES"]["ROOTSEARCHRULE"] : null;
        $this->m_Depth = isset($xmlArr["EASYFORM"]["ATTRIBUTES"]["TREEDEPTH"]) ? $xmlArr["EASYFORM"]["ATTRIBUTES"]["TREEDEPTH"] : null;
    }

    /**
     * Get/Retrieve Session data of this object
     *
     * @param SessionContext $sessionContext
     * @return void
     */
    public function getSessionVars($sessionContext)
    {
        parent::getSessionVars($sessionContext);
        $sessionContext->getObjVar($this->m_Name, "Selected", $this->m_Selected);
    }

    /**
     * Save object variable to session context
     *
     * @param SessionContext $sessionContext
     * @return void
     */
    public function setSessionVars($sessCtxt) 
    {
        parent::setSessionVars($sessCtxt);
        $sessCtxt->setObjVar($this->m_Name, "Selected", $this->m_Selected);
    }

    /**
     * Select Record
     *
     * @param string $recId
     * @access remote
     */
    public function selectRecord($recId)
    {
        $this->m_Selected = $recId;
        return parent::selectRecord($recId);
    }
    
    /**
     * Output attributs
     *
     * @return void
     */
    public function outputAttrs()
    {
        $out['name'] = $this->m_Name;
        $out['title'] = $this->m_Title;
        $out['hasSubform'] = $this->m_SubForms ? 1 : 0;
        $out['depth'] = $this->m_Depth;
        $out['rootNodes'] = $this->m_RootNodes;
        $out['description'] = $this->m_Description;
        $rootNodeId = $this->m_RootNodes[0]->m_Id;
        $out['selected'] = ($this->m_Selected !== null) ? $this->m_Selected : $rootNodeId;
        return $out;
    }

    /**
     * Fetch DataSet, and store on active record
     * 
     * @return void
     */
    public function fetchDataSet()
    {
        // build the tree
        $this->_getRootNodes();

        // prepare the table like set
        //return $this->m_RecordSet;

        $this->getDataObj()->setActiveRecord($this->m_RecordSet[0]);

        return null;
    }

    /**
     * Show children nodes
     *
     * @return void
     * @access remote
     */
    public function showChildrenNodes()
    {
        $pid = BizSystem::clientProxy()->getFormInputs("id");
        $recordList = $this->getDataObj()->directFetch("[PId]='$pid'");
        //print_r($recordList);
        $outs = array();
        $i = 0;
        foreach ($recordList as $rec)
        {
            //$output .= "<li id='".$rec['Id']."' class='closed'><a href='#'>".$rec['Name']."</a></li>\n";
            // jstree 0.9.8 only support json asyn call.
            $outs[$i]['attributes']['id'] = $this->m_Name."_".$rec['Id'];
            $outs[$i]['attributes']['value'] = $rec['Id'];
            $outs[$i]['attributes']['rel'] = $rec['Name'];
            $outs[$i]['data'] = $rec['Name'];
            $outs[$i]['state'] = closed;
            $i++;
        }
   	    if (function_exists("json_encode"))
            echo json_encode($outs);
        else
        {
            require_once 'Zend/Json.php';
            echo Zend_Json::encode($outs); 
        }
    }

    /**
     * Get root nodes, store on internal variable
     *
     * @return <type>
     */
    private function _getRootNodes()
    {
        // query on given search rule
        $recordList = $this->getDataObj()->directFetch($this->m_RootSearchRule);
        if (!$recordList)
        {
            $this->m_RootNodes = array();
            return;
        }
        foreach ($recordList as $rec)
        {
            $this->m_RootNodes[] = new Node($rec, 'folder');
            $this->m_RecordSet[] = $rec;
        }

        if ($this->m_Depth <= 1)
            return;
            
                   
        foreach ($this->m_RootNodes as $node)
        {
        	if($node->m_Type=='folder'){
            	$this->_getChildrenNodes($node, 1);        		
        	}
        }
    }

    /**
     * List all children records of a given record
     *
     * @return void
     */
    private function _getChildrenNodes(&$node, $depth)
    {
        $pid = $node->m_Id;
        $recordList = $this->getDataObj()->directFetch("[PId]='$pid'");  
        foreach ($recordList as $rec)
        {
            $node->m_ChildNodes[] = new Node($rec);
            $this->m_RecordSet[] = $rec;
        }

        // reach leave node
        if ($node->m_ChildNodes == null)
            return;  

        $depth++;
        // reach given depth
        if ($depth >= $this->m_Depth)
            return;
        else
        {
            foreach ($node->m_ChildNodes as $node_c)
            {
            	if($node_c->m_Type=='folder'){
                	$this->_getChildrenNodes($node_c, $depth);
            	}
            }
        }
    }

    public function getReportDataObj()
    {
        if (!$this->m_ReportDataObj)
        {
            if ($this->m_ReportDataObjName)
                $this->m_ReportDataObj = BizSystem::objectFactory()->getObject($this->m_ReportDataObjName);
            if($this->m_ReportDataObj)
                $this->m_ReportDataObj->m_BizFormName = $this->m_Name;
            else
            {
                //BizSystem::clientProxy()->showErrorMessage("Cannot get DataObj of ".$this->m_DataObjName.", please check your metadata file.");
                return null;
            }
        }
        return $this->m_ReportDataObj;
    }    
    
}

/**
 * Node class, for tree structure
 *
 * @package openbiz.bin.easy
 * @author Rocky Swen
 * @copyright Copyright (c) 2005-2009
 * @since 1.2
 * @todo need to move to other package (tool, base, etc?)
 * @access public
 *
 */
class Node
{
    public $m_Id = "";
    public $m_PId = "";
    public $m_ChildNodes = null;
    public $m_Name = "";
    public $m_Type = "";
    public $m_Link = "";
    public $m_ObjectId = "";

    /**
     * Initialize Node
     *
     * @param array $rec
     * @return void
     */
    function __construct($rec, $type='report')
    {
    	$this->m_Id = $rec['Id'];
        $this->m_PId = $rec['PId'];
        $this->m_Name = $rec['name'];
        $this->m_Type = $type;
        $this->m_Link = $rec['link'];
    }
}

?>