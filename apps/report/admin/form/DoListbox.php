<?php 
include_once (OPENBIZ_BIN."/easy/element/Listbox.php");
class DoListbox extends Listbox{
	
	public function render(){
		$formobj = $this->getFormObj();
        $this->m_SelectFrom = Expression::evaluateExpression($this->m_SelectFrom, $formobj);
		if($this->m_SelectFrom){
			$book_id =  (int)$this->m_SelectFrom;
			$dataObj =  BizSystem::GetObject("report.admin.do.ReportBookDO");
   			$records =  $dataObj->directFetch("[Id]='$book_id'",1);
			$db_id = $records[0]['db_id'];
			$this->m_SelectFrom = "report.admin.do.ReportDoDO[name:Id],[db_id]='$db_id'";
		}else{
			$this->m_SelectFrom = "report.admin.do.ReportDoDO[name:Id],[db_id]='{@report.admin.do.ReportBookDO:Field[db_id].Value}'";			
			$this->m_SelectFrom = Expression::evaluateExpression($this->m_SelectFrom, $formobj);
		}    	
		return parent::render();
	}

}
?>