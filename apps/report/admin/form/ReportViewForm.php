<?php 
class ReportViewForm extends EasyForm
{
	private $m_ReportElementDO = "report.admin.do.ReportFormElementDO";
	private $m_ReportDoFieldDO = "report.admin.do.ReportDoFieldDO";
	private $m_ReportDoDO = "report.admin.do.ReportDoDO";
	private $m_ReportDbDO = "report.admin.do.ReportDbDO";
	private $m_ReportFormDO = "report.admin.do.ReportFormDO";
		
	public function insertRecord(){		
		$result = parent::insertRecord();
		$rec = $this->getActiveRecord();
		if(is_array($rec)){	
			$this->LoadForms($rec['Id']);
		}
		return $result;
	}   

	public function LoadForms($recId){
		$rec	= $this->getActiveRecord($recId);	
		$id		= $rec['Id'];
		$db_id	= $rec['db_id'];
		$do_id	= $rec['do_id'];
		$view_id= $rec['Id'];
		
		$formobj= BizSystem::GetObject($this->m_ReportFormDO,1);
		$fieldobj= BizSystem::GetObject($this->m_ReportDoFieldDO,1);
		
		//create report chart form
		$chartFormType = "Chart";
		$sortorder_t = 10;
		if(!$this->_checkDupForm($do_id,$id,$chartFormType)){
			//determinte subtype of form
			$fieldRecs = $fieldobj->directFetch("[do_id]='$do_id'");
			
			if(count($fieldRecs)<=3)
			{
				$chartSubFormType="Column3D";
			}
			elseif(count($fieldRecs)<=5 )
			{
				$chartSubFormType="MSColumn3D";
			}
			$form_array = array(
							"title" => $rec["title"]." Chart",
							"form_id"=>$id,
	        				"do_id"=>$do_id,
							"view_id"=>$view_id,
	        				"type"=>$chartFormType,
							"subtype"=>$chartSubFormType,
							"width"=>"700",
							"height"=>"300",
		    				"sortorder"=>$sortorder_t,
			);
			if(count($fieldRecs)<6){				
				$formobj->insertRecord($form_array);
				$formRec = $formobj->getActiveRecord();
				$this->LoadElement($formRec);
			}
		}
		
		//create report table form
		$chartFormType = "table";
		$sortorder_t += 10;
		if(!$this->_checkDupForm($do_id,$id,$chartFormType)){
			$form_array = array(
							"title" => $rec["title"]." Table",
							"form_id"=>$id,
	        				"do_id"=>$do_id,
							"view_id"=>$view_id,
	        				"type"=>$chartFormType,
							"subtype"=>"",
							"width"=>"700",
							"height"=>"300",
		    				"sortorder"=>$sortorder_t,
                            "attrs"=>"TemplateFile=report_table_default.tpl.html;PageSize=10;"
			);
			$formobj->insertRecord($form_array);
			$formRec = $formobj->getActiveRecord();
			$this->LoadElement($formRec);
		}
		
		$this->rerenderSubForms();
	}
	
	public function LoadElement($rec=null){
		if(!$rec){
			$rec	= $this->getActiveRecord();
		}		
    	$id		= $rec['Id'];
    	$do_id	= $rec['do_id'];
    	$form_type = $rec['type'];
    	
    	$dataobj =  BizSystem::GetObject($this->m_ReportDoFieldDO,1);	
    	$elemobj =  BizSystem::GetObject($this->m_ReportElementDO,1);
    	$dataobj->clearSearchRule();
    	$dataobj->setSearchRule("[do_id]='$do_id' ");    	
    	$dataobj->setSortRule("[column]='id' DESC,[type]='Number' ASC,[type]='Text' ASC");
    	$records = $dataobj->Fetch();
    	$sortorder = 10;
    	$data_colum_count =0;
    	foreach($records as $record){   
	    	if(!$this->_checkDupElement($record['Id'],$id)){			 		
		    	$elem_array =array(
	        				"form_id"=>$id,
	        				"field_id"=>$record['Id'],
	        				"label"=>ucwords(str_replace("_"," ",$record['name'])),
		    				"sortorder"=>$sortorder,
	        				);
	    		switch($form_type){
		    		case "chart":
		    			
		    			if($record['name']=='Id'){
		    				break;
		    			}
		    			if($sortorder==10){
		    				$elem_array["class"]="report.lib.ChartCategory";
		    			}else{
		    				$elem_array["class"]="report.lib.ChartData";
		    				$data_colum_count ++;
		    			}
		    			if(substr(strtoupper($rec['subtype']),0,2)=="MS"){
			    			$elemobj->insertRecord($elem_array);
		    			}else{
		    				if($data_colum_count<2){
		    					$elemobj->insertRecord($elem_array);
		    				}
		    			}
		    			$sortorder+=10;
		    			break;
		    		case "table":
	    				if($record['name']=='Id'){
		    				break;
		    			}
		    			$elem_array["class"]="ColumnText";
		    			$elemobj->insertRecord($elem_array);
		    			$sortorder+=10;
		    			break;
		    	}	        				
		    	
	    	} 	    	   		
    	}
    	
		$this->selectRecord($id);
	}	
	
    protected function _checkDupElement($field_id,$form_id)
    {        
        // query UserDO by the username
        $dataobj =  BizSystem::GetObject($this->m_ReportElementDO,1);	
        $records = $dataobj->directFetch("[field_id]='$field_id' AND [form_id]='$form_id'",1);
        if (count($records)>=1)
            return true;
        return false;
    }	

    protected function _checkDupForm($do_id,$view_id,$from_type)
    {        
        $dataobj =  BizSystem::GetObject($this->m_ReportFormDO,1);	
        $records = $dataobj->directFetch("[do_id]='$do_id' AND [view_id]='$view_id' AND [type]='$from_type'",1);
        if (count($records)>=1)
            return true;
        return false;
    }	    
	public function LoadForm(){
		$rec	= $this->getActiveRecord();		
    	$id		= $rec['Id'];
    	$do_id	= $rec['do_id'];
    	$form_type = $rec['type'];
		$this->selectRecord($id);
	}
	
}
?>
