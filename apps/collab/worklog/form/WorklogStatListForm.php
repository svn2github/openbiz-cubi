<?php 
require_once MODULE_PATH.'/collab/statistics/form/StatisticsListForm.php';
class WorklogStatListForm extends StatisticsListForm
{
	public function fetchDataSet()
	{
		
		$parentForm = BizSystem::getObject("collab.worklog.form.WorklogStatReportForm");			
		$cond = $parentForm->m_CategoryId;
		$pri  =	abs(2-($parentForm->m_RecordId));
		$searchRule = $parentForm->m_SearchRule;
		if($cond!==null && $pri!==null){
			$this->m_SearchRule="[condition]='$cond' AND [priority]='$pri'";
		}

		if($searchRule){
			$searchRule = str_replace("[chart_type]  = :_v1", "", $searchRule);		
			$this->m_SearchRule = $searchRule.$this->m_SearchRule;
		}
		
		$result = parent::fetchDataSet();		
		return $result;
	}
}
?>