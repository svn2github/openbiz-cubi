<?php 
class WorklogStatListForm extends EasyFormGrouping
{
	public function fetchDataGroup()
	{

		$this->getDataObj()->clearAllRules();
		$parentForm = BizSystem::getObject("collab.statistics.form.WorklogStatReportForm");			
		$day = sprintf('%02d',$parentForm->m_CategoryId+1);
		
		$parentForm = BizSystem::getObject("collab.statistics.form.UserWorkhourReportForm");	
		$workdate = $parentForm->m_Year.'-'.$parentForm->m_Month.'-'.$day;
		$user_id = $parentForm->m_RecordId;
		//$searchRule = $parentForm->m_SearchRule;
		if($day){
			$this->m_SearchRule="[work_date]='$workdate' AND [create_by]='$user_id'";
		}
		$result = parent::fetchDataGroup();		
		return $result;
	}
}
?>