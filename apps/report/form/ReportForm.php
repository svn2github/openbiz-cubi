<?php
class ReportForm extends EasyForm
{
	static protected $_no_init = false;
	
	function __construct(&$xmlArr)
	{
		parent::__construct($xmlArr);
		
		$this->init();		
	}
	
	protected function init()
	{
		if (self::$_no_init) return;
		
		$formDO = "report.do.ReportFormDO";
		
		// get the __form from request and set the report form from db
		$__form = $_REQUEST["__form"];
		if (!$__form || $__form == "")
			return;
		// fetch view form records
        $formDO = BizSystem::getObject($formDO,1);
        $formRecords = $formDO->directFetch("[Id]='$__form'");
        if (count($formRecords)==0)
        {
        	trigger_error("Cannot find the report form with name as $__form", E_USER_ERROR);
        }
        
        BizSystem::objectFactory()->setObject($this->m_Name, null);
        $this->setAttributes($formRecords[0]);
		BizSystem::objectFactory()->setObject($this->m_Name, $this);
		
		self::$_no_init = true;
	}
	
	public function setAttributes($formRecord)
	{
		$reportDO = "report.do.ReportDO";
		$doDO = "report.do.ReportDoDO";
        $elementDO = "report.do.ReportFormElementDO";
		
		$this->m_Id = $formRecord['Id'];
		if (empty($formRecord['name']))
			$formRecord['name'] = $formRecord['Id'];
		$this->m_Name .= '--'.$formRecord['Id'];
		$this->m_Title = $formRecord['title'];
		$this->m_Description = $formRecord['description'];
		$this->m_DataObjName = $formRecord['do_name'];
		$this->m_ViewName = $formRecord['view_name'];
		$this->m_Type = $formRecord['type'];
		$this->m_SubType = $formRecord['subtype'];
		$this->m_Width = $formRecord['width'];
		$this->m_Height = $formRecord['height'];
		$this->m_Attrs = $formRecord['attrs'];
	
		$attrArr = explode(";",$this->m_Attrs);
		foreach($attrArr as $value){
			$itemArr = explode("=",$value);
			$formRecord[$itemArr[0]]=$itemArr[1];
		}
		
		if($formRecord['TemplateFile'] && $this->m_Type=='table'){
			if($this->m_StaticOutput!=true){
				$this->m_TemplateFile = $formRecord['TemplateFile'];
			}
		}
		
		//added for support user defined page size
		if($formRecord['PageSize']){
			$this->m_Range = $formRecord['PageSize'];
		}else{
			$this->m_Range = 10;
		}

		if($formRecord['fix_searchrule']) $this->m_FixSearchRule = $formRecord['fix_searchrule'];
		if($formRecord['default_searchrule']) $this->m_SearchRule = $formRecord['default_searchrule'];

		// fetch the do record, then create dataobj
        $_doDO = BizSystem::getObject($doDO,1);
        $doRecord = $_doDO->fetchById($formRecord['do_id']);
        
        $this->m_DataObj = BizSystem::getObject($reportDO,1);
        $this->m_DataObj->setAttributes($doRecord);
	    BizSystem::objectFactory()->setObject($this->m_DataObj->m_Name, $this->m_DataObj);
        
        $this->m_DataObjName = $this->m_DataObj->m_Name;
        
        // fetch element records
	    $elemDO = BizSystem::getObject($elementDO,1);
        $elementRecords = $elemDO->directFetch("[form_id]=$this->m_Id");
	
        // create element objects.
        $this->initElementObjects($elementRecords);
        
		foreach ($this->m_Panels as $panel)
		{
			foreach ($panel as $elem) {
				$elem->adjustFormName($this->m_Name);
			}
		}
    }
    
    protected function initElementObjects($elementRecords)
    {
    	foreach ($elementRecords as $elemRec)
        {
			if (empty($elemRec['name']))
				$elemRec['name'] = $elemRec['Id'];
        	$_xmlArr["ATTRIBUTES"]["NAME"] = $elemRec['name'];
			$_xmlArr["ATTRIBUTES"]["CLASS"] = $elemRec['class'];
			$_xmlArr["ATTRIBUTES"]["LABEL"] = $elemRec['label'];
			$_xmlArr["ATTRIBUTES"]["FIELDNAME"] = $elemRec['field_name'];
			//$_xmlArr["ATTRIBUTES"]["ATTRS"] = $elemRec['attrs'];
			$_xmlArr["ATTRIBUTES"]["STYLE"] = $elemRec['attrs'];
			$_xmlArr["ATTRIBUTES"]["SELECTFROMSQL"] = $elemRec['select_from'];
			$_xmlArr["ATTRIBUTES"]["ALLOWURLPARAM"] = 'N';
        	if($this->m_StaticOutput!=true){
				$_xmlArr["ATTRIBUTES"]["SORTABLE"] = 'Y';
			}			
			$xmlArr[] = $_xmlArr;
        }
       
        $this->m_DataPanel = new Panel($xmlArr,"",$this);
        /*foreach ($this->m_DataPanel as $elem) {
        	echo "<pre>";print_r($elem);echo "</pre>";
        }*/
    }
}

?>